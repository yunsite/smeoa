<?php
class NoticeFolderAction extends FolderAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['is_del'] = array('eq', '0');
	}

	public function index() {
		$this -> assign("folder_name", "公告栏管理");
		$this -> assign("type", "/notice/folder/");
		$this -> set_folder("/notice/folder/");
		parent::common();
	}

	public function winpop1() {
		$this -> set_folder("/notice/folder/");
		$this -> set_public(2);
		parent::winpop();
	}

	public function winpop2() {
		$this -> set_folder("/notice/folder/");
		$this -> set_public(1);
		parent::winpop();
	}
}
