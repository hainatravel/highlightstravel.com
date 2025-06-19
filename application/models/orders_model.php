<?php

class Orders_model extends CI_Model {
    /*     * *********** 传统订单 *********** */

    var $COLI_WebCode = 'CHT'; //订单来源站点代号
    var $COLI_Servicetype = 'T'; //服务类型 T线路 4游船
    var $COLI_sourcetype = '32002'; //订单类型，楼下有一个表
    var $COLI_SenderIP = ''; //客人的IP地址
    var $COLI_Area = '2'; //市场区域 2欧美市场 9日本市场
    var $COLI_Currency = 'USD'; //结算货币 USD美元 RMB人民币 RUB卢布 EUR欧元
    var $COLI_CustomerType = '101'; //所属小组ID 楼下有个表
    var $COLI_department = '1'; //所属小组SN 楼下有个表
    var $COLI_OrderDetailText = ''; //订单预定信息，保存所有POST数据
    var $COLI_ID = ''; //订单号，根据$COLI_SN获取
    var $COLI_SN = ''; //订单表主键
    var $COLI_Name = ''; //订单名称
    var $COLI_Sended = 1; //是否预定newsletter
    var $COLI_TouristLGC = "102001"; //导游语种
    var $COLI_PersonNum = '0'; //预定人数，成人
    var $COLI_ChildNum = '0'; //预定人数，小孩
    var $COLI_BabyNum = '0'; //预定人数，婴儿
    var $COLI_OrderStartDate = ''; //行程开始时间
    var $COLI_OrderEndDate = ''; //行程结束时间
    var $COLI_ApplyDate = ''; //订单提交日期
    var $COLI_InterestRate = '0.2'; //利率
    var $COLI_TrueCardRate = '0.03'; //信用卡手续费
    var $COLI_CustomerClass = '3001'; //结算类型 3001综合服务
    var $COLI_OrderType = '19001'; //线路类型 19001散客定制
    var $COLI_PayManner = '123001'; //付款方式 123001信用卡
    var $COLI_GroupType = '19006'; //订单类型
    var $COLI_Days = '0'; //行程时间
    var $MEI_SN = ''; //联系人表主键
    var $MEI_FirstName = ''; //用户名
    var $MEI_LastName = ''; //用户名
    var $MEI_MailList = ''; //邮箱
    var $MEI_Mail = ''; //备用邮箱
    var $MEI_Nationality = '0'; //国家SN
    var $MEI_Phone = ''; //联系电话
    var $MEI_Gender = ''; //性别  100003女 100001男
    var $MEI_ServiceLang = ''; //导游语种SN
    var $MEI_Country = ''; //联系人国家SN
    var $MEI_IsVendor = ''; //供应商
    var $MEI_Birthday = ''; //客人生日
    var $COLI_ProductSN = '';
    var $COLI_Keywords = ''; //关键字
    var $COLI_Memo = NULL;
    var $COLI_OrderPrice = NULL; //订单总价
    var $COLI_OPI_SN = NULL;
    var $COLI_OrderSource = NULL; //订单来源设备 PC:62001 Table:62002 mobile 62003
	var $COLI_Purpose = NULL;
	var $COLI_LineClass = '';
  // PPC 广告系列，对应参数：utm_campaign
  var $COLI_LinkedMan = NULL;

    /* 订单来源类型
      32001	InquiryForm
      32002	Question
      32003	TailorMade
      32004	Callyou
      32005	邮件订单
      32006	Hotel
      32007	contactus
      32008	partner
      32009	travel buddy
      32015	Testimonial
      32016	三峡游船
      32017	FAQ订单
      32018	前台现付
      32019	传真
      32020	电话
      32021	Skype
      32022	在线Chat
      32023	电话租赁
      32024	火车票预订
      32026	分销合作
      32028	推荐营销
      32029	三峡游船在线支付
      32030	Newsletter
      32031	小包价实时支付
      32032	Wego
      32033	Call Center
      32034	Google PPC
     */

    /** 订单分类
      19001		长线
      19002		GP线路
      19003		结伴同游
      19004		一地线路
      19005		单订三峡
      19006		其他
      19007		单订火车票
      19008		单手机租赁
      19009		单订门票

     */
    /* 所属小组信息
      1		101	英文网络直销
      2		102	英文分销
      7		103	市场推广
      8		104	德语市场
      9		105	日语市场
      10	106	商务酒店机票
      11	107	法语市场
      12	108	西班牙语市场
      13	109	英文在线组
      14	110	商务Biztravel
      15	111	电话租赁
      16	112	MCT市场
      17	113	ChinaTravel组
      18	114	英文专业市场组
      19	115	英文亚洲组
      20	116	俄语市场
      21	117	意大利语市场
     */

    function __construct() {
        parent::__construct();
        $this->HT = $this->load->database('HT', TRUE);
        //读取默认配置
        $this->COLI_WebCode = $this->config->item('Site_Code');
        $this->COLI_Area = $this->config->item('Site_Area');
        $this->COLI_CustomerType = $this->config->item('Site_DepartmentID');
        $this->COLI_department = $this->config->item('Site_Department');
        $this->COLI_Currency = $this->config->item('Site_Currency');
        $this->COLI_InterestRate = $this->config->item('Site_InterestRate');
        $this->COLI_TrueCardRate = $this->config->item('Site_TrueCardRate');
        $this->COLI_TouristLGC = $this->config->item('Site_ServiceLGC');
        $this->COLI_OrderStartDate = null;
        $this->COLI_Keywords = NULL;
        switch ($this->check_device()) {
            case 'mobile':
                $this->COLI_OrderSource = '62003';
                break;
            case 'tablet':
                $this->COLI_OrderSource = '62002';
                break;
            default:
                $this->COLI_OrderSource = '62001';
        }
    }

    /*     * *********** 传统订单end ********** */

