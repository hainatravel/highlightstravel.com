<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
    }

    public function index() {
        echo 'test index';        
    }
    
    // https://proxy-www.asiahighlights.com/index.php/test/ip_address
    public function ip_address() {
      echo "REMOTE_ADDR: " . $this->input->server('REMOTE_ADDR') . '<br>';
      echo "HTTP_CLIENT_IP: " . $this->input->server('HTTP_CLIENT_IP') . '<br>';
      echo "HTTP_X_FORWARDED_FOR: " . $this->input->server('HTTP_X_FORWARDED_FOR') . '<br>';
      echo "HTTP_TRUE_CLIENT_IP: " . $this->input->server('HTTP_TRUE_CLIENT_IP') . '<br>';
      echo "input->ip_address: " . $this->input->ip_address();
    }

    // https://proxy-www.asiahighlights.com/index.php/test/country_code
    public function country_code() {
      $country_code = $this->input->post('country_code');
      $country_array = explode('+', $country_code);
      var_dump($country_array);
      $country_id = $this->Orders_model->get_country_id_by_code($country_code);
      echo 'country_id: '.$country_id;
    }
	
	//根据条件获取模板所对应的页面url
	public function search_url(){
		$this->load->model('test_model');
		$template = $this->input->post('ic_template');
		
		//构造一个页面
		$html = '';
		$html .= '<h1>AH模板页面查询</h1>';
		$html .= '<form action="/gm.php/test/search_url/" method="post">';
		$html .= '<select name="ic_template" id="ic_template" class="form-control">
						<option selected="" value="guide_info_detail">通用内容模板</option>
						<option value="city_info_list">城市-列表模板</option>
						<option value="city_info_index">城市-首页模板</option>
						<option value="city_info_index_new">城市-首页模板(GM)</option>
						<option value="city_info_s_index">城市-首页模板[简]</option>
						<option value="city_info_attractions_list">城市-景点列表模板</option>
						<option value="city_info_s_attractions_list">城市-景点列表模板[简]</option>
						<option value="city_info_diytour">城市-特色产品模板</option>
						<option value="city_info_index_one">城市-一线城市首页</option>
						<option value="area_info_index">省份-首页</option>
						<option value="area_info_list">省份-列表模板</option>
						<option value="area_info_detail">省份-通用内容模板</option>
						<option value="culture_info_detail_just_list">文化模板 [列表式]</option>
						<option value="culture_info_detail_one_page">文化模板 [单页式]</option>
						<option value="culture_info_detail_with_category">文化模板 [导航式]</option>
						<option value="guide_top_series">信息专题模板</option>
						<option value="train_top_series">火车专题模板</option>
						<option value="travel_story">旅游攻略</option>
						<option value="festival_detail">节庆-详细模板</option>
						<option value="festival_list">节庆-列表模板</option>
						<option value="embassy_info_detail">大使馆-详细页</option>
						<option value="r_tpl_empty">[国际站]响应式-空白模板</option>
						<option value="tpl_empty">[国际站]空白模板</option>
						<option value="tpl_empty_h1">[国际站]空白模板+H1</option>
						<option value="tpl_empty_navi_h1">[国际站]空白模板+H1+左导航</option>
						<option value="tpl_city_tour">[国际站]城市线路模板</option>
						<option value="chinareisen">[德语站]chinareisen</option>
						<option value="warm">[已废弃]专题-温暖</option>
						<option value="solemn">[已废弃]专题-庄重</option>
						<option value="festival">[已废弃]专题-节庆</option>
						<option value="promotion_tour">[已废弃]专题-线路促销</option>
						<option value="city_attractions">[已废弃]城市-景点详细模板</option>
						<option value="city_circuit">城市-线路详细</option>
						<option value="guide_big_series">专题模板（大）</option>
						<option value="yangtze">三峡游船</option>
						<option value="city_article_list">城市article列表</option>
						<option value="food_list">food列表</option>
				</select>';
		$html .= '<input type="submit" value="搜索"/></form>';	
		
		echo $html;

		if(!empty($template)){
			$all_url = $this->test_model->get_url($template);
			$i = 1;
			foreach($all_url as $item){
				echo $i.' : '.$item->ic_url.' <a style="color:#337ab7;text-decoration: none;" href="https://www.asiahighlights.com'.$item->ic_url.'">查看原页面</a>';
				echo '<hr>';
				$i++;
			}
		}
	}
	
	public function search_contents(){
		$this->load->model('test_model');
		$template = $this->input->post('url');
		
		//构造一个页面
		$html = '';
		$html .= '<h1>AH根据url查询所属页面</h1>';
		$html .= '<form action="/index.php/test/search_contents/" method="post">';
		$html .= '输入url：<input type="text" name="url"/>';
		$html .= '<input type="submit" value="搜索"/></form>';	
		
		echo $html;

		if(!empty($template)){
			$all_url = $this->test_model->get_contents($template);
			$i = 1;
			foreach($all_url as $item){
				echo $i.' : '.$item->ic_url.' <a target="_blank" style="color:#337ab7;text-decoration: none;" href="https://www.asiahighlights.com'.$item->ic_url.'">查看原页面</a>';
				echo '<hr>';
				$i++;
			}
		}
    }
} 
	
   