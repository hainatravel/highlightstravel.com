<?php

class BIZ_PackageInfo_model extends CI_Model {

    var $topnum = false; //返回记录数
    var $pag_code = false; //线路代号
    var $orderby = false;

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    public function init() {
        $this->topnum = false;
        $this->pag_code = false;
        $this->orderby = ' ORDER BY bpi.PAG_SN DESC ';
    }

    public function search($pag_code, $topnum = false) {
        $this->init();
        $this->topnum = empty($topnum) ? false : $topnum;
        $this->pag_code = ' AND bpi.PAG_Code = ' . $this->HT->escape($pag_code);
        return $this->get_list();
    }

    public function get_list() {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "    
                      bpi.PAG_SN
                      ,bpi.PAG_CII_SN
                      ,bpi.PAG_Code
                      ,bpi.PAG_NeedTime
                      ,bpi2.PAG2_Name
                      ,bpi2.PAG2_Title
                FROM   BIZ_PackageInfo bpi
                       INNER JOIN BIZ_PackageInfo2 bpi2
                            ON  bpi2.PAG2_PAG_SN = bpi.PAG_SN
                WHERE  1 = 1
                       AND (bpi.DeleteFlag IS NULL OR bpi.DeleteFlag=0)
                       AND (bpi.PAG_DEI_SN=? OR bpi.PAG_DEI_SN=26)
                      -- AND bpi.PAG_NeedPublish = 1
                       AND bpi2.PAG2_LGC = ?
                 ";
        $this->pag_code ? $sql.=$this->pag_code : false;
        $this->orderby ? $sql.=$this->orderby : false;
        $query = $this->HT->query($sql,array(CONST_SITE_DEPARTMENT,CONST_SITE_LGC));
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
