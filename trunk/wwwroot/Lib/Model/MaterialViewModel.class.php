<?php
class MaterialViewModel extends ViewModel {
	public $viewFields=array(
		'Material'=>array('id','letter','mat_no','name','spec','unit','buy_price','sell_price','class','init_qty','min_qty','max_qty','user_id','user_name','is_del','create_time','update_time'),
		'MaterialClass'=>array('name'=>'class_name','_on'=>'Material.class=MaterialClass.id')
		);
}
?>