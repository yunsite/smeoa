<?php
// 节点模型
class NodeModel extends CommonModel {
	protected $_validate	=	array(
		array('name','checkNode','节点已经存在',0,'callback'),
		);

	public function checkNode() {
		$map['name']	 =	 $_POST['name'];
		$map['pid']	=	isset($_POST['pid'])?$_POST['pid']:0;
        $map['status'] = 1;
        if(!empty($_POST['id'])) {
			$map['id']	=	array('neq',$_POST['id']);
        }
		$result	=	$this->where($map)->field('id')->find();
        if($result) {
        	return false;
        }else{
			return true;
		}
	}
	
	public function access_list($emp_id){
		$sql="		SELECT distinct c.id, c.pid, c.name, c.url,c.icon ";
		$sql.="		FROM ".$this->tablePrefix."role_user AS a, ".$this->tablePrefix."role_node b, ".$this->tablePrefix."node AS c ";
		$sql.="		WHERE a.role_id = b.role_id and c.status=1 ";
		$sql.="		AND a.user_id =$emp_id ";
		$sql.="		AND c.id = b.node_id  or (c.pid=0  and c.status=1)";
		$sql.="		ORDER BY c.sort ";
		$rs = $this->db->query($sql);
		return $rs;
	}
}
?>