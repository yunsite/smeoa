<?php
class FlowLogModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function')
		);      
}
?>