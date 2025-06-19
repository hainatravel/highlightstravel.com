<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajax extends CI_Controller {
	
	//ajax 获取信息页面底部tailorshort
	public function footerTailorShort(){
		$html = '<div class="textBlock">Overwhelmed by thousands of trip ideas and tours? <br />Contact one of our travel advisors for help! <span><a href="/forms/tailormade">Help Me Plan Now <i class="fa fa-angle-right" aria-hidden="true"></i></a></span> </div>';
		echo $html;
	}
	
	//ajax调用广告
	public function getads(){
        $data = array();
		$guideUrl = $this->input->get_post('murl');
        if($guideUrl == NULL){
            //$guideUrl = '/liuzhou/';
            exit('err!');
        }
		
        $adcont = false;
        if($adcont){

        }else{
            $this->load->model('Advertise_model', 'mAds');
            //新广告系统
			$infoads = $this->mAds->get_advertise_by_url($guideUrl);
			//print_r($infoads);
            if($infoads == NULL){
                die('err');
            }
            foreach ($infoads as $key => $value) {
				if(isset($value->adp_ic_url)){
					$data[$key]['url'] = $value->adp_ic_url;
				}
                $data[$key]['adid'] = $value->ad_id;
                $data[$key]['content'] = $value->ad_content;
                $data[$key]['expire'] = date('Y-m-d',$value->ad_expire);
                $data[$key]['status'] = $value->ad_status;
            }
            $adcont = json_encode($data);
        }
        header("Content-type: application/json");
        die($adcont);
    }
	
	//请求数据接口
	public function ajax_get_rules(){
		$json = file_get_contents('https://cht.mycht.cn/info.php/apps/train/search/get_station_rules/');
		header("Content-type: application/json");
		echo $json;
	}
	
}

?>