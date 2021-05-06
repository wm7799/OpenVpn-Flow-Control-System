<?php
$title = '仪表盘';
include("api_head.php");
include("nav.php");
$shengyuFlow = round(($userinfo['maxll'] - $userinfo['isent'] - $userinfo['irecv']) / 1024 / 1024);
$totalFLow = round($userinfo['maxll'] / 1024 / 1024);
?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">仪表盘</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card revenueChartTwo broder-0 mb-4">
                        <div class="card-header">
                            <h6>流量</h6>
                        </div>
                        <!-- ends: .card-header -->
                        <div class="card-body px-sm-50 pb-sm-50 pt-sm-45 px-30 pb-30 pt-25 mb-sm-30">
                            <div class="d-flex justify-content-center">
                                <div class="">
                                    <div class="sales-target__progress-bar">
                                        <div class="left"></div>
                                        <div class="right">
                                            <div class="back"></div>
                                        </div>
                                        <div class="barOverflow">
                                            <div class="bar">
                                                <div class="top-circle"></div>
                                            </div>
                                        </div>
                                        <div class="total-count">
                                            <span><?= round($shengyuFlow / $totalFLow, 0) ?></span>%
                                            <div class="total-count__text">
                                                已使用
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sales-target d-flex justify-content-between">
                                <div class="sales-target__single">
                                    <h3 class="text-success"><?php echo $shengyuFlow; ?> M</h3>
                                    <span class="fs-14 color-gray">剩余流量</span>
                                </div>
                                <!-- ends: .cashflow-display__single -->
                                <div class="sales-target__single">
                                    <h3><?php echo $totalFLow ?> M</h3>
                                    <span class="fs-14 color-gray">总流量</span>
                                </div>
                                <!-- ends: .cashflow-display__single -->
                            </div>
                            <!-- ends: .performance-stats -->
                        </div>
                        <!-- ends: .card-body -->
                    </div>
                    <!-- ends: .card -->
                </div>
                <div class="col-lg-6">
                    <div class="card banner-feature banner-feature--2">
                        <div class="banner-feature__shape">
                            <img src="../img/svg/Group9010.svg" alt="img" class="svg">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-body">
                                <h1 class="banner-feature__heading color-white">有效期至</h1>
                                <p class="banner-feature__para color-white"><?php echo date("Y年m月d日", $userinfo["endtime"]); ?></p>
                                <?php
                                if ($userinfo["daili"] == 0) {
                                    ?>
                                    <button class="banner-feature__btn btn color-primary btn-md px-20 bg-white radius-xs fs-15"
                                            type="button" onclick="window.location.href='tc.php'">前往充值
                                    </button>
                                <?php }else{?>
                                    <button class="banner-feature__btn btn color-primary btn-md px-20 bg-white radius-xs fs-15"
                                            type="button" onclick="window.location.href='charge.php'">前往充值
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include("api_footer.php");
?>