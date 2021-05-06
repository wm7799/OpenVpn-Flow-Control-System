<?php
$title = '购买套餐';
include("api_head.php");
include("nav.php");
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
            <?php
            $db = db('app_tc');
            $list = $db->where(array())->order('id DESC')->select();
            foreach ($list as $vo) {
                ?>
                <div class="col-xxl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="card h-100">
                        <div class="card-body p-30">
                            <div class="pricing d-flex align-items-center">
                                <span class=" pricing__tag color-primary order-bg-opacity-primary rounded-pill "><?= $vo["name"] ?></span>
                            </div>
                            <div class="pricing__price rounded">
                                <p class="pricing_value display-3 color-dark d-flex align-items-center text-capitalize fw-600 mb-1">
                                    <sup>¥</sup><?= $vo["jg"] ?>
                                    <small class="pricing_user"><?= $vo["limit"] ?>天</small>
                                </p>
                                <p class="pricing_subtitle mb-0"><?= $vo["rate"] ?> MB</p>
                            </div>
                            <div class="pricing__features">
                                <ul>
                                    <li>
                                        <span class="fa fa-check"></span><?= $vo["content"] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="price_action d-flex pb-30 pl-30">
                            <button onclick="chooseTc(<?= $vo["id"] ?>)" data-toggle="modal" data-target="#modal-basic"
                                    class="btn btn-primary btn-default btn-squared text-capitalize px-30">购买
                            </button>
                        </div>
                    </div><!-- End: .card -->
                </div><!-- End: .col -->
                <?php
            }
            ?>
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
                $m = new Map();
                $userPayOn = $m->type("pay")->getValue("userPayOn");
                if ($userPayOn == "on"){
                    if ($m->type("pay")->getValue("alipayOn") == "on")
                        echo '<button onclick="zfb()" class="btn btn-info btn-lg btn-squared btn-block ">支付宝</button>';
                    if ($m->type("pay")->getValue("wechatpayOn") == "on")
                        echo '<button onclick="wx()" class="btn btn-success btn-lg btn-squared btn-block ">微信</button>';
                    if ($m->type("pay")->getValue("qqpayOn") == "on")
                        echo '<button onclick="qq()" class="btn btn-primary btn-lg btn-squared btn-block ">QQ钱包</button>';
                    ?>
                    <?php
                }else{
                    echo '支付功能未开放！';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include('api_footer.php');
?>
<script>
    let tid = '';

    function chooseTc(tcid) {
        tid = tcid;
    }

    function zfb() {
        generateOrder('alipay');
    }

    function wx() {
        generateOrder('wxpay');
    }

    function qq() {
        generateOrder('qqpay');
    }

    function generateOrder(typ) {
        var curWwwPath = window.document.location.href;
        var pathName = window.document.location.pathname;
        var pos = curWwwPath.indexOf(pathName);
        var localhostPath = curWwwPath.substring(0, pos);
        var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
        var url;
        if (projectName == '/kangml_api')
            url = localhostPath + "/pay/ajax.php?client=app";
        else
            url = localhostPath + "/pay/ajax.php?client=web";
        //生成订单
        $.ajax({
            type: "POST",
            url: url,
            data: {tid: tid, inputvalue: <?=$userinfo['id']?>},
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
