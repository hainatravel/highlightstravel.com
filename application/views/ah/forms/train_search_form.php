<style>
/*搜索框*/
.homesearch{display:block;text-align:center!important;border-radius:5px; box-shadow:0px 0px 6px 1px #888; padding: 10px 15px; /*width:auto!important;*/
}
h2.searchTitlle{  text-align:center; font-size:26px; margin:10px 0 15px 0;}
ul.train-nav{ margin-bottom: 19px;}
input.form-control{ font-size:16px!important; padding: 10px 15px;  }
@media (min-width: 768px) {
.homesearch{ 
}
.form-control{ width:100% !important;}
}
ul.train-nav{padding-left:8px;
}
ul.train-nav li{ list-style:none; display:block; float:left; font-size:16px; margin-right:10px;}
ul.train-nav li a{color:#000; padding:5px 15px; border-radius:4px;}
ul.train-nav li a:hover{ text-decoration: none!important;background:#345382 !important; color: aliceblue;}
ul.train-nav li.active a{ background:#345382 !important; border:none; color:#fff; border-radius:4px;}

#inputHelpBlock{ color:#999; display:block; text-align:left; float:left; margin-right:20px;
	}
.submitbtn{display:block; text-align:center;padding:15px 10px;
}
.btntrain{background:#345382; color:#FFF; font-size:18px;  padding: 5px 30px; border: none!important;
}
.btntrain:hover{ background: #1b3358; color: #fff;}   
</style>
<div class="container">
	<div class="col-sm-14 col-xs-24 homesearch">
		<form method="POST" name="ZZform1" target="_self" class="formWrap form-inline" id="ZZform1">
			<h2 class="searchTitlle">
				Train Ticket Service
			</h2>
			<ul class=" train-nav" id="navtraintop">
				<li class="active" style="display:none;">
					<a data-toggle="tab" href="#IterTrain">Int’l Train from China</a> 
				</li>
				<div class="clearfix">
				</div>
			</ul>
			<div class="tab-content">
				<div id="InnerTrain" class="tab-pane in active">
					<div class="col-sm-8 col-xs-24 form-group">
						<select name="IT_Txt_FZ_1" id="IT_Txt_FZ_1" type="text" class="inputBox form-control" autocomplete="off" placeholder="From"></select> 
					</div>
					<div class="col-sm-8 col-xs-24 form-group">
						<select name="IT_Txt_DZ_1" id="IT_Txt_DZ_1" type="text" class="inputBox form-control" autocomplete="off" placeholder="To"></select> 
					</div>
					<div class="col-sm-8 col-xs-24 form-group">
						<input name="stationDate_1" id="stationDate_1" type="text" class="calendar form-control" autocomplete="off" value="" placeholder="Depart On" /> 
					</div>
				</div>
	<span id="ItelMsg_1"></span> 
			</div>
	<input type="hidden" name="ItelTrain" id="ItelTrain" value="0" /> 
			<div class="col-sm-24 col-xs-24 form-group submitbtn" style="margin-top:15px;">
				<input class="btntrain" type="submit" value="Search >"/> 
			</div>
			<input type="hidden" name="thirdsite" value="ah"/>
		</form>
	</div>
</div>
<script>
$(function(){
	//初始化筛选框
	BindInterTrain(1);
	
	//配置日历选择
	$("#stationDate_1").datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        startDate: '+5d'
    });
	
	$('.btntrain').click(function(){
		$('#ZZform1').attr('action','http://www.trainspread.com/trains/search_result/');
		$('#ZZform1').submit();
	});
});
//绑定国际火车站select联动
function BindInterTrain(index){
	var $FromS = $("#IT_Txt_FZ_"+index);
	var $ToS = $("#IT_Txt_DZ_"+index);
	var $ItelMsg = $("#ItelMsg_"+index);

	$.getJSON("/index.php/ajax/ajax_get_rules/",function(json){
		var html =[];
		for (var key in json.TrainList){
			html.push('<option value="' + json.TrainList[key].FromStation + '">' + json.TrainList[key].FromStation + ','+ json.TrainList[key].FromCountry + '</option>');
		}

		//设置第二个select默认值
		var html2=['<option value="">Please Select</option>'];
		for (var key3 in json.TrainList[0].ToStations){
				html2.push('<option value="' + json.TrainList[0].ToStations[key3].Station + '" data="'+json.TrainList[0].ToStations[key3].Message+'">' + json.TrainList[0].ToStations[key3].Station + ','+json.TrainList[0].ToStations[key3].StationCountry + '</option>');
			}
		$ToS.empty().append(html2);

		$FromS.empty().append(html).change(function(){
			var n = $(this).get(0).selectedIndex;

			var html3 = ['<option value="">Please Select</option>'];
			for (var key2 in json.TrainList[n].ToStations){
				html3.push('<option value="' + json.TrainList[n].ToStations[key2].Station + '" data="'+json.TrainList[n].ToStations[key2].Message+'">' + json.TrainList[n].ToStations[key2].Station + ','+json.TrainList[n].ToStations[key2].StationCountry + '</option>');
			}

			$ToS.empty().append(html3).change(function(){
				var ItelMsg = $(this).find("option:selected").attr("data");
				if (ItelMsg!="" && typeof(ItelMsg)!="undefined"){
					$ItelMsg.html(ItelMsg);
				}else{
					$ItelMsg.html("");
				}
			});

			$ItelMsg.html("");
		});

	});

	$ToS.change(function(){
		var ItelMsg = $ToS.find("option:selected").attr("data");
		if (ItelMsg!="" && typeof(ItelMsg)!="undefined"){
			$ItelMsg.html(ItelMsg);
		}else{
			$ItelMsg.html("");
		}
		$(this).css('border-color',"").next("span").remove();
	});
}
</script>