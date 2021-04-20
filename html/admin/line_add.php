<?php
$title = '添加线路';
include('head.php');
include('nav.php');
if ($_GET['act'] == 'update') {
    $db = db('line');
    if ($db->where(array('id' => $_GET['id']))->update(array(
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'label' => $_POST['label'],
        'content' => $_POST['content'],
        'group' => $_POST['group'],
        'show' => $_POST['show'] == '1' ? '1' : '0'
    ))) {
        tip_success("修改线路【" . $_POST['name'] . "】成功！", 'line_add.php?act=mod&id=' . $_GET['id']);
    } else {
        tip_failed("十分抱歉修改失败", 'line_add.php?act=mod&id=' . $_GET['id']);
    }
} elseif ($_GET['act'] == 'add') {
    $db = db('line');
    if ($_POST["kuai"] == "1") {
        $line[] = '# 本文件由康师傅流控自动生成：kangml.com';
        $line[] = '# 本ovpn配置仅适用于康师傅流控系统，修改代理IP即可登陆到您的服务器。';
        $line[] = '# 其他流控注意更换证书秘钥。';
        $line[] = 'client';
        $line[] = 'proto ' . $_POST['k_xieyi'];
        $line[] = 'dev tun';
        $line[] = $_POST['k_content'];
        $line[] = 'auth-user-pass';
        $line[] = 'reneg-sec 0';
        $line[] = 'keepalive 20 60';
        $line[] = 'redirect-gateway';
        $line[] = 'ns-cert-type server';
        $line[] = 'comp-lzo';
        $line[] = 'verb 3';
        $line[] = 'resolv-retry infinite';
        $line[] = 'persist-key';
        $line[] = 'persist-tun';
        $line[] = 'nobind';
        $line[] = '## 证书';
        $line[] = '<ca>';
        $line[] = '[证书]';
        $line[] = '</ca>';
        $line[] = 'key-direction 1';
        $line[] = '<tls-auth>';
        $line[] = '[证书]';
        $line[] = '</tls-auth>';
        $_POST['content'] = implode("\n", $line);
    }
    if ($db->insert(array(
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'label' => $_POST['label'],
        'content' => $_POST['content'],
        'group' => $_POST['group'],
        'time' => time(),
        'show' => $_POST['show'] == '1' ? '1' : '0'
    ))) {
        tip_success("新增线路【" . $_POST['name'] . "】成功！", 'line_add.php');
    } else {
        tip_failed("十分抱歉修改失败", 'line_add.php');
    }
} else {
    $action = '?act=add';
    if ($_GET['act'] == 'mod') {
        $info = db('line')->where(array('id' => $_GET['id']))->find();
        $action = "?act=update&id=" . $_GET['id'];
    }

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
                            <div class="Vertical-form">
                                <form method="POST" action="<?php echo $action ?>">
                                    <div class="form-group">
                                        <label for="formGroupExampleInput" class="color-dark fs-14 fw-500 align-center">线路名称
                                            <span style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput" name="name" placeholder="线路名称"
                                               value="<?php echo $info['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput2"
                                               class="color-dark fs-14 fw-500 align-center">线路类型 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput2" name="type" placeholder="线路类型"
                                               value="<?php echo $info['type'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput3"
                                               class="color-dark fs-14 fw-500 align-center">线路描述 <span
                                                    style="color:red">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="formGroupExampleInput3" name="label" placeholder="显示标签"
                                               value="<?php echo $info['label'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="countryOption">
                                            <label for="countryOption" class="color-dark fs-14 fw-500 align-center">
                                                分组选择 <span style="color:red">*</span>
                                            </label>
                                            <select class="js-example-basic-single js-states form-control"
                                                    id="countryOption" name="group">
                                                <?php
                                                $list = db('line_grop')->order('id ASC')->select();
                                                foreach ($list as $vo) {
                                                    $selected = "";
                                                    if ((int)$info['group'] == (int)$vo['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="' . $vo['id'] . '" ' . $selected . '>' . $vo['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <script src="assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
                                    <script>
                                        var k = 0;
                                        function kuaijie() {
                                            $(".box1").toggle();
                                            $(".box2").toggle();
                                            if (k == 0) {
                                                k = 1
                                            } else {
                                                k = 0
                                            }
                                        }
                                        function autoGs() {
                                            var content = $("[name=content]").val();
                                            content = content.replace("\n\r", "\n");
                                            content = content.replace("\n", "\n\r");
                                            $("[name=content]").val(content);
                                        }
                                    </script>

                                    <div class="form-group">
                                        <?php
                                        if ($_GET['act'] != 'mod') {
                                            ?>
                                            <div class="checkbox-theme-default custom-checkbox ">
                                                <input class="checkbox" type="checkbox" id="check-un1" name="kuai"
                                                       value="1" onclick="kuaijie()">
                                                <label for="check-un1">
                                                                <span class="checkbox-text">
                                                                    快捷添加（勾选后只需要写伪装与指向代码即可）
                                                                </span>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <div class="checkbox-theme-default custom-checkbox ">
                                            <input class="checkbox" type="checkbox" id="check-un1" name="show"
                                                   value="1" <?php if ($info["show"] !== 0) { ?> checked <?php } ?>>
                                            <label for="check-un1">
                                                                <span class="checkbox-text">
                                                                    是否启用
                                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="color-dark fs-14 fw-500 align-center">线路内容(<span
                                                    style="color:red">请直接添加线路的全部内容 证书会自动替换</span>)</label>
                                        <button type="button" class="btn btn-light btn-default btn-squared btn-shadow-white mb-3"
                                                onclick="autoGs()"><span data-feather="layers"></span>
                                            自动换行
                                        </button>
                                        <p class="fs-14 align-center">标签：[domain] 会替换成您的IP或者域名 [time]
                                            当前的UNIX时间戳(秒) </p>
                                        <textarea class="form-control box1" rows="10" name="content"
                                                  placeholder="如果证书管理开启，那么线路的证书会被自动替换。"><?php echo $info['content'] ?></textarea>
                                        <div class="box2"
                                             style="display:none;background:#f8f8f8;padding:20px 10px;">
                                            <div class="form-group">
                                                <label for="lastname"
                                                       class="color-dark fs-14 fw-500 align-center">协议</label>
                                                <input type="text"
                                                       class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                                       name="k_xieyi"
                                                       placeholder="tcp或udp" value="tcp">
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname"
                                                       class="color-dark fs-14 fw-500 align-center">DNS</label>
                                                <input type="text"
                                                       class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                                       name="k_dns"
                                                       placeholder="114.114.114.114 114.114.115.115"
                                                       value="114.114.114.114 114.114.115.115">
                                            </div>
                                            <textarea class="form-control" rows="10" name="k_content"
                                                      placeholder="代码"><?php echo $info['content'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="layout-button mt-25">
                                        <button type="submit"
                                                class="btn btn-primary btn-default btn-squared px-30 btn-block">
                                            提交数据
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ends: .card -->
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('footer.php');
?>