<?php
$title = '线路管理';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'del'){
    $db = db('line');
    if ($db->where(array('id' => $_POST['id']))->delete()) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} elseif ($_GET['act'] == 'show') {
    $show = $_POST['show'] == '1' ? "1" : "0";
    $db = db('line');
    if ($db->where(array('id' => $_POST['id']))->update(array('show' => $show))) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
}
else{
?>
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <?php
                    $db = db('line');
                    if (@$_GET["gid"] == "") {
                        $data = [];
                    } else {
                        $where[] = "`group`=:group ";
                        $data[":group"] = $_GET["gid"];
                    }
                    if (@$_GET["kw"] != "") {
                        $where[] = " name LIKE :name";
                        $data[":name"] = "%" . $_GET["kw"] . "%";
                    }
                    $list = $db->where(implode(" AND ", $where), $data)->order('`order` DESC,id DESC')->fpage(@$_GET["page"], 20)->select();
                    $numrows = $db->getnums();
                    echo '<div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                        <h4 class="text-capitalize fw-500 breadcrumb-title">' . $title . '</h4>
                                        <span class="sub-title ml-sm-25 pl-sm-25">' . $numrows . ' 个线路</span>
                                    </div>
                                    <form action="line_list.php" method="get" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                        <span data-feather="search"></span>
                                        <input type="hidden" class="form-control" name="gid" value="' . $_GET["gid"] . '">
                                        <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                               placeholder="搜索线路名称" aria-label="Search" name="kw" value="' . $_GET["kw"] . '">
                                    </form>
                            </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary btn-add dropdown-toggle px-15" type="button"
                                            id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="las la-list fs-16"></i> 分类
                                    </button>'; ?>
                    <div class="dropdown-default dropdown-menu" aria-labelledby="dropdownMenu3">
                        <?php
                        if (@$_GET["gid"] == "") {
                            echo '<a class="dropdown-item" href="?' . $t_str . '" style="display: flex;align-items: center;justify-content: space-between;">全部<span class="badge-dot dot-info"></span></a>';
                        } else {
                            echo '<a class="dropdown-item" href="?' . $t_str . '" >全部</a>';
                        }
                        $rs = db("line_grop")->where()->select();
                        foreach ($rs as $res) {
                            if ($res['id'] == $_GET["gid"]) {
                                echo '<a class="dropdown-item" href="?gid=' . $res["id"] . '" style="display: flex;align-items: center;justify-content: space-between;">' . $res['name'] . '<span class="badge-dot dot-info"></span></a>';
                            } else {
                                echo '<a class="dropdown-item" href="?gid=' . $res["id"] . '">' . $res['name'] . '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
            <div class="table-responsive">
                <table class="table mb-0 table-borderless">
                    <thead>
                    <tr class="userDatatable-header line-id-<?= $res['id'] ?>">
                        <th>
                            <div class="d-flex align-items-center">
                                <div class="custom-checkbox  check-all">
                                    <input class="checkbox" type="checkbox" id="check-3">
                                    <label for="check-3">
                                        <span class="checkbox-text userDatatable-title">名称</span>
                                    </label>
                                </div>
                            </div>
                        </th>
                        <th>
                            <span class="userDatatable-title">类型</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">说明</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">状态</span>
                        </th>
                        <th>
                            <span class="userDatatable-title float-right">操作</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list as $vo) {
                        ?>
                        <tr class="line-id-<?= $vo['id'] ?>">
                            <td>
                                <div class="d-flex">
                                    <div class="d-flex align-items-center">
                                        <div class="checkbox-group-wrapper">
                                            <div class="checkbox-group d-flex">
                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                    <input class="checkbox" type="checkbox"
                                                           id="check-grp-<?= $vo['id'] ?>">
                                                    <label for="check-grp-<?= $vo['id'] ?>"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="userDatatable-content">
                                        <?= $vo['name'] ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= $vo['type'] ?>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?= $vo['label'] ?>
                                </div>
                            </td>
                            <td>
                                <div class="userDatatable-content">
                                    <?php echo $vo['show'] == '1' ? '<button type="button" class="btn btn-success btn-xs showstatus" onclick="qiyong(\'' . $vo['id'] . '\')" data="1">已启用</button>' : '<button type="button" class="btn btn-danger btn-xs showstatus" onclick="qiyong(\'' . $vo['id'] . '\')" data="0">已禁用</button>'; ?>
                                </div>
                            </td>
                            <td>
                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                    <li>
                                        <a href="line_add.php?act=mod&id=<?= $vo['id'] ?>"
                                           class="view">
                                            <span data-feather="edit"></span></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="remove"
                                           onclick="delLine('<?= $vo['id'] ?>')">
                                            <span data-feather="trash-2"></span></a>
                                    </li>
                                    <li>
                                        <a href="option.php?my=download&id=<?= $vo['id'] ?>" class="edit">
                                            <span data-feather="download"></span></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        echo create_page_html($numrows, $_GET["page"], 30, "&gid=" . $_GET["gid"]);
        ?>
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
                    doc.html("已禁用").attr({'data': '0','class': 'btn btn-danger btn-xs showstatus'});
                } else {
                    doc.html("已启用").attr({'data': '1','class': 'btn btn-success btn-xs showstatus'});
                }
                var url = "line_list.php?act=show";
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
                    var url = "line_list.php?act=del";
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
        <iframe name="download" style="display:none"></iframe>