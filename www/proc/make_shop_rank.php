<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_shop_rank.php
 * date   : 2009.01.15
 * desc   : 코디탑텐 샵랭킹 html 생성(1시간마다)
 *			메인 페이지만 html로 만들고 이후 이벤트는 ajax로 처리
 *
 * 이 페이지는 페이지의 DB로딩을 줄이기 위해 /product/best_shop_list.php 에 접속할때 "샵 평가순위" 부분을
 * html파일(/tpl/sub/cache_shop_rank.tpl)을 만드는 부분이다.
 * 이후 해당 링크 클릭시 ajax(/product/ajax_shop_rank_sub.php)로 처리된다.
 * 따라서 로직은 동일하다.
 * 단, 여기선 기간종류($term)은 "weekly"를 기본으로 한다.
 * tpl 파일의 갱신주기는 1시간이다.
 *******************************************************/
require_once "../inc/common.inc.php";
$mainconn->open();

$term = "weekly";

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
$tt_arr = getMonthDay("last", mktime(0,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));
$this_m_first = $tt_arr[0];
$this_m_last = $tt_arr[1];

$term_tab_1 = "tap_codi_ov_01.gif";
$term_tab_2 = "tap_codi_02.gif";
$term_tab_3 = "tap_codi_04.gif";

// 이전, 이후
$ptr_prev_first = $arr_prev[0];
$ptr_prev_last = $arr_prev[1];
$ptr_next_first = $arr_next[0];
$ptr_next_last = $arr_next[1];

