<?php
//执行shell命令
function systemi($line)
{
    $service_port = 8989;
    $address = '127.0.0.1';
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        $status = "error";
        $msg = "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    } else {
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 10, "usec" => 0));
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 10, "usec" => 0));
        $result = socket_connect($socket, $address, $service_port);
        if ($result === false) {
            $status = "error";
            $msg = "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
        } else {
            $status = "success";
            socket_write($socket, $line, strlen($line));
            $out = socket_read($socket, 8192);
            $msg = $out;
        }
        socket_close($socket);
        return ["status" => $status, "msg" => $msg];
    }
}

function db($dbname)
{
    //$ddcms = $_SERVER['ddcms']['cfg']['host']['ddcms'];
    $db = new D($dbname);
    return $db;
}

function dbRemote($dbInfo)
{
    $db = new D($dbInfo,true);
    return $db;
}

function processOrder($orderNum){
    $payDB = db('pay_order');
    $rs = $payDB->where(array('trade_no' => $orderNum))->find();//根据id找到订单信息
    if ($rs) {
        //变成已支付状态
        $payDB->where(["trade_no"=>$orderNum])->update(["status" => 1]);
        $tid = $rs["tid"];
        //判断是代理还是用户充值
        if ($tid == '-1') {
            if(db('app_daili')->where(['id'=>$rs['name']])->update('balance = balance+'.$rs['money'].',`lock`=1')){
                return "";
            }else{
                $payDB->where(["trade_no"=>$orderNum])->update(["status" => 2]);
                return "充值失败";
            }
        } else {
            $tc = db('app_tc')->where(array('id' => $tid))->find();
            if(!$tc){
                return "套餐已经失效";
            }
            $userinfo = db("openvpn")->where(["id"=>$rs["name"]])->find();
            $addll = $tc['rate']*1024*1024;//套餐流量
            //已到期，重置所有东西
            if ($userinfo["endtime"]<time()){
                $update[_maxll_] = $addll;
                $update[_endtime_] = time() + $tc['limit']*24*60*60;
                $update[_isent_] = "0";
                $update[_irecv_] = "0";
            }else{
                //没到期，用旧时间叠加
                $update[_maxll_] = $userinfo["maxll"] +$addll;//流量直接叠加
                $update[_endtime_] = $userinfo["endtime"]+ ($tc['limit']*24*60*60);
            }
            $update[_i_] = "1";
            if(db(_openvpn_)->where(["id"=>$rs["name"]])->update($update)){
                return "";
            }else{
                $payDB->where(["trade_no"=>$orderNum])->update(["status" => 2]);
                return "充值失败";
            }
        }

    }else{
        return '无法找到订单信息';
    }
}

function getClientIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

function html_encode($content, $style = ENT_QUOTES)
{
    return htmlspecialchars($content, $style);
}

function html_decode($content, $style = ENT_QUOTES)
{
    return htmlspecialchars_decode($content, $style);
}

function timeStr($time)
{
    $now = time();
    //十分钟 60*10
    $m10 = 60 * 10;
    if ($now - $time < 30) {
        return '刚刚';
    }
    for ($i = 1; $i <= 10; $i++) {
        if ($now - $time < $i * 60) {
            return $i . '分钟前';
        }
    }
    for ($i = 2; $i <= 6; $i++) {
        if ($now - $time < $i * $m10) {
            $t = ($i - 1) * 10;
            return $t . '分钟前';
        }
    }

    for ($i = 2; $i <= 24; $i++) {
        if ($now - $time < $i * $m10 * 6) {
            return $i . '小时前';
        }
    }
    for ($i = 2; $i <= 30; $i++) {
        if ($now - $time < $i * $m10 * 6 * 24) {
            return $i . '天前';
        }
    }

    return date('Y/m/d H:i:s', $time);

}

