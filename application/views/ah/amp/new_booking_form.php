<!--inquiryBtn开始-->
<div class="footerBtn visible-xs" id="footerBtn">
    <form action="/forms/inquirymobile" method="GET" target="_top">
        <input name="cli_no" id="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden">
        <input name="cli_sn" id="cli_sn" value="<?php echo $pd_tour->CLI_SN; ?>" type="hidden">
        <input name="cli_days" id="cli_days" value="<?php echo $pd_tour->CLI_Days; ?>" type="hidden">
        <input name="destinations" id="destinations" value="<?php echo $pd_tour->CLI2_PassCity; ?>" type="hidden">
        <input name="ic_title" type="hidden" value="<?php echo $pd_tour->CLI2_Name; ?>"/>
        <input type="submit" value="Inquire Now" id="footerBtn_sub">
    </form>
</div>
<!--inquiryBtn结束-->