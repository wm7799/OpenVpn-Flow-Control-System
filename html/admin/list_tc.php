<?php
$title = '套餐管理';
include('head.php');
include('nav.php');
?>
<?php
if ($_GET['act'] == 'del') {
    $db = db('app_tc');
    if ($db->where(array('id' => $_POST['id']))->delete()) {
        db("app_kms")->where(array('type_id' => $_POST['id']))->delete();
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} elseif ($_GET['act'] == 'show') {
    $show = $_POST['show'] == '1' ? "1" : "0";
    $db = db('app_tc');
    if ($db->where(array('id' => $_POST['id']))->update(array('show' => $show))) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} else {
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
                    $db = db('app_tc');
                    $list = $db->where(array())->order('id DESC')->select();
                    foreach ($list as $vo) {
                        echo '<div class="col-xxl-3 col-sm-6 ">
                            <div class="card banner-feature">
                                <div class="card-body">
                                    <h1 class="banner-feature__heading">' . $vo["name"] . '</h1>
                                    <p class="banner-feature__para color-gray">价格：' . $vo["jg"] . '元</p>
                                    <p class="banner-feature__para color-gray">流量：' . $vo["rate"] . 'M</p>
                                    <p class="banner-feature__para color-gray">期限：' . $vo["limit"] . '天</p>
                                    <p class="banner-feature__para color-gray">介绍：' . $vo["content"] . '</p>
                                    <button style="display:inline" class="banner-feature__btn btn btn-outline-info btn-sm px-20 radius-xs fs-14" type="button" onclick="window.location.href=\'km_list.php?tid=' . $vo['id'] . '\'">管理/添加卡密</button>
                                    <button style="display:inline" class="banner-feature__btn btn btn-outline-primary btn-sm px-20 radius-xs fs-14" type="button" onclick="window.location.href=\'add_tc.php?act=mod&id=' . $vo['id'] . '\'">编辑</button>
                                    <button style="display:inline" class="banner-feature__btn btn btn-outline-danger btn-sm px-20 radius-xs fs-14" type="button" onclick="delLine(\'' . $vo['id'] . '\')">删除</button>
                                ';
                        echo '</div>
              </div>
              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('footer.php');
?>
<script>
    function qiyong(id) {
        var doc = $('.line-id-' + id + ' .showstatus');
        if (doc.attr('data') == "1") {
            doc.html("已禁用").attr({'data': '0'});
        } else {
            doc.html("已启用").attr({'data': '1'});
        }
        var url = "list_tc.php?act=show";
        var data = {
            "id": id,
            "show": doc.attr('data')
        };
        $.post(url, data, function (data) {
            if (data.status == "success") {

            } else {
                alert("操作失败");
            }
        }, "JSON");
    }

    function delLine(id) {
        if (confirm('确认删除吗？删除后不可恢复哦！')) {
            $('.line-id-' + id).slideUp();
            var url = "list_tc.php?act=del";
            var data = {
                "id": id
            };
            $.post(url, data, function (data) {
                if (data.status == "success") {
                } else {
                    alert("删除失败");
                }
            }, "JSON");
        }
    }
</script>
