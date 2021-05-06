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
?>
<body class="layout-light side-menu">
<div class="mobile-search"></div>
<div class="mobile-author-actions"></div>
<header class="header-top">
    <nav class="navbar navbar-light">
        <div class="navbar-left">
            <a href="" class="sidebar-toggle">
                <img class="svg" src="../img/svg/bars.svg" alt="img"></a>
        </div>
        <!-- ends: navbar-left -->
        <div class="navbar-right">
            <ul class="navbar-right__menu">
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
                                    <span>尊敬的<?=$admin["name"]?></span>
                                </div>
                            </div>
                            <div class="nav-author__options">
                                <ul>
                                    <li>
                                        <a href="user.php">
                                            <span data-feather="key"></span> 修改密码</a>
                                    </li>
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
                <li class="menu-title m-top-30">
                    <span>功能区</span>
                </li>
                <li class="has-child <?php echoOpenMore("user_list.php");?>">
                    <a href="#" class="<?php echoActiveMore("user_list.php");?>">
                        <span data-feather="user" class="nav-icon"></span>
                        <span class="menu-text">用户</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="<?php echoActive('user_list.php');?>" href="user_list.php">用户列表</a>
                        </li>
                    </ul>
                </li>
                <li class="has-child <?php echoOpenMore("km_list.php","km_last.php");?>">
                    <a href="#" class="<?php echoActiveMore("km_list.php","km_last.php");?>">
                        <span data-feather="shopping-cart" class="nav-icon"></span>
                        <span class="menu-text">销售</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="km_list.php" class="<?php echoActive('km_list.php');?>">卡密管理</a>
                        </li>
                        <li>
                            <a href="km_last.php" class="<?php echoActive('km_last.php');?>">上次生成卡密</a>
                        </li>
                    </ul>
                </li>
                <li class="has-child <?php echoOpenMore("add_gg.php","list_gg.php");?>">
                    <a href="#" class="<?php echoActiveMore("add_gg.php","list_gg.php");?>">
                        <span data-feather="message-square" class="nav-icon"></span>
                        <span class="menu-text">消息</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="<?php echoActive('add_gg.php');?>" href="add_gg.php">发布消息</a>
                        </li>
                        <li>
                            <a class="<?php echoActive('list_gg.php');?>" href="list_gg.php">消息列表</a>
                        </li>
                    </ul>
                </li>
                <li class="has-child <?php echoOpenMore("kf.php");?>">
                    <a href="#" class="<?php echoActiveMore("kf.php");?>">
                        <span data-feather="settings" class="nav-icon"></span>
                        <span class="menu-text">高级设置</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="<?php echoActive('kf.php');?>" href="kf.php">客服修改</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>