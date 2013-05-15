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
			$user_id = $user_id = get_user_id();
			session_write_close();
			$where['user_id'] = $user_id;
			$where['time'] = array('elt', time()-1);
			$model = M("Push");
			$data = $model -> where($where) -> find();
			$where['id'] = $data['id'];
			//dump($model);
			if ($data){
				sleep(1);
				$model -> where("id=".$data['id'])->delete();
				$this -> ajaxReturn($data['data'],$data['info'],$data['status']);
			} else {
				sleep(2);
			}
		}
		$this -> ajaxReturn(null,"no-data",0);
	}

	function add($status,$info,$data){
		$user_id = get_user_id();
		$model = M("Push");
		$model -> user_id = $user_id;
		$model -> data = $data;
		$model -> status =$status;
		$model -> info = $info;		
		$model -> add();
	}
}
?>