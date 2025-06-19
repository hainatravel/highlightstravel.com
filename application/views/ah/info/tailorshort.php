<div class="footerTailorShort"></div>
<script>
$(function(){
	$.ajax({
		url:'/ajax_get/footerTailorShort',
		success:function(data){
			$('.footerTailorShort').html(data);
		}	
	});
});
</script>