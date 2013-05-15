<?php
// 用户模型
class ReferModel extends CommonModel {
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
	);

	public function get_data($type){
		$where['type']=$type;
		$where['is_del']=1;
		$list=$this->where($where)->getField('code,name');
		return $list;
	}
}
	
?>