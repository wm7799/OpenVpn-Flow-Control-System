<div style="margin:0 10px">
    <h3>订单确认</h3>
    <?php
    $db = db('app_tc');
    $vo = $db->where(['id' => $_GET['tc_id']])->find();
    //获取用户id
    $user = db('openvpn')->where(['iuser' => $_GET['username']])->find();
    echo '<div style="background: #ffffff;padding: 10px;margin-top: 10px;border-top:3px solid #328cc9">';
    echo '<div class="row-col c_active div_shadow">';
    echo '<h4 style="margin: 10px 0">' . $vo['name'] . ' / ' . $vo["limit"] . '天</h4>';
    echo '<div class="sub">价格：' . $vo["jg"] . '元</div>';
    echo '<div class="sub">流量：' . $vo["rate"] . 'M</div>';
    echo '<div class="text-right" style="margin-top: 20px">';
    echo '<button id="" class="submit btn btn-info" data="alipay">支付宝支付</button> ';
    echo '<button id="" class="submit btn btn-info" data="wxpay">微信支付</button> ';
    echo '<button id="" class="submit btn btn-info" data="qqpay">QQ支付</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    ?>
</div>
<script>
    $(function () {
        $(".submit").click(function () {
            var curWwwPath = window.document.location.href;
            var pathName = window.document.location.pathname;
            var pos = curWwwPath.indexOf(pathName);
            var localhostPath = curWwwPath.substring(0, pos);
            var url = localhostPath + "/pay/ajax.php?client=app";
            //生成订单
            $.ajax({
                type: "POST",
                url: url,
                data: {tid: <?php echo $_GET['tc_id']?>, inputvalue: <?=$user['id']?>},
                dataType: 'json',
                success: function (data) {
                    if (data.code == 0) {
                        //提交订单
                        window.location.href = localhostPath + '/pay/epay/submit.php?type=' + $(this).attr('data') + '&orderid=' + data.trade_no;
                    } else {
                        alert(data.msg);
                        return;
                    }
                }
            });
        });
    });
</script>
