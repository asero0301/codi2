<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/info/home_join.php
 * date   : 2008.12.22
 * desc   : ���� �� ����
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

require_once "../include/_head.php";
?>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><!-- �ְ� �ڵ� top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- ���������� ���� //-->
			
			<? require_once   "../include/left_info.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
      
        </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">���� �� ���� :</font></b> <font color="#FFFFFF">�ڵ�ž�ٿ� ���� �� ���ǻ����� �����ø� �Ʒ� ������ �ۼ��� �ּ���.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="1" bgcolor="DADADA"></td>
                  </tr>
                  <tr>
                    <td height="25" bgcolor="F6F5F5" style="padding-top:3">&nbsp;&nbsp;<font color="#333333">��  Ȯ����� �����帮���� �ϰڽ��ϴ�. �����մϴ�. </font></td>
                  </tr>
                  <tr>
                    <td height="1" bgcolor="DADADA"></td>
                  </tr>
                </table>
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td><input type="text" name="textfield34" class="logbox"  style="width:150"/></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �̸��� </td>
                      <td><input type="text" name="textfield32" class="logbox"  style="width:150"/>
                          ��
                          <select name="select" class="logbox"  style="width:150">
                    </select>
                    <input name="textfield322" type="text" class="logbox"  style="width:150"/></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> ����ó </td>
                      <td><input type="text" name="textfield32332" class="logbox"  style="width:60"/>
                          -
                          <input type="text" name="textfield3233" class="logbox"  style="width:60"/>
                          -
                      <input type="text" name="textfield32322" class="logbox"  style="width:60"/></td>
                    </tr>
					<tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td><textarea name="textarea" class="memobox"  style="width:100%; height:150; "></textarea></td>
					</tr>
                  </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><a href="#"><img src="/img/btn_ok02.gif" width="70" height="20" border="0"></a>&nbsp;<a href="#"><img src="/img/btn_cancle02.gif" width="70" height="20" border="0"></a></td>
        </tr>
      </table></td>
  </tr>
</table>
<? require_once "../include/_foot.php"; ?>