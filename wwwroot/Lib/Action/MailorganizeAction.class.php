<?php
class MailOrganizeAction extends CommonAction {

	public function index() {
		$user_id = $this -> get_user_id();
		$where["user_id"] = $user_id;
		$list = M("MailOrganize") -> where($where) -> select();
		$this -> assign("list", $list);
		$this -> display();
	}

	public function _before_add() {
		$temp = R("Mail/_assign_mail_folder_list");
		$this -> assign('mail_folder', $temp);
	}

	public function _before_edit() {
		$temp = R("Mail/_assign_mail_folder_list");
		$this -> assign('mail_folder', $temp);
	}

	function update() {
		$id = $_POST["id"];
		$model = M("MailOrganize");
		$model -> where("id=$id") -> delete();

		$model = D("MailOrganize");

		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = $this -> get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('编辑成功!');
		} else {
			//失败提示
			$this -> error('编辑失败!');
		}
	}

	function del() {

		$id = $_REQUEST["id"];
		$model = D("MailOrganize");

		$where['user_id'] = $this -> get_user_id();
		$where['id'] = $id;
		$list = $model -> where($where) -> delete();

		if ($list !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('删除成功!');
		} else {
			//失败提示
			$this -> error('编辑失败!');
		}
	}

}
?>