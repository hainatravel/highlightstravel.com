<?php

class test_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    //获取对应模板的页面
	public function get_url($template){
		$sql = "SELECT ic_url FROM infoContents WHERE ic_sitecode = 'ah' and ic_status = 1 and ic_template = '{$template}'";
		$query = $this->HT->query($sql);
		return $query->result();
	}
	
	//获取字符串查询所属的页面
	public function get_contents($string){
		$sql = "SELECT ic_url FROM infoContents WHERE ic_sitecode = 'ah' and ic_status = 1 and ic_content like '%{$string}%'";
		$query = $this->HT->query($sql);
		return $query->result();
	}

}
