<?php
class MailFolderAction extends FolderAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['status'] = array('eq', '1');
	}

	public function index() {
		$this -> assign("folder_name", "邮件文件夹设置");
		$this -> assign("folder", "mail/mail_list");
		$this -> set_folder("mail/mail_list");
		parent::personal();
	}

	public function winpop1() {
		$this -> set_folder("mail/mail_list");
		$this -> set_public(2);
		parent::winpop();
	}
}
