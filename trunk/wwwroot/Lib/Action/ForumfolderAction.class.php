<?php
class ForumFolderAction extends FolderAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['is_del'] = array('eq', '0');
	}

	public function index() {
		$this -> assign("folder_name", "论坛管理");
		$this -> assign("type", "/forum/folder/");
		$this -> set_folder("/forum/folder/");
		parent::common();
	}

	public function winpop2() {
		$this -> set_folder("/forum/folder/");
		$this -> set_public(1);
		parent::winpop();
	}

	//--------------------------------------------------------------------------------------------------------------------------------
}
