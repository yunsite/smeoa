<?php
// 用户模型
class ReferModel extends CommonModel {
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
	);

	public function get_data($type){
		$where['type']=$type;
		$where['status']=1;
		$list=$this->where($where)->getField('code,name');
		return $list;
	}
}
	
?>