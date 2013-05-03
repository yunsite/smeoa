<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8' />
	<title>smeoa</title>
	<meta content='' name='description' />
	<meta content='' name='author' />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="/public/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<?php
$files = "Conf/config.php";
if (!is_writable($files)) {
	echo "<font color=red>不可写！！！</font>";
} else {
	echo "<font color=green>可写</font>";
}
if (isset($_POST["install"])) {
	$config_str="<?php\n";
	$config_str .="    if (!defined('THINK_PATH')) exit();\n";
	$config_str .='    $array=array('."\n";
	$config_str .="        'URL_MODEL'=>3, // 如果你的环境不支持PATHINFO 请设置为3\n";
	$config_str .="        'DB_TYPE'=>'mysql',\n";
	$config_str .="        'DB_HOST'=>'".$_POST["db_host"]."',\n";
	$config_str .="        'DB_NAME'=>'".$_POST["db_dbname"]."',\n";
	$config_str .="        'DB_USER'=>'".$_POST["db_user"]."',\n";
	$config_str .="			'VAR_PAGE'=>'p',\n";
	$config_str .="        'DB_PWD'=>'".$_POST["db_pass"]."',\n";
	$config_str .="        'DB_PORT'=>'3306',\n";
	$config_str .="        'DB_PREFIX'=>'".$_POST["db_tag"]."',\n";
	$config_str .="		'TOKEN_ON'=>false, \n";
	$config_str .="		'TOKEN_TYPE'=>'md5',\n";
	$config_str .="		'TOKEN_NAME'=>'__hash__',\n";
	$config_str .="		'URL_CASE_INSENSITIVE' =>   true,\n";
	$config_str .="		'TMPL_CACHE_ON'=>false,\n";
	$config_str .="		'DB_FIELDS_CACHE'=>false,\n";
	$config_str .="        'APP_AUTOLOAD_PATH'=>'@.TagLib',\n";
	$config_str .="        'SESSION_AUTO_START'=>false,\n";
	$config_str .="       'USER_AUTH_KEY'             =>'authId',	// 用户认证SESSION标记\n";
	$config_str .="       'ADMIN_AUTH_KEY'			=>'administrator',\n";
	$config_str .="       'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型\n";
	$config_str .="       'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式\n";
	$config_str .="        'USER_AUTH_GATEWAY'         =>'login/index',// 默认认证网关\n";
	$config_str .="        'DB_LIKE_FIELDS'            =>'title|content|name|remark',\n";
	$config_str .="			'SAVE_PATH'=>'Data/Files/',\n";
	$config_str .="        'SHOW_PAGE_TRACE'=>0, //显示调试信息\n";
	$config_str .="    );\n";
	$config_str .='    return $array;'."\n";
	$config_str .="?>\n";
	$config_str .= " \n";
	$ff = fopen($files, "w ");
	fwrite($ff, $config_str);

$mysql_host = $_POST["db_host"];
$mysql_user = $_POST["db_user"];
$mysql_pass = $_POST["db_pass"];
$mysql_dbname = strtolower($_POST["db_dbname"]);
$mysql_tag=$_POST["db_tag"];

	//=====================
	//include_once ("Conf/config.php");
	//嵌入配置文件
	if (!@$link = mysql_connect($mysql_host, $mysql_user, $mysql_pass)) {//检查数据库连接情况
		echo "数据库连接失败! 请返回上一页检查连接参数 <a href=install.php>返回修改</a>";
	} else {
		mysql_query("CREATE DATABASE `$mysql_dbname`");
		mysql_select_db($mysql_dbname);

$lines=file("Sql/demo.sql");

$sqlstr="";
foreach($lines as $line){
  $line=trim($line);
  if($line!=""){
    if(!($line{0}=="#" || $line{0}.$line{1}=="--")){
      $sqlstr.=$line;  
    }
  }
}
$sqlstr=rtrim($sqlstr,";");
$sqls=explode(";",$sqlstr);
		foreach ($sqls as $val) {
			$val=str_replace("`think_","`".$mysql_tag,$val);
			mysql_query($val);
		}
		rename("install.php", "install.lock");
		echo "<script>\n
			window.onload=function(){
				alert('安装成功');
				location.href='index.php';
			}
		</script>";
	}
}
?>

<body class="install">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
<form   method="POST">
		<div class="row-fluid form_box">
			<div class="row-fluid form-horizontal">
				<div class="control-group">
					<label class="control-label" for="name" >填写主机：</label>
					<div class="controls">
						<input type="text" name="db_host" value="localhost"/></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">用 户 名：</label>
					<div class="controls">
						<input type="text" name="db_user" value="root"/></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">密　　码：</label>
					<div class="controls">
						<input type="text" name="db_pass" value="test"/></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">数据库名：</label>
					<div class="controls">
						<input type="text" name="db_dbname" value="install"/></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">数据前缀：</label>
					<div class="controls">
						<input type="text" name="db_tag" value="smeoa_"/></div>
				</div>
	<button type="submit" name="install">
		下一步
	</button>
</form>
			</div>
		</div>
</body>
</html>
