<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><meta name="robots" content="noindex,nofollow" /><title>Customers Email Review - China Highlights</title></head>';
echo '<body style="color: #333; margin: 20px 0px; padding: 0px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;">';
echo '<div style="width:740px; display: block; background:#e8e8e8; padding:12px; margin:25px auto 10px; overflow: hidden;">';
echo '<div class="ahInfo" style="background:#fff; width:350px; display: block; float: left; border-right: 1px solid #d1d1d1; padding:35px 25px; height:395px; position:relative;">';
echo '<img src="https://www.asiahighlights.com/pic/thankyou-title.png"/>';
echo '<p style=" font-size:14px; line-height:22px; margin-bottom:10px;">One of our specialists will go through your travel plan 
and contact you within 24 hours. </p>';
echo '<p style=" font-size:14px; line-height:22px; margin-bottom:10px;">Here is a general frame of your inquiry. Let us know if 
it is incorrect or you need to make any changes.</p>';
echo '<p style=" font-size:14px; line-height:22px; margin-bottom:10px;">Thank you once again for choosing Asia Highlights. </p>';
echo '<p style=" font-size:14px; line-height:22px; margin-bottom:40px;">Kind Regards,</p>';
echo '<img src="https://www.asiahighlights.com/pic/ah-team.png"/><div style="display:block;float: right;"><img src="https://data.asiahighlights.com/pic/logo-104.png"></div>';
echo '<span style="display: block; margin-top:40px;"><a style="color:#555;" href="//www.asiahighlights.com">www.asiahighlights.com</a></div></span>';
echo '<div class="customerInfo" style=" background:#f8f8f8; height:100%; display: block; width:309px; float: right; padding:15px; height:435px;"><ul style="margin-left:10px; padding-left:15px;">';
echo '<li style="list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555;font-size:16px; display: block; margin:10px 0 15px;">Your travel plans</li>';
echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="margin-left: 0;font-weight: normal; color:#999;">Destination:</strong>'.$this->input->post('Destination').'</li>';
if(!empty($this->input->post('ic_title'))){
	echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Interested in the itinerary:</strong> ”'.$this->input->post('ic_title').'”</li>';
}
if(empty($this->input->post('Date_Start'))){
	echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Date of arrival:</strong>'.$this->input->post('Date_Start_Mobile').'</li>';
}else{
	echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Date of arrival:</strong>'.$this->input->post('Date_Start').'</li>';
}

echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Hotel style:</strong>'.$this->input->post('hotelStyle').'</li>';
echo '<li style="font-size:16px; display: block; margin:20px 0 15px;">Your details</li>';
if($this->input->post('gender') == '100001'){
	echo '<li style="margin-left:0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Title:</strong>Mr</li>';
}elseif($this->input->post('gender') == '100003'){
	echo '<li style="margin-left:0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Title:</strong>Ms</li>';
}else{
	echo '<li style="margin-left:0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Title:</strong>Mx</li>';
}

echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">First Name:</strong>'.$this->input->post('Firstname').'</li>';
echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Last Name:</strong>'.$this->input->post('Lastname').'</li>';
echo '<li style="margin-left: 0;list-style: none; font-size:14px; line-height:18px; margin-bottom:10px; color:#555"><strong style="font-weight: normal; color:#999;">Email Address:</strong>'.$this->input->post('email').'</li></ul></div></div>';
echo '<div style="width:740px; display: block; padding:12px; margin:10px auto 40px; overflow: hidden; color:#555; line-height:20px;">If you have not received a reply within 24 hours, please check your “junk mail” folder. Or email <a style="color:#555;" href="mailto:contact@asiahighlights.com">contact@asiahighlights.com</a> and we will investigate the case.</div></body><html>';

?>