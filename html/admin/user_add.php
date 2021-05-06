<?php
$title = '生成用户';
include('head.php');
include('nav.php');
if (ACT == 'add') {
    $db = db(_openvpn_);
    if ($db->where(array("iuser" => $_POST['username']))->find()) {
        tip_failed("用户名重复了,请换一个试一试", '?');
        exit;
    }
    if ($db->insert(array(
        'iuser' => $_POST['username'],
        'pass' => $_POST['password'],
        'isent' => 0,
        'irecv' => 0,
        'maxll' => $_POST['rate'] * 1024 * 1024,
        'starttime' => time(),
        'i' => $_POST['i'],
        'endtime' => time() + $_POST['days'] * 24 * 60 * 60
    ))) {
        tip_success("新增用户【" . $_POST['username'] . "】成功！", '?');
    } else {
        tip_failed("十分抱歉修改失败", '?');
    }

} elseif (ACT == 'addPL') {
    $pass = trim($_POST["password"]);
    if ($pass == "") {
        tip_failed("密码长度不能为空", '?');
    } else {
        $db = db(_openvpn_);
        $n = 0;
        for ($i = 0; $i < $_POST["nums"]; $i++) {
            $passstr = null;
            for ($i2 = 0; $i2 < $pass; $i2++) {
                $passstr .= rand(0, 9);
            }
            $username = $_POST['username'] . rand(10000, 99999) . $i;
            if (!$db->where(array("iuser" => $username))->find()) { //禁止重复添加
                if ($db->insert(array(
                    'iuser' => $username,
                    'pass' => $passstr,
                    'i' => $_POST['i'],
                    'isent' => 0,
                    'irecv' => 0,
                    'maxll' => $_POST['rate'] * 1024 * 1024,
                    'starttime' => time(),
                    'endtime' => time() + $_POST['days'] * 24 * 60 * 60
                ))) {
                    $kms[] = '$data[' . $n . ']["user"]="' . $username . '";';
                    $kms[] = '$data[' . $n . ']["pass"]="' . $passstr . '";';
                    $n++;
                }
            }
        }
    }

    file_put_contents("userdata.php", '<?php' . "\n" . implode("\n", $kms));
    tip_success("生成成功！", 'user_his.php');

} ?>
<div class="contents">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center user-member__title mb-30 mt-30">
                    <h4 class="text-capitalize"><?=$title?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                    <div class="ap-tab-wrapper border-bottom ">
                        <ul class="nav px-30 ap-tab-main text-capitalize" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="nav-item">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><span data-feather="user"></span>单独添加</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><span data-feather="briefcase"></span>批量生成</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-sm-6 col-10">
                                    <div class="mt-40 mb-50">
                                        <div class="user-tab-info-title mb-40 text-capitalize">
                                            <h5 class="fw-500">单独添加一个用户</h5>
                                        </div>
                                        <div class="edit-profile__body">
                                            <form method="POST" action="?act=add" onsubmit="return checkStr()">
                                                <div class="form-group mb-25">
                                                    <label for="name1">用户名<span
                                                                style="color:red">*</span></label>
                                                    <input type="text" class="form-control" id="name1" name="username" placeholder="用户名为英文或数字"
                                                           value="<?php echo $info['name'] ?>">
                                                </div>
                                                <div class="form-group mb-25">
                                                    <label for="name2">密码<span
                                                                style="color:red">*</span></label>
                                                    <input type="text" class="form-control" id="name2" name="password" placeholder="密码为英文或数字"
                                                           value="<?php echo $info['jg'] ?>">
                                                </div>
                                                <div class="form-group mb-25">
                                                    <label for="phoneNumber5">流量（0-999999/M）<span
                                                                style="color:#ff0000">*</span></label>
                                                    <input type="text" class="form-control" id="phoneNumber5" name="rate" placeholder="1024"
                                                           value="<?php echo $info['limit'] ?>">
                                                </div>
                                                <div class="form-group mb-25 form-group-calender">
                                                    <label for="datepicker">有效期（0-999999/天）
                                                        <span style="color:red">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="phoneNumber" name="days" placeholder="30" value="<?php echo $info['rate'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-25 status-radio">
                                                    <label class="mb-15" for="phoneNumber2">状态 <span
                                                                style="color:red">*</span></label>
                                                    <div class="d-flex">
                                                        <div class="radio-horizontal-list d-flex flex-wrap">
                                                            <div class="radio-theme-default custom-radio ">
                                                                <input class="radio" type="radio" name="i" value="1" id="radio-hl1" checked>
                                                                <label for="radio-hl1">
                                                                    <span class="radio-text">启用</span>
                                                                </label>
                                                            </div>
                                                            <div class="radio-theme-default custom-radio ">
                                                                <input class="radio" type="radio" name="i" value="0" id="radio-hl2">
                                                                <label for="radio-hl2">
                                                                    <span class="radio-text">禁止</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-group d-flex pt-25 justify-content-end">
                                                    <button type="submit" class="btn btn-primary btn-block btn-default btn-squared text-capitalize radius-md shadow2">提交
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-sm-6 col-10">
                                    <div class="mt-40 mb-50">
                                        <div class="user-tab-info-title mb-35 text-capitalize">
                                            <h5 class="fw-500">批量生成用户</h5>
                                        </div>
                                        <div class="edit-profile__body">
                                            <form method="POST" action="?act=addPL">
                                                <div class="form-group mb-25">
                                                    <label for="name4">数量(数字)<span
                                                                style="color:red">*</span></label>
                                                    <input type="text" class="form-control" id="name4" name="nums" placeholder="10" value="10">
                                                </div>
                                                <div class="form-group mb-25">
                                                    <label for="phoneNumber1">用户名开头(英文和数字)<span
                                                                style="color:red">*</span></label>
                                                    <input type="text" class="form-control" id="phoneNumber1" name="username" placeholder="请输入用户名" value="user">
                                                </div>
                                                <div class="form-group mb-25">
                                                    <label for="phoneNumber">密码长度<span
                                                                style="color:red">*</span></label>
                                                    <input type="text" class="form-control" id="phoneNumber" name="password" placeholder="6" value="6">
                                                </div>
                                                <div class="form-group mb-25 form-group-calender">
                                                    <label for="datepicker">流量（0-999999/M）<span
                                                                style="color:red">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="phoneNumber" name="rate" placeholder="1024" value="1024">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-25 form-group-calender">
                                                    <label for="datepicker">有效期（0-999999/天）
                                                        <span style="color:red">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="phoneNumber" name="days" placeholder="30" value="30">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-25 status-radio">
                                                    <label class="mb-15" for="phoneNumber2">状态 <span
                                                                style="color:red">*</span></label>
                                                    <div class="d-flex">
                                                        <div class="radio-horizontal-list d-flex flex-wrap">
                                                            <div class="radio-theme-default custom-radio ">
                                                                <input class="radio" type="radio" name="i" value="1"
                                                                       id="radio-hl3" checked>
                                                                <label for="radio-hl3">
                                                                    <span class="radio-text">启用</span>
                                                                </label>
                                                            </div>
                                                            <div class="radio-theme-default custom-radio ">
                                                                <input class="radio" type="radio" name="i" value="0" id="radio-hl4">
                                                                <label for="radio-hl4">
                                                                    <span class="radio-text">禁止</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-group d-flex pt-25 justify-content-end">
                                                    <button type="submit" class="btn btn-primary btn-block btn-default btn-squared text-capitalize radius-md shadow2">提交
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
<?php
include('footer.php');
?>
<script>
    function checkStr() {
        const username = $('[name="username"]').val();
        const password = $('[name="password"]').val();
        const rate = $('[name="rate"]').val();
        const days = $('[name="days"]').val();
        const bz = $('[name="bz"]').val();

        if (username == "" || password == "" || rate == "" || days == "") {
            alert("用户名，密码，流量，期限 均不能为空");
            return false;
        }
        return true;
    }

</script>