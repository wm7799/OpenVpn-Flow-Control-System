<?php
$u = $_GET['username'];
$p = $_GET['password'];
$db = db('openvpn');
$userinfo = $db->where(array("iuser" => $u, "pass" => $p))->find();
if (!$userinfo) {
    die(tip_status('error', '请重新注册账号', 'top-middle', '1000', 'window.myObj.colsePage();'));
}
if (@$_GET["xiugai"] == "mima") {
    $db = db("openvpn");
    if ($userinfo["pass"] == $_POST["pass"]) {
        if ($_POST["passnew"] == $_POST["passnew2"]) {
            $db->where(array("id" => $userinfo["id"]))->update(["pass" => trim($_POST["passnew"])]);
            tip_status('success', '修改成功', 'top-middle', '1000', 'window.myObj.colsePage();');
        } else {
            tip_status('error', '密码不一致', 'top-middle', '1000', 'history.go(-1);');
        }
    } else {
        tip_status('error', '修改失败', 'top-middle', '1000', 'history.go(-1);');
    }
}
?>
<div class="container-fluid">
<!--    <div class="row mt-3">-->
<!--        <div class="col-lg-12">-->
<!--            <button class="btn btn-secondary btn-lg btn-create-event btn-block" data-toggle="tanc" data-target="#tanc">-->
<!--                <span data-feather="plus"></span>修改密码</button>-->
<!--        </div>-->
<!--    </div>-->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-header">
                    <h6>账号详细信息</h6>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="t_selling-today2" role="tabpanel"
                             aria-labelledby="t_selling-today2-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table table--default">
                                        <thead>
                                        <tr>
                                            <th>名称</th>
                                            <th>状态</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>用户账号</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <span class="selling-badge order-bg-opacity-primary color-primary"><?= $userinfo['iuser'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>用户状态</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <?php echo $userinfo["i"] == 1 ? "<span class=\"selling-badge order-bg-opacity-success color-success\">启用</span>" : "<span class=\"selling-badge order-bg-opacity-danger color-danger\">禁用</span>"; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>套餐流量</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <span class="selling-badge order-bg-opacity-primary color-primary"><?php echo round(($userinfo['maxll']) / 1024 / 1024 / 1024, 2); ?> GB</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>今日已用</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                        <span class="selling-badge order-bg-opacity-info color-info"><?php
                                            $list = db('top')->where(array('username' => $userinfo['iuser'], 'time' => date("Y-m-d")))->find()['data'];
                                            echo round(($list) / 1024 / 1024 / 1024, 2);
                                            ?> GB</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>已用流量</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                        <span class="selling-badge order-bg-opacity-info color-info"><?php echo round(($userinfo['irecv']) / 1024 / 1024 / 1024, 2);
                                            ?> GB</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>剩余流量</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <span class="selling-badge order-bg-opacity-info color-info"><?php echo round(($userinfo['maxll'] - $userinfo['isent'] - $userinfo['irecv']) / 1024 / 1024 / 1024, 2); ?> GB</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>到期时间</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <span class="selling-badge order-bg-opacity-info color-info"><?php echo date("Y年m月d日 h:i:s", $userinfo["endtime"]); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>在线状态</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <?php echo $userinfo["online"] == 1 ? "<span class=\"selling-badge order-bg-opacity-success color-success\">在线</span>" : "<span class=\"selling-badge order-bg-opacity-dark color-dark\">离线</span>"; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>使用节点</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                        <span class="selling-badge order-bg-opacity-info color-info"><?php $note = db("app_note")->where(array("id" => $userinfo["note_id"]))->find()['name'];
                                            if (!$note) {
                                                echo '未选择';
                                            } else {
                                                echo $note;
                                            } ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="selling-product-img d-flex align-items-center">
                                                    <span>使用协议</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <span class="selling-badge order-bg-opacity-info color-info"><?php echo $userinfo["proto"] == "" ? '未连接' : '' . $userinfo["proto"] . '' ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tanc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<h5 class="modal-title mt-0" id="content2"></h5>-->
                <h5 class="modal-title mt-0">修改密码</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-material" method="POST"
                  action="<?php echo '?act=user_info&app_key=' . $_GET['app_key'] . '&username=' . $_GET['username'] . '&password=' . $_GET['password'] . '&xiugai=mima'; ?>"
            <!-- Input -->
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-btn input-group-prepend"><label
                                            class="btn btn-primary bootstrap-touchspin-down">旧密码</label></span>
                                <input type="text" class="form-control" placeholder="旧密码" name="pass" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-btn input-group-prepend"><label
                                            class="btn btn-primary bootstrap-touchspin-down">新密码</label></span>
                                <input type="text" class="form-control" placeholder="新密码" name="passnew" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-btn input-group-prepend"><label
                                            class="btn btn-primary bootstrap-touchspin-down">确认新密码</label></span>
                                <input type="text" class="form-control" placeholder="确认新密码" name="passnew2" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-xs">确定修改</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal 