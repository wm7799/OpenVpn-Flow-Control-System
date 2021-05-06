<?php
$title = '卡密生成';
function getkm($len = 18)
{
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $strlen = strlen($str);
    $randstr = "";
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr;
}
if ($_GET['act'] == 'save') {
    include('system.php');
    $db = db("app_kms");
    $n = 0;
    for ($i = 0; $i < intval($_POST["nums"]); $i++) {
        $km = getkm(18);
        if ($db->insert(array("km" => $km, "addtime" => time(), "type_id" => $_POST["tid"]))) {
            $kms[] = '$km[]="' . $km . "\";";
            $n++;
        };
    }
    file_put_contents("kmdata.php", '<?php' . "\n" . implode("\n", $kms));
    die(json_encode(array("status" => 'success')));
} elseif ($_GET['act'] == 'del') {
    include('system.php');
    $db = db('app_kms');
    if ($db->where(array('id' => $_POST['id'], "daili" => 0))->delete()) {
        die(json_encode(array("status" => 'success')));
    } else {
        die(json_encode(array("status" => 'error')));
    }
} elseif ($_GET['act'] == 'del_select') {
    include('head.php');
    include('nav.php');
    $db = db('app_kms');
    $n = 0;
    $arr = $_POST['checkbox'];
    foreach ($arr as $id) {
        if ($db->where(array('id' => $id, "daili" => 0))->delete()) {
            $n++;
        }
    }
    tip_success($n . "条卡密删除成功", "?tid=" . $_GET["id"]);
}
elseif ($_GET['act'] == 'search') {
include('head.php');
include('nav.php');
$rs = db("app_kms")->where(["km" => $_GET["kw"]])->order("id DESC")->select();
if ($rs) {
?>
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                        </div>
                        <form action="?" method="get"
                              class="d-flex align-items-center user-member__form my-sm-0 my-2">
                            <span data-feather="search"></span>
                            <input type="hidden" class="form-control" name="act" value="search">
                            <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                   placeholder="搜索卡密" aria-label="Search" name="kw" value="<?= $_GET["kw"] ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                    <div class="table-responsive">
                        <?php
                        echo '<table class="table mb-0 table-borderless">
	   <thead>
		  <tr class="userDatatable-header">
		   <th >
		   <div class="d-flex align-items-center">
                <div class="custom-checkbox  check-all">
                    <input class="checkbox" type="checkbox" id="checkbox" name="checkbox-all" value="">
                    <label for="checkbox">
                        <span class="checkbox-text userDatatable-title">ID</span>
                    </label>
                </div>
            </div>
		   </th>
	   <th><span class="userDatatable-title">卡密</span></th>
	   <th><span class="userDatatable-title">状态</span></th>
		<th><span class="userDatatable-title">套餐时间</span></th>
		<th><span class="userDatatable-title">套餐流量</span></th>
		<th><span class="userDatatable-title">使用者</span></th>
		<th><span class="userDatatable-title">使用时间</span></th>
		<th><span class="userDatatable-title">添加时间</span></th>
		<th><span class="userDatatable-title float-right">操作</span></th>
		  </tr>
	   <tbody>';
                        foreach ($rs as $res) {
                            $info = db("app_tc")->where(array("id" => $res["type_id"]))->find();
                            echo "<tr class=\"line-id-" . $res["id"] . "\">";
                            ?>
                            <td>
                                <div class="d-flex">
                                    <div class="d-flex align-items-center">
                                        <div class="checkbox-group-wrapper">
                                            <div class="checkbox-group d-flex">
                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                    <input class="checkbox" id="check-grp-<?= $res["id"] ?>"
                                                           name="checkbox[]" type="checkbox"
                                                           value="<?= $res["id"] ?>"/>
                                                    <label for="check-grp-<?= $res["id"] ?>"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="userDatatable-content">
                                        <?= $res["id"] ?>
                                    </div>
                                </div>
                            </td>
                            <?php
                            echo '<td><div class="userDatatable-content">';
                            if ($res["isuse"] == 1) {
                                echo '<s style="color:red">' . $res["km"] . '</s>';
                            } else {
                                echo $res["km"];
                            }
                            "</div></td>";
                            echo '<td><div class="userDatatable-content">';
                            if ($res["isuse"] == 1) {
                                echo "已使用";
                            } else {
                                echo "正常";
                            }
                            echo "</div></td>";
                            echo '<td><div class="userDatatable-content">' . $info["limit"] . "天</div></td>";
                            echo '<td><div class="userDatatable-content">' . round($info["rate"], 3) . "MB&nbsp;" . $pre . '</div></td>';
                            echo '<td><div class="userDatatable-content">';
                            if ($res["user_id"] > 0) {
                                $uinfo = db(_openvpn_)->where(["id" => $res["user_id"]])->find();
                                echo $uinfo["iuser"];
                            } else {
                                echo " - ";
                            }
                            echo "</div></td>";
                            echo '<td><div class="userDatatable-content">';
                            if ($res["usetime"] != "" && $res["usetime"] != 0) {
                                echo date("Y/m/d H:i:s", $res["usetime"]);
                            } else {
                                echo " - ";
                            }
                            echo "</div></td>";
                            echo '<td><div class="userDatatable-content">';
                            if ($res["addtime"] != "" && $res["addtime"] != 0) {
                                echo date("Y/m/d H:i:s", $res["addtime"]);
                            } else {
                                echo " - ";
                            }
                            echo "</div></td>";
                            echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="delById(\'' . $res["id"] . '\')">删除</button></td>';
                            echo "</tr>";
                        }
                        echo "
		 </tbody>
	   </thead>
	</table>";
                        } else {
                            echo "<div class='mt-5' style='text-align: center;'>";
                            echo "空空如也~暂时没有任何卡密！";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    } elseif ($_GET['act'] == 'show') {
        include('head.php');
        echo "请复制保存<br>";
        $db = db('app_kms');
        $list = $db->where(array('type_id' => $_GET['id'], "isuse" => 0, "daili" => 0))->order("id DESC")->select();
        echo "<br><textarea style='width:100%;height:400px;'>";
        foreach ($list as $vo) {
            echo $vo["km"] . "\n";
        }
        echo "</textarea>";
    } elseif ($_GET['act'] == 'del_all') {
        include('head.php');
        include('nav.php');
        $db = db('app_kms');
        if ($db->where(array('type_id' => $_GET['gid'], "daili" => 0))->delete()) {
            tip_success("删除成功", $_SERVER['HTTP_REFERER']);
        } else {
            tip_failed("删除失败", $_SERVER['HTTP_REFERER']);
        }
    } else {
        include('head.php');
        include('nav.php');
        if (trim($_GET["tid"]) == "") {
            $tmp = db("app_tc")->order("id DESC")->find();
            $tid = $tmp["id"];
        } else {
            $tid = $_GET["tid"];
        }
        if (!$tc_info = db("app_tc")->where(array("id" => $tid))->find()) {
            die("没有此套餐");
        };
        ?>
        <div class="contents">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main user-member justify-content-sm-between ">
                            <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                                <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                    <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                                </div>
                                <form action="?" method="get"
                                      class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                    <span data-feather="search"></span>
                                    <input type="hidden" class="form-control" name="act"
                                           value="search">
                                    <input class="form-control mr-sm-2 border-0 box-shadow-none"
                                           type="search"
                                           placeholder="搜索卡密" aria-label="Search" name="kw">
                                </form>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary btn-add dropdown-toggle px-15"
                                        type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="las la-plus fs-16"></i> 操作
                                </button>
                                <div class="dropdown-default dropdown-menu"
                                     aria-labelledby="dropdownMenu2">
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       onclick="delAll('<?php echo $tid ?>')"> 清空本套餐</a>
                                    <a href="km_list.php?act=show&id=<?php echo $tid ?>"
                                       target="_blank"
                                       class="dropdown-item"> 导出本套餐未使用卡密</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                            <form action="?act=del_select" method="POST">
                                <div class="dropdown mb-3 mr-2">
                                    <button type="button"
                                            class="btn btn-light btn-outlined btn-outline-light dropdown-toggle"
                                            id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        选择套餐
                                        <i class="la la-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php
                                        //$rs=$DB->query("SELECT * FROM `auth_fwq`  order by id desc limit 20");
                                        $km_type = db("app_tc")->order("id DESC")->select();
                                        foreach ($km_type as $res) {
                                            if ($res['id'] == $tid) {
                                                echo '<a style="display: flex;align-items: center;justify-content: space-between;" class="dropdown-item" href="?tid=' . $res['id'] . '">' . $res['name'] . '<span class="badge-dot dot-info"></span></a>';
                                            } else {
                                                echo '<a class="dropdown-item" href="?tid=' . $res['id'] . '">' . $res['name'] . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <button style="display: inline;" type="submit"
                                        class="btn btn-danger btn-default btn-squared btn-shadow-danger ">
                                    删除所选
                                </button>&nbsp;
                                <a style="color: #fff;display: inline-block"
                                   class="btn btn-primary btn-default btn-squared btn-shadow-primary "
                                   data-toggle="modal"
                                   data-target="#myModal" id="setting">
                                    新增卡密
                                </a>&nbsp;

                                <div class="table-responsive">
                                    <?php
                                    $numrows = db("app_kms")->where(array("type_id" => $tid, "daili" => 0))->order("id DESC")->getnums();
                                    $rs = db("app_kms")->where(array("type_id" => $tid, "daili" => 0))->order("id DESC")->fpage($_GET["page"], 30)->select();
                                    if ($rs) {
                                        echo '<table class="table mb-0 table-borderless">
   <thead>
      <tr class="userDatatable-header">
      <th>
             <div class="d-flex align-items-center">
                <div class="custom-checkbox  check-all">
                    <input class="checkbox" type="checkbox" id="checkbox" name="checkbox-all" value="">
                    <label for="checkbox">
                        <span class="checkbox-text userDatatable-title">ID</span>
                    </label>
                </div>
            </div>
      </th>
   <th><span class="userDatatable-title">卡密</span></th>
   <th><span class="userDatatable-title">状态</span></th>
    <th><span class="userDatatable-title">套餐时间</span></th>
	<th><span class="userDatatable-title">套餐流量</span></th>
	<th><span class="userDatatable-title">使用者</span></th>
	<th><span class="userDatatable-title">使用时间</span></th>
	<th><span class="userDatatable-title">添加时间</span></th>
	<th><span class="userDatatable-title float-right">操作</span></th>
      </tr>
   <tbody>';
                                        foreach ($rs as $res) {
                                            $info = db("app_tc")->where(array("id" => $res["type_id"]))->find();
                                            echo "<tr class=\"line-id-" . $res["id"] . "\">";
                                            ?>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="checkbox-group-wrapper">
                                                            <div class="checkbox-group d-flex">
                                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox"
                                                                           id="check-grp-<?= $res["id"] ?>"
                                                                           name="checkbox[]"
                                                                           type="checkbox"
                                                                           value="<?= $res["id"] ?>"/>
                                                                    <label for="check-grp-<?= $res["id"] ?>"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="userDatatable-content">
                                                        <?= $res["id"] ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php
                                            echo '<td><div class="userDatatable-content">';
                                            if ($res["isuse"] == 1) {
                                                echo '<s style="color:red">' . $res["km"] . '</s>';
                                            } else {
                                                echo $res["km"];
                                            }
                                            "</div></td>";
                                            echo '<td><div class="userDatatable-content">';
                                            if ($res["isuse"] == 1) {
                                                echo "已使用";
                                            } else {
                                                echo "正常";
                                            }
                                            echo "</div></td>";
                                            echo '<td><div class="userDatatable-content">' . $info["limit"] . "天</div></td>";
                                            echo '<td><div class="userDatatable-content">' . round($info["rate"], 3) . "MB&nbsp;" . $pre . '</div></td>';
                                            echo '<td><div class="userDatatable-content">';
                                            if ($res["user_id"] > 0) {
                                                $uinfo = db(_openvpn_)->where(["id" => $res["user_id"]])->find();
                                                echo $uinfo["iuser"];
                                            } else {
                                                echo " - ";
                                            }
                                            echo "</div></td>";
                                            echo '<td><div class="userDatatable-content">';
                                            if ($res["usetime"] != "" && $res["usetime"] != 0) {
                                                echo date("Y/m/d H:i:s", $res["usetime"]);
                                            } else {
                                                echo " - ";
                                            }
                                            echo "</div></td>";
                                            echo '<td><div class="userDatatable-content">';
                                            if ($res["addtime"] != "" && $res["addtime"] != 0) {
                                                echo date("Y/m/d H:i:s", $res["addtime"]);
                                            } else {
                                                echo " - ";
                                            }
                                            echo "</div></td>";
                                            echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="delById(\'' . $res["id"] . '\')">删除</button></td>';
                                            echo "</tr>";
                                        }
                                        echo "
		 </tbody>
	   </thead>
	</table>";
                                    } else {
                                        echo "<div class='mt-5' style='text-align: center;'>";
                                        echo "空空如也~暂时没有任何卡密！";
                                        echo "</div>";
                                    }
                                    ?>
                            </form>
                        </div>
                        <?php
                        echo create_page_html($numrows, $_GET["page"], 30, "&tid=" . $_GET["tid"]); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            卡密生成
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="color-dark fs-14 fw-500 align-center">生成的套餐：</label>
                            <?php
                            echo $tc_info["name"] . '(';
                            echo $tc_info["limit"] . "天/" . round($tc_info["rate"], 3) . "M)";
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="name" class="color-dark fs-14 fw-500 align-center">请输入数量(0-9999)</label>
                            <input type="text" class="form-control" id="creat_kms" placeholder=""
                                   value="200">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            关闭
                        </button>
                        <button type="button" class="btn btn-primary save">
                            提交更改
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php
    }
    include("footer.php");
    ?>
    <script>
        $(function () {
            $('#myModal').modal('hide');
        });

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

        $(function () {
            $('#myModal').on('hide.bs.modal', function () {
                //alert('嘿，我听说您喜欢模态框...');
            })
        });
        $(function () {
            $(".save").click(function () {
                var nums = $("#creat_kms").val();
                if (nums == "") {
                    alert("请输入生成的卡密数量");
                }
                $.post('?act=save', {
                    "tid": '<?php echo $tid?>',
                    "nums": nums
                }, function (data) {
                    if (data.status == "success") {
                        $('#setting').click();
                        window.location.href = "km_his.php";
                    } else {
                        alert(data.msg);
                    }
                }, "JSON");
            });
        });
    </script>
