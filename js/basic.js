
//http://jquery.malsup.com/form/
function submitForm(form) {
	if(form == 'form_tailormade'){
		//检查目的地
		checkDestination();
	}
	//检查出发日期
	//checktourbox();
    $('#' + form).ajaxSubmit({
        success: successfun,
        error: errorfun,
        dataType: 'json',
        timeout: 30000
    });
    return false;
}

function errorfun(responseText, statusText, xhr, form) {
    alert('Action unsuccessful. Try again later.');
}


function successfun(responseText, statusText, xhr, form) {
    var scrollit = true;
    for (var key in responseText) {
        if (responseText[key].name == 'ok') {
            //window.location.href=responseText[key].value;  
            //showTips(form.attr('id'),'ok'); 

            //判断是否自动更新缓存
            if ($("#rule_check_flag").val() == 1 && $('#auto_update_cache_checkbox').attr("checked")) {
                $.modaldialog.success(responseText[key].value + 'n' + '\u9759\u6001\u9875\u9762\u66f4\u65b0\u4e2d...');
                updateCache($('#auto_update_cache_checkbox').val(), '');
            } else {
                $.modaldialog.success(responseText[key].value);
                /*setTimeout(function() {
                 $("#dialog-close").trigger('click');
                 }, 1500);*/
            }
        } else if (responseText[key].name == 'ok_go') {
            setTimeout(function () {
                window.location.href = responseText[key].value;
            }, 2000);
        } else if (responseText[key].name == 'no') {
            $.modaldialog.error(responseText[key].value);
        } else if (responseText[key].name == 'go') {
            window.location.href = responseText[key].value;
        } else if (responseText[key].name == 'ok_modal') {
            $('.modal').modal('hide');
            $.modaldialog.success(responseText[key].value);
        } else if (responseText[key].name == 'no_modal') {
            $('.modal').modal('hide');
            $.modaldialog.error(responseText[key].value);
        } else {
            // var url = window.location.href;
            //window.location.href = url.replace(/#warning/g, '') + '#warning';
            if (scrollit) {
			   var visibleTop = $('#' + responseText[key].name).offset().top - $('#' + responseText[key].name).height() - 100;
			   $("body,html").animate({
					scrollTop: visibleTop
			   });
			   scrollit = false;
            }
            
            showTips(responseText[key].name, responseText[key].value);
        }
    }
    return true;
}


function showTips(objName, title) {
    /*
     $('#'+objName).poshytip({
     content:title,
     timeOnScreen:5000,
     className: 'tip-yellow',
     showOn: 'none',
     alignTo: 'target',
     alignX: 'right',
     alignY:'center'
     });
     $('#'+objName).poshytip('show');
     $('#'+objName).focus(function(){
     $('#'+objName).poshytip('hide');
     });
     */
	 
    $('#' + objName).tooltip({
        title: title,
        placement: 'top',
        trigger: 'manual'
    });
    $('#' + objName).tooltip('show');
    setTimeout(function () {
        $('#' + objName).tooltip('hide');
    }, 5000);
}

