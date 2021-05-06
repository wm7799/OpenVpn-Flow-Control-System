<?php
require('../system.php');
$action = $_GET['action'];
$agent = $_GET['agent'] ?: 0;
$username = $_GET['username'];
$password = $_GET['password'];

define("DID", $agent);

function check_user()
{
    $username = $_GET['username'] ?: $_SESSION['username'];
    $password = $_GET['password'] ?: $_SESSION['password'];
    $res = db('openvpn')->where([_iuser_ => $username, _ipass_ => $password])->find();
    if (!$res) {
        $title = '温馨提示';
        include("api_head_new.php");
        include("mode/error_login.php");
        include("api_footer.php");
        die();
    }
    $_SESSION['username'] = $res[_iuser_];
    $_SESSION['password'] = $res[_ipass_];
    return $res;
}

switch ($action) {
    case 'success_pay':
        $title = '支付成功';
        include("api_head_new.php");
        include("mode/success_pay.php");
        include("api_footer.php");
        break;
    case 'successReg':
        $title = '注册成功';
        include("api_head_new.php");
        include("mode/success.php");
        include("api_footer.php");
        break;
    case 'shop':
        $user_info = check_user();
        $title = '充值与续费';
        include("api_head_new.php");
        include("mode/ad.php");
        include("api_footer.php");
        break; 
	case 'line':
        $user_info = check_user();
        $title = '线路安装';
        include("api_head_new.php");
        include("mode/line.php");
        include("api_footer.php");
        break;
    case 'connect':
//        $user_info = check_user();
        $title = '客服中心';
        include("api_head_new.php");
        include("mode/connect.php");
        include("api_footer.php");
        break;
    case 'notice_list':
        include('api_head_new.php');
        //include('list_gg.php');
        $u = $_GET['username'];
        $p = $_GET['password'];
        $db = db('app_gg');
        $list = $db->where(["daili" => DID])->order('id DESC')->select();
        echo '<div style="margin:10px 10px;">';
        echo '<div class="alert alert-warning">您可以在这看到最近30条消息通知</div>';
        echo '</div>';
        if ($list) {
            echo '<ul class="list-group">';
            foreach ($list as $v) {
                echo '<li class="list-group-item"><a href="">' . $v['name'] . '</a></li>
				';
            }
            echo '</ul>';
        } else {
            echo '消息已经删除或者不存在！';
        }

        include("api_footer.php");
        break;
    case 'notice':
        $db = db('app_gg');
        if ($notice = $db->where(["daili" => DID])->order('id DESC')->find()) {
            die(json_encode([
                'status' => 'success',
                'title' => $notice['name'],
                'content' => $notice['content']
            ]));
        };
        break;
    case 'userinfo':
        $u = check_user();
        $ud = new U($u[_iuser_], $u[_ipass_], true);
        if ($u) {
            $count = printmb($u[_maxll_]);
            $isuse = printmb($u[_irecv_] + $u[_isent_]);
            $sy = printmb($u[_maxll_] - ($u[_irecv_] + $u[_isent_]));
            $upload = printmb($u[_irecv_]);
            $download = printmb($u[_isent_]);
            $_sy = $ud->getDatadays();
            $s = $u[_maxll_] - ($u[_irecv_] + $u[_isent_]);
            $_all = $u[_maxll_] >= _MAX_LIMIT_ * 1024 * 1024 * 1024 ? "NO_LIMIT" : $s;
            die(json_encode([
                'status' => 'success',
                'bl' => $_all,
                'sy' => $_sy . "天"
            ]));
        } else {
            die(json_encode(['status' => 'error']));
        }
        break;
    case 'reg':
        $title = '新用户注册';
        include("api_head_new.php");
        $m =  new Map();
        $type = $m->type("cfg_app")->getValue("reg_type");
        if($type == "sms"){
            include("mode/dx_reg.php");
        }else{
            include("mode/app_reg.php");
        }
        include("api_footer.php");
        break;
    case 'pay':
        $user_info = check_user();
        $title = '充值与续费';
        include("api_head_new.php");
        include("mode/pay.php");
        include("api_footer.php");
        break;
}