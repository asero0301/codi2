<?
define('MYSQL_LOG_DIR',   "/log");         // MYSQL�α� ���丮

require_once "const.inc.php";
require_once "public.inc.php";
require_once "CMySQL.inc.php";
//require_once "CSitePool.inc.php";


$html_title = "����T - ��Ű���� 12�� ���� 1��, ��ü�� �о� ������ 52%, ��ü���� ����T";
$IsTestIIS = 0;

if($ServerName == "test.supert.co.kr")
{
	$IisDomain = getenv("HTTP_HOST");
	$TestServer = 1;
}
else
{
	$IisDomain = getenv("HTTP_HOST");
	$TestServer = 0;
}

//If (ereg("test.assalabia.com", $HTTP_SERVER_VARS[HTTP_HOST])) { 
//    $IsTestIIS = 1 ;
//	$IisDomain = "test.assalabia.com" ;
//} 
//Else
//	$IisDomain = "www.assalabia.com" ;


// ����Ű���� �����ϸ�...
/*
if(strlen($_GET["sslkey"]) > 0)
{
	$authkey = md5("(@.@)".$_GET[sslkey]."(@.@)");
	
	$sret = QueryHTTPArgs("http://sgate.superboard.com/login_ok.php?sslkey=$_GET[sslkey]&authkey=$authkey");

	foreach ($sret as $key => $value)
	{
		if(strncmp($key, "G_", 2) == 0)
		{
			$key = substr($key, 2, strlen($key)-2);
			$_GET[$key]     = $value;
			$_REQUEST[$key] = $value;
		}
		else if(strncmp($key, "P_", 2) == 0)
		{
			$key = substr($key, 2, strlen($key)-2);
			$_POST[$key]    = $value;
			$_REQUEST[$key] = $value;
		}
	}
}
*/

$cpu_start = microtime();

define('MEMBER_OK',                1);         // ����ȸ��
define('MEMBER_BAD',               2);         // �ҷ�ȸ��
define('MEMBER_NO',                3);         // �������� �ʴ� ȸ��
define('MEMBER_OUT',               4);         // Ż���� ȸ��

define('T_POINT',                  1);
define('T_CASH',                   2);
define('T_TICKET',                 4);


define('MEMBER_MOBILE_AUTH',       0);
define('MEMBER_IMAGETEXT_AUTH',    1);


//$MAIN_DB      = "coditop";
$MAIN_DB      = "roothope";

if($TestServer)
{
	$mainconn = new CMySQL();
	$mainconn->set("localhost", "coditop", "@coditop~!", "coditop");

	$SuperBoard = "testcgi.superboard.com:8000";
}
else
{
	$mainconn = new CMySQL();
	$mainconn->set("localhost", "coditop", "@coditop~!", "coditop");

	$SuperBoard = "www2.superboard.com";
	$ImageServer = "http://image.assalabia.com";
}


//�α����� ��Ű�� (�ӽ��ּ� ó��)
// require_once "main_login.inc.php";


function exit_free()
{
	global $mainconn;

	// ��������
	$mainconn->close();
}


// ���α׷� ����ÿ� ������ �Լ� ���
register_shutdown_function(exit_free);




function UseCash($id, $cash, $code, $content)
{
	global $mainconn;

	if($cash == 0)
		return;

	$mainconn->open();

	$mainconn->query("UPDATE member_info SET cash=cash+($cash) WHERE id='$id'");
	$mainconn->query("INSERT INTO cash_bank SET id='$id', sdate='".date("Y-m-d")."', ymonth='".date("Y-m")."', code='$code', amount=$cash, stime=".time(0).", content='$content'");
}




function UsePoint($id, $point, $code, $content)
{
	global $mainconn;

	if($point == 0)
		return;

	$mainconn->open();

	$mainconn->query("UPDATE member_info SET point=point+($point) WHERE id='$id'");
	$mainconn->query("INSERT INTO point_bank SET id='$id', sdate='".date("Y-m-d")."', ymonth='".date("Y-m")."', code='$code', amount=$point, stime=".time(0).", content='$content'");
}


function UsePointSum($id, $point, $code, $content)
{
	global $mainconn, $Date, $Time;

	if($point == 0)
		return;

	$mainconn->query("UPDATE member_info SET point=point+($point) WHERE id='$id'");

	$mainconn->query("UPDATE point_bank SET amount=amount+($point), content=CONCAT('".$content." (', FROM_UNIXTIME(stime, '%H:%i:%s'), ' ~ ', FROM_UNIXTIME($Time, '%H:%i:%s'), ')') WHERE id='$id' AND sdate='$Date' AND code='$code'");

	if($mainconn->affectedRows() < 1)
	{
		$mainconn->query("INSERT INTO point_bank SET id='$id', sdate='$Date', code='$code', amount=$point, stime='$Time', content='$content'");
	}
}



