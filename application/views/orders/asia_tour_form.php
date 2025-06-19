 <link href="/min/?f=/css/asia_tour_form.css,/css/tailor-make.css" rel="stylesheet">
<script language="javascript">

    $(function () {
        $("#flexible_date_yes").click(function () {
            $('#choose_date_box').show();
        });

        $("#flexible_date_no").click(function () {
            $('#choose_date_box').hide();
        });
		
		$("#show_arrowUp").mouseover(function () {
            $('#arrowUp').show();
        });
		$("#show_arrowUp").mouseout(function () {
            $('#arrowUp').hide();
        });
		
    })
</script>

<div id="inquiryForm">
    <div class="container">
        <div class="row">

            <div class="col-md-2 col-sm-2 hidden-xs"></div>
            <div class="col-md-3 col-sm-3 col-xs-6 pgHead"><img src="/image/peggie.png" class="img-responsive"></div>
            <div class="col-md-19 col-sm-19 col-xs-18"> <span class="advisorInfo"> <span class="arrow"></span> I'm Peggie, my team and I are SE Asia travel experts! Just let us know your requirements 
                    and my team will reply to you in a few hours, maximum 24 hours!</span>

            </div>
            <div class="clearfix"></div>
            <div class="col-md-5 col-sm-5 hidden-xs"></div>
            <div class="col-md-19 col-sm-19 col-xs-24">
                <form id="form_inquiry" name="form_inquiry" action="/orders/asia_tour_save" method="post" >
                    <div class="FormDetail">
                        <div class="row TourInfo">
                            <div class="col-md-7 col-sm-7 InquiryOn">You are inquiring on:</div>
                            <div class="col-md-17 col-sm-17 tourDetail">
                                <ul>
                                    <li><span class="detailName">Tour Code:</span><?php echo $post_cli_no; ?></li>
                                    <li><span class="detailName">Length:</span><?php echo $post_days; ?></li>
                                    <li><span class="detailName">Destinations:</span><?php echo $post_destinations; ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="whoTravel">
                            <h2 class="Question">1. Travelers? <sup>*</sup></h2>
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-24">
                                    <div class="groupType adults"> Adults (age 18+)
                                        <select id="adultsNumber" name="adultsNumber">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            	
                                                <option value="<?php echo $i; ?>"  
												  <?php if($adultsNumber == $i){?>selected="selected"<?php }?> 
                                                 ><?php echo $i; ?></option>
                                                
                                            <?php } ?>
                                            <option value="6" <?php if($adultsNumber == 6){?>selected="selected"<?php }?> >6+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-24">
                                    <div class="groupType youth"> Youth (age 12-17)
                                        <select id="ChildrenNumber" name="ChildrenNumber">
                                            <?php for ($i = 0; $i <= 5; $i++) { ?>
                                                <option value="<?php echo $i; ?>" 
                                                <?php if($ChildrenNumber == $i){?>selected="selected"<?php }?> 
                                                ><?php echo $i; ?></option>
                                            <?php } ?>
                                            <option value="6" <?php if($ChildrenNumber == 6){?>selected="selected"<?php }?> >6+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-24">
                                    <div class="groupType kids"> Children (&lt; age 12)
                                        <select id="BabiesNumber" name="BabiesNumber">
                                            <?php for ($i = 0; $i <= 5; $i++) { ?>
                                                <option value="<?php echo $i; ?>" 
                                                <?php if($BabiesNumber == $i){?>selected="selected"<?php }?> 
                                                ><?php echo $i; ?></option>
                                            <?php } ?>
                                            <option value="6" <?php if($ChildrenNumber == 6){?>selected="selected"<?php }?> >6+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="formItem">
                            <div class="Question">2. Date of Arrival<sup>*</sup></div>
                            <div class="row">
                                <div class="col-md-10 col-sm-10">
                                    <input type="text" autocomplete="off" placeholder="mm/dd/yyyy" value="<?php echo $post_Starting_Date; ?>" name="starting_date" id="starting_date" class="arrivalDate datepicker">
                                </div>
                                <div class="col-md-14 col-sm-14"><span class="dateFlexible">Are your dates flexible?</span> <br>
                                    <input type="radio" name="flexible_date" id='flexible_date_yes_1' value="yes" class="hotel">
                                    Yes
                                    <input type="radio" name="flexible_date" id="flexible_date_no_1" value="no" class="hotel">
                                    No </div>
                            </div>
                            <div id='choose_date_box' style="display:none;">
                                <div class="Flexible">Flexible to arrive or depart? Choose the date!</div>
                                <div class="row ChooseDate">
                                    <div class="col-md-3 col-sm-3">Arrive:</div>
                                    <div class="col-md-21 col-sm-21">
                                        <input type="text" name="Arrive_date" id="Arrive_date" value="" class="flexibleDate datepicker">
                                    </div>
                                </div>
                                <div class="row ChooseDate">
                                    <div class="col-md-3 col-sm-3">Depart:</div>
                                    <div class="col-md-21 col-sm-21">
                                        <input type="text" name="Depart_date" id="Depart_date" value="" class="flexibleDate datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hotelBlock">
                            <h2 class="Question">3. Hotel Style <sup>*</sup>
                                <small>
                                    <a href="javascript:void(0);" id="show_arrowUp" title=""><font color="#AE0000">(what's this?)</font></a>
                                    <div class="hint" id="arrowUp" style="display: none" >
                                <span class="arrowUp"></span>
                                Instead of ranking hotels in a traditional way, Asia Highlights carefully inspects some selected hotels into 3 styles. Each style ensures good location, nice service and unique SE Asian style. 
                                </div>
                                </small>
                                
                            </h2>
                            <div class="row">
                                <div class="col-md-8 col-sm-24">
                                    <label for="hotel">
                                        <div class="hotelStyle luxury">
                                            <input name="hotel" type="radio" value="Luxury (5 stars & up)" id="hotel">
                                           Luxury (5 stars & up) <span class="priceRange">USD 200+/room/night</span> </div>
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-24">
                                    <label for="fourStar">
                                        <div class="hotelStyle boutique">
                                            <input name="hotel" type="radio" value=" Handpicked Comfort (4-5 stars) " id="fourStar">
                                            Handpicked Comfort (4-5 stars) <span class="priceRange">USD 100-200/room/night</span> </div>
                                    </label>
                                </div>

                                <div class="col-md-8 col-sm-24">
                                    <label for="threeStar">
                                        <div class="hotelStyle comfort">
                                            <input name="hotel" type="radio" value="Standard (3 star) " id="threeStar">
                                            Standard (3 star) <span class="priceRange">USD 50-100/room/night </span> </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="formItem">
                            <div class="Question">4. What do you expect for this trip?<sup>*</sup></div>
                            <textarea placeholder="Tell us more to help us understand you better. How can we make it extra special?" onblur="hideTips('sCustominfoTipsid')" name="additionalrequirements" id="additionalrequirements"  class="ExpectTrip col-md-22 col-sm-22"></textarea>
                            <div class="clear"></div>
                        </div>
                        <div class="Question">5. Contact Details<sup>*</sup></div>
                        <div class="row">
                            <div class="personalInfo col-md-10 col-sm-10">
                                <div class="input-group margin-bottom-sm"> <span class="input-group-addon">
                                        <select id="gender" name="gender">
                                            <option value="100001"> Mr.</option>
                                            <option value="100003"> Ms.</option>
                                        </select>
                                    </span>
                                    <input type="text" id="realname" name="realname" placeholder="Full Name*" class="form-control fullname">
                                </div>
                            </div>
                            <div class="personalInfo col-md-10 col-sm-10">
                                <div class="input-group margin-bottom-sm"> <span class="input-group-addon"><i class="fa fa-globe"></i></span> <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    <input type="text" id="nationality" name="nationality" placeholder="Nationality*" class="form-control nationality ui-autocomplete-input typeahead_nationality typeahead" >
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="personalInfo col-md-10 col-sm-10">
                                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input type="email" id="email" name="email" placeholder="Email*" class="form-control email">
                                </div>
                                <span class="noSpam hidden-xs hidden-sm">We never spam you or sell your address.</span> </div>
                            <div class="personalInfo col-md-10 col-sm-10 col-xs-23">
                                <div class="input-group margin-bottom-sm"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="tel" id="PhoneNo" name="PhoneNo" placeholder="+country code and number." class="form-control telephone">
                                </div>
                                <span class="noSpam hidden-xs hidden-sm">Only call you if you ask, or for email issues.</span> </div>
                        </div>
                        <div class="sendInquiry row">
                            <div class="col-md-7 col-md-7 hidden-xs"></div>
                            <div class="col-md-10 col-sm-10 col-xs-24">
                                <input type="button" id="js_nextsteps" value="Send my inquiry" onclick="submitForm('form_inquiry');" />
                            </div>
                            <div class="col-md-7 col-md-7 hidden-xs"></div>
                        </div>
                    </div>
                    <input type="hidden" name="cli_no" value="<?php echo $post_cli_no; ?>" />
                    <input type="hidden" name="cli_sn" value="<?php echo $post_cli_sn; ?>" />
                    <input type="hidden" name="cli_days" value="<?php echo $post_days; ?>" />
                    <input type="hidden" name="destinations" value="<?php echo $post_destinations; ?>" />
                </form>
            </div>
        </div>
    </div>