<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_weekly_codi_top10.php
 * date   : 2008.10.23
 * desc   : 분류별 랭킹 top 10
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";
$mainconn->open();

$prt_today = date("Y년 n월 j일", time());
$ret_arr = getWeekDay("last", time());

$f_date = $ret_arr[0];
$l_date = $ret_arr[1];

$sql = "select count(*) from tblRankProduct where rp_start_dt = '$f_date' and rp_end_dt = '$l_date'";
$record_cnt = $mainconn->count($sql);

if ( $record_cnt == 0 ) {
	$ret_arr = getWeekDay("last", time()-86400);
	$f_date = $ret_arr[0];
	$l_date = $ret_arr[1];
}

$f_date_detail = $f_date." 00:00:00";
$l_date_detail = $l_date." 23:59:59";

$prt_f_y = substr($f_date,0,4);
$prt_f_m = substr($f_date,5,2); $prt_f_m = ( substr($prt_f_m,0,1) == "0" ) ? substr($prt_f_m,-1) : $prt_f_m;
$prt_f_d = substr($f_date,8,2); $prt_f_d = ( substr($prt_f_d,0,1) == "0" ) ? substr($prt_f_d,-1) : $prt_f_d;
$prt_l_y = substr($l_date,0,4);
$prt_l_m = substr($l_date,5,2); $prt_l_m = ( substr($prt_l_m,0,1) == "0" ) ? substr($prt_l_m,-1) : $prt_l_m;
$prt_l_d = substr($l_date,8,2); $prt_l_d = ( substr($prt_l_d,0,1) == "0" ) ? substr($prt_l_d,-1) : $prt_l_d;

$str = "
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='375'><img src='" . __HTTPURL__  . "/img/title_top10.gif' width='374' height='31'></td>
		<td align='right' class='date'><img src='" . __HTTPURL__  . "/img/icon_calender.gif' width='17' height='14' align='absmiddle'><a href='#' onClick='total_codi_ranking();'><font color='945D5D'>{$prt_f_y}년 {$prt_f_m}월 {$prt_f_d}일 ~ {$prt_l_y}년 {$prt_l_m}월 {$prt_l_d}일</font></a> </td>
	</tr>
</table>
";
 
