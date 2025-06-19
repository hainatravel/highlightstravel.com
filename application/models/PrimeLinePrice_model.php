<?php

class PrimeLinePrice_model extends CI_Model {

    var $topnum = false; //返回记录�?
    var $cli_no = false; //线路代号
    var $person_size = false; //人等
    var $cli_grade = 7001; //(标准7001、豪�?002、经�?003�?
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
        $this->price_date = false;
        $this->orderby = ' ORDER BY plp.PLP_Level ASC,plp.PLP_IsWeekPrice DESC,plp.PLP_AdultUnitPrice DESC ';
    }

    public function search($cli_no, $topnum = false, $cli_grade = false, $person_size = false, $price_date = false) {
        $this->init();
        $this->cli_no = $cli_no;
        $this->topnum = empty($topnum) ? false : $topnum;
        $this->cli_grade = empty($cli_grade) ? false : $this->cli_grade = ' AND  cli.CLI_Grade = ' . $this->HT->escape($cli_grade);
        $this->person_size = empty($person_size) ? false : $this->person_size = " AND $person_size BETWEEN plp.PLP_PersonGradeDown AND plp.PLP_PersonGradeUp ";
        if (!empty($price_date)) {
            $this->price_date = " AND '$price_date 00:00:00' BETWEEN plp.PLP_StartDate AND plp.PLP_EndDate ";
            $week_day = (int) date('w', strtotime($price_date)); //获取当前时间的星期号，用于判断周末价
            $this->price_date .=" 
                 AND (
                                (plp.PLP_IsWeekPrice=1 AND plp.PLP_WeekDefine LIKE '%$week_day%')
                                OR (plp.PLP_IsWeekPrice=0)
                            )
                     ";
        }
        return $this->get_list();
    }

    public function get_list() {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "    
                          cli.CLI_SN
                          ,cli.CLI_NO
                          ,cli.CLI_Grade
                          ,plp.PLP_SN
                          ,plp.PLP_CLI_SN
                          ,plp.PLP_Season
                          ,plp.PLP_Area
                          ,plp.PLP_StartDate
                          ,plp.PLP_EndDate
                          ,plp.PLP_PersonGradeDown
                          ,plp.PLP_PersonGradeUp
                          ,plp.PLP_AdultUnitCost
                          ,plp.PLP_AdultUnitPrice
                          ,plp.PLP_RoomDiffPrice
                          ,plp.PLP_ChildRate
                          ,plp.PLP_BabyRate
                          ,plp.PLP_ChildUnitPrice
                          ,plp.PLP_BabyUnitPrice
                          ,plp.PLP_Level
                          ,plp.PLP_IsWeekPrice
                          ,plp.PLP_WeekDefine
                          ,plp.PLP_PriceDate
                          ,plp.PLP_PersonNum
                          ,plp.PLP_VEI_SN
                          ,plp.PLP_Year
                          ,plp.PLP_VPPI_SN
                          ,plp.PLP_VPPD_SN
                          ,plp.PLP_Creator
                          ,plp.PLP_CreateDate
                          ,plp.PLP_LastEditor
                          ,plp.PLP_LastEditDate
                    FROM   PrimeLinePrice plp
                            INNER JOIN CustomerLineInfo cli
                                 ON  cli.CLI_SN = plp.PLP_CLI_SN
                    WHERE  1 = 1
                            AND cli.CLI_DEI_SN=?
                            AND plp.PLP_Year IS NOT NULL
                            AND cli.CLI_NO = ?
                            AND cli.CLI_State IN (1005003 ,1005004) 
                 ";

        $this->person_size ? $sql.=$this->person_size : false;
        $this->price_date ? $sql.=$this->price_date : false;
        $this->cli_grade ? $sql.=$this->cli_grade : false;
        $this->orderby ? $sql.=$this->orderby : false;

        $query = $this->HT->query($sql, array(CONST_SITE_DEPARTMENT,$this->cli_no));
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
