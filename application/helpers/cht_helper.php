<?php

/**
 * PHP 301 转向
 * @param $url String 转向的URL
 */
function php_301($url = '') {
    if (!empty($url)) {
        header("Location: " . $url, true, 301);
        return;
    } else {
        log_message('error', '错误的301转向');
        echo '404';
    }
}

/**
 * 获取iis rewrite之前的原始url
 */
function get_origin_url() {
    if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
        $origin_url = $_SERVER['HTTP_X_REWRITE_URL'];
    } else {
        $origin_url = $_SERVER['REQUEST_URI'];
    }
    return str_replace(array(
        '///',
        '/index.php',
        '/info.php',
        '@cache@refresh'), array(
        '/',
        '/',
        '/',
        ''), urldecode($origin_url));
}

function format_date($value) {
    if (!empty($value)) {
        return date("M. j, Y", strtotime($value));
    } else {
        return '';
    }
}

//由下方法ReplaceFieldName修改，由于AH需求全英文所以不需替换中文 lzq
function ReplaceFieldName($fields) {
    $CI = &get_instance();
    $CI->load->model('Orders_model');

    $OrderDetailText = '';
    foreach ($fields as $key => $value) {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        switch ($key) {
            case 'adultsNumber':
                $OrderDetailText .= 'Adults' . ':' . $value . "\n";
                break;
            case 'ChildrenNumber':
                $OrderDetailText .= 'Youths' . ':' . $value . "\n";
                break;
            case 'BabiesNumber':
                $OrderDetailText .= 'Children' . ':' . $value . "\n";
                break;
            case 'cli_tourdays':
                $OrderDetailText .= 'Trip Length' . ':' . $value . "\n";
                break;
			case 'tourdays':
                $OrderDetailText .= 'Trip Length' . ':' . $value . "\n";
                break;
            case 'starting_date':
            case 'Date_Start':
            case 'Date_Start_Mobile':
            case 'date_start':
                if (!empty($value)) {
                    $OrderDetailText .= 'date_start:' . date("M. j, Y", strtotime($value)) . "\n";
                }           
                break;
            case 'flexible':
            case 'daysFlexible':
            case 'flexible_date':
                $OrderDetailText .= 'Flexible' . ':' . $value . "\n";
                break;
            case 'hotel':
                $OrderDetailText .= 'Hotel' . ':' . $value . "\n";
                break;
            case 'guiding':
                $OrderDetailText .= 'Guiding' . ':' . $value . "\n";
                break;
            case 'city':
                $OrderDetailText .= 'Expected cities' . ':' . $value . "\n";
                break;
			case 'Destination':
                $OrderDetailText .= 'Destination' . ':' . $value . "\n";
                break;	
            case 'additionalrequirements':
                $OrderDetailText .= 'Additional request' . ':' . $value . "\n";
                break;
            case 'name':
            case 'realname':
                $OrderDetailText .= "\n\n" . 'Name' . ':' . $value . "\n";
                break;
            case 'product_code':
                $OrderDetailText .= "\n\n" . $key . ':' . $value . "\n";
                break;
            case 'gender':
                if ($value == 100001) {
                    $OrderDetailText .= 'Gender' . ':' . 'Man' . "\n";
                } elseif($value == 100003) {
                    $OrderDetailText .= 'Gender' . ':' . 'Woman' . "\n";
                }else{
					$OrderDetailText .= "\n\n" . 'Gender' . ':' . 'Neutual' . "\n";
				}
                break;
            case 'email':
                $OrderDetailText .= 'Email' . ':' . $value . "\n";
                break;
            case 'PhoneNo':
                $OrderDetailText .= 'Telephone' . ':' . $value . "\n";
                break;
            case 'seriousBooking':
                $OrderDetailText .= 'Serious Booking' . ':' . $value . "\n";
                break;
			case 'ic_title':
                $OrderDetailText .= 'Interested in the itinerary' . ':' . $value . "\n";
                break;
			// case 'url':
            //     $OrderDetailText .= '来源页面' . ':' . $value . "\n";
            //     break;
			case 'TicketType':
				$OrderDetailText .= 'Which Location' . ':' . $value . "\n";
				break;	
			case 'TicketStandard':
				$OrderDetailText .= 'Ticket Type' . ':' . $value . "\n";
				break;            
            case '__grecaptcha_token__':
              case 'payment_required':
                break;
            default:
                if (!empty($value)) {
                    $OrderDetailText .= $key . ':' . $value . "\n";
                }
        }
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        $OrderDetailText .= '来源页面：' . $_SERVER['HTTP_REFERER'];
    }

    switch (check_device()) {
        case 'mobile':
            $OrderDetailText =  $OrderDetailText . "\n" . 'Device:mobile';
            break;
        case 'tablet':
            $OrderDetailText = $OrderDetailText . "\n" . 'Device:tablet';
            break;
        default:
            $OrderDetailText = $OrderDetailText . "\n". 'Device:computer';
    }

    return $OrderDetailText;
}

