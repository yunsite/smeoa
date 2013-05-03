<?php
class ScheduleAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map) {
		if (!empty($_POST["name"])) {
			$map['name'] = array('like', "%" . $_POST['name'] . "%");
		}
		$map['user_id'] = array('eq', $this -> get_user_id());
		$map['status'] = array('eq', '1');
		if (!empty($_POST["start_date"])) {
			$map['start_date'] = array("egt", $_POST["start_date"]);
		}
		if (!empty($_POST["end_date"])) {
			$map['end_date'] = array("elt", $_POST["end_date"]);
		}
		$map['status'] = array('eq', '1');
	}

	public function upload() {
		R("File/upload");
	}

	function read() {
		$model = M('Schedule');
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
		$where['user_id'] = $this -> get_user_id();

		$vo = $model -> where($where) -> find();
		$this -> assign('vo', $vo);
		$this -> display();
	}

	function search() {
		$map = $this -> _search();
		if (method_exists($this, '_filter')){
			$this -> _filter($map);
		}
		if (empty($_POST["start_date"])) {
			$start_date=toDate(mktime(0,0,0,date("m"),1,date("Y")),'Y-m-d');			
			$map['start_date'] = array("egt",$start_date);
		}else{
			$start_date=$_POST["start_date"];
		}
		if (empty($_POST["end_date"])) {
			$end_date=toDate(mktime(0,0,0,date("m")+1,0,date("Y")),'Y-m-d');			
			$map['end_date'] = array("elt",toDate(time(),'Y-m-d'));		
		}else{
			$end_date=$_POST["end_date"];
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$model = D("Schedule");

		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> assign('type_data', $this -> type_data);
		$this -> display();
		return;
	}

	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}

	public function add() {
		$this -> assign('type_data', $this -> type_data);
		$this -> assign('warn_data', $this -> warn_data);
		$this -> display();
	}

	public function edit() {
		$this -> assign('type_data', $this -> type_data);
		$this -> assign('warn_data', $this -> warn_data);

		$id = $_REQUEST['id'];
		$model = M('Schedule');
		$where['user_id'] = $this -> get_user_id();
		$where['id'] = $id;
		$vo = $model -> where($where) -> find();

		$vo['start_time'] = fix_time($vo['start_time']);
		$vo['end_time'] = fix_time($vo['end_time']);
		$this -> assign('vo', $vo);
		$this -> display();
	}

	public function day_view() {
		$this -> index();
	}

	public function read2() {
		$this -> read();
	}

	function json() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-Type:text/html; charset=utf-8");
		$user_id = $this -> get_user_id();
		$start_date = $_REQUEST["start_date"];
		$end_date = $_REQUEST["end_date"];

		$where['user_id'] = $user_id;
		$where['start_date'] = array( array('egt', $start_date), array('elt', $end_date));
		$list = M("Schedule") -> where($where) -> order('start_date,priority desc') -> select();
		exit(json_encode($list));
	}

}
?>