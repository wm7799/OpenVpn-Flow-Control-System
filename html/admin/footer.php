<div class="notification-wrapper top-right"></div>
<footer class="footer-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-copyright">
                    <p>2021 @<a href="https://www.kangml.com">kangml.com</a>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="footer-menu text-right">
                    <ul>
                        <li>
                            <a href="http://www.kangml.com/op">关于我们</a>
                        </li>
                        <li>
                            <a href="http://wpa.qq.com/msgrd?v=3&uin=2013163999&site=qq&menu=yes">联系客服</a>
                        </li>
                    </ul>
                </div>
                <!-- ends: .Footer Menu -->
            </div>
        </div>
    </div>
</footer>
</main>

<div class="overlay-dark-sidebar"></div>
<div class="customizer-overlay"></div>

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

<?php
//默认密码提示修改
if (($_SESSION["dd"]["username"] == "admin" && $_SESSION["dd"]["password"] == "admin") || strlen($_SESSION["dd"]["password"]) < 4) {
    ?>
    <div class="modal-info-error modal fade show" id="anquan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-info" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-info-body d-flex">
                        <div class="modal-info-icon danger">
                            <span data-feather="x-circle"></span>
                        </div>
                        <div class="modal-info-text">
                            <p>系统检测到您使用的是系统默认密码admin或者密码长度过短。请您立即 进入【系统设置】->【<a href="user.php">管理密码</a>】 修改密码！
                                为了您的系统安全，请勿使用纯数字密码、简易密码、默认密码！这很容易被入侵！</p>
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
    <script>
        $(() => {
            $('#anquan').modal()
        });
    </script>
    <?php
}
?>

<script>
    // TODO 去掉不需要的script
    function createToastK(icon, close, title, content) {
        let toast = ``;

        const notificationShocase = $('.notification-wrapper');
        toast = `
      <div class="atbd-notification-box notification-info notification-${toastCount}">
        <div class="atbd-notification-box__content media">
            <div class="atbd-notification-box__icon">
                <span data-feather="${icon}"></span>
            </div>
            <div class="atbd-notification-box__text media-body">
                <h6>${title}</h6>
                <p>
                    ${content}
                </p>
            </div>
        </div>
        <a href="#" class="atbd-notification-box__close" data-toast="close">
            <span data-feather="x"></span>
        </a>
    </div>
    `;

        if (close) {
            toast = `
        <div class="atbd-notification-box notification-default notification-${toastCount}">
            <div class="atbd-notification-box__content">
                <div class="atbd-notification-box__text">
                    <h6>${title}</h6>
                    <p>
                        ${content}
                    </p>
                </div>
                <script>
                    function gonggaoRead(){
                        $.post(
                            "./access.php",
                            {
                                "do": "readMsg",
                                "id": msg_id
                            }, function (data) {
                                $('.atbd-notification-box').remove();
                            });
                        }
                <\/script>
                <div class="atbd-notification-box__action d-flex justify-content-end">
                    <button class="btn btn-xs btn-info custom-close" onclick="gonggaoRead()">不再提醒</button>
                </div>
            </div>
            <a href="#" class="atbd-notification-box__close" data-toast="close">
                <span data-feather="x"></span>
            </a>
        </div>
        `
        }

        notificationShocase.append(toast);
        toastCount++;
    }

    function showTongZhi(toastIcon, customClose, title, content, Duration) {
        let duration = (optionValue, defaultValue) =>
            typeof optionValue === "undefined" ? defaultValue : optionValue;
        createToastK(toastIcon, customClose, title, content);
        feather.replace();
        let thisToast = toastCount - 1;

        $('*[data-toast]').on('click', function () {
            $(this).parent('.atbd-notification-box').remove();
        })

        setTimeout(function () {
            $(document).find(".notification-" + thisToast).remove();
        }, duration(Duration, 5000));

    }
</script>
<script>
    var msg_id = 0;
    $(function () {
        $.post(
            "./access.php",
            {
                "do": "getMsg"
            }, function (data) {
                $(".msg-num").html(data.length);//消息盒子数量图标
                if (data.length > 0) {
                    //只弹窗第一个公告，其他放在消息箱子里面
                    let e = data[0];
                    showTongZhi('icon', true, e.title, e.msg);
                    msg_id = e.id;
                }
            }, "JSON");
        $.post(
            "./access.php",
            {
                "do": "getALLMsg"
            }, function (data) {
                if (data.length > 0) {
                    let msgUI = $(".msg-ul");
                    data.forEach(e=>{
                        //详细消息
                        if (e.msg.length>8){
                            e.msg = e.msg.substr(0,8) + '...';
                        }
                        let msg = `<li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                        <div class="nav-notification__type nav-notification__type--info">
                                            <span data-feather="inbox"></span>
                                        </div>
                                        <div class="nav-notification__details">
                                            <p>
                                                <a href="" class="subject stretched-link text-truncate"
                                                    style="max-width: 180px;">${e.title}</a>
                                                <span>${e.msg}</span>
                                            </p>
                                            <p>
                                                <span class="time-posted">${e.time}</span>
                                            </p>
                                        </div>
                                    </li>`;
                        msgUI.append(msg);
                    })
                }
            }, "JSON");
    });
</script>
</body>

</html>