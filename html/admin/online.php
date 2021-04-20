<?php
if ($_GET['act'] == 'save') {
    include('system.php');
    //执行数据保存
    $status1 = setSystemData("TCP_PATH", $_POST["tcp"]);
    $status2 = setSystemData("UDP_PATH", $_POST["udp"]);
    die(json_encode(array(
        "status" => "success"
    )));
} elseif ($_GET['act'] == 'data') {

    include('system.php');

    $tcp_file[0]["file"] = "openvpn_api/user-status-tcp.txt";
    $tcp_file[0]["telnet"] = "7075";

    $udp_file[0]["file"] = "openvpn_api/user-status-udp.txt";
    $udp_file[0]["telnet"] = "7079";

    $status_file = $_GET["t"] == "udp" ? $udp_file : $tcp_file;

    $html = '
  <table class="table table--default traffic-table">
                                    <thead>
                                    <tr>
                                        <th>用户名</th>
                                        <th>上传</th>
                                        <th>下载</th>
                                        <th>剩余流量(实时)</th>
                                        <th>IP</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
    foreach ($status_file as $vo) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $rs = db("auth_fwq")->where(array("id" => $id))->find();
            if (!$rs) {
                echo "此服务器不存在";
            } else {
                $file = 'http://' . $rs['ipport'] . '/' . $vo["file"];
            }
        } else {
            $file = '../' . $vo["file"];
            if (!is_file($file)) {
                exit;
            }
        }

        $context = stream_context_create(array(
            'http' => array(
                'timeout' => 5 //超时时间，单位为秒
            )
        ));
        if ($str = file_get_contents($file, false, $context)) {
            $num = (substr_count($str, date('Y')) - 1) / 2;
            $num = (int)$num;
            $nums += $num;
            $lines = explode("\n", $str);

            for ($i = 3; $i < $num + 3; $i++) {
                $line = $lines[$i];
                $arr = explode(",", $line);
                $recv = round($arr[2] / 1024) / 1000;
                $sent = round($arr[3] / 1024) / 1000;
                //$row = $DB->get_row("select * from `openvpn` where `iuser`='".$arr[0]."' limit 1");
                $row = db(_openvpn_)->where(array("iuser" => $arr[0]))->find();
                $sy = ($row['maxll'] - $row['isent'] - $row['irecv'] - $arr[2] - $arr[3]);
                $value = round($sy / 1024 / 1024, 3);
                $pre = $sy < 1024 * 1024 * 100 ? '<span class="label label-warning">流量不足</span' : '';
                $pre = $sy < 0 ? '<span class="label label-danger">流量超额</span' : $pre;

                $username = $arr[0] == "UNDEF" ? "正在登陆...(UNDEF)" : $arr[0];

                $html .= "<tr class=\"line-id-{$arr[0]}\">";
                $html .= "<td>" . $username . "</td>";
                $html .= "<td>" . $recv . "MB</td>";
                $html .= "<td>" . $sent . "MB</td>";
                $html .= "<td>" . round($value, 3) . "MB&nbsp;" . $pre . "</td>";
                $html .= "<td>" . $arr[1] . "</td>";
                $html .= '<td><a class="btn btn-xs btn-success" href="./user_list.php?a=qset&user=' . $arr[0] . '">查看用户</a>&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="if(!confirm(\'只对本机有效，是否继续\')){return false;}else{outline(\'' . $arr[0] . '\',' . $vo["telnet"] . ')}">强制下线</button></td>';
                $html .= "</tr>";
            }
        }
    }
    $html .= "
	</tbody>
