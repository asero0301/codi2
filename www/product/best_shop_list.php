<?
/*******************************************************
* author : Chan Hwang (gogisnim@gmail.com)
* file   : /coditop/product/best_shop_list.php
* date   : 2009.01.14
* desc   : �ڵ��򰡼��� - ����Ʈ�� (�Ѵ� ���)
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


<!-- ������ ��õ�ڵ� ���� -->
<?
// 10��
CacheLoadFile($TPL_DIR."/sub/cache_sub_today_recom_codi.tpl",$WEB_URL."proc/make_sub_today_recom_codi.php", 600);
?>
<!-- ������ ��õ�ڵ� �� -->


				</td>
			</tr>
		</table>

		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- �ְ� ����Ʈ �� 10�� ���� //-->
<? 
// ���� �Ͽ��� ���� �ְ�����Ʈ���� ���� �ѹ� �����Ѵ�.(���ο� �ִ°� �״��)
require_once "../" . $TPL_DIR."/main/weekly_best_shop.tpl";
?>
<!-- �ְ� ����Ʈ �� 10�� �� //-->


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
		
<!-- ������̼� ���� -->
		<table width="645" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="/img/codi_list_ov_02.gif" width="215" height="50"></td>
				<td><a href="#" onClick="total_codi_ranking();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image57','','/img/codi_list_ov_01.gif',1)"><img src="/img/codi_list_01.gif" name="Image57" width="215" height="50" border="0" id="Image57" /></a></td>
				<td><a href="#" onClick="go_auth_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image58','','/img/codi_list_ov_03.gif',1)"><img src="/img/codi_list_03.gif" name="Image58" width="215" height="50" border="0" id="Image58" /></a></td>
			</tr>
		</table>
<!-- ������̼� �� -->

		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- �� �򰡼��� ���� -->
<div id="ShopRankSubArea">
<?
// 1�ð�
CacheLoadFile($TPL_DIR."/sub/cache_shop_rank.tpl",$WEB_URL."proc/make_shop_rank.php", 3600);
?>
</div>
<!-- �� �򰡼��� �� -->


		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- �� �򰡼��� ���� -->
<div id="ShopRankSubListArea">
<?
// 1�ð�
CacheLoadFile($TPL_DIR."/sub/cache_shop_rank_list.tpl",$WEB_URL."proc/make_shop_rank_list.php", 3600);
?>
</div>


		</td>
	</tr>
</table>

<map name="btn_codi" id="btn_codi">
	<area shape="rect" coords="13,33,62,49" href="#" alt="�������̶�?" onclick="MM_openBrWindow('/pop/pop_shop.html','','toolbar=no,location=no,status=no,menubar=no,width=300,height=131,top=430,left=580');" />
	<area shape="rect" coords="13,53,62,69" href="#" alt="��κ���" onclick="go_auth_shop();" />
	<area shape="rect" coords="1,80,72,150" href="#" alt="��κ���" onclick="go_auth_shop();" />
</map>

<? include "../include/_foot.php"; ?>