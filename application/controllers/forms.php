<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once 'Mobile_Detect.php';

class forms extends CI_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
    }
	
	//水灯节表单
	public function lantern_form(){
		$data = array();
		$data['location'] = $this->input->get_post('location');
		$data['TicketStandard'] = $this->input->get_post('TicketStandard');
		$data['ticketonlyselection'] = $this->input->get_post('ticketonlyselection');
		$data['date'] = $this->input->get_post('date');
		$data['travelNumber'] = $this->input->get_post('travelNumber');
		$data['totalprice'] = $this->input->get_post('totalprice');
		
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['orderfrom'] = $_SERVER['HTTP_REFERER'];
		}else{
			$data['orderfrom'] = '';
		}
		
		$this->load->view('header');
        $this->load->view('orders/lantern_form',$data);
        $this->load->view('footer');
	}
	
	//水灯节表单
	public function lantern_mobile(){
		$this->load->view('header');
        $this->load->view('orders/lantern_mobile');
        $this->load->view('footer');
	}
	
	//tailormade和产品页面
	public function triprequest($third_part_code = '') {
        $data = array();
		$cli_sn = $this->input->get_post('cli_sn');
		$data['countrylist'] = ['Vietnam','Cambodia','India','Thailand','Myanmar','Japan','Laos','Nepal','Sri Lanka','China','Mongolia','Indonesia'];
		if($cli_sn){
			$data['countryarr'] = array();
			$obj = $this->Orders_model->get_country($cli_sn);
			foreach ($obj as $value){
				array_push($data['countryarr'],$value->CountryName);
			}
			$data['ic_title'] = $this->input->get_post('ic_title');
			$data['cli_no'] = $this->input->get_post('cli_no');
			$data['cli_sn'] = $cli_sn;
			$data['cli_days'] = $this->input->get_post('cli_days');
		}else{
			$data['countryarr'] = [];
		}
		$data['action'] = '/orders/triprequest_save';
        $data['seo_title'] = "Create my trip | Asia Highlights";
        //$data['seo_keywords'] = $data['detail']->ic_seo_keywords;
        //$data['seo_description'] = $data['detail']->ic_seo_description;
		
		$this->load->view('header', $data);
        $this->load->view('orders/form-advanced');
        $this->load->view('footer');
    }
	
	//inquiry 表单移动端
	public function inquirymobile(){
		$data = array();
		$cli_sn = $this->input->get_post('cli_sn');
		$data['countrylist'] = ['Vietnam','Cambodia','India','Thailand','Myanmar','Japan','Laos','Nepal','Sri Lanka','China','Mongolia','Indonesia'];
		if($cli_sn){
			$data['countryarr'] = array();
			$obj = $this->Orders_model->get_country($cli_sn);
			foreach ($obj as $value){
				array_push($data['countryarr'],$value->CountryName);
			}
			$data['ic_title'] = $this->input->get_post('ic_title');
		}else{
			$data['countryarr'] = [];
			$data['ic_title'] = '';
		}
		$data['action'] = '/orders/triprequest_save';
        $data['seo_title'] = "Create my trip | Asia Highlights";
		
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['orderfrom'] = $_SERVER['HTTP_REFERER'];
		}else{
			$data['orderfrom'] = '';
		}
		
		$this->load->view('header', $data);
        $this->load->view('orders/inquiry_mobile');
        $this->load->view('footer');
	}
	
	//inquiry 表单pc端
	public function inquiry(){
		$data = array();
		$cli_sn = $this->input->get_post('cli_sn');
		
		$data['countrylist'] = ['Vietnam','Cambodia','India','Thailand','Myanmar','Japan','Laos','Nepal','Sri Lanka','China','Mongolia','Indonesia'];
		if($cli_sn){
			$data['countryarr'] = array();
			$obj = $this->Orders_model->get_country($cli_sn);
			foreach ($obj as $value){
				array_push($data['countryarr'],$value->CountryName);
			}
			$data['ic_title'] = $this->input->get_post('ic_title');
		}else{
			$data['countryarr'] = [];
			$data['ic_title'] = '';
		}
		$data['action'] = '/orders/triprequest_save';
        $data['seo_title'] = "Create my trip | Asia Highlights";
		
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['orderfrom'] = $_SERVER['HTTP_REFERER'];
		}else{
			$data['orderfrom'] = '';
		}
		
		$this->load->view('header', $data);
        $this->load->view('orders/inquiry');
        $this->load->view('footer');
	}
	
	public function tailormade() {
		$data['countrylist'] = ['Vietnam','Cambodia','India','Thailand','Myanmar','Japan','Laos','Nepal','Sri Lanka','China','Mongolia','Indonesia'];
		$data['action'] = '/orders/triprequest_save';
        $data['seo_title'] = "Create my trip | Asia Highlights";
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['orderfrom'] = $_SERVER['HTTP_REFERER'];
		}else{
			$data['orderfrom'] = '';
		}
		
		if(isset($_GET['tourCode'])){
			$data['tourCode'] = $_GET['tourCode'];
		}else{
			$data['tourCode'] = '';
		}
		
		$detect = new Mobile_Detect;
		if ($detect->isMobile() && !$detect->isTablet()) {
			$this->load->view('orders/tailormademobile', $data);
		} else {
			$this->load->view('orders/tailormade', $data);
		}
	}
	
	public function tailormade_ppc() {
		$data = array();
		$detect = new Mobile_Detect;
		if ($detect->isMobile() && !$detect->isTablet()) {
			$this->load->view('orders/tailormademobile-ppc', $data);
		} else {
			$this->load->view('orders/tailormade-ppc', $data);
		}
	}
	
	public function tailormade_ppc_easy() {
		$data = array();
		$detect = new Mobile_Detect;
		if ($detect->isMobile() && !$detect->isTablet()) {
			$this->load->view('orders/tailormademobile-ppc-easy', $data);
		} else {
			$this->load->view('orders/tailormade-ppc-easy', $data);
		}
	}
	
	public function tailormade_ppc_india() {
		$data = array();
		$detect = new Mobile_Detect;
		if ($detect->isMobile() && !$detect->isTablet()) {
			$this->load->view('orders/tailormademobile-ppc-india', $data);
		} else {
			$this->load->view('orders/tailormade-ppc-india', $data);
		}
	}
	
	public function tailormademobile(){
		$data['countrylist'] = ['Vietnam','Cambodia','India','Thailand','Myanmar','Japan','Laos','Nepal','Sri Lanka','China','Mongolia','Indonesia'];
		$data['action'] = '/orders/triprequest_save';
        $data['seo_title'] = "Create my trip | Asia Highlights";
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['orderfrom'] = $_SERVER['HTTP_REFERER'];
		}else{
			$data['orderfrom'] = '';
		}
		
		if(isset($_GET['tourCode'])){
			$data['tourCode'] = $_GET['tourCode'];
		}else{
			$data['tourCode'] = '';
		}
		
		$this->load->view('header', $data);
        $this->load->view('orders/tailormademobile');
        $this->load->view('footer');
	}
}