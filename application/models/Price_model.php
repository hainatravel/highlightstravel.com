<?php

class Price_model extends CI_Model {

    var $topnum = false; //返回记录数
    var $cli_no = false; //线路代号
    var $person_size = false; //人等
    var $cli_grade = false; //(标准7001、豪华7002、经济7003）
    var $clp_pricetype = false; //价格类型 1旺季，2淡季
    var $price_date = false; //查询价格日期区间
    var $orderby = false;

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    public function init() {
        $this->topnum = false;
        $this->cli_no = false;
        $this->person_size = false;
        $this->cli_grade = false;
        $this->clp_pricetype = false;
        $this->price_date = false;
        $this->orderby = ' ORDER BY cli.CLI_Grade ASC, clp.CLP_PriceStartDate ASC,clp.CLP_PriceType DESC ';
    }

    public function search($cli_no, $topnum = false, $cli_grade = false, $clp_pricetype = false, $price_date = false) {
        $this->init();
        $this->topnum = empty($topnum) ? false : $topnum;
        $this->cli_no = ' AND cli.CLI_NO = ' . $this->HT->escape($cli_no);
        $this->cli_grade = empty($cli_grade) ? false : ' AND cli.CLI_Grade = ' . $this->HT->escape($cli_grade);
        $this->clp_pricetype = empty($clp_pricetype) ? false : ' AND clp.CLP_PriceType = ' . $this->HT->escape($clp_pricetype);
        $this->price_date = empty($price_date) ? false : " AND '$price_date 00:00:00' BETWEEN clp.CLP_PriceStartDate AND clp.CLP_PriceEndDate ";
        return $this->get_list();
    }

    public function get_list() {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "    
                  cli.CLI_SN
                 ,cli.CLI_NO
                 ,clp.CLP_SN
                 ,clp.CLP_OneAdultPriceRMB
                 ,clp.CLP_TwoToFiveAdultPriceRMB
                 ,clp.CLP_SixToNineAdultPriceRMB
                 ,clp.CLP_OverTenAdultPriceRMB
                 ,clp.CLP_PriceType
                 ,cli.CLI_Grade
                 ,clp.CLP_PriceStartDate
                 ,clp.CLP_PriceEndDate
           FROM   CustomerLinePrice clp
                  INNER JOIN CustomerLineInfo cli
                       ON  cli.CLI_SN = clp.CLP_CLI_SN
           WHERE  1 = 1
                  AND cli.CLI_State IN (1005003 ,1005004)
                 ";
        $this->cli_no ? $sql.=$this->cli_no : false;
        $this->cli_grade ? $sql.=$this->cli_grade : false;
        $this->clp_pricetype ? $sql.=$this->clp_pricetype : false;
        $this->price_date ? $sql.=$this->price_date : false;
        $this->orderby ? $sql.=$this->orderby : false;
        $query = $this->HT->query($sql);
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
