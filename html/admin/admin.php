<?php
$title = "仪表盘";
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
$tcpOnlineNum = db(_openvpn_)->where(["online" => "1", "proto" => "tcp-server"])->getnums(); //在线tcp用户
$udpOnlineNum = db(_openvpn_)->where(["online" => "1", "proto" => "udp"])->getnums(); //在线udp用户
$nums3 = db("auth_fwq")->where()->getnums(); //在线服务器
$dailiNum = db("app_daili")->where()->getnums(); //代理数量
$kmNum = db("app_kms")->where()->getnums(); //卡密数量
$isUseKmNum = db("app_kms")->where(["isuse" => 1])->getnums(); //已使用卡密数量
//流量统计
$totalFlow = 0;
for ($i = 0; $i <= 30; $i++) {
    $t = time() - ((30 - $i) * 24 * 60 * 60);
    $p = date("Y-m-d", $t);
    $rs = db("top")->where(["time" => $p])->select();
    if ($rs) {
        $value = 0;
        foreach ($rs as $res) {
            $value += $res['data'] / 1024 / 1024 / 1024;
        }
        $totalFlow += $value;
        if ($i > 15) $flowDayArr[] = round($value, 2);
        if ($i > 20) $flowDaySumArr[] = round($totalFlow, 2);
    } else {
        if ($i > 15) $flowDayArr[] = 0;
        if ($i > 20) $flowDaySumArr[] = round($totalFlow, 2);
    }
}
//今日在线人数
$todayTime = strtotime(date('Y-m-d', time()));//今天0点
$todayOnlineNum = db(_openvpn_)->where("`login_time` > " . $todayTime)->getnums();
$notOnlineNum = $nums - $todayOnlineNum;
$efUserArr = json_decode(db("dash")->where(["name" => "ef_user"])->select()[0]["content"]);//有效用户历史数组
$dailiArr = json_decode(db("dash")->where(["name" => "daili"])->select()[0]["content"]);//代理历史数组
//收入
$income = db('pay_order')->f('SUM(`money`)')->where(['status'=>1])->find()['SUM(`money`)'] ?? 0;
$todayMoney = 0;
for ($i = 0; $i <= 10; $i++) {
    $day = -10 + $i;
    $rs = db("pay_order")->f('SUM(`money`)')->where("DATEDIFF(`addtime`,NOW())=".$day." AND `status`=1")->find()['SUM(`money`)'];
    if ($rs) {
        if ($day == 0) $todayMoney = $rs;
        $moneyDayArr[] = $rs;
    } else {
        if ($day == 0) $todayMoney = 0;
        $moneyDayArr[] = 0;
    }
}
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
                                    <?php
                                    $lastEfUser = $user_num - $efUserArr[9];
                                    if ($lastEfUser >= 0) {
                                        echo '<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>' . $lastEfUser . '</span>
								</span>';
                                    } else {
                                        echo '<span class="percentage color-danger">
									<span data-feather="arrow-down"></span>
									<span>' . $lastEfUser . '</span>
								</span>';
                                    }
                                    ?>
                                    <span class="forcast-text">人</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">
                                    <div>
                                        <canvas id="efUserChart"></canvas>
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
                                <h1 class="forcast-value"><?= $dailiNum ?> 人</h1>
                                <p class="forcast-status">
                                    <?php
                                    $lastDaili = $dailiNum - $dailiArr[9];
                                    if ($lastDaili >= 0) {
                                        echo '<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>' . $lastDaili . '</span>
								</span>';
                                    } else {
                                        echo '<span class="percentage color-danger">
									<span data-feather="arrow-down"></span>
									<span>' . $lastDaili . '</span>
								</span>';
                                    }
                                    ?>
                                    <span class="forcast-text">人</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">
                                    <div>
                                        <canvas id="dailiChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-md-3 mb-25">
                        <div class="forcast-cardbox">
                            <h6 class="forcast-title">月总流量</h6>
                            <div class="forcast-details">
                                <h1 class="forcast-value"><?= round($totalFlow, 2) ?> G</h1>
                                <p class="forcast-status">
                                    <?php
                                    $lastFlow = $flowDaySumArr[9] - $flowDaySumArr[8];
                                    if ($lastFlow >= 0) {
                                        echo '<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span>' . $lastFlow . '</span>
								</span>';
                                    } else {
                                        echo '<span class="percentage color-danger">
									<span data-feather="arrow-down"></span>
									<span>' . $lastFlow . '</span>
								</span>';
                                    }
                                    ?>
                                    <span class="forcast-text">G</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">
                                    <div>
                                        <canvas id="monthFlowChart"></canvas>
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
                                <h1 class="forcast-value"><?=$income?> 元</h1>
                                <p class="forcast-status">
								<span class="percentage color-success">
									<span data-feather="arrow-up"></span>
									<span><?=$todayMoney ?></span>
								</span>
                                    <span class="forcast-text">元</span>
                                </p>
                            </div>
                            <div class="forcast__chart">
                                <div class="parentContainer">
                                    <div>
                                        <canvas id="moneyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ends: .forcast-cardbox -->
                    </div>
                    <div class="col-lg-6 mb-25">
                        <div class="card broder-0">
                            <div class="card-header">
                                <h6>近两周流量统计（单位GB）</h6>
                            </div>
                            <!-- ends: .card-header -->
                            <div class="card-body pt-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="tl_revenue-year" role="tabpanel"
                                         aria-labelledby="tl_revenue-year-tab">
                                        <div class="revenue-labels">
                                            <div>
                                                <strong class="text-primary"><?= min($flowDayArr) ?></strong>
                                                <span>最低使用量</span>
                                            </div>
                                            <div>
                                                <strong><?= max($flowDayArr) ?></strong>
                                                <span>最高使用量</span>
                                            </div>
                                        </div>
                                        <!-- ends: .performance-stats -->
                                        <div class="wp-chart">
                                            <div class="parentContainer">
                                                <div>
                                                    <canvas id="twoWeeksFlowChart"></canvas>
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
                                            <h1 class="ratio-point"><?= $todayOnlineNum ?> 人</h1>
                                            <span class="ratio-percentage color-success"><?= round($todayOnlineNum / $nums * 100, 0) ?>%</span>
                                        </div>
                                        <div class="progress-wrap mb-0">
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="width: <?= round($todayOnlineNum / $user_num * 100, 0) ?>%;"
                                                     aria-valuenow="<?= round($todayOnlineNum / $nums * 100, 0) ?>"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <span class="progress-text">
											<span class="color-dark dark"><?= $notOnlineNum ?> 人</span>
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
                                            <h1 class="ratio-point"><?= $isUseKmNum ?> 张</h1>
                                            <span class="ratio-percentage color-success"><?= round($isUseKmNum / $kmNum * 100, 0) ?>%</span>
                                        </div>
                                        <div class="progress-wrap mb-0">
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: <?= round($isUseKmNum / $kmNum * 100, 0) ?>%;"
                                                     aria-valuenow="<?= round($isUseKmNum / $kmNum * 100, 0) ?>"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <span class="progress-text">
											<span class="color-dark dark"><?= $kmNum ?> 张</span>
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
                                            <img class="svg" src="../img/svg/feature-cards10.svg" alt="">
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
                                            <img class="svg" src="../img/svg/feature-cards9.svg" alt="">
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
                                            <a class="dropdown-item" href="fwq_list.php">查看服务器</a>
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
                                            <canvas id="onlineChart"></canvas>
                                        </div>
                                    </div>
                                    <div class="session-wrap">
                                        <div class="session-single">
                                            <div class="chart-label">
                                                <span class="label-dot dot-success"></span>
                                                TCP
                                            </div>
                                            <strong><?= $tcpOnlineNum ?></strong>
                                            <sub><?= round($tcpOnlineNum / $nums2 * 100, 0) ?>%</sub>
                                        </div>
                                        <div class="session-single">
                                            <div class="chart-label">
                                                <span class="label-dot dot-info"></span>
                                                UDP
                                            </div>
                                            <strong><?= $udpOnlineNum ?></strong>
                                            <sub><?= round($udpOnlineNum / $nums2 * 100, 0) ?>%</sub>
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
                    </div>
                    <!-- ends: .card-header -->
                    <?php
                    //CPU使用率
                    exec("top -bn1 | grep Cpu", $cpuinfo);
                    preg_match('/\s*([0-9\.]*)\s*id/is', $cpuinfo[0], $cpuinfo_free);
                    $cpu_usage = 100 - (float)$cpuinfo_free[1];
                    //内存使用率
                    $free = shell_exec('free');
                    $free = (string)trim($free);
                    $free_arr = explode("\n", $free);
                    $mem = explode(" ", $free_arr[1]);
                    $mem = array_filter($mem);
                    $mem = array_merge($mem);
                    $memory_usage = round($mem[2] / $mem[1] * 100, 2);
                    ?>
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
                                        <span><?= round(($cpu_usage + $memory_usage) / 2, 0) ?></span>%
                                        <div class="total-count__text">
                                            平均负荷
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sales-target d-flex justify-content-between">
                            <div class="sales-target__single">
                                <h3 class="text-success"><?= $cpu_usage ?>%</h3>
                                <span class="fs-14 color-gray">CPU使用率</span>
                            </div>
                            <!-- ends: .cashflow-display__single -->
                            <div class="sales-target__single"><h3><?= $memory_usage ?>%</h3>
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
    chartjsLineChartForcast(
        "#efUserChart",
        (label = "有效用户图表"),
        (startGradient = "#5F63F212"),
        (endGradient = "#5F63F202"),
        (bColor = "#5F63F2"),
        (data = <?=json_encode($efUserArr)?>)
    );
    chartjsLineChartForcast(
        "#dailiChart",
        (label = "代理图表"),
        (startGradient = "#20C99712"),
        (endGradient = "#20C99703"),
        (bColor = "#20C997"),
        (data = <?=json_encode($dailiArr)?>)
    );
    chartjsLineChartForcast(
        "#monthFlowChart",
        (label = "月总流量图表"),
        (startGradient = "#5F63F212"),
        (endGradient = "#5F63F202"),
        (bColor = "#5F63F2"),
        (data = <?=json_encode($flowDaySumArr)?>)
    );
    chartjsLineChartForcast(
        "#moneyChart",
        (label = "总收入图表"),
        (startGradient = "#5F63F212"),
        (endGradient = "#5F63F202"),
        (bColor = "#5F63F2"),
        (data = <?=json_encode($moneyDayArr)?>)
    );
    function doHandleMonth(month) {
        var m = month;
        if (month.toString().length == 1) {
            m = "0" + month;
        }
        return m;
    }
    function getDay(day) {
        var today = new Date();
        var targetday_milliseconds = today.getTime() + 1000 * 60 * 60 * 24 * day;
        today.setTime(targetday_milliseconds); //注意，这行是关键代码
        var tMonth = today.getMonth();
        var tDate = today.getDate();
        tMonth = doHandleMonth(tMonth + 1);
        tDate = doHandleMonth(tDate);
        return tMonth + "-" + tDate;
    }
    chartjsLineChartFourFlow(
        "twoWeeksFlowChart",
        "#FA8B0C",
        "95",
        (data = <?=json_encode($flowDayArr)?>),
        (data = <?=json_encode($flowDayArr)?>),
        labels = [
            getDay(-11),
            getDay(-10),
            getDay(-9),
            getDay(-8),
            getDay(-7),
            getDay(-6),
            getDay(-5),
            getDay(-4),
            getDay(-3),
            getDay(-2),
            getDay(-1),
            getDay(0)
        ]
    );
    chartjsDoughnut(
        "onlineChart",
        "150",
        (data = [<?= $tcpOnlineNum ?>, <?= $udpOnlineNum ?>])
    );
    $(function () {
        $.post("rateJson.php?act=bwi", {}, function (data) {
            $(".bwjk").html(data);
        });
        setTimeout(function () {
            $.post("rateJson.php?act=bwi", {}, function (data) {
                $(".bwjk").html(data);
            });
        }, 100000);
    });
</script>