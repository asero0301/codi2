<?
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

$mem_kind = trim($_REQUEST['mem_kind']);

if ( $mem_kind == "" ) $mem_kind = "U";

join_chk();
?>

<? require_once "../include/_head.php"; ?>

<script type="text/JavaScript">
<!--
function yuni_jumin() {
	value = document.frm.jumin1.value;
	if (value.length >= 6)
	{
		document.frm.jumin2.focus();
		return;
	}
}

function chk_submit() {
	var f = document.frm;
	if ( f.name.value == "" ) {
		alert("이름을 입력하세요");
		f.name.focus();
		return;
	}
	if ( f.jumin1.value == "" ) {
		alert("주민등록번호 압부분을 입력하세요");
		f.jumin1.focus();
		return;
	}
	if ( f.jumin2.value == "" ) {
		alert("주민등록번호 뒷부분을 입력하세요");
		f.jumin2.focus();
		return;
	}
	if ( !SSN_Check(f.jumin1,f.jumin2) ) {
		alert("주민등록번호가 잘못되었습니다");
		f.jumin1.value=""; f.jumin2.value="";
		f.jumin1.focus();
		return;
	}
	f.action = "/member/real_name_request.php";
	f.submit();
}
//-->
</script>

<form id="frm" name="frm" method="post">
<input type="hidden" id="mem_kind" name="mem_kind" value="<?=$mem_kind?>" />

  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <!--
	<tr>
      <td height="22" valign="top"><img src="/img/smember03.gif" width="180" height="18" /></td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
	-->
    <tr>
      <td>
	  <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:10 10 10 10" class="intext">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="24" colspan="2" class="intitle"  style="padding-bottom:3"><b><font color="FF0078">[ 실명확인 ]</font></b> </td>
                        </tr>
                     
                      <tr>
                        <td width="120" height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> 이 름 </td>
                        <td><input type="text" id="name" name="name" class="logbox"  style="width:100" tabindex="7" /></td>
                      </tr>
                      <tr>
                        <td height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> 주민등록번호</td>
                        <td><input type="text" name="jumin1" id="jumin1" class="logbox"  style="width:100" tabindex="8" maxlength="6" onKeyUp="yuni_jumin();" />
                          -
                            <input type="password" name="jumin2" id="jumin2" maxlength="7" class="logbox"  style="width:100" tabindex="9" onKeyPress="if (event.keyCode==13) chk_submit();" />
                            <a href="#" onClick="chk_submit();"><img src="/img/btn_name_ok.gif" border="0"  align="absmiddle" tabindex="10" /></a></td>
                      </tr>
                    </table>
					</td>
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

  <? require_once "../include/_foot.php"; ?>
