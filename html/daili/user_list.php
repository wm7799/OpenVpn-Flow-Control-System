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
if (!empty($_GET['kw'])) {
    $numrows = db(_openvpn_)->where(array(_iuser_ => $_GET["kw"]))->getnums();
    $where = array(_iuser_ => $_GET["kw"], "daili" => $admin["id"]);
} else {
    //$numrows=$DB->count("SELECT count(*) from `openvpn` WHERE 1");
    $numrows = db(_openvpn_)->where(["daili" => $admin["id"]])->getnums();
    $where = array("daili" => $admin["id"]);
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
                        <form action="user_list.php" method="get"
                              class="d-flex align-items-center user-member__form my-sm-0 my-2">
                            <span data-feather="search"></span>
                            <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                   placeholder="搜索账号" aria-label="Search" name="kw" value="<?= $_GET["kw"] ?>">
                        </form>
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $rs = db(_openvpn_)->where($where)->fpage($_GET["page"], 30)->order("id DESC")->select();
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
                                <tr class="line-id-<?= $res['iuser'] ?>">
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
