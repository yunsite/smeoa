<?php
class DocFolderAction extends FolderAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['status'] = array('eq', '1');
	}

	public function common() {
		$this -> assign("folder_name", "公用文档库设置");
		$this -> assign("type", "/doc/common/");
		$this -> set_folder("/doc/common/");
		parent::common();
	}

	public function personal() {
		$this -> assign("folder_name", "个人文档库设置");
		$this -> assign("type", "/doc/personal/");
		$this -> set_folder("/doc/personal/");
		parent::personal();
	}

	public function winpop1() {
		$this -> set_folder("/doc/personal/");
		$this -> set_public(2);
		parent::winpop();
	}

	public function winpop2() {
		$this -> set_folder("/doc/common/");
		$this -> set_public(1);
		parent::winpop();
	}

}
