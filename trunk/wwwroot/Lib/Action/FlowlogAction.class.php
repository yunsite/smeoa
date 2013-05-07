<?php
class FlowLogAction extends CommonAction {
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
		$list = $model -> add();
		if ($list !== false) {//保存成功
			D("Flow") -> next_step($flow_id, $step);
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	public function reject() {
		$this -> insert();
	}
}
?>