<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/inc/const.inc.php
 * date   : 2008.08.07
 * desc   : Const
 *******************************************************/

// coditop public CONST define

$WEB_URL = "http://roothope.cafe24.com/";
$WEB_3RDBRAIN_URL = "http://www.3rdbrain.com/";

$COMPANY_TEL_NUM = "02-2234-1777";


$ADMIN_ID = "admin";

$ADMIN_DIR = "/manage/";
$ADMIN_AUTH = $ADMIN_DIR."index.php";
$ADMIN_MAIN_URL = $ADMIN_DIR."product/wait_list.php";
$ADMIN_TITLE = "Coditop10 Administrator";

// board process CONST define
$ADMIN_PAGE_SIZE = 20;
$ADMIN_PAGE_BLOCK = 10;
$REPLY_INDENT = 5;
$PAGE_SIZE = 10;
$PAGE_BLOCK = 10;

$COMMENT_PAGE_SIZE = 10;
$COMMENT_PAGE_BLOCK = 10;


// �ִ� ����ϰ���
$SHOP_MAX_COUNT = 10;

// main codi page
$MAIN_CODI_PAGE_SIZE = 15;

// ���� �������� �ѵ� (100��)
$MSG_FOREVER_LIMIT = 100;

// ���� ��ȿ�Ⱓ timestamp (30��)
$MSG_USAGE_DAY = 30;

// �򰡴������ �ڵ� page size
$PRODUCT_CODI_PAGE_SIZE = 15;

// ���� TODAY ��õ �ڵ�
$MAIN_TODAY_RECOM_PAGE_SIZE = 8;

// SUB ������ ��õ�ڵ� �� �������� ����
$SUB_TODAY_RECOM_PAGE_SIZE = 5;

// ���������� "new" ������ ǥ�� �Ⱓ(timestamp)
$NOTICE_NEW_STAMP = 7 * 86400;

// �Ż�ǰ �Ⱓ(timestamp)
$CODI_NEW_STAMP = 7 * 86400;

// UCC�� "new" ������ ǥ�� �Ⱓ(timestamp)
$UCC_NEW_STAMP = 1 * 86400;

// SHOP PR �� "new" ������ ǥ�� �Ⱓ(timestamp)
$PR_NEW_STAMP = 1 * 86400;

// �ҷ����� "new" ������ ǥ�� �Ⱓ(timestamp)
$BAD_NEW_STAMP = 1 * 86400;


// file upload
$UP_DIR = "upload";
$UP_URL = "/upload";

// tpl
$TPL_DIR = "tpl";
$TPL_URL = "/tpl";

// default gift
$DEFAULT_GIFT_STR = "��� �ڵ��ǰ ��ü";

// banner array
$BANNER_AREA = array (
	"MAINT", "MAINB", "MAINL", "MAINR", 
	"CODIT", "CODIB", "CODIL", "CODIR", 
	"BOARDT", "BOARDB", "BOARDL", "BOARDR",
	"JOINT", "JOINB", "JOINL", "JOINR",
	"ETCT", "ETCB", "ETCL", "ETCR"
);

// product categ
$P_CATEG = array (
	"T" => "����",
	"B" => "����",
	"O" => "�߿ܺ�",
	"U" => "�������",
	"A" => "ACC"
);

// ucc categ
$UCC_CATEG = array (
	"A" => array ("�ڵ���","���ڵ� �����ּ���"),
	"B" => array ("�ڵ��Ƿ�","� �ڵ� �������?"),
	"C" => array ("�ڵ�����","�ڵ� ���ȵ����")
);

// faq categ
$FAQ = array (
	"FAQ_A" => "�α���/ȸ�����",
	"FAQ_B" => "�����",
	"FAQ_Z" => "��Ÿ"
);

// qna categ
$QNA = array (
	"QNA_A" => "�α���/ȸ�����",
	"QNA_B" => "�����",
	"QNA_Z" => "��Ÿ"
);

// tracking code
$TRACKCODE = array (
	"A" => "<b><font color='#CC3300'>Ȯ��</font></b>",
	"B" => "<b><font color='#CC33CC'>�߼۴��</font></b>",
	"C" => "<b><font color='#CC33DD'>�߼ۿϷ�</font></b>",
	"D" => "<b><font color='#CC33EE'>����Ȯ����</font></b>",
	"E" => "<b><font color='#DD2457'>�Ϸ�</font></b>"
);

// coditop title
$TITLE = "���ϰ� ��ǰ�޴� CODI TOP10 - �ڵ�ž��";

$CASH_SUPPLY_MSG = "RECV_MEM_ID(RECV_MEM_NAME)���� CPC ĳ�� ����ѵ��� �ʰ��Ͽ����ϴ�.<br>ĳ�������� �Ͻñ� �ٶ��ϴ�";


$CODI_CMT = array (
	"�α����� �ϼž� �������� �����մϴ�.",
	"�򰡿� �̹� �����ϼ̽��ϴ�. �ϳ��� �ڵ��ǰ�� 1ȸ�� �������� �����մϴ�.",
	"����򰡸� �Է��� ��, ������ UP �Ǵ� DOWN �� Ŭ���ϸ� ����� �Ϸ�˴ϴ�.",
	"�ش� �ڵ��� �򰡱Ⱓ�� �Ϸ�Ǿ����ϴ�."
);


// ĳ�� ������ �ڵ庰 �ݾ�/ĳ��/���ʽ�ĳ��
$CASHMONEY = array (
	"M101" => array (5000, 5000, 0),
	"M102" => array (10000, 10000, 500),
	"M103" => array (30000, 30000, 1000),
	"M104" => array (50000, 50000, 3000),
	"M105" => array (100000, 100000, 5000)
);

// ������ �Ա� ����
$BANKINFO = array("�ڵ�ž��", "��������", "346-25-0012-766");
?>
