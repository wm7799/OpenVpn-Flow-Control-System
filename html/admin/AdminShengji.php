<?php
$title = 'APP升级推送';
include('head.php');
include('nav.php');
$require = true;
$m = new Map();
if ($_GET['act'] == 'update') {
    $m->type("cfg_sj")->update("versionCode", $_POST["versionCode"]);
    $m->type("cfg_sj")->update("url", $_POST["url"]);
    $m->type("cfg_sj")->update("content", $_POST["content"]);
    $m->type("cfg_sj")->update("opens", $_POST["opens"]);
    $m->type("cfg_sj")->update("spic", $_POST["spic"]);
    tip_success("修改成功", 'AdminShengji.php?act=mod&id=' . $_GET['id']);
} else {
    $data = $m->type("cfg_sj")->getAll();
    $action = '?act=update';
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
                                <form role="form" method="POST" action="<?php echo $action ?>"
                                      onsubmit="return checkStr()">
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">版本号(大于APP时才能检测到更新)</label>
                                           <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="versionCode" value="<?php echo $data["versionCode"] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">更新说明</label>
                                        <textarea class="form-control" rows="10"
                                                                             name="content"><?php echo $data["content"] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">APP下载连接</label>
                                        <input class="form-control ih-medium ip-gray radius-xs b-light px-15" rows="10" name="url"
                                                                          value="<?php echo $data["url"] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">功能开关</label>
                                                <select name="opens">
                                                    <option value="error">关闭</option>
                                                    <option value="success" <?php echo $data["opens"] == "success" ? " selected " : ""; ?>>
                                                        开启
                                                    </option>
                                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">启动图地址</label>
                                        <input class="form-control ih-medium ip-gray radius-xs b-light px-15" name="spic"
                                                                          value="<?php echo $data["spic"] ?>"></div>
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
    <script>
        function checkStr() {
            var title = $('[name="title"]').val();
            var content = $('[name="content"]').val();
            if (title == "" || content == "") {
                alert("标题与内容不得为空");
                return false;
            }
            return true;
        }
    </script>
    <?php
}
include('footer.php');
?>
