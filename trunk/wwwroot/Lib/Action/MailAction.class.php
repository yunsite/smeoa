<?php
class MailAction extends CommonAction {
	public $config;
	private $tmpPath = "data";

	// 过滤查询字段

	function _filter(&$map){
		$map['is_del'] = array('eq', '0');
		$map['user_id'] = array('eq', get_user_id());
		if (!empty($_POST['from'])) {
			$map['from'] = array('like', '%' . $_POST['from'] . '%');
		}
		if (!empty($_REQUEST['keyword']) && empty($map['title'])) {
			$this -> _set_search("keyword", $_POST['keyword']);
			$map['title'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	//--------------------------------------------------------------------
	//   邮件首页
	//--------------------------------------------------------------------
	public function index(){
		$this->redirect('/mail/mail_list?folder=inbox');
	}
	//--------------------------------------------------------------------
	// mailbox 1. 收件箱		folder=1
	// mailbox 2. 已发送		folder=2
	// mailbox 3. 草稿箱		folder=3
	// mailbox 4. 已删除		folder=4
	// mailbox 5. 垃圾邮件	folder=5
	// mailbox 6. 永久删除	is_del=1
	//--------------------------------------------------------------------

	public function mail_list() {
		$folder = $_GET['folder'];
		$fid = $_GET['fid'];
		if (empty($folder)) {
			$folder = "user";
		}
		$user_id = get_user_id();
		$this -> _assign_mail_folder_list();

		$model = D('Mail');
		$where = $this -> _search();
		if (method_exists($this, '_filter')){
			$this -> _filter($where);
		}
		if ($folder == "receve"){
			$this -> assign("receve", true);
			$folder = "inbox";
			cookie('left_menu',101);
		}
		$this -> assign("folder", $folder);

		switch ($folder){
			case 'inbox' :
				$where['folder'] = array("eq", '1');
				if (!empty($model)) {
					$this -> _list($model, $where, "create_time");
				}
				$this -> assign("folder_name", '收件箱');
				$this -> display();
				break;
			case 'outbox' :
				$where['folder'] = array("eq", '2');
				if (!empty($model)) {
					$this -> _list($model, $where, "create_time");
				}
				$this -> assign("folder_name", '已发送');
				$this -> display();
				break;
			case 'darftbox' :
				$where['folder'] = array("eq", '3');
				if (!empty($model)) {
					$this -> _list($model, $where);
				}
				$this -> assign("folder_name", '草稿箱');
				$this -> display();
				break;
			case 'delbox' :
				$where['folder'] = array("eq", '4');
				if (!empty($model)) {
					$this -> _list($model, $where);
				}
				$this -> assign("folder_name", '已删除');
				$this -> display();
				break;
			case 'spambox' :
				$where['folder'] = array("eq", '5');
				if (!empty($model)) {
					$this -> _list($model, $where);
				}
				$this -> assign("folder_name", '垃圾箱');
				$this -> display();
				break;
			case 'unread' :
				$where['read'] = array("eq", '0');
				if (!empty($model)) {
					$this -> _list($model, $where);
				}
				$this -> assign("folder_name", '未读邮件');
				$this -> display();
				break;
			case 'all' :
				if (!empty($model)) {
					$this -> _list($model, $where);
				}
				$this -> assign("folder_name", '全部邮件');
				$this -> display();
				break;
			case 'user' :
				$fid = $_GET["fid"];
				$where['folder'] = array('eq', $fid);
				if (!empty($model)) {
					$this -> _list($model, $where);
				}

				$where = array();
				$where['user_id'] = array('eq', $user_id);
				$where['id'] = array('eq', $fid);

				$folder_name = M("Folder") -> where($where) -> getField("name");
				$this -> assign("folder_name", $folder_name);
				$this -> display();
			default :
				break;
		}
	}

	//--------------------------------------------------------------------
	// mailbox 1. 收件箱		folder=1
	// mailbox 2. 已发送		folder=2
	// mailbox 3. 草稿箱		folder=3
	// mailbox 4. 已删除		folder=4
	// mailbox 5. 垃圾邮件	folder=5
	// mailbox 6. 永久删除	is_del=1
	//--------------------------------------------------------------------
	public function mark(){
		$action = $_REQUEST['action'];
		$id = $_REQUEST['mail_id'];
		switch ($action) {
			case 'del' :
				$field = 'folder';
				$val = 4;
				$result= $this -> set_field($id, $field, $val);
				break;
			case 'del_forever' :
				$field = 'is_del';
				$val = 1;	
				$this -> del_add_file($id);
				$result=$this -> set_field($id, $field, $val);
				break;
			case 'spam' :
				$field = 'folder';
				$val = 5;
				$result= $this -> set_field($id, $field, $val);
				break;
			case 'readed' :
				$field = 'read';
				$val = 1;
				$result=$this -> set_field($id, $field, $val);
				break;
			case 'unread' :
				$field = 'read';
				$val = 0;
				$result= $this -> set_field($id, $field, $val);
				break;
			case 'darft' :
				$field = 'folder';
				$val = 3;
				$result=$this -> set_field($id, $field, $val);
				break;
			case 'move_folder' :
				$field = 'folder';
				$val = $_REQUEST['val'];
				$result= $this -> set_field($id, $field, $val);
				break;
			default :
				break;
		}
		if ($result !== false) {
			$this -> assign('jumpUrl', $this -> _get_return_url());
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	public function upload() {
		R("File/upload");
	}

	public function down(){
		$attach_id = $_REQUEST["attach_id"];
		R("File/down", array($attach_id));
	}

	//--------------------------------------------------------------------
	//  写邮件
	//--------------------------------------------------------------------
	public function add() {
		if ($this -> _check_mail_account() == false) {
			return;
		}
		$this -> assign("recent", $this -> _get_recent());
		//添加最近联系人
		$this -> display();
	}

	private function organize(&$model) {

		$where['user_id'] = get_user_id();
		$where['is_del'] = 0;
		$list = M("MailOrganize") -> where($where) -> order('sort') -> select();

		foreach ($list as $val) {
			//包含

			if (($val['sender_check'] == 1) && ($val['sender_option'] == 1) && (strpos($model -> from, $val['sender_key']) !== false)) {
				$model -> folder = $val['to'];
				return;
			}
			//不包含
			if (($val['sender_check'] == 1) && ($val['sender_option'] == 0) && (strpos($model -> from, $val['sender_key']) == false)) {
				$model -> folder = $val['to'];
				return;
			}

			if (($val['domain_check'] == 1) && ($val['domain_option'] == 1) && (strpos($model -> from, $val['domain_key']) !== false)) {
				$model -> folder = $val['to'];
				return;
			}
			//不包含
			if (($val['domain_check'] == 1) && ($val['domain_option'] == 0) && (strpos($model -> from, $val['domain_key']) == false)) {
				$model -> folder = $val['to'];
				return;
			}

			if (($val['recever_check'] == 1) && ($val['recever_option'] == 1) && (strpos($model -> to, $val['recever_key']) !== false)) {
				$model -> folder = $val['to'];
				return;
			}
			//不包含
			if (($val['recever_check'] == 1) && ($val['recever_option'] == 0) && (strpos($model -> to, $val['recever_key']) == false)) {
				$model -> folder = $val['to'];
				return;
			}

			if (($val['title_check'] == 1) && ($val['title_option'] == 1) && (strpos($model -> title, $val['title_key']) !== false)) {
				$model -> folder = $val['to'];
				return;
			}
			//不包含
			if (($val['title_check'] == 1) && ($val['title_option'] == 0) && (strpos($model -> title, $val['title_key']) == false)) {
				$model -> folder = $val['to'];
				return;
			}
		}
	}

	//--------------------------------------------------------------------
	//  读取邮箱用户数据
	//--------------------------------------------------------------------
	private function _check_mail_account() {
		if (empty($this -> config)) {
			$user_id = get_user_id();
			$model = M('MailAccount');
			$list = $model -> field('mail_name,email,pop3svr,smtpsvr,mail_id,mail_pwd') -> find($user_id);
			if (empty($list['mail_name']) || empty($list['email']) || empty($list['pop3svr']) || empty($list['smtpsvr']) || empty($list['mail_id']) || empty($list['mail_pwd'])) {
				$this -> error("请设置邮箱帐号", "/mailaccount");
				return;
			} else {
				$this -> config = $list;
			}
		}
		return $this -> config;
	}

	//--------------------------------------------------------------------
	//  显示自定义文件夹
	//--------------------------------------------------------------------
	public  function _assign_mail_folder_list(){
		$model = D("Folder");
		$list = $model -> get_list("mail/mail_list", 2);
		$system_folder = array( array("id" => 1, "name" => "收件箱"), array("id" => 2, "name" => "已发送"));
		$list = array_merge($system_folder, $list);
		$tree = list_to_tree($list);
		$this -> assign('folder_list', dropdown_menu($tree));
		$temp=tree_to_list($tree);
		return $temp;
	}

	//--------------------------------------------------------------------
	//   显示邮件内容
	//--------------------------------------------------------------------
	public function read(){

		$model = M('Mail');
		$id = $_REQUEST['id'];
		$where['id'] = array('eq', $id);
		$where['user_id'] = array('eq', get_user_id());

		$model -> where($where) -> setField('read', '1');

		$vo = $model -> getById($id);
		$this -> assign('vo', $vo);
		$this -> _assign_mail_folder_list();
		$this -> _assign_file_list($vo['add_file']);
		$this -> _assign_next_link($id);
		$this -> display();
	}

	//--------------------------------------------------------------------
	//   回复，转发邮件内容
	//--------------------------------------------------------------------
	public function reply() {

		$type = $_REQUEST['type'];
		if ($type == "reply") {
			$prefix = "回复";
		}
		if ($type == "all") {
			$prefix = "回复";
		}
		if ($type == "forward") {
			$prefix = "转发";
		}
		$this -> assign('prefix', $prefix);

		$model = M('Mail');
		$id = $_REQUEST['id'];
		$where['id'] = array('eq', $id);
		$where['user_id'] = array('eq', get_user_id());
		$model -> where($where) -> setField('read', '1');

		$vo = $model -> getById($id);
		$this -> assign('type', $type);
		$this -> assign('vo', $vo);
		$this -> display();
	}


	//--------------------------------------------------------------------
	//   操作成功页面
	//--------------------------------------------------------------------
	private function _sucess() {
		$this -> display("sucess");
	}

	//--------------------------------------------------------------------
	//   上一封 下一封
	//--------------------------------------------------------------------
	private function _assign_next_link($id) {
		$folder_id = M('Mail') -> where("id=$id") -> getField('folder');
		$create_time = M('Mail') -> where("id=$id") -> getField('create_time');

		$model = M("Mail");

		$where['folder'] = array("eq", $folder_id);
		$where['_string'] = "create_time>$create_time";
		$where['user_id'] = array('eq', get_user_id());

		$prev = $model -> where($where) -> field("id,title") -> order('create_time asc') -> limit('1') -> select();
		if ($prev) {
			$prev_id = $prev[0]["id"];
			$title = $prev[0]["title"];
			$url = U('mail/read?id=' . $prev_id);
			$prev_html = "<a id=\"prev_link\" class=\"btn\" href=\"$url\" title=\"$title\">上一封</a>";
		} else {
			$prev_html = "<a class=\"btn disabled\" onclick=\"javascript:return false;\">上一封</a>";
		}

		$where = array();
		$where['folder'] = array("eq", $folder_id);
		$where['_string'] = "create_time<$create_time";
		$where['user_id'] = array('eq', get_user_id());

		$next = $model -> where($where) -> field("id,title") -> order('create_time desc') -> limit('1') -> select();

		if ($next) {
			$next_id = $next[0]["id"];
			$title = $next[0]["title"];
			$url = U('mail/read?id=' . $next_id);
			$next_html = "<a id=\"next_link\" class=\"btn\" href=\"$url\" title=\"$title\">下一封</a>";
		} else {
			$next_html = "<a class=\"disabled btn\" onclick=\"javascript:return false;\">下一封</a>";
		}
		$html = $prev_html . $next_html;
		$this -> assign('next_link', $html);
	}

	//--------------------------------------------------------------------
	//   下载邮件附件，返回文件ID
	//--------------------------------------------------------------------
	private function _real_file($str) {
		//$str = "47;49;50;";
		$files = explode(';', $str);
		if (count($files) > 1) {
			foreach ($files as $file) {
				if (strlen($file) > 2) {
					$fileId = $fileId . ($file) . ",";
				}
			}
			$fileId = substr($fileId, 0, strlen($fileId) - 1);
			$model = M("File");
			$File = $model -> field("name,savename") -> select($fileId);
			return $File;
		}
		return array();
	}

	//--------------------------------------------------------------------
	//   接收邮件
	//--------------------------------------------------------------------
	public function receve(){
		$new = 0;
		if ($this -> _check_mail_account() == false) {
			$this -> ajaxReturn(1, "请设置邮箱帐号", 0);
			die();
		}
		$user_id = get_user_id();
		session_write_close();
		vendor("Mail.class#receve2");
		$mail_list = array();
		$mail = new receiveMail();
		$connect = $mail -> connect($this -> config['pop3svr'], '110', $this -> config['mail_id'], $this -> config['mail_pwd'], 'INBOX', 'pop3');
		$mail_count = $mail -> mail_total_count();
		if ($connect){
			for ($i = 1; $i < $mail_count; $i++){
				$mail_id = $mail_count - $i+1;
				$item = $mail -> mail_list($mail_id);
				$where = array();
				$where['user_id'] = $user_id;
				$where['mid'] = $item[$mail_id];
				$count = M('Mail') -> where($where) -> count();
				if (empty($item[$mail_id])) {//mid 空时当成新邮件处理
					$count = 0;
				}
				if ($count == 0){
					$new++;
					$model = M("Mail");
					$model -> create($mail -> mail_header($mail_id));
					if ($model -> create_time < strtotime(date('y-m-d h:i:s')) - 86400 * 30) {
						$mail -> close_mail();
						$this -> pushReturn($new, "收到" . $new . "封邮件", 1);
					}
					$model -> user_id = $user_id;
					$model -> read = 0;
					$model -> folder = 1;
					$model -> is_del = 0;
					$str = $mail -> get_attach($mail_id, $this -> tmpPath);
					$model -> add_file = $this -> _receive_file($str, $model);
					$this -> organize($model);
					$model -> add();
				} else {
					$mail -> close_mail();
					if($new==0){
						$this -> pushReturn($new, "没有新邮件", 1);	
					}
				}
			}
		}
		$mail -> close_mail();
		$this -> pushReturn($new, "收到" . $new . "封邮件", 1);	
		//$this -> ajaxReturn($new, "收到" . $new . "封邮件", 1);
	}

	//--------------------------------------------------------------------
	//   接收邮件附件
	//--------------------------------------------------------------------
	private function _receive_file($str, &$model) {

		if (!empty($str)) {
			$ar = explode(",", $str);
			foreach ($ar as $key => $value) {
				$ar2 = explode("_", $value);
				$cid = $ar2[0];
				$inline = $ar2[1];
				$file_name = $ar2[2];
				$File = M("File");
				$File -> name = $file_name;
				$File->user_id=$this->get_user_id();
				$File -> size = filesize($this -> tmpPath . urlencode($value));
				$File -> extension = getExt($value);
				$File -> create_time = time();
				$dir = 'mail/' . date("Ym");
				$File -> savename = $dir . '/' . uniqid() . '.' . $File -> extension;
				$save_name = $File -> savename;
				if (!is_dir(C("SAVE_PATH") . $dir)) {
					mkdir(C("SAVE_PATH"). $dir, 0777, true);
				}
				if (rename($this -> tmpPath . urlencode($value),C("SAVE_PATH"). $File -> savename)) {
					$file_id = $File -> add();
					if ($inline == "INLINE") {
						$model -> content = str_ireplace("cid:$cid", "/" .C("SAVE_PATH") . $save_name, $model -> content);
					}
					$add_file = $add_file . ($file_id) . ';';
				}
			}
		}
		return $add_file;
	}

	//--------------------------------------------------------------------
	//   保存草稿箱
	//--------------------------------------------------------------------
	public function set_darft() {
		if ($this -> _check_mail_account() == false) {
			return;
		}
		$model = D('Mail');
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> __set('user_id', get_user_id());
		$model -> __set('folder', 3);
		$model -> __set('from', $this -> config['mail_name'] . '|' . $this -> config['email']);
		$model -> __set('reply_to', $this -> config['mail_name'] . '|' . $this -> config['email']);
		if (empty($_POST["id"])) {
			$list = $model -> add();
		} else {
			$list = $model -> save();
		}
		if ($list) {
			$this -> assign('jumpUrl', U('main/mail_list?folder=darftbox'));
			$this -> success("操作成功");
		} else {
			$this -> error("操作失败");
		};
	}

	//--------------------------------------------------------------------
	//  获取最近联系人
	//--------------------------------------------------------------------
	private function _get_recent() {
		$model = M("Recent");
		$user_id = get_user_id();
		return $model -> where("user_id=$user_id") -> getField("recent");
	}

	//--------------------------------------------------------------------
	//  设置最近联系人
	//--------------------------------------------------------------------
	private function _set_recent($address_list) {
		$user_id = get_user_id();
		$data["user_id"] = $user_id;
		$model = M("Recent");
		$recent = $model -> where("user_id=$user_id") -> getField("recent");

		if (!empty($recent)) {
			$address_list = implode(";", array_unique(array_filter(explode(";", $address_list . $recent, 20), "not_dept")));
			//保留20个数据
			$recent = $model -> where("user_id=$user_id") -> setField("recent", $address_list);
		} else {
			$address_list = implode(";", array_unique(array_filter(explode(";", $address_list, 20), "not_dept")));
			//保留20个数据
			if (!empty($address_list)) {
				$model -> user_id = $user_id;
				$model -> recent = $address_list;
				$model -> add();
			}
		}
	}

	//--------------------------------------------------------------------
	//  发送邮件
	//--------------------------------------------------------------------
	public function send() {
		$ajax = $_POST['ajax'];
		if ($this -> _check_mail_account() == false) {
			$this -> assign('jumpUrl', U('config'));
			$this -> error("请设置邮箱", $ajax);
			return;
		}
		$title = $_REQUEST['title'];
		$body = $_REQUEST['content'];
		$add_file = $_REQUEST['add_file'];

		$to = $_REQUEST['to'];
		$cc = $_REQUEST['cc '];
		$bcc = $_REQUEST['bcc '];

		$this -> _set_recent($to . $cc . $bcc);

		//header('Content-type:text/html;charset=utf-8');
		vendor("Mail.class#send");
		//从PHPMailer目录导入class.send.php类文件
		$mail = new PHPMailer(true);
		// the true param means it will throw exceptions on errors, which we need to catch
		$mail -> IsSMTP();
		// telling the class to use SMTP
		try {
			$mail -> Host = $this -> config['smtpsvr'];
			//"smtp.qq.com"; // SMTP server 部分邮箱不支持SMTP，QQ邮箱里要设置开启的
			$mail -> SMTPDebug = false;
			// 改为2可以开启调试
			$mail -> SMTPAuth = true;
			// enable SMTP authentication
			$mail -> Port = 25;
			// set the SMTP port for the GMAIL server
			$mail -> CharSet = "UTF-8";
			// 这里指定字符集！解决中文乱码问题
			$mail -> Encoding = "base64";
			$mail -> Username = $this -> config['mail_id'];
			// SMTP account username
			$mail -> Password = $this -> config['mail_pwd'];
			// SMTP account password
			$mail -> SetFrom($this -> config['email'], $this -> config['mail_name']);
			//发送者邮箱
			$mail -> AddReplyTo($this -> config['email'], $this -> config['mail_name']);
			//回复到这个邮箱

			$arrtmp = explode(';', $to);
			foreach ($arrtmp as $item) {
				if (strlen($item) > 6) {
					if (strpos($item, "dept@group")) {
						$dept_name = explode('|', $item);
						$dept_name = rtrim($dept_name[0]);
						$mail_list = D('Contact') -> get_detp_list_by_name($dept_name);
						foreach ($mail_list as $val) {
							$mail -> AddAddress($val["email"], $val["emp_name"]);
							// 收件人
						}
					} else {
						$tmp = explode('|', $item);

						$mail -> AddAddress($tmp[1], $tmp[0]);
						// 收件人
					}
				}
			}

			$arrtmp = explode(';', $cc);
			if (strlen($item) > 6) {
				foreach ($arrtmp as $item) {
					if (strpos($v, "dept@group")) {
						$dept_name = explode('|', $item);
						$mail_list = $this -> _get_dept_address_list($dept_name);
						foreach ($mail_list as $val) {
							$mail -> AddCC($val["emp_name"], $val["email"]);
							// 收件人
						}
					} else {
						$tmp = explode('|', $item);
						$mail -> AddCC($tmp[1], $tmp[0]);
						// 收件人
					}
				}
			}

			foreach ($arrtmp as $item) {
				if (strlen($item) > 6) {
					if (strpos($v, "dept@group")) {
						$dept_name = explode('|', $item);
						$mail_list = $this -> _get_dept_address_list($dept_name);
						foreach ($mail_list as $val) {
							$mail -> AddBCC($val["emp_name"], $val["email"]);
							// 收件人
						}
					} else {
						$tmp = explode('|', $item);
						$mail -> AddBCC($tmp[1], $tmp[0]);
						// 收件人
					}
				}
			}

			$mail -> Subject = "=?UTF-8?B?" . base64_encode($title) . "?=";
			//嵌入式图片处理
			if (preg_match('/\/data\/files\/\d{6}\/.{14}(jpg|gif|png)/', $body, $images)) {
				$i = 1;
				foreach ($images as $image) {
					if (strlen($image) > 20) {
						$cid = 'img' . ($i++);
						$name = $mail -> AddEmbeddedImage(substr($image, 1), $cid);
						$body = str_replace($image, "cid:$cid", $body);
					}
				}
			}

			$mail -> MsgHTML($body);

			if (strlen($add_file) > 2) {
				$files = $this -> _real_file($add_file);
				foreach ($files as $file) {
					$mail -> AddAttachment(C("SAVE_PATH"). $file['savename'], $file['name']);
				}
			}

			$model = D('Mail');
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			$model -> __set('user_id', get_user_id());
			$model -> __set('folder', 2);
			$model -> __set('read', 1);
			$model -> __set('from', $this -> config['mail_name'] . '|' . $this -> config['email']);
			$model -> __set('reply_to', $this -> config['mail_name'] . '|' . $this -> config['email']);
			if (empty($_POST["id"])) {
				$list = $model -> add();
			} else {
				$model -> __set('create_time', time());
				$list = $model -> save();
			}

			if ($mail -> Send()) {
				cookie("left_menu",105);
				$this -> assign('jumpUrl', U('mail/mail_list?folder=outbox'));
				$this -> success("发送成功");
			} else {
				$this -> error($mail -> ErrorInfo);
			};
		} catch (phpmailerException $e) {
			echo $e -> errorMessage();
			//Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e -> getMessage();
			//Boring error messages from anything else!
		}
	}
}
?>