<?php
// +----------------------------------------------------------------------
// | SMEOA [ 专注小微企业信息化 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.smeoa.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: smeoa <smeoa@qq.com>
// +----------------------------------------------------------------------

class LoginAction extends Action {
	// 检查用户是否登录

	public function index() {
		//如果通过认证跳转到首页
		//redirect(__APP__);
		if (!$this -> _session(C('USER_AUTH_KEY'))) {
			$this -> display();
		} else {
			redirect(__APP__);
		}
	}

	// 用户登出
	public function logout() {
		if ($this -> _session(C('USER_AUTH_KEY'))) {
			session(C('USER_AUTH_KEY'), null);
			//die();
			$this -> assign("jumpUrl", __URL__ . '/');
			$this -> success('登出成功！');
		} else {
			$this -> assign("jumpUrl", __URL__ . '/');
			$this -> error('已经登出！');
		}
	}

	// 登录检测
	public function check_login() {
		if (empty($_POST['emp_no'])) {
			$this -> error('帐号必须！');
		} elseif (empty($_POST['password'])) {
			$this -> error('密码必须！');
		}
		//生成认证条件
		$map = array();
		// 支持使用绑定帐号登录
		$map['emp_no'] = $_POST['emp_no'];
		$map["status"] = array('gt', 0);
		$model=M(C('USER_AUTH_MODEL'));
		$authInfo = $model->where($map)->find();
		//使用用户名、密码和状态的方式进行认证
		if (false === $authInfo) {
			$this -> error('帐号或密码错误！');
		} else {
			if ($authInfo['password'] != md5($_POST['password'])) {
				$this -> error('帐号或密码错误！');
			}
			session('[start]');
			session(C('USER_AUTH_KEY'), $authInfo['id']);
			session('emp_no', $authInfo['emp_no']);
			session('email', $authInfo['email']);
			session('user_name', $authInfo['emp_name']);
			session('last_login_time', $authInfo['last_login_time']);
			session('login_count', $authInfo['login_count']);
			session('dept_id', $authInfo['dept_id']);

			if ($authInfo['emp_no'] == 'admin') {
				session('administrator', true);
			}

			//读取数据库模块列表生成菜单项
			$menu = D("Node") -> access_list($authInfo['id']);

			//缓存菜单访问
			session('menu' . $authInfo['id'], $menu);
			//保存登录信息
			$User = M('User');
			$ip = get_client_ip();
			$time = time();
			$data = array();
			$data['id'] = $authInfo['id'];
			$data['last_login_time'] = $time;
			$data['login_count'] = array('exp', 'login_count+1');
			$data['last_login_ip'] = $ip;
			$User -> save($data);
			$this -> assign('jumpUrl', U("index/index"));
			$this -> success('登录成功！');
		}
	}

	// 更换密码
	public function change_pwd() {
		$this -> checkUser();
		//对表单提交处理进行处理或者增加非表单数据
		//if(md5($_POST['verify'])	!= $_session['verify']) {
		//	$this->error('验证码错误！');
		//}
		$map = array();
		$map['password'] = pwdHash($_POST['oldpassword']);
		if (isset($_POST['account'])) {
			$map['account'] = $_POST['account'];
		} elseif (($this -> get_user_id())) {
			$map['id'] = $this -> get_user_id();
		}
		//检查用户
		$User = M("User");
		if (!$User -> where($map) -> field('id') -> find()) {
			$this -> error('旧密码不符或者用户名错误！');
		} else {
			$User -> password = pwdHash($_POST['password']);
			$User -> save();
			$this -> assign('jumpUrl', $this -> get_return_url());
			$this -> success('密码修改成功！');
		}
	}

	public function profile() {
		$this -> checkUser();
		$User = M("User");
		$vo = $User -> getById($this -> get_user_id());
		$this -> assign('vo', $vo);
		$this -> display();
	}

	public function verify() {
		$type = isset($_GET['type']) ? $_GET['type'] : 'gif';
		import("@.ORG.Util.Image");
		Image::buildImageVerify(4, 1, $type);
	}

}
?>