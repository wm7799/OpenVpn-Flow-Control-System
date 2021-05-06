<?php
if(DID > 0){
	$res = db("app_daili")->where(["id"=>DID])->find();
	$data = $res;
}else{
	$m = new Map();
	$data = $m->type("cfg_app")->getAll();
}
?>
<div style="margin: 10px">
    <div style="background: #ffffff;padding: 10px;margin-top: 10px;border-top:3px">
        <?php
        echo html_decode($data["content"]);
        ?>
    </div>
</div>