function sendmail($to, $title, $content)
{
    //$smtppass = "rhglzztqhuuleahf";//SMTP服务器的用户密码
    $mail = new MySendMail();
    $mail->setServer("smtp.qq.com", "2207134109", "umgubpgdgjtfebba", 465, true); //设置smtp服务器，到服务器的SSL连接
    $mail->setFrom("send@dingd.cn"); //设置发件人
    $mail->setReceiver($to); //设置收件人，多个收件人，调用多次
    $mail->setMail($title, $content); //设置邮件主题、内容
    $state = $mail->sendMail();
    if ($state == "") {
        return false;
    }
    return true;
    /* @example
     * $mail = new MySendMail();
     * $mail->setServer("smtp@126.com", "XXXXX@126.com", "XXXXX"); //设置smtp服务器，普通连接方式
     * $mail->setServer("smtp.qq.com", "2207134109@qq.com", "yaoyao820", 465, true); //设置smtp服务器，到服务器的SSL连接
     * $mail->setFrom("admin@dingd.cn"); //设置发件人
     * $mail->setReceiver($to); //设置收件人，多个收件人，调用多次
     * $mail->setCc(""); //设置抄送，多个抄送，调用多次
     * $mail->setBcc(""); //设置秘密抄送，多个秘密抄送，调用多次
     * $mail->addAttachment(""); //添加附件，多个附件，调用多次
     * $mail->setMail($title, $content); //设置邮件主题、内容
     * $mail->sendMail(); //发送
     * $mail->sendMail(); //发送*/
}

function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_PROFILE'])) {
        $mobile_browser++;
    }
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
        $mobile_browser++;
    }
    // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
        $mobile_browser = 0;
    }
    // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
        $mobile_browser++;
    }
    if ($mobile_browser > 0) {
        return true;
    } else {
        return false;
    }
}

function printmb($ml)
{
    $m = abs($ml);
    if ($m < 1024) { //b
        $c = $m;
        $p = 'B';
    } elseif ($m >= 1024 && $m < 1024 * 1024) {
        $c = ($m / 1024);
        $p = 'K';
    } elseif ($m >= 1024 * 1024 && $m < 1024 * 1024 * 1024) {
        $c = ($m / 1024 / 1024);
        $p = 'M';
    } elseif ($m >= 1024 * 1024 * 1024 && $m < 1024 * 1024 * 1024 * 1024) {
        $c = ($m / 1024 / 1024 / 1024);
        $p = 'G';
    } elseif ($m >= 1024 * 1024 * 1024 * 1024) {
        $c = ($m / 1024 / 1024 / 1024 / 1024);
        $p = 'T';
    }
    $pre = $ml < 0 ? '-' : '';
    return array('n' => $pre . $c, 'p' => $p);
}

function setSystemData($key, $value)
{
    $db = db("app_data");
    if (trim($key) != "") {
        if ($db->where(array("key" => $key))->find()) {
            if ($db->where(array("key" => $key))->update(array("value" => $value))) {
                return true;
            } else {
                return false;
            };
        } else {
            if ($db->insert(array("key" => $key, "value" => $value))) {
                return true;
            } else {
                return false;
            };
        }
    }
    return false;
}

function getSystemData($key)
{
    $db = db("app_data");
    if (trim($key) != "") {
        $info = $db->where(array("key" => $key))->find();
        if ($info) {
            return $info["value"];
        } else {
            return "";
        }
    }
    return "";
}

function tip_success($msg, $url)
{
    echo '<div class="modal-info-success modal fade show" id="modal-info-success" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-info" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-info-body d-flex">
                            <div class="modal-info-icon success">
                                <span data-feather="check-circle"></span>
                            </div>

                            <div class="modal-info-text">
                                <p>'.$msg.'</p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">';
    if ($url == "?") {
        echo '<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Ok</button>';
    } else {
        echo '<a href="' . $url . '" class="btn btn-primary btn-sm">Ok</a>';
    }
    echo '</div>
                </div>
            </div>
        </div>
        <script>setTimeout(function(){
        $("#modal-info-success").modal()},100)</script>}';
}

function tip_failed($msg, $url)
{
    echo '<div class="modal-info-error modal fade show" id="modal-info-error" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-info" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-info-body d-flex">
                            <div class="modal-info-icon danger">
                                <span data-feather="x-circle"></span>
                            </div>

                            <div class="modal-info-text">
                                <p>'.$msg.'</p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">';
    if ($url == "?") {
        echo '<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Ok</button>';
    } else {
        echo '<a href="' . $url . '" class="btn btn-primary btn-sm">Ok</a>';
    }
    echo '</div>
                </div>
            </div>
        </div>
        <script>setTimeout(function(){
        $("#modal-info-error").modal()},100)</script>}';
}