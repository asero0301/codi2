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




//Git Test를 더 깊이있게 공부하자!!!  다른 디랙토리를 만들어싸!!!
// 랜덤 메인 카테고리
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

<!-- Content 영역 좌측 시작 : 포커스 | 당첨자리스트 | 주간BestShop | 인기키워드 | 공지사항 | 배너 //-->

		<td width="200" valign="top">




<!-- 좌측 가이드 5개(포커스) 롤링 시작 //-->
<?
// 관리자 페이지의 포커스 관리에서 입력/수정/삭제 될때마다 파일을 새로 생성한다.
require_once $TPL_DIR."/main/focus.tpl";
?>
<!-- 좌측 가이드 5개(포커스) 롤링 끝 //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- 당첨자 리스트 시작 //-->
<?
// 매주 월요일 새벽 당첨루틴을 통해 당첨된 결과 파일을 생성한다.
require_once $TPL_DIR."/main/gift_list.tpl";
?>
<!-- 당청자 리스트 끝 //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>



<!-- 주간 베스트 샵 10위 시작 //-->
<? 
// 매주 일요일 새벽 주간베스트샵을 통해 한번 실행한다.
require_once $TPL_DIR."/main/weekly_best_shop.tpl";
?>
<!-- 주간 베스트 샵 10위 끝 //-->



		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>




<!-- 인기키워드 시작 //-->
<? 
// 관리자페이지에서 입력/수정/삭제시 파일생성
require_once $TPL_DIR."/main/main_kwd.tpl";
?>
<!-- 인기키워드 끝 //-->




		<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>


<!-- 공지사항 시작 //-->
<?
// 최근꺼는 new 표시하기 위해 10분마다 DB읽어서 처리
// new는 최근 3일
CacheLoadFile($TPL_DIR."/main/cache_notice.tpl",$WEB_URL."proc/make_main_notice.php", 600);
?>
<!-- 공지사항 끝 //-->



		<table width="100" height="11" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
		</table>




<!-- 배너 위치 //-->
<?
// 관리자페이지에서 입력/수정/삭제시 파일생성
require_once $TPL_DIR."/banner/MAINL.tpl";
?>
		
<!-- 배너 끝 //-->




		</td>
<!-- Content 영역 좌측 끝끝끝 : 포커스 | 당첨자리스트 | 주간BestShop | 인기키워드 | 공지사항 | 배너 //-->




		<td width="15"></td>


<!-- Content 영역 중앙 시작 : 평가대기중인 코디 | Ranking Top 10 | 오늘의 추천코디 | 샵회원 PR | 코디UCC 및 안내링크 //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- Content 영역 중앙 시작 : 평가대기중인 코디 | Ranking Top 10 | 오늘의 추천코디 | 샵회원 PR | 코디UCC 및 안내링크 //-->

		
		<td valign="top">





<!-- 평가대기중인 코디 시작 -->
<?
/*
촌스럽지만 메인페이지의 부하를 줄이기 위해 5가지 방법으로 html을 생성한다.
5가지 방법은 각각 랜덤으로 정해진다.

REGDT : 최근등록한게 먼저 나오게
SCORE : 이번주 점수를 많이 얻은게 먼저나오게
PAGEVIEW : 페이지뷰가 많이 나온게 먼저나오게
PRICE : 가격이 싼게 먼저나오게
MANYCASH : 캐쉬를 많이 사용한게 먼저나오게
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
<!-- 평가대기중인 코디 끝 -->





<!-- Ranking Top 10 시작 -->
<?
// 5분
CacheLoadFile($TPL_DIR."/main/cache_main_ranking_top10.tpl",$WEB_URL."proc/make_ranking_top10.php", 300);
?>
<!-- Ranking Top 10 끝 -->










		<a name="today_recom_pos"></a>

		<table width="645" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="424" valign="top">



<!-- 오늘의 추천코디 -->
<?
// 10분
CacheLoadFile($TPL_DIR."/main/cache_main_today_recom_codi.tpl",$WEB_URL."proc/make_main_today_recom_codi.php", 600);
?>
<!-- 오늘의 추천코디 끝 -->



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



<!-- 샵회원 PR 시작 -->
<?
// 10분
CacheLoadFile($TPL_DIR."/main/cache_shop_pr.tpl",$WEB_URL."proc/make_shop_pr.php", 600);
?>
<!-- 샵회원 PR 끝 -->



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




<!-- 코디UCC 및 안내링크 시작 -->
<?
// 10분
CacheLoadFile($TPL_DIR."/main/cache_ucc_n_info.tpl",$WEB_URL."proc/make_ucc_n_info.php", 600);
?>
<!-- 코디UCC 및 안내링크 끝 -->



		</td>
<!-- Content 영역 중앙 끝 : 평가대기중인 코디 | Ranking Top 10 | 오늘의 추천코디 | 샵회원 PR | 코디UCC 및 안내링크 //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- *********************************************************************************** //-->
<!-- Content 영역 중앙 끝 : 평가대기중인 코디 | Ranking Top 10 | 오늘의 추천코디 | 샵회원 PR | 코디UCC 및 안내링크 //-->


	</tr>
</table>



<? include "./include/_foot.php"; ?>

