<?php
$title = '新增等级';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'update') {
    $db = db('app_daili_type');
    if ($db->where(array('id' => $_GET['id']))->update(array(
        'name' => $_POST['name'],
        'per' => $_POST['per']
    ))) {
        tip_success("修改成功", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }

} elseif ($_GET['act'] == 'add') {
    $db = db('app_daili_type');
    if ($db->insert(array(
        'name' => $_POST['name'],
        'per' => $_POST['per']
    ))) {
        tip_success("操作成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }

} else {
    $action = '?act=add';
    if ($_GET['act'] == 'mod') {
        $info = db('app_daili_type')->where(array('id' => $_GET['id']))->find();
        $action = "?act=update&id=" . $_GET['id'];
    }
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
                    <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade  show active" id="v-pills-home">
                                <div class="row justify-content-center">
                                    <div class="col-xl-4 col-sm-6 col-10">
                                        <div class="mt-40 mb-50">
                                            <div class="edit-profile__body">
                                                <form method="POST" action="<?php echo $action ?>"
                                                      onsubmit="return checkStr()">
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber5">等级名称 <span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="phoneNumber5"
                                                               name="name" placeholder="如：VIP1"
                                                               value="<?php echo $info['name'] ?>">
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber1">折扣比(0-100 80就代表原件的80%拿货) <span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="phoneNumber1"
                                                               name="per" placeholder="如：80"
                                                               value="<?php echo $info['per'] ?>">
                                                    </div>
                                                    <div class="button-group d-flex pt-25 justify-content-end">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-block btn-default btn-squared text-capitalize radius-md shadow2">
                                                            提交
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkStr() {
            var title = $('[name="title"]').val();
            var content = $('[name="per"]').val();
            if (title == "" || content == "") {
                alert("参数不完整");
                return false;
            }
            return true;
        }
    </script>
    <?php
}
include('footer.php');
?>
