<?php
$title = '发布消息';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'update') {
    $db = db('app_gg');
    if ($db->where(array('id' => $_GET['id']))->update(array(
        'name'=>$_POST['name'],
			'daili'=>$admin["id"],
			'content'=>$_POST['content'],
    ))) {
        tip_success("公告修改成功", 'add_gg.php?act=mod&id=' . $_GET['id']);
    } else {
        tip_failed("十分抱歉修改失败", 'add_gg.php?act=mod&id=' . $_GET['id']);
    }
} elseif ($_GET['act'] == 'add') {
    $db = db('app_gg');
    if ($db->insert(array(
        'name'=>$_POST['name'],
			'daili'=>$admin["id"],
			'content'=>$_POST['content'],
			'time'=>time()
    ))) {
        tip_success("新增消息【" . $_POST['name'] . "】成功！", 'add_gg.php');
    } else {
        tip_failed("十分抱歉修改失败", 'add_gg.php');
    }
} else {
    $action = '?act=add';
    if ($_GET['act'] == 'mod') {
        $info = db('app_gg')->where(array('id'=>$_GET['id'],'daili'=>$admin["id"],))->find();
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
                    <div class="card card-Vertical card-default card-md mb-4">
                        <div class="card-body pb-md-30">
                            <div class="Vertical-form">
                                <div class="alert alert-danger">公告只会在用户登录时、连接时和切换账号时才会更新。</div>
                                <form role="form" method="POST" action="<?php echo $action ?>"
                                      onsubmit="return checkStr()">
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">标题</label>
                                            <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15" name="name" placeholder="标题"
                                                   value="<?php echo $info['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">主要内容</label>
                                        <textarea class="form-control" rows="10"
                                             name="content"><?php echo $info['content'] ?></textarea>
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