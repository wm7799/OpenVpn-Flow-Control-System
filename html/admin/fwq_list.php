<?php
$title = '服务器列表';
include 'head.php';
include 'nav.php';
$my = $_GET['act'] ?? null;
if ($my == 'del') {
    $db = db("auth_fwq");
    $id = $_GET['id'];
    if ($db->where(["id" => $id])->delete()) {
        tip_success("删除成功", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("删除失败", $_SERVER['HTTP_REFERER']);
    }
} elseif ($my == 'bmd') {
    if ($_GET["do"] == "on") {
        systemi('iptables -D INPUT -p tcp -m tcp --dport 3306 -j ACCEPT');
        $rs = db("auth_fwq")->order("id DESC")->select();
        $i = 0;
        foreach ($rs as $vo) {
            $ip = trim((explode(":", $vo["ipport"]))[0]);
            $cmd = 'iptables -A INPUT -s ' . $ip . ' -p tcp -m tcp --dport 3306 -j ACCEPT';
            systemi($cmd);
            $i++;
        }
        systemi("service iptables save");
        tip_success("您已成功开启数据库防火墙 并自动应用" . $i . "条规则 康师傅流控全程为您护航", $_SERVER['HTTP_REFERER']);
    } else {
        $rs = db("auth_fwq")->order("id DESC")->select();
        foreach ($rs as $vo) {
            $ip = trim((explode($vo["ipport"], ":"))[0]);
            $cmd = 'iptables -D INPUT -s ' . $ip . ' -p tcp -m tcp --dport 3306 -j ACCEPT';
            systemi($cmd);
        }
        systemi('iptables -A INPUT -p tcp -m tcp --dport 3306 -j ACCEPT');
        systemi("service iptables save");
        tip_success("您已成功关闭数据库防火墙 已失去外网保护", $_SERVER['HTTP_REFERER']);
    }
} else {
    $cmd = 'cat /etc/sysconfig/iptables|grep "\-A INPUT -p tcp -m tcp \-\-dport 3306 \-j ACCEPT"';
    $res = systemi($cmd);
    $is_safe = false;
    if (trim($res["msg"]) == "") {
        $is_safe = true;
    }
    ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main user-member justify-content-sm-between ">
                        <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                            <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                                <?php
                                if (!empty($_GET['kw'])) {
                                    $where = array("name" => $_GET['kw']);
                                    $numrows = db("auth_fwq")->where(array("name" => $_GET['kw']))->getnums();
                                    $con = '<span class="sub-title ml-sm-25 pl-sm-25">包含 ' . $_GET['kw'] . ' ' . $numrows . ' 服务器</span>';
                                } else {
                                    $numrows = db("auth_fwq")->getnums();
                                    $where = [];
                                    $con = '<span class="sub-title ml-sm-25 pl-sm-25">' . $numrows . ' 服务器</span>';
                                }
                                echo $con;
                                ?>
                            </div>
                            <form action="fwqlist.php" method="get"
                                  class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                <span data-feather="search"></span>
                                <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                       placeholder="搜索服务器名称" aria-label="Search" name="kw">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                        数据库白名单模式：
                        <div class="btn-group mb-3">
                            <?php if ($is_safe) { ?>
                                <button type="button" href="?act=bmd&do=on" class="btn btn-success btn-default btn-squared btn-shadow-success">开启</button>
                                <button type="button" href="?act=bmd&do=off" class="btn btn-danger btn-default btn-squared btn-transparent-danger btn-shadow-danger">关闭</button>
                            <?php } else { ?>
                                <button type="button" href="?act=bmd&do=on" class="btn btn-success btn-default btn-squared btn-transparent-success btn-shadow-success">开启</button>
                                <button type="button" href="?act=bmd&do=off" class="btn btn-danger btn-default btn-squared btn-shadow-danger">关闭</button>
                            <?php } ?>
                        </div>
                        <script src="assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
                        <script>
                            var tz = 0;
                            function getOnLine(url, file) {
                                tz++;
                                var jtz = tz;
                                document.write("<div class=\"tz_" + jtz + "\">获取中...</div>");
                                $(function () {
                                    $.post("onlinetz.php", {
                                        "domain": url,
                                        "file": file
                                    }, function (data) {
                                        $(".tz_" + jtz).html(data);
                                    });
                                });
                            }
                        </script>
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <div class="custom-checkbox  check-all">
                                                <input class="checkbox" type="checkbox" id="check-3">
                                                <label for="check-3">
                                                    <span class="checkbox-text userDatatable-title">服务器名称</span>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th><span class="userDatatable-title">地址</span></th>
                                    <th><span class="userDatatable-title">TCP在线</span></th>
                                    <th><span class="userDatatable-title">UDP在线</span></th>
                                    <th><span class="userDatatable-title float-right">操作</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rs = db("auth_fwq")->where($where)->order("id DESC")->fpage($_GET["page"], 30)->select();
                                foreach ($rs as $res) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <div class="checkbox-group-wrapper">
                                                        <div class="checkbox-group d-flex">
                                                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                <input class="checkbox" type="checkbox"
                                                                       id="check-grp-<?= $res['name'] ?>">
                                                                <label for="check-grp-<?= $res['name'] ?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="userDatatable-content">
                                                    <?= $res['name'] ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= $res['ipport'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <script>getOnLine('<?= $res["ipport"]?>', 'user-status-tcp')</script>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <script>getOnLine('<?= $res["ipport"]?>', 'user-status-udp')</script>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a href="./fwq_list.php?act=del&id=<?= $res['id'] ?>" class="remove"
                                                       onclick="if(!confirm('你确实要删除此记录吗？')){return false;}">
                                                        <span data-feather="trash-2"></span></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        echo create_page_html($numrows, $_GET["page"], 30); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include("footer.php");
?>