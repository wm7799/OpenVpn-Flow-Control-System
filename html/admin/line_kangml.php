<?php
$title = '官方线路推送';
if ($_GET['act'] == 'add') {
    require("system.php");
    $sqlInfoLine = ["host" => "43.226.76.19", "user" => "mysql2104283bc9", "pass" => "06ous0zfYy", "port" => "3306", "db" => "mysql2104283bc9_db", "table" => "line"];
    $kangml_dbLine = dbRemote($sqlInfoLine);
    $lineres = $kangml_dbLine->where(array('id' => $_POST['id']))->find();
    $name = $lineres['name'];
    $type = $lineres['type'];
    $label = $lineres['label'];
    $content = $lineres['content'];
    $group = $lineres['group'];
    $show = '0';
    $time = time();
    $db = db('line');
    if ($db->insert(array(
        'name' => $name,
        'type' => $type,
        'label' => $label,
        'content' => $content,
        'group' => $group,
        'time' => $time,
        'show' => $show
    ))) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} else {
    include('head.php');
    include('nav.php');
    $sqlInfoLine = ["host" => "43.226.76.19", "user" => "mysql2104283bc9", "pass" => "06ous0zfYy", "port" => "3306", "db" => "mysql2104283bc9_db", "table" => "line"];
    $kangml_dbLine = dbRemote($sqlInfoLine);
    $sqlInfoLineGroup = ["host" => "43.226.76.19", "user" => "mysql2104283bc9", "pass" => "06ous0zfYy", "port" => "3306", "db" => "mysql2104283bc9_db", "table" => "line_grop"];
    $kangml_dbLineGroup = dbRemote($sqlInfoLineGroup);
    ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main user-member justify-content-sm-between ">
                        <?php
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
                        $list = $kangml_dbLine->where(implode(" AND ", $where), $data)->order('`order` DESC,id DESC')->fpage(@$_GET["page"], 20)->select();
                        $numrows = $kangml_dbLine->getnums();
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
                            $rs = $kangml_dbLineGroup->where()->select();
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
                                <span class="userDatatable-title float-right">操作</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //排除已添加
                        $nowLineArr = db('line')->where(implode(" AND ", $where), $data)->order('`order` DESC,id DESC')->fpage(@$_GET["page"], 20)->select();
                        foreach ($nowLineArr as $value) {
                            $nowLineNameArr[] = $value["name"];
                        }
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
                                    <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                        <li>
                                            <?php
                                            if (in_array($vo["name"], $nowLineNameArr)) {
                                                //已存在这个线路
                                                echo '<a href="javascript:void(0);" class="edit"
                                           onclick="">
                                        <span data-feather="check"></span></a>';
                                            } else {
                                                echo '<a href="javascript:void(0);" class="view"
                                           onclick="addLine(\'' . $vo["id"] . '\')">
                                        <span data-feather="plus"></span></a>';
                                            }
                                            ?>

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
    function addLine(id) {
        var doc = $('.line-id-' + id + ' .view');
        doc.html("<span data-feather='check'></span>").attr({'onclick': ''});
        var url = "line_kangml.php?act=add";
        var data = {
            "id": id
        };
        $.post(url, data, function (data) {
            if (data.status == "success") {
                showTongZhi('check-circle', false, "成功", "此线路已添加成功，默认为禁用。");
            } else {
                alert("添加失败");
            }
        }, "JSON");
    }
</script>