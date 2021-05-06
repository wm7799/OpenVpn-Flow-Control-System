<?php
$title = '带宽监控';
require('head.php');
require('nav.php');
if ($_GET["type"] == "bwh") {
    $title2 = "24小时宽带流出";
    $type = "bwh";
} else {
    $title2 = "实时宽带流出";
    $type = "bw";
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
                <div class="card broder-0">
                    <div class="card-header">
                        <h6><?= $title2 ?></h6>
                        <div class="card-extra">
                            <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                                <li>
                                    <a <?php echo $type == "bw" ? 'class="active"' : '' ?> href="net.php?type=bw">实时</a>
                                </li>
                                <li>
                                    <a <?php echo $type == "bwh" ? 'class="active"' : '' ?>
                                            href="net.php?type=bwh">24小时</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- ends: .card-header -->
                    <div class="card-body pt-0">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="tl_revenue-year" role="tabpanel"
                                 aria-labelledby="tl_revenue-year-tab">
                                <!-- ends: .performance-stats -->
                                <div class="wp-chart">
                                    <div class="parentContainer">
                                        <div>
                                            <canvas id="FlowChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ends: .card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>
<script>
    $.post("rateJson.php?act=" + "<?=$type?>", {}, function (json) {
        let flowArr = [];
        let timeArr = [];
        json.forEach(obj => {
            flowArr.push(obj['value']);
            timeArr.push(obj['name']);
        })
        chartjsLineChartFourFlow(
            "FlowChart",
            "#FA8B0C",
            "95",
            (data = flowArr),
            (data = flowArr),
            labels = timeArr
        );
    }, "JSON");
</script>
