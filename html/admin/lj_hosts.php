<?php
$title = 'hosts拦截';
include('head.php');
include('nav.php');
$m = new Map();
if ($_GET['act'] == 'update') {
    $info = file_put_contents("/etc/kangml_host", $_POST["content"]);
    tip_success("修改成功", $_SERVER['HTTP_REFERER']);
} else {
    $action = "?act=update";
    $info = file_get_contents("/etc/kangml_host");
    //$p = '/default\s([0-9]*)/';
    //preg_match($p,$info,$m);
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
                                        <p>
                                            示例:127.0.0.1 www.baidu.com 则用户访问百度会被屏蔽<br>
                                            10.8.0.1（或者你的IP） a.com 则访问a.com会进入你的流控
                                        </p>
                                    <textarea class="form-control" rows="20"
                                              name="content"><?php echo $info ?></textarea>
                                    <br>
                                    <button type="submit" class="btn btn-info btn-block">保存</button>
                                    <input type="button" class="btn btn-success btn-block"
                                           onclick="cmds('service dnsmasq restart')" value="立即生效（保存后再执行）">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function cmds(line) {
            if (confirm("立即使HOST表生效？")) {
                $.post('kangml_service.php', {
                    "cmd": line
                }, function (data) {
                    if (data.status == "success") {
                        alert("执行完毕");
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }, "JSON");
            }
        }
    </script>
    <?php
}
include('footer.php');
?>
