<?php
require("system.php");
$cache = R . "/cache/access.tmp";
$read = R . "/cache/read.tmp";
$do = $_POST["do"];
if ($do == "getMsg") {
    //获取公告内容
    if (is_file($cache) && time() - filemtime($cache) < 3 * 60) {
        //存在文件并且时间小于3小时
        $json = file_get_contents($cache);
    } else {
        //获取远程服务器的公告
        $url = 'http://www.pykky.com/gg.tmp';
        if (!file_put_contents($cache, file_get_contents($url)))
            file_put_contents($cache, "[]");
        $json = file_get_contents($cache);
    }
    if ($json) {
        //从消息数组中去除已读的公告id
        $jsonArr = json_decode($json);
        $readArr = json_decode(file_get_contents($read));
        $newGGArr = [];
        foreach ($jsonArr as $value){
            if (!in_array($value->id,$readArr)){
                array_push($newGGArr,$value);
            }
        }
        die(json_encode($newGGArr));
    }
    die(json_encode([]));
} else if ($do == "readMsg") {
    //已读
    $oldJsonArr = json_decode(file_get_contents($read));//解析旧的文件里的json
    $id = $_POST['id'];
    array_push($oldJsonArr, $id);//添加新的已读公告id
    $newJson = json_encode($oldJsonArr);
    //保存回去
    if (!file_put_contents($read, $newJson)){
        file_put_contents($read, "[]");
        die('no');
    }
} else if ($do == "getALLMsg") {
    //获取公告内容
    if (is_file($cache) && time() - filemtime($cache) < 3 * 60) {
        //存在文件并且时间小于3小时
        $json = file_get_contents($cache);
    } else {
        //获取远程服务器的公告
        $url = 'http://www.pykky.com/gg.tmp';
        if (!file_put_contents($cache, file_get_contents($url)))
            file_put_contents($cache, "[]");
        $json = file_get_contents($cache);
    }
    if ($json) {
        die($json);
    }
    die(json_encode([]));
}