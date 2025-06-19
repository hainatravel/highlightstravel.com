<?php

class infoShortLinks_model extends CI_Model
{

    public $topnum = false; //返回记录数
    public $orderby = false;
    public $where = false; //查询条件

    public function __construct()
    {
        parent::__construct();
        $this->INFO = $this->load->database('INFO', true);
    }

    public function init()
    {
        $this->topnum = false;
        $this->where = false;
        $this->orderby = ' order by isl_datetime desc ';
    }

    public function detail($isl_link)
    {
        $this->init();
        $this->topnum = 1;
        $this->where = ' AND  isl_link=N' . $this->INFO->escape($isl_link);
        return $this->get_list();
    }

    public function detail_url($isl_URL)
    {
        $this->init();
        $this->topnum = 1;
        $this->where = ' AND  isl_URL=N' . $this->INFO->escape($isl_URL);
        return $this->get_list();
    }

    public function add($table, $data)
    {
        if ($this->INFO->insert($table, $data)) {
            return $this->INFO->last_id($table);
        } else {
            return false;
        }
    }

    public function get_list()
    {
        $this->topnum ? $sql = "SELECT TOP " . $this->topnum : $sql = "SELECT ";
        $sql .= "
                isl_link ,
                isl_type ,
                isl_URL
            FROM
                infoShortLinks isl
            WHERE 1=1
                 ";
        $this->where ? $sql .= $this->where : false;
        $this->orderby ? $sql .= $this->orderby : false;
        $query = $this->INFO->query($sql);
        //print_r($this->INFO->queries);
        if ($this->topnum === 1) {
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row;
            } else {
                return false;
            }
        } else {
            return $query->result();
        }
    }

}
