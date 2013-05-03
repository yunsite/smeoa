<?php
class FlowModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('title','require','标题必须',1),
		array('content','require','内容必须'),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function')
		);
        
	function  _before_insert(&$data,$options){
		$type=$data["type"];
		$dept_id=$_SESSION['dept_id'];
		$data['dept_id']=$dept_id;

		$doc_no_format=M("FlowType")->where("id=$type")->getField("doc_no_format");
		$short_dept=M("Dept")->where("id=$dept_id")->getField('short');
		$dept_name=M("Dept")->where("id=$dept_id")->getField('name');
		$data['dept_name']=$dept_name;
		$short_flow=M("FlowType")->where("id=$type")->getField('short');

        $sql = "SELECT count(*) count FROM `".$this->tablePrefix."flow` WHERE 1 ";
		if(strpos($doc_no_format,"{SHORT}")!==false) {
			$sql.=" and type=$type ";       
		}
		if(strpos($doc_no_format,"{YY}")!==false) {
			$sql.=" and year(FROM_UNIXTIME(create_time))>=year(now())";       
		}
		if(strpos($doc_no_format,"{YYYY}")!==false){
			$sql.=" and year(FROM_UNIXTIME(create_time))>=year(now())";       
		}
		if(strpos($doc_no_format,"{DEPT}")!==false) {
			$sql.=" and dept_id=".$_SESSION['dept_id'];       
		}
		$rs = $this->db->query($sql);
		$count=$rs[0]['count']+1;

		if(strpos($doc_no_format,"{DEPT}")!==false){
			$doc_no_format=str_replace("{DEPT}",$short_dept,$doc_no_format);
		}
		
		if(strpos($doc_no_format,"{SHORT}")!==false){
			$doc_no_format=str_replace("{SHORT}",$short_flow,$doc_no_format);
		}

		if(strpos($doc_no_format,"{YYYY}")!==false){
			$doc_no_format=str_replace("{YYYY}",date('Y',mktime()),$doc_no_format);
		}	

		if(strpos($doc_no_format,"{YY}")!==false){
			$doc_no_format=str_replace("{YY}",date('y',mktime()),$doc_no_format);
		}
		
		if(strpos($doc_no_format,"{M}")!==false){
			$doc_no_format=str_replace("{M}",date('m',mktime()),$doc_no_format);
		}
		if(strpos($doc_no_format,"{D}")!==false){
			$doc_no_format=str_replace("{D}",date('d',mktime()),$doc_no_format);
		}		
		if(strpos($doc_no_format,"{#}")!==false){
			$doc_no_format=str_replace("{#}",str_pad($count,1,"0",STR_PAD_LEFT),$doc_no_format);
		}	
		if(strpos($doc_no_format,"{##}")!==false){
			$doc_no_format=str_replace("{##}",str_pad($count,2,"0",STR_PAD_LEFT),$doc_no_format);
		}	
		if(strpos($doc_no_format,"{###}")!==false){
			$doc_no_format=str_replace("{###}",str_pad($count,3,"0",STR_PAD_LEFT),$doc_no_format);
		}	
		if(strpos($doc_no_format,"{####}")!==false){
			$doc_no_format=str_replace("{####}",str_pad($count,4,"0",STR_PAD_LEFT),$doc_no_format);
		}	
		if(strpos($doc_no_format,"{#####}")!==false){
			$doc_no_format=str_replace("{#####}",str_pad($count,5,"0",STR_PAD_LEFT),$doc_no_format);
		}	
		if(strpos($doc_no_format,"{######}")!==false){
			$doc_no_format=str_replace("{######}",str_pad($count,6,"0",STR_PAD_LEFT),$doc_no_format);
		}
		$data['doc_no']=$doc_no_format;		
	}

	function _after_insert($data,$options){
		$this->_conv_confirm($data['id'],$data['confirm']);
		if($data['step']==20){
			$this->next_step($data['id'],20);
		}
	}

	function _after_update($data,$options){
		if($data['step']==20){
			$this->_conv_confirm($data['id'],$data['confirm']);
			$this->next_step($data['id'],20);
		}
	}

	function _get_dept($dept_id,$dept_grade) {
		$model=M("Dept");
		$dept=$model->find($dept_id);
		if($dept['dept_grade_id']==$dept_grade){
			return $dept_id;
		}else{
			//dump($dept_id);
			//dump($dept_grade."dg");
			if($dept['pid']!==0){
				return $this->_get_dept($dept['pid'],$dept_grade);
			}
		}
		return false;
	}

	function _conv_confirm($key,$val){
		$arr_confirm=explode("|",$val);
		$str_confirm;
		array_pop($arr_confirm);
		foreach($arr_confirm as $confirm){
			if(strpos($confirm,"dgp")!==false){
				$temp=explode("_",$confirm);
				$dept_grade=$temp[1];
				$position=$temp[2];
				$dept_id=$this->_get_dept($_SESSION['dept_id'],$dept_grade);				

				$model=M("User");
				$where=array();
				$where['dept_id']=$dept_id;
				$where['position_id']=$position;
				$where['status']=1;
				$emp_list=$model->where($where)->select();
				//dump($emp_list);
				$emp_list=rotate($emp_list);
				if(!empty($emp_list)){
					$str_confirm.=implode(",",$emp_list['emp_no'])."|";
				}
			}
			if(strpos($confirm,"dp")!==false){
				$temp=explode("_",$confirm);
				$dept=$temp[1];
				$position=$temp[2];	

				$model=M("User");
				$where=array();
				$where['dept_id']=$dept;
				$where['position_id']=$position;
				$where['status']=1;
				$emp_list=$model->where($where)->select();
				//dump($emp_list);
				$emp_list=rotate($emp_list);

				if(!empty($emp_list)){
					$str_confirm.=implode(",",$emp_list['emp_no'])."|";
				}
			}
			if(strpos($confirm,"dept")!==false){
				$temp=explode("_",$confirm);
				$dept=$temp[1];

				$model=M("User");
				$where=array();
				$where['dept_id']=$dept;
				$where['status']=1;
				$emp_list=$model->where($where)->select();
				$emp_list=rotate($emp_list);
				if(!empty($emp_list)){
					$str_confirm.=implode(",",$emp_list['emp_no'])."|";
				}
			}
			if(strpos($confirm,"emp")!==false){
				$temp=explode("_",$confirm);
				$emp=$temp[1];
					$str_confirm.=$emp."|";
			}
			if(strpos($confirm,"_")==false){			
				$str_confirm.=$confirm."|";
			}
		}
		$model=M("Flow");
		$model->where("id=$key")->setField('confirm',$str_confirm);
		return $str_confirm;
	}

	public function next_step($flow_id,$step){

		$model=M("Flow");
		$model->where("id=$flow_id")->setField('step',$step);

		if(substr($step,0,1)==2){			
			if($this->is_last_confirm($flow_id)) {
				$model->where("id=$flow_id")->setField('step',30);
				$step=30;
			}else{
				$step++;
			}
		}

		if(substr($step,0,1)==3){
			if($this->is_last_consult($flow_id)){				
				$step=40;
			}else{
				$step++;
			}
		}

		if ($step==40){
			$model->where("id=$flow_id")->setField('step',40);
		}else{
			$data['flow_id']=$flow_id;
			$data['step']=$step;
			$data['emp_no']=$this->duty_emp_no($flow_id,$step);
			if(strpos($data['emp_no'],",")!==false){
				$emp_list=explode(",",$data['emp_no']);
				foreach($emp_list as $emp){
					$data['emp_no']=$emp;
					$model=D("FlowLog");
					$model->create($data);
					$model->add();
				}
			}else{
				$model=D("FlowLog");
				$model->create($data);
				$model->add();
			}
		}
	}

	function is_last_confirm($flow_id){
		$confirm=M("Flow")->where("id=$flow_id")->getField("confirm");
		$last_confirm=explode("|",$confirm);
		array_pop($last_confirm);
		$last_confirm_emp_no=end($last_confirm);
		if(strpos($last_confirm_emp_no,$_SESSION["emp_no"])!==false){
			return true;
		}
		return false;
	}

	function is_last_consult($flow_id){
		$consult=M("Flow")->where("id=$flow_id")->getField("consult");
		
		if(empty($consult)){
			return true;
		}
		
		$last_consult=explode("|",$consult);
		
		array_pop($last_consult);
		
		$last_consult_emp_no=end($last_consult);
		if(strpos($last_consult_emp_no,$_SESSION["emp_no"])!==false){
			return true;
		}
		return false;
	}

	function duty_emp_no($flow_id,$step){

		if(substr($step,0,1)==2){
			$confirm=M("Flow")->where("id=$flow_id")->getField("confirm");
			$arr_confirm=explode("|",$confirm);
			array_pop($arr_confirm);
			
			//dump($arr_confirm[fmod($step,10)-1]);die;
			return $arr_confirm[fmod($step,10)-1];
			//dump($arr_confirm);
		}
		if(substr($step,0,1)==3){
			$consult=M("Flow")->where("id=$flow_id")->getField("consult");
			$arr_consult=explode("|",$consult);
			array_pop($arr_consult);
			
			//dump($arr_confirm[fmod($step,10)-1]);die;
			return $arr_consult[fmod($step,10)-1];
			//dump($arr_confirm);
		}
	}
}	
?>