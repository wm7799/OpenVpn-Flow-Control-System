<?php
$title = '线路安装配置';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $m->type("cfg_zs")->update("ca", $_POST["ca"]);
    $m->type("cfg_zs")->update("tls", $_POST["tls"]);
    $m->type("cfg_zs")->update("domain", $_POST["domain"]);
    $m->type("cfg_zs")->update("onoff", $_POST["onoff"]);
    tip_success("修改成功", $_SERVER['HTTP_REFERER']);
} else {
    $action = "?act=update";
    $info = $m->type("cfg_zs")->getAll();
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
                                <p>如果开启此功能，用户安装线路时，会强制修正线路证书为如下内容。如果关闭，则按线路中的证书安装。此功能仅仅影响线路，不会修改openvpn本身的证书。如果你需要替换证书，请替换/etc/openvpn/easy-rsa/
                                </p>
                                <form role="form" method="POST" action="<?php echo $action ?>">
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">域名/IP(线路中 [domain]
                                            会被替换成域名)</label>
                                            <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="domain"
                                                   value="<?php echo $info['domain'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">CA证书</label>

                                            <textarea class="form-control" rows="10"
                                                      name="ca"><?php echo $info['ca'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">tls-auth</label>

                                            <textarea class="form-control" rows="10"
                                                      name="tls"><?php echo $info['tls'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="onoff"
                                                           value="1" <?php echo $info["onoff"] == 1 ? " checked " : ""; ?>>是否启用
                                                </label>
                                            </div>
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
