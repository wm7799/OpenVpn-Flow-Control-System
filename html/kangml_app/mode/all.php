<?php
$u = @$_GET['username'];
$p = @$_GET['password'];
$res = db(_openvpn_)->where(array(_iuser_ => $u, _ipass_ => $p))->find();
$rs[sum] = &round($res['maxll'] / 1024 / 1024); //总数
$rs[row] = &round(($res['maxll'] - $res['isent'] - $res['irecv']) / 1024 / 1024); //单个数
$rs[rjian] = &round($rs[sum] - $rs[row]);
$rs[ro1] = &round($rs[rjian] / $rs[sum] * 100, 2);
$precision = 2;
$gb = 1024;
$tb = 1024 * $gb;
$llzs = &round($rs[sum] / $gb, $precision);//总套餐
$llsy = &round($rs[row] / $gb, $precision);//剩余套餐
$m = new Map();
$config = $m->type("cfg_app")->getAll();
$time = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>会员中心</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="mode/css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<section class="aui-flexView">
    <div class="aui-flex-box aui-flex-box-bg">
        <div class="aui-flex-box-hd">
            <?php
            if (preg_match($regex, $res['email'])) {
                echo '<img src="mode/images/user.png" alt="">';
            } else {
                echo '<a href=""><img src="mode/images/not_tx.png" alt=""></a>';
            } ?>
        </div>
        <div class="aui-flex-box-bd">
            当前用户：<h2 style="color: yellow"><?php echo $res['iuser']; ?></h2>
            <div class="aui-line-info">
                <div class="aui-line-width" style="width:<?= $rs[ro1] ?>%"></div>
            </div>
            <!--echo round($rs[row]/$rs[sum]*100)."％";-->
            <p><?= $llsy ?>GB/<?= $llzs ?>GB 已用<?= $rs[ro1] ?>%</p>
        </div>
        <a href="<?php
        echo '?action=shop' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
        ?>" class="aui-flex-box-fr">
            充值续费
        </a>
    </div>
    <div class="aui-list-box">
        <div class="aui-local-box">
            <div class="aui-local-box-hd">扩展功能</div>
            <div class="aui-local-box-bd"></div>
        </div>
        <div class="aui-palace aui-palace-one clearfix">

            <a href="<?php
            echo '?action=user_info' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
            ?>" class="aui-palace-grid aui-brt">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-005.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>详细信息</h2>
                </div>
            </a>
            <a href="<?php
            echo '?action=line' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
            ?>" class="aui-palace-grid aui-brt">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-003.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>线路安装</h2>
                </div>
            </a>
            <a href="<?php
            echo '?action=notice_list' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
            ?>" class="aui-palace-grid aui-brt">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-002.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>消息通知</h2>
                </div>
            </a>
            <a href="<?php
            echo '?action=llog' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
            ?>" class="aui-palace-grid">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-004.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>使用记录</h2>
                </div>
            </a>
            <a href="<?php
            echo '?action=top' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
            ?>" class="aui-palace-grid">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-006.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>流量排行</h2>
                </div>
            </a>
            <a href="<?php
            echo 'html/help.html';
            ?>" class="aui-palace-grid">
                <div class="aui-palace-grid-icon">
                    <img src="mode/images/icon-hd-010.jpg" alt="">
                </div>
                <div class="aui-palace-grid-text">
                    <h2>使用帮助</h2>
                </div>
            </a>
        </div>
    </div>
    <div class="divHeight"></div>
    <div class="aui-ad-bar">
        <a href="<?php
        echo '?action=shop' . '&username=' . $_GET['username'] . '&password=' . $_GET['password'];
        ?>">
        <img src="mode/images/ad-001.png" alt=""></a>
    </div>
    <div class="divHeight"></div>
    <div class="aui-list-box">
        <div class="aui-palace aui-palace-one clearfix">
            <center>
                <br>
                <br>
                <div class="aui-ad-bar">
                    <p>软件已安全运行</p>
                    <span id="sitetime" style="color: #BC1717 ;"></span>
                </div>
            </center>
            <script language=javascript>
                function siteTime() {
                    window.setTimeout("siteTime()", 1000);
                    var seconds = 1000;
                    var minutes = seconds * 60;
                    var hours = minutes * 60;
                    var days = hours * 24;
                    var years = days * 365;
                    var today = new Date();
                    var todayYear = today.getFullYear();
                    var todayMonth = today.getMonth() + 1;
                    var todayDate = today.getDate();
                    var todayHour = today.getHours();
                    var todayMinute = today.getMinutes();
                    var todaySecond = today.getSeconds();
                    var t1 = Date.UTC(2021, 05, 09, 00, 00, 00); //设置起始时间
                    var t2 = Date.UTC(todayYear, todayMonth, todayDate, todayHour, todayMinute, todaySecond);
                    var diff = t2 - t1;
                    var diffYears = Math.floor(diff / years);
                    var diffDays = Math.floor((diff / days) - diffYears * 365);
                    var diffHours = Math.floor((diff - (diffYears * 365 + diffDays) * days) / hours);
                    var diffMinutes = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours) / minutes);
                    var diffSeconds = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours - diffMinutes * minutes) / seconds);
                    document.getElementById("sitetime").innerHTML = " " + diffYears + " 年 " + diffDays + " 天 " + diffHours + " 小时 " + diffMinutes + " 分钟 " + diffSeconds + " 秒";
                }
                siteTime();
            </script>
        </div>
    </div>
</section>
