<?php
$title = "注册";
$not_to_login = true;
include("system.php");
function checkUsername($str)
{
    $output = '';
    $a = preg_match('/[' . chr(0xa1) . '-' . chr(0xff) . ']/', $str);
    $b = preg_match('/[0-9]/', $str);
    $c = preg_match('/[a-zA-Z]/', $str);
    if ($a && $b && $c) {
        $output = '汉字数字英文的混合字符串';
    } elseif ($a && $b && !$c) {
        $output = '汉字数字的混合字符串';
    } elseif ($a && !$b && $c) {
        $output = '汉字英文的混合字符串';
    } elseif (!$a && $b && $c) {
        $output = '数字英文的混合字符串';
        return true;
    } elseif ($a && !$b && !$c) {
        $output = '纯汉字';
    } elseif (!$a && $b && !$c) {
        $output = '纯数字';
        return true;
    } elseif (!$a && !$b && $c) {
        $output = '纯英文';
        return true;
    }
    //return $output;
    return false;
}

if ($_GET['act'] == 'reg_in') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $code = strtolower($_POST['code']);

    if (strtolower($_SESSION['code']) != $code) {
        die(json_encode(array('status' => 'error', 'msg' => '验证码错误')));
    }
    $type = @file_get_contents("data/reg_type.txt");
    if ($type == "sms") {
        if (trim($_SESSION['phone']) != trim($_POST['username'])) {
            die(json_encode(array('status' => 'error', 'msg' => '信息不一致')));
        }
    }
    if (trim($username) == '' || trim($password) == '') {
        die(json_encode(array('status' => 'error', 'msg' => '用户密码不能为空')));
    }
    if (!checkUsername($username)) {
        die(json_encode(array('status' => 'error', 'msg' => '用户名只能是英文和数字')));
    }
    if (!checkUsername($password)) {
        die(json_encode(array('status' => 'error', 'msg' => '密码只能是英文和数字')));
    }
    $db = db(_openvpn_);
    if ($db->where(array(_iuser_ => $username))->find()) {
        die(json_encode(array('status' => 'error', 'msg' => '已经注册过了哦')));
    } else {
        $vCode = $_POST['vCode'] ?? 0;
        $m = new Map();
        $info["SMS_T"] = $m->type("cfg_app")->getValue("SMS_T", 3);
        $info["SMS_L"] = $m->type("cfg_app")->getValue("SMS_L", 100);
        $info["SMS_I"] = $m->type("cfg_app")->getValue("SMS_I", 0);
        $date[_iuser_] = $username;
        $date[_ipass_] = $password;
        $date[_maxll_] = $info["SMS_L"] * 1024 * 1024;
        $date[_isent_] = '0';
        $date[_irecv_] = '0';
        $date["daili"] = $vCode;
        $date[_i_] = $info["SMS_I"];
        $date[_starttime_] = time();
        $date[_endtime_] = time() + ($info["SMS_T"] * 24 * 60 * 60);
        $arr = explode(",", _other_);
        foreach ($arr as $v) {
            $date[$v] = "";
        }
        if ($db->insert($date, true)) {
            $_SESSION['code'] = '';
            die(json_encode(array('status' => 'success', 'msg' => '100')));
        } else {
            die(json_encode(array('status' => 'error', 'msg' => '无法正常注册用户 请检查数据库')));
        }
    }
} else {
    include("api_head.php");
    $m = new Map();
    $type = $m->type("cfg_app")->getValue("reg_type");
    ?>
    <body>
    <main class="main-content">

        <div class="signUP-admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-5 p-0 d-none d-md-block">
                        <div class="signUP-admin-left position-relative">
                            <div class="signUP-overlay">
                                <img class="svg signupTop" src="../img/svg/signupTop.svg" alt="img"/>
                                <img class="svg signupBottom" src="../img/svg/signupBottom.svg" alt="img"/>
                            </div><!-- End: .signUP-overlay  -->
                            <div class="signUP-admin-left__content">
                                <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                    <a class="wh-36 bg-primary text-white radius-md mr-10 content-center">a</a>
                                    <span class="text-dark">欢迎您</span>
                                </div>
                                <h1>用户中心</h1>
                            </div><!-- End: .signUP-admin-left__content  -->
                            <div class="signUP-admin-left__img">
                                <img class="img-fluid svg" src="../img/svg/signupIllustration.svg" alt="img"/>
                            </div><!-- End: .signUP-admin-left__img  -->
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                        <div class="signUp-admin-right  p-md-40 p-10">
                            <div class="signUp-topbar d-flex align-items-center justify-content-md-end justify-content-center mt-md-0 mb-md-0 mt-20 mb-1">
                                <p class="mb-0">
                                    已经有账号了？
                                    <a href="login.php" class="color-primary">
                                        登陆
                                    </a>
                                </p>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-10 col-md-12 ">
                                    <div class="edit-profile mt-md-25 mt-0">
                                        <div class="card border-0">
                                            <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                                <div class="edit-profile__title">
                                                    <h6>注册 <span class="color-primary">用户账号</span></h6>
                                                </div>
                                            </div>
                                            <?php
                                            if ($type == "sms") {
                                                include("dx_reg.php");
                                            } else {
                                                include("app_reg.php");
                                            }
                                            ?>
                                        </div><!-- End: .card -->
                                    </div><!-- End: .edit-profile -->
                                </div><!-- End: .col-xl-5 -->
                            </div>
                        </div><!-- End: .signUp-admin-right  -->
                    </div><!-- End: .col-xl-8  -->
                </div>
            </div>
        </div><!-- End: .signUP-admin  -->
    </main>
    </body>
    </html>
    <?php
}