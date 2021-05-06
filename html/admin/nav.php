<?php
function echoActive($str){
    $url=$_SERVER['REQUEST_URI'];
    echo strpos($url,$str) == true ? 'active' : '';
}
function echoActiveMore(...$args){
    $url=$_SERVER['REQUEST_URI'];
    foreach ($args as $value){
        echo strpos($url,$value) ? 'active' : '';
    }
}
function echoOpenMore(...$args){
    $url=$_SERVER['REQUEST_URI'];
    foreach ($args as $value){
        echo strpos($url,$value) ? 'open' : '';
    }
}
$ver = file_get_contents("./version.txt");
$changelogStr = '未知';
$notNew = false;
if ($ver){
    $ver_rep = file_get_contents("http://a.pykky.com/version.php?ver=".$ver);
    if ($ver_rep){
        $ver_arr = explode(" ",$ver_rep);
        if ($ver_arr[1] == 'notNew'){
            $changelogStr = $ver_arr[0].' 待更新';
            $notNew = true;
        }else{
            $changelogStr = $ver_arr[0];
        }
    }
}
?>
<body class="layout-light side-menu">
    <div class="mobile-search"></div>
    <div class="mobile-author-actions"></div>
    <header class="header-top">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <a href="" class="sidebar-toggle">
                    <img class="svg" src="../img/svg/bars.svg" alt="img"></a>
                <a class="navbar-brand" href="#"><img class="svg dark" src="../img/logo_Dark.png" alt=""><img class="light"
                                                                                                              src="../img/Logo_white.png" alt=""></a>
            </div>
            <!-- ends: navbar-left -->

            <div class="navbar-right">
                <ul class="navbar-right__menu">
                    <li class="nav-search d-none">
                        <a href="#" class="search-toggle">
                            <i class="la la-search"></i>
                            <i class="la la-times"></i>
                        </a>
                        <form action="/" class="search-form-topMenu">
                            <span class="search-icon" data-feather="search"></span>
                            <input class="form-control mr-sm-2 box-shadow-none" type="search" placeholder="Se11arch..."
                                aria-label="Search">
                        </form>
                    </li>
                    <?php if ($notNew){?>
                    <li class="nav-notification">
                        <div class="dropdown-custom">
                            <a href="javascript:alert('有新的更新啦！请到官网使用最新脚本进行更新。');" class="nav-item-toggle">
                                <span data-feather="upload"></span></a>
                        </div>
                    </li>
                    <li class="nav-notification">
                        <?php }else{
                            echo '<li>';
                        }
                        ?>
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle">
                                <span data-feather="bell"></span></a>
                            <div class="dropdown-wrapper">
                                <h2 class="dropdown-wrapper__title">消息 <span
                                        class="badge-circle badge-warning ml-1 msg-num">3</span></h2>
                                <ul class="msg-ul">