foreach ( $P_CATEG as $k => $v ) {
	if ( $k == "T" ) {
		$ct_img = "top10_tap_ov_T.gif"; $cb_img = "top10_tap_B.gif"; $co_img = "top10_tap_O.gif"; $cu_img = "top10_tap_U.gif"; $ca_img = "top10_tap_A.gif";
	} else if ( $k == "B" ) {
		$ct_img = "top10_tap_T.gif"; $cb_img = "top10_tap_ov_B.gif"; $co_img = "top10_tap_O.gif"; $cu_img = "top10_tap_U.gif"; $ca_img = "top10_tap_A.gif";
	} else if ( $k == "O" ) {
		$ct_img = "top10_tap_T.gif"; $cb_img = "top10_tap_B.gif"; $co_img = "top10_tap_ov_O.gif"; $cu_img = "top10_tap_U.gif"; $ca_img = "top10_tap_A.gif";
	} else if ( $k == "U" ) {
		$ct_img = "top10_tap_T.gif"; $cb_img = "top10_tap_B.gif"; $co_img = "top10_tap_O.gif"; $cu_img = "top10_tap_ov_U.gif"; $ca_img = "top10_tap_A.gif";
	} else {
		$ct_img = "top10_tap_T.gif"; $cb_img = "top10_tap_B.gif"; $co_img = "top10_tap_O.gif"; $cu_img = "top10_tap_U.gif"; $ca_img = "top10_tap_ov_A.gif";
	}

	// 카테고리별 총 등록코디 갯수를 구한다.
	$sql2 = "select count(*) from tblProduct where p_categ = '$k' and p_judgment != 'R'";
	$categ_cnt = $mainconn->count($sql2);

	//echo "sql2 : $sql2 <p>";

	$str .= "
	<div id='categ_{$k}_area' style='display:none;'>
	<table width='645' height='48' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td><a href=\"javascript:chg_main_categ('T');\"><img src='" . __HTTPURL__  . "/images/{$ct_img}' width='113' height='48' alt='' border='0' /></a></td>
			<td><a href=\"javascript:chg_main_categ('B');\"><img src='" . __HTTPURL__  . "/images/{$cb_img}' width='110' height='48' alt='' border='0' /></a></td>
			<td><a href=\"javascript:chg_main_categ('O');\"><img src='" . __HTTPURL__  . "/images/{$co_img}' width='145' height='48' alt='' border='0' /></a></td>
			<td><a href=\"javascript:chg_main_categ('U');\"><img src='" . __HTTPURL__  . "/images/{$cu_img}' width='166' height='48' alt='' border='0' /></a></td>
			<td><a href=\"javascript:chg_main_categ('A');\"><img src='" . __HTTPURL__  . "/images/{$ca_img}' width='111' height='48' alt='' border='0' /></a></td>
		</tr>
	</table>
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='6' height='350' background='/img/bar_sero_02.gif'>&nbsp;</td>
			<td align='right' valign='top'><br>
			<table width='639' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='20' align='center' valign='bottom' >
					<table width='100%' height='50' border='0' cellpadding='0' cellspacing='0' bgcolor='FEB7B7'>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					</td>
	";


	// 전주 카테고리별 등록코디 갯수를 구한다.
	$codi_categ_cnt = 0;
	$sql3 = "
	select count(*) 
	from tblProduct A, tblShop B, tblRankProduct C
	where 1
	and A.p_idx = C.p_idx
	and A.shop_idx = B.shop_idx
	and C.p_categ = '$k'
	and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date'
	order by C.rpc_rank asc
	limit 10
	";
	$codi_categ_cnt = $mainconn->count($sql3);

	// tblProduct, tblShop, tblRankProduct
	// 지난주 인기있었던 코디 10개를 추출한다 (상의,하의,아웃웨어,언더웨어,악세사리 한꺼번에)
	$sql = "
	select A.p_idx, A.p_title, A.p_main_img, A.shop_idx, B.shop_name, C.rp_score, C.rpc_rank,
	(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_reg_dt between '$f_date_detail' and '$l_date_detail') as up_cnt
	from tblProduct A, tblShop B, tblRankProduct C
	where 1
	and A.p_idx = C.p_idx
	and A.shop_idx = B.shop_idx
	and C.p_categ = '$k'
	and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date'
	order by C.rpc_rank asc
	limit 10
	";

	//echo "main_sql : $sql <p>";

	$res = $mainconn->query($sql);
	$cnt = 1;
	while ( $row = $mainconn->fetch($res) ) {
		$p_idx = trim($row['p_idx']);
		$p_title = strip_str(trim($row['p_title']));
		$p_main_img = trim($row['p_main_img']);
		$shop_idx = trim($row['shop_idx']);
		$shop_name = trim($row['shop_name']);
		$rp_score = trim($row['rp_score']);
		$rpc_rank = trim($row['rpc_rank']);
		$up_cnt = trim($row['up_cnt']);
		$p_main_img = $UP_URL."/thumb/".$p_main_img;
		


		if ( $cnt == 1 ) {
			$p_title = cutStringHan($p_title, 60);
			if ( strlen($p_title) < 30 ) $p_title .= "<br>&nbsp;";
			$str .= "
			<td width='160' valign='top'>
			<table width='160' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td><img src='" . __HTTPURL__  . "/img/title_ranking1.jpg' width='160' height='35'></td>
				</tr>
				<tr>
					<td height='6'></td>
				</tr>
				<tr>
					<td><a href='#' onClick=\"codi_view('$p_idx');\"><img src='" . __HTTPURL__  . "$p_main_img' width='160' height='160' border='0'></a></td>
				</tr>
				
				<tr>
					<td height='6'></td>
				</tr>
				<tr>
					<td class='evmem'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
				</tr>
				
				<tr>
					<td height='8'></td>
				</tr>
					
				<tr>
					<td height='18' class='shopname'><img src='" . __HTTPURL__  . "/img/icon_shop.gif'  align='absmiddle' /> <b><a href='#' onClick=\"shop_view('$shop_idx');\">$shop_name</a> </b></td>
				</tr>
				<tr>
					<td height='18' class='evfont'><span class='shopname'><img src='" . __HTTPURL__  . "/img/icon_score.gif'  align='absmiddle' /> <b>$rp_score 점 </b></span></td>
				</tr>
				<tr>
					<td height='18'  class='evfont'><span class='shopname'><img src='" . __HTTPURL__  . "/img/icon_codi.gif'  align='absmiddle' /> <b><font color='#CC3300'>$up_cnt</font></b></span></td>
				</tr>
			</table>

			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='26'>&nbsp;</td>
				</tr>
			</table>

			<table width='100%' height='50' border='0' cellpadding='0' cellspacing='0' bgcolor='FEB7B7'>
				<tr>
					<td><font color='#000000' class='date'>$prt_today 기준</font><br><b><font color='#CC0000'>총 등록코디 : <font size='3'>".number_format($categ_cnt)."</font> </font></b></td>
				</tr>
			</table>
			</td>
			";
		} else {
			$p_title = cutStringHan($p_title, 20);
			if ( $cnt == 2 ) {
				$str .= "
				<td align='center' valign='top'>
				<table width='1' height='310' border='0' cellpadding='0' cellspacing='0' background='/img/dot_sero_max.gif'>
					<tr>
						<td width='1'></td>
					</tr>
				</table>
				</td>
				<td width='427' valign='top'>
				<table width='427' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td><img src='" . __HTTPURL__  . "/img/title_2_6.gif' width='427' height='25'></td>
					</tr>
				</table>

				<table border='0' cellspacing='0' cellpadding='0'>
					<tr>
				";
			} else if ( $cnt == 7 ) {
				$str .= "
					</tr>
				</table>

				<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td></td>
					</tr>
				</table>

				<table width='427' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td><img src='" . __HTTPURL__  . "/img/title_7_10.gif' width='427' height='25'></td>
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
					<td height='8'></td>
				</tr>
				<tr>
					<td><a href='#' onClick=\"codi_view('$p_idx');\"><img src='" . __HTTPURL__  . "$p_main_img' width='70' height='70' border='0'></a></td>
				</tr>
				<tr>
					<td height='4'></td>
				</tr>
				<tr>
					<td  class='evmem'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
				</tr>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
					<table width='100%' border='0' cellpadding='2' cellspacing='1' bgcolor='D9D9D9'>
						<tr>
							<td align='right' bgcolor='#FFFFFF'  class='shopname'><b><a href='#' onClick=\"shop_view('$shop_idx');\">$shop_name</a></b></td>
						</tr>
						<tr>
							<td align='right' bgcolor='#FFFFFF' class='evfont'>$rp_score 점 </td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</td>
			";


		}	// 1위가 아닐때
		
		$cnt++;
	}	// while 끝

	
	// 비어있는거 집어넣기
	for ( $i=$cnt; $i<11; $i++ ) {
		if ( $i == 7 ) {
			$str .= "
				</tr>
			</table>

			<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td></td>
				</tr>
			</table>

			<table width='427' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td><img src='" . __HTTPURL__  . "/img/title_7_10.gif' width='427' height='25'></td>
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
				<td height='8'></td>
			</tr>
			<tr>
				<td><img src='" . __HTTPURL__  . "/img/photo_no2.gif' width='70' height='70' border='0'></td>
			</tr>
			<tr>
				<td height='4'></td>
			</tr>
			<tr>
				<td  class='evmem'>해당 코디가 없습니다.</td>
			</tr>
			<tr>
				<td height='5'></td>
			</tr>
			<tr>
				<td>
				<table width='100%' border='0' cellpadding='2' cellspacing='1' bgcolor='D9D9D9'>
					<tr>
						<td align='right' bgcolor='#FFFFFF'  class='shopname'><b>&nbsp;</b></td>
					</tr>
					<tr>
						<td align='right' bgcolor='#FFFFFF' class='evfont'>0 점 </td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
		";
	} //  비어있는거 집어넣기 for 종료


	if ( $codi_categ_cnt > 0 ) {
		$str .= "
								<td width='85' align='center' valign='middle'><a href='#' onClick=\"total_codi_ranking();\"><img src='" . __HTTPURL__  . "/img/btn_gotop10.gif' width='70' height='142' border='0'></a></td>
							</tr>
						</table>

						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
		";
	}
	else {
		$str .= "
								<td width='85' align='center' valign='middle'><a href='#' onClick=\"total_codi_ranking();\"><img src='" . __HTTPURL__  . "/img/btn_gotop10.gif' width='70' height='142' border='0'></a></td>
							</tr>
						</table>

						</td>
					</tr>
				</table>
		</div>
		";
	}

}	// foreach 종료

// 전체 카테고리를 위해 ..
$str .= "<div id='categ__area' style='display:none;'></div>";

$str .= "<script>chg_main_categ(g_categ);</script>";




$mainconn->close();


echo $str;
?>