<?php
class PostAction extends CommonAction {

	//过滤查询字段
	function _filter(&$map) {
		$map['title'] = array('like', "%" . $_POST['title'] . "%");
		$map['user_name'] = array('like', "%" . $_POST['user_name'] . "%");
		$map['content'] = array('like', "%" . $_POST['content'] . "%");
		$map['status'] = array('eq', '1');
	}

	public function del() {
		$id = $_POST['id'];
		$user_id = get_user_id();
		$post_user_id = M("Post") -> where($where) -> getfield('user_id');
		if ($user_id == $post_user_id) {
			$field = "status";
			$this -> set_field($id, $field, 0);
		} else {
			$this -> ajaxReturn($arr, "删除失败", 1);
		}
	}
}
