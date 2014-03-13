<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/common/ajax_comment.php
 * date   : 2009.01.20
 * desc   : ajax comment
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 리퍼러 체크
referer_chk();

$kind	= trim($_REQUEST['kind']);
$p_idx	= trim($_REQUEST['p_idx']);
$page	= trim($_REQUEST['page']);
$v_url	= trim($_REQUEST['v_url']);
$w_url	= trim($_REQUEST['w_url']);
$rurl	= trim($_REQUEST['rurl']);

if ( !$page ) $page = 1;


$TXT = "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='10'><img src='/img/box01.gif' width='10' height='10' /></td>
		<td background='/img/box05.gif'></td>
		<td width='10'><img src='/img/box02.gif' width='10' height='10' /></td>
	</tr>
	<tr>
		<td background='/img/box07.gif'></td>
		<td bgcolor='F7F7F7' style='padding:8 8 8 8'>

		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	";

$mainconn->open();

if ( $kind == "N" ) {
	$tb_1 = "tblNotice";
	$tb_2 = "tblNoticeComment";
	$col_1 = "notice_";
	$col_2 = "notice_c_";
} else if ( $kind == "U" ) {
	$tb_1 = "tblUcc";
	$tb_2 = "tblUccComment";
	$col_1 = "ucc_";
	$col_2 = "ucc_c_";
}  else if ( $kind == "P" ) {
	$tb_1 = "tblPr";
	$tb_2 = "tblPrComment";
	$col_1 = "pr_";
	$col_2 = "pr_c_";
} else if ( $kind == "B" ) {
	$tb_1 = "tblBadShop";
	$tb_2 = "tblBadShopComment";
	$col_1 = "bad_";
	$col_2 = "bad_c_";
}


$cond = " and A.{$col_1}idx = B.{$col_1}idx and B.mem_id = C.mem_id and A.{$col_1}idx = $p_idx ";

$sql = "select count(*) from {$tb_1} A, {$tb_2} B, tblMember C where 1 $cond ";
//echo $sql."<br>";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$COMMENT_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1; $last = 0;
} else {
	$first = $COMMENT_PAGE_SIZE*($page-1); $last = $COMMENT_PAGE_SIZE*$page;
}

$sql = "
select 
B.{$col_2}idx, B.{$col_2}comment, B.{$col_2}reg_dt, C.mem_kind, C.mem_id, C.mem_name, C.mem_grade,
ifnull((select shop_idx from tblShop where mem_id = C.mem_id and shop_kind = 'I'),0) as s_idx,
ifnull((select shop_url from tblShop where mem_id = C.mem_id and shop_kind = 'I'),'') as shop_url,
ifnull((select rs_total_rank from tblRankShop where shop_idx=s_idx order by rs_idx desc limit 1),0) as rs_total_rank
from {$tb_1} A, {$tb_2} B, tblMember C
where 1 $cond
order by B.{$col_2}reg_dt desc
limit $first, $COMMENT_PAGE_SIZE
";

//echo $sql."<br>";

