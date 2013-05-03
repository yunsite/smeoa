<?php
class PoViewModel extends ViewModel {
	public $viewFields=array(
		'Po'=>array('id','po_no','supplier','create_time','status','po_date','user_id','user_name','remark','type','payment'),
		'PoItem'=>array('mat_no','qty','price','sum','remark'=>'item_remark','_on'=>'Po.po_no=PoItem.po_no'),
		'Supplier'=>array('name'=>'supplier_name','_on'=>'Po.supplier=Supplier.id'),
		'Material'=>array('name'=>'material_name','spec','unit','_on'=>'PoItem.mat_no=Material.mat_no')
		);
}
?>