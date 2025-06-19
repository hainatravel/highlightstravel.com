<form id="form_tour_detail" name="form_tour_detail" action="/orders/asia_tour" method="post">
    <div class="tourBox">
        <ul class="tourList">
            <li>
            Duration: <?php echo $pd_tour->CLI_Days; ?> days</li>
            <li>
                Tour Code:<?php echo $pd_tour->CLI_NO; ?>
            </li>
            <li>
                Tour Type: Private Tour</li>
        </ul>
        <div class="promoPrice">
            <span class="moneyfrom">From:</span> <span class="moneyTyp">$</span><span class="bestPrice">#<?php echo $pd_tour->CLI_NO; ?>#</span> <a class="priceLink" href="#price">Price details</a> 
        </div>
        <div class="letterrow">
            Book This Tour
        </div>
        <div class="departTime">
            <span class="title"><span class="glyphicon glyphicon-calendar"></span> Departure Date:</span> <input value="" name="Starting_Date" id="Starting_Date" class="depart hasDatepicker datepicker" placeholder="mm/dd/yyyy" /> 
        </div>
        <div class="row">
        <div class="col-md-24 col-sm-24 col-xs-24">
        <span class="title">Traveler:</span>
        </div>
        
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="traveller">
                   <select id="adultenum" name="adultenum"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">6+</option>        </select> 
                    <span class="ageInfo"> Age(18+):</span> 
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="traveller">
                    <select id="childnum" name="childnum"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">6+</option> </select> 
                    <span class="ageInfo"> Age(12-17):</span> 
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="traveller">
                    <select id="childnum" name="childnum"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">6+</option> </select> 
                    <span class="ageInfo"> Age(< 12):</span> 
                </div>
            </div>
        </div>
        <div class="bookTour">
        </div>
        <span class="bookTour"> <input value="Send" class="bookTour" onclick="return checktourbox();" type="submit" /> </span> 
    </div>
    <input name="cli_no" id="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden" /> 
    <input name="cli_days" id="cli_days" value="<?php echo $pd_tour->CLI_Days; ?>" type="hidden" /> 
    <input name="destinations" id="destinations" value="<?php echo $pd_tour->CLI2_PassCity; ?>" type="hidden" /> 
</form>