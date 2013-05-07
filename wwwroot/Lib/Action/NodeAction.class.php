<?php
class NodeAction extends CommonAction {
	
	public function _filter(&$map) {
		if (!empty($_GET['pid'])) {
			$map['pid'] = $_POST['pid'];
		}
	}
	
	public function _before_index() {
		$model = M("Node");
		$list = $model -> where('pid=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('groupList', $list);
	}
	
	public function index() {
		$node = M("Node");
		if (!empty($_POST['s_pid'])) {
			$pid = $_POST['s_pid'];
		} elseif (!empty($_GET['s_pid'])) {
			$pid = $_GET['s_pid'];
		} else {
			$pid = $node -> where('pid=0') -> order('sort asc') -> getField('id');
		}
		
		$menu = array();
		$menu = $node -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu, $pid);
		$this -> assign('pid', $pid);

		$model = M("Node");
		$list = $model -> order('sort asc') -> getField('id,name');

		$this -> assign('node_list', $list);

		$this -> assign('menu', popup_tree_menu($tree));

		$this -> display();
	}


	public function sort() {
		$node = M('Node');
		if (!empty($_GET['sortId'])) {
			$map = array();
			$map['status'] = 1;
			$map['id'] = array('in', $_GET['sortId']);
			$sortList = $node -> where($map) -> order('sort asc') -> select();
		} else {
			if (!empty($_GET['pid']) || $_GET['pid'] == "0") {
				$pid = $_GET['pid'];
			}
			if ($node -> getById($pid)) {
				$level = $node -> level + 1;
			} else {
				$level = 1;
			}
			$this -> assign('level', $level);
			$sortList = $node -> where('status=1 and pid=' . $pid) -> order('sort asc') -> select();
		}
		$this -> assign("sortList", $sortList);
		$this -> display();

		return;
	}

	function winpop() {
		$user_id = get_user_id();
		if ($user_id) {
			if ($this -> _session('menu' . $user_id)) {
				//如果已经缓存，直接读取缓存
				$menu = $_SESSION['menu' . $user_id];
			} else {
				//读取数据库模块列表生成菜单项
				$menu = D("Node") -> access_list($user_id);
				//缓存菜单访问
				session('menu' . $user_id, $menu);
			}
			$tree = list_to_tree($menu);
			//$tree = tree_to_list($tree);

			$this -> assign('menu', popup_tree_menu($tree));
			$this -> display();
		}
	}
}
?>