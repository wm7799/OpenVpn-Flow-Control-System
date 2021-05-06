<div class="col-lg-6 mt-3">
    <div class="atbd-notice">
        <div class="card card-default card-md mb-4">
            <div class="card-body">
                <div class="atbd-notice__content">
                    <div class="atbd-notice__top text-center">
                        <div class="atbd-notice__icon bg-success">
                            <i class="fas fa-check color-white"></i>
                        </div>
                        <div class="atbd-notice__text">
                            <h4>支付成功</h4>
                            <p>谢谢，您已经付款成功！</p>
                        </div>
                    </div>
                    <div class="atbd-notice__action d-flex justify-content-center">
                        <a href="webview:close" class="btn btn-sm btn-primary">关闭</a>
                    </div>
                </div>
            </div>
        </div><!-- ends: .card -->
    </div>

</div>
<script>
function sysC(){
	window.myObj.colsePage();
}
$(function() { 
        $('#myModal').modal({ 
            keyboard: true 
        }) 
    }); 
</script>