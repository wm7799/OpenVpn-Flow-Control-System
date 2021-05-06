<?php
$title = '限速设置';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $limit = $_POST["limit"];
    $total = $_POST["total"];
    $content = "default {$limit}
total {$total}";
    $info = file_put_contents("/etc/openvpn/bwlimitplugin.cnf", $content);
    tip_success("修改成功", $_SERVER['HTTP_REFERER']);
} else {
    $action = "?act=update";
    $info = file_get_contents("/etc/openvpn/bwlimitplugin.cnf");
    $p = '/default\s([0-9]*)/';
    preg_match($p, $info, $m);
    $p = '/total\s([0-9]*)/';
    preg_match($p, $info, $m2);
    ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center user-member__title mb-30 mt-30">
                        <h4 class="text-capitalize"><?= $title ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-Vertical card-default card-md mb-4">
                        <div class="card-body pb-md-30">
                            <div class="Vertical-form">
                                <form role="form" method="POST" action="<?php echo $action ?>">
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">服务器总带宽/Mbps</label>
                                        <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="total"
                                               value="<?php echo $m2[1] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">速度限制（Kbps 1000Kps = 1Mbps宽带
                                            即0.128m/s ）</label>
                                            <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="limit"
                                                   value="<?php echo $m[1] ?>">
                                            <br>
                                            <p>
                                                服务器总带宽：服务器总带宽,单位/Mbps,一般无需修改!
                                                <br><br>
                                                速度限制：此功能可以限制每个用户的下行速度,默认为1000Mbps,低于100Mbps的服务器无须修改,限速只是限制下载速度,而且只是大概数值,会与手机统计有所偏差,速度限制：1024Kbps = 1Mbps = 128kb/s严格按照此公式计算,默认限速不允许超过总带宽,否则连不上线路。
                                                <br><br>
                                                修改后必须重启VPN,不会修改就慎改！
                                            </p>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">提交数据</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('footer.php');
?>
