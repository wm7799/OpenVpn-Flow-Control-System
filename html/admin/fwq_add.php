<?php
$title = '添加服务器';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'update') {
    $db = db('app_tc');
    if ($db->where(array('id' => $_GET['id']))->update(array(
        'name' => $_POST['name'],
        'content' => $_POST['content'],
        'jg' => $_POST['jg'],
        'limit' => $_POST['limit'],
        'rate' => $_POST['rate'],
        'url' => $_POST['url']
    ))) {
        tip_success("公告修改成功", '?act=mod&id=' . $_GET['id']);
    } else {
        tip_failed("十分抱歉修改失败", '?act=mod&id=' . $_GET['id']);
    }
} elseif ($_GET['act'] == 'add') {

    $db = db("auth_fwq");
    if ($db->insert(array(
        'name' => $_POST['name'],
        'ipport' => $_POST['ipport']
    ))) {
        tip_success("新增服务器【" . $_POST['name'] . "】成功！", 'fwq_list.php');
    } else {
        tip_failed("十分抱歉修改失败", '?');
    }
} else {
    $action = "?act=add";
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
                                        <label for="formGroupExampleInput" class="color-dark fs-14 fw-500 align-center">服务器名字
                                            <span style="color:red">*</span>
                                        </label>
                                            <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                                   name="name" placeholder="节点1"
                                                   value="<?php echo $info['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput" class="color-dark fs-14 fw-500 align-center">IP与端口
                                            <span style="color:red">*</span>
                                        </label>
                                            <div class="input-group">
                                                <span class="input-group-addon align-center">http://</span><input type="text"
                                                                                                     class="form-control"
                                                                                                     name="ipport"
                                                                                                     placeholder="10.8.0.1:4190"
                                                                                                     value="<?php echo $info['ipport'] ?>">
                                            </div>
                                    </div>
                                    <div class="layout-button mt-25">
                                        <button type="submit"
                                                class="btn btn-primary btn-default btn-squared px-30 btn-block">
                                            添加服务器
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
    <script>
        function checkStr() {
            var name = $('[name="name"]').val();
            var ip = $('[name="ipport"]').val();
            if (name == "" || ip == "") {
                alert("参数填写不完整");
                return false;
            }
            return true;
        }
    </script>
    <?php
}
include('footer.php');
?>
