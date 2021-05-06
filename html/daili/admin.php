<?php
$title = "仪表盘";
require('head.php');
require('nav.php');
//基本信息加载
$nums = db(_openvpn_)->where(["daili" => $admin["id"]])->getnums();
$nums2 = db(_openvpn_)->where(["i" => "1", "daili" => $admin["id"]])->getnums();
$nums3 = db(_openvpn_)->where("endtime<:endtime AND endtime>:start AND i = 1 AND daili=:daili", ["endtime" => time() + 24 * 60 * 60 * 3, "start" => time(), "daili" => $admin["id"]])->getnums();
$kmNum = db("app_kms")->where(array("daili" => $admin["id"]))->order("id DESC")->getnums();
$isUseKmNum = db("app_kms")->where(["isuse" => 1,"daili" => $admin["id"]])->getnums(); //已使用卡密数量
$m = new Map();
$dailiPayOn = $m->type("pay")->getValue("dailiPayOn");
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
                    <div class="card card-default card-md mb-4">
                        <div class="card-header  py-20">
                            <h6>基本信息</h6>
                        </div>
                        <div class="card-body">
                            <div class="atbd-statistics-wrap d-flex">
                                <div class="statistics-item statistics-default">
                                    <span class="statistics-item__title">有效用户</span>
                                    <p class="statistics-item__number">
                                        <?php echo $nums2 ?> 个
                                    </p>
                                    <div class="statistics-item__action">
                                        <a href="/user/reg.php?vCode=<?=$admin["id"]?>" class="btn btn-shadow-info btn-info btn-md">注册链接</a>
                                    </div>
                                </div>
                                <div class="statistics-item statistics-default">
                                    <span class="statistics-item__title">账户余额</span>
                                    <p class="statistics-item__number">
                                        <?= $admin["balance"] ?> 元
                                    </p>
                                    <?php
                                    if ($dailiPayOn == 'on') {
                                        ?>
                                        <div class="statistics-item__action">
                                            <a data-toggle="modal" data-target="#modal-basic" href="#" class="btn btn-shadow-primary btn-primary btn-md">余额充值</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ends: .card -->
                    <div class="ratio-box card mb-4">
                        <div class="card-body">
                            <h6 class="ratio-title">卡密使用比例</h6>
                            <div class="ratio-info d-flex justify-content-between align-items-center">
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
                <div class="col-lg-6">
                        <div class="card banner-feature banner-feature--4">
                            <div class="banner-feature__shape">
                                <img src="../img/svg/Group3503.svg" alt="img" class="svg">
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="card-body">
                                    <h1 class="banner-feature__heading color-white"><?= $admin_ext["name"] ?></h1>
                                    <p class="banner-feature__para color-white">折扣：<?= $admin_ext["per"] ?>%</p>
                                    <button class="banner-feature__btn btn color-primary btn-md px-20 bg-white radius-xs fs-15" type="button">有效期至：<?= date("Y年m月d日", $admin["endtime"]) ?></button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-basic modal fade show" id="modal-basic" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">选择支付方式</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-feather="x"></span></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($dailiPayOn == "on"){
                        ?>
                        <div class="form-group">
                            <label for="firstname" class="color-dark fs-14 fw-500 align-center">金额</label>
                            <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15 money" name="money" placeholder="请输入数字（单位：元）">
                        </div>
                    <?php
                        if ($m->type("pay")->getValue("alipayOn") == "on")
                            echo '<button onclick="zfb()" class="btn btn-info btn-lg btn-squared btn-block ">支付宝</button>';
                        if ($m->type("pay")->getValue("wechatpayOn") == "on")
                            echo '<button onclick="wx()" class="btn btn-success btn-lg btn-squared btn-block ">微信</button>';
                        if ($m->type("pay")->getValue("qqpayOn") == "on")
                            echo '<button onclick="qq()" class="btn btn-primary btn-lg btn-squared btn-block ">QQ钱包</button>';
                    }else{
                        echo '支付功能未开放！';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
include("footer.php");
?>
<script>
    function zfb() {
        let money = $('.money').val();
        if (money) generateOrder('alipay',money);
    }

    function wx() {
        let money = $('.money').val();
        if (money) generateOrder('qqpay',money);
    }

    function qq() {
        let money = $('.money').val();
        if (money) generateOrder('wxpay',money);
    }

    function generateOrder(typ,money) {
        var curWwwPath = window.document.location.href;
        var pathName = window.document.location.pathname;
        var pos = curWwwPath.indexOf(pathName);
        var localhostPath = curWwwPath.substring(0, pos);
        var url = localhostPath + "/pay/ajax.php?client=daili&act=daili_pay";
        //生成订单
        $.ajax({
            type: "POST",
            url: url,
            data: {tid: '-1', jg: money, name: <?=$admin["id"]?>},
            dataType: 'json',
            success: function (data) {
                if (data.code == 0) {
                    //提交订单
                    window.location.href = localhostPath + '/pay/epay/submit.php?type=' + typ + '&orderid=' + data.trade_no;
                } else {
                    alert(data.msg);
                    return;
                }
            }
        });
    }
</script>