$(function () {
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var nationality_map = ["afghanistan", "albania", "algeria", "american samoa", "andorra", "angola", "anguilla", "antarctica", "antigua and barbuda", "argentina", "armenia", "aruba", "australia", "austria", "azerbaijan", "bahamas", "bahrain", "bangladesh", "barbadian", "barbados", "belarus", "belgium", "belize", "benin", "bermuda", "bhutan", "bolivia", "botswana", "bouvet island", "brazil", "british indian ocean territory", "brunei darussalam", "bulgaria", "burkina faso", "burundi", "cambodia", "cameroon", "canada", "cape verde", "cayman islands", "central african republic", "chad", "chile", "china", "china HK", "christmas island", "colombia", "comoros", "congo", "cook islands", "costa rica", "croatia", "cuba", "cyprus", "czech republic", "czechoslovakia", "denmark", "djibouti", "dominica", "dominican republic", "east timor", "ecuador", "egypt", "el salvador", "equatorial guinea", "eritrea", "estonia", "ethiopia", "falkland islands", "faroe islands", "fiji", "finland", "france", "french guiana", "french polynesia", "gabon", "gambia", "georgia", "germany", "ghana", "gibraltar", "greece", "greenland", "grenada", "guadeloupe", "guam", "guatemala", "guernsey", "guinea", "guinea-bissau", "guyana", "haiti", "honduras", "hong kong", "hungary", "iceland", "india", "indonesia", "iran", "iraq", "ireland", "isle of man", "israel", "italy", "jamaica", "japan", "jersey", "jordan", "kazakhstan", "kazakhstan2", "kenya", "kiribati", "korea", "kuwait", "kyrgyzstan", "laos", "latvia", "lebanon", "lesotho", "liberia", "libyan arab jamahiriya", "liechtenstein", "lithuania", "luxembourg", "macau", "macedonia", "madagascar", "malawi", "malaysia", "maldives", "mali", "malta", "marshall islands", "martinique", "mauritania", "mauritius", "mayotte", "mexican", "micronesia", "moldova", "monaco", "mongolia", "montserrat", "morocco", "mozambique", "myanmar", "namibia", "nauru", "nepal", "netherlands", "netherlands antilles", "neutral zone", "new caledonia", "new zealand", "nicaragua", "niger", "nigeria", "niue", "norfolk island", "north korea", "northern mariana islands", "norway", "oman", "pakistan", "palau", "panama", "papua new guinea", "paraguay", "peru", "philippines", "pitcairn", "poland", "portugal", "puerto rico", "qatar", "reunion", "romania", "russian federation", "rwanda", "saint helena", "samoa", "san marino", "sao tome and principe", "saudi arabia", "scotland", "senegal", "seychelles", "sierra leone", "singapore", "slovakia", "slovenia", "solomon islands", "somalia", "south africa", "south georgia and the sandwich", "spain", "sri lanka", "sudan", "suriname", "swaziland", "sweden", "switzerland", "syrian arab republic", "taiwan", "tanzania", "thailand", "the republic of cote d'ivoire", "togo", "tokelau", "tonga", "trinidad and tobago", "tunisia", "turkey", "turkmenistan", "turks and caicos islands", "tuvalu", "uganda", "ukraine", "united arab emirates", "united kingdom", "united states", "unknown", "uruguay", "ussr", "uzbekistan", "vanuatu", "vatican city state", "venezuela", "vietnam", "virgin islands (british)", "virgin islands (u.s.)", "western sahara", "yemen", "yugoslavia", "zaire", "zambia", "zimbabwe"];
    $('.nationality').typeahead({
        hint: false,
        highlight: true,
        minLength: 1
    },
    {
        name: 'nationality_states',
        source: substringMatcher(nationality_map)
    });


});

function checkDestination() {
	var liarr = $('.destinations li');
	var j = 0;
	var city = '';
	for(var i=0;i<liarr.length;i++){
		if($(liarr[i]).hasClass('checked') == false){
			j++;
		}else{
			city += $($('.destinations li')[i]).attr('name')+',';
		}
	}
	city = city.substring(0,city.length-1);
	$('input[name="Destination"]').val(city);
	if(j == 12){
		showTips('destinations', 'Please select your Destinations.');
		return false;
	}else{
		return true;
	}
}

function checktourbox() {
    if ($('#Date_Start').val() == '') {
        showTips('Date_Start', 'Please select your Departure Date.');
        return false;
    } else {
        return true;
    }
}
//csk 是否是PC端
function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
                "SymbianOS", "Windows Phone",
                "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
//csk 回到顶部
function to_top(){
        $("html,body").animate({ scrollTop: 0 }, 1000);
    }
    //滚动监听
    $(window).scroll(function(){
        var top=$(document).scrollTop();   
        var top_controller_div=$("#top_controller");     
        if(top==0){
            top_controller_div.hide();
        }else{
            top_controller_div.show(); 
        }
    });
    $(function(){ 
        var top_div = $("<div id='top_controller' onclick=\"to_top();\">").css('opacity','1');
            top_div.css({                
                'height': '50px',
                'position':'fixed',
                'width':'50px',
                'height':'50px',
                'z-index':9999,
                'right':'5px',
                'bottom':'50px',
                'display':'none',
                'background':'url(/image/to-top.png)',
                'cursor':'pointer'
            });
       $('body').append(top_div);     
       var top_controller_div=$("#top_controller");      
       var top=$(document).scrollTop(); 
       $("#total_tr").hide();
       if(top==0){
            top_controller_div.hide();
        }else{
            top_controller_div.show(); 
        }
    });
//csk 回到顶部    
