<script>
//本FAS系统由小乐二开修复  小乐博客http://blog.xiaole888.cn  
  $(function() {
    $( ".Wdate" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
    onClose: function( selectedDate ) {
        $( "#rangeBb" ).datepicker( "option", "minDate", selectedDate );
    }
	});
  });

</script>
<script>
  $(function(){
	   $('.btnui').button();
  });
  </script>
<script>
  function delDLine(id){
		var url = './qq_admin_daili.php?act=del&id='+id;
		$.post(url,{
		  
		},function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  function delLine(id){
		var url = './user_list.php?my=del&user='+id;
		$.post(url,{
		  
		},function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  

  
  

  function outline_udp(id){
		var url = './option.php?my=outline_udp&user='+id;
		$.post(url,{
			"user":id
		  },function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  
 //本FAS系统由小乐二开修复  小乐博客http://blog.xiaole888.cn 
  </script>
		<center><br><br>
		筑梦工作室技术支持，小乐博客提供备份<a href="http://blog.xiaole888.cn">http://blog.xiaole888.cn</a>
		<img style="display:none" src="http://lk.xiaole888.cn"></img>
		<br>
		</center>

  		</div>
  	</div>
 </div> <!--table-->
 <script>
var msg_id = 0;
$(function(){
	$.post(
		"<?=$admindir?>access.php",
		{
			"do":"getMsg"
		},function(data){
			if(data.status == "success"){
				$(".top-tips").fadeIn();
				$(".top-tips span").html(data.title);
				$(".gonggao p").html(data.msg);
				msg_id = data.id;
			}
		},"JSON");
});
$(function(){
	$(".onclick-item").click(function(){
		var n = $(".onclick-item").index(this);
			if($(".section-sub").eq(n).is(":hidden")){
				$(".section-sub").slideUp();
				$(".section-sub").eq(n).slideDown("fast");
				//$(".section-sub").eq(n).show();
			}else{
			//	$(".section-sub").eq(n).sileUp();
				$(".section-sub").eq(n).slideUp("fast");
				//$(".section-sub").eq(n).hide();
			}
			
	});
	$(".section>li").click(function(){
			var n = $(".section>li").index(this);
			$(".section>li").removeClass("active");
			$(".section>li").eq(n).addClass("active");
	});
	$(".shows").click(function(){
		if($(".sile").is(":hidden")){
			$(".sile").fadeIn("fast");
		}else{
			$(".sile").fadeOut();
		}
	});
	$(".gonggao-ok").click(function(){
		$(".gonggao").slideUp("fas");
		$.post(
		"<?=$admindir?>access.php",
		{
			"do":"readMsg",
			"id":msg_id
		},function(){
		});
	});
	$(".top-tips").click(function(){
		$(".gonggao").toggle("fas");
	});
});
</script>
<script src="/assets/js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
<script src="/assets/js/google-code-prettify/prettify.js" type="text/javascript"></script>
<script src="/assets/js/docs.js" type="text/javascript"></script>
</body>
</html>