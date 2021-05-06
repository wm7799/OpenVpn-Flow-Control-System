<?php
$mod = 'blank';
$title = "订单支付记录";
include('head.php');
include('nav.php');
$my = $_GET['my'] ?? null;
if ($my == 'delNo') {
    $sql = db('pay_order')->where(array('status'=>0))->delete();
    if ($sql) {
        echo '删除成功！';
    } else {
        echo '删除失败！';
    }
}elseif ($my == 'delYes') {
    $sql = db('pay_order')->where(array('status'=>1))->delete();
    if ($sql) {
        echo '删除成功！';
    } else {
        echo '删除失败！';
    }
} else {
    if (!empty($_GET['kw'])) {
        $numrows = db('pay_order')->where('trade_no' . " LIKE :kw", [":kw" => "%" . $_GET["kw"] . "%"])->getnums();
        $where = 'trade_no' . " LIKE :kw";
        $data = [":kw" => "%" . $_GET["kw"] . "%"];
    } else {
        //$numrows=$DB->count("SELECT count(*) from `openvpn` WHERE 1");
        $numrows = db('pay_order')->where()->getnums();
        $where = '';
    }
    ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main user-member justify-content-sm-between ">
                        <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                            <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                                <h4 class="text-capitalize fw-500 breadcrumb-title"><?= $title ?></h4>
                                <span class="sub-title ml-sm-25 pl-sm-25"><?= $numrows ?> 订单</span>
                            </div>
                            <form action="user_list.php" method="get" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                <span data-feather="search"></span>
                                <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                       placeholder="搜索订单号" aria-label="Search" name="kw" value="<?= $_GET["kw"] ?>">
                            </form>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary btn-add dropdown-toggle px-15" type="button"
                                    id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="las la-plus fs-16"></i> 批量操作
                            </button>
                            <div class="dropdown-default dropdown-menu" aria-labelledby="dropdownMenu3">
                                <a href="javascript:void(0)" class="dropdown-item" onclick="if(!confirm('清理全部未支付订单？执行后不可恢复！')){return false;}else{delAllNo()}"> 清理未支付订单</a>
                                <a href="javascript:void(0)" class="dropdown-item" onclick="if(!confirm('清理全部已支付订单？执行后不可恢复！')){return false;}else{delAllYes()}"> 清理已支付订单</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <div class="custom-checkbox  check-all">
                                                <input class="checkbox" type="checkbox" id="check-3">
                                                <label for="check-3">
                                                    <span class="checkbox-text userDatatable-title">用户/代理账号</span>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">订单号</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">商品名称</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">金额</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">时间</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">平台</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">状态</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rs = db('pay_order')->where($where, $data)->fpage($_GET["page"], 30)->order("id DESC")->select();
                                foreach ($rs as $res) {
                                    ?>
                                    <tr class="line-id-<?= $res['id'] ?>">
                                        <td>
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <div class="checkbox-group-wrapper">
                                                        <div class="checkbox-group d-flex">
                                                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                <input class="checkbox" type="checkbox"
                                                                       id="check-grp-<?= $res['id'] ?>">
                                                                <label for="check-grp-<?= $res['id'] ?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="userDatatable-content">
                                                    <?php
                                                        if ($res['type']== 'daili'){
                                                            $daili = db("app_daili")->where(['id'=>$res['name']])->find();
                                                            echo $daili['name'];
                                                        }else{
                                                            $user = db("openvpn")->where(['id'=>$res['name']])->find();
                                                            echo $user['iuser'];
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= $res['trade_no'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?php
                                                if ($res['type']== 'daili'){
                                                    echo '代理充值';
                                                }else{
                                                    $tc = db("app_tc")->where(['id'=>$res['tid']])->find();
                                                    echo $tc['name'];
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                ¥ <?= $res['money'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= $res['addtime'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <?= $res['type'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content d-inline-block">
                                                <?php
                                                switch ($res['status']){
                                                    case 1:
                                                        echo '<span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">已支付</span>';
                                                        break;
                                                    case 0:
                                                        echo '<span class="bg-opacity-info  color-info rounded-pill userDatatable-content-status active">未支付</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">出错</span>';
                                                        break;
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        }
                        echo create_page_html($numrows, $_GET["page"]);
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include("footer.php");
    ?>
    <script>
        function delAllNo(){
            var url = './pay_order.php?my=delNo';
            $.post(url, {}, function () {
                location.reload();
            });
        }
        function delAllYes(){
            var url = './pay_order.php?my=delYes';
            $.post(url, {}, function () {
                location.reload();
            });
        }
    </script>
