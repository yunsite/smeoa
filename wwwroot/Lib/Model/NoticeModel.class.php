<?php
class NoticeModel extends CommonModel {
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
		array('notice_no','new_notice_no',self::MODEL_INSERT,'callback'),
		);
        
    function new_notice_no(){
        $sql = "SELECT CONCAT(year(now()),'-',LPAD(count(*)+1,4,0)) notice_no FROM `".$this->tablePrefix."notice` WHERE 1 and year(FROM_UNIXTIME(create_time))>=year(now())";     
        $rs = $this->db->query($sql);
        if($rs){
            return $rs[0]['notice_no'];    
        }else{
            return date('Y')."-0001"; 
        }               
    }
}	
?>