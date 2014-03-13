<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/Mshop.php
 * date   : 2008.10.08
 * desc   : 샵관리
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];


$mainconn->close();

?>

<? include "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
       
            </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">세금게산서 :</font></b> <font color="#FFFFFF">결제한 내역에 따라 세금계산서를 신청하실 수 있습니다..</font> </td>
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
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">세금계산서는 전자세금계산서로 직접 발행되며 우편으로 발송되지 않습니다.</font>
                        <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td></td>
                          </tr>
                        </table>
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">세금계산서는 샵회원정보에 입력해 주신 사업자정보를 바탕으로 발행됩니다. </font><font color="#333333">(내용이 없으면 발행되지 않습니다. </font>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="24" align="right" valign="bottom"><a href="#"><img src="/img/btn_shop_modify.gif" width="110" height="20" border="0" /></a></td>
                          </tr>
                      </table></td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><textarea name="textarea" class="textbox "  style="width:100%; height:300; padding::10 10 10 10" readonly="readonly" >PG사 선정 후 작업</textarea></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<? include "../include/_foot.php"; ?>