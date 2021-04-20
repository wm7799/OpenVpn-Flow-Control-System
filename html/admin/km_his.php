<?php
$title="上次批量卡密生成记录";
include("head.php");
include("nav.php");
?>
<div class="contents">
    <div class="atbd-page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title"><?=$title?></h4>
                    </div>
                </div>
                <?php
                if (is_file("kmdata.php")) {
                    include("kmdata.php");
                    $time = filemtime("kmdata.php");
                    $count = count($km);
                    ?>
                    <div class="col-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6><?php echo "记录时间 " . date("Y/m/d H:i:s", $time) . " 共" . $count . "条"; ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="list-box">
                                    <ul>
                                        <?php
                                        foreach ($km as $vo) {
                                            echo '<li class="list-box__item">' . $vo . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <!-- ends: .list-box -->
                            </div>
                        </div>
                        <!-- ends: .card -->
                    </div>
                    <!-- ends: .col-lg-6 -->
                    <?php
                } else {
                    echo '<div class="col-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>您还没有生成记录哦</h6>
                                </div>
                            </div>
                            <!-- ends: .card -->
                        </div>
                        <!-- ends: .col-lg-6 -->';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- ends: .atbd-page-content -->
</div>
<?php
include("footer.php");
?>