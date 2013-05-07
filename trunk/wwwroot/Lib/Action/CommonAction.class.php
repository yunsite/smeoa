<?php
class CommonAction extends Action {
	public $_list_rows;
	public $_search;
	public $_config;

	function _initialize(){
		$user_id = $this -> _session(C('USER_AUTH_KEY'));
		if (!$user_id) {
			//跳转到认证网关
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		if (!$this -> _check_node_auth()) {
			$this -> error("没有权限");
		}
		$this -> _assign_left_menu();
		$this -> _get_config();
	}

	public function index() {
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$name = $this -> getActionName();
		$model = D($name);

		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
	}

	function add() {
		$this -> display();
	}

	function read() {
		$this -> edit();
	}

	function edit() {
		$name = $this -> getActionName();
		$model = M($name);
		$id = $_REQUEST[$model -> getPk()];
		$vo = $model -> getById($id);
		if (isset($vo['add_file'])) {
			$this -> _assign_file_list($vo["add_file"]);
		};
		$this -> assign('vo', $vo);
		$this -> display();
	}

	function ajaxRead() {
		$name = $this -> getActionName();
		$model = M($name);
		$id = $_REQUEST[$model -> getPk()];
		$data = $model -> getById($id);
		if ($data !== false) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	function save() {
		$opmode = $_POST["opmode"];
		if ($opmode == "add") {
			$this -> insert();
		}
		if ($opmode == "edit") {
			$this -> update();
		}
	}

	function insert() {
		$name = $this -> getActionName();
		$model = D($name);
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = $this -> _session("user_name");
		};
		//保存当前数据对象
		$list = $model -> add();
		if ($list !== false) {//保存成功
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	function update() {
		$name = $this -> getActionName();
		$model = D($name);
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		// 更新数据
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}

	protected function _get_config() {
		$config = session('config' . get_user_id());
		if (!empty($config)) {
			$this -> _config = $config;
		} else {
			$this -> _config = D("Config") -> get_config();
			session('config' . get_user_id(), $this -> _config);
		}
	}

	protected function get_list_rows() {
		return $this -> _config['list_rows'];
	}

	protected function set_list_rows($num) {
		$this -> _list_rows = $num;
	}

	protected function _get_return_url() {
		$return_url = cookie('return_url');
		if (!empty($return_url)) {
			return $return_url;
		} else {
			return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
		}
	}

	protected function _set_return_url($url) {
		cookie('return_url', $url);
	}

	/**
	 确认是否有权限进入相应的菜单
	 +----------------------------------------------------------
	 */
	protected function _check_node_auth() {
		$access_list = session('menu' . get_user_id());
		$access_list = rotate($access_list);
		$access_list = $access_list['url'];
		$access_list = array_map("get_module", $access_list);
		$access_list = array_unique($access_list);
		$access_list = array_filter($access_list);
		$public_list=array('Push',"Login","Home","Index","File");
		if (in_array(MODULE_NAME, $public_list)) {
			return true;
		} else {
			$result = in_array(strtolower(MODULE_NAME), $access_list);
		}
		return $result;
	}

	protected function _assign_left_menu() {
		$top_menu = cookie('top_menu');
		$user_id = get_user_id();

		$model = M("Node");
		$top_menu_list = session('top_menu' . $user_id);

		if (!empty($top_menu_list)) {
			$list = $top_menu_list;
		} else {
			if ($this -> _session('administrator')) {
				$where = array('status' => 1, 'pid' => 0, );
			} else {
				$where = array('status' => 1, 'pid' => 0, 'id' => array('neq', 84));
			}
			$list = $model -> where($where) -> order('sort asc') -> getField('id,name,url');
			session('top_menu' . $user_id, $list);
		}

		$this -> assign('list_top_menu', $list);

		if (!empty($top_menu)) {
			$this -> assign("top_menu_name", $model -> where("id=$top_menu") -> getField('name'));
		}

		if ($user_id) {
			if (session('menu' . $user_id)) {
				//如果已经缓存，直接读取缓存
				$menu = session('menu' . $user_id);
			} else {
				//读取数据库模块列表生成菜单项
				$menu = D("Node") -> access_list($user_id);
				$common_list = D("Folder") -> get_common_list();
				$personal_list = D("Folder") -> get_person_list();
				$menu = array_merge($common_list, $personal_list, $menu);
				//缓存菜单访问
				session('menu' . $user_id, $menu);
			}
			$tree = list_to_tree($menu, $top_menu);
			$this -> assign('html_left_menu', left_menu($tree));
		}
	}

	protected function _assign_folder_list($folder, $public) {
		$model = D("Folder");
		$list = $model -> get_list($folder, $public);
		$tree = list_to_tree($list);
		$this -> assign('folder_list', dropdown_menu($tree));
	}

	protected function _assign_file_list($add_file) {
		$files = explode(';', $add_file);
		$where['id'] = array('in', $files);
		$model = M("File");
		$list = $model -> where($where) -> select();
		$this -> assign('file_list', $list);
	}

	/**
	 +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $name 数据对象名称
	 +----------------------------------------------------------
	 * @return HashMap
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	protected function _search($name = '', $view = false) {
		//生成查询条件
		$map = array();
		$request = array_filter(array_keys(array_filter($_REQUEST)), "filter_search_field");
		if (empty($name)) {
			$name = $this -> getActionName();
		}
		$model = D($name);
		if ($view) {
			$fields = get_view_fields($model);
		} else {
			$fields = $model -> getDbFields();
		}

		foreach ($request as $val) {
			if ($check) {
				if (!in_array(substr($val, 3), $fields)) {
					continue;
				}
			}
			if (substr($val, 0, 3) == "be_") {
				if (isset($_REQUEST["en_" . substr($val, 3)])) {
					if (strpos($val, "date")) {
						$map[substr($val, 3)] = array( array('egt', date_to_int(trim($_REQUEST[$val]))), array('elt', date_to_int(trim($_REQUEST["en_" . substr($val, 3)]))));
					}
					if (strpos($val, "time")) {
						$map[substr($val, 3)] = array( array('egt', trim($_REQUEST[$val])), array('elt', trim($_REQUEST["en_" . substr($val, 3)])));
					}
				}
			}
			if (substr($val, 0, 3) == "li_") {
				$map[substr($val, 3)] = array('like', '%' . trim($_REQUEST[$val]) . '%');
			}
			if (substr($val, 0, 3) == "eq_") {
				$map[substr($val, 3)] = array('eq', trim($_REQUEST[$val]));
			}
			if (substr($val, 0, 3) == "gt_") {
				$map[substr($val, 3)] = array('egt', trim($_REQUEST[$val]));
			}
			if (substr($val, 0, 3) == "lt_") {
				$map[substr($val, 3)] = array('elt', trim($_REQUEST[$val]));
			}
		}
		$this -> _search = $map;
		return $map;
	}

	/**
	 +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	protected function _list($model, $map, $sortBy = '', $asc = false) {
		//排序字段 默认为主键名
		if (isset($_REQUEST['_order'])) {
			$order = $_REQUEST['_order'];
		} else {
			$order = !empty($sortBy) ? $sortBy : $model -> getPk();
		}
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset($_REQUEST['_sort'])) {
			$sort = $_REQUEST['_sort'] ? 'asc' : 'desc';
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}
		//取得满足条件的记录数

		$count = $model -> where($map) -> count($model -> pk);
		if ($count > 0) {
			import("@.ORG.Util.Page");
			//创建分页对象
			if (!empty($_REQUEST['listRows'])) {
				$listRows = $_REQUEST['listRows'];
			} else {
				$listRows = $this -> get_list_rows();
			}
			$p = new Page($count, $listRows);
			//分页查询数据
			$voList = $model -> where($map) -> order("`" . $order . "` " . $sort) -> limit($p -> firstRow . ',' . $p -> listRows) -> select();

			$p -> parameter = $this -> _search;
			//分页显示
			$page = $p -> show();
			//列表排序显示
			$sortImg = $sort;
			//排序图标
			$sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列';
			//排序提示
			$sort = $sort == 'desc' ? 1 : 0;
			//排序方式
			//模板赋值显示

			$name = $this -> getActionName();
			$this -> assign('list', $voList);
			$this -> assign('sort', $sort);
			$this -> assign('order', $order);
			$this -> assign('sortImg', $sortImg);
			$this -> assign('sortType', $sortAlt);
			$this -> assign("page", $page);
		}
		return;
	}

	function pushReturn($status, $info, $data, $time = null) {
		$user_id = get_user_id();
		$model = M("Push");
		$model -> user_id = $user_id;
		$model -> data = $data;
		$model -> status = $status;
		$model -> info = $info;
		if (empty($time)) {
			$model -> time = time();
		} else {
			$model -> time = $time;
		}
		$model -> add();
		exit();
	}

	/**
	 +----------------------------------------------------------
	 * 更新个别字段值
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	function set_field($id, $field, $val, $admin = false, $name = '') {
		if (empty($name)) {
			$name = $this -> getActionName();
		}
		$model = M($name);
		if (!empty($model)) {
			$pk = $model -> getPk();
			if (isset($id)) {
				if (is_array($id)) {
					$where[$pk] = array("in", $id);
				} else {
					$where[$pk] = array('in', explode(',', $id));
				}
				if (in_array('user_id', $model -> getDbFields()) && !$admin) {
					$where['user_id'] = array('eq', get_user_id());
				};
				$list = $model -> where($where) -> setField($field, $val);
				if ($list !== false) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	function get_field($id, $field, $admin = false, $name = '') {
		if (empty($name)) {
			$name = $this -> getActionName();
		}
		$model = M($name);
		if (!empty($model)) {
			$pk = $model -> getPk();
			if (isset($id)) {
				if (is_array($id)) {
					$where[$pk] = array("in", $id);
				} else {
					$where[$pk] = array('in', explode(',', $id));
				}
				if (in_array('user_id', $model -> getDbFields()) && !$admin) {
					$where['user_id'] = array('eq', get_user_id());
				};
				$list = $model -> where($where) -> getField($field);
				return $list;
			} else {
				return false;
			}
		}
	}

	function del_add_file($id, $name = '', $admin = false) {
		if (empty($name)) {
			$name = $this -> getActionName();
		}

		$model = M($name);
		if (!empty($model)) {
			$pk = $model -> getPk();
			if (empty($id)) {
				$id = $_REQUEST[$pk];
			}

			if (isset($id)) {
				if (is_array($id)) {
					$where[$pk] = array("in", $id);
				} else {
					$where[$pk] = array('in', explode(',', $id));
				}

				if (in_array('user_id', $model -> getDbFields()) && !$admin) {
					$where['user_id'] = array('eq', get_user_id());
				};

				$model -> where($where) -> setField('status', 0);
				$list = $model -> where($where) -> getField("id,add_file");
				$str_list = implode($list);

				$file_list = explode(";", $str_list);
				$file_list = array_filter($file_list);

				$model = M("File");
				$where = array();
				$where['id'] = array('in', $file_list);

				$model -> where($where) -> setField('status', 0);
				$list = $model -> where($where) -> select();
				$save_path = C('SAVE_PATH');

				foreach ($list as $file) {
					if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/" . $save_path . $file['savename'])) {
						unlink($_SERVER["DOCUMENT_ROOT"] . "/" . $save_path . $file['savename']);
					}
				}
				if ($list !== false) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

}
?>