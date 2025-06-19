<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Information extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->model('Information_model');
        $this->load->model('InfoMetas_model');
        $this->load->library('Tags_analysis');
    }

    public function index()
    {
        echo 'Information Index';
    }

    //优先使用传入的URL，用于主动生成静态页面（去映射）(优先使用POST参数)
    public function detail($url = ''){
        $data = array();
        if (empty($url)) {
            $url = $this->input->get_post('static_html_url');
        }

        if (empty($url) || $url == 'index.php') {
            $url = get_origin_url();
            if (preg_match('/\?.*/', $url) == 1) {
                $url = preg_replace('/\?.*/', '', $url);
                //php_301($url);
                //return;
            }
        }

        //大小写转向，只要url有大写字母的全部转到小写字母的url上
        if ($url != mb_strtolower($url)) {
            php_301(mb_strtolower($url));
            return;
        }

        $data['detail'] = $this->Information_model->get_detail($url);
        if ($data['detail'] === false || empty($data['detail']->ic_content)) {
            send_404();
            return false;
        }

		$data['canonical'] = '';
		
		//新url转换到旧的url  278002649
		if(strpos($data['detail']->is_path,'278002649') >= 0 || strpos($data['detail']->is_path,'278005102') >= 0){
			$data['canonical'] = $data['detail']->ic_url;
			//制作canonical
			/*if($data['detail']->ic_type == 'country_info' || $data['detail']->ic_type == 'area_info'){
				if(strpos($data['detail']->ic_url,'tours') > 0){
					$info_url = explode('/',$data['detail']->ic_url);
					$data['canonical'] = '/'.$info_url['2'].'/'.$info_url['1'].'.htm';
				}elseif(strpos($data['detail']->ic_url,'travel-guide') > 0){
					$data['canonical'] = substr($data['detail']->ic_url,0,strpos($data['detail']->ic_url,'travel-guide'));
				}else{
					$data['canonical'] = $data['detail']->ic_url.'.htm';
				}
			}elseif($data['detail']->ic_type == 'pd_tour'){
				$tour_url = explode('/',$data['detail']->ic_url);
				$product_code = explode('-',$tour_url['2']);
				$data['canonical'] = '/tours/ah-'.$product_code['2'].'.htm';
			}*/
			
			//构造结构化标签---面包屑
			if($data['detail']->ic_show_bread_crumbs){
				$breadcrumblist = array();
				$path_arr = explode(',',substr($data['detail']->is_path,0,strlen($data['detail']->is_path)-1));
				$path_arr = array_splice($path_arr,1);
				$path_arr = array_splice($path_arr,1);
				//循环获取每个节点的信息
				if($data['detail']->ic_type == 'area_info'){
					$info = $this->Information_model->get_parent_info($path_arr['0'])['0'];
					$breadcrumblist['0'] = new stdClass();
					$breadcrumblist['1'] = new stdClass();
					$breadcrumblist['2'] = new stdClass();
					$breadcrumblist['0']->ic_url = $info->ic_url;
					$breadcrumblist['0']->ic_url_title = $info->ic_url_title;
					$breadcrumblist['1']->ic_url = '/'.strtolower($info->ic_url_title).'/travel-guide';
					$breadcrumblist['1']->ic_url_title = $info->ic_url_title.' Travel Guide';
					$breadcrumblist['2']->ic_url = $data['detail']->ic_url;
					$breadcrumblist['2']->ic_url_title = $data['detail']->ic_url_title;
				}else{
					foreach($path_arr as $is_id){
						$info = $this->Information_model->get_parent_info($is_id);
						if(!empty($info)){
							$info = $info['0'];
							array_push($breadcrumblist,$info);
						}
					}
				}
				$data['detail']->construct_tag = make_construct_tag($breadcrumblist);
				$data['detail']->breadcrumblist = make_breadcrumblist($breadcrumblist);
			}
		}else{
			$data['canonical'] = $data['detail']->ic_url;
			//将老的url指向新的url
			if(strpos($data['detail']->ic_url,'.htm') > 0){
				$now_url = substr($data['detail']->ic_url,0,strlen($data['detail']->ic_url)-4);
				$now_info = $this->Information_model->get_detail($now_url);
				if($now_info !== false){
					$data['canonical'] = $now_url;
				}
			}
		}
		
		//进行标签替换
		$data['detail']->ic_content = $this->tags_analysis->analysis($data['detail']);
		
        $data['seo_title'] = $data['detail']->ic_seo_title;
        $data['seo_keywords'] = $data['detail']->ic_seo_keywords;
        $data['seo_description'] = $data['detail']->ic_seo_description;
        $data['seo_url'] = $data['detail']->ic_url;
		//print_r($data['detail']);die();
        //判断是否有AMP版本，并生成缓存文件
        if ($this->InfoMetas_model->get($data['detail']->ic_id, 'AMP_STATUS') > 0) {
            $AMP = $this->InfoMetas_model->get($data['detail']->ic_id, 'AMP');
            if (!empty($AMP)) {
                if (mb_substr($data['seo_url'], -1, 1) == '/') {
                    $data['amp_url'] = $data['seo_url'] . 'index.htm.amp.htm';
                } else {
                    $data['amp_url'] = $data['seo_url'] . '.amp.htm';
                }
                $cache_path = 'd:/Dropbox/wwwcache/asiahighlights.com' . $data['amp_url'];
                $dir = dirname($cache_path);
                if (!is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }
                //表单替换和价格替换
                $AMP_Clone_content = $data['detail']->ic_content;//因为tags_analysis是根据信息结构来替换的，所以需要克隆一个信息结构，然后用AMP代码覆盖ic_content
                $data['detail']->ic_content = $AMP;
                $AMP = $this->tags_analysis->analysis($data['detail']);
                $data['detail']->ic_content = $AMP_Clone_content;
                file_put_contents($cache_path, $AMP);
            }
        } else {
            //尝试删除AMP文件
            if (mb_substr($data['seo_url'], -1, 1) == '/') {
                $amp_url = $data['seo_url'] . 'index.htm.amp.htm';
            } else {
                $amp_url = $data['seo_url'] . '.amp.htm';
            }
            $amp_file = 'd:/Dropbox/wwwcache/asiahighlights.com' . $amp_url;
            if (file_exists($amp_file)) {
                unlink($amp_file);
            }
        }
        $data['meta_addon_css'] = $this->InfoMetas_model->get($data['detail']->ic_id, 'meta_addon_css');
        $data['meta_addon_js'] = $this->InfoMetas_model->get($data['detail']->ic_id, 'meta_addon_js');
        $data['meta_addon_picture'] = $this->InfoMetas_model->get($data['detail']->ic_id, 'meta_addon_picture');
		//print_r($data);die();
		$this->load->view('header', $data);
        $this->load->view('information_' . $data['detail']->ic_template);
        $this->load->view('footer');
        if ($this->input->get_post('no_cache')) {
            //不触发缓存生成，否则影响AMP生成速度，这个主要是给自动转换AMP用的
        } else {
            $this->output->cache(99999);
        }
    }


    //后面这串是密码，防止爬虫程序扫到
    //删除缓存文件，比如页面不在发布，或者修改了URL等情况
    public function delete_cache_8X913mksJ()
    {
        $url = $this->input->get_post('static_html_url');
        if (empty($url)) {
            $this->output->set_status_header(404);
            return false;
        }
        $cache_path = 'd:/Dropbox/wwwcache/asiahighlights.com';

        if (!is_dir($cache_path) OR !is_really_writable($cache_path)) {
            log_message('error', "Unable to write cache file: " . $cache_path);
            $this->output->set_status_header(404);
            return false;
        }

        $cache_path = $cache_path . $url;
        if (mb_substr($cache_path, -1, 1) == '/') {
            $cache_path .= 'index.htm';
        }

        //如果文件存在，先判断是否为缓存文件，防止覆盖原始程序文件
        if (file_exists($cache_path)) {
            if (!$fp_read = @fopen($cache_path, FOPEN_READ)) {
                $this->output->set_status_header(404);
                return FALSE;
            }
            flock($fp_read, LOCK_SH);
            $cache = '';
            if (filesize($cache_path) > 0) {
                $cache = fread($fp_read, filesize($cache_path));
            }
            flock($fp_read, LOCK_UN);
            fclose($fp_read);
            if (strpos($cache, '<!-- Generated by ') === false) {
                log_message('error', "is not cache file." . $cache_path);
                $this->output->set_status_header(404);
                return FALSE;
            } else {
                if (unlink($cache_path)) {
                    unlink($cache_path . '.mobile.htm');//删除移动端文件
                    if (file_exists($cache_path . '.amp.htm')) {
                        unlink($cache_path . '.amp.htm');//删除amp文件
                    }
                    echo 'ok';
                    return TRUE;
                } else {
                    $this->output->set_status_header(404);
                    return FALSE;
                }
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */