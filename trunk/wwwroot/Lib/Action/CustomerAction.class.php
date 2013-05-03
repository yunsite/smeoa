<?php
class CustomerAction extends CommonAction {
	//过滤查询字段

	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['letter'] = array('like', "%" . $_POST['letter'] . "%");
		$map['status'] = array('eq', '1');
		if (!empty($_POST['group'])) {
			$map['group'] = $_POST['group'];
		}
		$map['status'] = array('eq', '1');
	}

	function index() {
		$model = M("Customer");
		$where['status'] = 1;
		$list = $model -> where($where) -> select();
		$this -> assign('list', $list);
		$group_data = D("Class") -> get_data_list("customer");
		
		$new = array();
		foreach ($group_data as $val) {
			$new[$val['obj_id']] = $new[$val['obj_id']] . $val['class_id'] . ",";
		}
		$this -> assign('group_data', $new);
		$this -> group_list();
		$this -> display();
		return;
	}

	function export(){
		$model = M("Customer");
		$list = $model -> where($where) -> select();

		Vendor('Excel.PHPExcel');
		//导入thinkphp第三方类库

		$inputFileName = C("SAVE_PATH") . "templete/customer.xlsx";
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

		$objPHPExcel -> getProperties() -> setCreator("小薇") -> setLastModifiedBy("小薇") -> setTitle("Office 2007 XLSX Test Document") -> setSubject("Office 2007 XLSX Test Document") -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") -> setKeywords("office 2007 openxml php") -> setCategory("Test result file");
		// Add some data
		$i = 1;
		//dump($list);
		foreach ($list as $val) {
			$i++;
			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue("A$i", $val["name"]) -> setCellValue("B$i", $val["short"]) -> setCellValue("C$i", $val["biz_license"]) -> setCellValue("D$i", $val["payment"]) -> setCellValue("E$i", $val["address"]) -> setCellValue("F$i", $val["salesman"]) -> setCellValue("G$i", $val["contact"]) -> setCellValue("H$i", $val["email"]) -> setCellValue("I$i", $val["office_tel"]) -> setCellValue("J$i", $val["mobile_tel"]) -> setCellValue("J$i", $val["fax"])-> setCellValue("L$i", $val["im"])-> setCellValue("M$i", $val["remark"]);
		}
		// Rename worksheet
		$objPHPExcel -> getActiveSheet() -> setTitle('Customer');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel -> setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $file_name . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter -> save('php://output');
		exit ;
	}

	public function import() {
		$save_path = C('SAVE_PATH');
		$opmode = $_POST["opmode"];
		if ($opmode == "import") {
			import("@.ORG.Util.UploadFile");
			$upload = new UploadFile();
			$upload -> savePath = $save_path;
			$upload -> allowExts = array('xlsx');
			$upload -> saveRule = uniqid;
			$upload -> autoSub = false;

			if (!$upload -> upload()) {
				$this -> error($upload -> getErrorMsg());
			} else {
				//取得成功上传的文件信息
				$uploadList = $upload -> getUploadFileInfo();
				Vendor('Excel.PHPExcel');
				//导入thinkphp第三方类库

				$inputFileName = $save_path . $uploadList[0]["savename"];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel -> getActiveSheet() -> toArray(null, true, true, true);
				$model = M("Customer");
				for ($i = 2; $i <= count($sheetData); $i++) {
					$data = array();
					$data['name'] = $sheetData[$i]["A"];
					$data['short'] = $sheetData[$i]["B"];
					$data['letter'] = get_letter($sheetData[$i]["A"]);
					$data['biz_license'] = $sheetData[$i]["C"];
					$data['payment'] = $sheetData[$i]["D"];
					$data['address'] = $sheetData[$i]["E"];
					$data['salesman'] = $sheetData[$i]["F"];
					$data['contact'] = $sheetData[$i]["G"];
					$data['email'] = $sheetData[$i]["H"];
					$data['office_tel'] = $sheetData[$i]["I"];
					$data['mobile_tel'] = $sheetData[$i]["J"];
					$data['fax'] = $sheetData[$i]["K"];
					$data['im'] = $sheetData[$i]["L"];
					$data['remark'] = $sheetData[$i]["M"];
					$data['statu'] = 1;
					$model -> add($data);
				}
				//dump($sheetData);
				if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/" . $inputFileName)) {
					unlink($_SERVER["DOCUMENT_ROOT"] . "/" . $inputFileName);
				}
				$this -> assign('jumpUrl', $this -> get_return_url());
				$this -> success('导入成功！');
			}
		} else {
			$this -> display();
		}
	}

	function mark() {
		$id = $_REQUEST["id"];
		$val = $_REQUEST["val"];
		$field = 'group';
		$result = $this -> set_field($id, $field, $val);
		if ($result !== false) {
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function group_list() {
		$model = D("Class");
		$group_list = $model -> get_list('Customer', 'id,name', 'public');
		$this -> assign("group_list", $group_list);
	}

	function insert() {
		$ajax = $_POST['ajax'];
		$model = D('Customer');
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> __set('letter', get_letter($model -> __get('name')));
		$model -> __set('user_id', $this -> get_user_id());
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			if ($ajax || $this -> isAjax())
				$this -> ajaxReturn($list, "新增成功", 1);
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function update() {
		$ajax = $_POST['ajax'];
		$id = $_POST['id'];
		$model = D("Customer");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> __set('letter', get_letter($model -> __get('name')));
		// 更新数据
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}

	function del() {
		if (!empty($_POST['customer_id'])) {
			$model = M("Customer");
			$Customer_list = $_POST['customer_id'];
			if (!is_array($Customer_list)) {
				$Customer_list = explode(",", $Customer_list);
			}
			$where['id'] = array('in', $Customer_list);
			$where['user_id'] = $this -> get_user_id();
			$model -> where($where) -> delete();
			$model = D("Class");
			$result = $model -> del_data_by_obj($_POST['customer_id'], 'Customer');
		};
		if ($result !== false) {//保存成功
			if ($ajax || $this -> isAjax())
				$this -> ajaxReturn($list, "操作成功", 1);
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function read() {
		$type = $_REQUEST['type'];
		if ($type != 'inside') {
			$model = M('Customer');
			$id = $_REQUEST[$model -> getPk()];
			$vo = $model -> getById($id);
			$this -> assign('vo', $vo);
			$this -> display();
		} else {
			$User = D("User");
			$User -> viewFields = array('User' => array('id', 'status', 'nickname' => 'name'), 'Dept' => array('name' => 'dept', '_on' => 'User.dept_id =Dept.id', '_type' => 'LEFT'), 'UserInfo' => array('office_tel' => 'office_tel', 'mobile_tel' => 'mobile_tel', 'email' => 'email', 'website' => 'website', 'im' => 'im', '_on' => 'User.id=UserInfo.id'));
			$UserView = $User -> switchModel("View", array("viewFields"));
			$map['User.id'] = array('eq', $_REQUEST['id']);
			$vo = $UserView -> where($map) -> find();
			$this -> assign('accessList', $accessList);
			$this -> assign('vo', $vo);
			$this -> assign('actionName', $type);
			$this -> display('inside_read');
		}
	}

	function set_group() {
		if (!empty($_POST['customer_id'])) {
			$model = D("Class");
			$model -> del_data_by_obj($_POST['customer_id'], 'customer');
			if (!empty($_POST['group'])) {
				$result = $model -> set_class($_POST['customer_id'], $_POST['group'], "customer");
			}
		};
		if (!empty($_POST['new_group'])) {
			$model = M("Class");
			$model -> type = "customer";
			$model -> name = $_POST['new_group'];
			$model -> status = 1;
			$model -> user_id = $this -> get_user_id();
			$new_group_id = $model -> add();
			if (!empty($_POST['customer_id'])) {
				$model = D("Class");
				$result = $model -> set_class($_POST['customer_id'], $new_group_id, "customer");
			}
		};
		if ($result !== false) {//保存成功
			if ($ajax || $this -> isAjax())
				$this -> ajaxReturn($list, "操作成功", 1);
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}
}
?>