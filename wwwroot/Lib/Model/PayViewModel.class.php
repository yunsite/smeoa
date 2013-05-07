<?php
class PayViewModel extends ViewModel{
	public $viewFields=array(
		'Pay'=>array('id','po_no','gi_no','prepay','payable','supplier','create_time','status','paid','paid_time'),
		'Supplier'=>array('name'=>'supplier_name','_on'=>'Pay.supplier=Supplier.id'),
		);
	protected $fields=array('id','po_no','gi_no');
}
?>