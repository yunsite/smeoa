<?php
class DeptAction extends CommonAction {

	public function _filter(&$map) {
		if (!empty($_GET['pid'])) {
			$map['pid'] = $_POST['pid'];
		}
	}

	public function index() {
		$node = M("Dept");
		$menu = array();
		$menu = $node -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		
		$model = M("Dept");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_list', $list);


		$model = M("DeptGrade");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_grade_list', $list);

		$this -> display();
	}

	public function winpop() {
		$node = M("Dept");
		$menu = array();
		$menu = $node -> field('id,pid,name') -> order('sort asc') -> select();

		$tree = list_to_tree($menu);
		$this -> assign('pid', $pid);

		$model = M("Dept");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_list', $list);
		$this -> assign('menu', popup_tree_menu($tree));

		$model = M("DeptGrade");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_grade_list', $list);
		$this -> display();
	}

	public function winpop2() {
		$node = M("Dept");
		$menu = array();
		$menu = $node -> field('id,pid,name') -> order('sort asc') -> select();

		$tree = list_to_tree($menu);
		$this -> assign('pid', $pid);

		$model = M("Dept");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_list', $list);
		$this -> assign('menu', popup_tree_menu($tree));

		$model = M("DeptGrade");
		$list = $model -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_grade_list', $list);

		$this -> display();
	}

}
?>