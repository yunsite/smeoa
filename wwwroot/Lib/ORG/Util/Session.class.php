<?php
define('PREFIX', 'smeoa');
define('SESS_LEFETIME', 3600);
define('ZIP_FLAG', 0);

class Session {
	public $key;
	  public static function get_instance()
	  {
			static $session = null;
			if ($session == null)				
			$session = new Session();
			return $session;
	  }

		private $Memcache;
		/* 构造函数
		 * @param string @login_user
		 * @param int @login_type
		 * @param string $login_sess
		 */

		 function __construct(){
		
		$config['host'] = '127.0.0.1';  
		$config['port'] = 11211;  
		
        if (!class_exists('Memcache') || !function_exists('memcache_connect')) {
            exit("Can't load Memcache Extendstion");
        }
        $this->Memcache = new Memcache;
        if (!@$this->Memcache->connect($config['host'], $config['port'])) {
            exit('连接失败');
        }
        $this->setCookie();
        return TRUE;
    }

    /* 增加键值
     * return bool
     */

    public function add($key, $data='empty') {
        if (!$this->Memcache->add($key, $data, ZIP_FLAG, SESS_LEFETIME)) {
            exit("此键名已经被使用");
        }
    }
	

    /* uniqueID
     * return string
     */

    public function uniqueID() {
        return md5(uniqid(rand(), true)) . $_SERVER['REMOTE_ADDR'];
    }

    /* 读取数据
     * @param string
     * return string/array
     */

    public function get($key=''){
        if ($key == '')
            exit('键名不能为空');
        $wData = $this->Memcache->get($this->key);
        if (!$wData)
            return FALSE;
		if (array_key_exists($key,$wData)){
	        return $wData[$key];
		}else{
			return null;
		}
    }

    /* 重写数据
     * @param string $key
     * @param string $data
     * @return bool
     */

    public function set($key, $data=''){
		$arr_data=$this->Memcache->get($this->key);
		if (array_key_exists($key,$arr_data)){
	         $arr_data[$key]=$data;
		}else{
			$arr_data=array_merge($arr_data,array($key=>$data));
		}
		//dump($arr_data);
		//$arr_data=array("a"=>"a","b"=>"b");
		$ret = $this->Memcache->set($this->key,$arr_data, ZIP_FLAG, SESS_LEFETIME);
        if (TRUE != $ret) {
            exit("存储数据失败");
        }
    }

    public function del($key){
		$arr_data=$this->Memcache->get($this->key);
		$arr_data=array_diff_key($arr_data,array($key=>0));
		$ret = $this->Memcache->set($this->key,$arr_data, ZIP_FLAG, SESS_LEFETIME);
        if (TRUE != $ret) {
            exit("存储数据失败");
        }
    }
    /* 注销数据
     * @param string $key
     * return bool
     */

    public function Destory() {
		$this->Memcache->delete($_COOKIE['session_key']);
		 setcookie('session_key', $_COOKIE['session_key'], time() - 3600,"/");
    }

    /* Cookie验证,建立客户端与服务器端同步键名
     * return bool
     */

    public function setCookie() {
		
        if (empty($_COOKIE['session_key'])) {				
            $this->key =md5(uniqid(rand(), true). $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
            setcookie('session_key', $this->key, time() + SESS_LEFETIME,'/');			
			
			$arr_data["key"]=$this->key;
            $this->Memcache->set($this->key,$arr_data);
        } else {
            setcookie('session_key', $_COOKIE['session_key'], time() + SESS_LEFETIME,'/');			
			$this->key=$_COOKIE['session_key'];		
			if (!$this->Memcache->get($this->key)){			
				$this->Destory();
				//exit('处理异常'); //出现此错误是因为客户端伪造session_key			
			}
        }
    }
}
?>