function GetChineseFieldName($name) {
    $name = strtolower($name);
    $name_arr = array(
        'realname' => '客人姓名',
        'email' => '电子邮箱',
        'isfrom' => '订单',
        'gender' => '性别',
        '100001' => '男',
        '100002' => '女',
        '100003' => '女',
        'title' => '性别',
        'nationality' => '国籍',
        'destinationcode2' => 'destinationcode2',
        'email2' => '备用邮箱',
        'otheremail' => '备用邮箱',
        'phoneno' => '电话号码',
        'phone' => '电话号码',
        'additionalrequirements' => '更多需求',
        'promocode' => '优惠码',
        'newsletter' => '是否预定newsletter',
        'cli_no' => '线路代号',
        'cli_tourtitle' => '线路名称',
        'cli_tourdays' => '线路时长',
        'cli_price' => '线路价格',
        'guidelanguage' => '导游语种',
        'otherguidelanguage' => '备用导游语种',
        'tourspecial' => '选中的城市',
        'sc' => '选中的城市',
        'tourspecial2' => '选择的景点',
        'sc2' => '选择的景点',
        'flexiblecheck' => '是否是固定行程日期',
        'flexiblecheckselect' => '是否是固定行程日期',
        'flexible_date_month' => '大致的月份',
        'flexible_date_year' => '大致的年份',
        'staying_days' => '旅行天数',
        'preferredtransport' => '交通方式',
        'otherpreferredtransport' => '备选交通方式',
        'breakfast' => '早餐选择',
        'lunch' => '午餐选择',
        'dinner' => '晚餐选择',
        'hotelclass' => '酒店星级',
        'numberofrooms' => '酒店房间数',
        'roomrequirement' => '房间要求',
        'roomrequirementselect' => '房间要求',
        'starting_date' => '开始时间',
        'ending_date' => '结束时间',
        'adultenum' => '成人数',
        'adultsnumber' => '成人数',
        'childnum' => '小孩数',
        'childrennumber' => '小孩数',
        'babynum' => '婴儿数',
        'babiesnumber' => '婴儿数',
        'cli_grade' => '线路星级',
        '7001' => '四星',
        '7002' => '五星',
        '7003' => '三星',
        'subject' => '订单主题',
        'cli_sn' => '线路编号',
        'season' => '淡旺季(1旺季2淡季)',
        'aperson' => '旅客人数',
        'guidestyle' => '导游',
        'adult_num' => '成人数',
        'child_num' => '儿童数',
        'baby_num' => '婴儿数',
        'twin_num' => '无效字段',
        'share_num' => '无效字段',
        'national' => '国籍',
        'other_request' => '其他请求',
        'shipname' => '游船',
        'rdate' => '发船日期',
        'days' => '天数',
        'ship_sn' => '游船SN',
        'room' => '房型',
        'no_ajax' => '传值类型（外联不用管这项）',
        'cm_number' => '团队类型',
        'cm_city' => '目的地',
        'sections' => '子项目',
        'cm_hotelstar' => '酒店等级',
        'cm_guidelang' => '导游语种',
        'cm_traffic' => '交通工具',
        'cm_guidetime' => '导游服务',
        'date_start' => '出发时间',
        'Date_Start' => '出发时间',
        'date_end' => '结束时间',
        'from_guang_jiao_hui' => '广交会订单',
        'price' => '预算/价格/等级',
        'youlun_name' => '游轮订单-游轮',
        'youlun_date' => '游轮订单-出发日期',
        'youlun_gangkou' => '游轮订单-港口城市',
        'youlun_num' => '游轮订单-人数',
        'flexible' => '日期是否可变更',
        'post_url' => '订单来源/着陆页',
        'q_url' => '订单来源/着陆页',
        'allnumber' => '人数',
        'passport_text' => '护照',
        'birth_text' => '出生日期',
        'bloodstyle' => '血型',
        'tshirt' => 'T恤尺寸',
        'malasong' => '马拉松',
        'malasong_else' => '马拉松其他需求',
        'malasong_exp' => '马拉松参赛经验',
        'guide_old' => '客人年纪',
        'OoPdest' => '火车发站-到站',
        'OoPDepartureTime' => '火车出发日期',
        'business_guide' => '是否需要导游',
        'business_attraction' => '景点',
        'business_attraction_else' => '其他感兴趣的景点',
        'business_request' => '其他需求',
        'business_date' => '出发日期',
        'business_guidelang' => '导游语种',
        'tbgp_date' => '固定发团日期',
        'sex_text' => '性别');
    if (isset($name_arr[$name])) {
        return $name_arr[$name];
    } else {
        return $name;
    }
}

