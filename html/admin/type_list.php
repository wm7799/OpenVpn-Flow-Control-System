<?php
$mod = 'blank';
$title = "等级列表";
include('head.php');
include('nav.php');
?>
<?php
if ($_GET["act"] == 'del'){
    if (db("app_daili_type")->where(array("id" => $_GET['id']))->delete()) {
        tip_success("操作成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
}else{
?>
<div class="contents">
    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title"><?= $title ?></h4>
                    </div>
                </div>
                <?php
                $rs = db("app_daili_type")->where()->order("id DESC")->select();
                $i = 1;
                if ($rs) {
                    foreach ($rs as $res) {
                        echo '<div class="col-xxl-3 col-sm-6 ">
                            <div class="card banner-feature">
                                <div class="card-body">
                                    <h1 class="banner-feature__heading">名称：' . $res["name"] . '</h1>
                                    <p class="banner-feature__para color-gray">折扣：' . $res["per"] . '%</p>
                                    <button style="display:inline" class="banner-feature__btn btn btn-outline-primary btn-sm px-20 radius-xs fs-14" type="button" onclick="window.location.href=\'type_add.php?act=mod&id=' . $res["id"] . '\'">编辑</button>
                                ';
                        echo '<button style="display:inline" class="banner-feature__btn btn btn-outline-danger btn-sm px-20 radius-xs fs-14" type="button" onclick="if(confirm(\'确认删除？\')){window.location.href=\'type_add.php?act=mod&id=' . $res["id"] . '\'}else{return false;}">删除</button>';
                        echo '</div>
              </div>
              </div>';
                    }
                } else {
                    echo '<div class="box">暂无数据</div>';
                }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>
