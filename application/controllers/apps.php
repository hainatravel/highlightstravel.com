<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
 * 
 * 模块机制类
 * 
 */
class Apps extends CI_Controller 
{  
	//重映射方法，系统函数
    public function _remap($app,$param)
    {
        //第三方应用存放目录
        $third_party = 'third_party';

        //请求的应用、制器、方法
        $app_name        = strtolower($app)!='index'?$app:'partners';
        $controller_name = isset($param[0])?strtolower($param[0]):'index';
        $action_name     = isset($param[1])?strtolower($param[1]):'index';

        //加载应用包
        $app_path=APPPATH.$third_party."/".$app_name."/"; //存放模块的目录
        $view_cascade=TRUE;                           //允许加载模块内、外的视图
        $this->load->add_package_path($app_path,$view_cascade);
        
        //加载配置文件
        if (file_exists($app_path . 'config/config.php')) {
            $this->load->config('config');
        }
        
        //加载控制器
        if ( ! file_exists($app_path.'controllers/'.$controller_name.'.php')) {
            echo 'Controller file is not exists!';
            return false;
        }
        require_once($app_path.'controllers/'.$controller_name.'.php');
        $controller_name = ucfirst($controller_name);
        
        //实例化控制器并调用请求的方法
        if (class_exists($controller_name,false)) 
        {
            $controllerHandler = new $controller_name();
            if(method_exists($controllerHandler,$action_name)) {
                call_user_func_array(array($controllerHandler, $action_name), array_slice($param, 2));
            }else{
                echo 'Method is not exists!';
            }
        }
        else
        {
            echo 'Controller is not exists!';
        }
        
        //停止加载应用包
        $this->load->remove_package_path($app_path);      
    }

}