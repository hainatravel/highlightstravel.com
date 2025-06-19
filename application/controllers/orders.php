<?php

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

define('IS_GET', strtolower($_SERVER["REQUEST_METHOD"]) == 'get');

class Orders extends CI_Controller {

  public $site_code;
  public $third_part;

  /**
   * Orders constructor.
   */
  function __construct() {
    parent::__construct();
    $this->load->model('Orders_model');
    $this->load->model('CustomerLineInfo_model');
    $this->site_code = strtolower($this->config->item('Site_Code'));
    //屏蔽掉非法IP49.157.0.226
    if ($this->input->ip_address() == '116.93.127.114' || $this->input->ip_address() == '116.202.14.3') {
      send_404();
      die();
    }
  }

  public function index() {
    redirect();
  }

  //水灯节表单入库
  public function lantern_save() {
    $this->prevent_spam_order();
    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);

    $this->Orders_model->COLI_Servicetype = 'T';
    $emailtitle = 'Asia Highlights Enquiry Confirmation';
    $this->Orders_model->COLI_sourcetype = '32113';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19009';
    $this->Orders_model->COLI_OrderType = '19009';
    $this->Orders_model->COLI_PersonNum = $this->input->post('adult');
    $this->Orders_model->COLI_ChildNum = $this->input->post('kid_0_7_yrs');

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $fullname = $this->input->post('fullname');
    $this->Orders_model->MEI_FirstName = $fullname;

    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    $product_code = $this->input->post('product_code');
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->COLI_OrderStartDate = date('Y-m-d', strtotime($this->input->post('ticket_date')));

    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

    $external_site_map = array(
      78006 => 'facebook',
      78010 => 'instagram',
      78011 => 'pin',
      78014 => 'youtube',
      78017 => 'reddit',
      78023 => 'xiaohongshu',
    );

