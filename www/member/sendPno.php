<?
//########################################################################
//##	 ���ϸ� : sendPno.php											##
//##	 �ۼ��� : Ȳ��												##
//##	 ��  ¥ : 2008.10.07											##
//##	 ��  �� : �ڵ��� ������ȣ �߼�									##
//########################################################################

require_once "../inc/common.inc.php";

NoCache();

$pno_1	= $_REQUEST["pno_1"];
$pno_2	= $_REQUEST["pno_2"];
$pno_3	= $_REQUEST["pno_3"];

$chk_id = "coditop10";

/*
if ( $pno_1 == "" ) $pno_1 = "019";
if ( $pno_2 == "" ) $pno_2 = "612";
if ( $pno_3 == "" ) $pno_3 = "2632";
*/

$chk_num = $pno_1."-".$pno_2."-".$pno_3;

$mainconn->open();

if($pno_1 == "" || $pno_2 == "" || $pno_3 == "") {
	exit;

} else {
	
	$ran_num	= rand(0,10);
	$Krnd		= (int)((999 - 100 + 1) * $ran_num + 100);
	$serial		= substr($pno_3,3,1) . substr($Krnd,0,1) . substr($pno_3,0,1) . substr($Krnd,1,1) . substr($pno_3,2,1) . substr($Krnd,1,1) . substr($pno_3,1,1);
	
	$sql = "INSERT INTO tblCertifyMobile (mobile_no,certify_no,status,ip,reg_dt) values ('$chk_num','$serial','A','".$_SERVER['REMOTE_ADDR']."',now()) ";
	$mainconn->query($sql);

	$keyMsg = urlencode("������ȣ:$serial http://".$_SERVER['HTTP_HOST']);
	//$keyMsg = urlencode("$serial");

	//������ȣ sms�߼��ϱ�
	$keyChk = md5($chk_id."*^^*".$chk_num);
	$smsurl = "http://www2.superboard.com/admin/asp/sendSMS/assa_sendSMS.asp?sid=".$chk_id."&rhp=".$chk_num."&smsMsg=".$keyMsg."&keyChk=".$keyChk;

	//echo "smsurl : [".$smsurl."]<br>";

	$ret_chk = QueryHTTP($smsurl);
	//echo "<script>alert('success');</script>";

	//echo "<script>alert('chk_num:[".$chk_num."]\\nchk_id:[".$chk_id."]\\nkeyMsg:[".$keyMsg."]\\nkeyChk:[".$keyChk."]');</script>";
	
	if( ereg("[FAIL]", $ret_chk) ) {
		CloseMsg("�������̰ų� ������ȣ�� �ùٸ��� �ʽ��ϴ�\\n\\n����� �ٽ� �õ����ּ���.");
		exit;
	} else {
		//echo "<script language='javascript'>parent.showMobileChk();alert('\\n�Է��Ͻ� ����ó�� ������ȣ�� �����Ͽ����ϴ�.\\n\\n������ȣ�� �����ø� �Ʒ��� ������ȣ���� �������ּ���.\\n\\n����ڰ� ������ �ټ� ������ �� �ֽ��ϴ�.'); </script>";
		echo "<script language='javascript'>alert('\\n�Է��Ͻ� ����ó�� ������ȣ�� �����Ͽ����ϴ�.\\n\\n������ȣ�� �����ø� �Ʒ��� ������ȣ���� �������ּ���.\\n\\n����ڰ� ������ �ټ� ������ �� �ֽ��ϴ�.'); parent.document.frm.mobile_certify_num.focus();</script>";
		exit;
	}
}

$mainconn->close();
?>
