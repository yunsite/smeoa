<?php
class StaffAction extends CommonAction {
	//过滤查询字段
	private $position;
	private $rank;
	private $dept;

	function _filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['letter'] = array('like', "%" . $_POST['letter'] . "%");
		$map['status'] = array('eq', '1');
		if (!empty($_POST['group'])) {
			$map['group'] = $_POST['group'];
		}
		$map['user_id'] = array('eq', $this -> get_user_id());
	}

	function index() {
		$node = D("Dept");
		$menu = array();
		$menu = $node -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
				
		$model = D("UserView");
		$where['user_id'] = array('eq', $this -> get_user_id());
		$list = $model -> where($where) -> select();
		$this -> assign('list', $list);
		
		$group_data = D("Class") -> get_data_list("contact");
		$new = array();
		foreach ($group_data as $val) {
			$new[$val['obj_id']] = $new[$val['obj_id']] . $val['class_id'] . ",";
		}
		$this -> assign('group_data', $new);
		$this -> group_list();
		$this -> display();
		return;
	}
	
	
	function export() {
		$model = M("Contact");
		$where['user_id'] = array('eq', $this -> get_user_id());
		$list = $model -> where($where) -> select();

		//导入thinkphp第三方类库
		Vendor('Excel.PHPExcel');
	
		$inputFileName = C("SAVE_PATH") . "templete/contact.xlsx";
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

		$objPHPExcel -> getProperties() -> setCreator("小薇") -> setLastModifiedBy("小薇") -> setTitle("Office 2007 XLSX Test Document") -> setSubject("Office 2007 XLSX Test Document") -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") -> setKeywords("office 2007 openxml php") -> setCategory("Test result file");
		// Add some data
		$i = 1;
		//dump($list);
		foreach ($list as $val) {
			$i++;
			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue("A$i", $val["name"]) -> setCellValue("B$i", $val["company"]) -> setCellValue("C$i", $val["dept"]) -> setCellValue("D$i", $val["position"]) -> setCellValue("E$i", $val["office_tel"]) -> setCellValue("F$i", $val["mobile_tel"]) -> setCellValue("G$i", $val["email"]) -> setCellValue("H$i", $val["im"]) -> setCellValue("I$i", $val["website"]) -> setCellValue("J$i", $val["address"]) -> setCellValue("J$i", $val["remark"]);
		}
		// Rename worksheet
		$objPHPExcel -> getActiveSheet() -> setTitle('Contact');

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
				$model = M("Contact");
				for ($i = 2; $i <= count($sheetData); $i++) {
					$data = array();
					$data['name'] = $sheetData[$i]["A"];
					$data['company'] = $sheetData[$i]["B"];
					$data['letter'] = get_letter($sheetData[$i]["A"]);
					$data['dept'] = $sheetData[$i]["C"];
					$data['position'] = $sheetData[$i]["D"];
					$data['email'] = $sheetData[$i]["G"];
					$data['office_tel'] = $sheetData[$i]["E"];
					$data['mobile_tel'] = $sheetData[$i]["F"];
					$data['website'] = $sheetData[$i]["I"];
					$data['im'] = $sheetData[$i]["H"];
					$data['address'] = $sheetData[$i]["J"];
					$data['user_id'] = $this -> get_user_id();
					$data['remark'] = $sheetData[$i]["K"];
					$data['status'] = 1;
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
		if ($result == true) {
			$this -> success("操作成功");
		}
	}

	function group_list() {
		$model = D("Class");
		$group_list = $model -> get_list('contact', 'id,name');
		$this -> assign("group_list", $group_list);
	}

	function insert() {
		$model = D('Contact');
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> __set('letter', get_letter($model -> __get('name')));
		$model -> __set('user_id', $this -> get_user_id());
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
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
		$model = D("Contact");
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
		if (!empty($_POST['contact_id'])) {
			$model = M("Contact");
			$contact_list = $_POST['contact_id'];
			if (!is_array($contact_list)) {
				$contact_list = explode(",", $contact_list);
			}
			$where['id'] = array('in', $contact_list);
			$where['user_id'] = $this -> get_user_id();
			$model -> where($where) -> delete();
			$model = D("Class");
			$result = $model -> del_data_by_obj($_POST['contact_id'], 'contact');
		};
		if ($result !== false) {//保存成功
			$this -> assign('jumpUrl', $this->get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function read() {
		$type = $_REQUEST['type'];
		if ($type != 'inside') {
			$model = M('Contact');
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
			$this -> assign('vo', $vo);
			$this -> assign('actionName', $type);
			$this -> display('inside_read');
		}
	}

	function set_group() {
		if (!empty($_POST['contact_id'])) {
			$model = D("Class");
			$model -> del_data_by_obj($_POST['contact_id'], 'contact');
			if (!empty($_POST['group'])) {
				$result = $model -> set_class($_POST['contact_id'], $_POST['group'], "contact");
			}
		};
		if (!empty($_POST['new_group'])) {
			$model = M("Class");
			$model -> type = "contact";
			$model -> name = $_POST['new_group'];
			$model -> status = 1;
			$model -> user_id = $this -> get_user_id();
			$new_group_id = $model -> add();
			if (!empty($_POST['contact_id'])) {
				$model = D("Class");
				$result = $model -> set_class($_POST['contact_id'], $new_group_id, "contact");
			}
		};
		if ($result !== false) {//保存成功
			if ($ajax || $this -> isAjax())
				$this -> ajaxReturn($list, dump($_POST['group'], false) . "操作成功", 1);
			$this -> assign('jumpUrl', $this->get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function ajaxRead() {
		$id = $_REQUEST['id'];
		$model = M("Dept");
		$dept = tree_to_list(list_to_tree( M("Dept") -> select(), $id));
		$dept = rotate($dept);
		$dept = implode(",", $dept['id']) . ",$id";

		$model = D("UserView");
		$where['dept_id'] = array('in', $dept);
		$data = $model -> where($where) -> select();
		$this -> ajaxReturn($data, "", 1);
	}

	function popup_contact() {
		$model = M("Dept");
		$list = array();
		$list = $model -> field('id,pid,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_company', popup_tree_menu($list));

		$model = M("Rank");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_rank', popup_tree_menu($list));

		$model = M("Position");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_position', popup_tree_menu($list));

		$model = D("Class");

		$group_list = $model -> get_list("contact", "id,name,pid");
		$group_list = array_merge($group_list, array( array("id" => "#", "name" => "未分组")));
		$this -> assign("list_personal", popup_tree_menu($group_list));

		$this -> assign('type', 'rank');
		$this -> display();
		return;
	}

	function popup_auth() {

		$model = M("Dept");
		$list = array();
		$list = $model -> field('id,pid,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_company', popup_tree_menu($list));

		$model = M("Rank");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_rank', popup_tree_menu($list));

		$model = M("Position");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_position', popup_tree_menu($list));

		$this -> assign('type', 'rank');
		$this -> display();
		return;
	}

	function popup_actor() {

		$model = M("Dept");
		$list = array();
		$list = $model -> field('id,pid,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_company', popup_tree_menu($list));

		$model = M("Rank");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_rank', popup_tree_menu($list));

		$model = M("Position");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_position', popup_tree_menu($list));

		$this -> assign('type', 'rank');
		$this -> display();
		return;
	}

	function popup_confirm() {

		$model = M("Dept");
		$list = array();
		$list = $model -> field('id,pid,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_company', popup_tree_menu($list));

		$model = M("Rank");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_rank', popup_tree_menu($list));

		$model = M("Position");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_position', popup_tree_menu($list));

		$this -> assign('type', 'rank');
		$this -> display();
		return;
	}

	function popup_flow(){
		$model = M("DeptGrade");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_dept_grade', sub_tree_menu($list));

		$model = M("Dept");
		$list = array();
		$list = $model -> field('id,pid,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_dept', sub_tree_menu($list));

		$model = M("Position");
		$list = array();
		$list = $model -> field('id,name') -> order('sort asc') -> select();
		$list = list_to_tree($list);
		$this -> assign('list_position', sub_tree_menu($list));

		$this -> assign('type', 'dgp');
		$this -> display();
		return;
	}

	function json(){
		header("Content-Type:text/html; charset=utf-8");
		$key = $_REQUEST['key'];
		$ajax = $_REQUEST['ajax'];
		//dump($ajax);

		$model = M("User");
		$where['emp_name'] = array('like', "%" . $key . "%");
		$where['letter'] = array('like', "%" . $key . "%");
		$where['email'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$company = $model -> where($where) -> field('id,emp_name as name,email') -> select();

		$where = array();
		$model = M("Contact");
		$where['name'] = array('like', "%" . $key . "%");
		$where['letter'] = array('like', "%" . $key . "%");
		$where['email'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$map['email'] = array('neq', '');
		$map['user_id'] = array('eq', $this -> get_user_id());
		$personal = $model -> where($map) -> field('id,name,email') -> select();

		if (empty($company)) {
			$company = array();
		}
		if (empty($personal)) {
			$personal = array();
		}
		$contact = array_merge_recursive($company, $personal);
		exit(json_encode($contact));
	}

	function json2() {
		header("Content-Type:text/html; charset=utf-8");
		$key = $_REQUEST['key'];
		$ajax = $_REQUEST['ajax'];
		//dump($ajax);

		$model = M("User");
		$where['emp_name'] = array('like', "%" . $key . "%");
		$where['letter'] = array('like', "%" . $key . "%");
		$where['email'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$company = $model -> where($where) -> field('id,emp_name as name,email,emp_no') -> select();

		if (empty($company)) {
			$company = array();
		}
		if (empty($personal)) {
			$personal = array();
		}
		$contact = array_merge_recursive($company, $personal);
		exit(json_encode($contact));
	}
}
?>