$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$c_idx		= trim($row[${col_2}.'idx']);
	$s_mem_id		= trim($row['mem_id']);
	$s_mem_name	= trim($row['mem_name']);
	$mem_kind	= trim($row['mem_kind']);
	$mem_grade	= trim($row['mem_grade']);
	$shop_idx	= trim($row['s_idx']);
	$shop_url	= trim($row['shop_url']);
	$rs_total_rank	= trim($row['rs_total_rank']);
	$c_comment	= strip_str(trim($row[${col_2}.'comment']));
	$c_reg_dt	= str_replace("-",".",substr(trim($row[${col_2}.'reg_dt']),0,10));

	$mem_kind_icon = ( $mem_kind == "S" ) ? "icon_s.gif" : "icon_m.gif";

	if ( $s_mem_id == $_SESSION['mem_id'] ) {
		$owner_comment_del = "<a href='#reply_anc' onClick=\"submitComment('D','$c_idx');\"><img src='/img/delete.gif' border='0'></a>";
	} else {
		$owner_comment_del = "";
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=$COMMENT_PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'detailbox_$j','','$sh',";
		$param_hide .= "'detailbox_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);


	$TXT .= "
		<tr>
			<td width='100'><a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$mem_name</a> <img src='/img/${mem_kind_icon}' width='12' height='11' align='absmiddle' />

			<div id='detailbox_{$cnt}' style='position:relative; z-index:2; left:60px; top: -80px;visibility: hidden;' >
			<div style='position: absolute; z-index: 1;'>
			";

	if ( $mem_kind == "S" ) {	// 샵회원
		$TXT .= "
			<table width='215' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td width='6' align='right'><img src='/img/arr_orage.gif'></td>
					<td>
					
					<table width='200' border='1' cellpadding='0' cellspacing='5' bgcolor='#FF6600'  bordercolor='#FFFFFF'>
						<tr>
							<td bgcolor='#FFFFFF'  style='padding:8 14 8 14'>
							
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td align='center' valign='bottom'   style='PADDING-top: 6px;PADDING-bottom: 4px;'><b><font color='#333333'>[ 전체순위 ]</font><font color='#FF3300'></font></b><font color='#FF3300'> <b>$rs_total_rank 위 </b></font></td>
								</tr>
								<tr>
									<td valign='top'>
									
									<table width='100%' border='0' cellspacing='0' cellpadding='0'>
										<tr>
											<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
										</tr>
										<tr>
											<td width='20' height='25' align='center'><font color='#FF3300'><img src='/img/icon_home02.gif' align='absmiddle'></font> </td>
											<td style='PADDING-top: 4px;PADDING-bottom: 4px;'><a href='$shop_url' target='_blank'><b>홈페이지 바로가기</b></a> </td>
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
											<td width='20' height='21' align='center'><img src='/img/icon_list.gif' align='absmiddle'></td>
											<td class='shopname'><a href='#reply_anc' onClick=\"alert('공사중');\">등록코디 전체보기</a></td>
										</tr>
										<tr>
											<td width='20' height='21' align='center'  class='evfont'><span class='shopname'><img src='/img/icon_memo03.gif' align='absmiddle'></span></td>
											<td height='21'  class='evfont'><span class='shopname'><a href=\"javascript:pop_msg('$s_mem_id');\"> <b><font color='#CC3300'>쪽지보내기</font></b></a></span></td>
										</tr>
										<tr>
										
											<td colspan='2' align=right  class='evfont'><span class='shopname'><a onClick=\"MM_showHideLayers($param_hide);\" style='cursor:hand;'><img src='/img/btn_pop_close.gif' align='absmiddle' border=0></a> &nbsp; </span></td>
										
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
				";
	} else {	// 일반회원, 관리자
		$TXT .= "
			<table width='215' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td width='6' align='right'><img src='/img/arr_orage.gif'></td>
					<td>
					
					<table width='200' border='1' cellpadding='0' cellspacing='5' bgcolor='#FF6600'  bordercolor='#FFFFFF'>
						<tr>
							<td bgcolor='#FFFFFF'  style='padding:8 14 8 14'>
							
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
								
								<tr>
									<td valign='top'>
									
									<table width='100%' border='0' cellpadding='0' cellspacing='0'>
										<tr>
											<td width='20' height='21' align='center'><img src='/img/icon_gift.gif' width='8' height='9' align='absmiddle'></td>
											<td ><font color='#FF3300'>당첨등급 : $mem_grade 등급 </font></td>
										</tr>
										<tr>
											<td width='20' height='21' align='center'  class='evfont'><span class='shopname'><img src='/img/icon_memo03.gif' align='absmiddle'></span></td>
											<td height='21'  class='evfont'><span class='shopname'><a href=\"javascript:pop_msg('$s_mem_id');\"> <b><font color='#CC3300'>쪽지보내기</font></b></a></span></td>
										</tr>
										<tr>
										
											<td colspan='2' align=right  class='evfont'><span class='shopname'><a onClick=\"MM_showHideLayers($param_hide);\" style='cursor:hand;'><img src='/img/btn_pop_close.gif' align='absmiddle' border=0></a> &nbsp; </span></td>
										
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
				";
	}
	
	$TXT .= "
			</div>
			</div>
			
			</td>
			<td style='padding-top:5;padding-bottom:5'>$c_comment </td>
			<td width='100' align='right'>$c_reg_dt &nbsp;</td>
			<td width='9' align='center'>$owner_comment_del</td>
		</tr>
		<tr>
			<td height='1' colspan='4' bgcolor='E3E3E3'></td>
		</tr>
		";

	$cnt++;

}	// while


$total_block = ceil($total_page/$COMMENT_PAGE_BLOCK);
$block = ceil($page/$COMMENT_PAGE_BLOCK);
$first_page = ($block-1)*$COMMENT_PAGE_BLOCK;
$last_page = $block*$COMMENT_PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}


$mainconn->close();


$TXT .= "			
			</table>
			
			</td>
			<td background='/img/box08.gif'></td>
		</tr>
		<tr>
			<td><img src='/img/box03.gif' width='10' height='10' /></td>
			<td background='/img/box06.gif'></td>
			<td><img src='/img/box04.gif' width='10' height='10' /></td>
		</tr>
	</table>
";

if ( $total_record > 0 ) {
	$TXT .= "
		<table width='645' height='45' border='0' cellpadding='0' cellspacing='0'>
			<tr>
			  <td align='center'>
	";

	$TXT .= ajax_board_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadBoardComment",$kind,$p_idx,$r_url,$w_url,$_SESSION['mem_id'],$r_url);


	$TXT .= "
				</td>
			</tr>
		</table>
	";
}

$TXT .= "<div id='comm_write_area_${c_idx}'></div>";

echo $TXT;

?>
