<?php
$title = '更新记录';
include('head.php');
include('nav.php');
?>
<div class="contents">
    <div class="container-fluid">
        <?php echo file_get_contents("http://a.pykky.com/changelog.html")?>
    </div>
</div>
<?php
include('footer.php');
?>
