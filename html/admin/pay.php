<?php
$title = '支付接口配置';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $m->type("pay")->update("dailiPayOn", $_POST["dailiPayOn"]);
    $m->type("pay")->update("userPayOn", $_POST["userPayOn"]);
    $m->type("pay")->update("alipayOn", $_POST["alipayOn"]);
    $m->type("pay")->update("wechatpayOn", $_POST["wechatpayOn"]);
    $m->type("pay")->update("qqpayOn", $_POST["qqpayOn"]);
    $m->type("pay")->update("epayID", $_POST["epayID"]);
    $m->type("pay")->update("epayKey", $_POST["epayKey"]);
    $m->type("pay")->update("epaySite", $_POST["epaySite"]);
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
    $info["dailiPayOn"] = $m->type("pay")->getValue("dailiPayOn");
    $info["userPayOn"] = $m->type("pay")->getValue("userPayOn");
    $info["alipayOn"] = $m->type("pay")->getValue("alipayOn");
    $info["wechatpayOn"] = $m->type("pay")->getValue("wechatpayOn");
    $info["qqpayOn"] = $m->type("pay")->getValue("qqpayOn");
    $info["epayID"] = $m->type("pay")->getValue("epayID");
    $info["epayKey"] = $m->type("pay")->getValue("epayKey");
    $info["epaySite"] = $m->type("pay")->getValue("epaySite");
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
                                * 本支付系统采用的易支付API，请前往相关平台注册并申请商户ID与密钥，即可使用支付系统。
                            </h6>
                        </div>
                        <div class="card-body pb-md-30">
                            <div class="Vertical-form">
                                <form method="POST" action="<?php echo $action ?>">
                                    <div class="form-group mb-25 status-radio">
                                        <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                            代理充值 <span style="color:red">*</span>
                                        </label>
                                        <div class="d-flex">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="dailiPayOn"
                                                           value="on"
                                                           id="radio-hl1" <?= $info["dailiPayOn"] == "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl1">
                                                        <span class="radio-text">启用</span>
                                                    </label>
                                                </div>
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="dailiPayOn"
                                                           value="off" id="radio-hl2" <?= $info["dailiPayOn"] != "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl2">
                                                        <span class="radio-text">禁止</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-25 status-radio">
                                        <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                            用户充值 <span style="color:red">*</span>
                                        </label>
                                        <div class="d-flex">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="userPayOn"
                                                           value="on"
                                                           id="radio-hl3" <?= $info["userPayOn"] == "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl3">
                                                        <span class="radio-text">启用</span>
                                                    </label>
                                                </div>
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="userPayOn"
                                                           value="off" id="radio-hl4" <?= $info["userPayOn"] != "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl4">
                                                        <span class="radio-text">禁止</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-25 status-radio">
                                        <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                            支付宝 <span style="color:red">*</span>
                                        </label>
                                        <div class="d-flex">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="alipayOn"
                                                           value="on"
                                                           id="radio-hl5" <?= $info["alipayOn"] == "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl5">
                                                        <span class="radio-text">启用</span>
                                                    </label>
                                                </div>
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="alipayOn"
                                                           value="off" id="radio-hl6" <?= $info["alipayOn"] != "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl6">
                                                        <span class="radio-text">禁止</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-25 status-radio">
                                        <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                            微信 <span style="color:red">*</span>
                                        </label>
                                        <div class="d-flex">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="wechatpayOn"
                                                           value="on"
                                                           id="radio-hl7" <?= $info["wechatpayOn"] == "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl7">
                                                        <span class="radio-text">启用</span>
                                                    </label>
                                                </div>
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="wechatpayOn"
                                                           value="off" id="radio-hl8" <?= $info["wechatpayOn"] != "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl8">
                                                        <span class="radio-text">禁止</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-25 status-radio">
                                        <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                            QQ钱包 <span style="color:red">*</span>
                                        </label>
                                        <div class="d-flex">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="qqpayOn"
                                                           value="on"
                                                           id="radio-hl9" <?= $info["qqpayOn"] == "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl9">
                                                        <span class="radio-text">启用</span>
                                                    </label>
                                                </div>
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="qqpayOn"
                                                           value="off" id="radio-hl10" <?= $info["qqpayOn"] != "on" ? "checked" : '' ?>>
                                                    <label for="radio-hl10">
                                                        <span class="radio-text">禁止</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput" class="color-dark fs-14 fw-500 align-center">易支付商户ID <span style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput" name="epayID" placeholder=""
                                               value="<?php echo $info['epayID'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput2"
                                               class="color-dark fs-14 fw-500 align-center">易支付商户秘钥 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput2" name="epayKey" placeholder=""
                                               value="<?php echo $info['epayKey'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput3"
                                               class="color-dark fs-14 fw-500 align-center">易支付接口地址 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput3" name="epaySite" placeholder=""
                                               value="<?php echo $info['epaySite'] ?>">
                                        <p>一般为：http://www.xxxx.com/</p>
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
            var epayID = $('[name="epayID"]').val();
            var epayKey = $('[name="epayKey"]').val();
            var epaySite = $('[name="epaySite"]').val();
            if (epayID == "" || epayKey == "" || epaySite == "") {
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
