<?php
$title = '分类管理';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'del') {
    $db = db('line_grop');
    if ($db->where(["id" => $_GET["id"]])->delete()) {
        db("line")->where(["type" => $_GET["id"]])->delete();
        tip_success("删除分类并清空本分类下全部线路成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("删除失败", "?");
    }
} elseif ($_GET['act'] == 'add') {
    $db = db('line_grop');
    if ($db->insert(['name' => $_POST['name'], 'order' => $_POST['order'], 'show' => 1])) {
        tip_success("新增【" . $_POST['name'] . "】成功！", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("分类新增失败", "?");
    }
} else {
    $action = '?act=add';
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
                                <form role="form" method="POST" action="<?php echo $action; ?>">
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">分类名称</label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               name="name" placeholder="分类名称"
                                               value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="color-dark fs-14 fw-500 align-center">排序（0-9999
                                            数字越小越靠前）</label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               name="order" placeholder="排序"
                                               value="1">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-primary btn-default btn-squared btn-shadow-primary mb-3"
                                                onclick="autoGs()"><span data-feather="plus"></span>
                                            添加
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <ul class="list-group">
                                <?php
                                $list = db("line_grop")->where(array())->order("`order` ASC,id DESC")->select();
                                foreach ($list as $vo) {
                                    echo ' <li class="list-group-item line-id-' . $vo['id'] . '">
			序号:' . $vo['order'] . ':' . $vo['name'];
                                    echo '<button type="button" class="btn btn-danger btn-xs" onclick="if(confirm(\'删除分类会一并删除本分类下全部线路！\')){window.location.href=\'?act=del&id=' . $vo['id'] . '\'}else{return false}">删除</button>
		</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('footer.php');
?>
