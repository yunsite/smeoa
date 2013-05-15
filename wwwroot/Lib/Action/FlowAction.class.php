<?php
class FlowAction extends CommonAction {

	private $_flow_type;
	//过滤查询字段

	public function _initialize() {
		parent::_initialize();
		$model = D('FlowType');
		$where['is_del']=0;
		//$this -> _flow_type = $model -> where($where) -> getField('id,name');
	}

	function _filter(&$map) {
		$map['is_del'] = array('eq', '0');
	}

	public function upload() {
		R("File/upload");
	}

	function index() {
		$this -> group_list();

		$model = M('FlowType');
		if (!empty($_POST['group'])) {
			$where['group'] = $_POST['group'];
			if ($where['group'] == "全部") {
				$where=array();
			}
		}

		$where['is_del'] = 0;
		$list = $model -> where($where) -> select();
		$this -> assign("list", $list);
		$this -> display();
	}

	function flow_list() {
		$folder = $_REQUEST['folder'];
		$this -> assign("folder", $folder);
		$emp_no = $_SESSION['emp_no'];
		$user_id = get_user_id();

		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}

		switch ($folder) {
			case 'confirm' :
				$this -> assign("folder_name", '待审批');
				$FlowLog = M("FlowLog");
				$where['emp_no'] = $emp_no;
				$where['_string'] = "result is null";
				$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
				$log_list = rotate($log_list);
				if (!empty($log_list)) {
					$map['id'] = array('in', $log_list['flow_id']);
				} else {
					$this -> display();
					return;
				}
				break;
			case 'darft' :
				$this -> assign("folder_name", '草稿箱');
				$map['user_id'] = $user_id;
				$map['step'] = 10;
				break;
			case 'submit' :
				$this -> assign("folder_name", '已提交');

				$map['user_id'] = $user_id;
				$map['step'] = array('gt', 10);
				break;
			case 'finish' :
				$this -> assign("folder_name", '已办理');
				$FlowLog = M("FlowLog");
				$where['emp_no'] = $emp_no;
				$where['_string'] = "result is not null";
				$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
				$log_list = rotate($log_list);
				if (!empty($log_list)) {
					$map['id'] = array('in', $log_list['flow_id']);
				} else {
					$this -> display();
					return;
				}
				break;
			default :
				break;
		}
		$model = M("Flow");
		$this -> _list($model, $map);
		$this -> display();
	}

	function new_count() {
		$user_id = get_user_id();
		$model = M("FlowLog");
		$where['emp_no'] = $_SESSION['emp_no'];
		$where['_string'] = "result is null";
		$where['is_del'] = 0;
		return $model -> where($where) -> count('id');
	}

	function group_list() {
		$model = M("FlowType");
		$where['group'] = array("neq", "");
		$group_list = $model -> where($where) -> distinct("group") -> field("group") -> select();

		$group_list = rotate($group_list);
		$group_list = array_combine($group_list["group"], $group_list["group"]);
		$this -> assign("group_list", $group_list);
	}

	function add() {
		$type = $_REQUEST['type'];
		$model = M("FlowType");
		$flow_type = $model -> find($type);
		$this -> assign('confirm_name', $flow_type['confirm_name']);
		$this -> assign("flow_type", $flow_type);
		$this -> display();
	}

	function read() {
		$this -> edit();
	}

	function edit() {
		$model = D("Flow");

		$id = $_REQUEST['id'];
		$vo = $model -> getById($id);
		$this -> assign('vo', $vo);
		if (in_array('add_file', $model -> getDbFields())) {
			$this ->_assign_file_list($vo["add_file"]);
		};		
		$model = M("FlowType");
		$type = $vo['type'];
		$flow_type = $model -> find($type);
		$this -> assign("flow_type", $flow_type);

		$model = M("FlowLog");

		$where['flow_id'] = $id;
		$where['_string'] = "result is not null";
		$flow_log = $model -> where($where) -> select();

		$this -> assign("flow_log", $flow_log);

		$where = array();
		$where['flow_id'] = $id;
		$where['emp_no'] = $_SESSION['emp_no'];
		$where['_string'] = "result is null";
		$confirm = $model -> where($where) -> select();
		$this -> assign("confirm", $confirm[0]);
		$this -> display();
	}

	public function approve() {
		$model = D("FlowLog");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> result = 1;
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};

		$flow_id = $model -> flow_id;
		$step = $model -> step;
		//保存当前数据对象
		$list = $model -> save();
		$model = D("FlowLog");
		$model -> where("step=$step and flow_id=$flow_id and result is null") -> setField('is_del',1);

		if ($list !== false) {//保存成功
			D("Flow") -> next_step($flow_id, $step);
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	public function reject() {
		$model = D("FlowLog");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> result = 0;
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};

		$flow_id = $model -> flow_id;
		$step = $model -> step;
		//保存当前数据对象
		$list = $model -> save();
		//可以裁决的人有多个人的时候，一个人评价完以后，禁止其他人重复裁决。
		$model = D("FlowLog");
		$model -> where("step=$step and flow_id=$flow_id and result is null") -> setField('is_del',1);

		if ($list !== false) {//保存成功
			D("Flow") -> where("id=$flow_id") -> setField('step', 0);
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}
	public function down() {
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}
}
