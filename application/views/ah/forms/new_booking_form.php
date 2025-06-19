<div class="priceBlock">
	<form id="form_tour_detail" name="form_tour_detail" action="/forms/inquiry" method="post">
		<?php 
			if($pd_tour->CLI_NO == 'AH-24'){?>
			<span class="from"><?php echo $pd_tour->CLI_Days; ?> Day from</span>
		<?php }else{?>
			<span class="from"><?php echo $pd_tour->CLI_Days; ?> Days from</span>
		<?php }?>
		<b>$<span>#<?php echo $pd_tour->CLI_NO; ?>#</span></b>p/p
		<?php 
			if($pd_tour->CLI_NO != 'AH-24'){?>
				<span class="basedOn">(Based on a 2-people private group)</span>
			<?php }?>	
		<span class="inquiryNow"><input type="submit" value="Make an inquiry"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
		<input name="cli_no" id="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden" /> 
		<input name="cli_sn" id="cli_sn" value="<?php echo $pd_tour->CLI_SN; ?>" type="hidden" />  
		<input name="cli_days" id="cli_days" value="<?php echo $pd_tour->CLI_Days; ?>" type="hidden" /> 
		<input name="destinations" id="destinations" value="<?php echo $pd_tour->CLI2_PassCity; ?>" type="hidden" /> 
		<input name="ic_title" type="hidden" value="<?php echo $pd_tour->CLI2_Name; ?>"/>
	</form>
</div>
<script>
$(function(){
	//侧边滑动
	$("#form_tour_detail").stick_in_parent({parent: "#mcontent",bottoming:true,offset_top:80});
	
	var height = $('#Itinerary').offset().top;
	var height2 = $('#Handpicked').offset().top;
	var height3 = $('#Journey').offset().top;
	$(window).scroll(function(){
		if(($(window).scrollTop() > height) && ($(window).scrollTop() < height2)){
			$('.Handpicked').removeClass('active');
			$('.Journey').removeClass('active');
			$('.Itinerary').addClass('active');
		}
		if(($(window).scrollTop() > height2) && ($(window).scrollTop() < height3)){
			$('.Journey').removeClass('active');
			$('.Itinerary').removeClass('active');
			$('.Handpicked').addClass('active');
		}
		if(($(window).scrollTop() > height3)){
			$('.Itinerary').removeClass('active');
			$('.Handpicked').removeClass('active');
			$('.Journey').addClass('active');
		}
	});
});
</script>