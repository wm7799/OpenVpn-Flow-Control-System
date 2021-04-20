<?php
//后台锁定
$file = dirname(dirname(dirname( __FILE__)))."/kangml.lock";
if(file_exists($file))
{
    require ("error.php");
    return;
}
?>
<?php
header("location:admin.php");
