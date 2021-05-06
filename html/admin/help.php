<?php
$title = '帮助中心';
include('head.php');
include('nav.php');
?>
<div class="contents">
        <div class="container-fluid">
            <?php echo file_get_contents("http://a.pykky.com/faq.html")?>
        </div>
</div>
<?php
include('footer.php');
?>
