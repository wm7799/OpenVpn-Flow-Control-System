<?php
$title = '修改密码';
if ($_GET["act"] == "mod") {
    include("system.php");
    $admin = db("app_admin")->where(array("username" => $_SESSION["dd"]["username"], "password" => $_SESSION["dd"]["password"]))->find();
    if ($_POST["p2"] == $_POST["p3"]) {
        die(json_encode(array("status" => "error", "msg" => "不能修改为重复的密码")));
    } else {
        if ($_POST["p2"] != $admin["password"]) {
            die(json_encode(array("status" => "error", "msg" => "当前密码错误")));
        } else {
            if (trim($_POST["p3"]) == "") {
                die(json_encode(array("status" => "error", "msg" => "密码不得为空")));
            } else {
                if (db("app_admin")->where(array("username" => $admin["username"]))->update(array("password" => $_POST["p3"], "username" => $_POST["p1"]))) {
                    die(json_encode(array("status" => "success", "msg" => "密码修改成功")));
                } else {
                    die(json_encode(array("status" => "error", "msg" => "无法更新数据到数据库")));
                }
            }
        }
    }
} else {
    include('head.php');
    include('nav.php');
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
                                <div class="form-group">
                                    <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">用户名</label>
                                    <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                           id="username"
                                           placeholder="请输入密码" value="<?php echo $admin["username"] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">当前密码</label>
                                    <input type="password"
                                           class="form-control ih-medium ip-gray radius-xs b-light px-15" id="password"
                                           placeholder="请输入密码">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">新密码</label>
                                    <input type="password"
                                           class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                           id="password_new"
                                           placeholder="请输入密码">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block mod">确认修改</button>
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
};
?>
<script>
    $(function () {
        $(".mod").click(function () {
            $.post(
                "?act=mod", {
                    "p1": $("#username").val(),
                    "p2": $("#password").val(),
                    "p3": $("#password_new").val()
                }, function (data) {
                    if (data.status == "success") {
                        alert("密码修改成功");
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }, "JSON"
            );
        });
    });
</script>
