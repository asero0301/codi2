<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/main.php
 * date   : 2008.09.17
 * desc   : main
 *******************************************************/
session_start();

require_once "./inc/common.inc.php";
require_once "./inc/chk_frame.inc.php";




//Git Test�� �� �����ְ� ��������!!!  �ٸ� ���丮�� ������!!!
// ���� ���� ī�װ�
$t = time();
$t = $t % 5;
switch ( $t ) {
	case 1 :
		$rand_main_categ = "T";
		$main_codi_orderby = "REGDT";
		break;
	case 2 :
		$rand_main_categ = "B";
		$main_codi_orderby = "SCORE";
		break;
	case 3 :
		$rand_main_categ = "O";
		$main_codi_orderby = "PAGEVIEW";
		break;
	case 4 :
		$rand_main_categ = "U";
		$main_codi_orderby = "PRICE";
		break;
	default :
		$rand_main_categ = "A";
		$main_codi_orderby = "MANYCASH";
		break;
}
echo "<script>g_categ = '$rand_main_categ';</script>";

	
?>

<? include "./include/_head.php"; ?>


<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td></td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>

<!-- Content ���� ���� ���� : ��Ŀ�� | ��÷�ڸ���Ʈ | �ְ�BestShop | �α�Ű���� | �������� | ��� //-->

		<td width="200" valign="top">




<!-- ���� ���̵� 5��(��Ŀ��) �Ѹ� ���� //-->
<?
// ������ �������� ��Ŀ�� �������� �Է�/����/���� �ɶ����� ������ ���� �����Ѵ�.
require_once $TPL_DIR."/main/focus.tpl";
?>
<!-- ���� ���̵� 5��(��Ŀ��) �Ѹ� �� //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- ��÷�� ����Ʈ ���� //-->
<?
// ���� ������ ���� ��÷��ƾ�� ���� ��÷�� ��� ������ �����Ѵ�.
require_once $TPL_DIR."/main/gift_list.tpl";
?>
<!-- ��û�� ����Ʈ �� //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- �ְ� ����Ʈ �� 10�� ���� //-->
<? 
// ���� �Ͽ��� ���� �ְ�����Ʈ���� ���� �ѹ� �����Ѵ�.
require_once $TPL_DIR."/main/weekly_best_shop.tpl";
?>
<!-- �ְ� ����Ʈ �� 10�� �� //-->



		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>




<!-- �α�Ű���� ���� //-->
<? 
// ���������������� �Է�/����/������ ���ϻ���
require_once $TPL_DIR."/main/main_kwd.tpl";
?>
<!-- �α�Ű���� �� //-->




		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- �������� ���� //-->
<?
// �ֱٲ��� new ǥ���ϱ� ���� 10�и��� DB�о ó��
// new�� �ֱ� 3��
CacheLoadFile($TPL_DIR."/main/cache_notice.tpl",$WEB_URL."proc/make_main_notice.php", 600);
?>
<!-- �������� �� //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>




<!-- ��� ��ġ //-->
<?
// ���������������� �Է�/����/������ ���ϻ���
require_once $TPL_DIR."/banner/MAINL.tpl";
?>
		
<!-- ��� �� //-->




		</td>
<!-- Content ���� ���� ������ : ��Ŀ�� | ��÷�ڸ���Ʈ | �ְ�BestShop | �α�Ű���� | �������� | ��� //-->




		<td width="15"></td>


<!-- Content ���� �߾� ���� : �򰡴������ �ڵ� | Ranking Top 10 | ������ ��õ�ڵ� | ��ȸ�� PR | �ڵ�UCC �� �ȳ���ũ //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- Content ���� �߾� ���� : �򰡴������ �ڵ� | Ranking Top 10 | ������ ��õ�ڵ� | ��ȸ�� PR | �ڵ�UCC �� �ȳ���ũ //-->

		
		<td valign="top">





