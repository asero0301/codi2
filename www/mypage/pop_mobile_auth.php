<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/pop_mobile_auth.php
 * date   : 2008.10.09
 * desc   : 휴대폰 인증번호 처리하는 팝업창
 *******************************************************/
require_once "../inc/common.inc.php";

NoCache();

$mainconn->open();

$chk_id = "coditop10";
$pmode	= $_POST["pmode"];
$mobile_certify_num	= $_POST["mobile_certify_num"];
$pno_1	= $_POST["pno_1"];
$pno_2	= $_POST["pno_2"];
$pno_3	= $_POST["pno_3"];

$chk_num = $pno_1."-".$pno_2."-".$pno_3;
//echo $chk_num;
if ( $pmode == "proc" ) {

	$sql = "select certify_no from tblCertifyMobile where mobile_no = '$chk_num' order by idx desc limit 1 ";
	$certify_no = $mainconn->count($sql);

	if ( $certify_no != $mobile_certify_num ) {
		echo "<script>alert('휴대폰 인증번호가 일치하지 않습니다.');</script>";
	} else {
		echo "<script>opener.document.mem.action='/member/shop_edit_ok.php'; opener.document.mem.encoding='multipart/form-data'; opener.document.mem.target='_self'; opener.document.mem.submit(); self.close();</script>";
		exit;
	}
} else if ( $pmode == "mobile" ) {

	if($pno_1 == "" || $pno_2 == "" || $pno_3 == "") {
		exit;

	} else {
		
		$ran_num	= rand(0,10);
		$Krnd		= (int)((999 - 100 + 1) * $ran_num + 100);
		$serial		= substr($pno_3,3,1) . substr($Krnd,0,1) . substr($pno_3,0,1) . substr($Krnd,1,1) . substr($pno_3,2,1) . substr($Krnd,1,1) . substr($pno_3,1,1);
		
		$sql = "INSERT INTO tblCertifyMobile (mobile_no,certify_no,status,ip,reg_dt) values ('$chk_num','$serial','A','".$_SERVER['REMOTE_ADDR']."',now()) ";
		$mainconn->query($sql);

		$keyMsg = urlencode("인증번호:$serial http://".$_SERVER['HTTP_HOST']);

		//인증번호 sms발송하기
		$keyChk = md5($chk_id."*^^*".$chk_num);
		$smsurl = "http://www2.superboard.com/admin/asp/sendSMS/assa_sendSMS.asp?sid=".$chk_id."&rhp=".$chk_num."&smsMsg=".$keyMsg."&keyChk=".$keyChk;
	
		$ret_chk = QueryHTTP($smsurl);
		
		if( ereg("[FAIL]", $ret_chk) ) {
			CloseMsg("통신장애이거나 인증번호가 올바르지 않습니다\\n\\n잠시후 다시 시도해주세요.");
		} else {
			echo "<script language='javascript'>alert('\\n입력하신 연락처로 인증번호를 전송하였습니다.\\n\\n인증번호를 받으시면 아래의 인증번호란에 기입해주세요.\\n\\n사용자가 많으면 다소 지연될 수 있습니다.'); </script>";
		}
	
	}
}

$mainconn->close();
?>
<script language="javascript">
function goMobileSubmit() {
	var f = document.frm;
	f.pmode.value = "proc";
	f.submit();
}
</script>

<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="300" border="0" cellspacing="0" cellpadding="0">
<form id="frm" name="frm" method="post">
<input type="hidden" id="pmode" name="pmode" value="proc" />
<input type="hidden" id="pno_1" name="pno_1" value="<?=$pno_1?>" />
<input type="hidden" id="pno_2" name="pno_2" value="<?=$pno_2?>" />
<input type="hidden" id="pno_3" name="pno_3" value="<?=$pno_3?>" />

  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>휴대폰 인증번호 입력</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif">

                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        
                        <td align="center"><input type="text" name="mobile_certify_num" id="mobile_certify_num" class="logbox"  style="width:150" maxlength="10" />
                          <img src="/img/btn_phone_ok.gif" width="90" height="17" border="0" onClick="goMobileSubmit();" style="cursor:hand;" align="absmiddle" />
						</td>
                      </tr>
                  </table>

	</td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</form>
</table>

<script>
document.frm.mobile_certify_num.focus();
</script>