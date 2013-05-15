<?php
// 用户模型
class TodoModel extends CommonModel {
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
	);
}
	
?>