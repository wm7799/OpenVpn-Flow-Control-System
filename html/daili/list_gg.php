<?php
$title = '消息列表';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'del') {
    $db = db('app_gg');
    if($db->where(array('id'=>$_POST['id'],"daili"=>$admin["id"]))->delete()){
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} elseif ($_GET['act'] == 'show') {
    $show = $_POST['show'] == '1' ? "1" : "0";
    $db = db('app_gg');
    if($db->where(array('id'=>$_POST['id'],"daili"=>$admin["id"]))->update(array('show'=>$show))){
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
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
                            <ul class="list-group">
                                <?php
                                $db = db('app_gg');
                                $list = $db->where(array("daili"=>$admin["id"]))->order('id DESC')->select();
                                foreach ($list as $vo) {
                                    echo ' <li class="list-box__item line-id-' . $vo['id'] . '">
        <span class="atbd-tag tag-secondary tag-transparented">' . date('Y/m/d H:i:s', $vo['time']) . '</span>
        ID' . $vo['id'] . '：' . $vo['name'] . '
		<button style="display:inline" type="button" class="btn btn-primary btn-xs btn-squared mr-1" onclick="window.location.href=\'add_gg.php?act=mod&id=' . $vo['id'] . '\'">编辑</button>';
                                    echo '<button style="display:inline" type="button" class="btn btn-danger btn-xs btn-squared" onclick="delLine(\'' . $vo['id'] . '\')">删除</button>
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
<script>
    function qiyong(id) {
        var doc = $('.line-id-' + id + ' .showstatus');
        if (doc.attr('data') == "1") {
            doc.html("已禁用").attr({'data': '0'});
        } else {
            doc.html("已启用").attr({'data': '1'});
        }
        var url = "list_gg.php?act=show";
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
            var url = "list_gg.php?act=del";
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