//来源终端 tablet mobile desktop
function check_device() {
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $ua = $_SERVER['HTTP_USER_AGENT'];
    } else {
        $ua = '';
    }
    ## This credit must stay intact (Unless you have a deal with @lukasmig or frimerlukas@gmail.com
    ## Made by Lukas Frimer Tholander from Made In Osted Webdesign.
    ## Price will be $2
    $iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
    $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
    $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)

    if (!function_exists('androidTablet')) {

        function androidTablet($ua) { //Find out if it is a tablet
            if (strstr(strtolower($ua), 'android')) { //Search for android in user-agent
                if (!strstr(strtolower($ua), 'mobile')) { //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
                    return true;
                }
            }
        }

    }
    $androidTablet = androidTablet($ua); //Do androidTablet function
    $ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent

    if ($androidTablet || $ipad) { //If it's a tablet (iPad / Android)
        return 'tablet';
    } elseif ($iphone && !$ipad || $android && !$androidTablet || $windowsPhone) { //If it's a phone and NOT a tablet
        return 'mobile';
    } else { //If it's not a mobile device
        return 'desktop';
    }
}

//使用正则匹配出价格标签，返回一个价格数组
function price_pregmatch($content) {
    $price_array = array();
    $temp_array = array();
    $result = false;
    //#ah-1,lx,25,2016-01-23#
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
        switch ($cli_grade) {
            case 'st':
                $cli_grade = '7001';
                break;
            case 'lx':
                $cli_grade = '7002';
                break;
            case 'ec':
                $cli_grade = '7003';
                break;
            default :$cli_grade = false;
        }
        $person_size = !empty($price_array[2]) ? $price_array[2] : false; //人等1,2-5,6-9,10
        $price_date = !empty($price_array[3]) ? $price_array[3] : false; //价格时间
        $result[] = (object) array('placeholder' => $placeholder, 'cli_no' => $cli_no, 'cli_grade' => $cli_grade, 'person_size' => $person_size, 'price_date' => $price_date);
    }
    return $result;
}


    function GET_HTTP($url, $data = '', $method = 'GET') {
        $curl = curl_init(); // 启动一个CURL会话  
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查  
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在  
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $HTTP_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $HTTP_USER_AGENT); // 模拟用户使用的浏览器  
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer  
        if ($method == 'POST' && !empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包  
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 45); // 设置超时限制防止死循环  
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
        $tmpInfo = curl_exec($curl); // 执行操作  
        $errno = curl_errno($curl);
        if ($errno !== 0) {
            return false;
            $error_message = $errno . ' ' . curl_error($curl); //记录错误日志
            log_message('error', "train/get_http curl {$error_message}");
        }
        curl_close($curl); //关闭CURL会话  
        return $tmpInfo; //返回数据
    }
	
	//get发送请求
	function get_data($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
	
	//城市名字转换
	function exchange_cityId($city){
		$city = str_replace('-',' ',$city);
		switch ($city){
			case 'yangon':
				return 1481709;	
			case 'mandalay':
				return 1311874;	
			case 'bagan':
				return 1729191;	
			case 'inle lake':
				return 1293960;
			case 'ngapali beach':
				return 1298852;
			case 'hanoi':
				return 1561096;
			case 'hoi an':
				return 1561096;
			case 'ho chi minh city':
				return 1566083;	
			case 'sapa':	
				return 1687343;
			case 'halong bay':
				return 1580410;
			case 'mekong delta':
				return 1587974;
			case 'siem reap':
				return 1822214;
			case 'phnom penh':
				return 1830103;
			case 'battambang':	
				return 1831797;
			default:
				return $city;
		}
	}
	
	//图片转换
	function exchange_icon($num){
		$sun = array(1,2,30);
		$fewclouds = array(3,4,5,6,20,21);
		$scatteredclouds = array(7);
		$brokenclouds = array(8,32);
		$showerrain = array(12,13,14);
		$rain = array(15,16,17,18,29,42);
		$thunderstorm = array(24,29,31);
		$snow = array(19,24,29,31);
		$mist = array(11);
		if(in_array($num,$sun)){
			$string = '01d';
		}
		if(in_array($num,$fewclouds)){
			$string = '02d';
		}
		if(in_array($num,$scatteredclouds)){
			$string = '03d';
		}
		if(in_array($num,$brokenclouds)){
			$string = '04d';
		}
		if(in_array($num,$showerrain)){
			$string = '09d';
		}
		if(in_array($num,$rain)){
			$string = '10d';
		}
		if(in_array($num,$thunderstorm)){
			$string = '11d';
		}
		if(in_array($num,$snow)){
			$string = '13d';
		}
		if(in_array($num,$mist)){
			$string = '50d';
		}
		return $string;
	}

	
	function send_404(){
		// $CI = &get_instance();
        // $CI->output->set_status_header(404);
        // $data = array();
        // $data['seo_title'] = 'What Are You Looking for at Asia Highlights Travel';
        // $data['seo_keywords'] = '';
        // $data['seo_description'] = '';
        // $CI->load->view('header', $data);
        $CI->load->view('error/404');
        // $CI->load->view('footer');
	}
	
	function make_construct_tag($data){
		$i = 2;
		$return_tag = '';
		if(!empty($data)){
			$return_tag .= '
				<script type="application/ld+json">
				{
				  "@context": "http://schema.org",
				  "@type": "BreadcrumbList",
				  "itemListElement": [{
					"@type": "ListItem",
					"position": 1,
					"item": {
					  "@id": "/",
					  "name": "Homepage"
					}
				  }
			';
			foreach($data as $item){
				$return_tag .= '
					,{
						"@type": "ListItem",
						"position": '.$i.',
						"item": {
							"@id": "https://www.asiahighlights.com'.$item->ic_url.'",
							"name": "'.$item->ic_url_title.'"
						}
					}
				';
				$i++;
			}
			$return_tag .= ']}</script>';
		}
		return $return_tag;
	}
	
	function make_breadcrumblist($data){
		$return_breadcrumblist = '';
		if(!empty($data)){
			$return_breadcrumblist .= '<div class="crumbNav"><a href="/">Home</a>';
			$i = 1;
			$count = count($data);
			foreach($data as $item){
				if($i == $count){
					$return_breadcrumblist .= $item->ic_url_title;
				}else{
					$return_breadcrumblist .= '<a href="'.$item->ic_url.'">'.$item->ic_url_title.'</a>';
				}
				$i++;
			}
			$return_breadcrumblist .= '</div>';
		}
		return $return_breadcrumblist;
	}
