<?php
//上次短信发送时间
$system_time = time();
$last_time = $_SESSION["last_send"] == "" ? 0 : $_SESSION["last_send"];
$al_time = $system_time - $last_time;
?>
<body>
<main class="main-content">

    <div class="signUP-admin">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-5 p-0 d-none d-md-block">
                    <div class="signUP-admin-left position-relative">
                        <div class="signUP-overlay">
                            <img class="svg signupTop" src="../../img/svg/signupTop.svg" alt="img"/>
                            <img class="svg signupBottom" src="../../img/svg/signupBottom.svg" alt="img"/>
                        </div><!-- End: .signUP-overlay  -->
                        <div class="signUP-admin-left__content">
                            <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                <a class="wh-36 bg-primary text-white radius-md mr-10 content-center">a</a>
                                <span class="text-dark">欢迎您</span>
                            </div>
                            <h1>用户中心</h1>
                        </div><!-- End: .signUP-admin-left__content  -->
                        <div class="signUP-admin-left__img">
                            <img class="img-fluid svg" src="../../img/svg/signupIllustration.svg" alt="img"/>
                        </div><!-- End: .signUP-admin-left__img  -->
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                    <div class="signUp-admin-right  p-md-40 p-10">
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-10 col-md-12 ">
                                <div class="edit-profile mt-md-25 mt-0">
                                    <div class="card border-0">
                                        <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                            <div class="edit-profile__title">
                                                <h6>注册 <span class="color-primary">用户账号</span></h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="edit-profile__body">
                                                <div class="form-group mb-20">
                                                    <label for="name">用户名(英文或者数字3到12位)</label>
                                                    <input type="text" class="form-control" id="name"
                                                           placeholder="请设置用户名" name="user">
                                                </div>
                                                <div class="form-group mb-15">
                                                    <label for="password-field">密码</label>
                                                    <div class="position-relative">
                                                        <input id="pass" type="password"
                                                               class="form-control" name="pass"
                                                               placeholder="请设置密码">
                                                        <span class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-15">
                                                    <label for="password-field">确认密码</label>
                                                    <div class="position-relative">
                                                        <input id="pass2" type="password"
                                                               class="form-control" name="pass"
                                                               placeholder="再次输入确认密码">
                                                        <span class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-15">
                                                    <div style="float:left;width:150px"><input type="text"
                                                                                               class="form-control"
                                                                                               id="code"
                                                                                               placeholder="请输入验证码">
                                                    </div>
                                                    <div class="col-sm-4;width:40%;" style="float:right"><img
                                                                src="/kangml_app/mode/check_code.php?t=<?php echo time() ?>"
                                                                class="ccode"
                                                                onclick='$(".ccode").attr({"src":"/kangml_app/mode/check_code.php?t="+Date.parse(new Date())});'>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                                                <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                    <button type="submit"
                                                            onclick="reg()"
                                                            class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signUp-createBtn signIn-createBtn">
                                                        注册
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inject:js-->
                                        <script src="../../assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery/jquery-ui.js"></script>
                                        <script src="../../assets/vendor_assets/js/bootstrap/popper.js"></script>
                                        <script src="../../assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/accordion.js"></script>
                                        <script src="../../assets/vendor_assets/js/autoComplete.js"></script>
                                        <script src="../../assets/vendor_assets/js/Chart.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/charts.js"></script>
                                        <script src="../../assets/vendor_assets/js/daterangepicker.js"></script>
                                        <script src="../../assets/vendor_assets/js/drawer.js"></script>
                                        <script src="../../assets/vendor_assets/js/dynamicBadge.js"></script>
                                        <script src="../../assets/vendor_assets/js/dynamicCheckbox.js"></script>
                                        <script src="../../assets/vendor_assets/js/feather.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/fullcalendar@5.2.0.js"></script>
                                        <script src="../../assets/vendor_assets/js/google-chart.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.countdown.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.filterizr.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.magnific-popup.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.mCustomScrollbar.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.peity.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/leaflet.js"></script>
                                        <script src="../../assets/vendor_assets/js/leaflet.markercluster.js"></script>
                                        <script src="../../assets/vendor_assets/js/loader.js"></script>
                                        <script src="../../assets/vendor_assets/js/message.js"></script>
                                        <script src="../../assets/vendor_assets/js/moment.js"></script>
                                        <script src="../../assets/vendor_assets/js/muuri.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/notification.js"></script>
                                        <script src="../../assets/vendor_assets/js/popover.js"></script>
                                        <script src="../../assets/vendor_assets/js/select2.full.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/slick.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/trumbowyg.min.js"></script>
                                        <script src="../../assets/vendor_assets/js/wickedpicker.min.js"></script>
                                        <script src="../../assets/theme_assets/js/drag-drop.js"></script>
                                        <script src="../../assets/theme_assets/js/full-calendar.js"></script>
                                        <script src="../../assets/theme_assets/js/googlemap-init.js"></script>
                                        <script src="../../assets/theme_assets/js/icon-loader.js"></script>
                                        <script src="../../assets/theme_assets/js/jvectormap-init.js"></script>
                                        <script src="../../assets/theme_assets/js/leaflet-init.js"></script>
                                        <script src="../../assets/theme_assets/js/main.js"></script>
                                        <!-- endinject-->
                                        <script>
                                            function reg() {
                                                if ($("#name").val() == "" || $("#pass").val() == "" || $("#code").val() == "") {
                                                    alert("任何一项均不能为空");
                                                } else if ($("#name").val() == "") {
                                                    alert("用户名不得为空哦");
                                                    return;
                                                } else if ($("#pass").val() != $("#pass2").val()) {
                                                    alert("两次密码不一致");
                                                    return;
                                                } else {
                                                    $.post(
                                                        '/user/reg.php?act=reg_in', {
                                                            "username": $("#name").val(),
                                                            "password": $("#pass").val(),
                                                            "code": $("#code").val(),
                                                            "vCode": <?=DID?>
                                                        }, function (data) {
                                                            if (data.status == "success") {
                                                                window.location.href = "/kangml_app/client.php?action=successReg";
                                                            } else {
                                                                $(".ccode").attr({"src": "mode/check_code.php?t=" + Date.parse(new Date())});
                                                                alert(data.msg);
                                                            }
                                                        }, "JSON"
                                                    )
                                                }
                                            }

                                            function sysC() {
                                                window.myObj.colsePage();
                                            }

                                            $(function () {
                                                $('#myModal').modal({
                                                    keyboard: true
                                                })
                                            });
                                        </script>
                                    </div><!-- End: .card -->
                                </div><!-- End: .edit-profile -->
                            </div><!-- End: .col-xl-5 -->
                        </div>
                    </div><!-- End: .signUp-admin-right  -->
                </div><!-- End: .col-xl-8  -->
            </div>
        </div>
    </div><!-- End: .signUP-admin  -->