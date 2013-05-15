<?php
class PoModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('supplier','require','供应商必须',1),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('is_del','0',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		array('po_no','new_po_no',self::MODEL_INSERT,'callback'),
		);
        
    function new_po_no(){
        $sql = "SELECT CONCAT(year(now()),'-',LPAD(count(*)+1,4,0)) po_no FROM `".$this->tablePrefix."po` WHERE 1 and year(FROM_UNIXTIME(create_time))>=year(now())";       
        $rs = $this->db->query($sql);
        if($rs){
            return $rs[0]['po_no'];    
        }else{
            return date('Y')."-0001"; 
        }               
    }
}
?>