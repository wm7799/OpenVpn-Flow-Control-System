<?php
$title = '限速设置';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $limit = $_POST["limit"];
    $content = "default {$limit}
		total 1000";
    $info = file_put_contents("/etc/openvpn/bwlimitplugin.cnf", $content);
    tip_success("修改成功", $_SERVER['HTTP_REFERER']);
} else {
    $action = "?act=update";
    $info = file_get_contents("/etc/openvpn/bwlimitplugin.cnf");
    $p = '/default\s([0-9]*)/';
    preg_match($p, $info, $m);
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
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">速度限制（Kbps 1000Kps = 1Mbps宽带
                                            即0.128m/s ）</label>
                                            <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="limit"
                                                   value="<?php echo $m[1] ?>">
                                            <br>
                                            <p>
                                                此功能可以限制每个用户的下行速度，设置完成后请重启VPN。限速只是限制下载速度，而且只是大概数值，会与手机统计有所偏差。
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
