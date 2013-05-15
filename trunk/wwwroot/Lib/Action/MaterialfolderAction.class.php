<?php
class MaterialFolderAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['is_del'] = array('eq', '0');
	}

	public function index() {
		$node = M("MaterialFolder");
		$menu = array();
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('pid', $pid);
		
		$model = M("MaterialFolder");
		$list = $model -> where($where) -> getField('id,name');
		$this -> assign('folder_list', $list);
		$this -> assign('menu', sub_tree_menu($tree));
		$this -> display();
	}

	public function winpop() {
		$node = M("MaterialFolder");
		$menu = array();
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display();
	}
}
