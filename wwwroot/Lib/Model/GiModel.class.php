<?php
class GiModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('supplier','require','供应商必须',1),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		array('gi_no','new_gi_no',self::MODEL_INSERT,'callback'),
		);
        
    function new_gi_no(){
        $sql = "SELECT CONCAT(year(now()),'-',LPAD(count(*)+1,4,0)) gi_no FROM `".$this->tablePrefix."gi` WHERE 1 and year(FROM_UNIXTIME(create_time))>=year(now())";       
        $rs = $this->db->query($sql);
        if($rs){
            return $rs[0]['gi_no'];    
        }else{
            return date('Y')."-0001"; 
        }
    }

    function get_wait_sql(){
		$sql="select a.*, b.in_qty,a.order_qty-ifnull(b.in_qty,0) as diff,mat.name as material_name,mat.spec,mat.unit,supplier.name as supplier_name from ";
		$sql.=" (select po.po_no,po.supplier,po_item.mat_no,po_item.qty order_qty,po.po_date,po.user_id,po.user_name,po.remark,po_item.remark item_remark,po.status";
		$sql.=" from ".$this->tablePrefix."po po,".$this->tablePrefix."po_item  po_item";
		$sql.=" where po.po_no=po_item.po_no";
		$sql.=" and po.finish=0";
		$sql.=" and po.status=1";
		$sql.=" )a left join ";
		$sql.=" (select gi.po_no,gi_item.mat_no,sum(in_qty) in_qty";
		$sql.=" from ".$this->tablePrefix."gi gi,".$this->tablePrefix."gi_item gi_item";
		$sql.=" where gi.gi_no=gi_item.gi_no";
		$sql.=" group by gi.po_no,gi_item.mat_no) b";
		$sql.=" on a.po_no=b.po_no and a.mat_no=b.mat_no";
		$sql.=" left join ".$this->tablePrefix."material mat on a.mat_no=mat.mat_no ";
		$sql.=" left join ".$this->tablePrefix."supplier supplier on a.supplier=supplier.id ";
		return $sql;
    }
}
?>