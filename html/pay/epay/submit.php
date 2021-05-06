<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>正在为您跳转到支付页面，请稍候...</title>
</head>

<body>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/system.php';//引入system
$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath . '/';
$type = $_GET['type'] ?? exit('No type!');
$orderid = $_GET['orderid'] ?? exit('No orderid!');

//加载数据
$db = db('app_tc');
$order_db = db('pay_order');
$row2 = $order_db->where(array('trade_no' => $orderid))->select()[0];
$row = $db->where(array('id' => $row2['tid']))->select()[0];
//判断订单号是否存在,不存在重新发起请求
if (!$row2['trade_no']) exit('该订单号不存在，请返回来源地重新发起请求！');

//加载支付文件
require_once("epay.config.php");
require_once("epay_submit.class.php");
//判断是代理还是用户充值
if ($row2['tid'] == '-1') {
    $parameter = array(
        "pid" => $pay_info['epayID'],
        "type" => $type,
        "notify_url" => $siteurl . 'epay_notify.php',
        "return_url" => $siteurl . 'epay_return.php',
        "out_trade_no" => $orderid,
        "name" => '代理充值',
        "money" => $row2['money'],
        "sitename" => 'kangml'
    );
} else {
    $parameter = array(
        "pid" => $pay_info['epayID'],
        "type" => $type,
        "notify_url" => $siteurl . 'epay_notify.php',
        "return_url" => $siteurl . 'epay_return.php',
        "out_trade_no" => $orderid,
        "name" => $row['name'],
        "money" => $row['jg'],
        "sitename" => 'kangml'
    );
}
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter, "POST", "正在跳转");
echo $html_text;
?>

<p>正在为您跳转到支付页面，请稍候...</p>
</body>

</html>