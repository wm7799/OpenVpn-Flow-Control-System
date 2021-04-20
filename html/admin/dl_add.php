<?php
$title = '添加代理';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'update') {
    $db = db('app_daili');
    if (!$row = $db->where(array('id' => $_GET['id']))->find()) {
        tip_failed("账号不存在!", '?');
        exit;
    }
    $endtime =  $row["endtime"] + ((int)$_POST['enddate'] * 24 * 60 * 60);
    if ($db->where(array('id' => $_GET['id']))->update(array(
        'name' => $_POST['name'],
        'pass' => $_POST['pass'],
        'type' => $_POST["type"],
        'balance' => $_POST['balance'],
        'qq' => $_POST['qq'],
        'lock' => $_POST['lock'],
        'endtime' => $endtime
    ))) {
        tip_success("修改成功", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == 'add') {
    $db = db("app_daili");
    if ($db->insert(array(
        'name' => $_POST['name'],
        'pass' => $_POST['pass'],
        'type' => $_POST["type"],
        'balance' => $_POST['balance'],
        'qq' => $_POST['qq'],
        'lock' => $_POST['lock'],
        'endtime' => time() + $_POST['days'] * 24 * 60 * 60,
        'time' => time()
    ))) {
        tip_success("操作成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("十分抱歉修改失败", $_SERVER['HTTP_REFERER']);
    }
} else {
    $action = '?act=add';
    if ($_GET['act'] == 'mod') {
        $info = db('app_daili')->where(array('id' => $_GET['id']))->find();
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
                                                <form method="POST" action="<?php echo $action ?>" onsubmit="return checkStr()">
                                                    <div class="form-group mb-25">
                                                        <div class="countryOption">
                                                            <label for="countryOption">
                                                                代理等级 <span style="color:red">*</span>
                                                            </label>
                                                            <select class="js-example-basic-single js-states form-control" id="countryOption" name="type">
                                                                <?php $res = db("app_daili_type")->select();
                                                                if ($res) {
                                                                    foreach ($res as $vo) {
                                                                        ?>
                                                                        <option value="<?php echo $vo["id"] ?>" <?php if ($vo["id"] == $info["type"]) {
                                                                            echo " selected ";
                                                                        } ?>><?php echo $vo["name"] ?> 折扣<?php echo $vo["per"] ?>%
                                                                        </option>
                                                                    <?php }
                                                                } else {
                                                                    die("请先增加等级");
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber5">用户名 <span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="phoneNumber5"
                                                               name="name" placeholder="用户名为英文或数字"
                                                               value="<?php echo $info['name'] ?>">
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber5">密码 <span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="phoneNumber5"
                                                               name="pass" placeholder="密码为英文或数字"
                                                               value="<?php echo $info['pass'] ?>">
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber5">余额（元）<span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="phoneNumber5"
                                                               name="balance" placeholder="余额为纯数字"
                                                               value="<?php echo $info['balance'] ?>">
                                                    </div>
                                                    <?php if ($_GET['act'] == 'mod') {
                                                        echo '<div class="form-group mb-25">
                                                        <label for="name1">到期时间</label>
                                                        <input type="text" class="form-control" id="name1" name="days" value="'.date("Y-m-d", $info['endtime']).'" disabled>
                                                    </div>';
                                                        echo '<div class="form-group mb-25">
                                                        <label for="name1">延期(正数为添加 负数为减少 单位：天)</label>
                                                        <input type="text" class="form-control" id="name1"
                                                               name="enddate" value="0">
                                                    </div>';
                                                    } else { ?>
                                                    <div class="form-group mb-25 form-group-calender">
                                                        <label for="datepicker">有效期（0-999999/天） <span
                                                                    style="color:red">*</span></label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="phoneNumber"
                                                                   name="days" placeholder="30" value="30">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="form-group mb-25">
                                                        <label for="name1">联系方式 <span
                                                                    style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="name1"
                                                               name="qq" placeholder="QQ号或其他联系方式" value="<?php echo $info['qq'] ?>">
                                                    </div>
                                                    <div class="form-group mb-25 status-radio">
                                                        <label class="mb-15" for="phoneNumber2">状态</label>
                                                        <div class="d-flex">
                                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                                <div class="radio-theme-default custom-radio ">
                                                                    <input class="radio" type="radio" name="lock"
                                                                           value="1"
                                                                           id="radio-hl1" <?= $info["lock"] == 1 ? "checked" : '' ?>>
                                                                    <label for="radio-hl1">
                                                                        <span class="radio-text">启用</span>
                                                                    </label>
                                                                </div>
                                                                <div class="radio-theme-default custom-radio ">
                                                                    <input class="radio" type="radio" name="lock"
                                                                           value="0" id="radio-hl2" <?= $info["lock"] != 1 ? "checked" : '' ?>>
                                                                    <label for="radio-hl2">
                                                                        <span class="radio-text">禁止</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
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
            var username = $('[name="name"]').val();
            var password = $('[name="pass"]').val();
            var balance = $('[name="balance"]').val();
            var days = $('[name="days"]').val();
            var qq = $('[name="qq"]').val();

            if (username == "" || password == "" || balance == "" || days == "") {
                alert("资料不完整");
                return false;
            }
            return true;
        }
    </script>
    <?php
}
include('footer.php');

?>
