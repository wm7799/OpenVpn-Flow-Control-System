<?php
require 'head.php';
require 'nav.php';
function unsetLine($arr)
{
    foreach ($arr as $v) {
        if (strpos($v, "apache") === 0) {

        } else {
            $line[] = $v;
        }
    }
    return $line;
}

$nums = db(_openvpn_)->getnums(); //注册用户
$user_num = db(_openvpn_)->where(["i" => "1"])->getnums(); //有效用户
$nums2 = db(_openvpn_)->where(["online" => "1"])->getnums(); //在线用户
$nums3 = db("auth_fwq")->where()->getnums(); //在线服务器
?>
<div class="contents">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">仪表盘</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">

                        <div class="dropdown action-btn">
                            <button class="btn btn-sm btn-primary btn-add dropdown-toggle" type="button"
                                    id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="la la-share"></i> 快捷菜单
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                <span class="dropdown-item">快速进入功能</span>
                                <div class="dropdown-divider"></div>
                                <a href="user_add.php" class="dropdown-item">
                                    <i class="la la-user"></i> 添加用户</a>
                                <a href="dl_add.php" class="dropdown-item">
                                    <i class="la la-user-check"></i> 添加代理</a>
                                <a href="fwq_add.php" class="dropdown-item">
                                    <i class="la la-server"></i> 添加服务器</a>
                                <a href="line_add.php" class="dropdown-item">
                                    <i class="la la-edit"></i> 添加线路</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-12 mb-25">
                <div class="row">
                    <div class="col-md-3 mb-25">
                        <div class="forcast-cardbox">
                            <h6 class="forcast-title">有效用户</h6>
                            <div class="forcast-details">
                                <h1 class="forcast-value"><?= $user_num ?> 人</h1>
                                <p class="forcast-status">
								<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>0</span>
								</span>
                                    <span class="forcast-text">人</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">


                                    <div>
                                        <canvas id="lineChartforcastOne"></canvas>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-md-3 mb-25">
                        <div class="forcast-cardbox">
                            <h6 class="forcast-title">代理</h6>
                            <div class="forcast-details">
                                <h1 class="forcast-value">0 人</h1>
                                <p class="forcast-status">
								<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>0</span>
								</span>
                                    <span class="forcast-text">人</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">


                                    <div>
                                        <canvas id="lineChartforcastTwo"></canvas>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-md-3 mb-25">
                        <div class="forcast-cardbox">
                            <h6 class="forcast-title">总流量</h6>
                            <div class="forcast-details">
                                <h1 class="forcast-value">0 G</h1>
                                <p class="forcast-status">
								<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>0</span>
								</span>
                                    <span class="forcast-text">G</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">


                                    <div>
                                        <canvas id="lineChartforcastOne"></canvas>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-md-3 mb-25">
                        <div class="forcast-cardbox">
                            <h6 class="forcast-title">总收入</h6>
                            <div class="forcast-details">
                                <h1 class="forcast-value">0 元</h1>
                                <p class="forcast-status">
								<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>0</span>
								</span>
                                    <span class="forcast-text">元</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">


                                    <div>
                                        <canvas id="lineChartforcastTwo"></canvas>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-lg-6 mb-25">

                        <div class="card broder-0">
                            <div class="card-header">
                                <h6>七天流量统计（单位GB）</h6>
                            </div>
                            <!-- ends: .card-header -->
                            <div class="card-body pt-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="tl_revenue-year" role="tabpanel"
                                         aria-labelledby="tl_revenue-year-tab">
                                        <div class="revenue-labels">
                                            <div>
                                                <strong class="text-primary">0</strong>
                                                <span>7天最低使用量</span>
                                            </div>
                                            <div>
                                                <strong>0</strong>
                                                <span>7天内最高使用量</span>
                                            </div>
                                        </div>
                                        <!-- ends: .performance-stats -->

                                        <div class="wp-chart">
                                            <div class="parentContainer">


                                                <div>
                                                    <canvas id="myChart6"></canvas>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ends: .card-body -->
                        </div>

                    </div>
                    <div class="col-lg-6 mb-25">
                        <div class="row">
                            <div class="col-md-6 mb-25">
                                <div class="ratio-box card">
                                    <div class="card-body">
                                        <h6 class="ratio-title">今日上线比例</h6>
                                        <div
                                                class="ratio-info d-flex justify-content-between align-items-center">
                                            <h1 class="ratio-point">0 人</h1>
                                            <span class="ratio-percentage color-success">0%</span>
                                        </div>
                                        <div class="progress-wrap mb-0">
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="width: 80%;" aria-valuenow="80" aria-valuemin="0"
                                                     aria-valuemax="100"></div>

                                            </div>
                                            <span class="progress-text">
											<span class="color-dark dark">0 人</span>
											<span class="progress-target">未上线</span>
										</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- ends: .ratio-box -->
                            </div>
                            <div class="col-md-6 mb-25">
                                <div class="ratio-box card">
                                    <div class="card-body">
                                        <h6 class="ratio-title">卡密使用比例</h6>
                                        <div
                                                class="ratio-info d-flex justify-content-between align-items-center">
                                            <h1 class="ratio-point">0 张</h1>
                                            <span class="ratio-percentage color-success">0%</span>
                                        </div>
                                        <div class="progress-wrap mb-0">
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: 80%;" aria-valuenow="80" aria-valuemin="0"
                                                     aria-valuemax="100"></div>

                                            </div>
                                            <span class="progress-text">
											<span class="color-dark dark">0 张</span>
											<span class="progress-target">总卡密数量</span>
										</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- ends: .ratio-box -->
                            </div>
                            <div class="col-md-6 mb-25">
                                <div
                                        class="feature-cards5 d-flex justify-content-between border-0 radius-xl bg-white p-25">
                                    <div class="application-task d-flex align-items-center">
                                        <div class="application-task-icon wh-60 bg-secondary content-center">
                                            <img class="svg" src="img/svg/feature-cards10.svg" alt="">
                                        </div>
                                        <div class="application-task-content">
                                            <h4 class="bwjk">Loading</h4>
                                            <span class="text-light fs-14 mt-1 text-capitalize">实时网速 M/s</span>
                                        </div>
                                    </div>
                                    <div class="card__more-action dropdown dropdown-click">
                                        <button class="btn-link border-0 bg-transparent p-0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span data-feather="more-horizontal"></span>
                                        </button>
                                        <div class="dropdown-default dropdown-bottomLeft dropdown-menu-right dropdown-menu"
                                             x-placement="top-end"
                                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-96px, -137px, 0px);">
                                            <a class="dropdown-item" href="net.php">查看网速历史</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-25">
                                <div
                                        class="feature-cards5 d-flex justify-content-between border-0 radius-xl bg-white p-25">
                                    <div class="application-task d-flex align-items-center">
                                        <div class="application-task-icon wh-60 bg-primary content-center">
                                            <img class="svg" src="img/svg/feature-cards9.svg" alt="">
                                        </div>
                                        <div class="application-task-content">
                                            <h4><?= $nums3 ?></h4>
                                            <span class="text-light fs-14 mt-1 text-capitalize">在线服务器</span>
                                        </div>
                                    </div>
                                    <div class="card__more-action dropdown dropdown-click">
                                        <button class="btn-link border-0 bg-transparent p-0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span data-feather="more-horizontal"></span>
                                        </button>
                                        <div class="dropdown-default dropdown-bottomLeft dropdown-menu-right dropdown-menu"
                                             x-placement="top-end"
                                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-96px, -137px, 0px);">
                                            <a class="dropdown-item" href="#">view</a>
                                            <a class="dropdown-item" href="#">edit</a>
                                            <a class="dropdown-item" href="#">delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 m-bottom-30">
                <div class="device-chart-box">

                    <div class="card broder-0">
                        <div class="card-header">
                            <h6>在线状态</h6>
                        </div>
                        <!-- ends: .card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="se_device-month" role="tabpanel"
                                     aria-labelledby="se_device-month-tab">
                                    <div class="device-pieChart-wrap position-relative">
                                        <div class="pie-chart-legend">
                                            <p>
                                                <span><?= $nums2 ?></span>总人数
                                            </p>
                                        </div>


                                        <div>
                                            <canvas id="chartDoughnut2"></canvas>
                                        </div>


                                    </div>
                                    <div class="session-wrap">
                                        <div class="session-single">
                                            <div class="chart-label">
                                                <span class="label-dot dot-success"></span>
                                                TCP
                                            </div>
                                            <strong>0</strong>
                                            <sub>0%</sub>
                                        </div>
                                        <div class="session-single">
                                            <div class="chart-label">
                                                <span class="label-dot dot-info"></span>
                                                UDP
                                            </div>
                                            <strong>0</strong>
                                            <sub>0%</sub>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <!-- ends: .session-wrap -->
                        </div>
                        <!-- ends: .card-body -->
                    </div>

                </div>
            </div>
            <div class="col-md-4 mb-25">

                <div class="card revenueChartTwo broder-0">
                    <div class="card-header">
                        <h6>系统状态</h6>
                        <div class="card-extra">
                            <div class="dropdown dropleft">
                                <a href="#" role="button" id="revenue4" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <span data-feather="more-horizontal"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="revenue4">
                                    <a class="dropdown-item" href="#">待添加</a>
                                    <a class="dropdown-item" href="#">待添加</a>
                                    <a class="dropdown-item" href="#">待添加</a>
                                </div>
                            </div>
                        </div>
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
                                        <span>22</span>%
                                        <div class="total-count__text">
                                            平均负荷
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="sales-target d-flex justify-content-between">
                            <div class="sales-target__single">
                                <?php
                                exec("top -bn1 | grep Cpu", $cpuinfo);
                                //99.2 id
                                preg_match('/\s*([0-9\.]*)\s*id/is', $cpuinfo[0], $cpuinfo_free);
                                $lyl = 100 - (float)$cpuinfo_free[1];
                                ?>
                                <h3 class="text-success"><?= $lyl ?>%</h3>
                                <span class="fs-14 color-gray">CPU使用率</span>
                            </div>
                            <!-- ends: .cashflow-display__single -->
                            <div class="sales-target__single"><h3><?php
                                    //内存使用率
                                    $free = shell_exec('free');
                                    $free = (string)trim($free);
                                    $free_arr = explode("\n", $free);
                                    $mem = explode(" ", $free_arr[1]);
                                    $mem = array_filter($mem);
                                    $mem = array_merge($mem);
                                    $memory_usage = round($mem[2] / $mem[1] * 100, 2);
                                    echo $memory_usage . '%';
                                    ?></h3>
                                <span class="fs-14 color-gray">内存使用率</span>
                            </div>
                            <!-- ends: .cashflow-display__single -->
                        </div>
                        <!-- ends: .performance-stats -->
                    </div>
                    <!-- ends: .card-body -->
                </div>

            </div>
            <div class="col-md-4 mb-25">
                <div class="card card-default card-md mb-4">
                    <div class="card-header  py-20">
                        <h6>已开启端口</h6>
                    </div>
                    <div class="card-body">
                        <div class="atbd-tag-wrap mb-25">
                            <h6>TCP:</h6>
                            <div class="tag-box">
                                <?php
                                exec(" netstat -nap|grep tcp|grep \"0.0.0.0:\"", $tcp);
                                $tcp = unsetLine($tcp);
                                preg_match_all("/\:([0-9]*)/", implode("\n", $tcp), $m);
                                foreach ($m[1] as $v) {
                                    if ($v != '') {
                                        echo '<span class="atbd-tag tag-primary tag-transparented">' . $v . '</span> ';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="atbd-tag-wrap">
                            <h6>UDP:</h6>
                            <div class="tag-box">
                                <?php
                                exec(" netstat -nap|grep udp|grep \"0.0.0.0:\"", $udp);
                                $udp = unsetLine($udp);
                                preg_match_all("/\:([0-9]*)/", implode("\n", $udp), $m);
                                foreach ($m[1] as $v) {
                                    if ($v != '') {
                                        echo '<span class="atbd-tag tag-info tag-transparented">' . $v . '</span> ';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ends: .card -->
                <div class="card card-default card-md mb-4">
                    <div class="card-header  py-20">
                        <h6>监控系统</h6>
                    </div>
                    <div class="card-body">

                        <div class="atbd-tag-wrap">
                            <div class="tag-box">
                                <?php
                                exec("ps aux|grep jk.sh", $jiankong);
                                $jiankong = unsetLine($jiankong);
                                $run = false;
                                foreach ($jiankong as $v) {
                                    $run = true;
                                }
                                if ($run) {
                                    echo '<span class="atbd-tag tag-success ">用户状态监控 正常</span>';
                                } else {
                                    echo '<span class="atbd-tag tag-warning ">用户状态监控 异常</span>';
                                }
                                exec(" ps aux|grep FasAUTH.bin", $jiankong2);
                                $jiankong2 = unsetLine($jiankong2);
                                $run = false;
                                foreach ($jiankong2 as $v) {
                                    $run = true;
                                }
                                if ($run) {
                                    echo '<span class="atbd-tag tag-success ">用户流量监控 正常</span>';
                                } else {
                                    echo '<span class="atbd-tag tag-warning ">用户流量监控 异常</span>';
                                }
                                exec(" ps aux|grep sh_openvpn", $jiankong3);
                                $jiankong3 = unsetLine($jiankong3);
                                $run = false;
                                foreach ($jiankong3 as $v) {
                                    $run = true;
                                }
                                if ($run) {
                                    echo '<span class="atbd-tag tag-success ">流控进程守护 正常</span>';
                                } else {
                                    echo '<span class="atbd-tag tag-warning ">流控进程守护 异常</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ends: .card -->
            </div>
        </div>

    </div>
</div>
<?php
include "footer.php";
?>

<script>
    $(function () {
        $.post("rateJson.php?act=bwi", {}, function (data) {
            console.log(data)
            $(".bwjk").html(data);
        });
        setTimeout(function () {
            $.post("rateJson.php?act=bwi", {}, function (data) {
                $(".bwjk").html(data);
            });
        }, 100000);
    });
    AmCharts.ready(function () {
        $.post("rateJson.php?", {}, function (json) {
            var chart = new AmCharts.AmSerialChart();
            chart.dataProvider = json;
            chart.categoryField = "name";
            chart.angle = 30;
            chart.depth3D = 20;
            //标题
            chart.addTitle("15天流量趋势(单位GB)", 15);
            var graph = new AmCharts.AmGraph();
            chart.addGraph(graph);
            graph.valueField = "value";
            //背景颜色透明度
            graph.fillAlphas = 0.3;
            //类型
            graph.type = "line";
            //圆角
            graph.bullet = "round";
            //线颜色
            graph.lineColor = "#328cc9";
            //提示信息
            graph.balloonText = "[[value]] G";
            var categoryAxis = chart.categoryAxis;
            categoryAxis.autoGridCount = false;
            categoryAxis.gridCount = json.length;
            categoryAxis.gridPosition = "start";
            chart.write("line");
        }, "JSON");

    });
</script>