<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in03.php
 * date   : 2008.10.14
 * desc   : ���������� �ڵ��ǰ ��� 3�ܰ�(��)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

?>

<? include "../include/_head.php"; ?>
<link href="style.css" rel="stylesheet" type="text/css" />

<table width="860" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="332" background="/img/pro_in04.gif" style="padding-top:3">&nbsp;&nbsp;&nbsp;<b><font color="FFF600">�ڵ���</font></b> <font color="#FFFFFF">: �ڵ� ����Ͽ� �򰡸� ��û�մϴ�.</font></td>
    <td ><img src="/img/pro_in03.gif" width="528" height="29" /></td>
  </tr>
</table>

  <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><font color="#333333"><b><img src="/img/in_title03.gif"  align="absmiddle"/></b></font> �ڵ��ǰ�� �̻���� <b><font color="#009933">��ϿϷ�</font></b>�Ǿ����ϴ�. </td>
      <td align="right" class="evfont"><img src="/img/icon_aa.gif"  align="absmiddle"><!--������ ��üĳ�� <img src="/img/icon_cash.gif"  align="absmiddle"/><b><font color="FF0078">100</font></b>--></td>
    </tr>
    <tr>
      <td height="4" colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"><table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="8D2D45">
        <tr>
          <td bgcolor="580C1F" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                <tr>
                  <td height="150" style="padding:15 15 15 15"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">��ϿϷ� �ȳ� �޼��� ����</font></b></td>
                </tr>
              </table>
                </td>
            </tr>
          </table></td>
        </tr>
      </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
				  
				  <img src="/img/icon_aa.gif"  align="absmiddle"> �ڵ�ž�� ������������ �̵��ϽǷ���
				  
			      <img src="/img/btn_main.gif"  align="absmiddle"border="0" onClick="location.href='/main.php';" style="cursor:hand;" /></td>
                </tr>
                <tr>
                  <td height="6"></td>
                </tr>
                <tr>
                  <td><img src="/img/icon_aa.gif"  align="absmiddle" /> ����� �ڵ��ǰ�� �ִ� �򰡴�� ����Ʈ�� �̵��ϽǷ��� <img src="/img/btn_list.gif" alt="����Ʈ ����"  align="absmiddle" border="0" onClick="location.href='/product/product_list.php';" style="cursor:hand;" /></td>
                </tr>
                 <tr>
                  <td height="6"></td>
                </tr>
                <tr>
                  <td><img src="/img/icon_aa.gif"  align="absmiddle" /> �ڵ��ǰ�� �߰��� ����ϽǷ��� <img src="/img/btn_add02.gif" border="0"  align="absmiddle" onClick="location.href='/mypage/product_in01.php';" style="cursor:hand;" /></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <? include "../include/_foot.php"; ?>

