<link href="https://data.asiahighlights.com/min/?f=/css/lantern-form-pc.css" rel="stylesheet">
<body>
	<div class="wholeWrap">
		<div class="col-md-3 col-sm-3">
		</div>
		<div class="col-md-7 col-sm-7 hidden-xs">
			<div class="row">
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/ticket-select.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								Select services, ticket Type, quantity and date
							</div>
						</div>
					</div><div class="dotted"></div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/ticket-fill-form.png"
							alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								<strong>
									Provide your personal information
								</strong>
							</div>
						</div>
					</div><div class="dotted"></div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/ticket-pay.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								Make a payment
							</div>
						</div>
					</div><div class="dotted"></div>
				</div>
				<div class="workingSteps">
					<div class="col-md-6 col-sm-6">
						<div class="stepLogo">
							<img src="https://data.asiahighlights.com/image/ticket-get.png" alt="select ticket type">
						</div>
					</div>
					<div class="col-md-18 col-sm-18">
						<div class="detailedSteps">
							<div class="stepText">
								We get in touch with you within 24 hours with confirmation
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-14 col-sm-14">
		<form action="/orders/lantern_save" method="post" id="form_lantern" name="form_lantern">
			<div id="inquiryBox">
				<h2>
					Your Details...
				</h2>
				<div class="genderSelection">
					<form action="" method="GET">
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
					</form>
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
				<div class="formMemo">
					All your ticket issues will be sent to your mailbox.
				</div>
				<div class="inputTerm">
					<input type="text" name="Nationality" required>
					<label>
						Nationality / Region *
					</label>
				</div>
				<div class="inputTerm">
					<input type="text" name="PhoneNo">
					<label>
						Phone number (Area code + number. Only call if you ask.)
					</label>
				</div>
				<div class="checkYes">
					<input type="checkbox" value="Available on WhatsApp" name="whatsapp" id="whatsapp" class="checkBorder">
					<label for="whatsapp">
						This number is available on WhatsApp
					</label>
				</div>
				<textarea id="additionalrequirements" name="additionalrequirements" style="resize:none;" placeholder="ADDITIONAL REQUESTS... "></textarea>
				<div class="settleBlock">
					<div class="settlePart">
						<div class="settleItems">
							Location: <span class="totalPrice"><?php echo $location;?></span>
						</div>
						<div class="settleItems">
							Ticket Type: <span class="totalPrice"><?php echo $ticketonlyselection;?></span>
						</div>
						<div class="settleItems">
							Date of event: <span class="totalPrice"><?php echo $date;?></span>
						</div>
						<div class="settleItems">
							Number of people: <span class="totalPrice"><?Php echo $travelNumber;?></span>
						</div>
					</div>
					<div class="settleMponey">
						Total Price:
						<span class="totalPrice">
							USD <?php echo $totalprice;?>
						</span>
					</div>
				</div>
				<div class="clear">
				</div>
				<div class="inquiryBtn">
					<input type="submit" value="Pay Now">
				</div>
				<input type="hidden" name="location" value="<?php echo $location;?>"/>
				<input type="hidden" name="ticketype" value="<?php echo $ticketonlyselection;?>"/>
				<input type="hidden" name="date" value="<?php echo $date;?>"/>
				<input type="hidden" name="travelNumber" value="<?php echo $travelNumber;?>"/>
				<input type="hidden" name="totalprice" value="<?php echo $totalprice;?>"/>
				<input type="hidden" name="cli_sn" value="13349"/>
				<input type="hidden" name="url" value="<?php echo $orderfrom;?>" />
			</div>
			</form>
		</div>
		<div class="clear">
		</div>
	</div>
</body>