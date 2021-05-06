<?php
$client = isset($_GET['client']) ? $_GET['client'] : null;
if ($client == 'app') {
    require $_SERVER['DOCUMENT_ROOT'] . '/system.php';
    $type = 'app';
} elseif ($client == 'web') {
    require $_SERVER['DOCUMENT_ROOT'] . '/user/system.php';
    $type = 'web';
} elseif ($client == 'daili') {
    require '' . $_SERVER['DOCUMENT_ROOT'] . '/daili/system.php';
    $type = 'daili';
}
@header('Content-Type: application/json; charset=UTF-8');

$act = $_GET['act'] ?? 'pay';
switch ($act) {
    case 'pay':
        $tid = intval($_POST['tid']);//套餐id
        $inputvalue = $_POST['inputvalue'];//额外的变量，暂时用于用户ID
        $rs = db('app_tc')->where(array('id' => $tid))->select()[0];//根据id找到套餐信息
        if ($rs) {
            $need = $rs['jg'];//套餐价格
            $trade_no = date("YmdHis") . rand(111, 999);//订单号
            $user = isset($userinfo) && $user_info != null ? $userinfo['id'] : $inputvalue;//用户id
            $user_info = db('openvpn')->where(array('id' => $user))->select()[0];//根据用户id找到用户信息
            if (!$user_info) {
                exit('{"code":"-2","msg":"获取用户信息失败"}');
            }
//    if ($user_info['frozen_state'] == '1') {
//        exit('{"code":"-2","msg":"请先解冻账号再进行充值！"}');
//    }
            //添加到订单数据库表
            $date = date("Y-m-d H:i:s");
            $sql = db('pay_order')->insert(array(
                'trade_no' => $trade_no,
                'tid' => $tid,
                'name' => $user,
                'money' => $need,
                'addtime' => $date,
                'status' => 0,
                'type' => $type
            ));
            if ($sql) {
                exit('{"code":0,"msg":"提交订单成功！","trade_no":"' . $trade_no . '","need":"' . $need . '"}');
            } else {
                exit('{"code":-1,"msg":"提交订单失败！"}');
            }
        } else {
            exit('{"code":-2,"msg":"该商品不存在"}');
        }
        break;
    case 'daili_pay':
        $tid = $_POST['tid'];
        $need = $_POST['jg'];
        $user = $_POST['name'];
        $trade_no = date("YmdHis") . rand(111, 999);
        $date = $date = date("Y-m-d H:i:s");
        $db_order = db('pay_order');
        $sql = $db_order->insert(array(
            'trade_no' => $trade_no,
            'tid' => $tid,
            'name' => $user,
            'money' => $need,
            'addtime' => $date,
            'status' => 0,
            'type' => $type
        ));
        if ($sql) {
            exit('{"code":0,"msg":"提交订单成功！","trade_no":"' . $trade_no . '","need":"' . $need . '"}');
        } else {
            exit('{"code":-1,"msg":"提交订单失败！"}');
        }
        break;
}