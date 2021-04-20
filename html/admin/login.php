<?php
$display_login = true;
$title="登陆";
require('system.php');
$cip = getClientIP();
$last_ip_file = R."/cache/last_ip.log";
$last_ip = file_get_contents($last_ip_file);
if(ACT == "do_login"){
	$u = $_POST["user"] ?? "";
	$p = $_POST["pass"] ?? "";
	if(trim($u) == "" || trim($p) == ""){
		die(json_encode(["status"=>"error","msg"=>"信息不完整"]));
	}else{
		if($cip != $last_ip){
			$auth_key = trim($_POST["auth_key"]);
			$local_key = file_get_contents("/var/www/auth_key.access");
			if($auth_key == "" || $auth_key != trim($local_key)){
				die(json_encode(["status"=>"error","msg"=>"口令错误"]));
			}
		}
		$admin = db("app_admin")->where(array("username"=>$u,"password"=>$p))->find();
		if($admin){
			$_SESSION["dd"]["username"] = $u;
			$_SESSION["dd"]["password"] = $p;
			file_put_contents($last_ip_file,$cip);
			die(json_encode(["status"=>"success","msg"=>""]));
		}else{
			die(json_encode(["status"=>"error","msg"=>"密码错误"]));
		}
	}
}elseif(ACT == "logout"){
	unset($_SESSION["dd"]);
	header("location:admin.php");
}else{
    include("head.php");
?>
    <body>
<main class="main-content">

    <div class="signUP-admin">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-5 p-0 d-none d-md-block">
                    <div class="signUP-admin-left signIn-admin-left position-relative">
                        <div class="signUP-overlay">
                            <img class="svg signupTop" src="img/svg/signupTop.svg" alt="img" />
                            <img class="svg signupBottom" src="img/svg/signupBottom.svg" alt="img" />
                        </div><!-- End: .signUP-overlay  -->
                        <div class="signUP-admin-left__content">
                            <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                <a class="wh-36 bg-primary text-white radius-md mr-10 content-center">a</a>
                                <span class="text-dark">康师傅流控</span>
                            </div>
                            <h1>后台管理系统</h1>
                        </div><!-- End: .signUP-admin-left__content  -->
                        <div class="signUP-admin-left__img">
                            <img class="img-fluid svg" src="img/svg/signupIllustration.svg" alt="img" />
                        </div><!-- End: .signUP-admin-left__img  -->
                    </div><!-- End: .signUP-admin-left  -->
                </div><!-- End: .col-xl-4  -->
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                    <div class="signUp-admin-right signIn-admin-right  p-md-40 p-10">
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-8 col-md-12">
                                <div class="edit-profile mt-md-25 mt-0">
                                    <div class="card border-0">
                                        <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                            <div class="edit-profile__title">
                                                <h6>登陆 <span class="color-primary">管理员账号</span></h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="edit-profile__body">
                                                <div class="form-group mb-20">
                                                    <label for="username">账号</label>
                                                    <input type="text" class="form-control" id="username" placeholder="请输入管理员账户" name="user">
                                                </div>
                                                <div class="form-group mb-15">
                                                    <label for="password-field">密码</label>
                                                    <div class="position-relative">
                                                        <input id="password-field" type="password" class="form-control" name="pass" placeholder="请输入管理员密码">
                                                        <div class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></div>
                                                    </div>
                                                </div>
                                                <?php if($cip != $last_ip){ ?>
                                                <div class="form-group mb-15">
                                                    <label for="password-field2">本地口令</label>
                                                    <div class="position-relative">
                                                        <input id="password-field" type="password" class="form-control" name="auth_key" placeholder="请输入/var/www/auth_key.access本地口令">
                                                        <div class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="signUp-condition signIn-condition">
                                                    <a href="javascript:$('#bdKey').modal()">什么是本地口令</a>
                                                    <a href="javascript:alert('为了安全起见，无法自助找回，请联系客服找回管理员密码。')">忘记密码</a>
                                                </div>
                                                <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                    <button class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn do_login">
                                                        登陆
                                                    </button>
                                                </div>
                                            </div>
                                        </div><!-- End: .card-body -->
                                    </div><!-- End: .card -->
                                </div><!-- End: .edit-profile -->
                            </div><!-- End: .col-xl-5 -->
                        </div>
                    </div><!-- End: .signUp-admin-right  -->
                </div><!-- End: .col-xl-8  -->
            </div>
        </div>
    </div><!-- End: .signUP-admin  -->

    <div class="modal-info-error modal fade show" id="bdKey" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-info" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-info-body d-flex">
                        <div class="modal-info-icon primary">
                            <span data-feather="info"></span>
                        </div>
                        <div class="modal-info-text">
                            <p>本地口令，是一种不存储在数据库的本地密码。存储在<b>/var/www/auth_key.access</b>,修改文件内容本地口令也会随之更改。首次登录以及登录IP与上次不同时，会要求您输入!其目的是为了防止当数据库泄露或者密码被爆破黑客可以轻松入侵您的后台！因为本地口令不存在于数据库，所以不会被黑客截取！所以，我们强烈建议您，将本地口令与登录密码设置为不同的密码。<br>
                                您可以随时通过以下方式查看：<br>
                                命令行:<b>cat /var/www/auth_key.access</b><br>
                                或者直接登录sftp或者ftp查看!</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ends: .modal-info-error -->
    <script src="assets/google-api.js"></script>
    <!-- inject:js-->
    <script src="assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/vendor_assets/js/jquery/jquery-ui.js"></script>
    <script src="assets/vendor_assets/js/bootstrap/popper.js"></script>
    <script src="assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="assets/vendor_assets/js/accordion.js"></script>
    <script src="assets/vendor_assets/js/autoComplete.js"></script>
    <script src="assets/vendor_assets/js/Chart.min.js"></script>
    <script src="assets/vendor_assets/js/charts.js"></script>
    <script src="assets/vendor_assets/js/daterangepicker.js"></script>
    <script src="assets/vendor_assets/js/drawer.js"></script>
    <script src="assets/vendor_assets/js/dynamicBadge.js"></script>
    <script src="assets/vendor_assets/js/dynamicCheckbox.js"></script>
    <script src="assets/vendor_assets/js/feather.min.js"></script>
    <script src="assets/vendor_assets/js/fullcalendar@5.2.0.js"></script>
    <script src="assets/vendor_assets/js/google-chart.js"></script>
    <script src="assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendor_assets/js/jquery.countdown.min.js"></script>
    <script src="assets/vendor_assets/js/jquery.filterizr.min.js"></script>
    <script src="assets/vendor_assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/vendor_assets/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="assets/vendor_assets/js/jquery.peity.min.js"></script>
    <script src="assets/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
    <script src="assets/vendor_assets/js/leaflet.js"></script>
    <script src="assets/vendor_assets/js/leaflet.markercluster.js"></script>
    <script src="assets/vendor_assets/js/loader.js"></script>
    <script src="assets/vendor_assets/js/message.js"></script>
    <script src="assets/vendor_assets/js/moment.js"></script>
    <script src="assets/vendor_assets/js/muuri.min.js"></script>
    <script src="assets/vendor_assets/js/notification.js"></script>
    <script src="assets/vendor_assets/js/popover.js"></script>
    <script src="assets/vendor_assets/js/select2.full.min.js"></script>
    <script src="assets/vendor_assets/js/slick.min.js"></script>
    <script src="assets/vendor_assets/js/trumbowyg.min.js"></script>
    <script src="assets/vendor_assets/js/wickedpicker.min.js"></script>
    <script src="assets/theme_assets/js/drag-drop.js"></script>
    <script src="assets/theme_assets/js/full-calendar.js"></script>
    <script src="assets/theme_assets/js/googlemap-init.js"></script>
    <script src="assets/theme_assets/js/icon-loader.js"></script>
    <script src="assets/theme_assets/js/jvectormap-init.js"></script>
    <script src="assets/theme_assets/js/leaflet-init.js"></script>
    <script src="assets/theme_assets/js/main.js"></script>
    <!-- endinject-->
<script>
    $(function(){
        $(".do_login").click(function(){
            var username = $("[name='user']").val();
            var password = $("[name='pass']").val();
            var auth_key = $("[name='auth_key']").val();
            if(username == "" || password == ""){
                alert("信息不完整");
            }else{
                $.post("?act=do_login",
                    {
                        "user":username,
                        "pass":password,
                        "auth_key":auth_key
                    },function(data){
                        if(data.status == "success"){
                            window.location.href="admin.php";
                        }else{
                            alert(data.msg);
                        }
                    },"JSON");
            }
        });
    });
</script><?php
}
?>