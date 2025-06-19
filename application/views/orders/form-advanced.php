<style>
	.datepicker table tr td.disabled {
		color: #999;
	}
	#datalist{ font-size:14px; background: #fff;border: 1px solid #d1d1d1; min-height:50px;  max-height:200px;overflow-y:auto ; display: none;}
#datalist  li{  list-style-type:none}
#datalist  a { display: block; padding: 5px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;text-decoration:none}
</style>
<!-- Anti-flicker snippet (recommended)  -->
<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'OPT_CONTAINER_ID':true});</script>
<link href="https://data.asiahighlights.com/min/?f=/css/form-advanced.css" rel="stylesheet">
<article>
	<div id="formBanner">
		<h1>Start planning your journey</h1>
		<section>
			<div class="procedure hidden-xs">
				<div class="container">
					<span class="subTitle">How we create your itinerary</span>
					<div class="row">
						<div class="col-md-5 col-sm-5"><span class="listIcon">Use the form below
								to make an inqury
								with us</span></div>
						<div class="col-md-1 col-sm-1"><span class="whiteBorder"></span></div>
						<div class="col-md-5 col-sm-5"><span class="peopleIcon">We get in touch
								with you within 24
								hours with suggestions</span></div>
						<div class="col-md-1 col-sm-1"><span class="whiteBorder"></span></div>
						<div class="col-md-6 col-sm-6"><span class="emailIcon">We then craft
								an intinerary
								proposal based
								on your interests</span></div>
						<div class="col-md-1 col-sm-1"><span class="whiteBorder"></span></div>
						<div class="col-md-5 col-sm-5"><span class="handIcon">We work with you to
								refine the itinerary
								until you are satisfied</span></div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="container">
		<div class="row">
			<section>
				<div class="col-md-17 col-sm-17 col-xs-24">
					<div id="inquiryBox">
						<form action="<?php echo $action; ?>" method="post" id="form_tailormade" name="form_tailormade">
							<h2>Tell us about your travel plan</h2>
							<span class="labelTitle">Destination(s)<sup>*</sup></span>
							<div class="destinations" id="destinations">
								<ul>
									<?php
									foreach ($countrylist as $value) {
										if (in_array($value, $countryarr)) {
											echo '<li class="checked" name="' . $value . '"><label><input type="hidden" value="' . $value . '"> ' . $value . '</label></li>';
										} else {
											echo '<li name="' . $value . '"><label><input type="hidden" value="' . $value . '"> ' . $value . '</label></li>';
										}
									}
									echo '</ul>';
									echo '<input type="hidden" value="" name="Destination"/>';
									echo '</div><div class="clearfix"></div>';
									if (isset($ic_title)) {
										echo '<span class="interestedIn" style="font-style:italic;">Interested in the itinerary : ”' . $ic_title . '”</span>';
										echo '<input type="hidden" name="ic_title" value="' . $ic_title . '"/>';
									}

									?>

									<span class="labelTitle">Date of arrival <sup>*</sup></span>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-24">
											<input type="text" class="arrivalDate datepicker hidden-xs" id="Date_Start" name="Date_Start" value="" placeholder="mm/dd/yyyy" autocomplete="off">
											<input type="date" class="arrivalDate visible-xs" id="Date_Start" name="Date_Start_Mobile" value="<?php echo date('Y-m-d',time() + 518400)?>" min="<?php echo date('Y-m-d',time() + 518400)?>" placeholder="mm/dd/yyyy" autocomplete="off">
										</div>
										<div class="col-md-12 col-sm-12 col-xs-24" style="padding-left:40px">
											<li class="flexibleDate">
												<label><input type="hidden"> I'm flexible on the date</label>
												<input type="hidden" name="FlexibleDate" value="No" />
											</li>
										</div>
									</div>
									<span class="labelTitle">Hotel style <sup>*</sup>
										<div class="hotelStyle" id="hotelStyle">
											<p style="font-size=14px;color:#999;">*Hotels prices in Japan are at least doubled based on the suggested rates below.</p>
											<ul>
												<li name="Luxury (5 stars & up)"><label><input type="hidden" value="Luxury" id="fiveStar"> Luxury (5 stars & up) <em>USD 200+ / room / night</em></label></li>
												<li name="Handpicked Comfort (4-5 stars)"><label><input type="hidden" value="Handpiched Comfort" id="fourStar">
														Handpicked Comfort (4-5 stars) <em>USD 100-200 / room / night</em></label></li>
												<li name="Standard (3 stars)"><label><input type="hidden" value="Standard" id="threeStar">
														Standard (3 stars)<em>USD 70-100 / room / night</em></label></li>
											</ul>
											<input type="hidden" value="" name="hotelStyle" />
										</div>
										<span class="labelTitle">Tell us more to help us put together your ideal journey <sup>*</sup> </span>
										<textarea id="additionalrequirements" name="additionalrequirements" style="resize:none;" placeholder="E.g. Number of travelers, age range, duration, first time to Asia, family oriented, anniversary, vacation, business, your interests - culture, history, adventure, nature, food, photography, etc"></textarea>
							</div>
							<div id="contactInfo">
								<h2>Your details</h2>
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-24"><span class="subTitle">Title <sup>*</sup></span>
										<select id="gender" name="gender" style="height:38px;background-position:center right 10px;">
											<option value=""></option>
											<option value="100001">Mr</option>
											<option value="100004">Mx</option>
											<option value="100003">Ms</option>
										</select>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-12">
										<span class="subTitle">First name <sup>*</sup></span>
										<input style="width:90%;" type="text" class="firstname" type="text" name="Firstname" id="Firstname">
									</div>
									<div class="col-md-10 col-sm-10 col-xs-12">
										<span class="subTitle">Last name <sup>*</sup></span>
										<input style="width:90%;" type="text" class="lastname" type="text" name="Lastname" id="Lastname">
									</div>
									<div class="clearfix"></div>
									<div class="col-md-12 col-sm-12 col-xs-24">
										<span class="labelTitle">Email address <sup>*</sup></span>
										<input type="email" name="email" id="email">
									</div>
									<div class="clearfix"></div>
									<div class="col-md-12 col-sm-12 col-xs-24" id="fillNationality">
										<span class="labelTitle">Nationality<sup>*</sup></span>
										<input  type="text" name="Nationality" id="Nationality"  placeholder="United States">
										<div id="datalist">
										</div>
										
									</div>
								
									<div class="clearfix"></div>
									<div class="col-md-12 col-sm-12 col-xs-24">
										<span class="labelTitle">Phone number</span>
										<input type="tel" placeholder="(+1)" class="telephone" name="PhoneNo" id="PhoneNo">
									</div>
									<div class="col-md-12 col-sm-12 col-xs-24">
										<span class="onlyCall">Only call if you ask, or for email issues</span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-14 col-sm-14 hidden-xs"></div>
								<div class="col-md-10 col-sm-10 col-xs-24">
									<div class="submitBtn">
										<span class="beginNow"><a style="cursor:pointer;" onclick="submitForm('form_tailormade');">Begin my journey <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
										We never pass your information onto a third party. After submitting this form you will receive an email confirmation and from time to time our newsletters.
									</div>
								</div>
							</div>
					</div>
			</section>
			<aside>
				<div class="col-md-7 col-sm-7 hidden-xs">
					<div class="formTrust">
						<h2>Recognized</h2>
						<img src="/pic/featured-in.png" class="img-responsive">
						<div class="monkReview">
							"I can definitely recommend Asia Highlights and Albee if you are planning to book a trip to Myanmar and I will use them again if we are going to travel to any of the destinations on offer."
							<b>Frank S</b>
						</div>
					</div>
				</div>
			</aside>
			<?php if (isset($cli_no)) { ?>
				<input type="hidden" name="cli_no" value="<?php echo $cli_no ?>" />
			<?php } ?>
			<?php if (isset($cli_sn)) { ?>
				<input type="hidden" name="cli_sn" value="<?php echo $cli_sn ?>" />
			<?php } ?>
			<?php if (isset($cli_days)) { ?>
				<input type="hidden" name="cli_days" value="<?php echo $cli_days ?>" />
			<?php } ?>
			<input type="hidden" name="url" value="" />
			</form>
		</div>
	</div>
