<?php

class InfoMetas_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
    }

    function add($im_ic_id, $im_key, $im_value)
    {
        $sql = "INSERT INTO infoMetas \n"
                . "  ( \n"
                . "	im_ic_id, im_key, im_value \n"
                . "  ) \n"
                . "VALUES \n"
                . "  (  \n"
                . "	?, ?, N? \n"
                . "  )";
        return $this->HT->query($sql, array($im_ic_id, $im_key, $im_value));
    }

    function get($im_ic_id, $im_key)
    {
        $sql = "SELECT im.im_value \n"
                . "FROM   infoMetas im \n"
                . "WHERE  im.im_ic_id = ? \n"
                . "       AND im.im_key = ?";
        $query = $this->HT->query($sql, array($im_ic_id, $im_key));
        if ($query->num_rows() > 0)
        {
            return $query->row()->im_value;
        }
        else
        {
            return false;
        }
    }
	
	function detail($im_ic_id, $im_key)
	{
        $sql = "SELECT im.im_value \n"
                . "FROM   infoMetas im \n"
                . "WHERE  im.im_ic_id = ? \n"
                . "       AND im.im_key = ? ORDER BY im.im_id asc";
        $query = $this->HT->query($sql, array($im_ic_id, $im_key));
		return $query->result();
	}

    //获取未收录的信息
    public function get_unembody_content($datetime,$top_num=1){
        $sql="  SELECT TOP $top_num 
                            im_ic_id,
                            im_value,
                            ic_url,
                            ic_sitecode,
                            log_ht_usercode AS ic_author
                FROM        infoMetas 
                            INNER JOIN infoStructures ON is_ic_id=im_ic_id
                            INNER JOIN infoContents ON ic_id=im_ic_id
                            INNER JOIN infologs ON log_res_id=is_id
                WHERE       im_key = 'meta_embody' 
                            AND convert(varchar(500),im_value) != '1' 
                            AND convert(varchar(500),im_value)<N?
                ORDER BY im_id DESC";
        $query=$this->HT->query($sql,array($datetime));
        return $query->result();
    }

    function update($im_ic_id, $im_key, $im_value)
    {
        $sql = "UPDATE infoMetas \n"
                . "SET    im_value    = N? \n"
                . "WHERE  im_ic_id    = ? \n"
                . "       AND im_key  = ?";
        return $this->HT->query($sql, array($im_value, $im_ic_id, $im_key));
    }
	
    function delete($im_ic_id, $im_key)
    {
		$sql = "DELETE  \n"
			 . "FROM   infoMetas \n"
			 . "WHERE  im_ic_id = ? \n"
			 . "       AND im_key = ?";
        return $this->HT->query($sql, array($im_ic_id, $im_key));
    }
	
    
   
}