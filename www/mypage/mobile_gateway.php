<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/shop_join.php
 * date   : 2008.10.07
 * desc   : shop join
 *******************************************************/
//session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

$mem_name = trim($_REQUEST['mem_name']);
$mem_jumin = trim($_REQUEST['mem_jumin']);
$mem_key = trim($_REQUEST['mem_key']);

$this_mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);

if ( $this_mem_key != $mem_key ) {
	echo "<script>alert('실명인증 비정상적인 접근입니다.'); location.href='/main.php';</script>";
	exit;
}

require_once "../include/_head.php";


?>
<script type="text/JavaScript">
<!--
function MNsend() {
	var f = document.frm;

	if ( f.pno_2.value == "" || !isNumber(f.pno_2) ) {
		alert("휴대전화 번호가 입력되지 않았거나 올바르지 않습니다.");
		f.pno_2.value = "";
		f.pno_2.focus();
		return;
	}

	if ( f.pno_3.value == "" || !isNumber(f.pno_3) ) {
		alert("휴대전화 번호가 입력되지 않았거나 올바르지 않습니다.");
		f.pno_3.value = "";
		f.pno_3.focus();
		return;
	}

	f.action = "sendPno.php";
	f.method = "post";
	f.target = "_Cmt_Act";
	f.submit();
}

function goSubmit() {
	var f = document.frm;
	
	if ( f.mobile_certify_num.value == "" ) {
		alert("휴대폰 인증번호를 입력하세요");
		f.mobile_certify_num.value = "";
		f.mobile_certify_num.focus();
		return;
	}

	f.action = "shop_join.php";
	f.target = "_self";
	f.submit();
}

//-->
</script>

<iframe name="_Cmt_Act" width="0" height="0"></iframe>

<form name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="mem_name" name="mem_name" value="<?=$mem_name?>" />
<input type="hidden" id="mem_jumin" name="mem_jumin" value="<?=$mem_jumin?>" />
<input type="hidden" id="mem_key" name="mem_key" value="<?=$mem_key?>" />

  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember04.gif" width="180" height="18" /></td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
	  <table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 휴 대 폰 </td>
                      <td>
						<select name="pno_1" id="pno_1" class="logbox"  style="width:50">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="018">018</option>
							<option value="019">019</option>
                        </select>
                        -
                        <input type="text" name="pno_2" id="pno_2" class="logbox" maxlength="4" style="width:60" />
                        -
                        <input type="text" name="pno_3" id="pno_3" class="logbox" maxlength="4" style="width:60" />
                        <!--<span id='mobile_chk'>--><img src="/img/btn_phone.gif" border="0" onClick="MNsend();" style="cursor:hand;" align="absmiddle" /><!--</span>--></td>
                    </tr>
                  </table>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="1" background="/img/dot00.gif"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 휴대폰 인증 </td>
                        <td><input type="text" name="mobile_certify_num" id="mobile_certify_num" class="logbox"  style="width:150" maxlength="10" />
                          <img src="/img/btn_phone_ok.gif" width="90" height="17" border="0" onClick="goSubmit();" style="cursor:hand;" align="absmiddle" /></td>
                      </tr>
                      <tr>
                        <td width="110" height="24" class="intitle">&nbsp;</td>
                        <td>＊ 휴대폰으로 받은 인증번호를 입력하신 후에 인증번호확인을 클릭해주세요. </td>
                      </tr>
                  </table>
				  
				  </td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>



  
  </form>

  <? include "../include/_foot.php"; ?>