// 가장 최근 통계낸 날짜를 표시하기 위해서 기간의 마지막 날을 구한다.
$t_arr = explode("-", $l_date);
$prt_recent = date("Y년 n월 j일", mktime(1,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

$f_date_detail = $f_date." 00:00:00";
$l_date_detail = $l_date." 23:59:59";

$str = "";
$str .= "
<table width='645' border='0' cellpadding='0' cellspacing='3' bgcolor='EBEBEB'>
  <tr>
	<td bgcolor='C8C8C8' style='padding:1 1 1 1'><table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
		<tr>
		  <td style='padding:15 15 15 15'><table width='100%' border='0' cellspacing='0' cellpadding='0' style='border:1 dotted #BFBFBF;'>
			  <tr>
				<td style='padding:10 10 10 10' class='intext'><img src='/img/icon_book.gif' width='14' height='15'  align='absmiddle' /> <b><font color='#00CC33'><u>베스트 샵 </u></font></b> : 코디탑텐에서 회원님들께 높은 평가를 받은 <b><font color='#FF5C5C'><u>샾들의 순위</u></font></b>를 확인하실 수 있습니다. 샾이 등록한 모든 코디들의  <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;평가점수를 기준으로 순위가 결정됩니다.</td>
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

<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='129'><a href='#' onClick=\"loadShopRankSub('weekly','$this_w_first','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image52','','/img/tap_codi_ov_01.gif',1);\"><img src='/img/{$term_tab_1}' name='Image52' width='129' height='30' border='0' id='Image52' /></a></td>
		<td width='130'><a href='#' onClick=\"loadShopRankSub('monthly','$this_m_first','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image53','','/img/tap_codi_ov_02.gif',1);\"><img src='/img/{$term_tab_2}' name='Image53' width='131' height='30' border='0' id='Image53' /></a></td>
		<td width='130'><a href='#' onClick=\"loadShopRankSub('','','$key','$kwd');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image56','','/img/tap_codi_ov_04.gif',1);\"><img src='/img/{$term_tab_3}' name='Image56' width='131' height='30' border='0' id='Image56' /></a></td>
		<td align='right' background='/img/tap_04.gif'>&nbsp;
";

/* 지금은 없애고 나중에 달력으로 대체
if ( $term ) {
	$str .= "
		<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='62'><a href='#' onClick=\"loadShopRankSub('$term','$ptr_prev_first','$key','$kwd');\"><!--<img src='/img/btn_a01.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$ptr_prev_first)."<br>".str_replace("-",".",$ptr_prev_last)."</font></a></td>
				<td width='62'><a href='#' onClick=\"loadShopRankSub('$term','$f_date','$key','$kwd');\"><!--<img src='/img/btn_a03.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$f_date)."<br>".str_replace("-",".",$l_date)."</font></a></td>
				<td><a href='#' onClick=\"loadShopRankSub('$term','$ptr_next_first','$key','$kwd');\"><!--<img src='/img/btn_a02.gif' width='50' height='14' border='0'>--><font size='-2'>".str_replace("-",".",$ptr_next_first)."<br>".str_replace("-",".",$ptr_next_last)."</font></a></td>
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


$cond = " and A.shop_idx = B.shop_idx and A.shop_status = 'Y' and B.rs_start_dt = '$f_date' and B.rs_end_dt = '$l_date' ";
$orderby = " order by B.rs_score desc ";

$sql = "select count(*) from tblShop A, tblRankShop B where 1 $cond ";
$record_cnt = $mainconn->count($sql);

$sql = "
select
A.shop_idx, A.mem_id, A.shop_name, A.shop_url, A.shop_person, A.shop_mobile, A.shop_phone, A.shop_logo, A.shop_medal,
(select count(*) from tblProduct where shop_idx = A.shop_idx and p_judgment != 'R') as codi_cnt,
B.rs_score, B.rs_rank, B.rs_total_score, B.rs_total_rank 
from tblShop A, tblRankShop B
where 1 $cond $orderby limit 10
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$shop_idx = trim($row['shop_idx']);
	$shop_mem_id = trim($row['mem_id']);
	$shop_person = trim($row['shop_person']);
	$shop_url = trim($row['shop_url']);
	$s_shop_name = trim($row['shop_name']);
	$shop_medal = trim($row['shop_medal']);
	$shop_mobile = trim($row['shop_mobile']);
	$shop_phone = trim($row['shop_phone']);
	$shop_logo = trim($row['shop_logo']);
	$codi_cnt = trim($row['codi_cnt']);
	$rs_score = trim($row['rs_score']);
	$rs_rank = trim($row['rs_rank']);
	$rs_total_score = trim($row['rs_total_score']);
	$rs_total_rank = trim($row['rs_total_rank']);

	$shop_logo = $UP_URL."/thumb/".$shop_logo;

	$prt_rank = $rs_rank;
	$prt_score = $rs_score;

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
								<td><a href='#' onClick=\"MM_showHideLayers($param_show);\"><img src='$shop_logo' width='160' height='160' border='0' /></a></td>
							</tr>
							<tr>
								<td height='6'></td>
							</tr>
							<!--
							<tr>
								<td class='evmem'><a href='#'>☆야외 데이트☆ 에 딱 어울리는  스프링 커플 코디</a> </td>
							</tr>
							-->
						</table>

						<table border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td height='8'></td>
							</tr>
							<tr>
								<td height='18' class='shopname'><img src='/img/icon_shop.gif'  align='absmiddle' /> <b><a href='#' onClick=\"MM_showHideLayers($param_show);\">$s_shop_name</a>$shop_medal_mark</b> 
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
								<td height='18'  class='evfont'><span class='shopname'><img src='/img/icon_codi.gif'  align='absmiddle' /> <b><font color='#CC3300'>$codi_cnt</font></b></span></td>
							</tr>
						</table>

						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td height='9'></td>
							</tr>
						</table>
							
						<table width='100%' height='50' border='0' cellpadding='0' cellspacing='1' bgcolor='#FF3366'>
							<tr>
								<td align='center' bgcolor='FEB7B7'><font color='#000000' class='date'>$prt_recent 기준</font><br/><b><font color='#CC0000'>총 등록샵 : <font size='3'>".number_format($record_cnt)."</font> </font></b></td>
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
				<td><a href='#' onClick=\"MM_showHideLayers($param_show);\"><img src='$shop_logo' width='70' height='70' border='0'></a></td>
			</tr>
			<tr>
				<td height='4'></td>
			</tr>
			<tr>
				<td align='center'  class='evmem'>
				<table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='D9D9D9'>
					<tr>
						$auth_td
						<td align='right' bgcolor='#FFFFFF'  class='shopname'><b><a href='#' onClick=\"MM_showHideLayers($param_show);\"><span style='cursor:hand;'>$s_shop_name</span></a></b>
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
			<td height='30' align='center'>랭크된 샵이 없습니다.</td>
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
				<td  class='evmem'>해당 샵이 없습니다.</td>
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
						<td width='85' align='center' valign='top'><img src='/img/btn_gotop_codi.gif' width='70' height='142' border='0' usemap='#btn_codi' /></td>
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