</article>


<script>

		$(function() {
			var nationality_maps = ["United Kingdom","Argentina","Australia","Austria", "Belgium", "Brazil","Bulgaria", "Canada", "Chile","China","China HK",  "Colombia","Costa rica", "Croatia", "Cyprus", "Czech republic", "Denmark", "Dominica", "Dominican republic", "Ecuador",  "Fiji", "Finland","France", "Georgia", "Germany", "Ghana",  "Greece", "Honduras",  "Hungary","Iceland", "India", "Indonesia", "Ireland",  "Israel", "Italy", "Japan", "luxembourg", "Macau","Malaysia", "Malta","Mexican", "Netherlands","New Zealand", "Norway", "Philippines", "Poland", "Portugal", "Puerto rico", "Qatar", "Romania",  "Scotland" ,"Singapore", "South Africa", "Spain", "Sweden", "Switzerland", "Trinidad and Tobago","United Arab Emirates","United States",];
	　　　  var b=nationality_maps.join("-");   //b="0-1-2-3-4-5"  
			var a=b.toLowerCase( );
	　　　  var nationality_map=a.split("-"); //在-分解
    	var ele_key = document.getElementById("Nationality");
        ele_key.onkeyup = function (e) {
        var val = this.value;
        var srdata = [];
        for (var i = 0; i < nationality_map.length; i++) {
            if ( nationality_map[i].indexOf(val) > -1) {
            srdata.push(nationality_map[i]);
            }
        }
        //获取到的数据准备追加显示, 前期要做的事情: 清空数据,然后显示数据列表,如果获取到的数据为空,则不显示
        var ele_datalist = document.getElementById("datalist");
        ele_datalist.style.display = "block";
        ele_datalist.innerHTML = "";
        
        if (srdata.length == 0) {
            ele_datalist.style.display = "none";
        }
    
    //将搜索到的数据追加到显示数据列表, 然后每一行加入点击事件, 点击后将数据放入搜索框内, 数据列表隐藏
        var self = this;
        for (var i = 0; i < srdata.length; i++) {
            var ele_li = document.createElement("li");
            var ele_a = document.createElement("a");
            ele_a.setAttribute("href", "javascript:;");
            ele_a.textContent = srdata[i];
        
            ele_a.onclick = function () {
            self.value = this.textContent;
            ele_datalist.style.display = "none";
            }
        
        
            ele_li.appendChild(ele_a);
            ele_datalist.appendChild(ele_li);
        }
    }




		$("input[name='url']").val(document.referrer);

		//目的地选择效果
		$('.destinations li').click(function() {
			$('#destinations').tooltip('hide');
			if ($(this).hasClass('checked')) {
				$(this).removeClass('checked');
			} else {
				$(this).addClass('checked');
			}
		});

		//flexibleDate选择效果
		$('.flexibleDate').click(function() {
			if ($(this).hasClass('checked')) {
				$(this).removeClass('checked');
				$('input[name="FlexibleDate"]').val('No');
			} else {
				$(this).addClass('checked');
				$('input[name="FlexibleDate"]').val('Yes');
			}
		});

		//Hotel style选择效果
		$('.hotelStyle li').click(function() {
			$('#hotelStyle').tooltip('hide');
			if ($(this).hasClass('checked')) {
				$(this).removeClass('checked');
				$('input[name="hotelStyle"]').val('');
			} else {
				$('.hotelStyle li').removeClass('checked');
				$(this).addClass('checked');
				$('input[name="hotelStyle"]').val($(this).attr('name'));
			}
		});

		//---------------------------------------隐藏提示信息------------------------------------------------------
		$('#additionalrequirements').click(function() {
			$('#additionalrequirements').tooltip('hide');
		});

		$('#gender').click(function() {
			$('#gender').tooltip('hide');
		});

		$('#Firstname').click(function() {
			$('#Firstname').tooltip('hide');
		});

		$('#Lastname').click(function() {
			$('#Lastname').tooltip('hide');
		});

		$('#Nationality').click(function() {
			$('#Nationality').tooltip('hide');
		});

		$('#email').click(function() {
			$('#email').tooltip('hide');
		});

		//------------------------------------隐藏提示信息------------------------------------------------------	

		$('input[name="Nationality"]').bind("input propertychange change", function(event) {
			if ($(this).val() == 'United States') {
				$("#PhoneNo").val('+1');
			} else {
				$("#PhoneNo").val('');
				$("#PhoneNo").attr('placeholder', '');
			}
		});

		//动态给目的地后面添加图标
		for (var i = 0; i < 5; i++) {
			$($('#destinations li')[i]).children().append('<img class="recommended" src="/pic/recommended.png" style="padding-left: 5px;padding-bottom: 5px;"/>');
		}

		$('.recommended').popover({
			trigger: 'hover',
			content: 'Highly recommended',
			placement: 'auto top'
		});
	});
</script>
