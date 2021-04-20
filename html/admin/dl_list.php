<?php
$mod = 'blank';
$title = "代理列表";
include('head.php');
include('nav.php');
$key = file_get_contents("/root/res/app_key.txt");
?>
<?php
if ($_GET["act"] == 'del') {
    if (db("app_daili")->where(array("id" => $_GET['id']))->delete()) {
        tip_success("操作成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
} else {
    if (!empty($_GET['kw'])) {
        $numrows = db("app_daili")->where(array("name" => $_GET["kw"]))->getnums();
        $where = array("name" => $_GET["kw"]);
    } else {
        $numrows = db("app_daili")->where()->getnums();
        $where = '';
    }
    echo '<div class="contents">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main user-member justify-content-sm-between ">
                                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                        <h4 class="text-capitalize fw-500 breadcrumb-title">' . $title . '</h4>
                                        <span class="sub-title ml-sm-25 pl-sm-25">' . $numrows . ' 用户</span>
                                    </div>
                                    <form action="?" method="get" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                        <span data-feather="search"></span>
                                        <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                               placeholder="搜索账号" aria-label="Search" name="kw">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
    echo $con;
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                        <thead>
                        <tr class="userDatatable-header line-id-<?= $res['id'] ?>">
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
                                <span class="userDatatable-title">等级</span>
                            </th>
                            <th>
                                <span class="userDatatable-title">余额</span>
                            </th>
                            <th>
                                <span class="userDatatable-title">APP_KEY</span>
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
                        $rs = db("app_daili")->where($where)->fpage($_GET["page"], 30)->order("id DESC")->select();
                        $i = 1;
                        foreach ($rs as $res)
                        {
                        if (date("Y-m-d", $res['time']) == date("Y-m-d", time())) {
                            $p = '&nbsp;<span class="atbd-tag tag-warning tag-transparented">今日新增</span>';
                        } elseif (date("Y-m-d", $res['time']) == date("Y-m-d", (time() - 24 * 60 * 60))) {
                            $p = '&nbsp;<span class="atbd-tag tag-secondary tag-transparented">昨日新增</span>';
                        } else {
                            $p = "";
                        }
                        $deng = db("app_daili_type")->where(["id" => $res["type"]])->find();
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <div class="d-flex align-items-center">
                                        <div class="checkbox-group-wrapper">
                                            <div class="checkbox-group d-flex">
                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                    <input class="checkbox" type="checkbox"
                                                           id="check-grp-<?= $i ?>">
                                                    <label for="check-grp-<?= $i ?>"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="userDatatable-content">
                                        <?= $res['name'] ?><?= $p ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= date("Y-m-d", $res['time']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= date("Y-m-d", $res['endtime']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= $deng["name"] ?> 折扣：<?= $deng["per"] ?>%
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= $res['balance'] ?>元
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?php echo trim($key) . "_" . $res["id"]; ?>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content d-inline-block">
                                    <?= ($res['lock'] ? '<span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">开通</span>' : '<span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">禁用</span>') ?>
                                </div>
                            </td>
                            <td>
                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                    <li>
                                        <a href="dl_add.php?act=mod&id=<?= $res['id'] ?>"
                                           class="view">
                                            <span data-feather="edit"></span></a>
                                    </li>
                                    <li>
                                        <a href="?act=del&id=<?= $res['id'] ?>" class="remove"
                                           onclick="if(!confirm('你确实要删除此记录吗？')){return false;}else{return true}">
                                            <span data-feather="trash-2"></span></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                            <?php
                            $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php echo create_page_html($numrows, $_GET["page"]); ?>
            </div>
        </div>
    </div>
    </div>
    </div>
<?php }
include("footer.php"); ?>
