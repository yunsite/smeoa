<?php
// 用户模型
class DocFolderModel extends CommonModel {
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
	);
	public function get_common_list(){
		$sql="		SELECT CONCAT('df_',a.id) as id,a.name,CONCAT('df_',a.pid) as pid,CONCAT('/doc/folder/fid/',a.id) as url";
		$sql.="		FROM ".$this->tablePrefix."doc_folder AS a";
		$sql.="		WHERE  is_del=0 and type='common' ";
		$sql.="		ORDER BY a.sort ";
		$rs = $this->db->query($sql);
		$list=array();
		foreach($rs as $val){
			if ($val["pid"]=='df_0'){
				$val["pid"]=C('DOC_FOLDER_PID');
			}
			$list[]=$val;
		}
		return $list;
	}

	public function get_person_list($user_id){
		$sql="		SELECT CONCAT('dp_',a.id) as id,a.name,CONCAT('dp_',a.pid) as pid,CONCAT('/doc/person/fid/',a.id) as url";
		$sql.="		FROM ".$this->tablePrefix."doc_folder AS a";
		$sql.="		WHERE  is_del=0 and type='person' and user_id=$user_id ";
		$sql.="		ORDER BY a.sort ";
		$rs = $this->db->query($sql);
		$list=array();
		foreach($rs as $val){
			if ($val["pid"]=='dp_0'){
				$val["pid"]=C('DOC_PERSON_PID');
			}
			$list[]=$val;
		}
		return $list;
	}
}
?>