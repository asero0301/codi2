<?php
require_once "../inc/common.inc.php";
$admin_save_id = $_COOKIE['admin_idsave'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>Admin System</title>
<link rel = StyleSheet HREF='./style_ad.css' type='text/css' title='thehigh CSS'>
<script language="JavaScript" src="ad.js"></script>
<script language="javascript">
function goSubmit() {
	var f = document.frm;
	if ( f.admin_id.value == "" ) {
		alert("아이디를 입력하세요");
		f.admin_id.focus();
		return;
	}

	if ( f.admin_pwd.value == "" ) {
		alert("비밀번호을 입력하세요");
		f.admin_pwd.focus();
		return;
	}

	f.submit();
}
</script>
</head>

<body>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="1" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="200" align="center" bgcolor="#EAECEE"><table width="480" height="50" border="0" align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td align="left" valign="bottom"><img src="img/as_logo.gif" width="213" height="40"></td>
            </tr>
          </table>


		  <form name="frm" id="frm" method="POST" action="<?=$ADMIN_DIR."auth_ok.php"?>">

            <table width="480" border="0" align="center" cellpadding="15" cellspacing="5" bgcolor="434D56">
              <tr>
                <td align="center" bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="70">
						<!--<input name="checkbox" type="checkbox" value="checkbox" checked>-->
						<input type="checkbox" name="admin_idsave" value="Y" >

                          <span class="idlogin">ID저장</span> </td>
                      <td width="135">
						  <input name="admin_id" type="text" value="<?=$admin_save_id?>" class="logboxcss" style=" BACKGROUND-IMAGE: url(img/id.gif); BACKGROUND-REPEAT: no-repeat;" onFocus="this.style.backgroundImage = 'url(none)'" tabindex="1">
                      </td>
                      <td width="135">
						  <input name="admin_pwd" type="password" class="logboxcss" style=" BACKGROUND-IMAGE: url(img/pw.gif); BACKGROUND-REPEAT: no-repeat;" onFocus="this.style.backgroundImage = 'url(none)'" onKeyPress="javascript:if(event.keyCode==13) goSubmit();" tabindex="2"></td>
                      <td width="71"><a href="javascript:goSubmit();"><img src="img/btn_login.gif" width="71" height="20" border="0" tabindex="3"></a></td>
                    </tr>
                </table></td>
              </tr>
          </table>

		</form>



		  <table width="480" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td align="right" class=evgray>관리자모드입니다. 관리자외 접속을 금지합니다.</td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td height="1" align="center" bgcolor="#CCCCCC"></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
