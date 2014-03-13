<?
/*******************************************************
* author : Chan Hwang (gogisnim@gmail.com)
* file   : /coditop/product/auth_shop_list.php
* date   : 2009.01.15
* desc   : 코디평가순위 - 인증샵
*******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";
?>

<? require_once "../include/_head.php"; ?>


<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
	
	
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			

<!-- 오늘의 추천코디 시작 -->
<?
// 10분
CacheLoadFile($TPL_DIR."/sub/cache_sub_today_recom_codi.tpl",$WEB_URL."proc/make_sub_today_recom_codi.php", 600);
?>
<!-- 오늘의 추천코디 끝 -->
			
			
			</td>
          </tr>
        </table>
    
        <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
        </table>
   

<!-- 주간 베스트 샵 10위 시작 //-->
<? 
// 매주 일요일 새벽 주간베스트샵을 통해 한번 실행한다.(메인에 있는거 그대로)
require_once "../" . $TPL_DIR."/main/weekly_best_shop.tpl";
?>
<!-- 주간 베스트 샵 10위 끝 //-->


    </td>
    <td width="15"></td>
    <td valign="top">
        <table width="645" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375"><img src="/img/title_top104.gif" width="400" height="37"></td>
            <td >&nbsp;</td>
          </tr>
        </table>
        <table width="645" border="0" cellspacing="0" cellpadding="0">
        
          <tr>
            <td height="1" background="/img/dot00.gif"></td>
          </tr>
        
        </table>  
        <table width="645" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="/img/codi_list_ov_03.gif" width="215" height="50"></td>
            <td><a href="#" onClick="total_codi_ranking();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image25','','/img/codi_list_ov_01.gif',1)"><img src="/img/codi_list_01.gif" name="Image25" width="215" height="50" border="0" id="Image25" /></a><a href="#"></a></td>
            <td><a href="#" onClick="go_best_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','/img/codi_list_ov_02.gif',1)"><img src="/img/codi_list_02.gif" name="Image26" width="215" height="50" border="0" id="Image26" /></a><a href="#"></a></td>
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
                  <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                      <tr>
                        <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> 코디탑텐의 베스트샵에서 <b><font color="#FF5C5C"><u>주간 TOP10에 4회아상 선정된 샵</u></font></b>으로, 코디탑텐 회원님들의 평가로 인증된 멋진 감각과 패션<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;센스를 가진 샵들입니다.</td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table width="100" height="16" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
      </table>







<!-- 인증샵 리스트 시작 -->
<div id="AuthShopListArea">
<?
// 1시간
CacheLoadFile($TPL_DIR."/sub/cache_auth_rank_list.tpl",$WEB_URL."proc/make_auth_rank_list.php", 3600);
?>
</div>
<!-- 인증샵 리스트 끝 -->


	  </td>
  </tr>
</table>

<? include "../include/_foot.php"; ?>