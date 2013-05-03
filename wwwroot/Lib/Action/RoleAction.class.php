<?php
// 角色模块
class RoleAction extends CommonAction {

	public function node() {
		$node = M("Node");
		if (!empty($_POST['s_pid'])) {
			$pid = $_POST['s_pid'];
		} else {
			$pid = $node -> where('pid=0') -> order('sort asc') -> getField('id');
		}
		$menu = array();
		$menu = $node -> field('id,pid,name,check_auth,"#" as url') -> order('sort asc') -> select();
		$tree = list_to_tree($menu, $pid);
		$this -> assign('pid', $pid);
		$list = tree_to_list($tree);
		$this -> assign('node_list', $list);
		//$this->assign('menu',sub_tree_menu($list));

		$role = M("Role") -> select();
		$this -> assign('list', $role);

		$list = $node -> where('pid=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('groupList', $list);
		$this -> display();
	}

	public function get_node_list() {
		$role_id = $_POST["role_id"];
		$model = D("Role");
		$data = $model -> get_node_list($role_id);
		if ($data !== false) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	public function set_node() {
	
		$role_id = $_POST["role_id"];
		$org_list = $_POST["org_node_list"];
		$node_list = $_POST["node_list"];
		$admin_list=$_POST["admin"];
		$write_list=$_POST["write"];
		$read_list=$_POST["read"];

		$model = D("Role");
		$model -> del_node($role_id, $org_list);

		$result = $model -> set_node($role_id, $node_list);

		$model=M("RoleNode");
		$where['role_id']=$role_id;

		$where['node_id']=array('in',$admin_list);
		$model->where($where)->setField('admin',1);


		$where['node_id']=array('in',$write_list);
		$model->where($where)->setField('write',1);


		$where['node_id']=array('in',$read_list);
		$model->where($where)->setField('read',1);		

		if ($result === false) {
			$this -> error('操作失败！');
		} else {
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功！');
		}
	}

	public function get_role_list() {
		$model = D("Role");
		$id = $_REQUEST["id"];
		$data = $model -> get_role_list($id);
		if ($data !== false) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	public function set_role() {
		//dump($_POST);
		$user_list = $_POST["user_list"];
		$role_list = $_POST["role_list"];

		$model = D("Role");
		$model -> del_role($user_list);

		$result = $model -> set_role($user_list, $role_list);
		if ($result === false) {
			$this -> error('操作失败！');
		} else {
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功！');
		}
	}

	public function user() {
		$keyword="";
		if (!empty($_POST['keyword'])) {
			$keyword = $_POST['keyword'];
		}
		$user_list = D("User") -> get_user_list($keyword);
		$this -> assign("user_list", $user_list);

		$role = M("Role");
		$role_list = $role -> select();
		$this -> assign("role_list", $role_list);
		$this -> display();
	}

	public function duty() {
		$duty = M("Duty");
		$duty_list = $duty -> select();
		$this -> assign("duty_list", $duty_list);

		$role = M("Role") -> select();
		$this -> assign('list', $role);
		$this -> display();
	}

	public function get_duty_list() {
		$role_id = $_POST["role_id"];
		$model = D("Role");
		$data = $model -> get_duty_list($role_id);
		if ($data !== false) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	public function set_duty() {
		$role_id = $_POST["role_id"];
		$duty_list = $_POST["duty_list"];

		$model = D("Role");
		$model -> del_duty($role_id);

		$result = $model -> set_duty($role_id, $duty_list);
		if ($result === false) {
			$this -> error('操作失败！');
		} else {
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功！');
		}
	}

}
?>