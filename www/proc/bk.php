<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_main_codi_list.php
 * date   : 2008.10.19
 * desc   : 메인 "평가 대기중인 코디" 만드는 proc 스크립트
 *******************************************************/
require_once "/coditop/inc/common.inc.php";
require_once "/coditop/config/config.php";
$mainconn->open();

$ret_arr = getLastWeekDay(time());

$f_day = $ret_arr[0];
$l_day = $ret_arr[1];

$page = $_REQUEST['page'];
if ( !$page ) $page = 1;

$pr_4 = "
<td width='106' align='left' valign='middle'>
<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#DEDEDE'>
	<tr>
		<td align='center' valign='middle' bgcolor='#FFFFFF'><img src='" . __HTTPURL__  . "/img/view_icon_01.jpg' width='95' height='95' border='0'></td>
	</tr>
</table>
</td>
";

$pr_8 = "
<td align='left' valign='middle'>
<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#DEDEDE'>
	<tr>
		<td align='center' valign='middle' bgcolor='#FFFFFF'><img src='" . __HTTPURL__  . "/img/view_icon_02.jpg' width='95' height='95' border='0'></td>
	</tr>
</table>
</td>
";

$pr_18 = "
<td align='left' valign='middle'>
<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#DEDEDE'>
	<tr>
		<td align='center' valign='middle' bgcolor='#FFFFFF'><a href='#' onClick=\"location.href='/product/product_list.php';\"><img src='" . __HTTPURL__  . "/img/view_icon_03.gif' width='95' height='95' border='0'></a></td>
	</tr>
</table>
</td>
";

$str = "
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td><img src='" . __HTTPURL__  . "/img/title_ingcodi.gif' width='645' height='30'></td>
	</tr>
	<tr>
		<td>
		<table width='645' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='335'>
				<table border='0' cellspacing='0' cellpadding='0'>
		";

// 랜덤으로 돌리기 위해 페이징 개념을 사용하기 위해 전체 레코드를 구한다.
$sql = "
select count(*)
from tblProduct A, tblProductEach B
where 1
and A.p_idx = B.p_idx and A.p_judgment != 'R'
and now() between B.start_dt and B.end_dt
";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$MAIN_CODI_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $MAIN_CODI_PAGE_SIZE*($page-1);
	$last = $MAIN_CODI_PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd";
$orderby = " order by A.p_reg_dt desc ";


// 서브쿼리로 처리한다.
// 조인으로 하면 지난주 랭킹이 없는 코디는 검색되지 않는다.
// 현재 진행중인 코디이고 점수는 현재 진행중인 점수만 계산
$sql = "
select A.p_idx, A.p_title, A.shop_idx, A.p_categ, A.p_gift, A.p_judgment, A.p_main_img, B.p_e_idx,
(select shop_name from tblShop where shop_idx=A.shop_idx) as shop_name,
(select ifnull(sum(X.score),0) from tblScoreConfig X, tblScore Y where X.sc_cid = Y.sc_cid and Y.p_e_idx = B.p_e_idx) as score
from tblProduct A, tblProductEach B
where 1
and A.p_idx = B.p_idx and A.p_judgment != 'R'
and now() between B.start_dt and B.end_dt
$orderby limit $first, $MAIN_CODI_PAGE_SIZE 
";
/* 이건 지난주의 점수를 얻어서 폐기
$sql = "
select A.p_idx, A.p_title, A.shop_idx, A.p_categ, A.p_gift, A.p_judgment, A.p_main_img, B.p_e_idx,
(select shop_name from tblShop where shop_idx=A.shop_idx) as shop_name,
ifnull((select score from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),0) as score
from tblProduct A, tblProductEach B
where 1
and A.p_idx = B.p_idx and A.p_judgment != 'R'
and now() between B.start_dt and B.end_dt
$orderby limit $first, $MAIN_CODI_PAGE_SIZE 
";
*/
$res = $mainconn->query($sql);

