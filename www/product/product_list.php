<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/product_list.php
 * date   : 2008.10.13
 * desc   : �����ּ���
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

/*
S: ��
P: ����
A: ��+����
K: Ű����

s_key : A 
keyword : ���
*/

$s_key = trim($_REQUEST['s_key']);
$keyword = trim($_REQUEST['keyword']);
/*
echo "
kwd_categ : $kwd_categ <br>
kwd_kind : $kwd_kind <br>
page : $page <br>
kwd : $kwd <br>
order : $order <br>
s_key : $s_key <br>
keyword : $keyword <br>
";

onClick="loadCategKwdList('U','S','����',1,'A','','');"
function loadCategKwdList(kwd_categ,kwd_kind,kwd,page,order,s_key,keyword) {}
loadCategKwdList('','','',1,'A','S','����');
*/
?>

<? include "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">

        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			

			<!-- �ְ� �ڵ� top10 //-->
			<?
			//CacheLoadFile($TPL_DIR."/sub/weekly_codi_top10.tpl",$WEB_URL."proc/make_weekly_codi_top10.php", 300);
			// ���� �Ͽ��� weekly_product_rank.pl�� ���� �ѹ� �����Ѵ�.
			require_once "../" . $TPL_DIR."/sub/weekly_codi_top10.tpl";
			?>
			
			
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
	  
	  
      <!-- �ְ� ����Ʈ �� 10�� �� //--><!-- ��� ��ġ //-->
      <!-- ��� �� //-->
    </td>
    <td width="15"></td>
    <td valign="top">



        <table width="645" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375"><img src="/img/title_top101.gif" width="374" height="37"></td>
            <td >&nbsp;</td>
          </tr>
        </table>
		
		
		
<!-- �򰡴������ �ڵ� - ī�װ�/Ű���� -->		
<?
// 10��
CacheLoadFile($TPL_DIR."/sub/cache_categ_kwd.tpl",$WEB_URL."proc/make_categ_kwd.php", 600);
?>
		
		
		
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
      </table>


<!-- ����Ʈ -->
<div id="CategKwdListArea"></div>




	  </td>
  </tr>
</table>

<script language="javascript">
loadCategKwdList('','','',1,'A','<?=$s_key?>','<?=$keyword?>');
</script>

<? include "../include/_foot.php"; ?>