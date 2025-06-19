<script>
$(function(){
	var url = window.location.pathname;
	//var url = '/vietnam/halong-bay/weather.htm';
	var matches = /(\w+)\/((\w|-)+)\/weather/.exec(url);
	var country = matches[1];
	var city = matches[2];
	if(country && city){
		$.ajax({
			type:'POST',
			url:'/weather/create_weather_html',
			data:{
				city:city,
				country:country
			},
			success:function(data){
				$('.weatherForecast').html(data);
			}	
		});
	}else{
		return null;
	}
	
	
});
</script>
<link rel="stylesheet" type="text/css" href="https://data.asiahighlights.com/min/?f=/css/guide.css"/>
<div class="weatherForecast">
	<!-- 插入天气代码 -->
</div>