<!--                                    <li class="nav-notification__single nav-notification__single d-flex flex-wrap">-->
<!--                                        <div class="nav-notification__type nav-notification__type--info">-->
<!--                                            <span data-feather="at-sign"></span>-->
<!--                                        </div>-->
<!--                                        <div class="nav-notification__details">-->
<!--                                            <p>-->
<!--                                                <a href="" class="subject stretched-link text-truncate"-->
<!--                                                    style="max-width: 180px;">James</a>-->
<!--                                                <span>sent you a message</span>-->
<!--                                            </p>-->
<!--                                            <p>-->
<!--                                                <span class="time-posted">5 hours ago</span>-->
<!--                                            </p>-->
<!--                                        </div>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- ends: .nav-notification -->
<!--                    <li class="nav-settings">-->
<!--                        <div class="dropdown-custom">-->
<!--                            <a href="javascript:;" class="nav-item-toggle">-->
<!--                                <span data-feather="settings"></span></a>-->
<!--                            <div class="dropdown-wrapper dropdown-wrapper--large">-->
<!--                                <ul class="list-settings">-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/mail.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">All Features</a>-->
<!--                                            </h6>-->
<!--                                            <p>Introducing Increment subscriptions </p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/color-palette.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">Themes</a>-->
<!--                                            </h6>-->
<!--                                            <p>Third party themes that are compatible</p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/home.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">Payments</a>-->
<!--                                            </h6>-->
<!--                                            <p>We handle billions of dollars</p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/video-camera.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">Design Mockups</a>-->
<!--                                            </h6>-->
<!--                                            <p>Share planning visuals with clients</p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/document.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">Content Planner</a>-->
<!--                                            </h6>-->
<!--                                            <p>Centralize content gethering and editing</p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="d-flex">-->
<!--                                        <div class="mr-3"><img src="img/microphone.png" alt=""></div>-->
<!--                                        <div class="flex-grow-1">-->
<!--                                            <h6>-->
<!--                                                <a href="" class="stretched-link">Diagram Maker</a>-->
<!--                                            </h6>-->
<!--                                            <p>Plan user flows & test scenarios</p>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </li>-->
                    <!-- ends: .nav-settings -->
                    <li class="nav-support">
                        <div class="dropdown-custom">
                            <a href="help.php" class="nav-item-toggle">
                                <span data-feather="help-circle"></span></a>
                        </div>
                    </li>
                    <!-- ends: .nav-support -->
                    <li class="nav-author">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle"><img src="../img/author-nav.jpg" alt=""
                                                                                class="rounded-circle"></a>
                            <div class="dropdown-wrapper">
                                <div class="nav-author__info">
                                    <div class="author-img">
                                        <img src="../img/author-nav.jpg" alt="" class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6>欢迎您</h6>
                                        <span>后台管理员</span>
                                    </div>
                                </div>
                                <div class="nav-author__options">
                                    <ul>
<!--                                        <li>-->
<!--                                            <a href="">-->
<!--                                                <span data-feather="user"></span> Profile</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="">-->
<!--                                                <span data-feather="settings"></span> Settings</a>-->
<!--                                        </li>-->
                                        <li>
                                            <a href="user.php">
                                                <span data-feather="key"></span> 修改密码</a>
                                        </li>
<!--                                        <li>-->
<!--                                            <a href="">-->
<!--                                                <span data-feather="users"></span> Activity</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="">-->
<!--                                                <span data-feather="bell"></span> Help</a>-->
<!--                                        </li>-->
                                    </ul>
                                    <a href="login.php?act=logout" class="nav-author__signout">
                                        <span data-feather="log-out"></span> 登出</a>
                                </div>
                            </div>
                            <!-- ends: .dropdown-wrapper -->
                        </div>
                    </li>
                    <!-- ends: .nav-author -->
                </ul>
                <!-- ends: .navbar-right__menu -->
                <div class="navbar-right__mobileAction d-md-none">
                    <a href="#" class="btn-author-action">
                        <span data-feather="more-vertical"></span></a>
                </div>
            </div>
            <!-- ends: .navbar-right -->
        </nav>
    </header>
	<main class="main-content">

        <aside class="sidebar">
            <div class="sidebar__menu-group">
                <ul class="sidebar_nav">
                    <li class="menu-title">
                        <span>欢迎使用</span>
                    </li>
                    <li>
                        <a href="admin.php" class="<?php echoActive('admin.php');?>">
                            <span data-feather="home" class="nav-icon"></span>
                            <span class="menu-text">仪表盘</span>
                        </a>
                    </li>
                    <li>
                        <a href="changelog.php" class="<?php echoActive('changelog.php');?>">
                            <span data-feather="activity" class="nav-icon"></span>
                            <span class="menu-text">更新记录</span>
                            <span class="badge badge-primary menuItem"><?=$changelogStr ?></span>
                        </a>
                    </li>
                    <li class="menu-title m-top-30">
                        <span>功能区</span>
                    </li>
                    <li class="has-child <?php echoOpenMore("user_add.php","user_list.php","user_his.php","online.php","user_setting.php");?>">
                        <a href="#" class="<?php echoActiveMore("user_add.php","user_list.php","user_his.php","online.php","user_setting.php");?>">
                            <span data-feather="user" class="nav-icon"></span>
                            <span class="menu-text">用户</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a class="<?php echoActive('user_add.php');?>" href="user_add.php">生成用户</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('user_list.php');?>" href="user_list.php">用户列表</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('user_his.php');?>" href="user_his.php">上次生成</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('online.php');?>" href="online.php">在线用户</a>
                            </li>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('user_setting.php');?><!--" href="user_setting.php">用户配置</a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("dl_add.php","dl_list.php","type_add.php","type_list.php","dl_tx.php");?>">
                        <a href="#" class="<?php echoActiveMore("dl_add.php","dl_list.php","type_add.php","type_list.php","dl_tx.php");?>">
                            <span data-feather="user-check" class="nav-icon"></span>
                            <span class="menu-text">代理</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a href="dl_add.php" class="<?php echoActive('dl_add.php');?>">添加代理</a>
                            </li>
                            <li>
                                <a href="dl_list.php" class="<?php echoActive('dl_list.php');?>">代理列表</a>
                            </li>
                            <li>
                                <a href="type_add.php" class="<?php echoActive('type_add.php');?>">新增等级</a>
                            </li>
                            <li>
                                <a href="type_list.php" class="<?php echoActive('type_list.php');?>">等级列表</a>
                            </li>
