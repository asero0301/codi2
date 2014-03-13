<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_product_gift_tracking.php
 * date   : 2008.10.22
 * desc   : ajax product gift tracking
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );


$p_e_idx	= trim($_REQUEST['pe_idx']);
$p_idx		= trim($_REQUEST['p_idx']);
$giftpage	= trim($_REQUEST['giftpage']);
$shop_idx	= trim($_REQUEST['shop_idx']);

if ( $giftpage == "" ) {
	$giftpage = 1;
}

$mainconn->open();

$TXT = "<table width='860' height='30' border='0' cellpadding='0' cellspacing='0'>";

// 가장 최근 당첨 모듈 실행시각(이번주 일요일 0시 50분)
//$cur = date("Y-m-d H:i:s", time());
$arr = getWeekDay( "current", time() );
$this_sunday = $arr[0]." 00:50:00";

$cond = " where 1 and A.p_idx = B.p_idx and A.shop_idx = $shop_idx and B.end_dt < '$this_sunday' ";

/*
SELECT A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.p_gift, B.p_e_idx, B.end_dt, C.mem_id, C.shop_name, C.shop_url, ifnull( (
SELECT rs_total_rank
FROM tblRankShop
WHERE shop_idx = C.shop_idx
ORDER BY rs_idx DESC
LIMIT 1
), 0 ) AS rs_total_rank
FROM tblProduct A, tblProductEach B, tblShop C
WHERE 1
AND A.p_idx = B.p_idx
AND A.shop_idx = C.shop_idx
AND B.end_dt < '2009-02-13 12:12:12'
ORDER BY B.end_dt DESC
*/

// tblProduct, tblProductEach, tblGiftTracking
$sql = "SELECT count(*) FROM tblProduct A, tblProductEach B $cond ";

$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1; $last = 0;
} else {
	$first = $PAGE_SIZE*($giftpage-1); $last = $PAGE_SIZE*$giftpage;
}
$orderby = " order by B.end_dt desc ";



$sql = "
SELECT A.p_idx, A.p_title, A.p_main_img, A.p_gift, A.p_top10_num, B.p_e_idx, B.end_dt
FROM tblProduct A, tblProductEach B
$cond 
$orderby limit $first, $PAGE_SIZE 
";
//echo $sql."<br>";
$res = $mainconn->query($sql);

$p_e_cnt = 0;
$old_p_e_idx = 0;
$lotto_list = "";
$row_again = array();

while ( $row = $mainconn->fetch($res) ) {
	$p_idx		= trim($row['p_idx']);
	$p_title	= strip_str(trim($row['p_title']));
	$p_main_img	= trim($row['p_main_img']);
	$p_gift		= trim($row['p_gift']);
	$p_top10_num	= trim($row['p_top10_num']);
	$p_e_idx	= trim($row['p_e_idx']);
	$end_dt		= trim($row['end_dt']);
	
	$p_main_img = $UP_URL."/thumb/".$p_main_img;

	// 베스트 코디 마크
	if ( $p_top10_num > 0 ) {
		$codi_mark = "<img src='/img_seri/icon_bestshop2.gif' align='absmiddle'>";
	} else {
		$codi_mark = "&nbsp;";
	}
	
	$end_dt = str_replace("-",".",$end_dt);
	$end_dt = str_replace(" ","<br>",$end_dt);

	$sql2 = "
	select gt_status, user_mem_id, 
	(select mem_name from tblMember where mem_id=tblGiftTracking.user_mem_id) as user_mem_name 
	from tblGiftTracking
	where p_e_idx = $p_e_idx
	";
	//echo $sql2."<p><p>";
	$res2 = $mainconn->query($sql2);

	$status_list = "";
	$mem_list = "";
	while ( $row2 = $mainconn->fetch($res2) ) {
		$gt_status = trim($row2['gt_status']);
		$user_mem_id = trim($row2['user_mem_id']);
		$user_mem_name = trim($row2['user_mem_name']);

		//$gt_status = ( $gt_status == "A" ) ? "<b><font color='#CC3300'>대기</font></b>" : "<b><font color='#000000'>완료</font></b>";
		$gt_status = $TRACKCODE[$gt_status];

		$mem_list .= substr($user_mem_id, 0, -2)."** (".substr($user_mem_name,0,2)."*".substr($user_mem_name,4).")<br>";
		$status_list .= $gt_status."<br>";
	}

	if ( $mem_list == "" ) {
		$mem_list .= "(당첨자 없음)";
	}

	$TXT .= "
	<tr>
		<td align='center' style='PADDING-bottom: 10px; PADDING-top: 10px;'>
		<table width='100%' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td width='106'>
				<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
					<tr>
						<td bgcolor='#3D3D3D'><a href='./product_view.php'><img src='$p_main_img' width='95' height='95' border='0'></a></td>
					</tr>
				</table>
				</td>
				<td  style='padding-left:5;padding-right:8' class='evmem'>
				$p_title $codi_mark
				</td>
			</tr>
		</table>
		</td>
		<td width='200' align='center'  style='PADDING-bottom: 10px; PADDING-top: 10px;'>$p_gift</td>
		<td width='90' align='center' style='PADDING-top: 10px;PADDING-bottom:10px;PADDING-LEFT: 10px'><span class='evfont'>$end_dt</span></td>
		<td width='120' align='center'  style='PADDING-bottom: 10px; PADDING-top: 10px;'><font color='#333333' class='evmem'>$mem_list</font></td>
		<td width='80' align='center'>$status_list</td>
	</tr>
	<tr>
		<td height='1' colspan='5' background='/img/dot_garo_max.gif'></td>
	</tr>
	";
}

if ( $total_record == 0 ) {
	$TXT .= "<tr><td align='center' class='evfont'>경품 지급내역이 없습니다.</td></tr>";
}



$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($giftpage/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}


$TXT .= "</table>";

// 페이징
if ( $total_record > 0 ) {
$TXT .= ajax_gift_page_navi($giftpage,$first_page,$last_page,$total_page,$block,$total_block,"loadProductGiftTracking", $p_idx, $p_e_idx, $shop_idx);
}

$mainconn->close();

echo $TXT;
?>