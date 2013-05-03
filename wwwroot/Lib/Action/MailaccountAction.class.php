<?php
class MailaccountAction extends CommonAction {

	public function index() {
		$mail_user = M("MailAccount") -> find($this -> get_user_id());

		$this -> assign('mail_user', $mail_user);
		if (count($mail_user)) {
			$this -> assign('opmode', 'edit');
		} else {
			$this -> assign('opmode', 'add');
		}
		$this -> display();
	}

	function _set_email($email) {
		$model = M("User");
		$user_id = $this -> get_user_id();
		$data['id'] = $user_id;
		$data['email'] = $email;
		$model -> save($data);
	}

	function insert() {
		$model = M('MailAccount');
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('id', $model -> getDbFields())) {
			$model -> id = $this -> get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};
		$email = $_POST['email'];
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			$this -> _set_email($email);
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function update() {

		$model = M('MailAccount');

		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('id', $model -> getDbFields())) {
			$model -> id = $this -> get_user_id();
		};
		// 更新数据
		$email = $_POST['email'];
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> _set_email($email);
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}
}
?>