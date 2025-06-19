<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


//常量配置
define("COST_TIME",2);//限制时间，单位分钟
define("COST_COUNT",10);//限制次数


class Illegal_submit{
  private $CI;
  private $conn;//数据库连接资源
  //ip黑名单
  private $ip_blacklist=array();//array("202.103.68.34","202.103.68.30");
  //邮箱黑名单
  private $email_blacklist=array();
  function __construct(){ 
    $this->CI = & get_instance();
    $this->HT = $this->CI->load->database('HT', TRUE);
  }
  function test(){
    $sql="SELECT top 1 * from ConfirmLineInfoTmp";
    $query = $this->HT->query($sql);
    var_dump($query->result());
  }
  public function verify_view(){
    $list["r"]=$this->CI->input->post();
    unset($list["r"]["_ver"]);//验证码不需要再传输，所以去掉
    echo $this->CI->load->view('orders/ver_img',$list,true);
    session_start();
    if($_SESSION["randcode"]===@$_POST["_ver"]){
      return true;
    }
  }
  public function verify($ip="",$email=""){
    

    if(in_array($ip, $this->ip_blacklist) or in_array($email, $this->email_blacklist)){
      //此ip或者邮箱在黑名单     
      return $this->verify_view();
    }else{

      $sql="SELECT count(*)
          FROM ConfirmLineInfoTmp 
          WHERE (COLI_SenderIP='{$ip}'
           OR (
            SELECT MEI_MailList 
            FROM MEmberInfoTmp 
            WHERE MEI_SN=(SELECT CUL_CUI_SN FROM CUstomerListTmp WHERE CUL_COLI_SN=ConfirmLineInfoTmp.COLI_SN)
            )='{$email}')  
           AND COLI_ApplyDate>DATEADD(n,-".COST_TIME.",GETDATE())";   
      
      $r=$this->_fetch_array($sql);
      
      //如果数据多于配置的阈值，返回false
      if($r[0]<COST_COUNT){
        // return FALSE;//需要验证
        return $this->verify_view();
      }else{
        return TRUE;//不需要验证
      }     
    }

    
  }
  public function verify_ft($ip="",$email="",$post=""){
    if(in_array($ip, $this->ip_blacklist) or in_array($email, $this->email_blacklist)){
      //此ip或者邮箱在黑名单     
      return FALSE;
    }else{
      $sql="SELECT count(*)
          FROM ConfirmLineInfoTmp 
          WHERE (COLI_SenderIP='{$ip}'
           OR (
            SELECT MEI_MailList 
            FROM MEmberInfoTmp 
            WHERE MEI_SN=(SELECT CUL_CUI_SN FROM CUstomerListTmp WHERE CUL_COLI_SN=ConfirmLineInfoTmp.COLI_SN)
            )='{$email}')  
           AND COLI_ApplyDate>DATEADD(n,-".COST_TIME.",GETDATE())";   
      $query = $this->HT->query($sql);
      $r=$query->result();
      if($r){

        //如果数据多于配置的阈值，返回false
        if($r[0]->count_num<COST_COUNT){
          // return FALSE;//需要验证
          return FALSE;
        }else{
          return TRUE;//不需要验证
        } 
      }else{
        return TRUE;//不需要验证
      }
          
    }

    
  }

  public function verify_image(){
    $this->CI->load->library('Captcha_code');
    // $this->CI->load->library("session");
    $this->CI->captcha_code->show();  
      // $yzm_session = $this->CI->session->userdata('verify_code');  
      // echo $yzm_session; 
  }
  public function view(){

  }


}