    function TourOrderSave() {
        //入库
        $sql = "INSERT INTO ConfirmLineInfoTmp \n"
                . "  ( \n"
                . "	COLI_Keywords, COLI_ID, COLI_WebCode, COLI_Servicetype, COLI_sourcetype, COLI_SenderIP,  \n"
                . "	COLI_Area, COLI_Currency, COLI_CustomerType, COLI_department,  \n"
                . "	COLI_OrderDetailText, COLI_Name, COLI_Sended, COLI_PersonNum, COLI_ChildNum,  \n"
                . "	COLI_BabyNum, COLI_OrderStartDate, COLI_OrderEndDate, COLI_InterestRate,  \n"
                . "	COLI_TrueCardRate, COLI_CustomerClass, COLI_OrderType, COLI_PayManner,COLI_TouristLGC,  \n"
                . "	COLI_GroupType,COLI_Days,COLI_ProductSN, \n"
                . "	COLI_ApplyDate,COLI_OPI_ID,COLI_Memo,COLI_OrderPrice,COLI_OrderSource,COLI_Purpose,COLI_LineClass, "
                . " COLI_LinkedMan"
                . "  ) \n"
                . "VALUES \n"
                . "  (  \n"
                . "	?, ?, ?, ?, ?, ?, ?, ?, ?, ?, N?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,GETDATE(),?,?,?,?,?,?,? \n"
                . "  )";
        $query = $this->HT->query($sql, array($this->COLI_Keywords, $this->COLI_ID, $this->COLI_WebCode, $this->COLI_Servicetype, $this->COLI_sourcetype, $this->COLI_SenderIP, $this->COLI_Area, $this->COLI_Currency, $this->COLI_CustomerType, $this->COLI_department, $this->HT->escape_str($this->COLI_OrderDetailText), $this->COLI_Name, $this->COLI_Sended, $this->COLI_PersonNum, $this->COLI_ChildNum, $this->COLI_BabyNum, $this->COLI_OrderStartDate, $this->COLI_OrderEndDate, $this->COLI_InterestRate, $this->COLI_TrueCardRate, $this->COLI_CustomerClass, $this->COLI_OrderType, $this->COLI_PayManner, $this->COLI_TouristLGC, $this->COLI_GroupType, $this->COLI_Days, $this->COLI_ProductSN, $this->COLI_OPI_SN, $this->COLI_Memo, $this->COLI_OrderPrice, $this->COLI_OrderSource,$this->COLI_Purpose,$this->COLI_LineClass,$this->COLI_LinkedMan));

        $this->COLI_SN = $this->HT->insert_id();
        //lmr:备用邮箱容错
        if ($this->MEI_Mail == '0') {
            $this->MEI_Mail = '';
        }
        $sql = "INSERT INTO MEmberInfoTmp \n"
                . "  ( \n"
                . "	MEI_FirstName, MEI_LastName, MEI_MailList, MEI_Nationality, MEI_Phone,  \n"
                . "	MEI_Gender, MEI_ServiceLang, MEI_Country, MEI_Birthday,MEI_Mail, CreateDate \n"
                . "  ) \n"
                . "VALUES \n"
                . "  (  \n"
                . "	N?, N?, ?, ?, ?, ?, ?, ?, ?,?, GETDATE() \n"
                . "  )";

        $query = $this->HT->query($sql, array($this->MEI_FirstName, $this->MEI_LastName, $this->MEI_MailList, $this->MEI_Nationality, $this->MEI_Phone, $this->MEI_Gender, $this->MEI_ServiceLang, $this->MEI_Nationality, $this->MEI_Birthday, $this->MEI_Mail));
        $this->MEI_SN = $this->HT->insert_id();
        //print_r($this->HT->queries);

        $sql = "INSERT INTO CUstomerListTmp \n"
                . "  ( \n"
                . "	CUL_COLI_SN, CUL_CUI_SN, CreateDate \n"
                . "  ) \n"
                . "VALUES \n"
                . "  (  \n"
                . "	?, ?, GETDATE() \n"
                . "  )";
        $query = $this->HT->query($sql, array($this->COLI_SN, $this->MEI_SN));

        //增加存储客人表CustomerLineInfo

        return $query;
    }

    /*     * *********** 商务订单 ********** */

    var $GUT_SN;
    var $GUT_FirstName; //联系人
    var $GUT_LastName = ""; //联系人
    var $GUT_Title;     //称谓
    var $GUT_Email;     //主email
    var $GUT_Email2;     //备用email
    var $GUT_NationalityID;  //国家
    var $GUT_Passport;   //护照
    var $GUT_TEL;    //座机
    var $GUT_MoveTel;    //手机

    /**
     * 商务联系人表入库
     *
     * @return  int GUT_SN  插入id
     */

    function biz_guest_save() {
        //生成一个号码，用于MAX函数来查询插入ID时避免获得其它线程插入的值
        $AddCode = $this->MakeOrderNumber();
        $sql = "INSERT INTO BIZ_Guest \n"
                . "  ( \n"
                . "    GUT_FirstName, \n"
                . "    GUT_LastName, \n"
                . "    GUT_Title, \n"
                . "    GUT_Email, \n"
                . "    GUT_Email2, \n"
                . "    GUT_NationalityID, \n"
                . "    GUT_Passport, \n"
                . "    GUT_TEL, \n"
                . "    GUT_MoveTel, \n"
                . "    GUT_AddCode, \n"
                . "    GUT_CreateDate \n"
                . "  ) \n"
                . "VALUES \n"
                . "  ( \n"
                . "    N?, \n"
                . "    N?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    GETDATE() \n"
                . "  )";
        $query = $this->HT->query($sql, array($this->GUT_FirstName,
            $this->GUT_LastName,
            $this->GUT_Title,
            $this->GUT_Email,
            $this->GUT_Email2,
            $this->GUT_NationalityID,
            $this->GUT_Passport,
            $this->GUT_TEL,
            $this->GUT_MoveTel, $AddCode));
        $this->GUT_SN = $this->HT->query('select MAX(GUT_SN) as insert_id FROM BIZ_Guest WHERE GUT_AddCode=' . $AddCode)->row('insert_id');
        return $this->GUT_SN;
    }

    var $BIZ_COLI_ID;
    var $BIZ_COLI_GUT_SN;   //联系人id
    var $BIZ_COLI_Area;     //市场
    var $BIZ_COLI_ApplyDate;    //提交日期
    var $BIZ_COLI_Price;   //订单总价
    var $BIZ_COLI_Cost; //总成本
    var $BIZ_COLI_Currency; //币种
    var $BIZ_COLI_TrueCardRate; //信用卡手续费
    var $BIZ_COLI_SenderIP; //客人ip
    var $BIZ_COLI_WebCode = '';  //站点code
    var $BIZ_COLI_servicetype;  //订单来源类型
    var $BIZ_COLI_sourcetype;   //预定类型
    var $BIZ_COLI_AgencyID;
    var $BIZ_COLI_ConfirmType;  //提交方式
    var $BIZ_COLI_OrderDetailText;

