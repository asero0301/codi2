<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/codi_list.php
 * date   : 2009.01.08
 * desc   : 코디평가순위 - 베스트샵 (둘다 비슷)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

//auth_chk( my64encode($_SERVER['REQUEST_URI']) );
?>

<? require_once "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" valign="top"><!-- 주간 코디 top10 //-->
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
				<td width="375"><img src="/img/title_top102.gif" width="374" height="37"></td>
				<td >&nbsp;</td>
			</tr>
		</table>

        <table width="645" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="1" background="/img/dot00.gif"></td>
			</tr>
        </table>  

<!-- 내비게이션 시작 -->
        <table width="645" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="/img/codi_list_ov_01.gif" width="215"></td>
				<td><a href="#" onClick="go_best_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image55','','/img/codi_list_ov_02.gif',1)"><img src="/img/codi_list_02.gif" name="Image55" width="215" height="50" border="0" id="Image55" /></a></td>
				<td><a href="#" onClick="go_auth_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image56','','/img/codi_list_ov_03.gif',1)"><img src="/img/codi_list_03.gif" name="Image56" width="215" height="50" border="0" id="Image56" /></a></td>
			</tr>
        </table>
<!-- 내비게이션 끝 -->

        <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
        </table>




<!-- 코디탑텐 평가순위 시작 -->
<div id="CodiRankSubArea">
<?
// 1시간
CacheLoadFile($TPL_DIR."/sub/cache_codi_rank.tpl",$WEB_URL."proc/make_codi_rank.php", 3600);
?>
</div>
<!-- 코디탑텐 평가순위 끝 -->



		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- 코디탑텐 평가순위 리스트 시작 -->
<div id="CodiRankSubListArea">
<?
// 1시간
CacheLoadFile($TPL_DIR."/sub/cache_codi_rank_list.tpl",$WEB_URL."proc/make_codi_rank_list.php", 3600);
?>
</div>
<!-- 코디탑텐 평가순위 리스트 끝 -->

		</td>
	</tr>
</table>



<? include "../include/_foot.php"; ?>