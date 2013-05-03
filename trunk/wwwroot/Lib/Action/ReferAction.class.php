<?php
class ReferAction extends CommonAction {
	//过滤查询字段

	function _filter(&$map) {
		if (!empty($_POST['keyword'])) {
			$map['type|name|code'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}
}
?>