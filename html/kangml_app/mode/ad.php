<?php
if (isset($_POST['km'])) {
    $km = $_POST['km'];
    $myrow = db("app_kms")->where(array("km" => $km))->find();
    if (!$myrow) {
        die('此激活码不存在');
    } elseif ($myrow['isuse'] == 1) {
        die('此激活码已被使用');
    } else {
        $type_id = $myrow["type_id"];
        $tc = db("app_tc")->where(array("id" => $type_id))->find();
        if (!$tc) {
            die("此套餐已经失效了");
        }
        $userinfo = db("openvpn")->where(["id"=>$user_info['id']])->find();
        $addll = $tc['rate']*1024*1024;//套餐流量
        //已到期，重置所有东西
        if ($userinfo["endtime"]<time()){
            $update[_maxll_] = $addll;
            $update[_endtime_] = time() + $tc['limit']*24*60*60;
            $update[_isent_] = "0";
            $update[_irecv_] = "0";
        }else{
            //没到期，用旧时间叠加
            $update[_maxll_] = $userinfo["maxll"] +$addll;//流量直接叠加
            $update[_endtime_] = $userinfo["endtime"]+ ($tc['limit']*24*60*60);
        }
        $update["daili"] = $myrow["daili"];
        $update[_i_] = "1";
        if (db(_openvpn_)->where(["id" => $user_info["id"]])->update($update)) {
            db("app_kms")->where(array("id" => $myrow['id']))->update(array("isuse" => "1", "user_id" => $user_info["id"], "usetime" => time()));
            die('开通成功！');
        } else {
            die('开通失败！');
        }
    }
}
?>

<div class="alert alert-success" style="display:none;margin:0px;">
    请在此输入您购买的流量卡密。
</div>
<div style="margin:10px">
    <div class="form-group">
        <input type="text" class="form-control" name="km" placeholder="请输入激活码卡密">
    </div>
    <button type="submit" class="btn btn-success btn-block cz" onclick="kmcz()">
        充值到我的账户
    </button>
    </a>
    <br/>
    【使用说明】
    <br/>
    * 未到期的用户充值将会自动叠加流量和日期。
    <br>
    <br/>
    <?php
    if (DID == 0) {
        $db = db('app_tc');
        $list = $db->where(array())->order('id DESC')->select();
        foreach ($list as $vo) {
            echo '<div class="col-xs-12 col-sm-3" style="background: #ffffff;padding: 10px;margin-top: 10px">';
            echo '<div class="row-col c_active div_shadow">';
            echo '<h4 style="margin: 10px 0">' . $vo['name'] . ' / ' . $vo["limit"] . '天</h4>';
            echo '<div class="sub">价格：' . $vo["jg"] . '元</div>';
            echo '<div class="sub">流量：' . $vo["rate"] . 'M</div>';
            echo '<button style="margin-top:10px" data-toggle="modal" data-target="#modal-basic" class="btn btn-info btn-block" onclick="chooseTc(\'' . $vo["id"] . '\')">购买</button>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
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
                if ($userPayOn == "on") {
                    if ($m->type("pay")->getValue("alipayOn") == "on")
                        echo '<button onclick="zfb()" class="btn btn-info btn-lg btn-squared btn-block ">支付宝</button>';
                    if ($m->type("pay")->getValue("wechatpayOn") == "on")
                        echo '<button onclick="wx()" class="btn btn-success btn-lg btn-squared btn-block ">微信</button>';
                    if ($m->type("pay")->getValue("qqpayOn") == "on")
                        echo '<button onclick="qq()" class="btn btn-primary btn-lg btn-squared btn-block ">QQ钱包</button>';
                    ?>
                    <?php
                } else {
                    echo '支付功能未开放！';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- inject:js-->
<script src="../../assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery/jquery-ui.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/popper.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/vendor_assets/js/accordion.js"></script>
<script src="../../assets/vendor_assets/js/autoComplete.js"></script>
<script src="../../assets/vendor_assets/js/Chart.min.js"></script>
<script src="../../assets/vendor_assets/js/charts.js"></script>
<script src="../../assets/vendor_assets/js/daterangepicker.js"></script>
<script src="../../assets/vendor_assets/js/drawer.js"></script>
<script src="../../assets/vendor_assets/js/dynamicBadge.js"></script>
<script src="../../assets/vendor_assets/js/dynamicCheckbox.js"></script>
<script src="../../assets/vendor_assets/js/feather.min.js"></script>
<script src="../../assets/vendor_assets/js/fullcalendar@5.2.0.js"></script>
<script src="../../assets/vendor_assets/js/google-chart.js"></script>
<script src="../../assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="../../assets/vendor_assets/js/jquery.countdown.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.filterizr.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.magnific-popup.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.mCustomScrollbar.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.peity.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
<script src="../../assets/vendor_assets/js/leaflet.js"></script>
<script src="../../assets/vendor_assets/js/leaflet.markercluster.js"></script>
<script src="../../assets/vendor_assets/js/loader.js"></script>
<script src="../../assets/vendor_assets/js/message.js"></script>
<script src="../../assets/vendor_assets/js/moment.js"></script>
<script src="../../assets/vendor_assets/js/muuri.min.js"></script>
<script src="../../assets/vendor_assets/js/notification.js"></script>
<script src="../../assets/vendor_assets/js/popover.js"></script>
<script src="../../assets/vendor_assets/js/select2.full.min.js"></script>
<script src="../../assets/vendor_assets/js/slick.min.js"></script>
<script src="../../assets/vendor_assets/js/trumbowyg.min.js"></script>
<script src="../../assets/vendor_assets/js/wickedpicker.min.js"></script>
<script src="../../assets/theme_assets/js/drag-drop.js"></script>
<script src="../../assets/theme_assets/js/full-calendar.js"></script>
<script src="../../assets/theme_assets/js/googlemap-init.js"></script>
<script src="../../assets/theme_assets/js/icon-loader.js"></script>
<script src="../../assets/theme_assets/js/jvectormap-init.js"></script>
<script src="../../assets/theme_assets/js/leaflet-init.js"></script>
<script src="../../assets/theme_assets/js/main.js"></script>
<!-- endinject-->

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
        var url = localhostPath + "/pay/ajax.php?client=app";
        //生成订单
        $.ajax({
            type: "POST",
            url: url,
            data: {tid: tid, inputvalue: <?=$user_info['id']?>},
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

    var old_html = "";

    function kmcz() {
        if ($("[name=km]").val() == "") {
            $(".alert").html("卡密不能为空").show();
        } else {
            old_html = $(".cz").html();
            $(".cz").html("处理中...");
            $.post("?action=shop&username=<?php echo $username?>&password=<?php echo $password ?>", {
                "km": $("[name=km]").val()
            }, function (data) {
                $(".cz").html(old_html);
                $(".alert").show();
                $(".alert").html(data);
            })
        }
    }
</script>