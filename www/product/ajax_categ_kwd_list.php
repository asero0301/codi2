<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_categ_kwd_list.php
 * date   : 2008.10.24
 * desc   : "�����ּ���" �ϴ� ����Ʈ
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// �������� üũ2014-02-10
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

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


$kwd_categ	= trim($_REQUEST['kwd_categ']);		// T:����, B:����, O:�ƿ�����, U:�������, A:ACC
$kwd_kind	= trim($_REQUEST['kwd_kind']);		// S:��Ÿ�Ϻ�, I:�����ۺ�, T:�׸���
$page		= trim($_REQUEST['page']);			// ������
$kwd		= trim($_REQUEST['kwd']);			// Ű����
$order		= trim($_REQUEST['order']);			// A:�ֱٵ�ϼ���, B:�򰡸�������, C:��ŷ����
$s_key		= trim($_REQUEST['s_key']);			// S:���̸�, P:�ڵ��̸�, A:��+�ڵ�����, K:Ű����
$keyword	= trim($_REQUEST['keyword']);		// ajax �Է� �˻���

/*
echo "
kwd_categ : $kwd_categ <br>
kwd_kind : $kwd_kind <br>
page : $page <br>
kwd : $kwd <br>
order : $order <br>
s_key : $s_key <br>
keyword : $keyword <br>
";
*/

if ( $page == "" ) {
	$page = 1;
}

if ( $kwd_kind == "S" ) {
	$column = "A.p_style_kwd";
} else if ( $kwd_kind == "I" ) {
	$column = "A.p_item_kwd";
} else {
	$column = "A.p_theme_kwd";
}



$mainconn->open();

$cond = "";
$cond .= " and A.shop_idx = B.shop_idx and A.p_judgment != 'R' ";

if ( $kwd_categ ) {
	$cond .= " and A.p_categ = '$kwd_categ' ";
}

if ( $kwd_kind ) {
	$cond .= " and $column like '%$kwd%' ";
}

if ( $s_key && $keyword ) {
	if ( $s_key == "S" ) {
		$cond .= " and B.shop_name like '%$keyword%' ";
	} else if ( $s_key == "P" ) {
		$cond .= " and A.p_title like '%$keyword%' ";
	} else if ( $s_key == "K" ) {
		$cond .= " and (A.p_style_kwd like '%$keyword%' or A.p_item_kwd like '%$keyword%' or A.p_theme_kwd like '%$keyword%' ) ";
	} else if ( $s_key == "C" ) {
		$cond .= " and A.p_categ = '$keyword' ";
	} else {
		$cond .= " and (A.p_title like '%$keyword%' or B.shop_name like '%$keyword%') ";
	}
}


if ( $order == "A" ) {		// �ֱ� ��ϼ����̸�
	$sql = "select count(*) from tblProduct A, tblShop B where 1 $cond ";
} else {
	$diff_cond = " and A.p_idx=C.p_idx and now() between C.start_dt and C.end_dt ";
	$sql = "select count(*) from tblProduct A, tblShop B, tblProductEach C where 1 $cond $diff_cond ";
}


$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PRODUCT_CODI_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PRODUCT_CODI_PAGE_SIZE*($page-1);
	$last = $PRODUCT_CODI_PAGE_SIZE*$page;
}

if ( $order == "A" ) {
	$orderby = " order by A.p_reg_dt desc ";
	$A_img = "tap_ov_01.gif"; $B_img = "tap_02.gif"; $C_img = "tap_03.gif";
} else if ( $order == "B" ) {
	$orderby = " order by C.end_dt asc ";
	$A_img = "tap_01.gif"; $B_img = "tap_ov_02.gif"; $C_img = "tap_03.gif";
} else {
	$orderby = " order by rp_total_score desc ";
	$A_img = "tap_01.gif"; $B_img = "tap_02.gif"; $C_img = "tap_ov_03.gif";
}

$TXT = "
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='130'><a href='#' onClick=\"loadCategKwdList('$kwd_categ','$kwd_kind','$kwd',1,'A','$s_key','$keyword');\"><img src='/img/$A_img' width='130' height='30' border='0' /></a></td>
		<td width='130'><a href='#' onClick=\"loadCategKwdList('$kwd_categ','$kwd_kind','$kwd',1,'B','$s_key','$keyword');\"><img src='/img/$B_img'  width='131' height='30' border='0' /></a></td>
		<td width='130'><a href='#' onClick=\"loadCategKwdList('$kwd_categ','$kwd_kind','$kwd',1,'C','$s_key','$keyword');\"><img src='/img/$C_img' width='130' height='30' border='0' /></a></td>
		<td align='right' background='/img/tap_04.gif'>
";

if ( $_SESSION['mem_kind'] == "U" ) {
	$TXT .= "
	<a href='#' onClick=\"goMyCodi('U');\"><img src='/img/btn_codi01.gif' width='110' height='21' border='0' /></a>
	";
} else if ( $_SESSION['mem_kind'] == "S" ) {
	$TXT .= "
	<a href='#' onClick=\"goMyCodi('S');\"><img src='/img/btn_codi02.gif' width='110' height='21' border='0' /></a>
	";
} else {
	$TXT .= "&nbsp;";
}