<!-- �򰡴������ �ڵ� ���� -->
<?
/*
�̽������� ������������ ���ϸ� ���̱� ���� 5���� ������� html�� �����Ѵ�.
5���� ����� ���� �������� ��������.

REGDT : �ֱٵ���Ѱ� ���� ������
SCORE : �̹��� ������ ���� ������ ����������
PAGEVIEW : �������䰡 ���� ���°� ����������
PRICE : ������ �Ѱ� ����������
MANYCASH : ĳ���� ���� ����Ѱ� ����������
*/
//$main_codi_orderby = "REGDT";


if ( $main_codi_orderby == "REGDT" ) {
	CacheLoadFile($TPL_DIR."/main/cache_main_codi_list_by_regdt.tpl",$WEB_URL."proc/make_main_codi_list_by_regdt.php", 300);
} else if ( $main_codi_orderby == "SCORE" ) {
	CacheLoadFile($TPL_DIR."/main/cache_main_codi_list_by_score.tpl",$WEB_URL."proc/make_main_codi_list_by_score.php", 300);
} else if ( $main_codi_orderby == "PAGEVIEW" ) {
	CacheLoadFile($TPL_DIR."/main/cache_main_codi_list_by_pageview.tpl",$WEB_URL."proc/make_main_codi_list_by_pageview.php", 300);
} else if ( $main_codi_orderby == "PRICE" ) {
	CacheLoadFile($TPL_DIR."/main/cache_main_codi_list_by_price.tpl",$WEB_URL."proc/make_main_codi_list_by_price.php", 300);
} else if ( $main_codi_orderby == "MANYCASH" ) {
	CacheLoadFile($TPL_DIR."/main/cache_main_codi_list_by_manycash.tpl",$WEB_URL."proc/make_main_codi_list_by_manycash.php", 300);
}
?>
<!-- �򰡴������ �ڵ� �� -->





<!-- Ranking Top 10 ���� -->
<?
// 5��
CacheLoadFile($TPL_DIR."/main/cache_main_ranking_top10.tpl",$WEB_URL."proc/make_ranking_top10.php", 300);
?>
<!-- Ranking Top 10 �� -->










		<a name="today_recom_pos"></a>

		<table width="645" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="424" valign="top">



<!-- ������ ��õ�ڵ� -->
<?
// 10��
CacheLoadFile($TPL_DIR."/main/cache_main_today_recom_codi.tpl",$WEB_URL."proc/make_main_today_recom_codi.php", 600);
?>
<!-- ������ ��õ�ڵ� �� -->



				<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td></td>
					</tr>
				</table>

				</td>
				<td width="6" valign="top" background="/img/bar_sero_01.gif"></td>
				<td align="right" valign="top">
				<table width="100%" height="6" border="0" cellpadding="0" cellspacing="0" bgcolor="FEBBBB">
					<tr>
						<td></td>
					</tr>
				</table>



<!-- ��ȸ�� PR ���� -->
<?
// 10��
CacheLoadFile($TPL_DIR."/main/cache_shop_pr.tpl",$WEB_URL."proc/make_shop_pr.php", 600);
?>
<!-- ��ȸ�� PR �� -->



				</td>
			</tr>
		</table>

		<table width="430" height="6" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF6060">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>




<!-- �ڵ�UCC �� �ȳ���ũ ���� -->
<?
// 10��
CacheLoadFile($TPL_DIR."/main/cache_ucc_n_info.tpl",$WEB_URL."proc/make_ucc_n_info.php", 600);
?>
<!-- �ڵ�UCC �� �ȳ���ũ �� -->



		</td>
<!-- Content ���� �߾� �� : �򰡴������ �ڵ� | Ranking Top 10 | ������ ��õ�ڵ� | ��ȸ�� PR | �ڵ�UCC �� �ȳ���ũ //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- Content ���� �߾� �� : �򰡴������ �ڵ� | Ranking Top 10 | ������ ��õ�ڵ� | ��ȸ�� PR | �ڵ�UCC �� �ȳ���ũ //-->


	</tr>
</table>



<? include "./include/_foot.php"; ?>

