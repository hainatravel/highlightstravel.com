<?php

class CustomerLineInfo_model extends CI_Model {

    var $topnum = false; //返回记录数
    var $cli_no = false; //线路代号
    var $cli_grade = false; //(标准7001、豪华7002、经济7003）
    var $orderby = false;

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    public function init() {
        $this->topnum = false;
        $this->cli_no = false;
        $this->cli_grade = false;
        $this->orderby = ' ORDER BY cli.CLI_Grade ASC ';
    }

    public function search($cli_no, $topnum = false, $cli_grade = false) {
        $this->init();
        $this->topnum = empty($topnum) ? false : $topnum;
        $this->cli_no = ' AND cli.CLI_NO = ' . $this->HT->escape($cli_no);
        $this->cli_grade = empty($cli_grade) ? false : ' AND cli.CLI_Grade = ' . $this->HT->escape($cli_grade);
        return $this->get_list();
    }

    public function get_list() {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "    
                     cli.CLI_SN
                      ,cli.CLI_NO
                      ,cli.CLI_Days
                      ,cli.CLI_LineType
                      ,cli.CLI_Grade
                      ,cli.CLI_LineClass
                      ,cli2.CLI2_Name
                      ,cli2.CLI2_Introduction
                      ,cli2.CLI2_Memo
                      ,cli2.CLI2_PassCity
                      ,cli2.CLI2_DepartureCity
                      ,cli2.CLI2_EntranceCity
                FROM   CustomerLineInfo cli
                       INNER JOIN CustomerLineInfo2 cli2
                            ON  cli2.CLI2_CLI_SN = cli.CLI_SN
                   WHERE 1=1
                  AND cli.CLI_State IN (1005003 ,1005004)
                  AND cli.CLI_DEI_SN=?
                  AND cli2.CLI2_LGC = ?
                  
                 ";
        $this->cli_no ? $sql.=$this->cli_no : false;
        $this->cli_grade ? $sql.=$this->cli_grade : false;
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
