<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        $this->load->model('Ip2location_db1_model');
    }

    public function index()
    {
        $data = array();
        //优先读取参数ip地址，没有则自动判断客户端地址
        $data['ip_address'] = $this->input->get_post('ip_address');
        if (empty($data['ip_address'])) {
            $data['ip_address'] = $this->input->ip_address();
        }
        $data['ip_number'] = $this->Dot2LongIP($data['ip_address']);
        $data['country_code'] = $this->Ip2location_db1_model->get_country_code($data['ip_number']);
        echo json_encode($data);
    }

    /**
     * 根据客人ip获取国家信息
     * /index.php/apps/ip2location/index/get_country?ip_address=2409:8000:2000:0000:0070::1
     */
    public function get_country() {
      $data = array();
      //优先读取参数ip地址，没有则自动判断客户端地址
      $data['ip_address'] = $this->input->get_post('ip_address');
      if (empty($data['ip_address'])) {
          $data['ip_address'] = $this->input->ip_address();
      }
      // 判断获取到的客人ip地址是否是ipv4地址
      if (filter_var($data['ip_address'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        $ip_number = $this->Dot2LongIP($data['ip_address']);
        $country = $this->Ip2location_db1_model->get_country_by_ip($ip_number);
        $country['ip_address'] = $data['ip_address'];
        echo json_encode($country);
      }
    }

    /**
     * 根据 IP 判断是否是欧盟国家
     * http://localhost:8003/index.php/apps/ip2location/index/is_eu_country?ip_address=159.8.126.74
     */
    public function is_eu_country() {
        $european_counties = array('Russia', 'Ukraine', 'France');
        $ip_address = $this->input->get_post('ip_address');
        if (empty($ip_address)) {
            $ip_address = $this->input->ip_address();
        }
        $ip_number = $this->Dot2LongIP($ip_address);
        $country_name = $this->Ip2location_db1_model->get_country_name($ip_number);
        $is_eu_country = 'false';
        if (in_array($country_name, $european_counties)) {
            $is_eu_country = 'true';
        }
        echo json_encode($is_eu_country);
    }

    function Dot2LongIP($IPaddr)
    {
        if ($IPaddr == "") {
            return 0;
        } else {
            $ips = explode(".", "$IPaddr");
            return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
        }
    }

}