<!--                            <li>-->
<!--                                <a href="dl_tx.html" class="--><?php //echoActive('dl_tx.php');?><!--">代理提现审核</a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("add_tc.php","list_tc.php","km_list.php","km_his.php","pay_order.php","pay.php");?>">
                        <a href="#" class="<?php echoActiveMore("add_tc.php","list_tc.php","km_list.php","km_his.php","pay_order.php","pay.php");?>">
                            <span data-feather="shopping-cart" class="nav-icon"></span>
                            <span class="menu-text">销售</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a href="add_tc.php" class="<?php echoActive('add_tc.php');?>">添加套餐</a>
                            </li>
                            <li>
                                <a href="list_tc.php" class="<?php echoActive('list_tc.php');?>">套餐管理</a>
                            </li>
                            <li>
                                <a href="km_list.php" class="<?php echoActive('km_list.php');?>">卡密管理</a>
                            </li>
                            <li>
                                <a href="km_his.php" class="<?php echoActive('km_his.php');?>">上次生成卡密</a>
                            </li>
                            <li>
                                <a href="pay_order.php" class="<?php echoActive('pay_order.php');?>">支付订单记录</a>
                            </li>
                            <li>
                                <a href="pay.php" class="<?php echoActive('pay.php');?>">支付接口配置</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("line_add.php","line_list.php","cat_add.php","line_daili.php","line_kangml.php","line_var.php","zs.php");?>">
                        <a href="#" class="<?php echoActiveMore("line_add.php","line_list.php","cat_add.php","line_daili.php","line_kangml.php","line_var.php","zs.php");?>">
                            <span data-feather="target" class="nav-icon"></span>
                            <span class="menu-text">线路</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a href="line_add.php" class="<?php echoActive('line_add.php');?>">添加线路</a>
                            </li>
                            <li>
                                <a href="line_list.php" class="<?php echoActive('line_list.php');?>">线路管理</a>
                            </li>
                            <li>
                                <a href="cat_add.php" class="<?php echoActive('cat_add.php');?>">线路分类</a>
                            </li>
<!--                            <li>-->
<!--                                <a href="line_daili.php" class="--><?php //echoActive('line_daili.php');?><!--">代理线路</a>-->
<!--                            </li>-->
                            <li>
                                <a href="line_kangml.php" class="<?php echoActive('line_kangml.php');?>">官方推送线路</a>
                            </li>
<!--                            <li>-->
<!--                                <a href="line_var.php" class="--><?php //echoActive('line_var.php');?><!--">线路安装配置</a>-->
<!--                            </li>-->
                            <li>
                                <a href="zs.php" class="<?php echoActive('zs.php');?>">线路变量配置</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("lj_ad.php","lj_hosts.php","lj_setting.php","lh_ip_port.php","lj_domain.php");?>">
                        <a href="#" class="<?php echoActiveMore("lj_ad.php","lj_hosts.php","lj_setting.php","lh_ip_port.php","lj_domain.php");?>">
                            <span data-feather="cpu" class="nav-icon"></span>
                            <span class="menu-text">拦截</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
