<div class="notification-wrapper top-right"></div>
<footer class="footer-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-copyright">
                    <p>2021 @<a href="#">用户中心</a>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="footer-menu text-right">
                    <ul>
                        <li>
                            <a href="#">永远相信美好的事情即将发生</a>
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
</body>

</html>