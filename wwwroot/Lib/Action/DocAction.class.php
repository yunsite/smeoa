<?php
class DocAction extends CommonAction {
	private $doc_folder;
	public function _initialize() {
		parent::_initialize();
		$model = D('Folder');
		$this -> doc_folder = $model -> getField('id,name');
	}

	//过滤查询字段
	function _filter(&$map){
		$map['status'] = array('eq', '1');
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
		if (!empty($_POST['start_date']) & !empty($_POST['end_date'])) {
			$this -> _set_search("start_date", $_POST['start_date']);
			$this -> _set_search("end_date", $_POST['end_date']);
			$map['create_time'] = array( array('gt', date_to_int($_POST['start_date'])), array('lt', date_to_int($_POST['end_date'])));
		}
	}

	public function index(){
		$user_id = get_user_id();
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}

		$model = D("DocView");
		$map['_string'] = "type='/doc/common/' or (type='/doc/personal/' and Doc.user_id='$user_id')";
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
		return;
	}

	public function common() {
		$model = D("Doc");
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$folder_id = $_REQUEST['fid'];
		$map['folder'] = $folder_id;
		if (!empty($model)) {
			$this -> _list($model, $map);
		}

		$where = array();
		$where['id'] = array('eq', $folder_id);
		$folder_name = M("Folder") -> where($where) -> getField("name");
		$this -> assign("folder_name", $folder_name);

		$auth = D("Folder") -> _get_folder_auth($folder_id);
		$this -> assign("auth", $auth);

		$this -> _assign_folder_list("/doc/common/", 1);
		$this -> assign("folder_id", $folder_id);
		$this -> display();
		return;
	}

	public function personal() {
		$model = D("Doc");
		$map = $this -> _search();

		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$folder_id = $_REQUEST['fid'];
		$map['folder'] = $folder_id;
		if (!empty($model)) {
			$this -> _list($model, $map);
		}

		$where = array();
		$where['id'] = array('eq', $folder_id);
		$folder_name = M("Folder") -> where($where) -> getField("name");
		$this -> assign("folder_name", $folder_name);

		$auth = D("Folder") -> _get_folder_auth($folder_id);
		$this -> assign("auth", $auth);

		$this -> _assign_folder_list('/doc/personal/', 2);
		$this -> assign("folder_id", $folder_id);

		$this -> display();
		return;
	}

	public function _before_add() {
		$fid = $_REQUEST['fid'];
		$type = D("Folder") -> where("id=$fid") -> getField("folder");
		$this -> assign('folder', $fid);
		$this -> assign('type',$type);
	}

	public function _before_read() {
		$id = $_REQUEST['id'];
		$user_id = get_user_id();
		$model = M("Doc");
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
					$folder = M("Doc") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("Folder") -> _get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'status';
							$this -> set_field($id, $field, 0);
						}
						$this -> ajaxReturn('', "删除成功", 1);
					} else {
						$this -> ajaxReturn('', "删除失败", 1);
					}
					break;
				case 'move_folder' :
					$target_folder = $_REQUEST['val'];

					$where['id'] = array('in', $id);
					$folder = M("Doc") -> distinct(true) -> where($where) -> field("folder") -> select();
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
