<?php

class Information_model extends CI_Model {

    var $top_num = false;
    var $order_by = false;
    var $search_title = false;
    var $search_url = false;
    var $path = false;
    var $level = false;
    var $is_parent_id = false;
    var $is_id_array = false;
    var $ic_url_is_id = false;
    var $ic_type = false;
    var $ic_show_bread_crumbs = false;
    var $ic_ht_area_id = false;
    var $ic_ht_area_type = false;
    var $cols = false;
    var $ic_template = false;
    var $sql = false;

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    function init() {
        $this->top_num = false;
        $this->order_by = empty($this->order_by) ? " ORDER BY  ic_datetime DESC  " : $this->order_by;
        $this->search_title = false;
        $this->search_url = false;
        $this->path = false;
        $this->level = false;
        $this->is_parent_id = false;
        $this->is_id_array = false;
        $this->ic_url_is_id = false;
        $this->ic_show_bread_crumbs = false;
        $this->cols = false;
        $this->ic_template = false;
        $this->sql = false;
    }

    //可以传递url或者id，如果有id则以ID进行查询
    function get_detail($ic_url_is_id) {
        $this->init();
        $this->top_num = 1;
        $this->order_by = ' ORDER BY LEN(CAST(ic.ic_content AS NVARCHAR(MAX))) DESC,LEN(CAST(ic.ic_summary AS NVARCHAR(MAX))) DESC,is1.is_id ASC ';
        if (is_numeric($ic_url_is_id)) {
            $this->ic_url_is_id = " AND is1.is_id=  " . $this->HT->escape($ic_url_is_id);
        } else {
            $this->ic_url_is_id = " AND ic.ic_url =  N" . $this->HT->escape($ic_url_is_id);
        }


        return $this->get_list();
    }

    /*传递父级ID，获取同级目录
    *@parameter $is_parent_id int 传入的父级id
    *@parameter $num int 要获取的数目，默认五条
    *@author CSK
    *@date 2016-10-27
    */
    function get_same_level($is_parent_id,$num=5){
        $this->init();
        $this->top_num=$num;
        $this->cols="is1.is_sort,ic.ic_url,ic_url_title,is_id";
        $this->ic_url_is_id="AND is1.is_parent_id=".$this->HT->escape($is_parent_id);
        $this->order_by="ORDER BY is_sort ASC";
        return $this->get_list();
    }

    /*传递一组ID，获取信息
    *@parameter $is_id string 传入的id字符串（1,2,3）
    *@author CSK
    *@date 2016-10-27
    */
    function get_some_detail($is_id){
        $this->init();
        $this->cols="ic.ic_url,ic_url_title,ic_photo";
        $this->ic_url_is_id="AND ic.ic_id in (".$is_id.")";
        return $this->get_list();
    }

    function get_list() {
        $this->top_num ? $sql = "SELECT TOP " . $this->top_num : $sql = "SELECT ";
        if (!empty($this->cols)) {
            $sql .= $this->cols;
        } else {
            $sql .= "   is1.is_id, \n"
                    . " is1.is_parent_id, \n"
                    . " is1.is_path, \n"
                    . " is1.is_level, \n"
                    . " is1.is_sort, \n"
                    . " is1.is_sitecode, \n"
                    . " is1.is_datetime, \n"
                    . " is1.is_ic_id, \n"
                    . " ic.ic_id, \n"
                    . " ic.ic_url, \n"
                    . " ic.ic_url_title, \n"
                    . " ic.ic_type, \n"
                    . " ic.ic_title, \n"
                    . " ic.ic_content, \n"
                    . " ic.ic_summary, \n"
                    . " ic.ic_seo_title, \n"
                    . " ic.ic_seo_description, \n"
                    . " ic.ic_seo_keywords, \n"
                    . " ic.ic_show_bread_crumbs, \n"
                    . " ic.ic_status, \n"
                    . " ic.ic_template, \n"
                    . " ic.ic_photo, \n"
                    . " ic.ic_photo_width, \n"
                    . " ic.ic_photo_height, \n"
                    . " ic.ic_sitecode, \n"
                    . " ic.ic_recommend_tours, \n"
                    . " ic.ic_recommend_packages, \n"
                    . " ic.ic_datetime, \n"
                    . " ic.ic_ht_area_id, \n"
                    . " ic.ic_ht_area_type, \n"
                    . " ic.ic_ht_product_id, \n"
                    . " ic.ic_ht_product_type, \n"
                    . " ic.ic_author, \n"
                    . " o2.OPI2_FirstName, \n"
                    . " o2.OPI2_LastName  \n";
        }
        $sql.= " FROM   infoStructures is1 \n"
                . "       INNER JOIN infoContents ic ON ic.ic_id = is1.is_ic_id \n"
                . "            AND ic.ic_sitecode = is1.is_sitecode \n"
                . "       LEFT JOIN OperatorInfo o1 ON o1.OPI_Code = ic.ic_author \n"
                . "       LEFT JOIN OperatorInfo2 o2 ON o1.OPI_SN = o2.OPI2_OPI_SN AND o2.OPI2_LGC = ? \n"
                . "WHERE  ic.ic_status = 1 \n"
                . "AND  is1.is_sitecode = ? ";
        $this->search_title ? $sql.=$this->search_title : false;
        $this->search_url ? $sql.=$this->search_url : false;
        $this->path ? $sql.=$this->path : false;
        $this->level ? $sql.=$this->level : false;
        $this->ic_type ? $sql.=$this->ic_type : false;
        $this->ic_ht_area_id ? $sql.=$this->ic_ht_area_id : false;
        $this->ic_ht_area_type ? $sql.=$this->ic_ht_area_type : false;
        $this->is_parent_id ? $sql.=$this->is_parent_id : false;
        $this->ic_show_bread_crumbs ? $sql.=$this->ic_show_bread_crumbs : false;
        $this->is_id_array ? $sql.=$this->is_id_array : false;
        $this->ic_url_is_id ? $sql.=$this->ic_url_is_id : false;
        $this->ic_template ? $sql.=$this->ic_template : false;
        $this->order_by ? $sql.=$this->order_by : false;

        
        $query = $this->HT->query($sql, array($this->config->item('Site_LGC'), $this->config->item('Site_Code')));
        //$this->sql = $this->HT->queries;
        if ($this->top_num === 1) {
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row;
            } else {
                return FALSE;
            }
        } else {
            return $query->result();
        }
    }
	
	//根据传入IC_ID获取信息的标题和url链接
	public function get_title_url($ic_id){
		$sql = "select 
						ic_url,
						ic_url_title,
						ic_photo,
						ic_title
					from
						infoContents
					where 
						ic_id = {$ic_id}";
		$query = $this->HT->query($sql);
		return $query->result();
	}
	
	//根据is_parent_id 获取父级目录的信息
	public function get_parent_info($is_parent_id){
		$sql = "select ic_url,ic_url_title from infoStructures INNER JOIN infoContents ON ic_id = is_ic_id where is_id = ? and ic_status = 1";
		$query = $this->HT->query($sql,array($is_parent_id));
		return $query->result();
	}
}
