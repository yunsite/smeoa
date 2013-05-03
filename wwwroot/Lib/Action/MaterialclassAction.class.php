<?php
class MaterialClassAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['status'] = array('eq', '1');
	}

	public function index() {
		$node = M("MaterialClass");
		$where['status']=1;
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', sub_tree_menu($tree));
		
		$model = M("MaterialClass");
		$list = $model -> where($where) -> getField('id,name');
		$this -> assign('folder_list', $list);

		$this -> display();
	}

	public function winpop() {
		$node = M("MaterialClass");
		$menu = array();
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display();
	}
}
