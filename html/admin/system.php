<?php
//后台锁定
$file = dirname(dirname(dirname( __FILE__)))."/kangml.lock";
if(file_exists($file))
{
    require ("error.php");
	return;
}
require dirname(dirname( __FILE__))."/system.php";
//检测管理员数量
if(db("app_admin")->getnums()>1){
	die("错误：后台管理员不能多于1个");
};
//login页面防止死循环跳转
if(!$display_login)
{
	//检测session中的账号密码
	$admin = db("app_admin")->where(["username"=>$_SESSION["dd"]["username"],"password"=>$_SESSION["dd"]["password"]])->find();
	if(!$admin)
	{
		//没有找到对应管理员账号，未登录，跳转login页面
		header("location:login.php");	
		exit;
	}
}