<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/msg_write.php
 * date   : 2008.10.27
 * desc   : �޽��� �ۼ���
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// �������� üũ
auth_chk($RURL);
?>

<? include "../include/_head.php"; ?>

<table border="0" cellspacing="0" cellpadding="0">
<form name="frm" id="frm" method="post">
<input type="hidden" id="tgt" name="tgt" value="self" />

  <tr>
    <td width="200" valign="top"><!-- �ְ� �ڵ� top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- ���������� ���� //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
    <!-- ���� ���̵� 5�� �Ѹ� �� //--> </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">[������] ���� ������ :</font></b> <font color="#FFFFFF">������ ���� �� �ֽ��ϴ�.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:12 12 12 12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="80" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� </td>
                      <td class="intext"><input type="text" name="sel_id" id="sel_id" class="logbox"  style="width:150" /> (�����̵� �Է�)</td>
                      <td align="right" class="evgray" style="LETTER-SPACING: 1px"><font color="FF0078"><span id='textlimit'>0</span>��/500��</font></td>
                    </tr>

                  </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2"></td>
                      </tr>
                  
                      <tr>
                        <td>
						<textarea name="msg_comment" id="msg_comment" class="memobox" onKeyUp="updateChar2(500,this.form.msg_comment,'textlimit');" style="width:100%; height:250; "></textarea></td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="1" bgcolor="DADADA"></td>
                      </tr>
                      <tr>
                        <td height="25" bgcolor="F6F5F5"  class="intext">&nbsp;
                         
                              <input type="checkbox" name="save_yn" id="save_yn" value="Y" checked readOnly />
                              ���� �����Կ� ���� (���������Կ� ������ �ϸ�, ���ſ��θ� Ȯ���� �� �ֽ��ϴ�.)
                          
                        </td>
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
          <td align="center"><a href="#" onClick="msg_send();"><img src="/img/btn_send.gif" width="60" height="20" border="0" /></a></td>
        </tr>
      </table></td>
  </tr>

</form>
</table>
<? include "../include/_foot.php"; ?>