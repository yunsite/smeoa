<?php
class GiViewModel extends ViewModel {
	public $viewFields=array(
		'Gi'=>array('id','po_no','gi_no','supplier','create_time','status','gi_date','user_id','user_name','remark'),
		'GiItem'=>array('mat_no','in_qty','order_qty','remark'=>'item_remark','_on'=>'Gi.gi_no=GiItem.gi_no'),
		'Supplier'=>array('name'=>'supplier_name','_on'=>'Gi.supplier=Supplier.id'),
		'Material'=>array('name'=>'material_name','spec','unit','_on'=>'GiItem.mat_no=Material.mat_no')
		);
}
?>