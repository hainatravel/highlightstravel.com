<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 分析和替换内容中的动态程序
 */

class Tags_analysis {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('InfoMetas_model');
        $this->CI->load->model('CustomerLineInfo_model');
        $this->CI->load->model('Price_model');
        $this->CI->load->model('PrimeLinePrice_model');
        $this->CI->load->model('BIZ_PackagePrice_model');
        $this->CI->load->model('BIZ_PackageInfo_model');
        $this->CI->load->library('Currency');
        $this->CI->load->model('Information_model');//CSK
    }

    //解析内容中的标签tag
    public function analysis($information) {
        $data = array();
		//信息页面展示产品价格和表单  /////////////////////////////////////////////
        $data['detail'] = $information; //引用上面查到的数据
        //如果是产品类型，则需要查询绑定的线路代号，把内容中的占位符替换掉
        switch ($data['detail']->ic_type) {
            case 'pd_tour':
                $meta_product_code = $this->CI->InfoMetas_model->get($data['detail']->ic_id, 'meta_product_code');
                if (!empty($meta_product_code)) {
                    $data['pd_tour'] = $this->CI->CustomerLineInfo_model->search($meta_product_code, 1);
                    //print_r($data['pd_tour']);
                    if (!empty($data['pd_tour'])) {

                        //填充预订表单模板
                        if (strpos($data['detail']->ic_content, '@BOOKINGFORM@') !== false) { //默认使用booking_form_inquiry模板
                            //$pd_booking_from = $this->CI->load->view('tags/' . Site_Code . '/booking_form', $data, true);
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/booking_form_inquiry', $data, true);
                            $data['detail']->ic_content = str_replace('@BOOKINGFORM@', $pd_booking_from, $data['detail']->ic_content);
                        }
						
						//Quick Inquiry contactus 联系我们
						if (strpos($data['detail']->ic_content, '@BOOKING-QUICK-INQUIRY@') !== false) {
							$pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/booking_quick_inquiry', $data, true);
							$data['detail']->ic_content = str_replace('@BOOKING-QUICK-INQUIRY@', $pd_booking_from, $data['detail']->ic_content);
						}
						
						//填充预订表单模板
                        if (strpos($data['detail']->ic_content, '@NEWBOOKINGFORM@') !== false) { //默认使用booking_form_inquiry模板
                            //$pd_booking_from = $this->CI->load->view('tags/' . Site_Code . '/booking_form', $data, true);
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/new_booking_form', $data, true);
                            $data['detail']->ic_content = str_replace('@NEWBOOKINGFORM@', $pd_booking_from, $data['detail']->ic_content);
                        }
						
                        //填充预订表单模板-AMP版本
                        if (strpos($data['detail']->ic_content, '@AMP-NEWBOOKINGFORM@') !== false) {
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/amp/new_booking_form', $data, true);
                            $data['detail']->ic_content = str_replace('@AMP-NEWBOOKINGFORM@', $pd_booking_from, $data['detail']->ic_content);
                        }

                        if (strpos($data['detail']->ic_content, '@BOOKINGFORM-INQUIRY@') !== false) {
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/booking_form_inquiry', $data, true);
                            $data['detail']->ic_content = str_replace('@BOOKINGFORM-INQUIRY@', $pd_booking_from, $data['detail']->ic_content);
                        }

                        if (strpos($data['detail']->ic_content, '@BOOKING-INQUIRY-NOW@') !== false) { 
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/booking_inquiry_now', $data, true);
                            $data['detail']->ic_content = str_replace('@BOOKING-INQUIRY-NOW@', $pd_booking_from, $data['detail']->ic_content);
                        }
						
						if (strpos($data['detail']->ic_content, '@BOOKING-INQUIRY-NOW-LATEST@') !== false) { 
                            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/booking_inquiry_now_latest', $data, true);
                            $data['detail']->ic_content = str_replace('@BOOKING-INQUIRY-NOW-LATEST@', $pd_booking_from, $data['detail']->ic_content);
                        }

                    }
                }
                break;
            case 'pd_package':
                $meta_product_code = $this->CI->InfoMetas_model->get($data['detail']->ic_id, 'meta_product_code');
                if (!empty($meta_product_code)) {
                    $data['pd_package'] = $this->CI->BIZ_PackageInfo_model->search($meta_product_code, 1);
                    //print_r($data['pd_tour']);
                    if (!empty($data['pd_package'])) {
						
                    }
                }

                break;
            default:;
        }
		
		if (strpos($data['detail']->ic_content, '@TMBOTTOMBUTTON@') !== false) {
			$pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/tm_bottom_button', $data, true);
			$data['detail']->ic_content = str_replace('@TMBOTTOMBUTTON@', $pd_booking_from, $data['detail']->ic_content);
		}
		
		if (strpos($data['detail']->ic_content, '@QUICKBOOKINGFORM@') !== false) {
			$pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/quick_inquiry_form', $data, true);
			$data['detail']->ic_content = str_replace('@QUICKBOOKINGFORM@', $pd_booking_from, $data['detail']->ic_content);
		}
		
		//面包屑导航
		if (strpos($data['detail']->ic_content, '@BREADCRUMBLIST@') !== false) { 
			if(isset($data['detail']->breadcrumblist)){
				$data['detail']->ic_content = str_replace('@BREADCRUMBLIST@', $data['detail']->breadcrumblist, $data['detail']->ic_content);
			}
		}
		
		//amp的结构化标签 @AMP-CONSTRUCT-TAG@
		if (strpos($data['detail']->ic_content, '@AMP-CONSTRUCT-TAG@') !== false) { 
			if(isset($data['detail']->construct_tag)){
				$data['detail']->ic_content = str_replace('@AMP-CONSTRUCT-TAG@', $data['detail']->construct_tag, $data['detail']->ic_content);
			}else{
				$data['detail']->ic_content = str_replace('@AMP-CONSTRUCT-TAG@', '', $data['detail']->ic_content);
			}
		}
		
		//添加火车搜索框
		if (strpos($data['detail']->ic_content, '@TRAIN_SEARCH_FORM@') !== false) {
            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/forms/train_search_form', $data, true);
            $data['detail']->ic_content = str_replace('@TRAIN_SEARCH_FORM@', $pd_booking_from, $data['detail']->ic_content);
        }
		
		//推荐文章标签获取
		if (strpos($data['detail']->ic_content, '@RECOMMEND-INFO-LIST@') !== false) {
			$meta_recommend_info = $this->CI->InfoMetas_model->get($data['detail']->ic_id, 'meta_recommend_info');
			if(!empty($meta_recommend_info)){
				if(strpos($meta_recommend_info,',') !== false){
					$arr = explode(',',$meta_recommend_info);
					$data['title_url'] = array();
					foreach($arr as $ic_id){
						if($ic_id != ''){
							$obj = $this->CI->Information_model->get_title_url($ic_id)[0];
							if(!empty($obj)){
								array_push($data['title_url'],$obj);
							}
						}
					}
				}else{
					$data['title_url'] = $this->CI->Information_model->get_title_url($meta_recommend_info);
				}
				$recommend_info_list = $this->CI->load->view(CONST_SITE_CODE .'/info/recommend_info_list',$data, true);
				$data['detail']->ic_content = str_replace('@RECOMMEND-INFO-LIST@', $recommend_info_list, $data['detail']->ic_content);
			}else{
				$data['detail']->ic_content = str_replace('@RECOMMEND-INFO-LIST@', '', $data['detail']->ic_content);
			}
        }
		
		//推荐文章标签获取(包含图片)
		if (strpos($data['detail']->ic_content, '@RECOMMEND-INFO-LIST-IMG@') !== false) {
			$meta_recommend_info = $this->CI->InfoMetas_model->get($data['detail']->ic_id, 'meta_recommend_info');
			if(!empty($meta_recommend_info)){
				if(strpos($meta_recommend_info,',') !== false){
					$arr = explode(',',$meta_recommend_info);
					$data['title_url'] = array();
					foreach($arr as $ic_id){
						if($ic_id != ''){
							$obj = $this->CI->Information_model->get_title_url($ic_id)[0];
							if(!empty($obj)){
								array_push($data['title_url'],$obj);
							}
						}
					}
				}else{
					$data['title_url'] = $this->CI->Information_model->get_title_url($meta_recommend_info);
				}
				$recommend_info_list = $this->CI->load->view(CONST_SITE_CODE .'/info/recommend_info_list_img',$data, true);
				$data['detail']->ic_content = str_replace('@RECOMMEND-INFO-LIST-IMG@', $recommend_info_list, $data['detail']->ic_content);
			}else{
				$data['detail']->ic_content = str_replace('@RECOMMEND-INFO-LIST-IMG@', '', $data['detail']->ic_content);
			}
        }
		
		//推荐产品标签获取
		if (strpos($data['detail']->ic_content, '@RECOMMEND-PRODUCT-LIST@') !== false) {
			$meta_recommend_product = $data['detail']->ic_recommend_tours;
			if(!empty($meta_recommend_product)){
				if(strpos($meta_recommend_product,',') !== false){
					$arr = explode(',',$meta_recommend_product);
					$data['title_url'] = array();
					foreach($arr as $ic_id){
						if($ic_id != ''){
							$obj = $this->CI->Information_model->get_title_url($ic_id)[0];
							if(!empty($obj)){
								array_push($data['title_url'],$obj);
							}
						}
					}
				}else{
					$data['title_url'] = $this->CI->Information_model->get_title_url($meta_recommend_product);
				}
				
				$recommend_product_list = $this->CI->load->view(CONST_SITE_CODE .'/info/recommend_product_list',$data, true);
				$data['detail']->ic_content = str_replace('@RECOMMEND-PRODUCT-LIST@', $recommend_product_list, $data['detail']->ic_content);
			}else{
				$data['detail']->ic_content = str_replace('@RECOMMEND-PRODUCT-LIST@', '', $data['detail']->ic_content);
			}
        }
		
		//推荐产品标签获取(包含图片)
		if (strpos($data['detail']->ic_content, '@RECOMMEND-PRODUCT-LIST-IMG@') !== false) {
			$meta_recommend_product = $data['detail']->ic_recommend_tours;
			if(!empty($meta_recommend_product)){
				if(strpos($meta_recommend_product,',') !== false){
					$arr = explode(',',$meta_recommend_product);
					$data['title_url'] = array();
					foreach($arr as $ic_id){
						if($ic_id != ''){
							$obj = $this->CI->Information_model->get_title_url($ic_id)[0];
							if(!empty($obj)){
								array_push($data['title_url'],$obj);
							}
						}
					}
				}else{
					$data['title_url'] = $this->CI->Information_model->get_title_url($meta_recommend_product);
				}
				
				$recommend_product_list = $this->CI->load->view(CONST_SITE_CODE .'/info/recommend_product_list_img',$data, true);
				$data['detail']->ic_content = str_replace('@RECOMMEND-PRODUCT-LIST-IMG@', $recommend_product_list, $data['detail']->ic_content);
			}else{
				$data['detail']->ic_content = str_replace('@RECOMMEND-PRODUCT-LIST-IMG@', '', $data['detail']->ic_content);
			}
        }
		
		//tailorshort
        if (strpos($data['detail']->ic_content, '@TAILOR-SHORT@') !== false) {
            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/info/tailorshort', $data, true);
            $data['detail']->ic_content = str_replace('@TAILOR-SHORT@', $pd_booking_from, $data['detail']->ic_content);
        }
		
		//天气预报
		if (strpos($data['detail']->ic_content, '@WEATHER_INFO@') !== false) { 
			$pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/info/weather_info', $data, true);
            $data['detail']->ic_content = str_replace('@WEATHER_INFO@', $pd_booking_from, $data['detail']->ic_content);
		}      
		
        //左侧导航
        if (strpos($data['detail']->ic_content, '@INFO-LEFT-MENU@') !== false) {       
            $list["same_level"]=$this->CI->Information_model->get_same_level($data['detail']->is_parent_id,10); //csk 2016-11-11 改成10条            
            $list["parent"]=$this->CI->Information_model->get_detail($data['detail']->is_parent_id);
            $flg=TRUE;
            foreach ($list["same_level"] as $key=>$v){
                if($v->ic_url==$data['detail']->ic_url){
                    $flg=FALSE;
                }
                if($key==(count($list["same_level"])-1) && $flg){
                    //本页不存在前面五条链接之中，把$list["same_level"]最后一条换成本页链接
                    $list["same_level"][$key]->ic_url=$data['detail']->ic_url;
                    $list["same_level"][$key]->ic_url_title=$data['detail']->ic_url_title;
                }
            } 

            $pd_booking_from = $this->CI->load->view(CONST_SITE_CODE .'/info/info_left_menu', $list, true);
            $data['detail']->ic_content = str_replace('@INFO-LEFT-MENU@', $pd_booking_from, $data['detail']->ic_content);
        }        

		//AMP的标签 begin
		
		//AMP头部替换
		if (strpos($data['detail']->ic_content, '@AMP-COMMON-HEADER@') !== false) {
			$replace_code = $this->CI->load->view(CONST_SITE_CODE . '/amp/ampcommonheader', $data, true);
			$data['detail']->ic_content = str_replace('@AMP-COMMON-HEADER@', $replace_code, $data['detail']->ic_content);
		}
		
		//AMP底部替换
		if (strpos($data['detail']->ic_content, '@AMP-COMMON-FOOTER@') !== false) {
			$replace_code = $this->CI->load->view(CONST_SITE_CODE . '/amp/ampcommonfooter', $data, true);
			$data['detail']->ic_content = str_replace('@AMP-COMMON-FOOTER@', $replace_code, $data['detail']->ic_content);
		}
		
		//AMP的SEO title
		if (strpos($data['detail']->ic_content, '@AMP-SEO-TITLE@') !== false) {
			$data['detail']->ic_content = str_replace('@AMP-SEO-TITLE@', $data['detail']->ic_seo_title, $data['detail']->ic_content);
		}
		
		//AMP的SEO description
		if (strpos($data['detail']->ic_content, '@AMP-SEO-DESCRIPTION@') !== false) {
			$data['detail']->ic_content = str_replace('@AMP-SEO-DESCRIPTION@', $data['detail']->ic_seo_description, $data['detail']->ic_content);
		}
		
		//AMP的SEO keywords
		if (strpos($data['detail']->ic_content, '@AMP-SEO-KEYWORDS@') !== false) {
			$data['detail']->ic_content = str_replace('@AMP-SEO-KEYWORDS@', $data['detail']->ic_seo_keywords, $data['detail']->ic_content);
		}
		
		//AMP的google分析代码
		if (strpos($data['detail']->ic_content, '@AMP-GOOGLE-ANALYTICS@') !== false) {
			$replace_code = $this->CI->load->view(CONST_SITE_CODE . '/amp/google-analytics', $data, true);
			$data['detail']->ic_content = str_replace('@AMP-GOOGLE-ANALYTICS@', $replace_code, $data['detail']->ic_content);
		}
		
		//AMP的addthis分享代码
		/*if (strpos($data['detail']->ic_content, '<script async custom-element="amp-addthis" src="https://cdn.ampproject.org/v0/amp-addthis-0.1.js"></script>') !== false) {
			if($data['detail']->ic_type == 'pd_tour' || $data['detail']->ic_type == 'pd_package'){
				$replace_code = '';
				$data['detail']->ic_content = str_replace('<script async custom-element="amp-addthis" src="https://cdn.ampproject.org/v0/amp-addthis-0.1.js"></script>', $replace_code, $data['detail']->ic_content);
			}
		}*/
		
		if (strpos($data['detail']->ic_content, '<amp-addthis width="320" height="40" layout="responsive" data-pub-id="ra-598408c3e2fb90c3" data-widget-id="o2ei"></amp-addthis>') !== false) {
			if($data['detail']->ic_type == 'pd_tour' || $data['detail']->ic_type == 'pd_package'){
				$replace_code = '';
				$data['detail']->ic_content = str_replace('<amp-addthis width="320" height="40" layout="responsive" data-pub-id="ra-598408c3e2fb90c3" data-widget-id="o2ei"></amp-addthis>', $replace_code, $data['detail']->ic_content);
			}
		}
		
		//AMP的标签 end

        //页面中有价格标签，查出价格并替换内容
        $price_item_array = $this->price_pregmatch($data['detail']->ic_content);
        if (!empty($price_item_array)) {
            foreach ($price_item_array as $price_item) {
                $price_date = !empty($price_item->price_date) ? $price_item->price_date : date('Y-m-d', time() + 86400 * 7); //当前时间7天后的价格
                $price_number = '';
                //优先读取新的价格体系
                $price = $this->CI->PrimeLinePrice_model->search($price_item->cli_no, 1, $price_item->cli_grade, false, false);
                if (!empty($price)) {
                    switch (strtoupper($price_item->price_people)) {
                        case 'A':
                            $price_number = $price->PLP_AdultUnitPrice;
                            break;
                        case 'C':
                            $price_number = $price->PLP_ChildUnitPrice;
                            break;
                        case 'B':
                            $price_number = $price->PLP_BabyUnitPrice;
                            break;
                        case 'R':
                            $price_number = $price->PLP_RoomDiffPrice;
                            break;
                        case 'AR':
                            $price_number = $price->PLP_AdultUnitPrice + $price->PLP_RoomDiffPrice; //成人加单间房差
                            break;
                        default :
                            $price_number = $price->CLP_TwoToFiveAdultPriceRMB;
                    }
                } else {
                    $price = $this->CI->Price_model->search($price_item->cli_no, 1, $price_item->cli_grade, false, false);
                    if (!empty($price)) {
                        switch ($price_item->person_size) {
                            case '1':
                                $price_number = $price->CLP_OneAdultPriceRMB;
                                break;
                            case '2'://25
                                $price_number = $price->CLP_TwoToFiveAdultPriceRMB;
                                break;
                            case '6'://69
                                $price_number = $price->CLP_SixToNineAdultPriceRMB;
                                break;
                            case '10':
                                $price_number = $price->CLP_OverTenAdultPriceRMB;
                                break;
                            default:
                                $price_number = $price->CLP_TwoToFiveAdultPriceRMB;
                        }
                    }
                }
                //把金额格式化为带有逗号(,)方便阅读，如 12,345
                $price_number = is_numeric($price_number) ? number_format($this->CI->currency->GetSiteMoney($price_number)) : $price_number;
                if (!empty($price_number)) {
                    $data['detail']->ic_content = str_replace($price_item->placeholder, $price_number, $data['detail']->ic_content);
                }
            }
        }


        //替换包价线路价格 begin

        $price_item_array = $this->package_price_pregmatch($data['detail']->ic_content);
        if (!empty($price_item_array)) {
            foreach ($price_item_array as $price_item) {
                $price_date = !empty($price_item->price_date) ? $price_item->price_date : date('Y-m-d', time() + 86400 * 3); //当前时间3天后的价格
                $price_number = '';
                //优先读取新的价格体系
                $price = $this->CI->BIZ_PackagePrice_model->search($price_item->pag_code, 1, $price_item->person_size, $price_date);
                if (!empty($price)) {
                    switch (strtoupper($price_item->price_people)) {
                        case 'A':
                            $price_number = $price->PKP_AdultPrice;
                            break;
                        case 'C':
                            $price_number = $price->PKP_ChildPrice;
                            break;
                        case 'B':
                            $price_number = $price->PKP_InfantPrice;
                            break;
                        default :
                            $price_number = $price->PKP_AdultPrice;
                    }
                }
                //把金额格式化为带有逗号(,)方便阅读，如 12,345
                $price_number = is_numeric($price_number) ? number_format($this->CI->currency->GetSiteMoney($price_number)) : $price_number;
                if (!empty($price_number)) {
                    $data['detail']->ic_content = str_replace($price_item->placeholder, $price_number, $data['detail']->ic_content);
                }
            }
        }

        //替换包价线路价格 end
//信息页面展示产品价格和表单  end/////////////////////////////////////////////
        return $data['detail']->ic_content;
    }

    //使用正则匹配出价格标签，返回一个价格数组
    private function price_pregmatch($content) {
        $price_array = array();
        $temp_array = array();
        $result = false;
        //#ah-1,lx,2,2016-01-23,A# 
        //线路代号,等级(st标准、lx豪华、ec经济),人等,时间,人型(A成人、C小孩、B婴儿、R单间房差、AR成人+房差)
        preg_match_all('^#[a-zA-Z0-9,-]+#^', $content, $temp_array);
        foreach ($temp_array[0] as $item) {
            $placeholder = $item;
            $item = str_replace('#', '', $item);
            $price_array = explode(',', $item);
            $cli_no = !empty($price_array[0]) ? $price_array[0] : false; //线路代号
            if (empty($cli_no)) {
                continue; //没有设置线路代号则进入下一条
            }
            $cli_grade = !empty($price_array[1]) ? $price_array[1] : false; //标准7001、豪华7002、经济7003
            switch (strtoupper($cli_grade)) {
                case 'ST':
                    $cli_grade = '7001';
                    break;
                case 'LX':
                    $cli_grade = '7002';
                    break;
                case 'EC':
                    $cli_grade = '7003';
                    break;
                default :$cli_grade = '7001';
            }
            $person_size = (!empty($price_array[2]) && is_numeric($price_array[2])) ? $price_array[2] : 2; //人等1,2-5,6-9,10，默认2人等
            //为了兼容以前的人等方式，把算数人等转换为单数 25=>2
            switch ($person_size) {
                case '25':
                    $person_size = '2';
                    break;
                case '69':
                    $person_size = '6';
                    break;
            }
            $price_date = !empty($price_array[3]) ? $price_array[3] : false; //价格时间
            $price_people = !empty($price_array[4]) ? $price_array[4] : 'A'; //A成人、C小孩、B婴儿、R单间房差
            $result[] = (object) array('placeholder' => $placeholder, 'cli_no' => $cli_no, 'cli_grade' => $cli_grade, 'person_size' => $person_size, 'price_date' => $price_date, 'price_people' => $price_people);
        }
        return $result;
    }

    //使用正则匹配出包价线路价格标签，返回一个价格数组
    private function package_price_pregmatch($content) {
        $price_array = array();
        $temp_array = array();
        $result = false;
        //{shsic-11,2,2016-01-23,A}  线路代号，人等，时间，人型
        preg_match_all('^\{[a-zA-Z0-9,-]+\}^', $content, $temp_array);
        foreach ($temp_array[0] as $item) {
            $placeholder = $item;
            $item = str_replace('{', '', $item);
            $item = str_replace('}', '', $item);
            $price_array = explode(',', $item);
            $pag_code = !empty($price_array[0]) ? $price_array[0] : false; //线路代号
            if (empty($pag_code)) {
                continue; //没有设置代号则进入下一条
            }
            $person_size = (!empty($price_array[1]) && is_numeric($price_array[1])) ? $price_array[1] : 2; //人等1,2-5,6-9,10，默认2人等
            $price_date = !empty($price_array[2]) ? $price_array[2] : false; //价格时间
            $price_people = !empty($price_array[3]) ? $price_array[3] : 'A'; //A成人、C小孩、B婴儿
            $result[] = (object) array('placeholder' => $placeholder, 'pag_code' => $pag_code, 'person_size' => $person_size, 'price_date' => $price_date, 'price_people' => $price_people);
        }
        return $result;
    }

}
