<?
/*******************************************************
* author : Chan Hwang (gogisnim@gmail.com)
* file   : /coditop/product/best_shop_list.php
* date   : 2009.01.14
* desc   : 코디평가순위 - 베스트샵 (둘다 비슷)
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
				<td width="375"><img src="/img/title_top103.gif" width="374" height="37"></td>
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
				<td><img src="/img/codi_list_ov_02.gif" width="215" height="50"></td>
				<td><a href="#" onClick="total_codi_ranking();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image57','','/img/codi_list_ov_01.gif',1)"><img src="/img/codi_list_01.gif" name="Image57" width="215" height="50" border="0" id="Image57" /></a></td>
				<td><a href="#" onClick="go_auth_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image58','','/img/codi_list_ov_03.gif',1)"><img src="/img/codi_list_03.gif" name="Image58" width="215" height="50" border="0" id="Image58" /></a></td>
			</tr>
		</table>
<!-- 내비게이션 끝 -->

		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- 샵 평가순위 시작 -->
<div id="ShopRankSubArea">
<?
// 1시간
CacheLoadFile($TPL_DIR."/sub/cache_shop_rank.tpl",$WEB_URL."proc/make_shop_rank.php", 3600);
?>
</div>
<!-- 샵 평가순위 끝 -->


		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- 샵 평가순위 시작 -->
<div id="ShopRankSubListArea">
<?
// 1시간
CacheLoadFile($TPL_DIR."/sub/cache_shop_rank_list.tpl",$WEB_URL."proc/make_shop_rank_list.php", 3600);
?>
</div>


		</td>
	</tr>
</table>

<map name="btn_codi" id="btn_codi">
	<area shape="rect" coords="13,33,62,49" href="#" alt="인증샵이란?" onclick="MM_openBrWindow('/pop/pop_shop.html','','toolbar=no,location=no,status=no,menubar=no,width=300,height=131,top=430,left=580');" />
	<area shape="rect" coords="13,53,62,69" href="#" alt="모두보기" onclick="go_auth_shop();" />
	<area shape="rect" coords="1,80,72,150" href="#" alt="모두보기" onclick="go_auth_shop();" />
</map>

<? include "../include/_foot.php"; ?>