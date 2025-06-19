 <link href="/min/?f=/css/asia_tour_form.css" rel="stylesheet">
<form id="form_tour_detail" name="form_tour_detail" action="/orders/asia_tour" method="post">
    <div class="tourBox">
        <ul class="tourList">
            <li>
                Duration: <?php echo $pd_tour->CLI_Days; ?> days 
            </li>
            <li>
                Tour Code:<?php echo $pd_tour->CLI_NO; ?>
            </li>
            <li>
                Tour Type: Private Tours
            </li>
        </ul>
        <div class="promoPrice">
            <span class="moneyfrom">From:</span> <span class="moneyTyp">$</span><span class="bestPrice">#<?php echo $pd_tour->CLI_NO; ?>#</span> <a class="priceLink" href="#price">Price details</a> 
        </div>
        <div class="letterrow">
            Book This Tour
        </div>
        <div class="departTime">
            <span class="title"><span class="glyphicon glyphicon-calendar"></span> Date of Arrival:</span> 
            <input value="" name="Starting_Date" id="Starting_Date" class="arrivalDate datepicker" style="background-color:#FFF" placeholder="mm/dd/yy" /> 
        </div>
        <div class="traveller">
            <span class="title"><span class="glyphicon glyphicon-calendar"></span> Travelers </span>
        </div>
        <div class="row">
        
            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="traveller">
                     <select id="adultsNumber" name="adultsNumber" >
                     <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                            <?php } ?>
                                            <option value="6" >6+</option>        </select>
                                            
                                             <span class="title">  age  18+ </span>
                </div>
            </div>
           <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="traveller">
                     <select id="ChildrenNumber" name="ChildrenNumber"><option value="0">0</option><?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                            <?php } ?>
                                            <option value="6" >6+</option>        </select> <span class="title">  age  12-17 </span>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="traveller">
                     <select id="BabiesNumber" name="BabiesNumber"><option value="0">0</option><?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                            <?php } ?>
                                            <option value="6" >6+</option>        </select> <span class="title">  age  &lt;12 </span>
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