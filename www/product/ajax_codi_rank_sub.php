<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_codi_rank_sub.php
 * date   : 2009.01.13
 * desc   : 코디평가순위 ajax 처리
 *
 * 이 페이지는 페이지의 DB로딩을 줄이기 위해 /product/codi_list.php 에 접속할때 "코디탑텐 평가순위" 부분을
 * html파일(/tpl/sub/cache_codi_rank.tpl)로 만들려고 했으나 카테고리병,기간별 페이지량이 많아서 DB로딩 작업
 * 에도 불구하고 ajax 방식의 DB로 처리했다. 
 * 로직은 /proc/make_codi_rank.php와 동일하지만 $term, $categ, $key, $kwd 값이 수시로 변할 수 있다고 가정한다.
 * $term 값이 있고없고에 따라서 Query 와 변수에 변화가 생긴다. 이를 유심히 체크한다.
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$categ	= trim($_REQUEST['categ']);
$term	= trim($_REQUEST['term']);
$f_date	= trim($_REQUEST['f_date']);
$key	= trim($_REQUEST['key']);
$kwd	= trim($_REQUEST['kwd']);

//echo $f_date."========<br>";
// 기준날짜를 구한다.
if ( $term == "weekly" ) {
	$l_date = getLastDay($f_date, "W");
	// 기준날짜의 이전날짜
	$t_arr = explode("-", $f_date);
	$arr_prev = getWeekDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
	// 기준날짜의 다음날짜
	$arr_next = getWeekDay("next", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

	// 대당 월/주의 첫날과 마지막날
	$this_w_first = $f_date;
	$this_w_last = $l_date;
	$tt_arr = getMonthDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
	$this_m_first = $tt_arr[0];
	$this_m_last = $tt_arr[1];

	$term_tab_1 = "tap_codi_ov_01.gif";
	$term_tab_2 = "tap_codi_02.gif";
	$term_tab_3 = "tap_codi_03.gif";

} else if ( $term == "monthly" ) {
	$l_date = getLastDay($f_date, "M");
	$t_arr = explode("-", $f_date);
	$stamp = mktime(0,0,0, $t_arr[1],$t_arr[2],$t_arr[0]);
	$arr_prev = getMonthDay("last", $stamp);
	$arr_next = getMonthDay("next", $stamp);

	// 대당 월/주의 첫날과 마지막날
	$tt_arr = getWeekDay("last", time());
	$this_w_first = $tt_arr[0];
	$this_w_last = $tt_arr[1];
	$this_m_first = $f_date;
	$this_m_last = $l_date;

	$term_tab_1 = "tap_codi_01.gif";
	$term_tab_2 = "tap_codi_ov_02.gif";
	$term_tab_3 = "tap_codi_03.gif";

} else {
	$tt_arr = getWeekDay("last", time());
	$f_date = $tt_arr[0];
	$l_date = $tt_arr[1];
	
	$t_arr = explode("-", $f_date);
	$arr_prev = getWeekDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
	$arr_next = getWeekDay("next", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

	// 대당 월/주의 첫날과 마지막날
	$this_w_first = $f_date;
	$this_w_last = $l_date;
	$tt_arr = getMonthDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
	$this_m_first = $tt_arr[0];
	$this_m_last = $tt_arr[1];

	$term_tab_1 = "tap_codi_01.gif";
	$term_tab_2 = "tap_codi_02.gif";
	$term_tab_3 = "tap_codi_ov_03.gif";
}

// 이전, 이후
$ptr_prev_first = $arr_prev[0];
$ptr_prev_last = $arr_prev[1];
$ptr_next_first = $arr_next[0];
$ptr_next_last = $arr_next[1];


$f_date_detail = $f_date." 00:00:00";
$l_date_detail = $l_date." 23:59:59";

switch ( $categ ) {
	case "T" :
		$ct_img = "ov_top10_codi_T.gif"; $cb_img = "top10_codi_B.gif"; $co_img = "top10_codi_O.gif"; $cu_img = "top10_codi_U.gif"; $ca_img = "top10_codi_A.gif"; $c_img = "top10_codi_.gif";
		break;
	case "B" :
		$ct_img = "top10_codi_T.gif"; $cb_img = "ov_top10_codi_B.gif"; $co_img = "top10_codi_O.gif"; $cu_img = "top10_codi_U.gif"; $ca_img = "top10_codi_A.gif"; $c_img = "top10_codi_.gif";
		break;
	case "O" :
		$ct_img = "top10_codi_T.gif"; $cb_img = "top10_codi_B.gif"; $co_img = "ov_top10_codi_O.gif"; $cu_img = "top10_codi_U.gif"; $ca_img = "top10_codi_A.gif"; $c_img = "top10_codi_.gif";
		break;
	case "U" :
		$ct_img = "top10_codi_T.gif"; $cb_img = "top10_codi_B.gif"; $co_img = "top10_codi_O.gif"; $cu_img = "ov_top10_codi_U.gif"; $ca_img = "top10_codi_A.gif"; $c_img = "top10_codi_.gif";
		break;
	case "A" :
		$ct_img = "top10_codi_T.gif"; $cb_img = "top10_codi_B.gif"; $co_img = "top10_codi_O.gif"; $cu_img = "top10_codi_U.gif"; $ca_img = "ov_top10_codi_A.gif"; $c_img = "top10_codi_.gif";
		break;
	default :
		$ct_img = "top10_codi_T.gif"; $cb_img = "top10_codi_B.gif"; $co_img = "top10_codi_O.gif"; $cu_img = "top10_codi_U.gif"; $ca_img = "top10_codi_A.gif"; $c_img = "ov_top10_codi_.gif";
		break;
}

$str = "";
$str .= "
<table width='645' border='0' cellpadding='0' cellspacing='3' bgcolor='EBEBEB'>
  <tr>
	<td bgcolor='C8C8C8' style='padding:1 1 1 1'><table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
		<tr>
		  <td style='padding:15 15 15 15'><table width='100%' border='0' cellspacing='0' cellpadding='0' style='border:1 dotted #BFBFBF;'>
			  <tr>
				<td style='padding:10 10 10 10' class='intext'><img src='/img/icon_book.gif' width='14' height='15'  align='absmiddle' /> <b><font color='#00CC33'><u>베스트 코디 </u></font></b> : 코디탑텐에서 회원님들께 높은 평가를 받은 <b><font color='#FF5C5C'><u>코디상품들의 순위</u></font></b>를 확인하실 수 있습니다. 어떤 상품이 <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;좋은 상품인지, 요즘 잘나가는 상품은 어떤 것인지 확인해보세요.</td>
			  </tr>
		  </table></td>
		</tr>
	</table></td>
  </tr>
</table>

<table width='100' height='16' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td></td>
	</tr>
</table>

<table width='645' height='48' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td><a href='#' onClick=\"loadCodiRankSub('','$term','$f_date','','');\"><img src='/img/$c_img' width='113' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCodiRankSub('T','$term','$f_date','','');\"><img src='/img/$ct_img' width='87' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCodiRankSub('B','$term','$f_date','','');\"><img src='/img/$cb_img' width='89' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCodiRankSub('O','$term','$f_date','','');\"><img src='/img/$co_img' width='130' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCodiRankSub('U','$term','$f_date','','');\"><img src='/img/$cu_img' width='133' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCodiRankSub('A','$term','$f_date','','');\"><img src='/img/$ca_img' width='93' height='48' border='0'></a></td>
	</tr>
</table>

<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td></td>
	</tr>
</table>

<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='129'><a href='#' onClick=\"loadCodiRankSub('$categ','weekly','$this_w_first','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image52','','/img/tap_codi_ov_01.gif',1);\"><img src='/img/{$term_tab_1}' name='Image52' width='129' height='30' border='0' id='Image52' /></a></td>
		<td width='130'><a href='#' onClick=\"loadCodiRankSub('$categ','monthly','$this_m_first','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image53','','/img/tap_codi_ov_02.gif',1);\"><img src='/img/{$term_tab_2}' name='Image53' width='131' height='30' border='0' id='Image53' /></a></td>
		<td width='130'><a href='#' onClick=\"loadCodiRankSub('$categ','','','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image54','','/img/tap_codi_ov_03.gif',1);\"><img src='/img/{$term_tab_3}' name='Image54' width='131' height='30' border='0' id='Image54' /></a></td>
		<td align='right' background='/img/tap_04.gif'>&nbsp;
";

/* 지금은 없애고 나중에 달력으로 대체
if ( $term ) {
	$str .= "
		<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='62'><a href='#' onClick=\"loadCodiRankSub('$categ','$term','$ptr_prev_first','$key','$kwd');\"><!--<img src='/img/btn_a01.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$ptr_prev_first)."<br>".str_replace("-",".",$ptr_prev_last)."</font></a></td>
				<td width='62'><a href='#' onClick=\"loadCodiRankSub('$categ','$term','$f_date','$key','$kwd');\"><!--<img src='/img/btn_a03.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$f_date)."<br>".str_replace("-",".",$l_date)."</font></a></td>
				<td><a href='#' onClick=\"loadCodiRankSub('$categ','$term','$ptr_next_first','$key','$kwd');\"><!--<img src='/img/btn_a02.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$ptr_next_first)."<br>".str_replace("-",".",$ptr_next_last)."</font></a></td>
			</tr>
		</table>
	";
} else {
	$str .= "&nbsp;";
}
*/

$str .= "
		</td>
	</tr>
</table>
";

$cond = "";
$cond = " and A.p_idx = C.p_idx and A.shop_idx = B.shop_idx and A.p_judgment != 'R' ";
$orderby = " order by C.rp_score desc, A.p_reg_dt asc ";

if ( $categ ) {
	$cond .= " and A.p_categ = '$categ' ";
}

// 주간 또는 월간일때
if ( $term ) {
	// 가장 최근 통계낸 날짜를 표시하기 위해서 기간의 마지막 날을 구한다.
	$t_arr = explode("-", $l_date);
	$prt_recent = date("Y년 n월 j일", mktime(1,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

	$cond .= " and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date' ";
	$detail_cond = " and p_u_reg_dt between '$f_date_detail' and '$l_date_detail' ";

	$sql = "select count(*) from tblProduct A, tblShop B, tblRankProduct C where 1 $cond ";
	$record_cnt = $mainconn->count($sql);

	$sql = "
	select A.p_idx, A.p_title, A.p_main_img, A.shop_idx, B.mem_id, B.shop_url, B.shop_name, B.shop_medal, C.rp_score, C.rp_rank, C.rpc_rank, C.rp_total_score, C.rp_total_rank, C.rpc_total_rank,
	(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_val > 0 $detail_cond ) as up_cnt
	from tblProduct A, tblShop B, tblRankProduct C
	where 1 $cond $orderby limit 10
	";
} else {
	$sql = "select rp_start_dt, rp_end_dt from tblRankProduct order by rp_idx desc limit 1 ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row ) {
		$t_rp_start_dt = $row['rp_start_dt'];
		$t_rp_end_dt = $row['rp_end_dt'];

		// 가장 최근 통계낸 날짜를 표시하기 위해서 기간의 마지막 날을 구한다.
		$t_arr = explode("-", $t_rp_end_dt);
		$prt_recent = date("Y년 n월 j일", mktime(1,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

		$noterm_orderby = " order by C.rp_total_score desc ";
		$noterm_cond = " and A.p_idx = C.p_idx and A.shop_idx = B.shop_idx and A.p_judgment != 'R' and C.rp_start_dt = '$t_rp_start_dt' and C.rp_end_dt = '$t_rp_end_dt' ";
		if ( $categ ) {
			$noterm_cond .= " and A.p_categ = '$categ' ";
		}

		$sql = "select count(*) from tblProduct A, tblShop B, tblRankProduct C where 1 $noterm_cond ";
		$record_cnt = $mainconn->count($sql);

		$sql = "
		SELECT A.p_idx, A.p_title, A.p_main_img, A.shop_idx, B.mem_id, B.shop_url, B.shop_name, B.shop_medal, C.rp_score, C.rp_rank, C.rpc_rank, C.rp_total_score, C.rp_total_rank, C.rpc_total_rank,
		(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_val > 0) as up_cnt
		from tblProduct A, tblShop B, tblRankProduct C
		where 1 $noterm_cond $noterm_orderby limit 10
		";
	}

}

//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$p_idx = trim($row['p_idx']);
	$p_title = strip_str(trim($row['p_title']));
	//$p_title = cutStringHan($p_title, 25);
	$p_main_img = trim($row['p_main_img']);
	$shop_mem_id = trim($row['mem_id']);
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

	$p_main_img = $UP_URL."/thumb/".$p_main_img;

	if ( $term && !$categ ) {	// 주간/월간 이면서 카테고리없이 전체
		$prt_rank = $rp_rank;
		$prt_score = $rp_score;
	} else if ( $term && $categ ) {	// 주간/월간 이면서 카테고리 있을때
		$prt_rank = $rpc_rank;
		$prt_score = $rp_score;
	} else if ( !$term && $categ ) {	// 기간없이 카테고리 있을때
		$prt_rank = $rpc_total_rank;
		$prt_score = $rp_total_score;
	} else {	// 기간없고 카테고리 없을때
		$prt_rank = $rp_total_rank;
		$prt_score = $rp_total_score;
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=10; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_$j','','$sh',";
		$param_hide .= "'shopview_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);

	if ( $cnt == 1 ) {
		if ( $shop_medal == "Y" ) {
			$shop_medal_mark = "<img src='/img_seri/icon_ks_mini.gif' border='0' align=absmiddle />";
		} else {
			$shop_medal_mark = "&nbsp;";
		}
		
		$p_title = cutStringHan($p_title, 50);

		$str .= "
		<table width='645' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='1' rowspan='2' background='/img/dot02.gif'></td>
				<td style='padding:13 13 13 13'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='175' align='center'>
						<table width='160' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td><img src='/img/title_ranking1.jpg' width='160' height='35' /></td>
							</tr>
							<tr>
								<td height='6'></td>
							</tr>
							<tr>
								<td><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='160' height='160' border='0' /></a></td>
							</tr>
							<tr>
								<td height='6'></td>
							</tr>
							<tr>
								<td class='evmem'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
							</tr>
						</table>
						<table border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td height='8'></td>
							</tr>
							<tr>
								<td height='18' class='shopname'><img src='/img/icon_shop.gif'  align='absmiddle' /> <b><a href='#'  onClick=\"MM_showHideLayers($param_show);\">$s_shop_name</a> $shop_medal_mark</b>
		";

		// 샵 정보 레이어
		$str .= getLayerShopInfo("shopview", $cnt, 2, 1, 125, -85, $prt_rank, $shop_url, $s_shop_name, $shop_mem_id, $param_hide);

		$str .= "
								</td>
							</tr>
							<tr>
								<td height='18' class='evfont'><span class='shopname'><img src='/img/icon_score.gif'  align='absmiddle' /> <b>$prt_score 점 </b></span></td>
							</tr>
							<tr>
								<td height='18'  class='evfont'><span class='shopname'><img src='/img/icon_codi.gif'  align='absmiddle' /> <b><font color='#CC3300'>$up_cnt</font></b></span></td>
							</tr>
						</table>
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td height='9'></td>
							</tr>
						</table>
						<table width='100%' height='50' border='0' cellpadding='0' cellspacing='1' bgcolor='#FF3366'>
							<tr>
								<td align='center' bgcolor='FEB7B7'><font color='#000000' class='date'>$prt_recent 기준</font><br /><b><font color='#CC0000'>총 등록코디 : <font size='3'>".number_format($record_cnt)."</font> </font></b></td>
							</tr>
						</table>
						</td>
						<td width='10'>&nbsp;</td>
						<td width='1' bgcolor='#CCCCCC'></td>
						<td width='15'>&nbsp;</td>
						<td valign='middle'>
						<table width='427' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td><img src='/img/title_2_6.gif' width='427' height='25' /></td>
							</tr>
						</table>
						<table border='0' cellspacing='0' cellpadding='0'>
							<tr>
		";
	} else {
		$p_title = cutStringHan($p_title, 25);
		if ( $cnt == 7 ) {
			$str .= "
				</tr>
			</table>
			<table width='100' height='12' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td></td>
				</tr>
			</table>
			<table width='427' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td><img src='/img/title_7_10.gif' width='427' height='25' /></td>
				</tr>
			</table>
			<table border='0' cellspacing='0' cellpadding='0'>
				<tr>
			";
		}

		if ( $shop_medal == "Y" ) {
			$auth_td = "<td width='20' rowspan='2' valign='top' bgcolor='#FFFFFF' class='shopname'><img src='/img_seri/icon_ks_mini.gif' border='0' align=absmiddle /></td>";
		} else {
			$auth_td = "<td width='2' rowspan='2' valign='top' bgcolor='#FFFFFF' class='shopname'>&nbsp;</td>";
		}

		$str .= "
		<td width='85' align='center' valign='top'>
		<table width='70' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='6' ></td>
			</tr>
			<tr>
				<td><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='70' height='70' border='0' /></a></td>
			</tr>
			<tr>
				<td height='4'></td>
			</tr>
			<tr>
				<td  class='evmem'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
			</tr>
			<tr>
				<td height='20' align='center'  class='date'>
				<table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='D9D9D9'>
					<tr>
						$auth_td
						<td align='right' bgcolor='#FFFFFF' class='shopname'><b><a href='#' onClick=\"MM_showHideLayers($param_show);\"><span  style='cursor:hand;'>$s_shop_name</span></a></b>
		";

		// 샵 정보 레이어
		$str .= getLayerShopInfo("shopview", $cnt, 2, 1, 1, -85, $prt_rank, $shop_url, $s_shop_name, $shop_mem_id, $param_hide);

		$str .= "
						</td>
					</tr>
					<tr>
						<td align='right' bgcolor='#FFFFFF' class='evfont'>$prt_score 점</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
		";

	}

	$cnt++;
}	// while

// 결과값이 없으면 종료한다.
if ( $cnt == 1 ) {
	$str .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td height='30' align='center'>랭크된 코디가 없습니다.</td>
		</tr>
	</table>
	";
	$mainconn->close();
	echo $str;
	exit;
}

// 비어있는거 집어넣기
for ( $i=$cnt; $i<11; $i++ ) {
	if ( $i == 7 ) {
		$str .= "
			</tr>
		</table>
		<table width='100' height='12' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>
		<table width='427' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td><img src='/img/title_7_10.gif' width='427' height='25' /></td>
			</tr>
		</table>
		<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
		";
	}

	$str .= "
		<td width='85' align='center' valign='top'>
		<table width='70' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='6' ></td>
			</tr>
			<tr>
				<td><img src='/img/photo_no.gif' width='70' height='70' border='0' /></td>
			</tr>
			<tr>
				<td height='4'></td>
			</tr>
			<tr>
				<td  class='evmem'>해당 코디가 없습니다.</td>
			</tr>
			<tr>
				<td height='20' align='center'  class='date'>
				<table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='D9D9D9'>
					<tr>
						<td width='2' rowspan='2' valign='top' bgcolor='#FFFFFF' class='shopname'>&nbsp;</td>
						<td align='right' bgcolor='#FFFFFF' class='shopname'>&nbsp;</td>
				</tr>
				<tr>
					<td align='right' bgcolor='#FFFFFF' class='evfont'>0 점</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</td>
	";
}

$str .= "
						<td width='85' align='center' valign='top'><a href='#' onClick='go_best_shop();'><img src='/img/btn_gotop_best.gif' width='70' height='142' border='0' /></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
		<td width='1' rowspan='2' background='/img/dot02.gif'></td>
	</tr>
	<tr>
		<td height='1' background='/img/dot01.gif'></td>
	</tr>
</table>
";

$mainconn->close();

echo $str;
?>
