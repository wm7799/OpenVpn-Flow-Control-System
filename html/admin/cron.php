<?php
require_once('system.php');
$db = db("dash");
$ef_user = $db->where(["name"=>"ef_user"])->find();
if ($ef_user){
    $contentArr = json_decode($ef_user['content']);//获取旧的数据
    for ($i=1 ; $i<10;$i++){
        //去除第一个，保留后面9个
        $newContentArr[] = $contentArr[$i];
    }
    //填入今天第10个
    $newContentArr[] = db(_openvpn_)->where(["i" => "1"])->getnums(); //有效用户
    $jsonArr = json_encode($newContentArr);
    $res = $db->where(["name"=>"ef_user"])->update(["content"=>$jsonArr]);
}

$daili = $db->where(["name"=>"daili"])->find();
if ($daili){
    $contentArr = json_decode($daili['content']);//获取旧的数据
    for ($i=1 ; $i<10;$i++){
        //去除第一个，保留后面9个
        $newContentArr2[] = $contentArr[$i];
    }
    //填入今天第10个
    $newContentArr2[] = db("app_daili")->where()->getnums(); //代理数量
    $jsonArr = json_encode($newContentArr2);
    $res2 = $db->where(["name"=>"daili"])->update(["content"=>$jsonArr]);
}

echo 'success';