<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_codi_rank_sub_list.php
 * date   : 2009.01.14
 * desc   : �ڵ��򰡼��� ����Ʈ ajax ó��
 *
 * �� �������� �������� DB�ε��� ���̱� ���� /product/codi_list.php �� �����Ҷ� "�ڵ�ž�� �򰡼���"�� ����Ʈ �κ���
 * html����(/tpl/sub/cache_codi_rank_list.tpl)�� ������� ������ �����κκ�(������ ��ȭ) �������� 
 * ajax ����� DB�� ó���ߴ�. 
 * ������ /proc/make_codi_rank_list.php�� ���������� $term, $categ, $key, $kwd ���� ���÷� ���� �� �ִٰ� �����Ѵ�.
 * $term ���� �ְ���� ���� Query �� ������ ��ȭ�� �����. �̸� ������ üũ�Ѵ�.
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// �������� üũ
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$categ	= trim($_REQUEST['categ']);
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


// ���س�¥�� ���Ѵ�.
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
$cond = " and A.p_idx = C.p_idx and A.shop_idx = B.shop_idx and A.p_judgment != 'R' ";
$orderby = " order by C.rp_score desc, A.p_reg_dt asc ";

if ( $categ ) {
	$cond .= " and A.p_categ = '$categ' ";
}

// �ְ� �Ǵ� �����϶�
if ( $term ) {
	
	$cond .= " and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date' and C.rp_rank > 10 ";
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
} else {
	$sql = "select rp_start_dt, rp_end_dt from tblRankProduct order by rp_idx desc limit 1 ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row ) {
		$t_rp_start_dt = $row['rp_start_dt'];
		$t_rp_end_dt = $row['rp_end_dt'];

		$noterm_orderby = " order by C.rp_total_score desc ";
		$noterm_cond = " and A.p_idx = C.p_idx and A.shop_idx = B.shop_idx and A.p_judgment != 'R' and C.rp_start_dt = '$t_rp_start_dt' and C.rp_end_dt = '$t_rp_end_dt' and C.rp_total_rank > 10 ";
		if ( $categ ) {
			$noterm_cond .= " and A.p_categ = '$categ' ";
		}

		$sql = "select count(*) from tblProduct A, tblShop B, tblRankProduct C where 1 $noterm_cond ";
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
		SELECT A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.shop_idx, B.mem_id, B.shop_url, B.shop_name, B.shop_medal, C.rp_score, C.rp_rank, C.rpc_rank, C.rp_total_score, C.rp_total_rank, C.rpc_total_rank,
		(select end_dt from tblProductEach where p_idx=A.p_idx order by p_e_idx desc limit 1) as end_dt,
		(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_val > 0) as up_cnt
		from tblProduct A, tblShop B, tblRankProduct C
		where 1 $noterm_cond $noterm_orderby limit $first, $PAGE_SIZE
		";
	}

}

//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$p_idx = trim($row['p_idx']);
	$p_title = strip_str(trim($row['p_title']));
	$p_main_img = trim($row['p_main_img']);
	$p_top10_num = trim($row['p_top10_num']);
	$end_dt = trim($row['end_dt']);
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

	$end_dt = str_replace("-",".",substr($end_dt,0,10)	);

	// ������ ��ũ
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0'>";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	// ����Ʈ �ڵ� ��ũ
	if ( $p_top10_num > 0 ) {
		$codi_mark = "<img src='/img_seri/icon_bestshop2.gif' align='absmiddle'>";
	} else {
		$codi_mark = "&nbsp;";
	}

	$p_title = strip_str($p_title);
	$p_main_img = $UP_URL."/thumb/".$p_main_img;

	if ( $term && !$categ ) {	// �ְ�/���� �̸鼭 ī�װ����� ��ü
		$prt_rank = $rp_rank;
		$prt_score = $rp_score;
	} else if ( $term && $categ ) {	// �ְ�/���� �̸鼭 ī�װ� ������
		$prt_rank = $rpc_rank;
		$prt_score = $rp_score;
	} else if ( !$term && $categ ) {	// �Ⱓ���� ī�װ� ������
		$prt_rank = $rpc_total_rank;
		$prt_score = $rp_total_score;
	} else {	// �Ⱓ���� ī�װ� ������
		$prt_rank = $rp_total_rank;
		$prt_score = $rp_total_score;
	}

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
	
	// �� ���� ���̾�
	$str .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $prt_rank, $shop_url, $s_shop_name, $s_shop_mem_id, $param_hide);


	$str .= "
				$shop_medal_mark
			</td>
			<td width='74' align='center' >$up_cnt</td>
			<td width='72' align='center'><font color='FF5D5E'>$prt_score</font></td>
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

// ����¡(categ, term, f_date, key, kwd, page)
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
