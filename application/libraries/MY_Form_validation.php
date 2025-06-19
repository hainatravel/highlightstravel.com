<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    //提升CI_Form_validation类库的错误记录变量属性，前台程序需要用来读取每个表单的错误信息
    public $_error_array = array();

}