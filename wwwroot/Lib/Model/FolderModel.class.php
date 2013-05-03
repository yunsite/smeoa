<?php
class FolderModel extends CommonModel {
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
	);
	public function get_list($folder,$public){		
		$where['folder']=$folder;
		$where['status']=1;
		if($public==2){
			$user_id=$this->get_user_id();
			$where['user_id']=$user_id;
		}
        $list = $this ->where($where) -> order("sort") -> Field('id,name,pid') -> select();
		return $list;
	}

	public function get_common_list(){
		$sql="		SELECT CONCAT('fid_',a.id) as id,a.name,a.folder,a.sort,CONCAT('fid_',a.pid) as pid,CONCAT(a.folder,'?fid=',a.id) as url";
		$sql.="		FROM ".$this->tablePrefix."folder AS a";
		$sql.="		WHERE  status=1 and public=1 ";
		$sql.="		ORDER BY a.folder,a.sort ";
		$rs = $this->db->query($sql);
		$list=array();
		foreach($rs as $val){
			if ($val["pid"]=='fid_0'){
				$where['sub_folder']=$val['folder'];
				$pid=M("Node")->where($where)->getField('id');
				$val["pid"]=$pid;
			}
			$list[]=$val;
		}
		return $list;
	}

	public function get_person_list(){
		$user_id=$this->get_user_id();
		$sql="		SELECT CONCAT('fid_',a.id) as id,a.name,a.folder,CONCAT('fid_',a.pid) as pid,CONCAT(a.folder,'?fid=',a.id) as url";
		$sql.="		FROM ".$this->tablePrefix."folder AS a";
		$sql.="		WHERE  status=1 and public=2 and user_id=$user_id ";
		$sql.="		ORDER BY a.folder,a.sort ";
		$rs = $this->db->query($sql);
		$list=array();
		foreach($rs as $val){
			if ($val["pid"]=='fid_0'){
				$where['sub_folder']=$val['folder'];
				$pid=M("Node")->where($where)->getField('id');
				$val["pid"]=$pid;
			}
			$list[]=$val;
		}
		return $list;
	}

	public function _get_folder_auth($folder_id){				 
		$user_id=$this->get_user_id();		
		$auth_list=M("Folder")->where("id=$folder_id")->Field('user_id,public')->find();
		if (($auth_list['user_id']==$user_id)&&($auth_list['public']==2)){
			return array('admin'=>true,"write"=>true,"read"=>true);
		}
		$auth_list=M("Folder")->where("id=$folder_id")->Field('admin,write,read')->find();
		
		$result= array_map(array("FolderModel","_check_auth"),$auth_list);
		
		if ($result['admin']==true){
			$result['write']=true;				
		}
		if ($result['write']==true){
			$result['read']=true;			
		}
		return $result;			
	}
	
	private function _check_auth($auth_list){
			$arrtmp = explode(';', $auth_list);					
			foreach ($arrtmp as $item) {
				if (strlen($item) > 2) {
					if (stripos($item, "dept_")!==false){
						$arr_dept = explode('|', $item);
						$dept_id=substr($arr_dept[1],5);
						
						$emp_list =D("Contact")->get_dept_list($dept_id);
						$emp_list=rotate($emp_list);		
						if (in_array($_SESSION['emp_no'],$emp_list["emp_no"])){
							return true;
						}
					} else {
						if (stripos($item,$_SESSION['emp_no'])){
							return true;
						}
					}
				}
			}
			return false;		
	}
}
?>