    /**
     * 商务订单主表入库
     *
     * @return  int BIZ_COLI_ID  插入id
     */
    function biz_confirm_save() {
        if (empty($this->BIZ_COLI_WebCode)) {
            $this->BIZ_COLI_WebCode = $this->config->item('Site_Code');
        }
        //生成一个号码，用于MAX函数来查询插入ID时避免获得其它线程插入的值
        $AddCode = $this->MakeOrderNumber();
        $sql = "INSERT INTO BIZ_ConfirmLineInfo \n"
                . "( \n"
                . "	COLI_ID, \n"
                . "	COLI_GUT_SN, \n"
                . "	COLI_Area, \n"
                . "	COLI_ApplyDate, \n"
                . "	COLI_Price, \n"
                . "	COLI_Cost, \n"
                . "	COLI_Currency, \n"
                . "	COLI_TrueCardRate, \n"
                . "	COLI_AgencyID, \n"
                . "	COLI_OrderDetailText, \n"
                . "	COLI_SenderIP, \n"
                . "	COLI_WebCode, \n"
                . "	COLI_servicetype, \n"
                . "	COLI_sourcetype, \n"
                . "	COLI_ConfirmType, \n"
                . "    COLI_State, \n"
                . "    COLI_Department, \n"
                . "    COLI_AddCode, \n"
                . "    COLI_OrderSource \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	getdate(), \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	N?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ? \n"
                . ")";
        $query = $this->HT->query($sql, array($this->BIZ_COLI_ID,
            $this->BIZ_COLI_GUT_SN,
            $this->config->item('Site_Area'),
            //date("Y-m-d H:i:s"),
            $this->BIZ_COLI_Price,
            $this->BIZ_COLI_Cost,
            $this->config->item('Site_Currency'),
            $this->BIZ_COLI_TrueCardRate,
            $this->BIZ_COLI_AgencyID,
            $this->BIZ_COLI_OrderDetailText,
            $this->BIZ_COLI_SenderIP,
            $this->BIZ_COLI_WebCode,
            $this->BIZ_COLI_servicetype,
            $this->BIZ_COLI_sourcetype,
            $this->BIZ_COLI_ConfirmType,
            999,
            $this->config->item('Site_Department'),
            $AddCode,
            $this->COLI_OrderSource));
        $this->BIZ_COLI_ID = $this->HT->query('select MAX(COLI_SN) as insert_id FROM BIZ_ConfirmLineInfo WHERE COLI_AddCode=' . $AddCode)->row('insert_id');
        return $this->BIZ_COLI_ID;
    }

    var $COLD_SN;
    var $COLD_COLI_SN;      //订单主表sn
    var $COLD_ServiceType;  //服务类型
    var $COLD_StartDate;    //产品的服务的开始日期
    var $COLD_EndDate;      //产品的服务的结束日期
    var $COLD_TotalCost;    //总成本
    var $COLD_TotalPrice;   //总报价
    var $COLD_Count;        //产品数量
    var $COLD_PersonNum;    //成人数
    var $COLD_ChildNum;     //小孩数
    var $COLD_BabyNum;      //婴儿数
    var $cold_state;        //状态
    var $DeleteFlag;        //删除标志
    var $COLD_DeliveryCharge = 0; //快递费用
    var $COLD_PlanVEI_SN = NULL; //默认供应商 628-火车桂林国旅
    var $COLD_SPFS = NULL;  //快递方式：1自取 2酒店 3指定地址
    var $COLD_ServiceSN = NULL; //产品ID 除机票外 其它自基础产品库各产品ID

    /**
     * 商务订单子（详细）表入库
     *
     * @return int  插入id
     */

    function biz_confirm_detail_save() {
        //生成一个号码，用于MAX函数来查询插入ID时避免获得其它线程插入的值
        $AddCode = $this->MakeOrderNumber();
        $sql = "INSERT INTO BIZ_ConfirmLineDetail \n"
                . "( \n"
                . "	COLD_COLI_SN, \n"
                . "	COLD_ServiceType, \n"
                . "	COLD_StartDate, \n"
                . "	COLD_EndDate, \n"
                . "	COLD_TotalCost, \n"
                . "	COLD_TotalPrice, \n"
                . "	COLD_Count, \n"
                . "	COLD_PersonNum, \n"
                . "	COLD_ChildNum, \n"
                . "	COLD_BabyNum, \n"
                . "	cold_state, \n"
                . "	DeleteFlag, \n"
                . "    COLD_DeliveryCharge, \n"
                . "    COLD_AddCode, \n"
                . "    COLD_PlanVEI_SN, \n"
                . "    COLD_SPFS, \n"
                . "    COLD_ServiceSN \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "  ? \n"
                . ")";
        $HT1 = $this->load->database('HT', true);
        $query = $HT1->query($sql, array($this->COLD_COLI_SN,
            $this->COLD_ServiceType,
            $this->COLD_StartDate,
            $this->COLD_EndDate,
            $this->COLD_TotalCost,
            $this->COLD_TotalPrice,
            $this->COLD_Count,
            $this->COLD_PersonNum,
            $this->COLD_ChildNum,
            $this->COLD_BabyNum,
            $this->cold_state,
            $this->DeleteFlag,
            $this->COLD_DeliveryCharge,
            $AddCode,
            $this->COLD_PlanVEI_SN,
            $this->COLD_SPFS,
            $this->COLD_ServiceSN)
        );
        //查出最近插入的id
        $HT2 = $this->load->database('HT', true);
        $this->COLD_SN = $HT2->query('select MAX(COLD_SN) as insert_id FROM BIZ_ConfirmLineDetail WHERE COLD_AddCode=' . $AddCode)->row('insert_id');
        return $this->COLD_SN;
    }