$TXT .= "
		</td>
	</tr>
</table>

<table width='100' height='0' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td></td>
	</tr>
</table>

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
						<td width='243' align='center'><img src='/img/title01.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='100' align='center'><img src='/img/title02.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='100' align='center'><img src='/img/title03.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='110' align='center'><img src='/img/title04.gif' width='70' height='20'></td>
						<td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
						<td width='80' align='center'><img src='/img/title05.gif' width='70' height='20'></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td height='1' bgcolor='DD656A'></td>
			</tr>
		</table>
		
		<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>
";


if ( $order == "A" ) {
	$sql = "
	select A.mem_id, A.p_idx, A.p_title, A.p_main_img, A.p_gift, B.shop_idx, B.shop_name, B.shop_url,
	ifnull((select rp_total_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_date' and rp_end_dt = '$l_date'),0) as rp_total_rank,
	ifnull((select rp_total_score from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_date' and rp_end_dt = '$l_date'),0) as rp_total_score,
	ifnull((select start_dt from tblProductEach where p_idx=A.p_idx and now() between start_dt and end_dt),0) as start_dt,
	ifnull((select end_dt from tblProductEach where p_idx=A.p_idx and now() between start_dt and end_dt),0) as end_dt
	from tblProduct A, tblShop B
	where 1 $cond $orderby limit $first, $PRODUCT_CODI_PAGE_SIZE
	";

} else {
	$sql = "
	select A.mem_id, A.p_idx, A.p_title, A.p_main_img, A.p_gift, B.shop_idx, B.shop_name, B.shop_url, C.start_dt, C.end_dt,
	ifnull((select rp_total_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_date' and rp_end_dt = '$l_date'),0) as rp_total_rank,
	ifnull((select rp_total_score from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_date' and rp_end_dt = '$l_date'),0) as rp_total_score
	from tblProduct A, tblShop B, tblProductEach C
	where 1 $cond $diff_cond $orderby limit $first, $PRODUCT_CODI_PAGE_SIZE
	";
}
//echo "<p>".$sql."<p>";
$res = $mainconn->query($sql);
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cnt++;
	$s_shop_mem_id = trim($row['mem_id']);
	$p_idx = trim($row['p_idx']);
	$p_title = strip_str(trim($row['p_title']));
	$p_main_img = trim($row['p_main_img']);
	$p_gift = trim($row['p_gift']);
	$shop_idx = trim($row['shop_idx']);
	$s_shop_name = trim($row['shop_name']);
	$start_dt = trim($row['start_dt']);
	$end_dt = trim($row['end_dt']);
	$shop_url = trim($row['shop_url']);
	$rp_total_score = trim($row['rp_total_score']);
	$rp_total_rank = trim($row['rp_total_rank']);

	$p_main_img = $UP_URL."/thumb/".$p_main_img;
	$prt_start_dt = substr($start_dt,0,10)." (".substr($start_dt,11,5).")";
	$prt_end_dt = substr($end_dt,0,10)." (".substr($end_dt,11,5).")";

	$prt_duration = ( substr($prt_end_dt,0,1) ) ? $prt_start_dt."<br>~<br>".$prt_end_dt : "<img src='/img/btn_end.gif' border='0' />";

	$param_show = $param_hide = "";
	for ( $j=1; $j<=$PRODUCT_CODI_PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_$j','','$sh',";
		$param_hide .= "'shopview_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);

		

	$TXT .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='100'>
			<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
				<tr>
					<td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='95' height='95' border='0' /></a></td>
				</tr>
			</table>
			</td>
			<td  style='padding-left:5;padding-right:8' class='evmem'><img src='/img_seri/icon_bestshop2.gif'  align='absmiddle'>
			<table width='100' height='7' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td></td>
				</tr>
			</table>
			<a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
			<td width='103' align='center'>$p_gift </td>
			<td width='102' align='center' class='shopname'><a  onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;' />$s_shop_name</a></td>
			<td width='113' align='center' class='date'>$prt_duration</td>
			<td width='81' align='center'><img src='/img/icon_point.gif'  align='absmiddle'><font color='FF5D5E'> $rp_total_score</font></td>
		</tr>
	</table>
	";

	// �� ���� ���̾�
	$TXT .= getLayerShopInfo("shopview", $cnt, 2, 1, 425, -122, $rp_total_rank, $shop_url, $s_shop_name, $s_shop_mem_id, $param_hide);


	$TXT .= "
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

}

if ( $total_record > 0 ) {
	$TXT .= "
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

	// ����¡
	$TXT .= ajax_board_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadCategKwdList", $kwd_categ, $kwd_kind, $kwd, $order, $s_key, $keyword);

	$TXT .= "
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	";
}

if ( $cnt < $PRODUCT_CODI_PAGE_SIZE ) {

	for ( $i=$cnt+1; $i<$PRODUCT_CODI_PAGE_SIZE; $i++ ) {
		$TXT .= "<div id='shopview_{$i}'  style='position:relative; z-index:2; left:445px; top: -122px;visibility: hidden;'></div>";
	}
}


$mainconn->close();

echo $TXT;
?>
