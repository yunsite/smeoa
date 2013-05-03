<?php
class NoticeAction extends CommonAction {
	private $notice_folder;
	public function _initialize() {
		parent::_initialize();
		$model = D('Folder');
		$this -> notice_folder = $model -> getField('id,name');
	}

	//过滤查询字段
	function _filter(&$map) {
		$map['status'] = array('eq', '1');
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$map['title'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	public function index() {
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("Notice");
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
		return;
	}

	public function mark() {
		$action = $_REQUEST['action'];
		$id = $_REQUEST['notice_id'];
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
				$folder = M("Notice") -> distinct(true) -> where($where) -> field("folder") -> select();
				if (count($folder) == 1) {
					$auth = D("Folder") -> _get_folder_auth($folder[0]["folder"]);
					if ($auth['admin'] == true) {
						$field = 'folder';
						$this -> set_field($id, $field, $target_folder);
					}
					$this -> ajaxReturn('', "操作成功", 1);
				} else {
					$this -> ajaxReturn('', "操作成功", 1);
				}
				break;

			default :
				break;
		}
	}

	public function _before_add() {
		$fid = $_REQUEST['fid'];
		$type = M("Folder") -> where("id=$fid") -> getField("type");
		$this -> assign('folder', $fid);
		$this -> assign('type', $type);
	}

	public function _before_read() {
		$id = $_REQUEST['id'];
		$user_id = $this -> get_user_id();
		$model = M("Notice");
		$folder_id = $model -> where("id=$id") -> getField('folder');
		$this -> assign("auth", $auth = D("Folder") -> _get_folder_auth($folder_id));
	}

	public function folder() {
		$model = D("Notice");
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

		$this -> _assign_folder_list("/notice/folder/", 1);
		$this -> assign("folder_id", $folder_id);
		$this -> display();
		return;
	}

	public function upload() {
		R('File/upload');
	}

	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}

}
