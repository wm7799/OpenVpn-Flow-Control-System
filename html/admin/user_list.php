<?php
$mod = 'blank';
$title = "账号列表";
include('head.php');
include('nav.php');
if ($_GET["a"] == "qset") {
    include("qset.php");
    include("footer.php");
} else {
    ?>
        <?php
        $my = $_GET['my'] ?? null;
        if ($my == 'del') {
            echo '<div class="panel panel-default">
<div class="panel-heading w h"><h3 class="panel-title">删除账号</h3></div>
<div class="panel-body box">';
            $user = $_GET['user'];
            $sql = db(_openvpn_)->where(array(_iuser_ => $user))->delete();
            if ($sql) {
                db("top")->where(["username" => $user])->delete();
                echo '删除成功！';
            } else {
                echo '删除失败！';
            }
            echo '<hr/><a href="./user_list.php">>>返回账号列表</a></div></div>';
        } else {
            if (!empty($_GET['kw'])) {
                $numrows = db(_openvpn_)->where(_iuser_ . " LIKE :kw", [":kw" => "%" . $_GET["kw"] . "%"])->getnums();
                $where = _iuser_ . " LIKE :kw";
                $data = [":kw" => "%" . $_GET["kw"] . "%"];
            } else {
                //$numrows=$DB->count("SELECT count(*) from `openvpn` WHERE 1");
                $numrows = db(_openvpn_)->where()->getnums();
                $where = '';
            }
            echo $con;
            ?>
            <div class="contents">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main user-member justify-content-sm-between ">
                                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                        <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                                        <span class="sub-title ml-sm-25 pl-sm-25"><?= $numrows ?> 用户</span>
                                    </div>
                                    <form action="user_list.php" method="get" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                        <span data-feather="search"></span>
                                        <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                               placeholder="搜索账号" aria-label="Search" name="kw" value="<?= $_GET["kw"] ?>">
                                    </form>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary btn-add dropdown-toggle px-15" type="button"
                                            id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="las la-plus fs-16"></i> 批量操作
                                    </button>
                                    <div class="dropdown-default dropdown-menu" aria-labelledby="dropdownMenu3">
                                        <a href="javascript:void(0)" class="dropdown-item" onclick="var n = prompt('统一新增流量，减少请输入负数（单位：G）');if(!n){return false;}else{addLlAll(n)}"> 统一新增流量</a>
                                        <a href="javascript:void(0)" class="dropdown-item" onclick="var n = prompt('统一新增天数，减少请输入负数（单位：天）');if(!n){return false;}else{addTimeAll(n)}"> 统一新增天数</a>
                                        <a href="javascript:void(0)" class="dropdown-item" onclick="if(!confirm('清理全部未激活用户？执行后不可恢复！')){return false;}else{delAllJ()}"> 清理全部未激活用户</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <div class="d-flex align-items-center">
                                                    <div class="custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-3">
                                                        <label for="check-3">
                                                            <span class="checkbox-text userDatatable-title">账号</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">添加时间</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">到期时间</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">剩余流量</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">总流量</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">状态</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title float-right">操作</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $rs = db(_openvpn_)->where($where, $data)->fpage($_GET["page"], 30)->order("id DESC")->select();
                                        foreach ($rs as $res) {
                                            if (date("Y-m-d", $res['starttime']) == date("Y-m-d", time())) {
                                                $p = '&nbsp;<span class="atbd-tag tag-warning tag-transparented">今日新增</span>';
                                            } elseif (date("Y-m-d", $res['starttime']) == date("Y-m-d", (time() - 24 * 60 * 60))) {
                                                $p = '&nbsp;<span class="atbd-tag tag-secondary tag-transparented">昨日新增</span>';
                                            } else {
                                                $p = "";
                                            }

                                            if ($res["vip"] == 1) {
                                                $vip = '&nbsp;<span class="atbd-tag tag-secondary ">VIP</span>';
                                            } elseif ($res["vip"] == 2) {
                                                $vip = '&nbsp;<span class="atbd-tag tag-warning ">VIP2</span>';
                                            } else {
                                                $vip = "";
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="d-flex align-items-center">
                                                            <div class="checkbox-group-wrapper">
                                                                <div class="checkbox-group d-flex">
                                                                    <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                        <input class="checkbox" type="checkbox"
                                                                               id="check-grp-<?= $res['iuser'] ?>">
                                                                        <label for="check-grp-<?= $res['iuser'] ?>"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="userDatatable-content">
                                                            <?= $vip ?><?= $res['iuser'] ?><?= $p ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content">
                                                        <?= date("Y-m-d", $res['starttime']) ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content">
                                                        <?= date("Y-m-d", $res['endtime']) ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content">
                                                        <span class="shengyu"><?= round(($res['maxll'] - $res['isent'] - $res['irecv']) / 1024 / 1024) ?></span>MB
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content">
                                                        <span class="maxll"><?= round(($res['maxll']) / 1024 / 1024) ?></span>MB
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content d-inline-block">
                                                        <?= ($res['i'] ? '<span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">开通</span>' : '<span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">禁用</span>') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                        <li>
                                                            <a href="./user_list.php?a=qset&user=<?= $res['iuser'] ?>"
                                                               class="view">
                                                                <span data-feather="edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" class="edit"
                                                               onclick="var n = prompt('请输入您要重置的流量（单位：G)');if(!n){return false;}else{addLl('<?= $res['id'] ?>',n)}">
                                                                <span data-feather="cloud"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" class="remove"
                                                               onclick="if(!confirm('你确实要删除此记录吗？')){return false;}else{delLine('<?= $res['iuser'] ?>')}">
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
        }
                                echo create_page_html($numrows, $_GET["page"]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    <?php
    include("footer.php");
    ?>
    <script>
        function addLlAll(n) {
            var url = './option.php?my=addllAll';
            $.post(url, {
                "n": n
            }, function () {

            });
            //var m = $('.line-id-'+id+" .maxll");
            //var ne = n*1024;
            //m.html(ne);
            location.reload();
        }

        function addTimeAll(n) {
            var url = './option.php?my=addtimeAll';
            $.post(url, {
                "n": n
            }, function () {

            });

            location.reload();
        }

        function addLl(id, n) {
            var url = './option.php?my=addll';
            $.post(url, {
                "n": n,
                "user": id
            }, function () {
                location.reload();
            });
        }

        function delAllJ() {
            var url = './option.php?my=deljy';
            $.post(url, {}, function () {
                location.reload();
            });
        }
    </script>
    <?php
}
?>
