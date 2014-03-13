<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/pop_msg_write.php
 * date   : 2008.10.25
 * desc   : message form
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// 인증여부 체크
pop_auth_chk();

// 리퍼러 체크
pop_referer_chk();

$sel_id = $_POST['sel_id'];
$tgt = $_POST['tgt'];	// 관리자모드에서 보내는거
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>코디탑텐 쪽지보내기</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/common.js"></script>
<script language="javascript" src="/js/codi.js"></script>
</head>

<body>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form name="frm" id="frm" method="post">
<input type="hidden" id="tgt" name="tgt" value="<?=$tgt?>" />
  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100">&nbsp;</td>
        <td align="center" class="intitle"><font color="#FFFFFF"><b>코디탑텐 쪽지보내기</b></font></td>
        <td width="100" align="right"><span class="intitle" style="padding-bottom:10"><a href="javascript:self.close()"><img src="/img/btn_close02.gif" border="0"  align="absmiddle"/></a></span></td>
      </tr>
    </table>      
    </td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
      <tr>
        <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td style="padding:12 12 12 12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 받 는 이 </td>
                    <td><input name="sel_id" id="sel_id" type="text" class="logbox"  style="width:150" value="<?=$sel_id?>" readOnly /></td>
                    <td align="right" class="evgray" style="LETTER-SPACING: 1px"><font color="FF0078"><span id='textlimit'>0</span>자/500자</font></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="2"></td>
                    </tr>
                    <tr>
                      <td>
					  <textarea name="msg_comment" id="msg_comment" class="memobox" onKeyUp="updateChar2(500,this.form.msg_comment,'textlimit');" style="width:100%; height:120; "></textarea>
					  </td>
                    </tr>
                  </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="1" bgcolor="DADADA"></td>
                    </tr>
                    <tr>
                      <td height="25" bgcolor="F6F5F5"  class="intext">&nbsp;
                          <input type="checkbox" name="save_yn" id="save_yn" value="Y" checked readOnly />
                        보낸 쪽지함에 저장 (수신확인을 할 수 있습니다.) </td>
                    </tr>
                    <tr>
                      <td height="1" bgcolor="DADADA"></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><a href="#" onclick="msg_send();"><img src="/img/btn_send.gif" width="60" height="20" border="0" /></a>&nbsp;<a href="#" onClick="self.close();"><img src="/img/btn_cancle03.gif" border="0" /></a></td>
        </tr>
      </table>
      </td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>

</form>
</table>

</body>
</html>