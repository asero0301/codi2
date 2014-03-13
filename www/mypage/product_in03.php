<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in03.php
 * date   : 2008.10.14
 * desc   : 마이페이지 코디상품 등록 3단계(끝)
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
    <td width="332" background="/img/pro_in04.gif" style="padding-top:3">&nbsp;&nbsp;&nbsp;<b><font color="FFF600">코디등록</font></b> <font color="#FFFFFF">: 코디를 등록하여 평가를 신청합니다.</font></td>
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
      <td><font color="#333333"><b><img src="/img/in_title03.gif"  align="absmiddle"/></b></font> 코디상품이 이상없이 <b><font color="#009933">등록완료</font></b>되었습니다. </td>
      <td align="right" class="evfont"><img src="/img/icon_aa.gif"  align="absmiddle"><!--현재등록 전체캐쉬 <img src="/img/icon_cash.gif"  align="absmiddle"/><b><font color="FF0078">100</font></b>--></td>
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
                  <td height="150" style="padding:15 15 15 15"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">등록완료 안내 메세지 공간</font></b></td>
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
				  
				  <img src="/img/icon_aa.gif"  align="absmiddle"> 코디탑텐 메인페이지로 이동하실려면
				  
			      <img src="/img/btn_main.gif"  align="absmiddle"border="0" onClick="location.href='/main.php';" style="cursor:hand;" /></td>
                </tr>
                <tr>
                  <td height="6"></td>
                </tr>
                <tr>
                  <td><img src="/img/icon_aa.gif"  align="absmiddle" /> 등록한 코디상품이 있는 평가대기 리스트로 이동하실려면 <img src="/img/btn_list.gif" alt="리스트 보기"  align="absmiddle" border="0" onClick="location.href='/product/product_list.php';" style="cursor:hand;" /></td>
                </tr>
                 <tr>
                  <td height="6"></td>
                </tr>
                <tr>
                  <td><img src="/img/icon_aa.gif"  align="absmiddle" /> 코디상품을 추가로 등록하실려면 <img src="/img/btn_add02.gif" border="0"  align="absmiddle" onClick="location.href='/mypage/product_in01.php';" style="cursor:hand;" /></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <? include "../include/_foot.php"; ?>

