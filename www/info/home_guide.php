<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/info/info.php
 * date   : 2008.12.22
 * desc   : �̿���
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
			
			<? require_once "../include/left_info.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
      
        </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">�̿��� :</font></b> <font color="#FFFFFF">�ڵ�ž�� ����Ʈ �̿����Դϴ�.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="22" valign="top"><img src="/img/member_user.gif" width="180" height="18" /></td>
        </tr>
        <tr>
          <td width="1" background="/img/dot00.gif"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><textarea name="textarea" class="memberbox "  style="width:100%; height:3980; overflow:hidden " >

			<? require_once "../member/txt/user1.php" ?>

</textarea></td>
        </tr>
      </table>
      <table width="100" height="25" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25">&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="22" valign="top"><img src="/img/member_shop.gif" width="180" height="18" /></td>
        </tr>
        <tr>
          <td width="1" background="/img/dot00.gif"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><textarea name="textarea2" class="memberbox "  style="width:100%; height:3570;overflow:hidden " ><? 
		  
		  require_once "../member/txt/shop1.php" ?>

</textarea></td>
        </tr>
      </table></td>
  </tr>
</table>
<? require_once "../include/_foot.php"; ?>