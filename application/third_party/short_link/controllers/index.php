<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('infoShortLinks_model');
    }

    public function index()
    {
        $this->load->view('welcome');
    }

    //创建短链接
    public function create()
    {
        $data = array();
        $url = $this->input->get('url');
        $type = $this->input->get('type');
        if (empty($type)) {$type = '';}
        if (empty($url)) {
            $data[] = array('name' => 'no', 'value' => '未知错误');
            echo json_encode($data);
            return false;
        }
        $url = base64_decode($url);
        $find = $this->infoShortLinks_model->detail_url($url);
        if ($find) {
            $data[] = array('name' => 'ok', 'value' => $find);
        } else {
            $isl_link = strtolower('/slink/' . substr(md5($url . 'ha*kj7qMRcX7!^K!'), 8, 16) . $type); //中间的乱码是加了点盐
            $shortLinkData = new StdClass;
            $shortLinkData->isl_link = $isl_link;
            $shortLinkData->isl_URL = $url;
            $shortLinkData->isl_type = $type;
            if ($this->infoShortLinks_model->add('infoShortLinks', $shortLinkData)) {
                $data[] = array('name' => 'ok', 'value' => $shortLinkData);
            } else {
                $data[] = array('name' => 'no', 'value' => '未知错误');
            }
        }
        echo json_encode($data);
    }

    public function detail()
    {
        $isl_link = $this->input->get('slink');
        if (empty($isl_link)) {show_404();}
        $find = $this->infoShortLinks_model->detail($isl_link);
        if ($find) {
            redirect($find->isl_URL);
        }
        show_404();
    }
}
