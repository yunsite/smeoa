<?php
class ForumModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('title','require','标题必须',1),
		array('content','require','内容必须'),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		);        
}	
?>