</thead>
</table>";
    die(json_encode(array('status' => "success", 'nums' => $nums, "html" => $html)));

} else {
    $title = '当前在线用户';
    include('head.php');
    include('nav.php');
    ?>
    <div class="contents">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="breadcrumb-main user-member justify-content-sm-between ">
                        <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                            <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                                <span class="sub-title ml-sm-25 pl-sm-25">十秒钟自动刷新一次数据</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-30">

                    <div class="card border-0">
                        <div class="card-header">
                            <h6><block class="oln"></block> 人在线</h6>
                            <div class="card-extra">
                                <ul class="card-tab-links mr-3 nav-tabs nav">
                                    <li>
                                        <a <?php echo $_GET["t"] == "udp" ? "" : "class='active'" ?> href="javascript:void(0)"
                                           onclick="window.location.href='online.php?<?php echo $_GET['id'] == "" ? "" : "id=" . $_GET['id']; ?><?php echo $_GET['t'] == "udp" ? "&t=tcp" : "&t=udp" ?>'"
                                           data-toggle="tab" id="t_channel-today-tab" role="tab"
                                           area-controls="t_channel-table"
                                           aria-selected="<?php echo $_GET["t"] == "udp" ? "false" : "true" ?>">TCP</a>
                                    </li>
                                    <li>
                                        <a <?php echo $_GET["t"] == "udp" ? "class='active'" : "" ?> href="javascript:void(0)"
                                           onclick="window.location.href='online.php?<?php echo $_GET['id'] == "" ? "" : "id=" . $_GET['id']; ?><?php echo $_GET['t'] == "udp" ? "&t=tcp" : "&t=udp" ?>'"
                                           data-toggle="tab" id="t_channel-week-tab" role="tab"
                                           area-controls="t_channel-table"
                                           aria-selected="<?php echo $_GET["t"] == "udp" ? "true" : "false" ?>">UDP</a>
                                    </li>
                                </ul>
                                <div class="dropdown dropleft">
                                    <a href="#" role="button" id="traffic" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <span data-feather="more-horizontal"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="traffic">
                                        <?php
                                        if ($_GET["id"] == "") {
                                            echo '<a class="dropdown-item" href="?' . $t_str . '" style="display: flex;align-items: center;justify-content: space-between;">当前服务器<span class="badge-dot dot-info"></span></a>';
                                        } else {
                                            echo '<a class="dropdown-item" href="?' . $t_str . '" >当前服务器</a>';
                                        }
                                        //$rs=$DB->query("SELECT * FROM `auth_fwq`  order by id desc limit 20");
                                        $rs = db("auth_fwq")->order("id DESC")->select();
                                        foreach ($rs as $res) {
                                            $id_str = $res['id'] == "" ? "" : "id=" . $res['id'];
                                            $t_str = $_GET['t'] == "" ? "" : "&t=" . $_GET['t'];
                                            if ($res['id'] == $_GET["id"]) {
                                                echo '<a class="dropdown-item" href="?' . $id_str . $t_str . '" style="display: flex;align-items: center;justify-content: space-between;"><span class="badge-dot dot-info"></span>' . $res['name'] . '</a>';
                                            } else {
                                                echo '<a class="dropdown-item" href="?' . $id_str . $t_str . '">' . $res['name'] . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="t_channel-today" role="tabpanel"
                                     aria-labelledby="t_channel-today-tab">
                                    <div class="table-responsive">
                                        <div style="text-align: center;">
                                            <b>请稍等...加载中...</b>
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

    <?php
    include("footer.php");
} ?>
<script>
    function outline(id, port) {
        $.post('kangml_service.php', {
            "cmd": "/root/res/sha " + id + " " + port
        }, function (data) {
            if (data.status == "success") {
                alert("执行完毕");
                location.reload();
            } else {
                alert(data.msg);
            }
        }, "JSON");
        $('.line-id-' + id).slideUp();
    }
    var fun = function () {
        $.post('?act=data&<?php echo $_GET['id'] == "" ? "" : "id=" . $_GET['id']; ?><?php echo $_GET['t'] == "" ? "" : "&t=" . $_GET['t']; ?>', {}, function (data) {
            if (data.status == "success") {
                $('.table-responsive').html(data.html);
                $('.oln').text(data.nums);
            } else {
                $('.table-responsive').html(data.mes);
            }
        }, "JSON");
    }
    $(function () {
        fun();
        setInterval(fun, 10000);
    });
</script>
