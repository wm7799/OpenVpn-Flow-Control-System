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
    case 'help1':
        $user_info = check_user();
        $title = '个人中心';
        include("api_head_new.php");
        include("mode/all.php");
        include("api_footer.php");
        break;
    case 'user_info':
        $user_info = check_user();
        $title = '详细信息';
        include("api_head_new.php");
        include("mode/user_info.php");
        include("api_footer.php");
        break;
    case 'llog':
        $user_info = check_user();
        $title = '使用记录';
        include("api_head_new.php");
        include("mode/llog.php");
        include("api_footer.php");
        break;
    case 'top':
        $user_info = check_user();
        $title = '流量排行';
        include("api_head_new.php");
        include("mode/top.php");
        include("api_footer.php");
        break;
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
        $title = '消息通知';
        include('api_head_new.php');
        //include('list_gg.php');
        $u = $_GET['username'];
        $p = $_GET['password'];
        $db = db('app_gg');
        $list = $db->where(["daili" => DID])->order('id DESC')->select();
        echo '<div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-12">
<div class="card card-default card-md mb-4">
                                <div class="card-header py-20">
                                    <h6>公告/消息通知</h6>
                                </div>
                                <div class="card-body">';
        if ($list) {
            foreach ($list as $v) {
                echo '<div class="atbd-collapse atbd-collapse-borderless">
                                        <div class="atbd-collapse-item">
                                            <div class="atbd-collapse-item__header">
                                                <a href="#" class="item-link" data-toggle="collapse" data-target="#collapse-body-b-3" aria-expanded="true" aria-controls="collapse-body-b-3">
                                                    <i class="la la-angle-right"></i>
                                                    <h6>' .$v['name'].'</h6>
                                                </a>
                                            </div>
                                            <div id="collapse-body-b-3" class="collapse atbd-collapse-item__body">
                                                <div class="collapse-body-text">
                                                    <p>
                                                        '.$v['content'].'
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- inject:js-->
<script src="../../assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery/jquery-ui.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/popper.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/theme_assets/js/main.js"></script>
<!-- endinject-->';
            }
            echo '</ul>';
        } else {
            echo '消息已经删除或者不存在！';
        }
        echo "</div></div></div></div>";
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
            $_all = $u[_maxll_] >= _MAX_LIMIT_ * 1024 * 1024 * 1024 ? "NO_LIMIT" : (int)($s / 1024);
            die(json_encode([
                'status' => 'success',
                'bl' => "NO_LIMIT",
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