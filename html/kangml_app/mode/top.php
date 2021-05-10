<?php
$u = $_GET['username'];
$p = $_GET['password'];
$db = db('top');
$list = $db->limit('20')->where(array("time" => date("Y-m-d", time())))->order('data DESC')->select();
$my = $db->where(array("username" => $u, "time" => date("Y-m-d", time())))->find();
$mytop = db("top")->where('data >= :data AND time = :time', [":data" => $my["data"], ":time" => date("Y-m-d", time())])->getnums();
$ml = printmb($my['data']);
echo '<div class="alert alert-success">
		<b>当前我的排名:以' . round($ml["n"], 2) . $ml["p"] . '的成绩位居今天第<font style="color:red">' . $mytop . '</font>名！</b></div>
		<style>
		.topn{font-size:30px;color:#fff;float:left;margin-left:15px;width:100px;}
		</style>';
$i = 1;
foreach ($list as $vo) {
    $l = printmb($vo['data']);
    echo '<div class="gradient-color-name gradient1 py-35 px-20 color-white rounded-xl m-10 "><div class="topn">' . $i . '</div><div class="topc"><h3 style="color: yellow">' . round($l['n'], 2) . $l['p'] . '</h3><div class="topu">' . substr_replace($vo["username"], '****', 3, 4) . '</div></div></div>';
    $i++;
}
echo '</tbody>
</table>';