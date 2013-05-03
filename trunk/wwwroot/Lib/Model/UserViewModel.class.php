<?php
class UserViewModel extends ViewModel {
	public $viewFields=array(
		'User'=>array('id','emp_no','emp_name'=>'name','letter','dept_id','position_id','rank_id','email','duty','office_tel','mobile_tel','pic'),
		'Position'=>array('name'=>'position_name','_on'=>'Position.id=User.position_id'),
		'Rank'=>array('name'=>'rank_name','_on'=>'Rank.id=User.rank_id'),
		'Dept'=>array('name'=>'dept_name','_on'=>'Dept.id=User.dept_id')
		);
}
?>