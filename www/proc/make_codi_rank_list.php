<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_codi_rank_list.php
 * date   : 2009.01.14
 * desc   : 코디탑텐 평가순위 html 생성(1시간마다)
 *			메인 페이지만 html로 만들고 이후 이벤트는 ajax로 처리
 *
 * 이 페이지는 페이지의 DB로딩을 줄이기 위해 /product/codi_list.php 에 접속할때 "코디탑텐 평가순위" 리스트 부분을
 * html파일(/tpl/sub/cache_codi_rank_list.tpl)을 만드는 부분이다.
 * 이후 해당 링크 클릭시 ajax(/product/ajax_codi_rank_sub_list.php)로 처리된다.
 * 따라서 로직은 동일하다.
 * 단, 여기선 카테고리($categ) 정보는 없고, 기간종류($term)은 "weekly"를 기본으로 한다.
 * tpl 파일의 갱신주기는 1시간이다.
 *******************************************************/
require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$term = "weekly";
$categ = "";

if ( !$page ) $page = 1;

$ret_arr = getWeekDay("last", time());

$f_date = $ret_arr[0];
$l_date = $ret_arr[1];

$t_arr = explode("-", $f_date);
$arr_prev = getWeekDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
// 기준날짜의 다음날짜
$arr_next = getWeekDay("next", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

// 대당 월/주의 첫날과 마지막날
$this_w_first = $f_date;
$this_w_last = $l_date;
$tt_arr = getMonthDay("current", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
$this_m_first = $tt_arr[0];
$this_m_last = $tt_arr[1];


$f_date_detail = $f_date." 00:00:00";
$l_date_detail = $l_date." 23:59:59";

$str = "";
$str .= "
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td>
		<table width='645' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='6' bgcolor='FF5B5C'></td>
			</tr>
			<tr>
				<td height='27'>
				<table width='645' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td align='center'><img src='/img/title01.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='100' align='center'><img src='/img/title45.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='100' align='center'><img src='/img/title03.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='70' align='center'><img src='/img/title07.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='70' align='center'><img src='/img/title08.gif' width='70' height='20'></td>
						<td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='70' align='center'><img src='/img/title09.gif' width='70' height='20'></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td height='1' bgcolor='FF5B5C'></td>
			</tr>
		</table>

		<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>
";


$cond = "";
$cond = " and A.p_idx = C.p_idx and A.shop_idx = B.shop_idx and A.p_judgment != 'R' and C.rp_rank > 10 ";
$orderby = " order by C.rp_score desc, A.p_reg_dt asc ";


$cond .= " and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date' ";
$detail_cond = " and p_u_reg_dt between '$f_date_detail' and '$l_date_detail' ";

$sql = "select count(*) from tblProduct A, tblShop B, tblRankProduct C where 1 $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$sql = "
select A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.shop_idx, B.mem_id, B.shop_url, B.shop_name, B.shop_medal, C.rp_score, C.rp_rank, C.rpc_rank, C.rp_total_score, C.rp_total_rank, C.rpc_total_rank,
(select end_dt from tblProductEach where p_idx=A.p_idx order by p_e_idx desc limit 1) as end_dt,
(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_val > 0 $detail_cond ) as up_cnt
from tblProduct A, tblShop B, tblRankProduct C
where 1 $cond $orderby limit $first, $PAGE_SIZE
";


//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$p_idx = trim($row['p_idx']);
	$p_title = strip_str(trim($row['p_title']));
	$p_main_img = trim($row['p_main_img']);
	$p_top10_num = trim($row['p_top10_num']);
	$s_shop_mem_id = trim($row['mem_id']);
	$shop_idx = trim($row['shop_idx']);
	$shop_url = trim($row['shop_url']);
	$s_shop_name = trim($row['shop_name']);
	$shop_medal = trim($row['shop_medal']);
	$up_cnt = trim($row['up_cnt']);
	$rp_score = trim($row['rp_score']);
	$rp_rank = trim($row['rp_rank']);
	$rpc_rank = trim($row['rpc_rank']);
	$rp_total_score = trim($row['rp_total_score']);
	$rp_total_rank = trim($row['rp_total_rank']);
	$rpc_total_rank = trim($row['rpc_total_rank']);
	$end_dt = trim($row['end_dt']);

	$end_dt = str_replace("-",".",substr($end_dt,0,10)	);

	// 인증샵 마크
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0'>";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	// 베스트 코디 마크
	if ( $p_top10_num > 0 ) {
		$codi_mark = "<img src='/img_seri/icon_bestshop2.gif' align='absmiddle'>";
	} else {
		$codi_mark = "&nbsp;";
	}

	$p_title = strip_str($p_title);
	$p_main_img = $UP_URL."/thumb/".$p_main_img;

	$prt_rank = $rp_rank;

	$param_show = $param_hide = "";
	for ( $j=1; $j<=$PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_list_$j','','$sh',";
		$param_hide .= "'shopview_list_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);

	$str .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='100'>
			<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
				<tr>
					<td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='95' height='95' border='0'></a></td>
				</tr>
			</table>
			</td>
			<td style='padding-left:5;padding-right:8' class='evmem'>
			$codi_mark
			<table width='100' height='7' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td></td>
				</tr>
			</table>
			<a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a>
			</td>
			<td width='103' align='center'>$end_dt</td>
			<td width='103' align='center' class='shopname'><a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$s_shop_name</a>
	";

	// 샵 정보 레이어
	$str .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $prt_rank, $shop_url, $s_shop_name, $s_shop_mem_id, $param_hide);
			
	$str .= "
				$shop_medal_mark
			</td>
			<td width='74' align='center' >$up_cnt</td>
			<td width='72' align='center'><font color='FF5D5E'>$rp_total_score</font></td>
			<td width='72' align='center'><font color='9E6ED1'><b>$rp_rank</b></font></td>
		</tr>
	</table>

	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height='1' bgcolor='E9E9E9'></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	";

	
	$cnt++;
}	// while


$str .= "
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height='6' bgcolor='FF5B5C'></td>
			</tr>
		</table>


		<table width='100' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>

		<table width='100%' height='45' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td align='center'>
";

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

// 페이징(categ, term, f_date, key, kwd, page)
$str .= ajax_codi_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadCodiRankSubList", $categ, $term, $f_date, $key, $kwd);

$str .= "
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
";

$mainconn->close();

echo $str;
?>