$cnt = 1;
$pr_cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$p_idx		= trim($row['p_idx']);
	$shop_idx	= trim($row['shop_idx']);
	$shop_name	= trim($row['shop_name']);
	$p_title	= trim($row['p_title']);
	$p_categ	= trim($row['p_categ']);
	$p_gift		= trim($row['p_gift']);
	$p_main_img	= trim($row['p_main_img']);
	$p_judgment = trim($row['p_judgment']);
	$p_e_idx	= trim($row['p_e_idx']);
	$score		= trim($row['score']);

	$main_img = $UP_URL."/thumb/".$p_main_img;

	if ( $pr_cnt == 1 || $pr_cnt == 6 || $pr_cnt == 11 ) {
		$str .= "<tr>";
	}

	$pr_txt = ${"pr_".$pr_cnt};
	if ( strlen($pr_txt) > 10 ) {
		
		$str .= $pr_txt;
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=15; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'main_codi_detail_$j','','$sh',";
		$param_hide .= "'main_codi_detail_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);

	if ( $cnt == 4 || $cnt == 5 || $cnt == 8 || $cnt == 9 || $cnt == 10 || $cnt == 14 || $cnt == 15 ) {

		$str .= "
		<td align='left' valign='middle'>
		<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#DEDEDE'>
			<tr>
				<td align='right' valign='middle' bgcolor='#FFFFFF'><a href='#'  onClick=\"MM_showHideLayers($param_show);\"><img src='" . __HTTPURL__  . "$main_img' width='95' height='95' border='0'></a>
				<div id='main_codi_detail_$cnt' style='position:relative; z-index:1; left:-402px; top: -130px;visibility: hidden;'> 
				<div STYLE='position: absolute;  '>
				<table border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td>
						<table width='300' border='1' cellpadding='0' cellspacing='5' bgcolor='#FF6600'  bordercolor='#FFFFFF'>
							<tr>
								<td bgcolor='#FFFFFF' >
								<table width='100%' border='0' cellspacing='0' cellpadding='0'>
									<tr>
										<td rowspan='2' class='title' style='PADDING-top: 10px;PADDING-bottom: 10px;PADDING-left: 10px;PADDING-right: 10px;' ><a href='#' onClick=\"codi_view('$p_idx');\"><img src='" . __HTTPURL__  . "$main_img' width='130' height='130' border='0'></a></td>
										<td valign='bottom'  class='evmem'  style='PADDING-top: 6px;PADDING-bottom: 4px;'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
									</tr>
									<tr>
										<td valign='top'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
											</tr>
											<tr>
												<td width='48' height='25'><font color='#FF3300'><img src='" . __HTTPURL__  . "/img/icon_presnt.jpg' width='44' height='19' align='absmiddle'></font> </td>
												<td class='evfont'  style='PADDING-top: 4px;PADDING-bottom: 4px;'><font color='#FF3300'>$p_gift </font></td>
											</tr>
											<tr>
												<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
											</tr>
											<tr>
												<td height='4' colspan='2'></td>
											</tr>
										</table>
										<table width='100%' border='0' cellpadding='0' cellspacing='0'>
											<tr>
												<td height='21' class='shopname'><img src='" . __HTTPURL__  . "/img/box_shop.gif' width='44' height='19' align='absmiddle'> <b><a href='#' onClick=\"shop_view('$shop_idx');\">$shop_name</a> </b></td>
											</tr>
											<tr>
												<td height='21'  class='evfont'><span class='shopname'><img src='" . __HTTPURL__  . "/img/box_jumsu.gif' width='44' height='19' align='absmiddle'> <b><font color='#CC3300'>$score</font></b></span></td>
											</tr>
											<tr>
												<td  class='evfont' align=right><span class='shopname'><a href='#'  onClick=\"MM_showHideLayers($param_hide);\"><img src='" . __HTTPURL__  . "/img/btn_pop_close.gif' align='absmiddle' border=0></a> &nbsp; </td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
						<td width='6' align='left'><img src='" . __HTTPURL__  . "/img/arr_orage_right.gif'></td>
					</tr>
				</table>
				</div>
				</div>
				</td>
			</tr>
		</table>
		</td>
		";

	} else {

		$str .= "
		<td width='106' align='left' valign='middle'>
		<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#DEDEDE'>
			<tr>
				<td align='right' valign='middle' bgcolor='#FFFFFF'><a href='#'  onClick=\"MM_showHideLayers($param_show);\"><img src='" . __HTTPURL__  . "$main_img' width='95' height='95' border='0'></a>
				<div id='main_codi_detail_$cnt' style='position:relative; z-index:2; left:0px; top: -130px;visibility: hidden;' > 
				
				<div STYLE='position: absolute;  '>
				<table width='350' height='180'  border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td width='6' align='right'><img src='" . __HTTPURL__  . "/img/arr_orage.gif'></td>
						<td>
						<table width='344' height='180' border='1' cellpadding='0' cellspacing='5'  bordercolor='#FFFFFF' bgcolor='#FF6600'>
							<tr>
								<td bgcolor='#FFFFFF' >
								<table width='100%' border='0' cellspacing='0' cellpadding='0'>
									<tr>
										<td rowspan='2' class='title' style='PADDING-top: 10px;PADDING-bottom: 10px;PADDING-left: 10px;PADDING-right: 10px;' ><a href='#' onClick=\"codi_view('$p_idx');\"><img src='" . __HTTPURL__  . "$main_img' width='130' height='130' border='0'></a></td>
										<td valign='bottom'  class='evmem'  style='PADDING-top: 6px;PADDING-bottom: 4px;'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
									</tr>
									<tr>
										<td valign='top'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
											</tr>
											<tr>
												<td width='48' height='30'><font color='#FF3300'><img src='" . __HTTPURL__  . "/img/icon_presnt.jpg' width='44' height='19' align='absmiddle'></font> </td>
												<td class='evfont'  style='PADDING-top: 4px;PADDING-bottom: 4px;'><font color='#FF3300'>$p_gift </font></td>
											</tr>
											<tr>
												<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
											</tr>
											<tr>
												<td height='4' colspan='2'></td>
											</tr>
										</table>
										<table width='100%' border='0' cellpadding='0' cellspacing='0'>
											<tr>
												<td height='23' class='shopname'><img src='" . __HTTPURL__  . "/img/box_shop.gif' width='44' height='19' align='absmiddle'> <b><a href='#' onClick=\"shop_view('$shop_idx');\">$shop_name</a> </b></td>
											</tr>
											<tr>
												<td height='23'  class='evfont'><span class='shopname'><img src='" . __HTTPURL__  . "/img/box_jumsu.gif' width='44' height='19' align='absmiddle'> <b><font color='#CC3300'>$score</font></b></span></td>
											</tr>   
											<tr>
												<td  class='evfont' align=right><span class='shopname'><a href='#'  onClick=\"MM_showHideLayers($param_hide);\"><img src='" . __HTTPURL__  . "/img/btn_pop_close.gif' align='absmiddle' border=0></a> &nbsp; </td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</div>
				</div>
				</td>
			</tr>
		</table>
		</td>
		";
	}
	
	
	if ( $pr_cnt == 5 || $pr_cnt == 10 || $pr_cnt == 16 ) {
		$str .= "</tr>";
	}

	//if ( $pr_cnt != 5 && $pr_cnt != 11 && $pr_cnt != 18 ) {
		$cnt++;		// 실제 레코드수(5)
	//}

	$pr_cnt++;		// 보이는 레코드수(6)

}


// 코디가 모자랄때 처리
for ($i=$pr_cnt; $i<=16; $i++ ) {
	if ( $i == 1 || $i == 6 || $i == 11 ) {
		$str .= "<tr>";
	}
	if ( $i == 16 ) {
		$str .= $pr_18;
	} else {
		$str .= $pr_8;
	}
	if ( $i == 4 ) $str .= $pr_4;
	if ( $i == 8 ) $str .= $pr_8;
	if ( $i == 5 || $i == 10 || $i == 16 ) {
		$str .= "</tr>";
	}
}



$str .= "
				</table>

				</td>
				<td width='6' background='/img/bar_sero_01.gif'>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='6' bgcolor='FF5C5C'></td>
	</tr>
</table>
";


$mainconn->close();


echo $str;
?>

