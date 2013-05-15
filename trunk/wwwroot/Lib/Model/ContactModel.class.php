<?php
class ContactModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('name','require','姓名必须！',1),
		array('email','email','邮箱格式错误！',2),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		);
	public function get_dept_list($id){
        $dept = tree_to_list(list_to_tree( M("Dept") -> select(), $id));
        $dept = rotate($dept);
        $dept = implode(",", $dept['id']) . ",$id";
        $model = M("User");
        $where['dept_id'] = array('in', $dept);
        $data = $model -> where($where) -> select();
        return $data;		
	}
	
	public function get_detp_list_by_name($name){
		$id = M("Dept") -> getFieldByName($name, "id");
		$this->get_dept_list($id);
	}
}
?>