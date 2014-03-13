<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/pop_zip_check.php
 * date   : 2008.10.06
 * desc   : popup zip check
 *******************************************************/

 $mem_kind = trim($_REQUEST['mem_kind']);
 $ob = trim($_REQUEST['ob']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>평가하고 경품받는 CODI TOP10 - 코디탑텐</title>
<link rel = StyleSheet HREF='/css/style.css' type='text/css' title='thehigh CSS'>

<script language="JavaScript">
function goZip() {
	var f = document.frm;
	if ( f.addr.value == "" || f.addr.value == null ) {
		alert("동/읍/면, 기관, 학교 등의 이름을 입력하세요.");
		f.addr.focus();
		return;
	}
	f.submit();
}
</script>
</head>

<body onload="document.frm.addr.focus();">

<table width="300" border="0" cellspacing="0" cellpadding="0">
<form id="frm" name="frm" method="post" action="pop_zip_check_ok.php">
<input type="hidden" id="mem_kind" name="mem_kind" value="<?=$mem_kind?>" />
<input type="hidden" id="ob" name="ob" value="<?=$ob?>" />

  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>우편번호 검색</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif">
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>동/읍/면, 기관, 학교 등의 이름을 입력하세요.</td>
      </tr>
	  <tr>
        <td height="6" colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" id="addr" name="addr" value="" class="logbox"  style="width:170" />
          <a href="#" onClick="goZip();"><img src="/img/btn_search.gif" border="0" align="absmiddle" /></a>
		</td>
      </tr>
	  
	   <tr>
	     <td colspan="2" height="45">&nbsp;</td>
        </tr>

      <tr>
        <td colspan="2" align="center"><a href="javascript:self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</form>
</table>

</body>
</html>