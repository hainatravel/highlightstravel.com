<div id="form_tour_detail">
	<div class="fixedNav">
		<form action="/orders/quick_inquiry_save" method="post">
			<div class="priceBlock"><h2>Inquire Now</h2>
				<input name="name" type="text" id="realname" value="" placeholder="Full name" class="FullName" required>
				<input name="email" type="text" id="email" value="" placeholder="Email" class="EmailAddress" required>
				<input type="text" id="starting_date" name="starting_date" value="" placeholder="Starting date" readonly="readonly" class="InquiryCalendar datepicker">
				<input type="tel" value="" name="PhoneNo" id="PhoneNo" placeholder="Phone number" class="Inquiryphone">
				<textarea id="form_additionalrequirements" style="height:100px;" name="form_additionalrequirements" placeholder="How many people, hotel style and changes to make... "></textarea>
				<button type="submit" id="submit_booking_form_inquiry" name="booking_form_inquiry_list" class="sendButton">
					Send My Inquiry
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</button>
				<?php 
				if(isset($pd_tour->CLI_SN) && isset($pd_tour->CLI_NO)){?>
					<input type="hidden" name="cli_sn" value="<?php echo $pd_tour->CLI_SN; ?>"/>
					<input name="cli_no" value="<?php echo $pd_tour->CLI_NO; ?>" type="hidden" /> 
				<?php }?>
				<input name="ic_title" value="<?php echo $detail->ic_title; ?>" type="hidden" /> 
			</div>
		</form>
	</div>
</div>