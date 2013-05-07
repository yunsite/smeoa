<?php
class ConfigAction extends CommonAction {
	public function index() {
		$config = M("Config") -> find(get_user_id());
		$this -> assign("config", $config);
		if (count($config)) {
			$this -> assign('opmode', 'edit');
		} else {
			$this -> assign('opmode', 'add');
		}
		$this -> display();
	}

	function save() {
		$opmode = $_POST["opmode"];
		if ($opmode == "add") {
			$this -> insert();
		}
		if ($opmode == "edit") {
			$this -> update();
		}
	}

	function insert() {
		$model = M('Config');
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('id', $model -> getDbFields())) {
			$model -> id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};
		$email = $_POST['email'];
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			$this -> _set_email($email);
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function update() {
		//B('FilterString');

		$model = M('Config');

		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('id', $model -> getDbFields())) {
			$model -> id = get_user_id();
		};
		// 更新数据
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}

}
?>