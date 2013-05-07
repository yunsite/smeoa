<?php
class FlowTypeAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		if (!empty($_POST['keyword'])){
			$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	function index(){
		$model = M("FlowType");
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$list = $model -> where($map) -> select();
		$this -> assign('list', $list);
		$this -> group_list();
		$this -> display();
		return;
	}

	function mark() {
		$id = $_REQUEST["flow_type_id"];
		$val = $_REQUEST["val"];
		$field = 'group';
		$result=$this -> set_field($id, $field, $val);
		if ($result !== false) {
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function _before_add() {
		$this -> group_list();
		$user_id = get_user_id();
		$this -> assign("user_id", $user_id);
	}

	function group_list() {
		$model = M("FlowType");
		$where['group'] = array("neq", "");
		$group_list = $model -> where($where) -> distinct("group") -> field("group") -> select();
		$group_list = rotate($group_list);
		$group_list = array_combine($group_list["group"], $group_list["group"]);
		$this -> assign("group_list", $group_list);
	}

	function _before_edit() {
		$this -> group_list();
		$user_id = get_user_id();
		$this -> assign("user_id", $user_id);
	}

	function insert() {
		$ajax = $_POST['ajax'];
		$model = D('FlowType');

		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> __set('letter', get_letter($model -> __get('name')));
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function update() {
		$id = $_POST['id'];
		$model = D("FlowType");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
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

	function ajaxRead() {
		$type = $_REQUEST['type'];
		$id = $_REQUEST['id'];

		switch ($type) {
			case "company" :
				$model = M("Dept");
				$dept = tree_to_list(list_to_tree( M("Dept") -> select(), $id));
				$dept = rotate($dept);
				$dept = implode(",", $dept['id']) . ",$id";

				$model = M("User");
				$where['dept_id'] = array('in', $dept);
				$data = $model -> where($where) -> field('id,emp_name,dept_id,email') -> select();
				break;
			case "rank" :
				$model = M("User");
				$where['rank_id'] = array('eq', $id);
				$data = $model -> where($where) -> field('id,emp_name,email') -> select();
				break;

			case "position" :
				$model = M("User");
				$where['position_id'] = array('eq', $id);
				$data = $model -> where($where) -> field('id,emp_name,email') -> select();
				break;

			case "personal" :
				$model = M("FlowType");
				if ($id == "#")
					$id = "";
				$where['group'] = array('eq', $id);
				$where['email'] = array('neq', '');
				$where['user_id'] = array('eq', get_user_id());
				$data = $model -> where($where) -> field('id,name as emp_name,email') -> select();
				break;

			default :
		}

		if (true) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	function json() {
		header("Content-Type:text/html; charset=utf-8");
		$key = $_REQUEST['key'];
		$ajax = $_REQUEST['ajax'];
		//dump($ajax);

		$model = M("User");
		$where['emp_name'] = array('like', "%" . $key . "%");
		$where['letter'] = array('like', "%" . $key . "%");
		$where['email'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$company = $model -> where($where) -> field('id,emp_name as name,email') -> select();
		$model = M("FlowType");

		$where['name'] = array('like', "%" . $key . "%");
		$where['letter'] = array('like', "%" . $key . "%");
		$where['email'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$map['email'] = array('neq', '');
		$map['user_id'] = array('eq', get_user_id());
		$personal = $model -> where($map) -> field('id,name,email') -> select();

		if (empty($company)) {
			$company = array();
		}
		if (empty($personal)) {
			$personal = array();
		}

		$FlowType = array_merge_recursive($company, $personal);
		exit(json_encode($FlowType));
	}
}
?>