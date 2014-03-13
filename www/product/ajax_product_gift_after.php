<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_product_gift_after.php
 * date   : 2009.02.13
 * desc   : ajax 당첨후기
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );


$p_e_idx	= trim($_REQUEST['pe_idx']);
$p_idx		= trim($_REQUEST['p_idx']);
$giftafterpage	= trim($_REQUEST['giftafterpage']);

if ( $giftafterpage == "" ) {
	$giftafterpage = 1;
}

$mainconn->open();

$TXT = "<table width='860' height='30' border='0' cellpadding='0' cellspacing='0'>";

// tblProduct, tblProductEach, tblGiftTracking
$sql = "
SELECT count(*)
FROM tblProduct A, tblProductEach B, tblGiftTracking C
WHERE 1
AND A.p_idx = B.p_idx
AND B.p_e_idx = C.p_e_idx
AND A.p_idx = $p_idx
AND C.gt_comment is not NULL
";

$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1; $last = 0;
} else {
	$first = $PAGE_SIZE*($giftafterpage-1); $last = $PAGE_SIZE*$giftafterpage;
}
$orderby = " order by B.p_e_idx desc ";



$sql = "
SELECT A.p_idx, B.p_e_idx, C.user_mem_id, C.status_reg_dt, C.gt_comment
FROM tblProduct A, tblProductEach B, tblGiftTracking C
WHERE 1
AND A.p_idx = B.p_idx
AND B.p_e_idx = C.p_e_idx
AND A.p_idx = $p_idx
AND C.gt_comment is not NULL
$orderby limit $first, $PAGE_SIZE 
";
//echo $sql."<br>";
$res = $mainconn->query($sql);
$article_num = $total_record - $PAGE_SIZE*($giftafterpage-1);
while ( $row = $mainconn->fetch($res) ) {
	$p_idx		= trim($row['p_idx']);
	$p_e_idx	= trim($row['p_e_idx']);
	$user_mem_id= trim($row['user_mem_id']);
	$status_reg_dt	= trim($row['status_reg_dt']);
	$gt_comment	= strip_str(trim($row['gt_comment']), "V");
	
	$status_reg_dt = str_replace("-",".",$status_reg_dt);
	$status_reg_dt = str_replace(" ","<br>",$status_reg_dt);

	$TXT .= "
	<tr>
		<td width='65' align='center' class='evfont'>$article_num</td>
		<td style='PADDING-top: 10px;PADDING-bottom:10px;PADDING-LEFT: 10px'>$gt_comment </td>
		<td width='90' align='center'><font color='#333333' class='evmem'>$user_mem_id</font></td>
		<td width='80' align='center' class='evfont'>$status_reg_dt</td>
	</tr>
	<tr>
		<td height='1' colspan='4' background='/img/dot_garo_max.gif'></td>
	</tr>
	";

	$article_num--;
}


if ( $total_record == 0 ) {
	$TXT .= "<tr><td align='center' class='evfont'>당첨후기가 없습니다.</td></tr>";
}


$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($giftafterpage/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}


$TXT .= "</table>";

// 페이징
if ( $total_record > 0 ) {
$TXT .= ajax_gift_page_navi($giftafterpage,$first_page,$last_page,$total_page,$block,$total_block,"loadProductGiftAfter", $p_idx, $p_e_idx, "");
}

$mainconn->close();

echo $TXT;
?>