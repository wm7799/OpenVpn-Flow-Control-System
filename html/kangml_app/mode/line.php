<script>
    var select_note_id = 0;
</script>
<?php

$m = new Map();
$noteoff = $m->type("cfg_app")->getValue("noteoff", 0);
$LINE = $m->type("cfg_app")->getValue("LINE", "no_abs");
$regionno = false;

$isp = $_GET["i"];
$_SESSION["isp"] = $isp;
$_SESSION["is_tmp_location"] = true;
$line_grop = db('line_grop')->where(array("show" => 1))->order('`order` ASC,id ASC')->select();
$select_box_status = "display:none";
$line_box_status = "display:block";
if ($noteoff == "1") {
    $note = db("app_note");
    $res = $note->order("id ASC")->select();
    $select_box_status = "display:block";
    $line_box_status = "display:none";
    $userinfo = db("openvpn")->where(["iuser" => $_GET["username"]])->find();
    if ($userinfo["note_id"] != 0) {
        if ($selected_note = $note->where(["id" => $userinfo["note_id"]])->find()) {
            $select_box_status = "display:none";
            $line_box_status = "display:block";
        }
    }

    ?>
    <div class="card card-default card-md mb-4 select_note" style="<?= $select_box_status ?>">
        <div class="card-body">
            <div class="page-title-block">
                <div class="page-title-wrap  wrapper-bordered">
                    <div class="page-title d-flex justify-content-between">
                        <div class="page-title__left">
                            <span class="title-text">选择节点</span>
                            <span class="sub-title">合理选择节点可改善网速</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <?php
            foreach ($res as $vo) {
                $selected = $vo["default"] == "1" ? " selected " : "";
                $color = "";
                $status = "";
                if ($vo["count"] != 0) {
                    $online = db("openvpn")->where(["last_ip" => $vo["ipport"], "online" => 1])->getnums();
                    //$online = rand(0,140);
                    if ($online == 0) {
                        $status = "空闲";
                        $color = "text-primary";
                    } else {
                        $status = round($online / $vo["count"] * 100, 0);
                        if ($status < 1) $status = 1;
                        if ($status > 100) $status = 100;

                        if ($status >= 1 && $status < 30) {
                            $color = "text-primary";
                        } else if ($status >= 30 && $status < 60) {
                            $color = "text-success";
                        } else if ($status >= 60 && $status < 80) {
                            $color = "text-warning";
                        } else {
                            $color = "text-danger";
                        }
                        $status = "负荷:" . $status . "%";
                    }
                }
                ?>
                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4 select_note" style="<?= $select_box_status ?>">
                        <div class="card-body d-flex justify-content-between">
                            <div style="width: 60%">
                                <h4 class="list-group-item-heading">
                                    <?= $vo["name"] ?>&nbsp;&nbsp;<em><small
                                                class="<?= $color ?>"><?= $status ?></small></em>
                                </h4>
                                <div class="text-muted text-nowrap" style="overflow:hidden;text-overflow:ellipsis ">
                                    <?= $vo["description"] ?>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info note_select" note="<?= $vo["id"] ?>"
                                    name="<?= $vo["name"] ?>" description="<?= $vo["description"] ?>"
                                    status="<?= $status ?>" scolor="<?= $color ?>">选择
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
    <div style="clear:both"></div>
<?php }
?>
<div class="select_line" style="<?= $line_box_status ?>">
    <?php
    if ($noteoff == "1") {
        $color = "";
        $status = "";
        if ($selected_note["count"] != 0) {
            $online = db("openvpn")->where(["last_ip" => $selected_note["ipport"], "online" => 1])->getnums();
            if ($online == 0) {
                $status = "空闲";
                $color = "text-primary";
            } else {
                $status = round($online / $selected_note["count"] * 100, 0);
                if ($status < 1) $status = 1;
                if ($status > 100) $status = 100;

                if ($status >= 1 && $status < 30) {
                    $color = "text-primary";
                } else if ($status >= 30 && $status < 60) {
                    $color = "text-success";
                } else if ($status >= 60 && $status < 80) {
                    $color = "text-warning";
                } else {
                    $color = "text-danger";
                }
                $status = "负荷:" . $status . "%";
            }
        }
        ?>

        <div class="card card-default card-md mb-4">
            <div class="card-body">
                <div class="page-title-block">
                    <div class="page-title-wrap  wrapper-bordered">
                        <div class="page-title d-flex justify-content-between">
                            <div class="page-title__left">
                                <a href="#" class="note_reselect"><i class="las la-arrow-left"></i></a>
                                <span class="title-text"><?= $selected_note["name"] ?></span> &nbsp;<em><small
                                            class="<?= $color ?>"><?= $status ?></small></em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4">
                    <div class="card-header">
                        <form action="?" method="GET" class="cityFenleiForm" style="width: 100%">
                            <input name="action" value="line" type="hidden">
                            <input name="app_key" value="<?php echo $_GET["app_key"] ?>" type="hidden">
                            <input name="username" value="<?php echo $_GET["username"] ?>" type="hidden">
                            <input name="password" value="<?php echo $_GET["password"] ?>" type="hidden">

                                <select id="countryOption" class="js-example-basic-single js-states form-control" name="i" onchange="submitForm()">
                                    <?php
                                    $i = 1;
                                    $p = "";
                                    $select_id = $line_grop[0]['id'];
                                    foreach ($line_grop as $vo) {
                                        if($vo["name"] == $isp){
                                            $p = 'selected';
                                            $select_id = $vo["id"];
                                        }
                                        echo '<option value="'.$vo["name"].'" '.$p.'>'.$vo["name"].'</option>';
                                        $i++;
                                        $p = "";
                                    }
                                    ?>
                                </select>
                        </form>
                    </div>
                    <div class="card-body">

                        <div id="slider" class="swipe">
                            <ul class="box01_list">
                                <li class="li_list">
                                    <!---->
                                    <div class="main">
                                        <ul class="list-group">
                                            <?php
                                            $line = db('line')->where(array('show' => '1', 'group' => $select_id))->order('id DESC')->select();
                                            if ($line) {
                                                foreach ($line as $vos) {
                                                    ?>
                                                    <li class="list-group-item">
                                                        <b><?php echo $vos['name'] ?></b>&nbsp;<span
                                                                class="atbd-tag tag-light "><?php echo $vos['type'] ?></span><br>
                                                        <p><?php echo $vos['label'] ?></p>
                                                        <button style="display: inline-block" type="button"
                                                                class="btn btn-primary btn-sm"
                                                                onclick="addLine('<?php echo $vos['id'] ?>')">安装
                                                        </button>
                                                        <button style="display: inline-block" type="button"
                                                                type="button"
                                                                class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#myModal"
                                                                onclick="feedback('<?php echo $vos['name'] ?>',<?php echo $vos['id'] ?>)">
                                                            反馈
                                                        </button>
                                                    </li>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <center>
                                                    <div style="color:#ccc;font-size:12px;">暂无地区线路</div>
                                                </center>
                                                <?php
                                            } ?>
                                        </ul>
                                        <div style="clear:both"></div>
                                    </div>
                                </li>
                                <!---->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">工单反馈</h4>
                </div>
                <div class="modal-body">
                    <?php
                    foreach ($config["Feedback"]["Field"] as $key => $vo) {
                        ?>
                        <div class="form-group">
                            <label for="name"><?= $key ?></label><br>
                            <?php
                            if (is_array($vo)) {
                                $i = 0;
                                foreach ($vo as $v) {
                                    $fix = $i == 0 ? "checked" : "";
                                    ?>

                                    <label for="name"><input type="radio" value="<?= $v ?>"
                                                             name="<?= base64_encode($key) ?>" <?= $fix ?>><?= $v ?>
                                    </label>&nbsp;
                                    <?php $i++;
                                }
                            } else {
                                echo '<input name="' . base64_encode($key) . '" value="' . $vo . '" class="form-control">';
                            } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary add" data-dismiss="modal">确认发布</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<!-- inject:js-->
<script src="../../assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery/jquery-ui.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/popper.js"></script>
<script src="../../assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/vendor_assets/js/accordion.js"></script>
<script src="../../assets/vendor_assets/js/autoComplete.js"></script>
<script src="../../assets/vendor_assets/js/Chart.min.js"></script>
<script src="../../assets/vendor_assets/js/charts.js"></script>
<script src="../../assets/vendor_assets/js/daterangepicker.js"></script>
<script src="../../assets/vendor_assets/js/drawer.js"></script>
<script src="../../assets/vendor_assets/js/dynamicBadge.js"></script>
<script src="../../assets/vendor_assets/js/dynamicCheckbox.js"></script>
<script src="../../assets/vendor_assets/js/feather.min.js"></script>
<script src="../../assets/vendor_assets/js/fullcalendar@5.2.0.js"></script>
<script src="../../assets/vendor_assets/js/google-chart.js"></script>
<script src="../../assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="../../assets/vendor_assets/js/jquery.countdown.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.filterizr.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.magnific-popup.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.mCustomScrollbar.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.peity.min.js"></script>
<script src="../../assets/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
<script src="../../assets/vendor_assets/js/leaflet.js"></script>
<script src="../../assets/vendor_assets/js/leaflet.markercluster.js"></script>
<script src="../../assets/vendor_assets/js/loader.js"></script>
<script src="../../assets/vendor_assets/js/message.js"></script>
<script src="../../assets/vendor_assets/js/moment.js"></script>
<script src="../../assets/vendor_assets/js/muuri.min.js"></script>
<script src="../../assets/vendor_assets/js/notification.js"></script>
<script src="../../assets/vendor_assets/js/popover.js"></script>
<script src="../../assets/vendor_assets/js/select2.full.min.js"></script>
<script src="../../assets/vendor_assets/js/slick.min.js"></script>
<script src="../../assets/vendor_assets/js/trumbowyg.min.js"></script>
<script src="../../assets/vendor_assets/js/wickedpicker.min.js"></script>
<script src="../../assets/theme_assets/js/drag-drop.js"></script>
<script src="../../assets/theme_assets/js/full-calendar.js"></script>
<script src="../../assets/theme_assets/js/googlemap-init.js"></script>
<script src="../../assets/theme_assets/js/icon-loader.js"></script>
<script src="../../assets/theme_assets/js/jvectormap-init.js"></script>
<script src="../../assets/theme_assets/js/leaflet-init.js"></script>
<script src="../../assets/theme_assets/js/main.js"></script>
<!-- endinject-->
<script type="text/javascript">
    function submitForm() {
        $(".cityFenleiForm").submit();
    }
    var select_line_id = 0;
    $(function () {
        $(".gitem").click(function () {
            var n = $(".gitem").index(this);
            $(".gitem a").removeClass("active").eq(n).addClass("active");
            $(".li_list").hide().eq(n).show();
        });
    });
    $(".add").click(function () {
        $.post("?act=feedback&username=<?php echo $_GET["username"]?>&password=<?php echo $_GET["password"]?>", {
            "line_id": select_line_id,
            <?php
            foreach ($config["Feedback"]["Field"] as $key => $vo) {
                if (is_array($vo)) {
                    $data[] = "\"" . base64_encode($key) . "\":$(\"[name='" . base64_encode($key) . "']:checked\").val()";
                } else {
                    $data[] = "\"" . base64_encode($key) . "\":$(\"[name='" . base64_encode($key) . "']\").val()";
                }
            }
            echo implode(",\n", $data);
            ?>

        }, function (data) {
            if (data.status == "success") {
                alert("反馈成功啦");
            } else if (data.status == "old") {
                alert("同一个线路15分钟只能反馈一次哦");
            } else {
                alert("新增失败");
            }
        }, "JSON");

    });

    var name_tmp = "";

    function addLine(id) {
        if (window.fasInterface) {
            $.post(
                'getLine.php',
                {
                    'id': id,
                    'username': '<?php echo $_GET["username"] ?>',
                    'password': '<?php echo $_GET["password"] ?>'
                }, function (data) {
                    if (data.status == 'success') {
                        //window.myObj.writeFile('test.ovpn','<?php echo base64_encode(file_get_contents('1.ovpn'))?>','download');
                        name_tmp = data.name;

                        window.fasInterface.installPro(data.name + '.ovpn', data.content);
                    } else {
                        alert(data.msg);
                    }
                }, "JSON");
        } else {
            alert("请在app中登录");
        }
    }

    function feedback(name, id) {
        $("#myModalLabel").html(name);
        select_line_id = id;
    }


    $(".note_select").click(function () {
        var id = parseInt($(this).attr("note"));
        var name = $(this).attr("name");
        var description = $(this).attr("description");
        var status = $(this).attr("status");
        var color = $(this).attr("scolor");
        $.post(
            'getLine.php?action=select_note', {
                'select_id': id,
                'username': '<?=$_GET["username"] ?>',
                'password': '<?=$_GET["password"] ?>'
            }, function (data) {
                if (data.status == 'success') {
                    $(".selected-line h4 span").html(name);
                    $(".selected-line p").html(description);
                    $(".selected-line small").html(status);
                    $(".selected-line small").attr({"class": color});
                    $(".select_note").slideUp("fast");
                    $(".select_line").slideDown("fast");
                } else {
                    alert(data.msg);
                }
            }, "JSON");
    });

    $(".note_reselect").click(function () {
        $(".select_note").slideDown("fast");
        $(".select_line").slideUp("fast");
    });
</script>
