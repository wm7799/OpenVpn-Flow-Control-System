<?php
$title = '支付接口配置';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $m->type("cfg_pay")->update("pay_on", $_POST["pay_on"]);
    $m->type("cfg_pay")->update("app_id", $_POST["app_id"]);
    $m->type("cfg_pay")->update("app_key", $_POST["app_key"]);
    $m->type("cfg_pay")->update("fk_pass", $_POST["fk_pass"]);
    $m->type("cfg_pay")->update("fk_mail", $_POST["fk_mail"]);
    $m->type("cfg_pay")->update("notify_url", $_POST["notify_url"]);
    $m->type("cfg_pay")->update("return_url", $_POST["return_url"]);
    tip_success("修改成功", 'pay.php');
} elseif ($_GET['act'] == 'add') {
    $db = db('app_daili_type');
    if ($db->insert(array(
        'name' => $_POST['name'],
        'per' => $_POST['per']
    ))) {
        tip_success("操作成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
} else {
    $action = "?act=update";
    $info["pay_on"] = $m->type("cfg_pay")->getValue("pay_on");
    $info["app_id"] = $m->type("cfg_pay")->getValue("app_id");
    $info["app_key"] = $m->type("cfg_pay")->getValue("app_key");
    $info["notify_url"] = $m->type("cfg_pay")->getValue("notify_url");
    $info["return_url"] = $m->type("cfg_pay")->getValue("return_url");
    $info["fk_pass"] = $m->type("cfg_pay")->getValue("fk_pass");
    $info["fk_mail"] = $m->type("cfg_pay")->getValue("fk_mail");

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
                        <div class="card-header">
                            <h6>
                                * 本支付系统采用的“<a href="https://www.fakajun.com" target="_blank">发卡君</a>”提供的API，筑梦工作室提供技术支持。请前往<a
                                        href="https://www.fakajun.com" target="_blank">发卡君</a>注册并申请APP_ID与APP_KEY，方能使用支付系统。
                                <br>
                                * 订单查询请暂时前往发卡君官网或者后台。
                            </h6>
                        </div>
                        <div class="card-body pb-md-30">
                            <div class="Vertical-form">
                                <form method="POST" action="<?php echo $action ?>">
                                    <div class="form-group">
                                        <div class="countryOption">
                                            <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                                代理充值 <span style="color:red">*</span>
                                            </label>
                                            <select class="js-example-basic-single js-states form-control"
                                                    id="countryOption" name="pay_on">
                                                <option value="pay_off">关闭支付</option>
                                                <option value="pay" <?php echo $info["pay_on"] == "pay" ? "selected" : ""; ?>>
                                                    开启支付
                                                </option>
                                            </select>
                                            <a href="https://www.fakajun.com/" target="_blank" class="btn btn-default">前往发卡君</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput" class="color-dark fs-14 fw-500 align-center">APP_ID
                                            <span style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput" name="app_id" placeholder=""
                                               value="<?php echo $info['app_id'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput2"
                                               class="color-dark fs-14 fw-500 align-center">APP_KEY <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput2" name="app_key" placeholder=""
                                               value="<?php echo $info['app_key'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput3"
                                               class="color-dark fs-14 fw-500 align-center">支付结果回调地址 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput3" name="notify_url" placeholder=""
                                               value="<?php echo $info['notify_url'] ?>">
                                        <p>一般为：http://<?= $_SERVER['HTTP_HOST'] ?>/daili/notify_url.php</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput4"
                                               class="color-dark fs-14 fw-500 align-center">支付后跳转地址 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput4" name="return_url" placeholder=""
                                               value="<?php echo $info['return_url'] ?>">
                                        <p>一般为：http://<?= $_SERVER['HTTP_HOST'] ?>/daili/order.php</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput5"
                                               class="color-dark fs-14 fw-500 align-center">发卡君邮箱（用于提现） <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput5" name="fk_mail" placeholder=""
                                               value="<?php echo $info['fk_mail'] ?>">
                                        <p>一般为：http://<?= $_SERVER['HTTP_HOST'] ?>/daili/order.php</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput6"
                                               class="color-dark fs-14 fw-500 align-center">发卡君密码（用于提现）<span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput6" name="fk_pass" placeholder=""
                                               value="<?php echo $info['fk_pass'] ?>">
                                    </div>
                                    <div class="layout-button mt-25">
                                        <button type="submit" class="btn btn-primary btn-default btn-squared px-30 btn-block">
                                            提交数据
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ends: .card -->
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkStr() {
            var title = $('[name="title"]').val();
            var content = $('[name="per"]').val();
            if (title == "" || content == "") {
                alert("参数不完整");
                return false;
            }
            return true;
        }
    </script>
    <?php
}
include('footer.php');
?>
