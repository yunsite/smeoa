<?php
class ForumAction extends CommonAction {
	public function _initialize() {
		parent::_initialize();
	}

	//过滤查询字段
	function _filter(&$map) {
		$map['title'] = array('like', "%" . $_POST['title'] . "%");
		$map['user_name'] = array('like', "%" . $_POST['user_name'] . "%");
		$map['content'] = array('like', "%" . $_POST['content'] . "%");
		$map['notice_no'] = array('like', "%" . $_POST['notice_no'] . "%");
		$map['status'] = array('eq', '1');
	}

	public function _conv_data(&$item) {
		if (isset($item['folder'])) {
			$model = D('Folder');
			$list = $model -> getField('id,name');
			$item['folder_name'] = $list[$item['folder']];
		}
		if (isset($item['user_id'])) {
			$model = D('User');
			$list = $model -> get_user_list();
			$list = fix_array_key($list, "id");
			$item['user'] = $list[$item['user_id']];
		}
		return $item;
	}

	public function index() {
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("Forum");
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
		return;
	}

	public function _before_add() {
		$this -> assign('folder', $_REQUEST['fid']);
	}

	public function read() {
		$model = M("Forum");
		$id = $_REQUEST["id"];
		$vo = $model -> getById($id);
		$vo = $this -> _conv_data($vo);
		$this -> assign('vo', $vo);

		$id = $_REQUEST['id'];
		$user_id = $this -> get_user_id();
		$user['user_id'] = $user_id;

		$user = $this -> _conv_data($user);
		$this -> assign('user', $user);

		$this -> assign('user_id', $user_id);

		$model = M("Forum");
		$model -> where("id=$id") -> setInc('views', 1);

		$model = M("Forum");
		$folder_id = $model -> where("id=$id") -> getField('folder');
		$auth = D("Folder") -> _get_folder_auth($folder_id);
		$this -> assign("auth", $auth);

		$where['tid'] = $id;
		$where['status'] = 1;
		$model = M("Post");

		$this -> set_list_rows(8);

		if (!empty($model)) {
			$this -> _list($model, $where, "id", true);
		}

		$this -> assign("tid", $id);
		$this -> display();
	}

	public function folder() {

		$folder_id = $_REQUEST['fid'];
		if (!empty($_REQUEST['name'])) {
			$where['name'] = array("like", "%" . $_REQUEST['name'] . "%");
		}
		$where['folder'] = $folder_id;
		$where['status'] = 1;
		$model = M("Forum");
		if (!empty($model)) {
			$this -> _list($model, $where);
		}
		$where = array();
		$where['id'] = array('eq', $folder_id);
		$folder_name = M("Folder") -> where($where) -> getField("name");
		$this -> assign("folder_name", $folder_name);

		$auth = D("Folder") -> _get_folder_auth($folder_id);
		$this -> assign("auth", $auth);

		$this -> _assign_folder_list('/forum/folder/');
		$this -> assign("folder_id", $folder_id);
		$this -> display();
		return;
	}

	public function del() {
		$id = $_REQUEST['id'];
		$where['id'] = array('in', explode(',', $id));
		$list = M("Forum") -> where($where) -> getfield('id,folder');

		$result = array_map(array("FolderAction", "_get_folder_auth"), $list);

		foreach ($result as $key => $val) {
			if ($val['admin'] == true) {
				$field = 'status';
				$this -> set_field($key, $field, 0);
			}
		}
		$this -> ajaxReturn('', "删除成功", 1);
	}

	public function move_folder() {
		$id = $_REQUEST['id'];
		$user_id = $this -> get_user_id();

		$where['id'] = array('in', explode(',', $id));
		$list = $list = M("Forum") -> where($where) -> getfield('id,folder,user_id');

		foreach ($list as $key => $val) {
			if ($val['user_id'] == $user_id) {
				$field = 'folder';
				$target_folder = $_REQUEST['folder'];
				$this -> set_field($key, $field, $target_folder);
			}
		}

		$list = M("Forum") -> where($where) -> getfield('id,folder');
		$result = array_map(array("FolderAction", "_get_folder_auth"), $list);
		foreach ($result as $key => $val) {
			if ($val['admin'] == true) {
				$field = 'folder';
				$target_folder = $_REQUEST['folder'];
				$this -> set_field($key, $field, $target_folder, '', true);
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
