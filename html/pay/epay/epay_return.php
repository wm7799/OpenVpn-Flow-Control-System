<?php
/* * 
 * 功能：彩虹易支付页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
require $_SERVER['DOCUMENT_ROOT'] . '/system.php';
require_once("epay.config.php");
require_once("epay.notify.class.php");


//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if ($verify_result) {
    //商户订单号
    $out_trade_no = $_GET['out_trade_no'];
    //支付宝交易号
    $trade_no = $_GET['trade_no'];
    //交易状态
    $trade_status = $_GET['trade_status'];
    $order_db = db('pay_order');
    $srow = $order_db->where(array('trade_no' => $out_trade_no))->select()[0];
    if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
        if ($srow['status'] == 0) {
            echo processOrder($out_trade_no);
        }
        //http://119.29.79.238:1024/other/epay/epay_return.php?money=1.00&name=231&out_trade_no=20210426092249308&pid=10005&trade_no=2021042609224989151&trade_status=TRADE_SUCCESS&type=alipay&sign=02308525fce5d3f4607470c970db7610&sign_type=MD5
        if ($srow['type'] == "app") {
            echo '<script>window.location.href="/kangml_app/client.php?action=success_pay";</script>';
        } elseif ($srow['type'] == "web") {
            echo '<h1 style="font-size: 80px">已付款成功！3秒后返回用户中心...</h1>
                    <script>
                    setTimeout(jump,3000);
                            function jump(){
                            window.location.href="/user/index.php";
                            }</script>';
        } elseif ($srow['type'] == "daili") {
            echo '<h1 style="font-size: 80px">已付款成功！3秒后返回代理中心...</h1>
                    <script>
                    setTimeout(jump,3000);
                            function jump(){
                            window.location.href="/daili/admin.php";
                            }</script>';
        }
    } else {
        //验证失败
        echo '订单验证失败！';
    }
}