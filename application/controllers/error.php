<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends CI_Controller {

    public function index() {
        echo 'index';
    }

    public function page_not_found() {
        //$this->output->set_status_header(404);
        //$data = array();
        //$data['seo_title'] = 'What Are You Looking for at Asia Highlights Travel1';
        //$data['seo_keywords'] = '';
        //$data['seo_description'] = '';
        //$this->load->view('header', $data);
        $this->load->view('error/404');
        //$this->load->view('footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