<!--                            <li>-->
<!--                                <a href="lj_ad.php" class="--><?php //echoActive('lj_ad.php');?><!--">广告拦截</a>-->
<!--                            </li>-->
                            <li>
                                <a href="lj_hosts.php" class="<?php echoActive('lj_hosts.php');?>">hosts拦截</a>
                            </li>
<!--                            <li>-->
<!--                                <a href="lj_setting.php" class="--><?php //echoActive('lj_setting.php');?><!--">拦截配置</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="lh_ip_port.php" class="--><?php //echoActive('lh_ip_port.php');?><!--">IP端口拦截</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="lj_domain.php" class="--><?php //echoActive('lj_domain.php');?><!--">域名拦截</a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("add_gg.php","add_dlgg.php","list_gg.php","feedback.php","dl_feedback.php");?>">
                        <a href="#" class="<?php echoActiveMore("add_gg.php","add_dlgg.php","list_gg.php","feedback.php","dl_feedback.php");?>">
                            <span data-feather="message-square" class="nav-icon"></span>
                            <span class="menu-text">消息</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a class="<?php echoActive('add_gg.php');?>" href="add_gg.php">发布官方消息</a>
                            </li>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('add_dlgg.php');?><!--" href="add_dlgg.php">发布代理消息</a>-->
<!--                            </li>-->
                            <li>
                                <a class="<?php echoActive('list_gg.php');?>" href="list_gg.php">官方消息列表</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('feedback.php');?>" href="feedback.php">线路反馈消息</a>
                            </li>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('dl_feedback.php');?><!--" href="dl_feedback.php">代理反馈消息</a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("note_add.php","note_list.php","fwq_add.php","fwq_list.php");?>">
                        <a href="#" class="<?php echoActiveMore("note_add.php","note_list.php","fwq_add.php","fwq_list.php");?>">
                            <span data-feather="server" class="nav-icon"></span>
                            <span class="menu-text">负载</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a class="<?php echoActive('note_add.php');?>" href="note_add.php">添加节点</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('note_list.php');?>" href="note_list.php">节点管理</a>
                            </li>
                            <li>
                                <a class="<?php echoActive('fwq_add.php');?>" href="fwq_add.php">添加服务器
                                </a>
                            </li>
                            <li>
                                <a class="<?php echoActive('fwq_list.php');?>" href="fwq_list.php">服务器管理
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("sms_log.php","login_log.php","jk_log.php","net.php");?>">
                        <a href="#" class="<?php echoActiveMore("sms_log.php","login_log.php","jk_log.php","net.php");?>">
                            <span data-feather="bar-chart-2" class="nav-icon"></span>
                            <span class="menu-text">日志</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('sms_log.php');?><!--" href="sms_log.php">发信日志</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('login_log.php');?><!--" href="login_log.php">登陆日志</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('jk_log.php');?><!--" href="jk_log.php">监控日志-->
<!--                                </a>-->
<!--                            </li>-->
                            <li>
                                <a class="<?php echoActive('net.php');?>" href="net.php">网速监控
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-child <?php echoOpenMore("email.php","sms.php","register_setting.php","float.php","qq_admin.php","create_app.php","AdminShengji.php","cron.php");?>">
                        <a href="#" class="<?php echoActiveMore("email.php","sms.php","register_setting.php","float.php","qq_admin.php","create_app.php","AdminShengji.php","cron.php");?>">
                            <span data-feather="settings" class="nav-icon"></span>
                            <span class="menu-text">高级设置</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('email.php');?><!--" href="email.php">邮箱设置</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('sms.php');?><!--" href="sms.php">短信设置</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('register_setting.php');?><!--" href="register_setting.php">注册设置-->
<!--                                </a>-->
<!--                            </li>-->
                            <li>
                                <a class="<?php echoActive('float.php');?>" href="float.php">限速设置
                                </a>
                            </li>
                            <li>
                                <a class="<?php echoActive('qq_admin.php');?>" href="qq_admin.php">APP设置
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('create_app.php');?><!--" href="create_app.php">APP生成-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('AdminShengji.php');?><!--" href="AdminShengji.php">APP升级推送-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="--><?php //echoActive('cron.php');?><!--" href="cron.php">定时任务-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>