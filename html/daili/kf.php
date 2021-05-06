<?php
$title = '修改客服信息';
include('head.php');
include('nav.php');
if ($_GET["act"] == "mod") {
    $db = db('app_daili');
    if ($db->where(['id' => $admin['id']])->update(['content' => $_POST['content']])) {
        tip_success("公告修改成功", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
} else {
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
                                <form role="form" method="POST" action="?act=mod"
                                      onsubmit="return checkStr()">
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">客服页面的文字内容
                                            支持HTML</label>
                                        <textarea class="form-control" rows="6"
                                                  name="content"><?= $admin["content"] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">提交数据</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<?php
include('footer.php');?>
