<?php
$login_allow = true;
$title = "登陆";
require("system.php");
if (ACT == "logout") {
    unset($_SESSION["dl"]);
    header("location:admin.php");
} else {
    include("head.php");
    ?>
    <body>
    <?php
    if (isset($_POST["user"]) && isset($_POST["pass"])) {
        $u = $_POST["user"];
        $p = $_POST["pass"];
        if (trim($u) == "" || trim($p) == "") {
            echo "<script>alert(\"账户密码不能为空\");</script>";
        } else {
            $admin = db("app_daili")->where(array("name" => $u, "pass" => $p, "lock" => 1))->find();
            if ($admin) {
                if ($admin["endtime"] > time()) {
                    $_SESSION["dl"]["username"] = $u;
                    $_SESSION["dl"]["password"] = $p;
                    header("location:admin.php");
                } else {
                    echo "<script>alert(\"代理身份已经过期\");</script>";
                }
            } else {
                echo "<script>alert(\"密码错误或者尚未激活\");</script>";
            }
        }
    }
    ?>
    <main class="main-content">
        <div class="signUP-admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-5 p-0 d-none d-md-block">
                        <div class="signUP-admin-left signIn-admin-left position-relative">
                            <div class="signUP-overlay">
                                <img class="svg signupTop" src="../img/svg/signupTop.svg" alt="img"/>
                                <img class="svg signupBottom" src="../img/svg/signupBottom.svg" alt="img"/>
                            </div><!-- End: .signUP-overlay  -->
                            <div class="signUP-admin-left__content">
                                <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                    <a class="wh-36 bg-primary text-white radius-md mr-10 content-center">a</a>
                                    <span class="text-dark">欢迎您</span>
                                </div>
                                <h1>代理中心</h1>
                            </div><!-- End: .signUP-admin-left__content  -->
                            <div class="signUP-admin-left__img">
                                <img class="img-fluid svg" src="../img/svg/signupIllustration.svg" alt="img"/>
                            </div><!-- End: .signUP-admin-left__img  -->
                        </div><!-- End: .signUP-admin-left  -->
                    </div><!-- End: .col-xl-4  -->
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                        <div class="signUp-admin-right signIn-admin-right  p-md-40 p-10">
                            <div class="signUp-topbar d-flex align-items-center justify-content-md-end justify-content-center mt-md-0 mb-md-0 mt-20 mb-1">
                                <p class="mb-0">
                                    还没有账号？
                                    <a href="reg.php" class="color-primary">
                                        去注册
                                    </a>
                                </p>
                            </div><!-- End: .signUp-topbar  -->
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-8 col-md-12">
                                    <div class="edit-profile mt-md-25 mt-0">
                                        <div class="card border-0">
                                            <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                                <div class="edit-profile__title">
                                                    <h6>登陆 <span class="color-primary">代理账号</span></h6>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="edit-profile__body">
                                                    <form action="./login.php" method="POST" role="form">
                                                        <div class="form-group mb-20">
                                                            <label for="username">账号</label>
                                                            <input type="text" class="form-control" id="username"
                                                                   placeholder="请输入代理账户" name="user">
                                                        </div>
                                                        <div class="form-group mb-15">
                                                            <label for="password-field">密码</label>
                                                            <div class="position-relative">
                                                                <input id="password-field" type="password"
                                                                       class="form-control" name="pass"
                                                                       placeholder="请输入代理密码">
                                                                <div class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></div>
                                                            </div>
                                                        </div>
                                                        <div class="signUp-condition signIn-condition">
                                                            <a href="reg.php">点我注册</a>
                                                        </div>
                                                        <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn do_login">
                                                                登陆
                                                            </button>
                                                        </div>
                                                    </form>
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
    </main>

    <!-- inject:js-->
    <script src="../assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery/jquery-ui.js"></script>
    <script src="../assets/vendor_assets/js/bootstrap/popper.js"></script>
    <script src="../assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/vendor_assets/js/accordion.js"></script>
    <script src="../assets/vendor_assets/js/autoComplete.js"></script>
    <script src="../assets/vendor_assets/js/Chart.min.js"></script>
    <script src="../assets/vendor_assets/js/charts.js"></script>
    <script src="../assets/vendor_assets/js/daterangepicker.js"></script>
    <script src="../assets/vendor_assets/js/drawer.js"></script>
    <script src="../assets/vendor_assets/js/dynamicBadge.js"></script>
    <script src="../assets/vendor_assets/js/dynamicCheckbox.js"></script>
    <script src="../assets/vendor_assets/js/feather.min.js"></script>
    <script src="../assets/vendor_assets/js/fullcalendar@5.2.0.js"></script>
    <script src="../assets/vendor_assets/js/google-chart.js"></script>
    <script src="../assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendor_assets/js/jquery.countdown.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery.filterizr.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery.peity.min.js"></script>
    <script src="../assets/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
    <script src="../assets/vendor_assets/js/leaflet.js"></script>
    <script src="../assets/vendor_assets/js/leaflet.markercluster.js"></script>
    <script src="../assets/vendor_assets/js/loader.js"></script>
    <script src="../assets/vendor_assets/js/message.js"></script>
    <script src="../assets/vendor_assets/js/moment.js"></script>
    <script src="../assets/vendor_assets/js/muuri.min.js"></script>
    <script src="../assets/vendor_assets/js/notification.js"></script>
    <script src="../assets/vendor_assets/js/popover.js"></script>
    <script src="../assets/vendor_assets/js/select2.full.min.js"></script>
    <script src="../assets/vendor_assets/js/slick.min.js"></script>
    <script src="../assets/vendor_assets/js/trumbowyg.min.js"></script>
    <script src="../assets/vendor_assets/js/wickedpicker.min.js"></script>
    <script src="../assets/theme_assets/js/drag-drop.js"></script>
    <script src="../assets/theme_assets/js/full-calendar.js"></script>
    <script src="../assets/theme_assets/js/googlemap-init.js"></script>
    <script src="../assets/theme_assets/js/icon-loader.js"></script>
    <script src="../assets/theme_assets/js/jvectormap-init.js"></script>
    <script src="../assets/theme_assets/js/leaflet-init.js"></script>
    <script src="../assets/theme_assets/js/main.js"></script>
    <!-- endinject-->
    </body>
    </html>
    <?php
}
?>