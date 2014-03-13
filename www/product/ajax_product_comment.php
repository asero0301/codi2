<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_product_comment.php
 * date   : 2008.10.22
 * desc   : ajax product comment
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

$p_e_idx	= trim($_REQUEST['pe_idx']);
$p_idx		= trim($_REQUEST['p_idx']);
$page		= trim($_REQUEST['page']);
$rurl		= trim($_REQUEST['rurl']);
$updown_yn	= trim($_REQUEST['updown_yn']);
$active		= trim($_REQUEST['active']);

if ( $page == "" ) {
	$page = 1;
}

// ajax 댓글을 위한 view/write url
$view_url = "/product/ajax_product_comment.php?p_idx=$p_idx&pe_idx=$p_e_idx&page=$page";
$write_url = "/product/ajax_product_comment_ok.php";

$mainconn->open();

$TXT = "<table width='860' height='30' border='0' cellpadding='0' cellspacing='0'>";

// tblProduct, tblProductEach, tblProductComment, tblMember, tblProductUpDown
// tblProductUpDown을 같이 join하지 않는 이유는 댓글만 달 수 있기때문..
// 댓글역시 p_e_idx에 의해 초기화된다. 즉, 다른 p_e_idx이면 출력되지 않는다.
$sql = "
select count(*)
from tblProductComment A, tblProduct B, tblMember C, tblProductEach D
where 1
and A.p_idx = B.p_idx 
and A.p_e_idx = D.p_e_idx 
and A.mem_id = C.mem_id 
and B.p_idx = $p_idx 
and A.p_c_status = 'Y'
";
//echo $sql."<br>";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1; $last = 0;
} else {
	$first = $PAGE_SIZE*($page-1); $last = $PAGE_SIZE*$page;
}
$orderby = " order by A.p_c_reg_dt desc ";


$sql = "
select A.p_c_idx, A.p_c_comment, A.p_c_reg_dt, C.mem_id, C.mem_name,
ifnull((select p_u_val from tblProductUpDown where p_e_idx=D.p_e_idx and mem_id=C.mem_id and p_u_reg_dt=A.p_c_reg_dt),0) as p_u_val
from tblProductComment A, tblProduct B, tblMember C, tblProductEach D
where 1
and A.p_idx = B.p_idx 
and A.p_e_idx = D.p_e_idx 
and A.mem_id = C.mem_id 
and B.p_idx = $p_idx 
and A.p_c_status = 'Y'
$orderby limit $first, $PAGE_SIZE 
";
//echo $sql."<br>";
$res = $mainconn->query($sql);
$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$p_c_idx	= trim($row['p_c_idx']);
	$p_c_comment= trim($row['p_c_comment']);
	$p_c_reg_dt	= trim($row['p_c_reg_dt']);
	$s_mem_id		= trim($row['mem_id']);
	$mem_name	= trim($row['mem_name']);
	$p_u_val	= trim($row['p_u_val']);

	$p_c_comment = strip_str($p_c_comment, "V");
	if ( $p_u_val > 0 ) {
		$updown_icon = "<img src='/img/icon_codiup.gif' width='67' height='20' alt='코디업'>";
	} else if ( $p_u_val < 0 ) {
		$updown_icon = "<img src='/img/icon_codidown.gif' width='67' height='20' alt='코디다운'>";
	} else {
		$updown_icon = "<img src='/img/icon_codietc.gif' width='67' height='20' alt='기타의견'>";
	}

	$p_c_reg_dt = str_replace("-",".",$p_c_reg_dt);
	$p_c_reg_dt = str_replace(" ","<br>",$p_c_reg_dt);
	

	$TXT .= "
	<tr>
		<td width='65' align='center' class='evfont'>$article_num</td>
		<td width='80' align='center'>$updown_icon</td>
		<td style='PADDING-top: 10px;PADDING-bottom:10px;PADDING-LEFT: 10px'>$p_c_comment </td>
		<td width='90' align='center'><font color='#333333' class='evmem'>$s_mem_id</font></td>
		<td width='80' align='center' class='evfont'>$p_c_reg_dt</td>
	</tr>
	<tr>
		<td height='1' colspan='5' background='/img/dot_garo_max.gif'></td>
	</tr>
	";

	$article_num--;

}	// while

if ( $total_record == 0 ) {
	$TXT .= "<tr><td align='center' class='evfont'>댓글평가가 없습니다.</td></tr>";
}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}


$TXT .= "</table>";

// 페이징
if ( $total_record > 0 ) {
$TXT .= ajax_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadProductComment", $rurl, $_SESSION['mem_id'],$_SESSION['mem_kind'],$view_url, $write_url, $p_idx, $p_e_idx, "reply_anc", $updown_yn, $active);
}

$TXT .= "<div id='product_comm_write_area'></div>";

$mainconn->close();

echo $TXT;
?>