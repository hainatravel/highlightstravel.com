<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advertise_model extends CI_Model
{
    
    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }
    
    /**
     * function 用于提取指定页面关联的广告
     * $pageurl:需要展示广告的页面url
     * $place: 广告位
     */
    public function get_advertise_by_url($pageurl, $place = false) {
        //获取当前页面关联的广告
        $data = array();
        
        $site_code = Site_Code;
        //$site_code = 'gm';
        $ad_list = $this->get_advertise($site_code, $pageurl, $place);
        //尝试根据当前页面的信息ID来提取广告
        //CH统一只用URL查询
        if (empty($ad_list)) {
            $info_detail = $this->get_detail($pageurl);
            if (empty($info_detail)) return array();
            $ad_list = $this->get_advertise($site_code, $pageurl, $place, $info_detail->ic_id);
			
        }
        //当前页面没有关联广告的话，取父级节点的广告代替
        if (empty($ad_list)) {
            //获取父级信息节点关联的适用于当前页面的广告
            $parent_ads = $this->get_parent_ads($info_detail->is_path, $site_code, time(), $place);
            if (empty($parent_ads)) {
                
                //url匹配不到数据的话，尝试用父节点的信息内容ic_id来匹配
                $parent_ads = $this->get_parent_ads($info_detail->is_path, $site_code, time(), $place, true);
            }
            if (empty($parent_ads)) return array();
            
            //重新排序，方便提取直接父节点的广告数据
            $temp = array();
            foreach ($parent_ads as $p) {
                $temp[$p->is_id][] = $p;
            }
            
            //优先获取直接父节点关联的广告,以此类推
            $is_id_array = explode(',', $info_detail->is_path);
            krsort($is_id_array);
            foreach ($is_id_array as $isid) {
                if ($isid != '' && isset($temp[$isid])) {
                    $ad_list = $temp[$isid];
                    break;
                }
            }
        }
        
        //返回当前页面所有广告位的广告，按广告索引
        $advertise = array();
        if (!empty($ad_list)) {
            foreach ($ad_list as $ad) {
                $advertise[$ad->ad_place] = $ad;
            }
        }
        return $advertise;
    }
    
    //获取指定页面指定位置的广告
    public function get_advertise($site_code, $adp_ic_url, $ad_place = false, $ic_id = false) {
        $adp_ic_url = $ic_id ? $ic_id : $adp_ic_url;
        
        //当url匹配不到数据的时候该用信息内容ID匹配
        $mapsql = $ad_place == false ? '' : " AND ad_place='$ad_place' ";
        $sql = "SELECT   adp_id,
                         adp_ic_url,
                         adp_forself,
                         ad_id,
                         ad_is_id,
                         ad_title,
                         ad_content,
                         ad_expire,
                         ad_place,
                         ad_sitecode,
                         ad_status,
                         ad_createtime
                FROM     infoAdvertise LEFT JOIN infoAdvertisePage ON ad_id=adp_ad_id
                WHERE   ad_status=1 AND adp_ic_url='$adp_ic_url' AND ad_sitecode=? AND ad_expire>? $mapsql";
        $query = $this->HT->query($sql, array($site_code, time()));
        //echo '<!--'.$this->HT->last_query().'-->';
        $result = $query->result();
        return $result;
    }
    
    //获取父级信息节点关联的可以用于子节点的广告
    public function get_parent_ads($path, $site_code, $ad_expire, $ad_place = false, $icid_flag = false) {
        $compare_string = $icid_flag ? 'convert(nvarchar, ic_id)' : 'ic_url';
        
        //当url匹配不到数据的时候该用信息内容ID匹配
        $path = $path . "0";
        $mapsql = $ad_place == false ? '' : " AND ad_place='$ad_place' ";
        $sql = "    SELECT ad_id,
                         ad_is_id,
                         ad_title,
                         ad_content,
                         ad_expire,
                         ad_place,
                         ad_sitecode,
                         ad_status,
                         ad_createtime,
                         is_id
                    FROM infoAdvertise 
                         LEFT JOIN infoAdvertisePage ON ad_id=adp_ad_id
                         LEFT JOIN infoContents  ON adp_ic_url={$compare_string}
                         LEFT JOIN infoStructures ON ic_id=is_ic_id AND is_id in ($path)
                   WHERE ad_sitecode=? and is_sitecode=? and ad_status=1 AND (adp_forself=1 or (adp_forself = 3 AND adp_ic_url LIKE {$compare_string})) AND ad_expire>? $mapsql";
        $query = $this->HT->query($sql, array($site_code, $site_code, $ad_expire));
        //echo '<!--' . $this->HT->last_query() . '-->';
        $result = $query->result();
        return $result;
    }
    
    public function get_detail($url) {
        $sql = "SELECT TOP 1 * FROM infoContents a INNER JOIN infoStructures b ON a.ic_id = b.is_ic_id WHERE ic_url = ? AND ic_status = 1 AND ic_sitecode = 'ah'";
        $query = $this->HT->query($sql, array($url));
        $row = $query->row();
        return $row;
    }
}
