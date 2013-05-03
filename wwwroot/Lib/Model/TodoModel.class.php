<?php
// 用户模型
class TodoModel extends CommonModel {
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
	);
}
	
?>