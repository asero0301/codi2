<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_shop_rank_sub_list.php
 * date   : 2009.01.15
 * desc   : 베스트샵 순위 리스트 ajax 처리
 *
 * 이 페이지는 페이지의 DB로딩을 줄이기 위해 /product/best_shop_list.php 에 접속할때 "샵순위" 부분을
 * html파일(/tpl/sub/cache_shop_rank.tpl)로 만들려고 했으나 기간별 페이지량이 많아서 DB로딩 작업
 * 에도 불구하고 ajax 방식의 DB로 처리했다. 
 * 로직은 /proc/make_shop_rank_list.php와 동일하지만 $term, $key, $kwd 값이 수시로 변할 수 있다고 가정한다.
 * $term 값이 있고없고에 따라서 Query 와 변수에 변화가 생긴다. 이를 유심히 체크한다.
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$term	= trim($_REQUEST['term']);
$f_date	= trim($_REQUEST['f_date']);
$key	= trim($_REQUEST['key']);
$kwd	= trim($_REQUEST['kwd']);
$page	= trim($_REQUEST['page']);

if ( !$page ) $page = 1;

if ( !$f_date ) {
	$tmp = getWeekDay("last", time());
	$f_date = $tmp[0];
}

// 기준날짜를 구한다.
if ( $term == "weekly" ) {
	$l_date = getLastDay($f_date, "W");
	
} else if ( $term == "monthly" ) {
	$l_date = getLastDay($f_date, "M");
	
} else {
	$tt_arr = getWeekDay("last", time());
	$f_date = $tt_arr[0];
	$l_date = $tt_arr[1];
	
}

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
								<td align='center'><img src='/img/title10.gif' width='70' height='20'></td>
								<td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9'></td>
								<td width='100' align='center'><img src='/img/title43.gif' width='70' height='20'></td>
								<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
								<td width='130' align='center'><img src='/img/title11.gif' width='70' height='20'></td>
								<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
								<td width='70' align='center'><img src='/img/title12.gif' width='70' height='20'></td>
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
$cond = " and A.shop_idx = B.shop_idx and A.shop_status = 'Y' ";
$orderby = " order by B.rs_score desc, A.shop_reg_dt asc ";

// 주간 또는 월간일때
if ( $term ) {
	// 가장 최근 통계낸 날짜를 표시하기 위해서 기간의 마지막 날을 구한다.
	$t_arr = explode("-", $l_date);
	$prt_recent = date("Y년 n월 j일", mktime(1,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

	$cond .= " and B.rs_start_dt = '$f_date' and B.rs_end_dt = '$l_date' and B.rs_rank > 10 ";
	
	$sql = "select count(*) from tblShop A, tblRankShop B where 1 $cond ";
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
	select
	A.shop_idx, A.mem_id, A.shop_name, A.shop_url, A.shop_person, A.shop_mobile, A.shop_phone, A.shop_logo, A.shop_medal,
	(select count(*) from tblProduct where shop_idx = A.shop_idx and p_judgment != 'R') as codi_cnt,
	B.rs_score, B.rs_rank, B.rs_total_score, B.rs_total_rank 
	from tblShop A, tblRankShop B
	where 1 $cond $orderby limit $first, $PAGE_SIZE
	";
} else {
	$sql = "select rs_start_dt, rs_end_dt from tblRankShop order by rs_idx desc limit 1 ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row ) {
		$t_rs_start_dt = $row['rs_start_dt'];
		$t_rs_end_dt = $row['rs_end_dt'];

		// 가장 최근 통계낸 날짜를 표시하기 위해서 기간의 마지막 날을 구한다.
		$t_arr = explode("-", $t_rs_end_dt);
		$prt_recent = date("Y년 n월 j일", mktime(1,0,0,$t_arr[1],$t_arr[2],$t_arr[0]));

		$noterm_orderby = " order by B.rs_total_score desc ";
		$noterm_cond = " and A.shop_idx = B.shop_idx and A.shop_status = 'Y' and B.rs_start_dt = '$t_rs_start_dt' and B.rs_end_dt = '$t_rs_end_dt' and B.rs_total_rank > 10 ";

		$sql = "select count(*) from tblShop A, tblRankShop B where 1 $noterm_cond ";
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
		select
		A.shop_idx, A.mem_id, A.shop_name, A.shop_url, A.shop_person, A.shop_mobile, A.shop_phone, A.shop_logo, A.shop_medal,
		(select count(*) from tblProduct where shop_idx = A.shop_idx and p_judgment != 'R') as codi_cnt,
		B.rs_score, B.rs_rank, B.rs_total_score, B.rs_total_rank 
		from tblShop A, tblRankShop B
		where 1 $noterm_cond $noterm_orderby limit $first, $PAGE_SIZE
		";
	}
}

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

	// 인증샵 마크
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0'>";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	if ( $term ) {
		$prt_rank = $rs_rank;
		$prt_score = $rs_score;
	} else {
		$prt_rank = $rs_total_rank;
		$prt_score = $rs_total_score;
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=10; $j++ ) {
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
								<td bgcolor='#3D3D3D'><a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'><img src='$shop_logo' width='95' height='95' border='0'></a></td>
							</tr>
						</table>
						</td>
						<td  style='padding-left:5;padding-right:8'class='shopname'>
						<a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$s_shop_name</a>
	";

	// 샵 정보 레이어
	$str .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $prt_rank, $shop_url, $s_shop_name, $shop_mem_id, $param_hide);

	$str .= "
							$shop_medal_mark
						</td>
						<td width='102' align='center'>$shop_mobile<br>$shop_phone</td>
						<td width='133' align='center'>$shop_person</td>
						<td width='74' align='center' >$codi_cnt</td>
						<td width='72' align='center'><font color='FF5D5E'>$rs_total_score</font></td>
						<td width='72' align='center'><font color='9E6ED1'><b>$prt_rank</b></font></td>
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



// 페이징(term, f_date, key, page, kwd)
$str .= ajax_general_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadShopRankSubList", $term, $f_date, $key, $kwd);

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