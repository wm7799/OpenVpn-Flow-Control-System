<?php
$title = '修改账号';
$user = trim($_GET['user']);
if (!$user || !$row = db(_openvpn_)->where(array(_iuser_ => $user))->find()) {
    exit("账号不存在!");
}
if ($_POST['type'] == "update") {
    $pass = trim($_POST['pass']);
    $maxll = trim($_POST['maxll']) * 1024 * 1024;
    $state = trim($_POST['state']);
    $endtime = $row["endtime"] + ((int)$_POST['enddate'] * 24 * 60 * 60);
    if (db(_openvpn_)->where(array(_iuser_ => $user))->update(array(
        _ipass_ => $pass,
        _maxll_ => $maxll,
        _i_ => $state,
        _endtime_ => $endtime
    ))) {
        tip_success("修改成功", 'user_list.php?a=qset&user=' . $user);
    } else {
        tip_failed('修改失败！', 'user_list.php?a=qset&user=' . $user);
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
                    <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade  show active" id="v-pills-home">
                                <div class="row justify-content-center">
                                    <div class="col-xl-4 col-sm-6 col-10">
                                        <div class="mt-40 mb-50">
                                            <div class="edit-profile__body">
                                                <form method="POST" action="./user_list.php?a=qset&user=<?= $user ?>">
                                                    <input type="hidden" name="type" value="update"/>
                                                    <div class="form-group mb-25">
                                                        <label for="name2">密码(英文和数字)</label>
                                                        <input type="text" class="form-control" id="name2" name="pass"
                                                               value="<?= $row['pass'] ?>">
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber5">总流量</label>
                                                        <input type="text" class="form-control" id="phoneNumber5"
                                                               name="maxll"
                                                               value="<?= round($row['maxll'] / 1024 / 1024) ?>">
                                                    </div>
                                                    <div class="form-group mb-25 form-group-calender">
                                                        <label for="datepicker">有效期</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="phoneNumber"
                                                                   name="days"
                                                                   value="<?= date("Y年m月d日 H点i分s秒", $row["endtime"]) ?>"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-25">
                                                        <label for="name1">延期(正数为添加 负数为减少 单位：天)</label>
                                                        <input type="text" class="form-control" id="name1"
                                                               name="enddate" value="0">
                                                    </div>
                                                    <div class="form-group mb-25 status-radio">
                                                        <label class="mb-15" for="phoneNumber2">状态</label>
                                                        <div class="d-flex">
                                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                                <div class="radio-theme-default custom-radio ">
                                                                    <input class="radio" type="radio" name="state"
                                                                           value="1"
                                                                           id="radio-hl1" <?= $row['i'] ? "checked" : '' ?>>
                                                                    <label for="radio-hl1">
                                                                        <span class="radio-text">启用</span>
                                                                    </label>
                                                                </div>
                                                                <div class="radio-theme-default custom-radio ">
                                                                    <input class="radio" type="radio" name="state"
                                                                           value="0" id="radio-hl2" <?= $row['i'] ? "" : 'checked' ?>>
                                                                    <label for="radio-hl2">
                                                                        <span class="radio-text">禁止</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="button-group d-flex pt-25 justify-content-end">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-block btn-default btn-squared text-capitalize radius-md shadow2">
                                                            修改
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
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="box" style="margin-top:10px;">
                <div class="main">
                    <div id="line">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        var json = [
            <?php
            $temp_date = date("Y-m-d 0:0:0", time());
            $now = strtotime($temp_date);
            for ($i = 0; $i <= 30; $i++) {
                $t = $now - ((30 - $i) * 24 * 60 * 60);
                $p = date("Y-m-d", $t);

                //$res = $DB->get_row("select * from `top` where `username`='".$user."' AND time='".$p."' limit 1");
                $res = db("top")->where(array("username" => $user, "time" => $p))->find();

                if ($res) {
                    $value = $res['data'] / 1024 / 1024;
                    $data[] = '{ "name": "' . date("d", $t) . '日", "value": "' . round($value, 3) . '" }';
                } else {
                    $data[] = '{ "name": "' . date("d", $t) . '日", "value": "0" }';
                }

            }
            echo implode(",", $data);
            ?>
        ];
        var data = [
            {"name": "上传流量(MB)", "value": "<?php echo(round($row['isent'] / 1024 / 1024, 3));?>"},
            {"name": "下载流量(MB)", "value": "<?php echo(round($row['irecv'] / 1024 / 1024, 3));?>"},
            {
                "name": "剩余流量(MB)",
                "value": "<?php echo(round(($row['maxll'] - $row['isent'] - $row['irecv']) / 1024 / 1024, 3));?>"
            }
        ];
        $(document).ready(function (e) {
            //GetSerialChart();
            MakeChart(data);
        });
        //折线图
        AmCharts.ready(function () {
            var chart = new AmCharts.AmSerialChart();
            chart.dataProvider = json;
            chart.categoryField = "name";
            chart.angle = 30;
            chart.depth3D = 20;
            //标题
            chart.addTitle("30天流量趋势", 15);
            var graph = new AmCharts.AmGraph();
            chart.addGraph(graph);
            graph.valueField = "value";
            //背景颜色透明度
            graph.fillAlphas = 0.3;
            //类型
            graph.type = "line";
            //圆角
            graph.bullet = "round";
            //线颜色
            graph.lineColor = "#8e3e1f";
            //提示信息
            graph.balloonText = "[[name]]: [[value]]";
            var categoryAxis = chart.categoryAxis;
            categoryAxis.autoGridCount = false;
            categoryAxis.gridCount = json.length;
            categoryAxis.gridPosition = "start";
            chart.write("line");
        });
        //饼图
        //根据json数据生成饼状图，并将饼状图显示到div中
        function MakeChart(value) {
            chartData = eval(value);
            //饼状图
            chart = new AmCharts.AmPieChart();
            chart.dataProvider = chartData;
            //标题数据
            chart.titleField = "name";
            //值数据
            chart.valueField = "value";
            //边框线颜色
            chart.outlineColor = "#fff";
            //边框线的透明度
            chart.outlineAlpha = .8;
            //边框线的狂宽度
            chart.outlineThickness = 1;
            chart.depth3D = 20;
            chart.angle = 30;
            chart.write("pie");
        }
    </script>
    <script src="./js/datepicker/bootstrap-datepicker.js"></script>
<?php } ?>
