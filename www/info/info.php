<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/info/info.php
 * date   : 2008.12.22
 * desc   : 사이트안내
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

require_once "/coditop/include/_head.php";
?>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><!-- 주간 코디 top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? require_once "../include/left_info.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
      
    </td>
    <td width="15"></td>
    <td align="center" valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">사이트 소개 :</font></b> <font color="#FFFFFF">코디탑텐 사이트 소개합니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" ><img src="/img/info.jpg" /></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" ><img src="/img/info001.gif" /></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" background="/img/info_bg01.gif"><table width="590" border="0" cellspacing="0" cellpadding="0">

              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="645" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" ><img src="/img/info002.gif" /></td>
              </tr>
              <tr>
                <td align="center" ><img src="/img/info003.gif" width="645" height="738" /></td>
              </tr>
            </table>
            </td>
        </tr>
        <tr>
          <td><img src="/img/info_bg02.gif" width="645" height="22" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<? require_once "../include/_foot.php"; ?>