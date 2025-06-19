<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ip2location_db1_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->INFO = $this->load->database('INFO', TRUE);
    }


    public function get_country_by_ip($ip_number)
    {
        $sql = "
            SELECT TOP 1 ipdb.country_code, ipdb.country_name
            FROM   ip2location_db1 ipdb
            WHERE  ? BETWEEN ipdb.ip_from AND ipdb.ip_to 
        ";
        $query = $this->INFO->query($sql, array($ip_number));

        $country = array(
          'country_code' => '',
          'country_name' => ''          
        );

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $country = [
              'country_code' => $row->country_code,
              'country_name' => $row->country_name
          ];
        }
        
        return $country;
    }


    public function get_country_code($ip_number)
    {
        $sql = "
            SELECT TOP 1 ipdb.country_code
            FROM   ip2location_db1 ipdb
            WHERE  ? BETWEEN ipdb.ip_from AND ipdb.ip_to 
        ";
        $query = $this->INFO->query($sql, array($ip_number));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->country_code;
        } else {
            return FALSE;
        }
    }


    public function get_country_name($ip_number)
    {
        $sql = '
            SELECT TOP 1 ipdb.country_name
            FROM   ip2location_db1 ipdb
            WHERE  ? BETWEEN ipdb.ip_from AND ipdb.ip_to 
        ';
        $query = $this->INFO->query($sql, array($ip_number));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->country_name;
        } else {
            return FALSE;
        }
    }


}