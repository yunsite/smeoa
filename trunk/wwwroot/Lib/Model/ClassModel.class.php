<?php
// 用户模型
class ClassModel extends CommonModel {
	protected $_auto	 =	 array(
		array('status','1'),
	);

	public function get_list($class_type,$field=null,$public=null){
		$where['type']=$class_type;
		$where['status']=1;
		if(empty($public)){
			$user_id=$this->get_user_id();
			$where['user_id']=$user_id;
		}
		if(empty($field)){
			$list=$this->where($where)->select();
		}else{
			$list=$this->where($where)->getfield($field);
		}
		return $list;
	}

	public function get_data_list($class_type,$class_id=null){
		$model=M("ClassData");
		$user_id=$this->get_user_id();
		$where="class.user_id='$user_id' and class.type='$class_type'";
		if(!empty($class_id)){
			$where.=" and class_id=$class_id";
		}
		$join='join '.$this->tablePrefix.'class class on class_id=class.id';
		$list=$model->join($join)->where($where)->field("obj_id,class_id")->select();
	//	echo $model->getLastSql();
		return $list;
	}

	function del_data_by_obj($obj_list,$class_type){
		$model=M("ClassData");
		$where['obj_id']=array('in',$obj_list);
		$where['type']=$class_type;
		$result=$model->where($where)->delete();
		return $result;
	}

	function del_data_by_class($class_list){
		$model=M("ClassData");
		if (is_array($class_list)){
			$class_list=array_filter($class_list);
		}else{
			$class_list=explode(",",$class_list);
		}
		$where['class_id']=array('in',$class_list);
		$result=$model->where($where)->delete();
		return $result;			
	}

	function set_class($obj_list,$class_list,$class_type){
		if(empty($obj_list)){
			return true;
		}
		if(empty($class_list)){
			return true;
		}
		if (is_array($obj_list)){
			$obj_list=array_filter($obj_list);
		}else{
			$obj_list=explode(",",$obj_list);
			$obj_list=array_filter($obj_list);
		}
		$obj_list=implode(",",$obj_list);
		if (is_array($class_list)){
			$class_list=array_filter($class_list);
		}else{
			$class_list=explode(",",$class_list);
			$class_list=array_filter($class_list);
		}
		$class_list=implode(",",$class_list);
		$where = 'a.id in ('.$obj_list.') AND b.id in('.$class_list.')';
		$sql='INSERT INTO '.$this->tablePrefix.'class_data (obj_id,type,class_id) SELECT a.id,b.type,b.id ';
		$sql.=' FROM '.$this->tablePrefix.$class_type.' a, '.$this->tablePrefix.'class b WHERE '.$where;
		$result = $this->execute($sql);
		if($result===false){
			return false;
		}else {
			return true;
		}
	}
}
?>