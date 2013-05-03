<?php
class MaterialAction extends CommonAction {
	//过滤查询字段
	private $class;

	public function _initialize(){
		parent::_initialize();
		$this -> class = M("MaterialClass") -> getField('id,name');
	}

	function _filter(&$map){
		$map['status'] = array('eq', '1');
		if (!empty($_POST['keyword'])){
			$map['name|mat_no|letter'] = array('like', "%" . $_POST['keyword'] . "%");
		}else{
			if (!empty($_POST['name'])) {
				$map['name'] = array('like', "%" . $_POST['name'] . "%");
			}
			if (!empty($_POST['spec'])) {
				$map['spec'] = array('like', "%" . $_POST['spec'] . "%");
			}
			if (!empty($_POST['mat_no'])) {
				$map['mat_no'] = array('like', "%" . $_POST['mat_no'] . "%");
			}
			if (!empty($_POST['class'])) {
				$map['class'] = array('eq',$_POST['class']);
			}
		}
		//dump($map);
	}

	function index() {
		$model = D("MaterialView");
		$map = $this -> _search();
		if (method_exists($this, '_filter')){
			$this -> _filter($map);
		}
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this->_assign_class_list();
		$this -> display();
		return;
	}

	protected function _assign_class_list() {
		$model = M("MaterialClass");
		$list = $model ->field("id,pid,name")->select();
		$tree = list_to_tree($list);
		$this -> assign('class_list', dropdown_menu($tree));
	}

	function export(){
		$model = M("Material");
		$model = M("Material");
		$map = $this -> _search();
		if (method_exists($this, '_filter')){
			$this -> _filter($map);
		}
		$list = $model -> where($map) -> select();

		//导入thinkphp第三方类库
		Vendor('Excel.PHPExcel');
	
		$inputFileName = C("SAVE_PATH") . "templete/material.xlsx";
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

		$objPHPExcel -> getProperties() -> setCreator("小薇") -> setLastModifiedBy("小薇") -> setTitle("Office 2007 XLSX Test Document") -> setSubject("Office 2007 XLSX Test Document") -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") -> setKeywords("office 2007 openxml php") -> setCategory("Test result file");
		// Add some data
		$i = 1;
		//dump($list);
		foreach ($list as $val){
			$i++;
			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue("A$i", $val["mat_no"]) -> setCellValue("B$i", $val["name"]) -> setCellValue("C$i", $val["spec"]) -> setCellValue("D$i", $val["unit"]) -> setCellValue("E$i", $val["class"]) -> setCellValue("F$i", $val["buy_price"]) -> setCellValue("G$i", $val["sell_price"]) -> setCellValue("H$i", $val["init_qty"]) -> setCellValue("I$i", $val["min_qty"]) -> setCellValue("J$i", $val["max_qty"]) -> setCellValue("K$i", $val["remark"]);
		}
		// Rename worksheet
		$objPHPExcel -> getActiveSheet() -> setTitle('Material');

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
				$model = M("Material");
				for ($i = 2; $i <= count($sheetData); $i++) {
					$data = array();
					$data['mat_no'] = $sheetData[$i]["A"];
					$data['name'] = $sheetData[$i]["B"];
					$data['letter'] = get_letter($sheetData[$i]["A"]);
					$data['spec'] = $sheetData[$i]["C"];
					$data['unit'] = $sheetData[$i]["D"];
					$data['class'] = $sheetData[$i]["E"];
					$data['buy_price'] = $sheetData[$i]["F"];
					$data['sell_price'] = $sheetData[$i]["G"];
					$data['init_qty'] = $sheetData[$i]["H"];
					$data['min_qty'] = $sheetData[$i]["I"];
					$data['max_qty'] = $sheetData[$i]["J"];
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

	public function mark(){
		$action = $_REQUEST['action'];
		$id = $_REQUEST['material_id'];
		if(!empty($id)){
			switch ($action){
				case 'del' :
					$where['id'] = array('in', $id);
					$field = 'status';
					if ($this -> set_field($id, $field, 0)){
						$this -> ajaxReturn('', "删除成功", 1);
					} else {
						$this -> ajaxReturn('',"删除失败", 1);
					}
					break;
				case 'move_folder' :
					$target_folder = $_REQUEST['val'];
					$where['id'] = array('in', $id);
					$field="class";
					if ($this -> set_field($id, $field, $target_folder)) {
						$this -> ajaxReturn('', "操作成功", 1);
					} else {
						$this -> ajaxReturn('', dump($id,false)."1操作失败", 1);
					}
					break;
				default :
					break;
			}		
		}
	}

	function group_list() {
		$model = D("Class");
		$group_list = $model -> get_list('Material', 'id,name');
		$this -> assign("group_list", $group_list);
	}
	
	function _before_edit(){
		$model = M("MaterialClass");
		$list = $model -> where($where) -> getField('id,name');
		$this -> assign('class_list', $list);
	}

	function insert() {
		$model = D('Material');
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
		$model = D("Material");
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
		if (!empty($_POST['Material_id'])) {
			$model = M("Material");
			$Material_list = $_POST['Material_id'];
			if (!is_array($Material_list)) {
				$Material_list = explode(",", $Material_list);
			}
			$where['id'] = array('in', $Material_list);
			$where['user_id'] = $this -> get_user_id();
			$model -> where($where) -> delete();
			$model = D("Class");
			$result = $model -> del_data_by_obj($_POST['Material_id'], 'Material');
		};
		if ($result !== false) {//保存成功
			$this -> assign('jumpUrl', $this->get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	function json(){
		header("Content-Type:text/html; charset=utf-8");
		$keyword = $_REQUEST['keyword'];

		$model = M("Material");
		$where['mat_no'] = array('like', "%" . $keyword . "%");
		$where['name'] = array('like', "%" . $keyword . "%");
		$where['letter'] = array('like', "%" . $keyword . "%");
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$map['status'] = 1;
		$list = $model -> where($map) -> field('id,name,spec,unit,buy_price,mat_no') -> select();
		exit(json_encode($list));
	}

	public function winpop() {
		$node = M("MaterialClass");
		$menu = array();
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display();
	}
}
?>