<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 自动加载语种标签 
 */

class Currency {

    var $USD_Rate; //人民币兑美元汇率
    var $EUR_Rate; //人民币兑欧元汇率
    var $RUB_Rate; //人民币兑卢布汇率

    public function __construct() {
        $this->CI = & get_instance();
        log_message('debug', "Language Tags Class Initialized");
        $this->GetCurrencyRate();
    }

    function GetCurrencyRate() {
        $this->HT = $this->CI->load->database('HT', TRUE);
        $sql = "SELECT CRI_BuyIn / 100.00 AS tmpExRate, \n"
                . "       CRI_Code \n"
                . "FROM   tourmanager.dbo.CurrencyRateInfo \n"
                . "WHERE  CRI_Code IN ('USD', 'EUR', 'RUB') \n"
                . "       AND GETDATE() BETWEEN CRI_Start AND CRI_Stop";
        $query = $this->HT->query($sql);
        foreach ($query->result() as $item) {
            switch ($item->CRI_Code) {
                case 'USD':
                    $this->USD_Rate = $item->tmpExRate;
                    break;
                case 'EUR':
                    $this->EUR_Rate = $item->tmpExRate;
                    break;
                case 'RUB':
                    $this->RUB_Rate = $item->tmpExRate;
                    break;
            }
        }
//        echo $this->USD_Rate . '<br/>';
//        echo $this->EUR_Rate . '<br/>';
//        echo $this->RUB_Rate . '<br/>';
        return $query->result();
    }

    //根据人民币转换成站点对应的货币
    public function GetSiteMoney($RMB) {
        if (!is_numeric($RMB)) 
        {
            return $RMB;
        }
       
        $result = $RMB;
        if (is_numeric($RMB)) {
            switch (CONST_SITE_CURRENCY) {
                case 'USD':
                    $result = $RMB / $this->USD_Rate;
                    break;
                case 'EUR':
                    $result = $RMB / $this->EUR_Rate;
                    break;
                case 'RUB':
                    $result = $RMB / $this->RUB_Rate;
                    break;
            }
        }
        return ceil($result);
    }
    
    //把美金转换为人民币
    public function get_USD_RMB_SUM($USD) {
        
        if (!is_numeric($USD))return $USD;
        $result = $USD;
		$result = $USD * $this->USD_Rate;
        return ceil($result);
    }
	
    /**
     * 返回站点的汇率。
     * 
     * @author lmr
     */
    public function get_site_currencyrate() {
        switch (CONST_SITE_CURRENCY) {
            case 'USD':
                return $this->USD_Rate;
            case 'EUR':
                return $this->EUR_Rate;
            case 'RUB':
                return $this->RUB_Rate;
            default:
                return 1;
        }
    }
    
    /**
     * 返回带money_char的价格。
     * 
     * @param $money Int 价格.
     * @return String 带货币符号的价格。
     */ 
     public function get_money_char($money='') {
        
        switch (CONST_SITE_CODE) {
            case 'JP':
                return $money.'元';
            case 'GM':
                return '€'.$money;
            case 'VC':
                return $money.'€';
            case 'VAC':
                return '$'.$money;
            case 'RU':
                return '$'.$money;
            case 'IT':
                return '€'.$money;
            case 'SHT':
                return '$'.$money;
            default:
                return '$'.$money;
        }
     }
     
    /**
     * 返回带money_char的价格。
     * 
     * @param $money Int 价格.
     * @return String 带货币符号的价格。
     */ 
    public function get_site_money_with_char($money='') {
        return $this->get_money_char($this->GetSiteMoney($money));
     }
     
     
     /**
      * RMB换算成指定货币。
      * @param  int money   RMB
      * @param  string  char    货币代号：usd，eur
      * @return int 换算价格
      */ 
     public function convert_moneny_by_char($money,$char='')
     {
        switch (strtolower($char))
        {
            case 'usd':
                return ceil($money/$this->USD_Rate);
            case 'eur':
                return ceil($money/$this->EUR_Rate);
        }
        return $money;
     }
}