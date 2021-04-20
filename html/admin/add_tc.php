<?php
$title = '添加套餐';
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_tc');
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
			'jg'=>$_POST['jg'],
			'limit'=>$_POST['limit'],
			'rate'=>$_POST['rate'],
			'url'=>$_POST['url']
		))){
			tip_success("公告修改成功",'add_tc.php?act=mod&id='.$_GET['id']);
		}else{
			tip_failed("十分抱歉修改失败",'add_tc.php?act=mod&id='.$_GET['id']);
		}
	}elseif($_GET['act'] == 'add'){
		$db = db('app_tc');
		if($db->insert(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
			'jg'=>$_POST['jg'],
			'limit'=>$_POST['limit'],
			'rate'=>$_POST['rate'],
			'url'=>$_POST['url'],
			'time'=>time()
		))){
			tip_success("新增消息【".$_POST['name']."】成功！",'add_tc.php');
		}else{
			tip_failed("十分抱歉修改失败",'add_tc.php');
		}
	}else{
	$action = '?act=add';
	if($_GET['act'] == 'mod'){
		$info = db('app_tc')->where(array('id'=>$_GET['id']))->find();
		$action = "?act=update&id=".$_GET['id'];
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
                        <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade  show active" id="v-pills-home">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-sm-6 col-10">
                                            <div class="mt-40 mb-50">
                                                <div class="edit-profile__body">
                                                    <form method="POST" action="<?php echo $action?>"
                                                          onsubmit="return checkStr()">
                                                        <div class="form-group mb-25">
                                                            <label for="phoneNumber5">套餐名称 <span
                                                                        style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="phoneNumber5"
                                                                   name="name" placeholder="标题"
                                                                   value="<?php echo $info['name'] ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="phoneNumber1">套餐价格(元) <span
                                                                        style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="phoneNumber1"
                                                                   name="jg" placeholder="10"
                                                                   value="<?php echo $info['jg'] ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="phoneNumber2">流量限额(M) <span
                                                                        style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="phoneNumber2"
                                                                   name="rate" placeholder="1024"
                                                                   value="<?php echo $info['rate'] ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="phoneNumber3">购买连接 <span
                                                                        style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="phoneNumber3"
                                                                   name="url" placeholder="http://abc.cn/buy/122"
                                                                   value="<?php echo $info['url'] ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="phoneNumber5">套餐描述 <span
                                                                        style="color:red">*</span></label>
                                                            <textarea type="text" class="form-control" id="phoneNumber5"
                                                                   name="content" rows="10"><?php echo $info['content'] ?></textarea>
                                                        </div>
                                                        <div class="button-group d-flex pt-25 justify-content-end">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-block btn-default btn-squared text-capitalize radius-md shadow2">
                                                                提交
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<script>
	function checkStr(){
		var title = $('[name="title"]').val();
		var content = $('[name="content"]').val();
		if(title == "" || content ==　""){
			alert("标题与内容不得为空");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
?>
