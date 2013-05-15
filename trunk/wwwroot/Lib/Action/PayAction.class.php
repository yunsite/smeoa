<?php
class PayAction extends CommonAction {
	private $doc_folder;

	//过滤查询字段
	function _filter(&$map){
		$map['is_del'] = array('eq', '0');
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
		if (!empty($_POST['supplier'])){
			$this -> _set_search("supplier", $_POST['supplier']);
			$map['supplier'] = array('eq',$_POST['supplier']);
		}
		if (!empty($_POST['mat_no'])){
			$this -> _set_search("mat_no", $_POST['mat_no']);
			$map['mat_no'] = array('eq',$_POST['mat_no']);
		}
		if (!empty($_POST['po_no'])){
			$this -> _set_search("po_no", $_POST['po_no']);
			$map['po_no'] = array('eq',$_POST['po_no']);
		}
		if (!empty($_POST['user_id'])){
			$this -> _set_search("user_id", $_POST['user_id']);
			$map['user_id'] = array('eq',$_POST['user_id']);
		}
		if (!empty($_POST['remark'])){
			$this -> _set_search("remark", $_POST['remark']);
			$map['remark|item_remark'] = array('like', "%" . $_POST['remark'] . "%");
		}
	}
	public function index() {
		$user_id = get_user_id();
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("PayView");
		if (empty($_POST['start_date']) & empty($_POST['end_date'])){
			$start_date=toDate(mktime(0,0,0,date("m"),1,date("Y")),'Y-m-d');	
			$end_date=toDate(mktime(0,0,0,date("m")+1,0,date("Y")),'Y-m-d');	
			$this -> _set_search("start_date",$start_date);
			$this -> _set_search("end_date",$end_date);
			$map['create_time'] = array( array('gt', date_to_int($start_date)), array('lt', date_to_int($end_date)));
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
		return;
	}

	function pay(){
		$id=$_REQUEST['id'];		
		if(!empty($id)){
			$model=M("Pay");
			$where['id']=array("eq",$id);	
			$model->where($where)->setField("paid",1);
			$result=$model->where($where)->setField("paid_time",time());
		}
		if($result){
			$this->success('成功');
		}else{
			$this->error('失败');
		}
	}


	function insert() {	

		$arr_mat_no=$_POST['mat_no'];
		$arr_qty=$_POST['qty'];
		$arr_price=$_POST['price'];
		$arr_sum=$_POST['sum'];
		$arr_remark=$_POST['remark'];
		$type=$_POST['type'];
		$payment=$_POST['payment'];
		$prepay=$_POST['prepay'];
		$total=array_sum($arr_sum);

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
		$po_no=$po_model->po_no;
		$po_model->total=$total;
		$po_result = $po_model -> add();

		if($type==2){

			$gi_model=D("Gi");
			if (false === $gi_model -> create()) {
				$this -> error($gi_model -> getError());
			}
			if (in_array('user_id', $gi_model -> getDbFields())) {
				$gi_model -> user_id = get_user_id();
			};
			if (in_array('user_name', $gi_model -> getDbFields())) {
				$gi_model -> user_name = $this -> _session("user_name");
			};
			$gi_no=$gi_model->gi_no;
			$gi_model->po_no=$po_no;
			$gi_model->gi_date=$_POST['po_date'];
			$gi_result=$gi_model -> add();
		}

		$po_item_model=M("PoItem");
		$gi_item_model=M("GiItem");

		foreach ($arr_mat_no as $key => $value) {
			$data['mat_no']=$arr_mat_no[$key];
			$data['qty']=$arr_qty[$key];
			$data['price']=$arr_price[$key];
			$data['sum']=$arr_sum[$key];
			$data['remark']=$arr_remark[$key];
			$data['po_no']=$po_no;
			$po_item_result=$po_item_model->add($data);	
			if($type==2){
				$data['order_qty']=$arr_qty[$key];
				$data['in_qty']=$arr_qty[$key];
				$data['gi_no']=$gi_no;
				$gi_item_result=$gi_item_model->add($data);
			}
		}
		switch ($payment){
			case '1':
				if($type==1){
					$pay_data['prepay']=$total;
					$pay_data['po_no']=$po_no;
					$pay_data['supplier']=$_POST['supplier'];
				}
				break;
			case '2':
				if($type==1){
					$pay_data['prepay']=$prepay;
					$pay_data['po_no']=$po_no;
					$pay_data['supplier']=$_POST['supplier'];
				}
				break;
			case '3':
				if($type==2){
					$pay_data['payable']=$total;
					$pay_data['gi_no']=$gi_no;
					$pay_data['supplier']=$_POST['supplier'];
				}
				break;								
		}
		if(is_array($pay_data)){
			M("Pay")->add($pay_data);
		}
		if ($po_result !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}	

	public function _before_read() {
		$id = $_REQUEST['id'];
		$user_id = get_user_id();
		$model = M("Po");
		$folder_id = $model -> where("id=$id") -> getField('folder');
		$this -> assign("auth", $auth = D("Folder") -> _get_folder_auth($folder_id));
	}

	public function mark() {
		$action = $_REQUEST['action'];
		$id = $_REQUEST['doc_id'];
		if(!empty($id)){
			switch ($action) {
				case 'del' :
					$where['id'] = array('in', $id);
					$folder = M("Po") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("Folder") -> _get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'is_del';
							$this -> set_field($id, $field,1);
						}
						$this -> ajaxReturn('', "删除成功", 1);
					} else {
						$this -> ajaxReturn('', "删除失败", 1);
					}
					break;
				case 'move_folder' :
					$target_folder = $_REQUEST['val'];

					$where['id'] = array('in', $id);
					$folder = M("Po") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("Folder") -> _get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'folder';
							$this -> set_field($id, $field, $target_folder);
						}
						$this -> ajaxReturn('', "操作成功", 1);
					} else {
						$this -> ajaxReturn('', "操作失败", 1);
					}
					break;
				default :
					break;
			}
		}
	}

	public function upload() {
		R('File/upload');
	}

	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}
}
