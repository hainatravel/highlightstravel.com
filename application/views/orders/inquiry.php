<link href="/css/inquiry-pc.css" rel="stylesheet">
<div class="wholeWrap">
	<div class="col-md-3 col-sm-3"></div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="stpeBlock">
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/ticket-select.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								<strong>
									Use the form below to make an inqury with us
								</strong>
							</div>
						</div>
					</div>
					<div class="dotted">
					</div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/get-matched.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								We get in touch with you within 24 hours with suggestions
							</div>
						</div>
					</div>
					<div class="dotted">
					</div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/craft-journey.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								We then craft an intinerary proposal based on your interests
							</div>
						</div>
					</div>
					<div class="dotted">
					</div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/deal-journey.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								We work with you to refine the itinerary until you are satisfied
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-1 col-sm-1">
	</div>
	<div class="col-md-14 col-sm-14">
		<div id="inquiryBox">
			<h1>
				Start Planning Your Trip
			</h1>
			<div class="howWeWork">
				Tell us your interests and get replied within 24 hours...
			</div>
			<div class="interestedRoute">
				<div class="headerText">
					INTERESTED ITINERARY
				</div>
				<div class="routeName">
					<?php echo $ic_title;?>
				</div>
			</div>
			<h3>
				Destinations: <span class="destination"><?php foreach ($countryarr as $city){echo $city.',';}?></span>
			</h3>
			<form action="/orders/inquiry_save" method="post" id="inquiry" name="inquiry">
			<input id="check" type="checkbox" class="hidden">
			<div class="foldDestinations">
				<div class="readMore">
					<div class="selectionBlock">
						<div class="row">
						<?php foreach ($countrylist as $moreCity){
						echo '<div class="col-md-8 col-sm-8">';
						echo '<div class="checkboxLabel">';
						if(in_array($moreCity,$countryarr)){
							echo '<input type="checkbox" value="'.$moreCity.'" id="'.$moreCity.'" name="destination[]" checked="checked" />';
						}else{
							echo '<input type="checkbox" value="'.$moreCity.'" id="'.$moreCity.'" name="destination[]" />';
						}
						echo '<label for="'.$moreCity.'" class="updatedestination">'.$moreCity.'</label></div></div>';
					}?>
							
						</div>
						<span class="chooseothers">
							You are welcome to input other destinations below if it is not shown here.
						</span>
					</div>
				</div>
			</div>
			<label for="check" class="check-in">
				Choose more destinations
				<i class="fa fa-angle-down" aria-hidden="true">
				</i>
			</label>
			<label for="check" class="check-out">
				Fold
				<i class="fa fa-angle-up" aria-hidden="true">
				</i>
			</label>
			<div class="clear">
			</div>
			<div class="selectionBlock">
				<h3 id="hotelselect">
					Your hotel preference * <span id="hotel_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please select an option.)</span>
				</h3>
				<span class="formNote">
					Hotels prices in Japan are at least doubled based on the suggested rates
					below.
				</span>
				<div class="selectHotl">
						<div class="optionLable">
							<input type="radio" value="Luxury" id="fiveStar" name="hotel">
							<label for="fiveStar" class="hotelText">
								Luxury (5 stars & up)
								<div class="selectionMemo">
									USD 200+ / night
								</div>
							</label>
						</div>
						<div class="optionLable">
							<input type="radio" value="Handpicked Comfort 4-5star" id="fourStar" name="hotel">
							<label for="fourStar" class="hotelText">
								Handpicked Comfort (4-5 stars)
								<div class="selectionMemo">
									USD 100-200 / night
								</div>
							</label>
						</div>
						<div class="optionLable">
							<input type="radio" value="Standard 3 star" id="threeStar" name="hotel">
							<label for="threeStar" class="hotelText">
								Standard (3 stars)
								<div class="selectionMemo">
									USD 70-100 / night
								</div>
							</label>
						</div>
				</div>
			</div>
			<div class="selectionBlock">
				<h3 id="numberselect">
					Number in your group * <span id="number_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please fill out this field.)</span>
				</h3>
				<div class="peopleSelect">
					<span class="formMemo">
						Adults (≥12 years old)
					</span>
					<div class="numberBtn">
						<input class="minaddBtn reduceadult" type="button" value="-" />
						<input class="number" type="text" value="2" name="adultnumber" />
						<input class="minaddBtn addadult" type="button" value="+" />
					</div>
				</div>
				<div class="peopleSelect">
					<span class="formMemo">
						Kids (2-11 years old)
					</span>
					<div class="numberBtn">
						<input class="minaddBtn reducechild" type="button" value="-" />
						<input class="kidNum" type="text" value="0" name="kidnumber" />
						<input class="minaddBtn addchild" type="button" value="+" />
					</div>
				</div>
				<div class="clear">
				</div>
			</div>
			<div class="selectionBlock">
				<h3 id="dateselect">
					Your date of arrival * <span id="date_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please fill out this field.)</span>
				</h3>
				<input type="text" class="arrivalDate datepicker hidden-xs" id="Date_Start"
				name="Date_Start" value="" placeholder="mm/dd/yyyy" autocomplete="off">
				<div class="checkYes">
					<input type="checkbox" class="checkBorder" id="dateLimit" name="time">
					<label for="dateLimit">
						I'm flexible on the date
					</label>
				</div>
			</div>
			<div class="selectionBlock">
				<h3>
					Tell us more to help us put together your ideal journey.
				</h3>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="family" id="familytrip" name="grouptype[]">
						<label for="familytrip">
							<div class="smallTag">
								<div class="styleText">
									Family
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="couple" id="cp" name="grouptype[]">
						<label for="cp">
							<div class="smallTag">
								<div class="styleText">
									Couple
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="solo" id="single" name="grouptype[]">
						<label for="single">
							<div class="smallTag">
								<div class="styleText">
									Solo
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="friends" id="mate" name="interests[]">
						<label for="mate">
							<div class="smallTag">
								<div class="styleText">
									Friends
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="vacation" id="holiday" name="grouptype[]">
						<label for="holiday">
							<div class="smallTag">
								<div class="styleText">
									Vacation
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="adventure" id="risk" name="interests[]">
						<label for="risk">
							<div class="smallTag">
								<div class="styleText">
									Adventure
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="food" id="gourmet" name="interests[]">
						<label for="gourmet">
							<div class="smallTag">
								<div class="styleText">
									Food
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="asiabeginner" id="firstasia" name="interests[]">
						<label for="firstasia">
							<div class="smallTag">
								<div class="styleText">
									First time to Asia
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="localculture" id="culture" name="interests[]">
						<label for="culture">
							<div class="smallTag">
								<div class="styleText">
									Culture&History
								</div>
							</div>
						</label>
					</div>
					<div class="travelStyle travelTag">
						<input type="checkbox" value="relax" id="rest" name="interests[]">
						<label for="rest">
							<div class="smallTag">
								<div class="styleText">
									Rest&relaxation
								</div>
							</div>
						</label>
					</div>
				<textarea id="additionalrequirements" name="additionalrequirements" style="resize:none;" placeholder="E.g. Age range, duration, group situation, your travel style, which cities you would like to go, special requests..."></textarea>
			</div>
			<hr>
			<h2>
				Tell us about you...
			</h2>
			<div class="genderSelection">
					<div class="checkboxGender">
						<input type="radio" value="100001" id="male" name="gender">
						<label for="male">
							Mr.
						</label>
					</div>
					<div class="checkboxGender">
						<input type="radio" value="100003" id="female" name="gender">
						<label for="female">
							Ms.
						</label>
					</div>
					<div class="checkboxGender">
						<input type="radio" value="100004" id="neutural" name="gender">
						<label for="neutural">
							Mx.
						</label>
					</div>
			</div>
			<span id="name_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please fill out this field.)</span>
			<div class="inputTerm">
				<input type="text" name="name" required>
				<label>
					Full Name *
				</label>
			</div>
			<span id="email_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please fill out this field.)</span>
			<div class="inputTerm">
				<input type="email" name="email" required>
				<label>
					Email Address *
				</label>
			</div>
			<div class="formMemo">
				All your ticket issues will be sent to your mailbox.
			</div>
			<span id="nation_error_msg" style="color:#a31022;font-size:18px;" class="hidden">(Please fill out this field.)</span>
			<div class="inputTerm">
				<input type="text" name="Nationality" required>
				<label>
					Nationality / Region *
				</label>
			</div>
			<div class="inputTerm">
				<input type="text" name="PhoneNo">
				<label>
					Phone number
				</label>
			</div>
			<div class="formMemo">
				Area code + number. Only call if you ask.
			</div>
			<div class="checkYes">
				<input type="checkbox" value="Available on WhatsApp" name="whatsapp" id="whatsapp"
				class="checkBorder">
				<label for="whatsapp">
					This number is available on WhatsApp
				</label>
			</div>
			<div class="clear">
			</div>
			<div class="inquiryBtn">
				<button id="tmsubmit" href="javascript:;">Start My Journey</button>
			</div>
			<input type="hidden" name="url" value="<?php echo $orderfrom;?>" />
			<input type="hidden" name="cli_sn" value="<?php echo $this->input->get_post('cli_sn');?>" />
			<input type="hidden" name="ic_title" value="<?php echo $ic_title;?>" />
			</form>
		</div>
	</div>
	<div class="clear">
	</div>
