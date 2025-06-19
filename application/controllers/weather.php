<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class weather extends CI_Controller {

    public function index() {
		//$this->load->view('header');
        //$this->load->view('ah/info/weather_info');
        //$this->load->view('footer');
		echo '前方高能预警！！';
		
    }
	
    //创建天气html
	public function create_weather_html(){
		$city = str_replace('-',' ',$this->input->post('city'));
		$country = $this->input->post('country');
		if(!$city){
			return null;
		}
		$forecast_url = 'api.openweathermap.org/data/2.5/forecast?id='.exchange_cityId($city).'&appid=71ebb62956a874cd1d03517a5a3e67e7&units=metric';

		$forecast_info = json_decode(get_data($forecast_url));
		//echo $forecast_url;
		//print_r($forecast_info);
		if($forecast_info->cod == 400){
			return null;
		}
		$day = new StdClass();
		$weather = new StdClass();
		$weather->one = array();
		$weather->two = array();
		$weather->three = array();
		$weather->four = array();
		
		//当天时间
		$time = date('Y-m-d',time());
		
		//获取数据
		$today = date('d',time());
			for($i=0;$i<count($forecast_info->list);$i++){
				$forecast_info->list[$i]->dt = date('y-m-d H:i:s',$forecast_info->list[$i]->dt);
				
				if(preg_match_all('/([\d]+)-([\d]+)-'.date('d',strtotime('+1 day')).' (08|1[\d]):00:00/',$forecast_info->list[$i]->dt)){
					$day->one = $forecast_info->list[$i]->main;
					$day->one->dt = $forecast_info->list[$i]->dt;
					$day->one->icon = $forecast_info->list[$i]->weather[0]->icon;
					Array_push($weather->one,$day->one);
				}
				
				if(preg_match_all('/([\d]+)-([\d]+)-'.date('d',strtotime('+2 day')).' (08|1[\d]):00:00/',$forecast_info->list[$i]->dt)){
					$day->two = $forecast_info->list[$i]->main;
					$day->two->dt = $forecast_info->list[$i]->dt;
					$day->two->icon = $forecast_info->list[$i]->weather[0]->icon;
					Array_push($weather->two,$day->two);
				}
				
				if(preg_match_all('/([\d]+)-([\d]+)-'.date('d',strtotime('+3 day')).' (08|1[\d]):00:00/',$forecast_info->list[$i]->dt)){
					$day->three = $forecast_info->list[$i]->main;
					$day->three->dt = $forecast_info->list[$i]->dt;
					$day->three->icon = $forecast_info->list[$i]->weather[0]->icon;
					Array_push($weather->three,$day->three);
				}
				
				if(preg_match_all('/([\d]+)-([\d]+)-'.date('d',strtotime('+4 day')).' (08|1[\d]):00:00/',$forecast_info->list[$i]->dt)){
					$day->four = $forecast_info->list[$i]->main;
					$day->four->dt = $forecast_info->list[$i]->dt;
					$day->four->icon = $forecast_info->list[$i]->weather[0]->icon;
					Array_push($weather->four,$day->four);
				}
				
			}
			
			//创建html
			$html = '';
			$html .= '<span class="location">'.ucfirst($country).','.ucwords($city).'</span>';
			if($country == 'myanmar'){
				$html .= '<span class="time">'.date('H:i',strtotime('-1 hours - 30 minute')).' '.date('M d',time()).','.date('D',time()).'</span>';
			}else{
				$html .= '<span class="time">'.date('H:i',strtotime('-1 hours')).' '.date('M d',time()).','.date('D',time()).'</span>';
			}
			$html .= '<span class="weatherCondition">'.$forecast_info->list[0]->weather[0]->description.'</span><div class="tempCondition"><div class="tempSign">';
			$html .= '<img src="/pic/weather/'. $forecast_info->list[0]->weather[0]->icon.'.png"> <strong>'.ceil($forecast_info->list[0]->main->temp).'<sup>℃</sup></strong></div>';
			
			if(isset($forecast_info->list[0]->rain)){
				$arr = (array)$forecast_info->list[0]->rain;
				if(isset($arr['3h'])){
				$html .= '<div class="weatherInfo">Precipitation:'.ceil($arr['3h']).'mm<br>';
				}else{
					$html .= '<div class="weatherInfo">Precipitation:0 mm<br>';
				}
			}
			
			$html .= 'Humidity:'.$forecast_info->list[0]->main->humidity.'%<br>Wind: '.$forecast_info->list[0]->wind->speed.'km/h</div></div>';
			$html .= '<div class="dailyWeather"><ul><li><strong>'.date('D',strtotime("$time +1 day")).'</strong><img src="/pic/weather/'. $day->one->icon.'.png"><em>'.ceil($weather->one[0]->temp).'° - '.ceil($weather->one[count($weather->one)-1]->temp).'°'.'</em></li>';
			$html .= '<li><strong>'.date('D',strtotime("$time +2 day")).'</strong><img src="/pic/weather/'. $day->two->icon.'.png"><em>'. ceil($weather->two[0]->temp).'° - '.ceil($weather->two[count($weather->two)-1]->temp).'°'.'</em></li>';
			$html .= '<li><strong>'.date('D',strtotime("$time +3 day")).'</strong><img src="/pic/weather/'. $day->three->icon.'.png"><em>'. ceil($weather->three[0]->temp).'° - '.ceil($weather->three[count($weather->three)-1]->temp).'°'.'</em></li>';
			$html .= '<li><strong>'.date('D',strtotime("$time +4 day")).'</strong><img src="/pic/weather/'. $day->four->icon.'.png"><em>'.ceil($weather->four[0]->temp).'° - '.ceil($weather->four[count($weather->four)-1]->temp).'°'.'</em></li></ul></div>';
			
			print_r($html);
		}
	
}