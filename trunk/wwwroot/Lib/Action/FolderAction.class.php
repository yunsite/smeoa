<?php
class FolderAction extends CommonAction {
	//过滤查询字段
	private $_folder;
	private $_public;

	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['status'] = array('eq', '1');
	}

	function set_folder($folder) {
		$this -> _folder = $folder;
	}

	function get_folder() {
		return $this -> _folder;
	}

	function set_public($public) {
		$this -> _public = $public;
	}

	function get_public() {
		return $this -> _public;
	}

	function insert() {
		$model = D("Folder");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功.
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败22!');
		}
	}

	function update() {
		$model = D("Folder");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		// 更新数据
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}

	function ajaxRead() {
		$model = M("Folder");
		$id = $_REQUEST["id"];
		$data = $model -> getById($id);
		if ($data !== false) {// 读取成功
			if ($data['public'] == 1) {
				$this -> ajaxReturn($data, "", 1);
			}
			if ($data['public'] == 2) {
				$user_id = get_user_id();
				if ($data['user_id'] == $user_id) {
					$this -> ajaxReturn($data, "", 1);
				}
			}
			$this -> ajaxReturn("", "", 0);
		}
	}

	public function common() {

		$node = M("Folder");
		$menu = array();
		$where['folder'] = $this -> get_folder();
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', sub_tree_menu($tree));

		$model = M("Folder");
		$list = $model -> where($where) -> getField('id,name');
		$this -> assign('folder_list', $list);
		$this -> display("Folder:common");
	}

	public function personal() {
		$node = M("Folder");
		$menu = array();
		$user_id = get_user_id();
		$where['folder'] = $this -> get_folder();
		$where['user_id'] = $user_id;
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$model = M("Folder");
		$list = $model -> where($where) -> getField('id,name');
		$this -> assign('folder_list', $list);
		$this -> assign('menu', sub_tree_menu($tree));
		$this -> display("Folder:personal");
	}

	public function winpop(){
		$node = M("Folder");
		$menu = array();
		$public = $this -> get_public();
		$where['folder'] = $this -> get_folder();
		if ($public == 2) {
			$user_id = get_user_id();
			$where['user_id'] = $user_id;
		}
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display("folder:winpop");
	}

}
