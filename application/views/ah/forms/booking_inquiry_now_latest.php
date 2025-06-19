<style>
.footerBtn { display: block; margin: 0 auto; width: 250px; text-align: center; background: #a31022; border-radius: 4px; font-size: 20px; padding: 8px 0; color: #fff; cursor: pointer; }
.footerBtn>span { color: #fff; }
@media(max-width:768px) {
.footerBtn { position: fixed; bottom: 0; left: 0; display: block !important; width: 100%; color: #fff; font-size: 14px; background: #a31022; border-radius: 0px; z-index: 9999; }
}
</style>
<div class="footerBtn visible-xs" id="footerBtn" >
<form  action="/forms/inquirymobile" method="post">    
    <input name="cli_no" id="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden" /> 
    <input name="cli_sn" id="cli_sn" value="<?php echo $pd_tour->CLI_SN; ?>" type="hidden" />  
    <input name="cli_days" id="cli_days" value="<?php echo $pd_tour->CLI_Days; ?>" type="hidden" /> 
    <input name="destinations" id="destinations" value="<?php echo $pd_tour->CLI2_PassCity; ?>" type="hidden" />    
	<input name="ic_title" type="hidden" value="<?php echo $pd_tour->CLI2_Name; ?>">
    <span class="" id="footerBtn_sub">Inquiry Now</span>
</form>    
</div>

<script>
    $(function(){
        if($(window).width()<768){
            $(".inquiryNow").css("display","none");
            $("#footer").css("display","none");
        }
    })
    $("#footerBtn_sub").click(function(){
        $("#footerBtn>form").submit();
    });
</script>
