<?php
	require("system.php");
	if(@$_GET["act"]=="mod"){
		$db = db(_openvpn_);
		if($userinfo[_ipass_] == $_POST["pass"]){
			if($_POST["passnew"] == $_POST["passnew2"]){
				$db->where(array(_iuser_=>$userinfo["id"]))->update([_ipass_=>trim($_POST["passnew"])]);
				die(json_encode(array("status"=>"success","msg"=>"修改成功")));
			}else{
				die(json_encode(array("status"=>"error","msg"=>"两次密码不一致")));
			}
		}else{
			die(json_encode(array("status"=>"error","msg"=>"用户不存在或者密码错误")));
		}
	}else{
	    $title = "修改密码";
	require("api_head.php");
	require("nav.php");
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
                                    <div class="form-group">
                                        <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">旧密码</label>
                                        <input type="password"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15" id="pass"
                                               placeholder="请输入旧密码">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">新密码</label>
                                        <input type="password"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15" id="passnew"
                                               placeholder="请输入新密码">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="color-dark fs-14 fw-500 align-center">再次确认新密码</label>
                                        <input type="password"
                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                               id="passnew2"
                                               placeholder="请输入新密码">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block mod">确认修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	<?php
	require("api_footer.php");
	?>
        <script>
            $(function(){
                $(".mod").click(function(){
                    //  alert("修改密码后您必须重新切换账号登录！");
                    $.post(
                        "?act=mod",{
                            "pass":$("#pass").val(),
                            "passnew":$("#passnew").val(),
                            "passnew2":$("#passnew2").val()
                        },function(data){
                            if(data.status == "success"){
                                alert("密码修改成功");
                                window.myObj.goLogin();
                            }else{
                                alert(data.msg);
                            }
                        },"JSON"
                    );
                });
            });
        </script>
<?php
	}?>