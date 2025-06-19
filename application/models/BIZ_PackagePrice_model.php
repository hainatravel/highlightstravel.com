<?php

class BIZ_PackagePrice_model extends CI_Model {

    var $topnum = false; //返回记录数
    var $pag_code = false; //线路代号
    var $person_size = false; //人等
    var $price_date = false; //查询价格日期区间
    var $orderby = false;

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    public function init() {
        $this->topnum = false;
        $this->pag_code = false;
        $this->person_size = false;
        $this->price_date = false;
        $this->orderby = ' ORDER BY bpp.PKP_PriceGrade ASC,bpp.PKP_AdultPrice DESC ';
    }

    public function search($pag_code, $topnum = false, $person_size = false, $price_date = false) {
        $this->init();
        $this->pag_code = $pag_code;
        $this->topnum = empty($topnum) ? false : $topnum;
        $this->person_size = empty($person_size) ? false : $this->person_size = " AND $person_size BETWEEN bpp.PKP_PersonStart AND bpp.PKP_PersonStop ";
        $this->price_date = empty($price_date) ? false : " AND '$price_date 00:00:00' BETWEEN bpp.PKP_ValidDate AND bpp.PKP_InvalidDate ";
        return $this->get_list();
    }

    public function get_list() {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "    
                           bpi.PAG_SN
                          ,bpi.PAG_Code
                          ,bpp.PKP_SN
                          ,bpp.PKP_PAG_SN
                          ,bpp.PKP_AdultPrice
                          ,bpp.PKP_ChildPrice
                          ,bpp.PKP_InfantPrice
                          ,bpp.PKP_AdultNetPrice
                          ,bpp.PKP_ChildNetPrice
                          ,bpp.PKP_InfantNetPrice
                            ,bpp.PKP_ValidDate
                            ,bpp.PKP_InvalidDate
                          ,bpp.PKP_PriceGrade
                          ,bpp.PKP_PersonStart
                          ,bpp.PKP_PersonStop
                          ,bpp.PKP_AdultCost
                          ,bpp.PKP_ChildCost
                          ,bpp.PKP_BabyCost
                    FROM   BIZ_PackagePrice bpp
                           INNER JOIN BIZ_PackageInfo bpi
                                ON  bpi.PAG_SN = bpp.PKP_PAG_SN
                    WHERE  1 = 1
                           AND (bpi.DeleteFlag IS NULL OR bpi.DeleteFlag=0)
                           AND bpi.PAG_Code = ?
                           AND (bpi.PAG_DEI_SN = ? OR bpi.PAG_DEI_SN = 26 )
                           
                 ";

        $this->person_size ? $sql.=$this->person_size : false;
        $this->price_date ? $sql.=$this->price_date : false;
        $this->orderby ? $sql.=$this->orderby : false;

        $query = $this->HT->query($sql, array($this->pag_code,CONST_SITE_DEPARTMENT));
        //print_r($this->HT->queries);
        if ($this->topnum === 1) {
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

}
