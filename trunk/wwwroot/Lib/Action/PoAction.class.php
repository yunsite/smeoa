<?php
class PoAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['is_del'] = array('eq', '0');
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$map['supplier_name|remark|item_remark|material_name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
		if (!empty($_POST['mat_no'])) {
			$this -> _set_search("mat_no", $_POST['mat_no']);
			$map['mat_no'] = array('eq', $_POST['mat_no']);
		}
		if (!empty($_POST['remark'])) {
			$this -> _set_search("remark", $_POST['remark']);
			$map['remark|item_remark'] = array('like', "%" . $_POST['remark'] . "%");
		}
	}

	public function index(){
		$map = $this -> _search("PoView",true);
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		if (empty($_POST['start_date']) & empty($_POST['end_date'])) {
			$start_date = toDate(mktime(0, 0, 0, date("m"), 1, date("Y")), 'Y-m-d');
			$end_date = toDate(mktime(0, 0, 0, date("m") + 1, 0, date("Y")), 'Y-m-d');
			$map['po_date'] = array( array('egt', $start_date), array('elt', $end_date));
		} else {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
		}
		$this -> assign('start_date', $start_date);
		$this -> assign('end_date', $end_date);
	
		$sql = D("PoView") -> buildSql();
		$model = new Model();
		$list = $model -> table($sql . "a") -> where($map) -> order('supplier,po_no') -> select();
		$this -> assign("list", $list);
		$this -> display();
		return;
	}

	function insert() {
		$arr_mat_no = $_POST['mat_no'];
		$arr_qty = $_POST['qty'];
		$arr_price = $_POST['price'];
		$arr_sum = $_POST['sum'];
		$arr_remark = $_POST['remark'];

		$type = $_POST['type'];
		$payment = $_POST['payment'];
		$prepay = $_POST['prepay'];

		$total = array_sum($arr_sum);

		$po_model = D("Po");
		if (false === $po_model -> create()) {
			$this -> error($po_model -> getError());
		}
		if (in_array('user_id', $po_model -> getDbFields())) {
			$po_model -> user_id = get_user_id();
		};
		if (in_array('user_name', $po_model -> getDbFields())) {
			$po_model -> user_name = $this -> _session("user_name");
		};
		//保存当前数据对象
		$po_model -> total = $total;
		if ($type == 2) {
			$po_model -> finish = 1;
		}
		$po_no = $po_model -> po_no;
		$po_result = $po_model -> add();

		//订单类型直接入库
		if ($type == 2) {
			$gi_model = D("Gi");
			if (false === $gi_model -> create()) {
				$this -> error($gi_model -> getError());
			}
			if (in_array('user_id', $gi_model -> getDbFields())) {
				$gi_model -> user_id = get_user_id();
			};
			if (in_array('user_name', $gi_model -> getDbFields())) {
				$gi_model -> user_name = $this -> _session("user_name");
			};

			$gi_model -> po_no = $po_no;
			$gi_model -> gi_date = $_POST['po_date'];
			$gi_no = $gi_model -> gi_no;
			$gi_result = $gi_model -> add();
		}

		$po_item_model = M("PoItem");
		$gi_item_model = M("GiItem");

		foreach ($arr_mat_no as $key => $value) {
			$data['mat_no'] = $arr_mat_no[$key];
			$data['qty'] = $arr_qty[$key];
			$data['price'] = $arr_price[$key];
			$data['sum'] = $arr_sum[$key];
			$data['remark'] = $arr_remark[$key];
			$data['po_no'] = $po_no;
			$po_item_result = $po_item_model -> add($data);
			if ($type == 2) {
				$data['order_qty'] = $arr_qty[$key];
				$data['in_qty'] = $arr_qty[$key];
				$data['gi_no'] = $gi_no;
				$gi_item_result = $gi_item_model -> add($data);
			}
		}
		//付款方式
		switch ($payment) {
			//预付货款
			case '1' :
				if ($type == 1) {
					$pay_data['prepay'] = $total;
					$pay_data['po_no'] = $po_no;
					$pay_data['supplier'] = $_POST['supplier'];
				}
				break;
			//预付部分
			case '2' :
				if ($type == 1) {
					$pay_data['prepay'] = $prepay;
					$pay_data['po_no'] = $po_no;
					$pay_data['supplier'] = $_POST['supplier'];
				}
				break;
			//货到付款
			case '3' :
				if ($type == 2) {
					$pay_data['payable'] = $total;
					$pay_data['gi_no'] = $gi_no;
					$pay_data['supplier'] = $_POST['supplier'];
				}
				break;
		}

		if (is_array($pay_data)) {
			$pay_model = M("Pay");
			$pay_data['create_time'] = time();
			$pay_model -> add($pay_data);
		}
		if ($po_result !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function json() {
		header("Content-Type:text/html; charset=utf-8");
		$keyword = $_REQUEST['keyword'];
		$model = M("Po");
		$map['po_no'] = array('like', "%" . $keyword . "%");
		$map['is_del'] = 0;
		$map['finish'] = 0;
		$list = $model -> where($map) -> field('id,po_no as name') -> select();
		//dump($model);
		exit(json_encode($list));
	}

	public function upload() {
		R('File/upload');
	}

	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}

}