    var $FOI_SN;
    var $FOI_COLD_SN;       // 订单子表sn
    var $Aircompany;        //航空公司编码
    var $FlightsNo;         //航班号
    var $Cabin;             //舱位
    var $DepartAirport;     //出发机场
    var $ArrivalAirport;    //抵达机场
    var $DepartureCity;     //出发城市
    var $DepartureTime;     //出发日期
    var $ArrivalCity;       //抵达城市
    var $Arrivaltime;       //抵达时间
    var $DepartureDate;     //出发时间
    var $adultCost;         //成人成本
    var $childCost;         //小孩成倍
    var $babyCost;          //婴儿成本
    var $adultPrice;        //成人报价
    var $childPrice;        //小孩报价
    var $babyPrice;         //婴儿报价
    var $Stopover;          //
    var $PriceY;            //Y仓价格
    var $price_low;         //最低价格
    var $FOI_Mile;         //里程
    var $TicketAddress = '';  //寄送地址
    var $FOI_CostTime = '';   //运行时间
    var $Aircraft = '';   //12306座位编号

    /**
     *
     * 商务机票订单入库
     *
     */

    function biz_flight_order_save() {
        //生成一个号码，用于MAX函数来查询插入ID时避免获得其它线程插入的值
        $AddCode = $this->MakeOrderNumber();
        $sql = "INSERT INTO BIZ_FlightsOrderInfo \n"
                . "( \n"
                . "	FOI_COLD_SN, \n"
                . "	Aircompany, \n"
                . "	FlightsNo, \n"
                . "	Cabin, \n"
                . "	DepartAirport, \n"
                . "	ArrivalAirport, \n"
                . "	DepartureCity, \n"
                . "	DepartureTime, \n"
                . "	ArrivalCity, \n"
                . "	Arrivaltime, \n"
                . "	DepartureDate, \n"
                . "	adultCost, \n"
                . "	childCost, \n"
                . "	babyCost, \n"
                . "	adultPrice, \n"
                . "	childPrice, \n"
                . "	babyPrice, \n"
                . "	Stopover, \n"
                . "	PriceY, \n"
                . "	price_low, \n"
                . "	FOI_Mile, \n"
                . "    TicketAddress, \n"
                . "    FOI_CostTime, \n"
                . "    FOI_AddCode, \n"
                . "    Aircraft \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	? \n"
                . ")";
        $HT1 = $this->load->database('HT', true);
        $query = $HT1->query($sql, array($this->FOI_COLD_SN,
            $this->Aircompany,
            $this->FlightsNo,
            $this->Cabin,
            $this->DepartAirport,
            $this->ArrivalAirport,
            $this->DepartureCity,
            $this->DepartureTime,
            $this->ArrivalCity,
            $this->Arrivaltime,
            $this->DepartureDate,
            $this->adultCost,
            $this->childCost,
            $this->babyCost,
            $this->adultPrice,
            $this->childPrice,
            $this->babyPrice,
            $this->Stopover,
            $this->PriceY,
            $this->price_low,
            $this->FOI_Mile,
            $this->TicketAddress,
            $this->FOI_CostTime,
            $AddCode,
            $this->Aircraft));
        $this->FOI_SN = $HT1->query('select MAX(FOI_SN) as insert_id FROM BIZ_FlightsOrderInfo WHERE FOI_AddCode=' . $AddCode)->row('insert_id');
        return $this->FOI_SN;
    }

    var $BPE_SN;
    var $BPE_FirstName;     //客人
    var $BPE_MiddleName;    //客人
    var $BPE_LastName;      //客人
    var $BPE_GuestType;     //客人类型
    var $BPE_Passport;      //护照
    var $BPE_imageSrc = '';   //护照图片
    var $BPE_Nationality;   //国籍
    var $BPE_SEX;           //性别
    var $BPE_BirthDate;     //生日

    /**
     *
     * 商务订单参团客人入库
     *
     */

    function biz_book_people_save() {
        //生成一个号码，用于MAX函数来查询插入ID时避免获得其它线程插入的值
        $AddCode = $this->MakeOrderNumber();
        $sql = "INSERT INTO BIZ_BookPeople \n"
                . "( \n"
                . "	BPE_FirstName, \n"
                . "	BPE_MiddleName, \n"
                . "	BPE_LastName, \n"
                . "	BPE_GuestType, \n"
                . "	BPE_Passport, \n"
                . "	BPE_imageSrc, \n"
                . "	BPE_Nationality, \n"
                . "	BPE_SEX, \n"
                . "	BPE_BirthDate, \n"
                . "	BPE_AddCode \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	N?, \n"
                . "	N?, \n"
                . "	N?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	? \n"
                . ")";
        $query = $this->HT->query($sql, array($this->BPE_FirstName, $this->BPE_MiddleName,
            $this->BPE_LastName, $this->BPE_GuestType,
            $this->BPE_Passport, $this->BPE_imageSrc,
            $this->BPE_Nationality,
            $this->BPE_SEX, $this->BPE_BirthDate, $AddCode));
        $this->BPE_SN = $this->HT->query('select MAX(BPE_SN) as insert_id FROM BIZ_BookPeople WHERE BPE_AddCode=' . $AddCode)->row('insert_id');
        return $this->BPE_SN;
    }

    /**
     * 参团人关联
     *
     * @param   int 商务子表sn
     * @param   int 参团客人sn
     */
    function biz_bookpeople_List_save($COLD_SN, $BPE_SN) {
        $sql = "INSERT INTO BIZ_BookPeopleList \n"
                . "( \n"
                . "	BPL_COLD_SN, \n"
                . "	BPL_BPE_SN \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	? \n"
                . ")";
        $query = $this->HT->query($sql, array($COLD_SN, $BPE_SN));
    }

    /*
     * 生成订单号
     * 根据系统时间生成，精确到0.0001微秒
     */

    function MakeOrderNumber() {
        return str_replace('.', '', sprintf('%11.4f', gettimeofday(TRUE)));
    }

