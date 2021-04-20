<?php
if ($_GET['act'] == 'del') {
    include('system.php');
    $db = db('app_feedback');
    if ($db->where(array('id' => $_POST['id']))->delete()) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} elseif ($_GET['act'] == 'del_all') {
    include('head.php');
    include('nav.php');
    $db = db('app_feedback');
    if ($db->where(array('type_id' => $_GET['gid']))->delete()) {
        tip_success("删除成功", $_SERVER['HTTP_REFERER']);
    } else {
        tip_failed("删除失败", $_SERVER['HTTP_REFERER']);
    }
} else {
    $title = '线路反馈消息';
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
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                        <form action="?act=del_select" method="POST">
                            <button type="button" class="btn btn-danger btn-default btn-squared btn-shadow-danger mb-3"
                                    onclick="delAll('<?php echo $tid ?>')">清空
                            </button>
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-checkbox  check-all">
                                                    <input class="checkbox" type="checkbox" id="check-3">
                                                    <label for="check-3">
                                                        <span class="checkbox-text userDatatable-title">用户</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">线路</span>
                                        </th>
                                        <?php
                                        $numrows = db("app_feedback")->order("id DESC")->getnums();
                                        foreach ($config["Feedback"]["Field"] as $key => $vo) {
                                            echo '<th><span class="userDatatable-title">' . $key . '</span></th>';
                                        }
                                        echo '<th><span class="userDatatable-title">时间</span></th>
                                            <th><span class="userDatatable-title float-right">操作</span></th></tr></thead><tbody>';
                                        $rs = db("app_feedback")->order("id DESC")->select();
                                        foreach ($rs

                                        as $res) {
                                        $info = db(_openvpn_)->where(array("id" => $res["user_id"]))->find();
                                        $info2 = db("line")->where(array("id" => $res["line_id"]))->find();
                                        echo "<tr class=\"line-id-" . $res["id"] . "\">";
                                        ?>
                                        <td>
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <div class="checkbox-group-wrapper">
                                                        <div class="checkbox-group d-flex">
                                                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                <input class="checkbox" type="checkbox"
                                                                       id="check-grp-<?= $res["id"] ?>">
                                                                <label for="check-grp-<?= $res["id"] ?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="userDatatable-content">
                                                    <?= $info[_iuser_] ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= $info2["name"] ?>
                                            </div>
                                        </td>
                                        <?php
                                        $data = json_decode(base64_decode($res["content"]), true);
                                        foreach ($config["Feedback"]["Field"] as $key => $vo) {
                                            echo '<td><div class="userDatatable-content">' . $data[$key] . '</div></td>';
                                        }
                                        ?>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= date("Y/m/d H:i:s", $res["time"]) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a href="?act=del&id=<?= $res['id'] ?>" class="remove"
                                                       onclick="delById('<?= $res["id"] ?>')">
                                                        <span data-feather="trash-2"></span></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo create_page_html($numrows, $_GET["page"]); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function delById(id, action) {
            if (confirm('确认删除吗？删除后不可恢复哦！')) {
                var url = "?act=del";
                var data = {
                    "id": id
                };
                $.post(url, data, function (data) {
                    if (data.status == "success") {
                        $('.line-id-' + id).slideUp();
                    } else {
                        alert("删除失败");
                    }
                }, "JSON");
            }
        }

        function delAll(id) {
            if (confirm('确认删除吗？删除后不可恢复哦！')) {
                location.href = "?act=del_all&gid=" + id;
            }
        }
    </script>
    <?php
    include("footer.php");
}
?>