    $Line_class = $this->Orders_model->COLI_LineClass;
    // Facebook, Instagram, Pinterest, Youtube 要设置为站外订单
    if (!empty($Line_class) && array_key_exists($Line_class, $external_site_map)) {
      $this->Orders_model->COLI_WebCode = 'GH_ZWQD_HW';
    }

    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);

    //发送邮件给客人
    $email_data = array(
      'full_name' => $this->input->post('fullname'),
      'email' => $this->input->post('email'),
      'starting_date' => format_date($this->input->post('ticket_date')),
      'contact_info' => $this->input->post('PhoneNo'),
      'itinerary' => $this->input->post('itinerary'),
      'requirements' => $this->input->post('form_additionalrequirements'),
      'country_code' => $this->input->post('country_code'),
      'ticket_type' => $this->input->post('ticket_type'),
    );

    $email_text = $this->load->view('ah/email/lantern-festival', $email_data, true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      $email_data['full_name'],
      $email_data['email'],
      "Asia highlights has receive your inquiry",
      $email_text
    );

    $payment_description = $this->input->post('payment_description');
    if (empty($payment_description)) {
      $payment_description = 'Booking Yi Peng Festival Tickets';
    }

    //生成支付链接
    $this->load->library('Currency');
    $addurl = '';
    $totalprice = $this->input->post('total_price');

    // FB, ins, 小红书 订单要 95 折（四舍五入）
    if ($Line_class == 78006 || $Line_class == 78010 || $Line_class == 78023) {
      $totalprice = round($totalprice * 0.95, 2);
    }

    $total_rmb = $this->currency->get_USD_RMB_SUM($totalprice);
    $signstr = 'currency=USD&order_id=' . $this->Orders_model->COLI_ID . '_T&rmb_amount=' . $total_rmb . '&total_amount=' . $totalprice . '&key=7a46484300f04031b42fdd44559578e4';
    $sign = md5($signstr);
    $addurl .= base64_encode('order_id=' . $this->Orders_model->COLI_ID . '_T&subject=' . $payment_description . '&body=' . $payment_description . '&total_amount=' . $totalprice . '&currency=USD&rmb_amount=' . $total_rmb . '&sign=' . $sign . '&lg=en_US&return_url=https://www.asiahighlights.com/orders/thankyou?inquire');
    $payurl = 'https://secure.chinahighlights.com/pay/paymentservice/?' . $addurl;
    //跳转到thankyou页面
    redirect($payurl);
  }

  // 新年倒计时表单入库
  public function new_year_countdown_save() {
    $this->prevent_spam_order();
    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);

    $this->Orders_model->COLI_Servicetype = 'T';
    $emailtitle = 'Asia Highlights Enquiry Confirmation';
    $this->Orders_model->COLI_sourcetype = '32113';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19009';
    $this->Orders_model->COLI_PersonNum = $this->input->post('adult');
    $this->Orders_model->COLI_ChildNum = $this->input->post('kid_0_7_yrs');

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $fullname = $this->input->post('fullname');
    $this->Orders_model->MEI_FirstName = $fullname;

    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    $product_code = $this->input->post('product_code');
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->COLI_OrderStartDate = date('Y-m-d', strtotime($this->input->post('ticket_date')));

    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

    if (!empty($third_webcode)) {
      $this->Orders_model->COLI_WebCode = $third_webcode;
    }

    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);

    // 发送邮件给客人
    $email_data = array(
      'full_name' => $this->input->post('fullname'),
      'email' => $this->input->post('email'),
      'starting_date' => format_date($this->input->post('ticket_date')),
      'contact_info' => $this->input->post('PhoneNo'),
      'itinerary' => $this->input->post('itinerary'),
      'requirements' => $this->input->post('form_additionalrequirements'),
      'country_code' => $this->input->post('country_code'),
      'ticket_type' => $this->input->post('ticket_type'),
    );

    $email_text = $this->load->view('ah/email/new-year-countdown', $email_data, true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      $email_data['full_name'],
      $email_data['email'],
      "Asia highlights has receive your inquiry",
      $email_text
    );

    $payment_description = 'Chiang Mai CAD New Year Countdown to 2025 Festival Ticket';

    //生成支付链接
    $this->load->library('Currency');
    $addurl = '';
    $totalprice = $this->input->post('total_price');
    $total_rmb = $this->currency->get_USD_RMB_SUM($totalprice);
    $signstr = 'currency=USD&order_id=' . $this->Orders_model->COLI_ID . '_T&rmb_amount=' . $total_rmb . '&total_amount=' . $totalprice . '&key=7a46484300f04031b42fdd44559578e4';
    $sign = md5($signstr);
    $addurl .= base64_encode('order_id=' . $this->Orders_model->COLI_ID . '_T&subject=' . $payment_description . '&body=' . $payment_description . '&total_amount=' . $totalprice . '&currency=USD&rmb_amount=' . $total_rmb . '&sign=' . $sign . '&lg=en_US&return_url=https://www.asiahighlights.com/orders/thankyou?inquire');
    $payurl = 'https://secure.chinahighlights.com/pay/paymentservice/?' . $addurl;
    redirect($payurl);
  }

  public function test_lantern_email() {

    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);

    $this->Orders_model->COLI_Servicetype = 'T';
    $this->Orders_model->COLI_sourcetype = '32113';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19009';
    $this->Orders_model->COLI_PersonNum = $this->input->post('adult');
    $this->Orders_model->COLI_ChildNum = $this->input->post('kid_0_7_yrs');

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $fullname = $this->input->post('fullname');
    $this->Orders_model->MEI_FirstName = $fullname;

    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    $product_code = $this->input->post('product_code');
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->COLI_OrderStartDate = date('Y-m-d', strtotime($this->input->post('ticket_date')));

    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

    //发送邮件给客人
    $email_data = array(
      'full_name' => $this->input->post('fullname'),
      'email' => $this->input->post('email'),
      'starting_date' => format_date($this->input->post('ticket_date')),
      'contact_info' => $this->input->post('PhoneNo'),
      'itinerary' => $this->input->post('itinerary'),
      'requirements' => $this->input->post('form_additionalrequirements'),
      'country_code' => $this->input->post('country_code'),
      'ticket_type' => $this->input->post('ticket_type'),
    );

    $email_text = $this->load->view('ah/email/lantern-festival', $email_data, true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      $email_data['full_name'],
      $email_data['email'],
      "Asia highlights has receive your inquiry",
      $email_text
    );
  }

  public function tailormade_save() {
    $this->prevent_spam_order();

    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';

    $emailtitle = 'Asia Highlights Enquiry Confirmation';
    //默认就是TM表单
    $this->Orders_model->COLI_sourcetype = '32003';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';

    $adultNumber = intval($this->input->post('adult_18_plus'));
    //
    $childrenNumber = $this->input->post('children_3_9');
    $teenagerNumber = $this->input->post('teenager_10_17');
    $infantNumber = $this->input->post('infant_0_2');
    $personNumber = intval($adultNumber) + intval($teenagerNumber);
    $this->Orders_model->COLI_PersonNum = $personNumber;
    $this->Orders_model->COLI_ChildNum = $childrenNumber;
    $this->Orders_model->COLI_BabyNum = $infantNumber;
    $travelerNumber = intval($adultNumber) + intval($teenagerNumber) + intval($childrenNumber) + intval($infantNumber);
    //
    $this->Orders_model->COLI_Days = $this->input->post('trip_length');
    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $this->Orders_model->MEI_FirstName = $this->input->post('name');
    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;

    $fullname = $this->input->post('name');

    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    $product_code = $this->input->post('product_code');
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $order_start_date = $this->input->post('date_start');
    // starting_date没有值的时候$orderStartDate var_dump为false，
    // 需要转换为NULL数据库才会为NULL值
    if (empty($order_start_date)) {
      $order_start_date = NULL;
    } else {
      $order_start_date = date('Y-m-d', strtotime($order_start_date));
    }
    $this->Orders_model->COLI_OrderStartDate = $order_start_date;
    $this->Orders_model->MEI_Gender = $this->input->post('gender');
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

    //是否来至第三方合作网站
    $third_webcode = $this->input->post('third_webcode');
    if (empty($third_webcode)) {
      $third_webcode = $this->input->cookie('third_code');
      $this->input->set_cookie('third_code', '', '');
      $this->input->set_cookie('third%5Fcode', '', '');
    }
    if (!empty($third_webcode)) {
      $this->Orders_model->COLI_WebCode = $third_webcode;
    }

    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);
    //发送邮件给客人
    $selected_dest_combos = $this->input->post('destination_combos');
    $selected_dest = $this->input->post('destination');
    $selected_dest_text = $selected_dest_combos;
    if (!empty($selected_dest)) {
      $selected_dest_text .= implode(',', $selected_dest);
    }
    $selected_dest_text .= ', ' . $this->input->post('other_destinations');
    $starting_date_value = $order_start_date == NULL ? '' : format_date($order_start_date);
    $email_data = array(
      'full_name' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'nationality' => $this->input->post('country_code'),
      'travelers' => $travelerNumber,
      'trip_length' => $this->input->post('trip_length'),
      'hotel_style' => $this->input->post('hotel'),
      'destinations' => $selected_dest_text,
      'starting_date' => $starting_date_value,
      'contact_info' => $this->input->post('PhoneNo'),
      'requirements' => $this->input->post('additional_requirements'),
    );
    $this->email_customer($email_data);

    redirect(site_url('orders/thankyou?tailormade'));
  }

  public function inquiry_save() {

    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';
    $emailtitle = 'Asia Highlights Enquiry Confirmation';

    //默认就是产品订单
    $this->Orders_model->COLI_sourcetype = '32001';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';
    $this->Orders_model->COLI_PersonNum = $this->input->post('adultnumber');
    $this->Orders_model->COLI_ChildNum = $this->input->post('kidnumber');
    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $this->Orders_model->MEI_LastName = $this->input->post('name');
    $fullname = $this->input->post('name');
    $this->Orders_model->MEI_Nationality = $this->Orders_model->GetNationalityID($this->input->post('Nationality'));

    $this->Orders_model->COLI_ProductSN = $this->input->post('cli_sn');
    $this->Orders_model->COLI_OrderStartDate = $this->input->post('date_start');

    $this->Orders_model->MEI_Gender = $this->input->post('gender');
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

    //是否来至第三方合作网站
    $third_webcode = $this->input->post('third_webcode');
    if (empty($third_webcode)) {
      $third_webcode = $this->input->cookie('third_code');
      $this->input->set_cookie('third_code', '', '');
      $this->input->set_cookie('third%5Fcode', '', '');
    }
    if (!empty($third_webcode)) {
      $this->Orders_model->COLI_WebCode = $third_webcode;
    }

    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);
    //发送邮件给客人
    $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $fullname, $this->input->post('email'), $emailtitle, $this->load->view('ah/email/inquiry_email', '', true));
    redirect(site_url('orders/thankyou'));
  }

  /**
   * 返回一个实际上无法成功的 200 状态码，欺骗攻击者误以为成功
   */
  public function fake_200() {
    header('HTTP/1.1 200 OK');
    header("status: 200 OK");

    $url = 'https://www.asiahighlights.com/orders/thankyou';
    $options = [
      'http' => [
        'header' => "Content-type: ".$_SERVER['CONTENT_TYPE']."\r\n".
                    "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n"
      ]
    ];

    $context = stream_context_create($options);
    echo file_get_contents($url, false, $context);

    exit;
  }

  public function output_403() {
    header('HTTP/1.1 403 Forbidden');
    header("status: 403 Forbidden");
    exit;
  }

  private function prevent_spam_order() {
    $this->verifying_grecaptcha_token();
    if ($this->input->get_post("email") == 'sample@email.tst' ||
      false !== stripos($this->input->get_post("email"), "sample@email.tst")
    ) {
      log_message('error', "reject by Acunetix scan Detected. IP: " . $this->input->ip_address());
      $this->fake_200();
    }

    if (IS_GET) {
      $this->fake_200();
    }

    // 限制字符数量 2048 个。
    $requirements = $this->input->post('form_additionalrequirements') . $this->input->post('AdditionalRequirements2');

    if (!empty($requirements) && strlen($requirements) > 2048) {
      log_message('error', "requirements too long. IP: " . $this->input->ip_address());
      $this->fake_200();
    }

    if (FALSE === $this->detect_spam('realname') ||
      FALSE === $this->detect_spam('form_additionalrequirements') ||
      FALSE === $this->detect_spam('AdditionalRequirements2')) {
      log_message('error', "reject by remove html tags. IP: " . $this->input->ip_address());
      $this->fake_200();
    }

    // 屏蔽过于频繁的垃圾订单 IP。
    // 屏蔽 IP 不能太时间，需要时再使用以下方法（取消注释即可）
    // if (in_array($this->input->ip_address(), array("192.40.57.53", "164.132.203.193", "190.2.146.231", "167.235.3.218", "45.82.179.75"))) {
    //     $this->fake_200();
    // }

    if (in_array(strstr($this->input->get_post("email"), "@"), array("@asiahighlights.com", "@hainatravel.com"))) {
      // 内部测试邮箱，不做 IP 限制。
    } else {
      if (false === $this->Orders_model->ip_limit($this->input->ip_address())) {
        log_message('error', "reject by IP limit. IP: " . $this->input->ip_address());
        $this->fake_200();
      }
    }
  }

  // 旅行合作表单
  public function agency_save() {
    $this->prevent_spam_order();

    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';
    $this->Orders_model->COLI_sourcetype = '32008';
    $this->Orders_model->COLI_WebCode = 'GHTOBHW';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $this->Orders_model->MEI_FirstName = $this->input->post('name');
    $this->Orders_model->MEI_Nationality =
      $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));

    $product_code = $this->input->post('product_code');
    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->TourOrderSave();

    redirect(site_url('orders/thankyou?agency'));
  }

  // Newsletter 表单
  public function newsletter_save() {
    $this->prevent_spam_order();

    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';
    $this->Orders_model->COLI_sourcetype = '32165';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $this->Orders_model->MEI_FirstName = $this->input->post('name');

    $product_code = $this->input->post('product_code');
    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->TourOrderSave();

    $email_content = $this->load->view('ah/email/newsletter-thankyou', [], true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      $this->input->post('name'),
      $this->input->post('email'),
      "Asia highlights has receive your inquiry",
      $email_content
    );

    redirect('https://www.asiahighlights.com/orders/thankyou-newsletter?id=' . + $this->Orders_model->COLI_ID);
  }

  public function test_email() {
    $email_content = $this->load->view('ah/email/newsletter-thankyou', [], true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      'lyj',
      'lyj@hainatravel.com',
      "Asia highlights has receive your inquiry",
      $email_content
    );
  }

  //快速表单
  public function quick_inquiry_save() {
    $this->prevent_spam_order();

    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';
    $emailtitle = 'Asia Highlights Enquiry Confirmation';
    $this->Orders_model->COLI_sourcetype = '32113';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';

    $adultNumber = intval($this->input->post('adult_18_plus'));
    $childrenNumber = $this->input->post('children_3_9');
    $teenagerNumber = $this->input->post('teenager_10_17');
    $infantNumber = $this->input->post('infant_0_2');
    $personNumber = intval($adultNumber) + intval($teenagerNumber);
    $this->Orders_model->COLI_PersonNum = $personNumber;
    $this->Orders_model->COLI_ChildNum = $childrenNumber;
    $this->Orders_model->COLI_BabyNum = $infantNumber;

    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $this->Orders_model->MEI_FirstName = $this->input->post('name');
    $fullname = $this->input->post('name');

    $this->Orders_model->COLI_ProductSN = $this->input->post('cli_sn');

    $order_start_date = $this->input->post('date_start');
    // starting_date没有值的时候 $orderStartDate var_dump 为 false，
    // 需要转换为 NULL 数据库才会为 NULL 值
    $order_start_date = empty($order_start_date) ? NULL : date('Y-m-d', strtotime($order_start_date));

    $this->Orders_model->COLI_OrderStartDate = $order_start_date;
    $this->Orders_model->MEI_Gender = $this->input->post('gender');
    $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');
    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;

    $product_code = $this->input->post('product_code');
    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }

    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);
    //发送邮件给客人
    $email_data = array(
      'full_name' => $fullname,
      'email' => $this->input->post('email'),
      'starting_date' => format_date($this->input->post('date_start')),
      'contact_info' => $this->input->post('PhoneNo'),
      'itinerary' => $this->input->post('itinerary'),
      'requirements' => $this->input->post('additional_requirements'),
    );
    $this->email_customer($email_data);

    //
    $paymentRequired = $this->input->post('payment_required');
    if (empty($paymentRequired)) {
      redirect(site_url('orders/thankyou?inquire'));
    } else {
      $this->load->library('Currency');
      $addurl = '';
      $totalprice = $this->input->post('total_price');
      $total_rmb = $this->currency->get_USD_RMB_SUM($totalprice);
      $signstr = 'currency=USD&order_id=' . $this->Orders_model->COLI_ID . '_T&rmb_amount=' . $total_rmb . '&total_amount=' . $totalprice . '&key=7a46484300f04031b42fdd44559578e4';
      $sign = md5($signstr);
      $addurl .= base64_encode('order_id=' . $this->Orders_model->COLI_ID . '_T&subject=Booking Mini-Group Tour&body=Booking Mini-Group Tour&total_amount=' . $totalprice . '&currency=USD&rmb_amount=' . $total_rmb . '&sign=' . $sign . '&lg=en_US&return_url=https://www.asiahighlights.com/orders/thankyou?inquire');
      $payurl = 'https://secure.chinahighlights.com/pay/paymentservice/?' . $addurl;

      redirect($payurl);
    }
  }

  //新版tailormade入库程序
  public function triprequest_save() {
    //$this->form_validation->set_rules('Destination', 'lang:Destination', 'required');
    //$this->form_validation->set_rules('Date_Start', 'lang:Date_Start', 'required');
    //$this->form_validation->set_rules('hotelStyle', 'lang:hotelStyle', 'required');
    //$this->form_validation->set_rules('additionalrequirements', 'lang:additionalrequirements', 'required');
    //$this->form_validation->set_rules('gender', 'lang:Title', 'required');
    $this->form_validation->set_rules('Firstname', 'lang:Firstname', 'required');
    //$this->form_validation->set_rules('Lastname', 'lang:Lastname', 'required');
    $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
    //$this->form_validation->set_rules('Nationality', 'lang:Nationality', 'required');

    //$this->form_validation->set_rules('hotel', 'lang:hotel', 'required');
    //$this->form_validation->set_rules('tourdays', 'lang:tourdays', 'required');
    if ($this->form_validation->run() == false) {
      $data = array();
      foreach ($this->form_validation->_error_array as $key => $value) {
        if ($key == 'Destination') {
          $key = 'destinations';
        }
        $data[] = array('name' => $key, 'value' => $value);
      }
      if ($this->input->post('no_ajax')) {
        $vali_string = '';
        foreach ($data as $v) {
          $vali_string .= $v['name'] . ' => ' . $v['value'] . '  ';
        }
        echo ('<script>alert("' . $vali_string . '");history.back();</script>');
      } else {
        echo json_encode($data);
      }
    } else {
      $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
      $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
      $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);

      $this->Orders_model->COLI_Servicetype = 'T';
      $emailtitle = 'Asia Highlights Enquiry Confirmation';
      if ($this->input->post('cli_sn')) {
        //含有cli_sn的是产品订单
        $this->Orders_model->COLI_sourcetype = '32001';
      } else {
        //不含有的是tailormade订单
        $this->Orders_model->COLI_sourcetype = '32003';
      }

      $this->convert_utm_source_to_lineclass();

      $this->Orders_model->COLI_GroupType = '19006';
      $this->Orders_model->COLI_OrderType = '19006';
      if (is_numeric($this->input->post('adultsNumber'))) {
        $this->Orders_model->COLI_PersonNum = $this->input->post('adultsNumber');
      }
      if (is_numeric($this->input->post('ChildrenNumber'))) {
        $this->Orders_model->COLI_ChildNum = $this->input->post('ChildrenNumber');
      }
      if (is_numeric($this->input->post('BabiesNumber'))) {
        $this->Orders_model->COLI_BabyNum = $this->input->post('BabiesNumber');
      }
      $this->Orders_model->MEI_MailList = $this->input->post('email');
      $this->Orders_model->MEI_Mail = $this->input->post('email2');
      /*
      $pos = strstr($this->input->post('realname'), ' ');
      if ($pos === false) {
      $this->Orders_model->MEI_FirstName = $this->input->post('realname');
      } else {
      $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('realname'));
      $this->Orders_model->MEI_LastName = $pos;
      }
       */
      $this->Orders_model->MEI_FirstName = $this->input->post('Firstname');
      $this->Orders_model->MEI_LastName = $this->input->post('Lastname');
      $fullname = $this->input->post('Firstname') . $this->input->post('Lastname');
      $this->Orders_model->MEI_Nationality = $this->Orders_model->GetNationalityID($this->input->post('Nationality'));

      $this->Orders_model->COLI_ProductSN = $this->input->post('cli_sn');

      if ($this->input->post('Date_Start')) {
        $this->Orders_model->COLI_OrderStartDate = $this->input->post('Date_Start');
      } else {
        $this->Orders_model->COLI_OrderStartDate = $this->input->post('Date_Start_Mobile');
      }

      $this->Orders_model->MEI_Gender = $this->input->post('gender');
      $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

      //是否来至第三方合作网站
      $third_webcode = $this->input->post('third_webcode');
      if (empty($third_webcode)) {
        $third_webcode = $this->input->cookie('third_code');
        $this->input->set_cookie('third_code', '', '');
        $this->input->set_cookie('third%5Fcode', '', '');
      }
      if (!empty($third_webcode)) {
        $this->Orders_model->COLI_WebCode = $third_webcode;
      }

      //指定操作人
      if ($this->input->post('COLI_OPI_SN')) {
        $this->Orders_model->COLI_OPI_SN = $this->input->post('COLI_OPI_SN');
      }

      //print_r($this->load->view('orders/newemail_template', '', true));
      //die();
      $this->Orders_model->TourOrderSave();
      $this->Orders_model->SendMail($fullname, $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $emailtitle, $this->Orders_model->COLI_OrderDetailText);
      //发送邮件给客人 (20160504tailor_make)
      $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $fullname, $this->input->post('email'), $emailtitle, $this->load->view('orders/newemail_template', '', true));

      //是否AJAX提交？
      $no_ajax = $this->input->post('no_ajax');
      if (empty($no_ajax)) {
        $data[] = array('name' => 'go', 'value' => site_url('orders/thankyou'));
        echo json_encode($data);
      } else {
        $file_alias = $this->input->post('file_alias');
        redirect(site_url('orders/thankyou' . $file_alias));
      }
    }
  }

  public function question_save() {
    $this->form_validation->set_rules('realname', 'lang:realname', 'required');
    $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
    $this->form_validation->set_rules('aquestion', 'lang:aquestion', 'required');
    if ($this->form_validation->run() == false) {
      $data = array();
      foreach ($this->form_validation->_error_array as $key => $value) {
        $data[] = array('name' => $key, 'value' => $value);
      }
      echo json_encode($data);
    } else {
      bind_ip($this->input->ip_address());
      $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
      $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
      $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
      $this->Orders_model->COLI_Servicetype = 'T';
      $this->Orders_model->COLI_sourcetype = '32002';

      $this->convert_utm_source_to_lineclass();

      $this->Orders_model->COLI_GroupType = '19006';
      $this->Orders_model->COLI_OrderType = '19006';
      $this->Orders_model->MEI_MailList = $this->input->post('email');
      $pos = strstr($this->input->post('realname'), ' ');
      if ($pos === false) {
        $this->Orders_model->MEI_FirstName = $this->input->post('realname');
      } else {
        $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('realname'));
        $this->Orders_model->MEI_LastName = $pos;
      }
      $this->COLI_ProductSN = '';
      bind_email($this->Orders_model->MEI_MailList);
      $this->Orders_model->TourOrderSave();
      $this->Orders_model->SendMail($this->input->post('realname'), $this->input->
          post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), 'Question Orders', $this->Orders_model->COLI_OrderDetailText);

      //发送邮件给客人
      $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $this->input->post('realname'), $this->input->
          post('email'), 'Question Orders', $this->load->view('ah/email/email_template', '', true));

      //是否AJAX提交？
      $no_ajax = $this->input->post('no_ajax');
      if (empty($no_ajax)) {
        $data[] = array('name' => 'ok', 'value' => site_url('orders/question-thankyou/'));
        echo json_encode($data);
      } else {
        $file_alias = $this->input->post('file_alias');
        redirect(site_url('orders/question-thankyou/' . $file_alias));
      }
    }
  }

  public function question_thankyou() {
    $data = array();
    $this->html_do->head($data, 'r');
    $data['PPCCode'] = $this->lang->line('PPC_question');
    $this->load->view('orders/r_thankyou/' . $this->site_code, $data);
  }

  public function detect_spam($param_name) {
    $html_tag = '#<\s*\/?(meta|script|html|a|div|body|input|img|title|link|form)\s+[^>]*?>#im';
    $http_url = '/((https|http)?:\/\/)(?!www\.asiahighlights)\S+/';
    $chinese_string = '/(赢|美女|注册|领取|红包|彩金)/';
    $html_encode = '/&#(.*);/'; // 包含 HTML 编码的字符，如：&#25105;
    $tinyurl = '/www.tinyurl.com\S+/';
    $param_value = $this->input->post($param_name);
    $end_str = $param_value;
    $end_str = preg_replace($html_tag, '', $end_str);
    $end_str = preg_replace($http_url, '', $end_str);
    $end_str = preg_replace($chinese_string, '', $end_str);
    $end_str = preg_replace($html_encode, '', $end_str);
    $end_str = preg_replace($tinyurl, '', $end_str);
    return strcasecmp($param_value, $end_str) === 0;
  }

  /**
   *
   * contact-us.htm 订单入库
   *
   */
  public function contactus_save() {
    $this->prevent_spam_order();
    $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
    $this->Orders_model->COLI_SenderIP = $this->input->ip_address();

    $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
    $this->Orders_model->COLI_Servicetype = 'T';
    $this->Orders_model->COLI_sourcetype = '32007';

    $this->convert_utm_source_to_lineclass();

    $this->Orders_model->COLI_GroupType = '19006';
    $this->Orders_model->COLI_OrderType = '19006';
    $country_id = $this->Orders_model->get_country_id_by_code($this->input->post('country_code'));
    $this->Orders_model->MEI_Nationality = $country_id;
    $this->Orders_model->MEI_MailList = $this->input->post('email');
    $pos = strstr($this->input->post('name'), ' ');
    if ($pos === false) {
      $this->Orders_model->MEI_FirstName = $this->input->post('name');
    } else {
      $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('name'));
      $this->Orders_model->MEI_LastName = $pos;
    }

    $this->Orders_model->MEI_Phone = $this->input->post('contactInfo');
    $product_code = $this->input->post('product_code');
    // 根据产品编号(CLI_NO)查找并绑定产品SN(CLI_SN)
    if ($product_code) {
      $tour_obj = $this->CustomerLineInfo_model->search($product_code, 1);
      if (!empty($tour_obj)) {
        $this->Orders_model->COLI_ProductSN = $tour_obj->CLI_SN;
      }
    }
    $this->Orders_model->TourOrderSave();
    $this->Orders_model->SendMail($this->input->post('name'), $this->input->post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), 'Asia Highlights Enquiry Confirmation', $this->Orders_model->COLI_OrderDetailText);
    $country_code = $this->input->post('country_code');
    $contact_info = $country_code . ' ' . $this->input->post('contactInfo');
    //发送邮件给客人
    $email_data = array(
      'full_name' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'contact_info' => $contact_info,
      'requirements' => $this->input->post('additional_requirements'),
    );
    $this->email_customer($email_data);
    redirect(site_url('orders/thankyou?contactus'));
  }

  // 发送订单自动回复邮件
  public function email_customer($email_data) {
    $email_text = $this->load->view('ah/email/ah-auto-mail', $email_data, true);
    $this->Orders_model->SendMail(
      $this->config->item('Site_ServiceName'),
      $this->config->item('Site_ServiceEmail'),
      $email_data['full_name'],
      $email_data['email'],
      "Asia highlights has receive your inquiry",
      $email_text
    );
  }

  public function thankyou() {
    $data = array();
    $data['seo_title'] = 'Thank you for your inquiry | Asia Highlights';
    //$data['PPCCode'] = $this->lang->line('PPC_contact_us');
    $this->load->view('header', $data);
    $this->load->view('orders/thank_you', $data);
    $this->load->view('footer');
  }

  /**
   * 联系我们订单入库
   * @author lmr
   */
  public function callus_save() {
    $this->form_validation->set_rules('realname', 'lang:realname', 'required');
    $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
    $this->form_validation->set_rules('comments', 'lang:comments', 'required');
    if ($this->form_validation->run() == false) {
      $data = array();
      foreach ($this->form_validation->_error_array as $key => $value) {
        $data[] = array('name' => $key, 'value' => $value);
      }
      echo json_encode($data);
    } else {
      $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
      $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
      $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
      $this->Orders_model->COLI_Servicetype = 'T';
      $this->Orders_model->COLI_sourcetype = '32004';

      $this->convert_utm_source_to_lineclass();

      $this->Orders_model->COLI_GroupType = '19006';
      $this->Orders_model->COLI_OrderType = '19006';
      $this->Orders_model->MEI_MailList = $this->input->post('email');
      $pos = strstr($this->input->post('realname'), ' ');
      if ($pos === false) {
        $this->Orders_model->MEI_FirstName = $this->input->post('realname');
      } else {
        $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('realname'));
        $this->Orders_model->MEI_LastName = $pos;
      }
      $this->COLI_ProductSN = '';
      bind_email($this->Orders_model->MEI_MailList);
      $this->Orders_model->TourOrderSave();
      $this->Orders_model->SendMail($this->input->post('realname'), $this->input->
          post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), 'Contactus Orders', $this->Orders_model->COLI_OrderDetailText);
      //发送邮件给客人
      $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $this->input->post('realname'), $this->input->
          post('email'), 'Contactus Orders', $this->load->view('ah/email/email_template', '', true));
      $data[] = array('name' => 'ok', 'value' => site_url('orders/callus-thankyou/'));
      echo json_encode($data);
    }
  }

  public function callus_thankyou() {
    $data = array();
    $data['PPCCode'] = $this->lang->line('PPC_callus');
    $data['seo_title'] = 'Thank you for your inquiry | Asia Highlights';
    $this->load->view('header', $data);
    $this->load->view('orders/thank_you', $data);
    $this->load->view('footer');
  }

  //ch 过来的
  public function ch_tailormade_save() {
    $this->form_validation->set_rules('city', 'lang:city', 'required');
    $this->form_validation->set_rules('realname', 'lang:realname', 'required');
    //$this->form_validation->set_rules('nationality', 'lang:nationality', 'required');
    $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
    //$this->form_validation->set_rules('additionalrequirements', 'lang:additionalrequirements', 'required');
    //$this->form_validation->set_rules('cli_tourdays', 'lang:cli_tourdays', 'required');
    if ($this->form_validation->run() == false) {
      $data = array();
      foreach ($this->form_validation->_error_array as $key => $value) {
        $data[] = array('name' => $key, 'value' => $value);
      }
      if ($this->input->post('no_ajax')) {
        $vali_string = '';
        foreach ($data as $v) {
          $vali_string .= $v['name'] . ' => ' . $v['value'] . '  ';
        }
        echo ('<script>alert("' . $vali_string . '");history.back();</script>');
      } else {
        echo json_encode($data);
      }
    } else {
      $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
      $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
      $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
      $this->Orders_model->COLI_Servicetype = 'T';
      $this->Orders_model->COLI_sourcetype = '32108';

      $this->convert_utm_source_to_lineclass();

      $this->Orders_model->COLI_GroupType = '19006';
      $this->Orders_model->COLI_OrderType = '19006';
      if (is_numeric($this->input->post('adultsNumber'))) {
        $this->Orders_model->COLI_PersonNum = $this->input->post('adultsNumber');
      }
      if (is_numeric($this->input->post('ChildrenNumber'))) {
        $this->Orders_model->COLI_ChildNum = $this->input->post('ChildrenNumber');
      }
      if (is_numeric($this->input->post('BabiesNumber'))) {
        $this->Orders_model->COLI_BabyNum = $this->input->post('BabiesNumber');
      }
      $this->Orders_model->MEI_MailList = $this->input->post('email');
      $this->Orders_model->MEI_Mail = $this->input->post('email2');
      $pos = strstr($this->input->post('realname'), ' ');
      if ($pos === false) {
        $this->Orders_model->MEI_FirstName = $this->input->post('realname');
      } else {
        $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('realname'));
        $this->Orders_model->MEI_LastName = $pos;
      }
      $this->Orders_model->MEI_Nationality = $this->Orders_model->GetNationalityID($this->
          input->post('nationality'));
      $this->COLI_ProductSN = '';
      if ($this->input->post('Date_Start')) {
        $this->Orders_model->COLI_OrderStartDate = $this->input->post('Date_Start');
      }
      $this->Orders_model->MEI_Gender = $this->input->post('gender');
      $this->Orders_model->MEI_Phone = $this->input->post('PhoneNo');

      //是否来至第三方合作网站
      $third_webcode = $this->input->post('third_webcode');
      if (empty($third_webcode)) {
        $third_webcode = $this->input->cookie('third_code');
        $this->input->set_cookie('third_code', '', '');
        $this->input->set_cookie('third%5Fcode', '', '');
      }
      if (!empty($third_webcode)) {
        $this->Orders_model->COLI_WebCode = $third_webcode;
      }

      //指定操作人
      if ($this->input->post('COLI_OPI_SN')) {
        $this->Orders_model->COLI_OPI_SN = $this->input->post('COLI_OPI_SN');
      }
      $this->Orders_model->TourOrderSave();
      $this->Orders_model->SendMail($this->input->post('realname'), $this->input->
          post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), 'Tailor Made Orders', $this->Orders_model->COLI_OrderDetailText);
      //发送邮件给客人 (20160504tailor_make)
      $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $this->input->post('realname'), $this->input->post('email'), 'Tailor Made Orders', $this->load->view('ah/email/email_template', '', true));

      //是否AJAX提交？
      $no_ajax = $this->input->post('no_ajax');
      if (empty($no_ajax)) {
        $data[] = array('name' => 'go', 'value' => site_url('orders/thankyou'));
        echo json_encode($data);
      } else {
        // $file_alias = $this->input->post('file_alias');
        redirect("https://www.chinahighlights.com/forms/thankyou-asia-tours.asp");
      }
    }
  }

  public function tailormade_thankyou() {
    $data = array();
    $data['seo_title'] = 'Asia Highlights Travel';
    $this->load->view('header', $data);
    $this->load->view('orders/thank_you', $data);
    $this->load->view('footer');
    $this->output->cache(99999);
  }

  public function asia_tour() {
    $data = array();

    $this->form_validation->set_rules('cli_no', 'lang:cli_no', 'required');
    if ($this->form_validation->run() == false) {
      redirect();
    }

    $data['post_cli_no'] = $this->input->post('cli_no');
    $data['post_cli_sn'] = $this->input->post('cli_sn');
    $data['post_days'] = $this->input->post('cli_days');
    $data['post_destinations'] = $this->input->post('destinations');
    $data['adultsNumber'] = $this->input->post('adultsNumber');
    $data['ChildrenNumber'] = $this->input->post('ChildrenNumber');
    $data['BabiesNumber'] = $this->input->post('BabiesNumber');
    $data['post_Starting_Date'] = $this->input->post('Starting_Date');

    $this->load->view('header', $data);
    $this->load->view('orders/asia_tour_form');
    $this->load->view('footer');
  }

  public function asia_tour_save() {
    $this->form_validation->set_rules('realname', 'lang:realname', 'required');
    $this->form_validation->set_rules('nationality', 'lang:nationality', 'required');
    $this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
    $this->form_validation->set_rules('additionalrequirements', 'lang:additionalrequirements', 'required');
    $this->form_validation->set_rules('hotel', 'lang:hotel', 'required');
    $this->form_validation->set_rules('starting_date', 'lang:starting_date', 'required');
    if ($this->form_validation->run() == false) {
      $data = array();
      foreach ($this->form_validation->_error_array as $key => $value) {
        $data[] = array('name' => $key, 'value' => $value);
      }
      echo json_encode($data);
    } else {
      $this->Orders_model->COLI_ID = $this->Orders_model->MakeOrderNumber();
      $this->Orders_model->COLI_SenderIP = $this->input->ip_address();
      $this->Orders_model->COLI_OrderDetailText = ReplaceFieldName($_POST);
      $this->Orders_model->COLI_Servicetype = 'T';
      $this->Orders_model->COLI_sourcetype = '32001';

      $this->convert_utm_source_to_lineclass();

      $this->Orders_model->COLI_GroupType = '19001';
      $this->Orders_model->COLI_OrderType = '19001';
      $this->Orders_model->COLI_Name = $this->input->post('cli_no') . ' ' . $this->
        input->post('cli_tourtitle');
      $this->Orders_model->COLI_PersonNum = $this->input->post('adultsNumber');
      $this->Orders_model->COLI_ChildNum = $this->input->post('ChildrenNumber');
      $this->Orders_model->COLI_BabyNum = $this->input->post('BabiesNumber');
      $this->Orders_model->COLI_OrderStartDate = $this->input->post('starting_date');
      $this->Orders_model->COLI_Days = $this->input->post('cli_tourdays');

      $this->Orders_model->MEI_MailList = $this->input->post('email');
      $this->Orders_model->MEI_Mail = $this->input->post('email2');
      $pos = strstr($this->input->post('realname'), ' ');
      if ($pos === false) {
        $this->Orders_model->MEI_FirstName = $this->input->post('realname');
      } else {
        $this->Orders_model->MEI_FirstName = str_replace($pos, '', $this->input->post('realname'));
        $this->Orders_model->MEI_LastName = $pos;
      }
      $this->Orders_model->MEI_Nationality = $this->Orders_model->GetNationalityID($this->
          input->post('nationality'));
      $this->Orders_model->MEI_Gender = $this->input->post('gender');
      if (empty($this->Orders_model->MEI_Phone) || !isset($this->Orders_model->
        MEI_Phone)) {
        $this->Orders_model->MEI_Phone = @$this->input->post('PhoneNo');
      }
      $this->Orders_model->COLI_ProductSN = $this->input->post('cli_sn');

      //是否来至第三方合作网站
      $third_webcode = $this->input->post('third_webcode');
      if (empty($third_webcode)) {
        $third_webcode = $this->input->cookie('third_code');
        $this->input->set_cookie('third_code', '', '');
        $this->input->set_cookie('third%5Fcode', '', '');
      }
      if (!empty($third_webcode)) {
        $this->Orders_model->COLI_WebCode = $third_webcode;
      }
      $this->Orders_model->TourOrderSave();
      $this->Orders_model->SendMail($this->input->post('realname'), $this->input->
          post('email'), $this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), 'Tour Orders', $this->Orders_model->COLI_OrderDetailText);
      //发送邮件给客人(20160504inquiry_form)
      $this->Orders_model->SendMail($this->config->item('Site_ServiceName'), $this->config->item('Site_ServiceEmail'), $this->input->post('realname'), $this->input->
          post('email'), 'Tour Orders', $this->load->view('ah/email/email_template', '', true));

      $data[] = array('name' => 'go', 'value' => site_url('orders/asia_tour_thankyou'));
      echo json_encode($data);
    }
  }


  private function convert_utm_source_to_lineclass() {
    // 使用 UTM 跟踪广告链接
    $utm_source_map = array(
      'googleppc' => 78001,
      'bingppc' => 78003,
      'newsletter' => 78005,
      'facebook' => 78006,
      'travelchinacheaper' => 78007,
      'farwestchina' => 78008,
      'petel.bg' => 78009,
      'instagram' => 78010,
      'pin' => 78011, // Pinterest
      'youtube' => 78014,
      'whatsapp' => 78016,
      'reddit' => 78017,
      'xiaohongshu' => 78023,
    );

    $utm_source = get_cookie('__ah_utm_source');

    if (!empty($utm_source) && array_key_exists($utm_source, $utm_source_map)) {
      $this->Orders_model->COLI_LineClass = $utm_source_map[$utm_source];
    }

    $utm_campaign = get_cookie('__ah_utm_campaign');

    if (!empty($utm_campaign)) {
      $this->Orders_model->COLI_LinkedMan = $utm_campaign;
    }

    // 关联订单后统一删除 utm 的 cookie
    delete_cookie('__ah_utm_source', '.asiahighlights.com');
    delete_cookie('__ah_utm_medium', '.asiahighlights.com');
    delete_cookie('__ah_utm_campaign', '.asiahighlights.com');
  }

  public function asia_tour_thankyou() {
    $data = array();
    $data['seo_title'] = 'Tour Inquiry | Asia Highlights';
    $this->load->view('header', $data);
    $this->load->view('orders/thank_you', $data);
    $this->load->view('footer');
  }

  // 验证浏览器指纹
  // 已经取消使用，全免使用 grecaptch
  public function verifying_fingerprint() {
    $visitor_id = $this->input->get_post("visitorId");
    $are_you_rebot = $this->input->get_post("AreYouARebot");

    if (empty($visitor_id) ||
      empty($are_you_rebot) ||
      $are_you_rebot === 'Yes' ||
      $visitor_id === '123456789') {
      log_message('error', "reject by fingerprint. IP: " . $this->input->ip_address());
      $this->output_403();
    }
    if (!empty($visitor_id) && $visitor_id === '6dc3bdabc78d07eee856bcd8e979840e') {
      log_message('error', "reject by invaild fingerprint. IP: " . $this->input->ip_address());
      $this->output_403();
    }
  }

  // 测试地址：
  // https://proxy-www.asiahighlights.com/orders/verifying_grecaptcha_token?__grecaptcha_token__=
  public function verifying_grecaptcha_token() {
    $grecaptcha_token = $this->input->get_post("__grecaptcha_token__");
    if (empty($grecaptcha_token)) {
      log_message('error', 'grecaptcha token is empty: ' . $this->input->ip_address());
      $this->fake_200();
    }
    $create_assessment_url = 'https://recaptchaenterprise.googleapis.com/v1/projects/turnkey-life-235705/assessments?key=AIzaSyChwkYUGNvh8Lx9kck6ADFvMoMv3rEn-fI';
    $event_obj = new StdClass();
    $event_obj->token = $grecaptcha_token;
    $event_obj->siteKey = '6Lf828MhAAAAANNetijCXKwW5ARyhcJ-b1Hhslja';
    $event_obj->expectedAction = 'ADD_TO_CART';
    $assessment_obj = new StdClass();
    $assessment_obj->event = $event_obj;
    $json_obj = json_encode($assessment_obj);
    $assessment_result = $this->curl_post_json($create_assessment_url, $json_obj);

    if (empty($assessment_result)) {
      log_message('error', 'grecaptcha error: ' . $this->input->ip_address());
      $this->send_dingtalk_msg();
      $this->fake_200();
    } else if (array_key_exists('riskAnalysis', $assessment_result)) {
      log_message('error', 'grecaptcha valid, score: ' . $assessment_result->riskAnalysis->score . '; (' . $this->input->ip_address() . ')');
      if ($assessment_result->riskAnalysis->score <= 0.3) {
        $this->fake_200();
      }
    } else if (array_key_exists('tokenProperties', $assessment_result)) {
      log_message('error', 'grecaptcha invalid, reason: ' . $assessment_result->tokenProperties->invalidReason . '; (' . $this->input->ip_address() . ')');
      $this->fake_200();
    }
  }

  private function send_dingtalk_msg() {
    $curl_session = curl_init();
	  $req_url = 'https://p9axztuwd7x8a7.mycht.cn/dingtalk/dingtalkwork/SendMDMsgByDingRobotToGroup?groupid=cidFtzcIzNwNoiaGU9Q795CIg==&msgTitle='
		  .urlencode('reCAPTCHA 错误')
		  .'&msgText='
		  .urlencode('AH 无法使用 reCAPTCHA 验证');

	  curl_setopt($curl_session, CURLOPT_HEADER, false);
	  curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl_session, CURLOPT_TIMEOUT, 20);
	  curl_setopt($curl_session, CURLOPT_CONNECTTIMEOUT, 20);
	  curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($curl_session, CURLOPT_URL, $req_url);

	  $curl_output = curl_exec($curl_session);
	  curl_close($curl_session);
  }

  private function curl_post_json($url, $json) {
    $http_code = 0;
    $return_obj = null;
    $curl_obj = curl_init();
    $headers = array(
      'Content-Type: application/json',
    );
    $curl_options = [
      CURLOPT_HEADER => false,
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 20,
      CURLOPT_CONNECTTIMEOUT => 20,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_FORBID_REUSE => true,
      CURLOPT_FRESH_CONNECT => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_URL => $url,
    ];

    curl_setopt_array($curl_obj, $curl_options);

    $output = curl_exec($curl_obj);

    if ($output && !curl_errno($curl_obj)) {
      $http_code = curl_getinfo($curl_obj, CURLINFO_HTTP_CODE);
    }

    curl_close($curl_obj);

    if ($http_code == 200) {
      $return_obj = json_decode($output, false);
    }

    return $return_obj;
  }
}
