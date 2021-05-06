<?php
//取消php执行时间闲置
set_time_limit(0);
//去掉php错误警告
//error_reporting(0); TODO
//强制使用中国（上海）时区
date_default_timezone_set('Asia/Shanghai');
//导入配置文件
define('R',dirname( __FILE__));
define('RI',dirname( __FILE__).'/Core');
//根目录
require(R.'/config.php');
require(R.'/full_config.php');
//Core目录
require(RI.'/fun/html.fun.php');
require(RI.'/fun/function.fun.php');
require(RI.'/class/D.class.php');//PDO数据库
require(RI.'/class/U.class.php');//用户
require(RI.'/class/Map.class.php');//map表
require(RI.'/class/Base.class.php');//防止xss
//app里流量为无限制的提示
define("_MAX_LIMIT_",(new Map())->type("cfg_app")->getValue("max_limit",100));
//全局GET和POST的防xss
SqlBase::_deal();
//页面的act参数
$action = trim(@$_GET["act"]);
define("ACT",$action);
//开启session
session_start();
//在线支付
$m = new Map();
$pay_info['epayID'] = $m->type("pay")->getValue("epayID");
$pay_info['epayKey'] = $m->type("pay")->getValue("epayKey");
$pay_info['epaySite'] = $m->type("pay")->getValue("epaySite");