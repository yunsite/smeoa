<?php
// 用户模型
class ConfigModel extends CommonModel {
	function get_config(){
		$id=$this->get_user_id();
		$model=M("Config");
		$data= $model->find($id);
		//dump($model);
		return $data;
	}

	function set_config($data){
		$id=$this->get_user_id();
		$data['id']=$id;
		$model=M("Config");
		$count=$model->where("id=$id")->count();
		if(empty($count)){			
			return $model->add($data);
		}else{
			return $model->save($data);
		}
	}
}
?>