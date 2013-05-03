<?php
// 用户模型
class UserModel extends CommonModel {
	public $_validate	=	array(
		array('account','/^[a-z]\w{3,}$/i','帐号格式错误'),
		array('password','require','密码必须'),
		array('nickname','require','昵称必须'),
		array('repassword','require','确认密码必须'),
		);

	public $_auto		=	array(
		array('password','pwdHash',self::MODEL_BOTH,'callback'),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		);

	protected function pwdHash() {
		if(isset($_POST['password'])) {
			return pwdHash($_POST['password']);
		}else{
			return false;
		}
	}

	function get_user_list($keyword='')
	{		
		$sql= " SELECT user .* , dept.name AS dept_name, position.name AS position_name, rank.name AS rank_name";
		$sql.= " FROM ".$this->tablePrefix."user AS user";
		$sql.= " LEFT JOIN ".$this->tablePrefix."position AS position ON user.position_id = position.id";
		$sql.= " LEFT JOIN ".$this->tablePrefix."rank AS rank ON user.rank_id = rank.id";
		$sql.= " LEFT JOIN ".$this->tablePrefix."dept dept ON user.dept_id = dept.id";
		$sql.= " WHERE 1=1 ";
		if(!empty($keyword)){
			$sql.= " and (user.emp_no like '%$keyword%' or user.emp_name like '%$keyword%') ";
		}
		$rs = $this->db->query($sql);
		return $rs;
	}
	function get_user($emp_no)
	{		
		$sql= " SELECT user .* , dept.name AS dept_name, position.name AS position_name, rank.name AS rank_name";
		$sql.= " FROM ".$this->tablePrefix."user AS user";
		$sql.= " LEFT JOIN ".$this->tablePrefix."position AS position ON user.position_id = position.id";
		$sql.= " LEFT JOIN ".$this->tablePrefix."rank AS rank ON user.rank_id = rank.id";
		$sql.= " LEFT JOIN ".$this->tablePrefix."dept dept ON user.dept_id = dept.id";
		$sql.= " WHERE 1=1 ";
		$sql.= " and user.emp_no='$emp_no' ";
		$rs = $this->db->query($sql);
		return $rs[0];
	}
}
?>