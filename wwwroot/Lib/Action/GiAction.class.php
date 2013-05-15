<?php
class GiAction extends CommonAction {
	private $doc_folder;
	public function _initialize(){
		parent::_initialize();
		$model = D('Folder');
		$this -> doc_folder = $model -> getField('id,name');
	}

	//过滤查询字段
	function _filter(&$map){
		$map['is_del'] = array('eq', '0');
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
		if (!empty($_POST['mat_no'])){
			$map['mat_no'] = array('eq',$_POST['mat_no']);
		}
		if (!empty($_POST['gi_no'])){
			$this -> _set_search("gi_no", $_POST['gi_no']);
			$map['gi_no'] = array('eq',$_POST['gi_no']);
		}
		if (!empty($_POST['po_no'])){
			$this -> _set_search("gi_no", $_POST['po_no']);
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

	public function wait(){
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		unset($map['gi_date']);
		if (empty($_POST['start_date']) & empty($_POST['end_date'])){
			$start_date=toDate(mktime(0,0,0,date("m")-1,1,date("Y")),'Y-m-d');	
			$end_date=toDate(mktime(0,0,0,date("m")+1,0,date("Y")),'Y-m-d');	
			$this -> _set_search("start_date",$start_date);
			$this -> _set_search("end_date",$end_date);
			$map['po_date'] = array( array('egt',$start_date), array('elt',$end_date));			
		}else{
			$start_date=$_POST['start_date'];
			$end_date=$_POST['end_date'];
			$map['po_date'] = array( array('egt',$start_date), array('elt',$end_date));	
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);

		$model = D("Gi");
		$sql=$model->get_wait_sql();
		$model=new Model();
		$list=$model->table("($sql) t1")->where($map)->order('supplier,po_no,mat_no')->select();
		//dump($list);
		$this->assign("list",$list);
		$this -> display();
	}

	public function receve(){
		$po_no=$_REQUEST['po_no'];	

		$model = D("Gi");
		$sql=$model->get_wait_sql();
		$model=new Model();
		$where['po_no']=array('eq',$po_no);
		$list=$model->table("($sql) t1")->where($where)->order('supplier,po_no,mat_no')->select();		
		$this->assign('list',$list);
		$this -> display();
	}

	public function index(){
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		
		if (empty($_POST['start_date']) & empty($_POST['end_date'])){
			$start_date=toDate(mktime(0,0,0,date("m"),1,date("Y")),'Y-m-d');	
			$end_date=toDate(mktime(0,0,0,date("m")+1,0,date("Y")),'Y-m-d');	
			$this -> _set_search("start_date",$start_date);
			$this -> _set_search("end_date",$end_date);
			$map['gi_date'] = array( array('egt',$start_date), array('elt',$end_date));
		}else{
			$start_date=$_POST['start_date'];
			$end_date=$_POST['end_date'];
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);

		$model = D("GiView");
		$list=$model->where($map)->order('supplier,po_no,gi_no')->select();
		$this->assign("list",$list);
		$this -> display();
		return;
	}

	function insert() {	
		$arr_mat_no=$_POST['mat_no'];
		$arr_qty=$_POST['qty'];
		$arr_order_qty=$_POST['order_qty'];
		$arr_diff=$_POST['diff'];		
		$arr_remark=$_POST['remark'];
		$type=$_POST['type'];
		$payment=$_POST['payment'];

		dump(array_map(number_format,$arr_qty));
		dump(array_map(number_format,$arr_diff));
		$test=array_diff_assoc(array_map(number_format,$arr_qty),array_map(number_format,$arr_order_qty));

		if(empty($test)){			
			$where['po_no']=array('eq',$_POST['po_no']);
			M("Po")->where($where)->setField("finish",1);
			
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
				$pay_model=M("Pay");
				$pay_data['create_time']=time();
				$pay_model->add($pay_data);
			}					
		};
		//die;
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
		//保存当前数据对象
		$gi_no=$gi_model->gi_no;
		$gi_result = $gi_model -> add();

		$gi_item_model=M("GiItem");
		foreach ($arr_mat_no as $key => $value){
			$data['mat_no']=$arr_mat_no[$key];
			$data['in_qty']=$arr_qty[$key];			
			$data['order_qty']=$arr_order_qty[$key];
			$data['remark']=$arr_remark[$key];
			$data['gi_no']=$gi_no;
			$gi_item_result=$gi_item_model->add($data);			
		}
		if ($gi_result !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}	

	public function mark() {
		$action = $_REQUEST['action'];
		$id = $_REQUEST['doc_id'];
		if(!empty($id)){
			switch ($action) {
				case 'del' :
					$where['id'] = array('in', $id);
					$folder = M("Gi") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("Folder") -> _get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'is_del';
							$this -> set_field($id, $field, 1);
						}
						$this -> ajaxReturn('', "删除成功", 1);
					} else {
						$this -> ajaxReturn('', "删除失败", 1);
					}
					break;
				case 'move_folder' :
					$target_folder = $_REQUEST['val'];

					$where['id'] = array('in', $id);
					$folder = M("Gi") -> distinct(true) -> where($where) -> field("folder") -> select();
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
