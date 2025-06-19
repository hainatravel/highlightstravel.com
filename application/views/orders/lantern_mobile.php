<link href="https://data.asiahighlights.com/min/?f=/css/lantern-mobile.css" rel="stylesheet">
<div id="formBanner">
	<img src="https://data.asiahighlights.com/image/lantern-form-mobile-banner.jpg"
	src="thailand lantern festival 2020" width="100%">
	<h1>
		Book Your Ticket(s)
	</h1>
	<div class="howWeWork">
		Make the inquiry and get your ticket confirmation within 24 hours.
	</div>
</div>
<div class="container">
	<div id="inquiryBox">
		<h2>
			Ticket Selection
		</h2>
		<form action="/orders/lantern_save" method="post" id="form_lantern" name="form_lantern">
		<div class="selectBox">
			<select id="tickettype" name="location" >
				<option value="selectlocation">
					- Select Location - *
				</option>
				<option value="Chiang Mai CAD">
					Chiang Mai CAD
				</option>
			</select>
		</div>
		<div class="selectBox">
			<select id="TicketStandard" name="TicketStandard">
				<option value="selectservice">
					- Select Services - *
				</option>
				<option value="ticketonly">
					Ticket Only
				</option>
				<option value="Ticket+ShuttleTransfer">
					Ticket + Shuttle Transfer (round trip)
				</option>
			</select>
		</div>
		<div class="selectBox">
			<select id="ticketonlyselection" name="ticketype">
				
			</select>
		</div>
		<div class="selectBox">
			<select id="selectdate" name="date">
				<option value="selecttype">
					- Select Date - *
				</option>
				<option value="31 Oct 2020">
					31 Oct 2020
				</option>
			</select>
		</div>
		<div class="selectionBlock">
			<h3>
				Number in your group *
			</h3>
			<div class="peopleSelect">
				<input class="number travelNumber" type="text" value="2" name="travelNumber" />
				<div class="numberBtn">
					<input class="minaddBtn minus" type="button" value="-" />
					<input class="minaddBtn plus" type="button" value="+" />
				</div>
			</div>
		</div>
		<div class="selectionBlock">
			<textarea id="additionalrequirements" name="additionalrequirements" style="resize:none;"
			placeholder="Tell us your additional request..."></textarea>
			<input type="hidden" name="totalprice" id="totalprice" value=""/>
		</div>
		<hr />
		<h2>
			Your Details
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
		<div class="inputTerm">
			<input type="text" name="fullname" required>
			<label>
				Full Name *
			</label>
		</div>
		<div class="inputTerm">
			<input type="email" name="email" required>
			<label>
				Email Address *
			</label>
		</div>
		<span class="formMemo">
			Your trip advisor will talk with you via email first.
		</span>
		<div class="inputTerm">
			<input type="text" name="Nationality" required>
			<label>
				Nationality *
			</label>
		</div>
		<div class="inputTerm">
			<input type="text" name="PhoneNo">
			<label>
				Phone number (area code + number)
			</label>
		</div>
		<div class="checkYes">
			<input type="checkbox" value="Available on WhatsApp" name="whatsapp" id="whatsapp"
			class="checkBorder">
			<label for="whatsapp">
				This number is available on WhatsApp
			</label>
		</div>
		<div class="settleBlock">
			<div class="settlePart">
				<div class="settleItems">
					Ticket Type: <span class="confirmNotice" style="color: #ad1818;"></span>
				</div>
				<div class="settleItems">
					Date of event: <span id="confirmdate" style="color: #ad1818;"></span>
				</div>
				<div class="settleItems">
					Number of people: <span class="confirmpeople" style="color: #ad1818;"></span>
				</div>
			</div>
			<div class="settleMponey">
				Total Price:
				<span class="priceDetail" style="color: #ad1818;">
					
				</span>
			</div>
		</div>
		<div class="inquiryBtn">
			<input type="submit" value="Pay Now">
		</div>
		<input type="hidden" name="cli_sn" value="13349"/>
		<input type="hidden" name="url" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />
		</form>
		<div class="contactUs">
			<p>
				Can't decide? Why not
				<a href="https://www.asiahighlights.com/contact-us.htm">
					contact us
				</a>
				for help!
			</p>
		</div>
	</div>
</div>
<script>
var nums = 2;
var level = 1;
$('.confirmpeople').html(nums + ' people');
totalprice();

//加减人数
$('.minus').click(function(){
	nums = $('.travelNumber').val();
	if(nums>0){
		nums--;
		$('.travelNumber').val(nums);
		$('.confirmpeople').html(nums + ' people');
		totalprice(level,nums);
	}
});
  
$('.plus').click(function(){
	nums = $('.travelNumber').val();
	nums++;
	$('.travelNumber').val(nums);
	$('.confirmpeople').html(nums + ' people');
	totalprice(level,nums);
});

//调整服务种类
$('#TicketStandard').change(function(){
	var selectype = $('#TicketStandard').val();
	var addoption = '';
	
	if(selectype == 'ticketonly'){
		addoption += '<option value="">--Select Ticket Type--</option>';
		addoption += '<option value="Premium Ticket">Premium Ticket</option>';
		addoption += '<option value="VIP Ticket">VIP Ticket</option>';
		addoption += '<option value="Standard Ticket">Standard Ticket</option>';
	}
	
	if(selectype == 'Ticket+ShuttleTransfer'){
		addoption += '<option value="">--Select Ticket Type--</option>';
		addoption += '<option value="Premium Ticket+Shuttle Transfer from Maya Shopping Center">Premium Ticket+Shuttle Transfer from Maya Shopping Center</option>';
		addoption += '<option value="VIP Ticket+Shuttle Transfer from Maya Shopping Center">VIP Ticket+Shuttle Transfer from Maya Shopping Center</option>';
		addoption += '<option value="Standard Ticket+Shuttle Transfer from Maya Shopping Center">Standard Ticket+Shuttle Transfer from Maya Shopping Center</option>';
	}
	
	$('#ticketonlyselection').html(addoption);
});

//确认票种
$('#ticketonlyselection').change(function(){
	var tyicketype = $('#TicketStandard').val();
	var ticketonlyselection = $('#ticketonlyselection').val();
	
	if(tyicketype != '' && ticketonlyselection != ''){
		$('.confirmNotice').html(ticketonlyselection);
		
		if(ticketonlyselection == 'Premium Ticket' || ticketonlyselection == 'Premium Ticket+Shuttle Transfer from Maya Shopping Center'){
			level = 3;
		}
		
		if(ticketonlyselection == 'VIP Ticket' || ticketonlyselection == 'VIP Ticket+Shuttle Transfer from Maya Shopping Center'){
			level = 2;
		}
		
		if(ticketonlyselection == 'Standard Ticket' || ticketonlyselection == 'Standard Ticket+Shuttle Transfer from Maya Shopping Center'){
			level = 1;
		}
		totalprice();
	}
});

//确认时间
$('#selectdate').change(function(){
	var selectdate = $(this).val();
	$('#confirmdate').html(selectdate);
});


//价格计算
function totalprice(){
	switch(level){
		case 1 :
			singleprice = 155;
			break;
		case 2 :
			singleprice = 195;
			break;
		case 3 :
			singleprice = 215;
			break;	
		default:
			singleprice = 155;
			break;
	}
	$('.priceDetail').html('USD ' + singleprice*nums);
	$('#totalprice').val(singleprice*nums);
}
</script>