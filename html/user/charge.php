<?php
$title = '余额充值';
include("api_head.php");
include("nav.php");
if(isset($_POST['km'])){
    $km = $_POST['km'];
    $myrow=db("app_kms")->where(array("km"=>$km))->find();
    if(!$myrow){
        echo "<script>alert('此激活码不存在');</script>";
    }elseif($myrow['isuse']==1){
        echo "<script>alert('此激活码已被使用');</script>";
    }else{
        $type_id = $myrow["type_id"];
        $tc = db("app_tc")->where(array("id"=>$type_id))->find();
        if(!$tc){
            echo "<script>alert('套餐已经失效');</script>";
        }
        $userinfo = db("openvpn")->where(["id"=>$userinfo["id"]])->find();
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
        $update["daili"] = $myrow["daili"];
        $update[_i_] = "1";
        if(db(_openvpn_)->where(["id"=>$userinfo["id"]])->update($update)){
            db("app_kms")->where(array("id"=>$myrow['id']))->update(array("isuse"=>"1","user_id"=>$userinfo["id"],"usetime"=>time()));
            echo "<script>alert('开通成功');</script>";
        }else{
            echo "<script>alert('开通失败');</script>";
        }
    }
}
    ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center user-member__title mb-30 mt-30">
                        <h4 class="text-capitalize"><?= $title ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-Vertical card-default card-md mb-4">
                        <div class="card-body pb-md-30">
                            <div class="Vertical-form">
                                <div class="alert alert-danger">未到期的用户充值将会自动叠加流量和日期。</div>
                                <form role="form" method="POST" action="?"
                                      onsubmit="return checkStr()">
                                    <div class="form-group">
                                        <label for="firstname" class="color-dark fs-14 fw-500 align-center">卡密</label>
                                        <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15" name="km" placeholder="请输入激活码卡密">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">充值</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
include('api_footer.php');
?>