    /**
     * 生成商务订单号
     */
    function biz_make_order_number() {
        /*
          $date = date('ymd',time());
          $sql = "SELECT MAX( \n"
          . "           CONVERT( \n"
          . "               INT, \n"
          . "               CASE  \n"
          . "                    WHEN ISNUMERIC(RIGHT(COLI_ID, 3)) = 0 THEN LEFT(RIGHT(COLI_ID, 4), 3) \n"
          . "                    ELSE RIGHT(COLI_ID, 3) \n"
          . "               END \n"
          . "           ) \n"
          . "       ) AS SN \n"
          . "FROM   dbo.BIZ_ConfirmLineInfo  \n"
          . "WHERE  (LEFT(COLI_ID, 6) = ?)";
          $query = $this->HT->query($sql,array($date));
          $id = $query->row()->SN;
          if (is_null($id)||empty($id))
          {
          $id = 0;
          }
          $ids = $date.(sprintf('%03d',(int)$id+1));
          return $ids;
         */
        //call $conn
        include('c:/database_conn.php');
        $connection = array(
            'UID' => $db['HT']['username'],
            'PWD' => $db['HT']['password'],
            'Database' => 'tourmanager',
            'ConnectionPooling' => 1,
            'CharacterSet' => 'utf-8',
            'ReturnDatesAsStrings' => 1
        );
        $conn = sqlsrv_connect($db['HT']['hostname'], $connection);
        $stmt = sqlsrv_query($conn, "declare @ccid varchar(20);exec dbo.SP_GetBIZOrderNo @ccid out;select @ccid as ccid;");
        if ($stmt === false) {
            echo "Error in executing statement 3.\n";
            die(print_r(sqlsrv_errors(), true));
        } else {
            //存储过程中每一个select都会产生一个结果集，取某个结果集就需要从第一个移动到需要的那个结果集
            //如果结果集为空就移到下一个
            while (sqlsrv_has_rows($stmt) !== TRUE) {
                sqlsrv_next_result($stmt);
            }

            $result_object = array();
            while ($row = sqlsrv_fetch_object($stmt)) {
                $result_object[] = $row;
            }

            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);

            return($result_object[0]->ccid);
        }
    }

    /**
     *
     * 更新订单状态(商务订单)
     *
     */
    public function update_biz_order($order_id, $pay_manager, $source_type, $state, $text = '') {
        //更新订单
        $sql = "UPDATE BIZ_ConfirmLineInfo SET COLI_PayManner=?,COLI_sourcetype=?,COLI_State=?,COLI_OrderDetailText=COLI_OrderDetailText+? WHERE COLI_ID=?";
        $query = $this->HT->query($sql, array($pay_manager, $source_type, $state, $text, $order_id . ''));
        $this->insert_acc_info($order_id);
        return '是否执行:' . print_r($query, true) . ' sql:' . $sql . ' 参数:' . print_r(array($pay_manager, $source_type, $state, $text, $order_id . ''), true);
    }

    /**
     *
     * 更新火车订单购票截图
     *
     */
    public function update_train_order_pic($order_pic_id) {
        //更新订单
        $sql = "exec dbo.SP_BIZ_GroupFinanceList_Insert '" . $order_pic_id . "'";
        //$query = $this->HT->query($sql);

        include('c:/database_conn.php');
        $connection = array(
            'UID' => $db['HT']['username'],
            'PWD' => $db['HT']['password'],
            'Database' => 'tourmanager',
            'ConnectionPooling' => 1,
            'CharacterSet' => 'utf-8',
            'ReturnDatesAsStrings' => 1
        );
        $conn = sqlsrv_connect($db['HT']['hostname'], $connection);
        $stmt = sqlsrv_query($conn, $sql);

        return $stmt;
    }

    /**
     *
     * 插入收款记录
     *
     */
    public function insert_acc_info($order_id) {
        //获取订单
        $sql = "Select Top 1 COLI_SN,COLI_ID,COLI_PayManner,COLI_Price From BIZ_ConfirmLineInfo Where COLI_ID = ?";
        $query = $this->HT->query($sql, array($order_id));
        $order_info = $query->row();
        //插入记录
        $sql = "INSERT INTO BIZ_GroupAccountInfo \n"
                . "  ( \n"
                . "    GAI_COLI_SN, \n"
                . "    GAI_COLI_ID, \n"
                . "    GAI_Type, \n"
                . "    GAI_SQJE, \n"
                . "    GAI_SQDate, \n"
                . "    GAI_SSJE, \n"
                . "    GAI_SQJECurrency, \n"
                . "    GAI_SSDate, \n"
                . "    GAI_CusName, \n"
                . "    GAI_CusEmail, \n"
                . "    GAI_Memo \n"
                . "  ) \n"
                . "VALUES \n"
                . "  ( \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ?, \n"
                . "    ? \n"
                . "  )";
        $query = $this->HT->query($sql, array($order_info->COLI_SN,
            $order_info->COLI_ID,
            $order_info->COLI_PayManner,
            $order_info->COLI_Price,
            date('Y-m-d H:i:s'),
            $order_info->COLI_Price,
            $this->config->item('Site_Currency'),
            date('Y-m-d H:i:s'),
            "", "", " "));
    }

    function GetNationalityID($nationalityName) {
        if (!$nationalityName) {
            return 0;
        }
        if (is_numeric($nationalityName)) {
            return $nationalityName;
        } else {
            $sql = "SELECT TOP 1 ci2.COI2_COI_SN \n"
                    . "FROM   COuntryInfo2 ci2 \n"
                    . "WHERE  ci2.COI2_Country = ? ";
            $query = $this->HT->query($sql, array($nationalityName));
            if ($query->result()) {
                $row = $query->row();
                return $row->COI2_COI_SN;
            } else {
                return 0;
            }
        }
    }

    /**
     * $country_code = 'United States +1';
     * $country_name = 'United States';
     * $country_id = 3;
     */
    public function get_country_id_by_code($country_code) {

      $country_id = 0;
      $country_array = explode('+', $country_code);

      if (count($country_array) > 1) {
        $country_name = trim($country_array[0]);
        $sql = "SELECT TOP 1 ci2.COI2_COI_SN \n"
                . "FROM COuntryInfo2 ci2 \n"
                . "WHERE ci2.COI2_LGC = 1 and ci2.COI2_Country = ? ";
        $query = $this->HT->query($sql, array($country_name));

        if ($query->result()) {
          $row = $query->row();
          $country_id = $row->COI2_COI_SN;
        }
      }

      return $country_id;
    }

    function GetNationalityName($nationalityID) {
        if (!is_numeric($nationalityID)) {
            return $nationalityID;
        } else {
            $sql = "SELECT TOP 1  ci2.COI2_Country \n"
                    . "FROM   COuntryInfo2 ci2 \n"
                    . "WHERE  ci2.COI2_LGC = 2 \n"
                    . "       AND ci2.COI2_COI_SN = ? ";
            $query = $this->HT->query($sql, array($nationalityID));
            if ($query->result()) {
                $row = $query->row();
                return $row->COI2_Country;
            } else {
                return $nationalityID;
            }
        }
    }

    /**
     *
     * 获取商务订单信息
     * @param   string  $order_id   订单id
     * @return  mixed   订单信息
     *
     */
    public function get_flight_order_by_id($order_id) {
        $sql = "SELECT DISTINCT cli.COLI_ID, \n"
                . "       cli.COLI_Price, \n"
                . "       bg.GUT_FirstName, \n"
                . "       bg.GUT_LastName, \n"
                . "       bg.GUT_Email, \n"
                . "       bg.GUT_Email2, \n"
                . "       bpe.BPE_SN, \n"
                . "       bpe.BPE_GuestType, \n"
                . "       bpe.BPE_FirstName, \n"
                . "       bpe.BPE_MiddleName, \n"
                . "       bpe.BPE_LastName, \n"
                . "       bpe.BPE_GuestType, \n"
                . "       bpe.BPE_Passport, \n"
                . "       cld.COLD_Count, \n"
                . "       foi.FlightsNo, \n"
                . "       foi.DepartureDate, \n"
                . "       foi.DepartureTime, \n"
                . "       foi.ArrivalTime, \n"
                . "       cli.COLI_PayManner, \n"
                . "       cli.COLI_State, \n"
                . "       cli.COLI_sourcetype, \n"
                . "       foi.Cabin, \n"
                . "       foi.DepartAirport, \n"
                . "       foi.ArrivalAirport, \n"
                . "       cld.COLD_SN, \n"
                . "       foi.DepartureCity, \n"
                . "       foi.ArrivalCity, \n"
                . "       bg.GUT_TEL, \n"
                . "       bg.GUT_NationalityID, \n"
                . "       cli.COLI_OrderDetailText, \n"
                . "       bpe.BPE_imageSrc, \n"
                . "       cli.COLI_Cost, \n"
                . "       cld.COLD_TotalPrice, \n"
                . "       cld.COLD_TotalCost \n"
                . "FROM   BIZ_ConfirmLineInfo cli \n"
                . "       INNER JOIN BIZ_ConfirmLineDetail cld \n"
                . "            ON  cli.COLI_SN = cld.COLD_COLI_SN \n"
                . "       INNER JOIN BIZ_GUEST bg \n"
                . "            ON  bg.GUT_SN = cli.COLI_GUT_SN \n"
                . "       INNER JOIN BIZ_BookPeopleList bpl \n"
                . "            ON  bpl.BPL_COLD_SN = cld.COLD_SN \n"
                . "       INNER JOIN BIZ_BookPeople bpe \n"
                . "            ON  bpl.BPL_BPE_SN = bpe.BPE_SN \n"
                . "       INNER JOIN BIZ_FlightsOrderInfo foi \n"
                . "            ON  foi.FOI_COLD_SN = cld.COLD_SN \n"
                . "WHERE  cli.COLI_ID = ? AND isnull(cld.deleteflag,0) = 0 ";

        $query = $this->HT->query($sql, array($order_id));
        return $query->result();
    }

    /**
     *
     * 获取机票订单乘员列表
     * @param   string  $order_id   订单id
     * @return  mixed   订单信息
     *
     */
    public function get_bpe_list_by_id($order_id) {
        $sql = "SELECT DISTINCT bpe.BPE_SN, \n"
                . "       bpe.BPE_FirstName, \n"
                . "       bpe.BPE_MiddleName, \n"
                . "       bpe.BPE_LastName, \n"
                . "       bpe.BPE_Passport \n"
                . "FROM   BIZ_BookPeople bpe \n"
                . "       INNER JOIN BIZ_BookPeopleList bpl \n"
                . "            ON  bpe.BPE_SN = bpl.BPL_BPE_SN \n"
                . "       INNER JOIN BIZ_ConfirmLineDetail cold \n"
                . "            ON  bpl.BPL_COLD_SN = cold.COLD_SN \n"
                . "       INNER JOIN BIZ_ConfirmLineInfo coli \n"
                . "            ON  coli.COLI_SN = cold.COLD_COLI_SN \n"
                . "WHERE  coli.COLI_ID = ?";
        $query = $this->HT->query($sql, array($order_id));
        //echo('<!--'.$this->HT->compile_binds($sql,array($order_id)).'-->');
        return $query->result();
    }

    /**
     *
     * 获取机票电子票号
     * @param   array  bpe_sn   乘客sn数组
     * @return  mixed   机票票号
     *
     */
    public function get_ticket_no($bpe_sn) {
        if (is_array($bpe_sn)) {
            $instr = join(',', $bpe_sn);
        } elseif (is_string($bpe_sn)) {
            $instr = $bpe_sn;
        } else {
            $instr = 0;
        }
        $sql = "SELECT DISTINCT ftn.FTN_FilghtsNo, \n"
                . "       ftn.FTN_TicketNo, \n"
                . "       ftn.FTN_GuestNo \n"
                . "FROM   BIZ_FlightsTicketNo ftn \n"
                . "WHERE  ftn.FTN_GuestNo IN (" . $instr . ")";
        $query = $this->HT->query($sql);
        return $query->result();
    }

    /*
     * 发送邮件
     */

    function SendMail($fromName, $fromEmail, $toName, $toEmail, $subject, $body) {
        $sql = "INSERT INTO Email_AutomaticSend \n"
                . "  ( \n"
                . "	M_ReplyToName, M_ReplyToEmail, M_ToName, M_ToEmail, M_Title, M_Body, M_Web,  \n"
                . "	M_FromName, M_State \n"
                . "  ) \n"
                . "VALUES \n"
                . "  (  \n"
                . "	?, ?, ?, ?, ?, ?, ?, ?, 0 \n"
                . "  ) ";
        $query = $this->HT->query($sql, array($fromName, $fromEmail, $toName, $toEmail, $subject, $body, $this->config->item('Site_Code'), $this->config->item('Site_Domain')));
        return $query;
    }

    /**
     * wifi预订入库(目前仅CHT使用)
     *
     * @return int  插入id
     */
    var $WOI_COLD_SN;
    var $WOI_Device;       //设备（智能手机、pad）
    var $WOI_DeviceCount;  //设备数量
    var $WOI_UsersCount;   //使用人数
    var $WOI_Package;      //Wi-Fi套餐
    var $WOI_PackageCount; //套餐数量
    var $WOI_DeliverDate;  //起租日期
    var $WOI_DeliverCity;  //起租城市
    var $WOI_DeliverAddr;  //起租地址
    var $WOI_ReturnDate;   //归还日期
    var $WOI_ReturnCity;   //归还城市
    var $WOI_ReturnAddr;   //归还地址
    var $WOI_OtherService; //其他服务
    var $WOI_GroupNo;      //团号
    var $WOI_ExpressNo;    //快递单号

    public function biz_wifi_info_save() {
        $sql = "INSERT INTO BIZ_WifiOrderInfo \n"
                . "( \n"
                . "	WOI_COLD_SN, \n"
                . "	WOI_Device, \n"
                . "	WOI_DeviceCount, \n"
                . "	WOI_UsersCount, \n"
                . "	WOI_Package, \n"
                . "	WOI_PackageCount, \n"
                . "	WOI_DeliverDate, \n"
                . "	WOI_DeliverCity, \n"
                . "	WOI_DeliverAddr, \n"
                . "	WOI_ReturnDate, \n"
                . "	WOI_ReturnCity, \n"
                . "	WOI_ReturnAddr, \n"
                . "    WOI_OtherService, \n"
                . "    WOI_GroupNo, \n"
                . "    WOI_ExpressNo \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	? \n"
                . ")";
        $HT1 = $this->load->database('HT', true);
        $query = $HT1->query($sql, array($this->WOI_COLD_SN,
            $this->WOI_Device,
            $this->WOI_DeviceCount,
            $this->WOI_UsersCount,
            $this->WOI_Package,
            $this->WOI_PackageCount,
            $this->WOI_DeliverDate,
            $this->WOI_DeliverCity,
            $this->WOI_DeliverAddr,
            $this->WOI_ReturnDate,
            $this->WOI_ReturnCity,
            $this->WOI_ReturnAddr,
            $this->WOI_OtherService,
            $this->WOI_GroupNo,
            $this->WOI_ExpressNo
        ));
    }

    /**
     * 酒店预订入库
     *
     * @return int  插入id
     */
    var $HOI_COLD_SN; //必选
    var $HOI_NoSmoking = null;  //无烟房
    var $HOI_EarlyTime = null;  //最早确认时间，已不用
    var $HOI_LastTime = null;   //最晚确认时间，已不用
    var $HOI_Room_NO = null;    //房号
    var $HOI_ExtraNum = 0;      //加床
    var $HOI_RoomTypeName = null; //房型
    var $HOI_BreakNum = null;   //早餐人数
    var $HOI_PriceType = null;  //价格类型
    var $HOI_BreakType = null;  //早餐类型
    var $HOI_RoomRates = null;
    var $HOI_ExtrabedRates = null;
    var $HOI_TaxFee = null;

    public function biz_hotel_order_save() {
        /* ASP版本
          sql="select * from BIZ_HotelOrderInfo where 1=2"
          rs2.open sql,conn,3,3,1
          rs2.addnew
          rs2("HOI_COLD_SN")=COLD_SN
          rs2("HOI_ExtraNum") = extrabed
          if clng(Smoking)<2 then
          rs2("HOI_NoSmoking")=Smoking
          end if
          rs2("HOI_EarlyTime")=earlydate
          rs2("HOI_LastTime")=""
          rs2.update
          rs2.close
         */
        $sql = "INSERT INTO BIZ_HotelOrderInfo \n"
                . "( \n"
                . "	HOI_COLD_SN, \n"
                . "	HOI_NoSmoking, \n"
                . "	HOI_EarlyTime, \n"
                . "	HOI_LastTime, \n"
                . "	HOI_Room_NO, \n"
                . "	HOI_ExtraNum, \n"
                . "	HOI_RoomTypeName, \n"
                . "	HOI_BreakNum, \n"
                . "	HOI_PriceType, \n"
                . "	HOI_BreakType, \n"
                . "	HOI_RoomRates, \n"
                . "	HOI_ExtrabedRates, \n"
                . "	HOI_TaxFee \n"
                . ") \n"
                . "VALUES \n"
                . "( \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	?, \n"
                . "	? \n"
                . ")";
        $HT1 = $this->load->database('HT', true);
        $query = $HT1->query($sql, array(
            $this->HOI_COLD_SN,
            $this->HOI_NoSmoking,
            $this->HOI_EarlyTime,
            $this->HOI_LastTime,
            $this->HOI_Room_NO,
            $this->HOI_ExtraNum,
            $this->HOI_RoomTypeName,
            $this->HOI_BreakNum,
            $this->HOI_PriceType,
            $this->HOI_BreakType,
            $this->HOI_RoomRates,
            $this->HOI_ExtrabedRates,
            $this->HOI_TaxFee
        ));
    }

    /**
     *
     * 返回成行订单
     * 条件1：订单类型
     * 天剑2：网站来源
     *
     */
    public function get_order_info($COLI_sourcetype, $COLI_WebCode, $biz = true) {
        if ($biz) {
            $sql = "SELECT TOP 200 c.COLI_WebCode, \n"
                    . "       c.COLI_ID, \n"
                    . "       c.COLI_ConfirmDate, \n"
                    . "       c.COLI_ApplyDate, \n"
                    . "       ISNULL(c.COLI_IsSuccess, 0) AS success \n"
                    . "FROM   BIZ_ConfirmLineInfo c \n"
                    . "WHERE  c.COLI_sourcetype = ? \n"
                    . "       AND c.COLI_WebCode = ? \n"
                    . "ORDER BY \n"
                    . "       c.COLI_SN DESC";
            $query = $this->HT->query($sql, array($COLI_sourcetype, $COLI_WebCode));
        } else {
            $sql = "SELECT TOP 200 c.COLI_WebCode, \n"
                    . "       c.COLI_ID, \n"
                    . "       c.COLI_ConfirmDate, \n"
                    . "       c.COLI_ApplyDate, \n"
                    . "       CASE WHEN c.COLI_Sended = 5 THEN 1 ELSE 0 END AS success \n"
                    . "FROM   ConfirmLineInfo c \n"
                    . "WHERE  c.COLI_sourcetype = ? \n"
                    . "       AND c.COLI_WebCode = ? \n"
                    . "ORDER BY \n"
                    . "       c.COLI_SN DESC";
            $query = $this->HT->query($sql, array($COLI_sourcetype, $COLI_WebCode));
        }
        $this->sql = $this->HT->queries;
        return $query->result();
    }

    //传统订单支付之后，插入新的订单信息
    public function insert_daytrip_order($coli_sn, $pay_manner, $gri_sn, $state, $deleteflag) {
        //获取订单
        $order_info_sql = "
                SELECT confirmlineinfotmp.COLI_OrderPrice,
                       memberinfotmp.MEI_FirstName,
                       memberinfotmp.MEI_LastName,
                       memberinfotmp.MEI_Mail
                FROM   memberinfotmp
                       INNER JOIN customerlisttmp
                               ON memberinfotmp.mei_sn = customerlisttmp.cul_cui_sn
                       INNER JOIN confirmlineinfotmp
                               ON customerlisttmp.cul_coli_sn = confirmlineinfotmp.coli_sn
                WHERE  (customerlisttmp.cul_coli_sn = ? )";
        $query = $this->HT->query($order_info_sql, array($coli_sn));
        $order_info = $query->row();

        //插入记录
        $sql = "INSERT INTO GroupAccountInfoTmp
                (
                  GAI_COLI_SN,
                  GAI_SQJE,
                  GAI_SQDate,
                  GAI_CusName,
                  GAI_CusEmail,
                  GAI_SQJECurrency,
                  GAI_Type,
                  LastEditTime,
                  GAI_GRI_SN,
                  GAI_State,
                  DeleteFlag
                )
                VALUES (?,?,?,?,?,?,?,?,?,?,?)";

        $query = $this->HT->query($sql, array($coli_sn,
            $order_info->COLI_OrderPrice,
            date('Y-m-d H:i:s'),
            $order_info->MEI_FirstName . " " . $order_info->MEI_LastName,
            $order_info->MEI_Mail,
            $this->config->item('Site_Currency'),
            $pay_manner,
            date('Y-m-d H:i:s'),
            $gri_sn,
            $state,
            $deleteflag
                )
        );
    }

    //来源终端 tablet mobile desktop
    public function check_device() {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $ua = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $ua = '';
        }
        ## This credit must stay intact (Unless you have a deal with @lukasmig or frimerlukas@gmail.com
        ## Made by Lukas Frimer Tholander from Made In Osted Webdesign.
        ## Price will be $2
        $iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
        $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
        $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)

        if (!function_exists('androidTablet')) {

            function androidTablet($ua) { //Find out if it is a tablet
                if (strstr(strtolower($ua), 'android')) { //Search for android in user-agent
                    if (!strstr(strtolower($ua), 'mobile')) { //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
                        return true;
                    }
                }
            }

        }
        $androidTablet = androidTablet($ua); //Do androidTablet function
        $ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent

        if ($androidTablet || $ipad) { //If it's a tablet (iPad / Android)
            return 'tablet';
        } elseif ($iphone && !$ipad || $android && !$androidTablet || $windowsPhone) { //If it's a phone and NOT a tablet
            return 'mobile';
        } else { //If it's not a mobile device
            return 'desktop';
        }
    }

	//获取线路经过的城市
	public function get_country($coli_sn){
		$sql = "SELECT
					distinct
						(SELECT
						(SELECT
							COI2_Country
						FROM
							COuntryInfo2
						WHERE
							COI2_COI_SN= PRI_Country
						AND COI2_LGC=1)
					FROM
						PRovinceInfo
					WHERE
						PRI_SN=CII_PRI_SN)
					AS
						CountryName
					FROM
						CItyInfo
					WHERE
						isnull(CII_IsTrue,1)=1
					AND
						CII_SN
					in
					(SELECT
						CLD_ServiceCity FROM CustomerLineDetail
					WHERE
						CLD_ServiceType='X'
					AND
						CLD_ServiceCity
					not in
						(183,184,244,1502)
					AND
						CLD_CLI_SN = ?)";
		$query = $this->HT->query($sql,$coli_sn);
		$query = $query->result();
        return 	$query;
	}

	//获取线路信息标题
	public function get_title($url){
		$sql = 'select ic_title from infoContents where ic_url = ?';
		$query = $this->HT->query($sql,$url);
		$query = $query->row();
        return 	$query;
	}

    public function ip_limit($ip = "0.0.0.0")
    {
        if (strcmp($ip, "0.0.0.0") === 0 || empty($ip)) {
            return TRUE;
        }
        $countByMinute = 0;
        $countByDay = 0;
        $sql = "SELECT TOP 1 COUNT(1) cnt
                FROM ConfirmLineInfoTmp
                WHERE COLI_SenderIP = ?
                  AND DATEDIFF(MI,COLI_ApplyDate,GETDATE()) < 60
                  GROUP BY CONVERT(VARCHAR(18), CONVERT(smalldatetime,COLI_ApplyDate))
                  ORDER BY cnt DESC";
        $query = $this->HT->query($sql, array($ip));
        $result = $query->row();
        if (!empty($result)) {
			$countByMinute = $result->cnt;
		}

        $sql = "SELECT COUNT(1) cnt
                FROM ConfirmLineInfoTmp
                WHERE COLI_SenderIP = ?
                AND DateDiff(dd,COLI_ApplyDate,getdate())=0";
        $query = $this->HT->query($sql, array($ip));
        $result = $query->row();
        if (!empty($result)) {
			$countByDay = $result->cnt;
		}

        /* 每分钟 5 个, 每天 15 个 */
        if ($countByMinute >= 5 || $countByDay >= 10) {
            return false;
        } else {
            return true;
        }
    }


}
