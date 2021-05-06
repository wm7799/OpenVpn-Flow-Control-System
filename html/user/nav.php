<?php
function echoActive($str){
    $url=$_SERVER['REQUEST_URI'];
    echo strpos($url,$str) == true ? 'active' : '';
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
                                    <span><?=$userinfo[_iuser_]?></span>
                                </div>
                            </div>
                            <div class="nav-author__options">
                                <ul>
                                    <li>
                                        <a href="mod.php">
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
                    <a href="index.php" class="<?php echoActive('index.php');?>">
                        <span data-feather="home" class="nav-icon"></span>
                        <span class="menu-text">仪表盘</span>
                    </a>
                </li>
                <li class="menu-title m-top-30">
                    <span>功能区</span>
                </li>
                <li>
                    <a href="charge.php" class="<?php echoActive("charge.php");?>">
                        <span data-feather="layers" class="nav-icon"></span>
                        <span class="menu-text">充值</span>
                        <span class="toggle-icon"></span>
                    </a>
                </li>
                <?php
                if ($userinfo["daili"]==0){
                ?>
                <li>
                    <a href="tc.php" class="<?php echoActive("tc.php");?>">
                        <span data-feather="shopping-cart" class="nav-icon"></span>
                        <span class="menu-text">套餐</span>
                        <span class="toggle-icon"></span>
                    </a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="iosline.php" class="<?php echoActive("iosline.php");?>">
                        <span data-feather="target" class="nav-icon"></span>
                        <span class="menu-text">线路</span>
                        <span class="toggle-icon"></span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>