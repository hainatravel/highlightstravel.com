
<div class="footerBtn" id="footerBtn" >
<form  action="/orders/asia_tour" method="post">    
    <input name="cli_no" id="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden" /> 
    <input name="cli_sn" id="cli_sn" value="<?php echo $pd_tour->CLI_SN; ?>" type="hidden" />  
    <input name="cli_days" id="cli_days" value="<?php echo $pd_tour->CLI_Days; ?>" type="hidden" /> 
    <input name="destinations" id="destinations" value="<?php echo $pd_tour->CLI2_PassCity; ?>" type="hidden" />     
    <span class="" id="footerBtn_sub">Inquiry Now</span>
</form>    
</div>

<script>
    $(function(){
        if($(window).width()<768){
            $("#form_tour_detail").css("display","none");
            $("#footer").css("display","none");
        }
    })
    $("#footerBtn_sub").click(function(){
        $("#footerBtn>form").submit();
    });
</script>
