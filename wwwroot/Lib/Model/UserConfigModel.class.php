<?php
// 用户模型
class UserConfigModel extends CommonModel {
	function get_config(){
		$config = session('config' . get_user_id());
		if (empty($config)){
			$id=$this->get_user_id();
			$model=M("UserConfig");
			$config= $model->find($id);
			session('config' . get_user_id(), $this -> _config);
		}
		return $config;
	}

	function set_config($data){
		$id=$this->get_user_id();
		$data['id']=$id;
		$model=M("UserConfig");
		$count=$model->where("id=$id")->count();
		if(empty($count)){			
			return $model->add($data);
		}else{
			return $model->save($data);
		}
	}
}
?>