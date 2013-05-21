<?php
class TodoAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
	}

	public function index() {
		$user_id = get_user_id();
		$where['user_id'] = $user_id;
		$where['status'] = array("in", "1,2");
		if(!empty($_POST['keyword'])){
			$where['name']=array('like',"%".$_POST["keyword"]."%");
		}
		$list = M("Todo") -> where($where) -> order('priority desc,sort asc') -> select();
		$this -> assign("list", $list);

		$where['status'] = 3;
		$list2 = M("Todo") -> where($where) -> order('priority desc,sort asc') -> select();
		$this -> assign("list2", $list2);

		$this -> display();
		return;
	}

	public function upload() {
		R("File/upload");
	}

	function read() {
		$model = M('Todo');
		$id = $_REQUEST['id'];
		$list = $_REQUEST['list'];
		$this -> assign("list", $list);
		$list = explode("|", $list);
		array_pop($list);
		$current = array_search($id, $list);
		if ($current !== false) {
			$next = $list[$current + 1];
			$prev = $list[$current - 1];
		}
		$this -> assign('next', $next);
		$this -> assign('prev', $prev);

		$where['id'] = $id;
		$where['user_id'] = get_user_id();
		$vo = $model -> where($where) -> find();
		$this -> assign('vo', $vo);
		$this -> display();
	}

	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}

	function del() {
		$id = $_REQUEST['id'];
		$where['id'] = $id;
		$where['user_id'] = get_user_id();
		$result = M("Todo") -> where($where) -> delete();
		if ($result !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('删除成功!');
		} else {
			//失败提示
			$this -> error('删除失败!');
		}
	}

	public function add(){
		$this -> display();
	}

	public function edit() {

		$this -> assign("time_list", $time_list);
		$this -> assign('type_data', $this -> type_data);
		$this -> assign('warn_data', $this -> warn_data);

		$id = $_REQUEST['id'];
		$model = M('Todo');
		$where['user_id'] = get_user_id();
		$where['id'] = $id;
		$vo = $model -> where($where) -> find();

		$vo['start_time'] = fix_time($vo['start_time']);
		$vo['end_time'] = fix_time($vo['end_time']);
		$this -> assign('vo', $vo);
		$this -> display();
	}

	public function set_sort() {
		$node = $_REQUEST['node'];
		$priority = $_REQUEST['priority'];
		$sort = $_REQUEST['sort'];

		$model = M("Todo");
		// 实例化User对象
		$where['user_id'] = get_user_id();
		foreach ($node as $key => $val) {
			$data = array('priority' => $priority[$key], 'sort' => $sort[$key]);
			$where['id'] = $val;
			$model -> where($where) -> setField($data);
		}
	}

	public function mark_status() {
		$id = $_REQUEST['id'];
		$val = $_REQUEST['val'];
		if ($val == 3) {
			$field = 'end_date';
			$date = date("Y-m-d");
			$model = M("Todo");
			$where['id'] = $id;
			$where['user_id'] = array('eq', get_user_id());
			$list = $model -> where($where) -> setField($field, $date);
		}
		$field = 'status';
		$result = $this -> set_field($id, $field, $val);
		if ($result !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('删除成功!');
		} else {
			//失败提示
			$this -> error('删除失败!');
		}
	}

	function json() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-Type:text/html; charset=utf-8");
		$user_id = get_user_id();
		$start_date = $_REQUEST["start_date"];
		$end_date = $_REQUEST["end_date"];

		$where['user_id'] = $user_id;
		$where['start_date'] = array( array('gt', $start_date), array('lt', $end_date));
		$list = M("Todo") -> where($where) -> order('start_date,priority desc') -> select();
		exit(json_encode($list));
	}
}
?>