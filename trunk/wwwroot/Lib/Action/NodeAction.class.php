<?php
class NodeAction extends CommonAction {		
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

	function winpop(){
		$menu = D("Node") -> order('sort asc') -> select();;
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display();
	}
}
?>