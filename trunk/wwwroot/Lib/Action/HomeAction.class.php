<?php
class HomeAction extends CommonAction {
	//过滤查询字段

	function _filter(&$map) {
		if (!empty($_POST['keyword'])) {
			$map['type|name|code'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	public function index() {
		cookie("top_menu", null);
		$config = D("UserConfig") -> get_config();
		$this -> assign("home_sort", $config['home_sort']);
		$this -> mail_list();
		$this -> flow_list();
		$this -> schedule_list();
		$this -> notice_list();
		$this -> doc_list();
		$this -> forum_list();
		$this -> display();
	}

	public function set_sort() {
		$val = $_REQUEST["val"];
		$data['home_sort'] = $val;
		$model = D("Config") -> set_config($data);
	}

	protected function mail_list() {
		$user_id = get_user_id();
		$model = D('Mail');

		//获取最新邮件
		$where['user_id'] = $user_id;
		$where['is_del'] = array('eq', '0');
		$where['folder'] = array( array('eq', 1), array('gt', 6), 'or');

		$new_mail_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign('new_mail_list', $new_mail_list);

		//获取未读邮件
		$where['read'] = array('eq', '0');
		$unread_mail_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign('unread_mail_list', $unread_mail_list);
	}

	protected function flow_list() {
		$user_id = get_user_id();
		$model = D('Flow');
		//带审批的列表
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $user_id;
		$where['_string'] = "result is null";
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		
		if (!empty($log_list)) {
			$log_list = rotate($log_list);
			$map['id'] = array('in', $log_list['flow_id']);
			$todo_flow_list = $model -> $where($map) -> field("id,title,create_time") -> select();
			$this -> assign("todo_flow_list", $todo_flow_list);
		}
		//已提交
		$map = array();
		$map['user_id'] = $user_id;
		$map['step'] = array('gt', 10);
		$submit_process_list = $model -> where($map) -> field("id,title,create_time") -> select();
		$this -> assign("submit_flow_list", $submit_process_list);
	}

	protected function doc_list() {
		$user_id = get_user_id();
		$model = D('Doc');
		//获取最新邮件

		$where['is_del'] = array('eq', '0');
		$where['type'] = array('eq', '/doc/common/');
		$common_list = $model -> where($where) -> field("id,name,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("common_list", $common_list);

		$where = array();
		$where['is_del'] = array('eq', '0');
		$where['user_id'] = $user_id;
		$where['type'] = array('eq', '/doc/personal/');
		$personal_list = $model -> where($where) -> field("id,name,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("personal_list", $personal_list);
	}

	protected function schedule_list() {
		$user_id = get_user_id();
		$model = M('Schedule');
		//获取最新邮件
		$start_date = date("Y-m-d");
		$where['user_id'] = $user_id;
		$where['start_date'] = array('egt', $start_date);
		$schedule_list = M("Schedule") -> where($where) -> order('start_date,priority desc') -> limit(6) -> select();
		$this -> assign("schedule_list", $schedule_list);

		$model = M("Todo");
		$where = array();
		$where['user_id'] = $user_id;
		$where['status'] = array("in", "1,2");
		$todo_list = M("Todo") -> where($where) -> order('priority desc,sort asc') -> limit(6) -> select();
		$this -> assign("todo_list", $todo_list);
	}

	protected function notice_list() {
		$model = D('Notice');
		//获取最新邮件

		$where['is_del'] = array('eq', '0');
		$new_notice_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("new_notice_list", $new_notice_list);
	}

	protected function forum_list() {
		$model = D('Forum');
		$where['is_del'] = array('eq', '0');
		$new_forum_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("new_forum_list", $new_forum_list);
	}

}
?>