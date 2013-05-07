<?php
class PsiAction extends CommonAction {
	//过滤查询字段

	function _filter(&$map) {
		if (!empty($_POST['keyword'])) {
			$map['type|name|code'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	public function index() {
		$config = D("Config") -> get_config();
		$this -> assign("home_sort", $config['home_sort']);
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
		$where['status'] = array('eq', '1');
		$where['folder'] = array( array('eq', 1), array('gt', 6), 'or');

		$new_mail_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign('new_mail_list', $new_mail_list);

		//获取未读邮件
		$where['read'] = array('eq', '0');
		$unread_mail_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign('unread_mail_list', $unread_mail_list);
	}

	protected function process_list() {
		$user_id = get_user_id();
		$model = D('Process');
		//带审批的列表
		$ProcessLog = M("ProcessLog");
		$where['emp_no'] = $user_id;
		$where['_string'] = "result is null";
		$log_list = $ProcessLog -> where($where) -> field('process_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['process_id']);
			$todo_process_list = $model -> $where($map) -> field("id,title,create_time") -> select();
			$this -> assign("todo_process_list", $todo_process_list);
		}
		//已提交
		$map = array();
		$map['user_id'] = $user_id;
		$map['step'] = array('gt', 10);
		$submit_process_list = $model -> where($map) -> field("id,title,create_time") -> select();
		$this -> assign("submit_process_list", $submit_process_list);
	}

	protected function doc_list() {
		$user_id = get_user_id();
		$model = D('Doc');
		//获取最新邮件

		$where['status'] = array('eq', '1');
		$where['type'] = array('eq', '/doc/common/');
		$common_list = $model -> where($where) -> field("id,name,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("common_list", $common_list);

		$where = array();
		$where['status'] = array('eq', '1');
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

		$where['status'] = array('eq', '1');
		$new_notice_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("new_notice_list", $new_notice_list);
	}

	protected function forum_list() {
		$model = D('Forum');
		$where['status'] = array('eq', '1');
		$new_forum_list = $model -> where($where) -> field("id,title,create_time") -> order("create_time desc") -> limit(6) -> select();
		$this -> assign("new_forum_list", $new_forum_list);
	}
}
?>