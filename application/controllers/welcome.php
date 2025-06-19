<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        echo 'index';
    }

    // 2024-03-20 下线 redirect 功能 lz
    // public function redirect() {
    //   //要转向的URL
    //   $url = $this->input->get('url');
        
    //   // 指定要匹配的域名
    //   $domainAH = 'asiahighlights.com';
    //   $domainCH = 'chinahighlights.com';
    //   $domainGH = 'globalhighlights.com';

    //   $veryfiedDomain = 
    //     $this->hasDomain($url, $domainAH) or 
    //     $this->hasDomain($url, $domainCH) or 
    //     $this->hasDomain($url, $domainGH);

    //   if ($veryfiedDomain) {      
    //     redirect($url);
    //   } else {
    //     send_404();
    //     exit;
    //   }
    // }

    function hasDomain($url, $domain) {
      $parsed = parse_url($url);
      $host = $parsed['host'];  
      // 去掉 www. 前缀（如有必要）
      $domain = preg_replace('#^www\.#', '', $domain);  
      // 判断 host 是否以指定域名结尾
      return preg_match('/' . preg_quote($domain, '/') . '$/i', $host);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */