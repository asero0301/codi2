<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/product_list.php
 * date   : 2008.10.13
 * desc   : 평가해주세요
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

/*
S: 샵
P: 제목
A: 샵+제목
K: 키워드

s_key : A 
keyword : 녹색
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

onClick="loadCategKwdList('U','S','섹시',1,'A','','');"
function loadCategKwdList(kwd_categ,kwd_kind,kwd,page,order,s_key,keyword) {}
loadCategKwdList('','','',1,'A','S','냥이');
*/
?>

<? include "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">

        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			

			<!-- 주간 코디 top10 //-->
			<?
			//CacheLoadFile($TPL_DIR."/sub/weekly_codi_top10.tpl",$WEB_URL."proc/make_weekly_codi_top10.php", 300);
			// 매주 일요일 weekly_product_rank.pl을 통해 한번 실행한다.
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
   

      <!-- 주간 베스트 샵 10위 시작 //-->
	<? 
	// 매주 일요일 새벽 주간베스트샵을 통해 한번 실행한다.(메인에 있는거 그대로)
	require_once "../" . $TPL_DIR."/main/weekly_best_shop.tpl";
	?>
	  
	  
      <!-- 주간 베스트 샵 10위 끝 //--><!-- 배너 위치 //-->
      <!-- 배너 끝 //-->
    </td>
    <td width="15"></td>
    <td valign="top">



        <table width="645" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375"><img src="/img/title_top101.gif" width="374" height="37"></td>
            <td >&nbsp;</td>
          </tr>
        </table>
		
		
		
<!-- 평가대기중인 코디 - 카테고리/키워드 -->		
<?
// 10분
CacheLoadFile($TPL_DIR."/sub/cache_categ_kwd.tpl",$WEB_URL."proc/make_categ_kwd.php", 600);
?>
		
		
		
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
      </table>


<!-- 리스트 -->
<div id="CategKwdListArea"></div>




	  </td>
  </tr>
</table>

<script language="javascript">
loadCategKwdList('','','',1,'A','<?=$s_key?>','<?=$keyword?>');
</script>

<? include "../include/_foot.php"; ?>