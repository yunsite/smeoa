<?php
class PushAction extends CommonAction {
	//过滤查询字段
	function server(){
		for ($i = 0, $timeout = 10; $i < $timeout; $i++ )
		{
			if(connection_status()!=0){
				exit();
			}
			$where=array();
			$user_id = $user_id = $this -> get_user_id();
			session_write_close();
			$where['user_id'] = $user_id;
			$where['time'] = array('lt', time());
			$model = M("Push");
			$data = $model -> where($where) -> find();
			$where['id'] = $data['id'];
			//dump($model);
			if ($data) {
				$model -> where("id=".$data['id'])->delete();
				$this -> ajaxReturn($data['data'],$data['info'],$data['status']);
			} else {
				sleep(2);
			}
		}
		$this -> ajaxReturn(null,"no-data",0);
	}

	function add($status,$info,$data) {
		$user_id = $this -> get_user_id();
		$model = M("Push");
		$model -> user_id = $user_id;
		$model -> data = $data;
		$model -> status =$status;
		$model -> info = $info;		
		$model -> add();
	}
}
?>