function GetMyInfo()
{
	global $mainconn, $dbconn, $mem;

	$mainconn->open();

	$mres = $mainconn->query("SELECT point, cash, admin FROM member_info WHERE id='$mem[id]'");
	if(!($mrow = $mainconn->fetch($mres)))
	{
		$mem["chk_gid"]	= MEMBER_OK ;
		return;
	}
	else
		$mem["chk_gid"]	= MEMBER_NO ;

	$mem["point"]  = $mrow["point"];
	$mem["cash"]   = $mrow["cash"];
	$mem["admin"]  = $mrow["admin"];

	$mainconn->freeResult($mres);
}



function MemID($id, $myicon = 0, $type="p_room", $admin=null)
{
	global $mem;

	if($mem["admin"] > 0)
	{
		echo "<a href='#' onClick=\"window.open('/member/info.php?id=$id', '_info', 'width=310, height=400');return false;\"><img src='/img/member.gif' width='14' height='11' hspace=1 border=0 align='absMiddle'></a>";
	}
	
	echo "<a href=\"#\" onClick=\"return memberID('$id')\">";

	if($admin > 0)
	{
		$myicon = 1;
	}

	if($myicon > 0)
	{
		echo "<img src='/img/supert.gif' width='64' height='13' border=0 align='absMiddle'>";

//		$hash = str2hash($id, 89);

		if($hash > 0)
		{
//			printf("<img src='http://image.superboard.com/myicon/%02d/%s.gif' border=0 align='absMiddle'>", 	$hash, $id);
		}
		else
		{
//			printf("<img src='http://image.superboard.com/myicon/myicon.cgi?id=%s' border=0 align='absMiddle'>", $id);
		}
	}
	else
		echo "<font class='mem_id'>$id</font>";

	echo "</a>";
}


function MemLevelIcon($level, $hspace=2)
{
	if($level < 0)
		return;
	
	//echo "<img src='/img/level/$level.gif' width='15' height='15' border=0 align='absmiddle' hspace='$hspace'>";
//	echo "<a href=\"#\" onFocus=\"this.blur()\" onClick=\"window.open('/dograce/level.php?level=$level', '_level_', 'width=330, height=565, status=yes');return false\"><img src='/img/level/$level.gif' width='15' height='15' border=0 align='absmiddle' hspace='$hspace'></a>";
}



function AgeCheck($age, $jumin = null)
{
	if($jumin == null)
	{
		global $mem;
		$jumin = $mem["jumin"];
	}

	$year  = substr($jumin, 0, 2) + 1900;
	$month = substr($jumin, 2, 2);
	$day   = substr($jumin, 4, 2);

	if(substr($jumin, 6, 1) > 2)
		$year += 100;

	if(GetAge($year."-".$month."-".$day) >= $age)
		return 1;

	return 0;
}



function AdultCheck()
{
	return AgeCheck(19);
}



function getMoney($id=null, $flag=T_CASH)
{
	global $mainconn, $mem;

	if($id == null)
		$id = $mem["id"];

	$field = '';

//	if($flag & T_POINT)
//	{
//		$field
//	}

	$mainconn->open();
	return $mainconn->count("SELECT cash FROM member_info WHERE id = '". $id ."'");
}


function MaskIP($ip)
{
	global $mem;
	
	if($mem["admin"] > 8)
		return $ip;

	$ip = explode(".", $ip);
	$ip[2] = "xxx";

	return join(".", $ip);
}


function SendMobile($from_no, $id, $to_no, $msg)
{
	//������ȣ sms�߼��ϱ�
	$keyChk = md5($id."*^^*".$to_no);
	$smsurl = "http://www2.superboard.com/admin/asp/sendSMS/assa_sendSMS.asp?shp=".urlencode($from_no)."&sid=".$id."&rhp=".$to_no."&smsMsg=".urlencode($msg)."&keyChk=".$keyChk;

	$ret_chk = QueryHTTP($smsurl);

	if(ereg("[FAIL]", $ret_chk))
		return false;
	else
		return true;
}

/*
$mem["name"]   = str64decode($mem["name"]);
$mem["email"]  = str64decode($mem["email"]);
$mem["mobile"] = str64decode($mem["mobile"]);
$mem["jumin"]  = str64decode($mem["jumin"]);
*/
/*
$mainconn->open();
$inc_sql = "select * from tblCashConfig ";
$inc_res = $mainconn->query($inc_sql);
$CASHCODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_cc_cid = trim($inc_row['cc_cid']);
	$inc_cc_cval = trim($inc_row['cc_cval']);
	$inc_etc_conf = trim($inc_row['etc_conf']);
	$inc_cash = trim($inc_row['cash']);

	$CASHCODE[$inc_cc_cid] = $inc_cash;
}
$mainconn->close();
*/
?>
