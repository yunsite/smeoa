<?php
class WarehouseAction extends CommonAction {

	function _filter(&$map) {
		if (!empty($_POST['keyword'])) {
			$map['code|name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	public function index(){
		$model = M("Warehouse");
		$list = $model -> order('sort') -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
}
?>