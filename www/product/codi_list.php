<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/codi_list.php
 * date   : 2009.01.08
 * desc   : �ڵ��򰡼��� - ����Ʈ�� (�Ѵ� ���)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

//auth_chk( my64encode($_SERVER['REQUEST_URI']) );
?>

<? require_once "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" valign="top"><!-- �ְ� �ڵ� top10 //-->
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
				<td width="375"><img src="/img/title_top102.gif" width="374" height="37"></td>
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
				<td><img src="/img/codi_list_ov_01.gif" width="215"></td>
				<td><a href="#" onClick="go_best_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image55','','/img/codi_list_ov_02.gif',1)"><img src="/img/codi_list_02.gif" name="Image55" width="215" height="50" border="0" id="Image55" /></a></td>
				<td><a href="#" onClick="go_auth_shop();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image56','','/img/codi_list_ov_03.gif',1)"><img src="/img/codi_list_03.gif" name="Image56" width="215" height="50" border="0" id="Image56" /></a></td>
			</tr>
        </table>
<!-- ������̼� �� -->

        <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
        </table>




<!-- �ڵ�ž�� �򰡼��� ���� -->
<div id="CodiRankSubArea">
<?
// 1�ð�
CacheLoadFile($TPL_DIR."/sub/cache_codi_rank.tpl",$WEB_URL."proc/make_codi_rank.php", 3600);
?>
</div>
<!-- �ڵ�ž�� �򰡼��� �� -->



		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- �ڵ�ž�� �򰡼��� ����Ʈ ���� -->
<div id="CodiRankSubListArea">
<?
// 1�ð�
CacheLoadFile($TPL_DIR."/sub/cache_codi_rank_list.tpl",$WEB_URL."proc/make_codi_rank_list.php", 3600);
?>
</div>
<!-- �ڵ�ž�� �򰡼��� ����Ʈ �� -->

		</td>
	</tr>
</table>



<? include "../include/_foot.php"; ?>