</div>
<script>
$(function(){
	var adultnums = $('input[name="adultnumber"]').val();
	var kidnums = $('input[name="kidnumber"]').val();
	//成人人数加减
	$('.addadult').click(function(){
		adultnums++;
		$('input[name="adultnumber"]').val(adultnums);
	});
	
	$('.reduceadult').click(function(){
		if(adultnums > 0){
			adultnums--;
			$('input[name="adultnumber"]').val(adultnums);
		}
		
	});
	
	//加减儿童人数
	$('.addchild').click(function(){
		kidnums++;
		$('input[name="kidnumber"]').val(kidnums);
	});
	
	$('.reducechild').click(function(){
		if(kidnums > 0){
			kidnums--;
			$('input[name="kidnumber"]').val(kidnums);
		}
		
	});
	
	//更新目的地
	$('.updatedestination').click(function(){
		var destinantionstr = '';
		var selectdes = $(this).prev().val();
		for(var i=0;i<$('input[name="destination[]"]').length-1;i++){
			if(selectdes != $($('input[name="destination[]"]')[i]).val()){
				if($($('input[name="destination[]"]')[i]).is(':checked')){
					destinantionstr += $($('input[name="destination[]"]')[i]).val() + ',';
				}
			}
		}
		if($(this).prev().is(':checked')){
			destinantionstr = destinantionstr.substr(0,destinantionstr.length-1);
		}else{
			destinantionstr += selectdes;
		}
		
		$('.destination').html(destinantionstr);
	});
	
	//表单验证
	$('#tmsubmit').click(function(){
		var adultnumber = $('input[name="adultnumber"]').val();
		var hotel = $('input[name="hotel"]:checked').val();
		var name = $('input[name="name"]').val();
		var email = $('input[name="email"]').val();
		var Nationality = $('input[name="Nationality"]').val();
		var date = $('input[name="Date_Start"]').val();
		
		//酒店选择
		if(hotel === undefined){
			$("body,html").animate({
                scrollTop: $('#hotelselect').offset().top - 70
            });
			$('#hotel_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#hotel_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
		//人数选择
		if(adultnumber < 1){
			$("body,html").animate({
                scrollTop: $('#numberselect').offset().top - 70
            });
			$('#number_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#number_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
		//时间选择
		if(date == ''){
			$("body,html").animate({
                scrollTop: $('#dateselect').offset().top - 70
            });
			$('#date_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#date_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
		//姓名验证
		if(name == ''){
			$('input[name="name"]').focus();
			$('#name_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#name_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
		//邮箱验证
		if(email == ''){
			$('input[name="email"]').focus();
			$('#email_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#email_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
		//国籍验证
		if(Nationality == ''){
			$('input[name="Nationality"]').focus();
			$('#nation_error_msg').removeClass('hidden');
			setTimeout(function(){
				$('#nation_error_msg').addClass('hidden');
			},5000);
			return false;
		}
		
	});
});
</script>