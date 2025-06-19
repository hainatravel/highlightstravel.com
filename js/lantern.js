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

