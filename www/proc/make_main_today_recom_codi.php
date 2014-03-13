<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_main_today_recom_codi.php
 * date   : 2008.10.27
 * desc   : ���� "������ ��õ�ڵ�" ����� proc ��ũ��Ʈ
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";
$mainconn->open();

$today = date("Y-m-d", time());

$cond = " and A.p_idx = B.p_idx and A.p_judgment = 'Y' and B.p_e_idx = C.p_e_idx and C.p_tr_today = '$today' ";
$orderby = " order by C.p_tr_idx desc ";

// �������� ������ ���� ����¡ ������ ����ϱ� ���� ��ü ���ڵ带 ���Ѵ�.
$sql = "select count(*) from tblProduct A, tblProductEach B, tblProductTodayRecom C where 1 $cond";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$MAIN_TODAY_RECOM_PAGE_SIZE);


$str = "";


// ������ ��õ�ڵ� ������ ���� �ֽ� �����ͷ� ó���Ѵ�.
if ( $total_record == 0 ) {
	$total_page = 1;
	
	$str .= "
	<div id='main_today_recom_1' style='display:none;'>
	<table width='424' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td height='40' align='right' background='/img/title_today.gif' style='padding-right:14;padding-top:7'>
			<table border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='17'><img src='" . __HTTPURL__  . "/img/btn_pre008.gif' width='14' height='14' border='0' /></td>
					<td width='14'><img src='" . __HTTPURL__  . "/img/btn_next008.gif' width='14' height='14' border='0' /></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	";
	
	$sql2 = "
	select A.p_idx, A.p_title, A.p_main_img
	from tblProduct A, tblProductEach B
	where A.p_idx=B.p_idx and A.p_judgment != 'R'
	and now() between B.start_dt and B.end_dt
	order by A.p_reg_dt desc limit $MAIN_TODAY_RECOM_PAGE_SIZE 
	";
	$res2 = $mainconn->query($sql2);
	$cnt = 0;
	while ( $row2 = $mainconn->fetch($res2) ) {
		${"p_idx_".$cnt} = trim($row2['p_idx']);
		${"p_title_".$cnt} = cutStringHan(strip_str(trim($row2['p_title'])),35);
		${"p_main_img_".$cnt}	= $UP_URL."/thumb/".trim($row2['p_main_img']);

		$cnt++;
	}

	$no_img = "/img/photo_no.gif";

	$p_img_0 = ( $p_idx_0 ) ? $p_main_img_0 : $no_img;
	$p_img_1 = ( $p_idx_1 ) ? $p_main_img_1 : $no_img;
	$p_img_2 = ( $p_idx_2 ) ? $p_main_img_2 : $no_img;
	$p_img_3 = ( $p_idx_3 ) ? $p_main_img_3 : $no_img;
	$p_img_4 = ( $p_idx_4 ) ? $p_main_img_4 : $no_img;
	$p_img_5 = ( $p_idx_5 ) ? $p_main_img_5 : $no_img;
	$p_img_6 = ( $p_idx_6 ) ? $p_main_img_6 : $no_img;
	$p_img_7 = ( $p_idx_7 ) ? $p_main_img_7 : $no_img;

	$str .= "
	<table width='410' height='147' border='0' cellpadding='0' cellspacing='0' background='/img/bg_today.gif'>
		<tr>
			<td align='center'>
			<table border='0' cellspacing='0' cellpadding='4'>
				<tr>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_0');\"><img src='" . __HTTPURL__  . "$p_img_0' width='85' height='85' border='0' /></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_1');\"><img src='" . __HTTPURL__  . "$p_img_1' width='85' height='85' border='0' /></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_2');\"><img src='" . __HTTPURL__  . "$p_img_2' width='85' height='85' border='0' /></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_3');\"><img src='" . __HTTPURL__  . "$p_img_3' width='85' height='85' border='0' /></a></td>
				</tr>
				<tr>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_0');\">$p_title_0 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_1');\">$p_title_1 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_2');\">$p_title_2 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_3');\">$p_title_3 </a></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>

	<table width='100' height='5' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td></td>
		</tr>
	</table>

	<table width='410' height='147' border='0' cellpadding='0' cellspacing='0' background='/img/bg_today.gif'>
		<tr>
			<td align='center'>
			<table border='0' cellspacing='0' cellpadding='4'>
				<tr>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_4');\"><img src='" . __HTTPURL__  . "$p_img_4' width='85' height='85' border='0'></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_5');\"><img src='" . __HTTPURL__  . "$p_img_5' width='85' height='85' border='0'></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_6');\"><img src='" . __HTTPURL__  . "$p_img_6' width='85' height='85' border='0'></a></td>
					<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_7');\"><img src='" . __HTTPURL__  . "$p_img_7' width='85' height='85' border='0'></a></td>
				</tr>
				<tr>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_4');\">$p_title_4 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_5');\">$p_title_5 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_6');\">$p_title_6 </a></td>
					<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_7');\">$p_title_7 </a></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</div>
	";
	
// ������ ��õ�ڵ� �ϳ� �̻� ������ 
// ����, 8�� �̻��̶�� ������ ��õ�ڵ����� ó���Ѵ�.
// 8�� �����϶� ������ �з��� �ֱٵ����ͷ� ó���Ѵ�.
} else {

	// ��� �������� ���� �� ���Ѵ�.
	for ( $i=1; $i<=$total_page; $i++ ) {
		$p_idx_0 = $p_idx_1 = $p_idx_2 = $p_idx_3 = $p_idx_4 = $p_idx_5 = $p_idx_6 = $p_idx_7 = "";
		$p_title_0 = $p_title_1 = $p_title_2 = $p_title_3 = $p_title_4 = $p_title_5 = $p_title_6 = $p_title_7 = "";
		$p_main_img_0 = $p_main_img_1 = $p_main_img_2 = $p_main_img_3 = $p_main_img_4 = $p_main_img_5 = $p_main_img_6 = $p_main_img_7 = "";

		$str .= "
		<div id='main_today_recom_{$i}' style='display:none;'>
		<table width='424' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='40' align='right' background='/img/title_today.gif' style='padding-right:14;padding-top:7'>
				<table border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='17'><a href=\"javascript:main_today_recom_page_view('$total_page','".($i-1)."');\"><img src='" . __HTTPURL__  . "/img/btn_pre008.gif' width='14' height='14' border='0' /></a></td>
						<td width='14'><a href=\"javascript:main_today_recom_page_view('$total_page','".($i+1)."');\"><img src='" . __HTTPURL__  . "/img/btn_next008.gif' width='14' height='14' border='0' /></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		";

		
		$first = $MAIN_TODAY_RECOM_PAGE_SIZE * ($i-1);
		$last = $MAIN_TODAY_RECOM_PAGE_SIZE * $i;


		// ���ó�¥ ��õ�ڵ� �����Ѵ�.
		$sql = "
		select A.p_idx, A.p_title, A.p_main_img
		from tblProduct A, tblProductEach B, tblProductTodayRecom C
		where 1 $cond
		$orderby limit $first, $MAIN_TODAY_RECOM_PAGE_SIZE 
		";
		//echo "today_recom : ".$sql."<p>";
		$res = $mainconn->query($sql);

		$cnt = 0;
		$duplex_no = "";
		while ( $row = $mainconn->fetch($res) ) {
			${"p_idx_".$cnt}	= trim($row['p_idx']);
			${"p_title_".$cnt}	= cutStringHan(strip_str(trim($row['p_title'])),35);
			${"p_main_img_".$cnt}	= $UP_URL."/thumb/".trim($row['p_main_img']);

			$duplex_no .= ${"p_idx_".$cnt}.",";
			
			$cnt++;
		}

		$duplex_no = substr($duplex_no, 0, strlen($duplex_no)-1);

		// ������ ��õ�ڵ� 8�� �̻� ���Ǹ� ������ ��ŭ �ֱ� �ڵ𿡼� �����´�.
		// ��, �տ� ���� ��õ�ڵ�� ���ܵȴ�.($duplex_no ������ üũ�Ѵ�)
		if ( $i == 1 ) {
			if ( $total_record < $MAIN_TODAY_RECOM_PAGE_SIZE ) {
				$sql2 = "
				select A.p_idx, A.p_title, A.p_main_img
				from tblProduct A, tblProductEach B
				where A.p_idx=B.p_idx and A.p_judgment != 'R'
				and A.p_idx not in ($duplex_no)
				and now() between B.start_dt and B.end_dt
				order by A.p_reg_dt desc limit ".($MAIN_TODAY_RECOM_PAGE_SIZE-$total_record)." 
				";
				$res2 = $mainconn->query($sql2);
				while ( $row2 = $mainconn->fetch($res2) ) {
					${"p_idx_".$cnt} = trim($row2['p_idx']);
					${"p_title_".$cnt} = cutStringHan(strip_str(trim($row2['p_title'])),35);
					${"p_main_img_".$cnt}	= $UP_URL."/thumb/".trim($row2['p_main_img']);

					$cnt++;
				}
			}
		}

		$no_img = "/img/photo_no.gif";

		$p_img_0 = ( $p_idx_0 ) ? $p_main_img_0 : $no_img;
		$p_img_1 = ( $p_idx_1 ) ? $p_main_img_1 : $no_img;
		$p_img_2 = ( $p_idx_2 ) ? $p_main_img_2 : $no_img;
		$p_img_3 = ( $p_idx_3 ) ? $p_main_img_3 : $no_img;
		$p_img_4 = ( $p_idx_4 ) ? $p_main_img_4 : $no_img;
		$p_img_5 = ( $p_idx_5 ) ? $p_main_img_5 : $no_img;
		$p_img_6 = ( $p_idx_6 ) ? $p_main_img_6 : $no_img;
		$p_img_7 = ( $p_idx_7 ) ? $p_main_img_7 : $no_img;

		$str .= "
		<table width='410' height='147' border='0' cellpadding='0' cellspacing='0' background='/img/bg_today.gif'>
			<tr>
				<td align='center'>
				<table border='0' cellspacing='0' cellpadding='4'>
					<tr>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_0');\"><img src='" . __HTTPURL__  . "$p_img_0' width='85' height='85' border='0' /></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_1');\"><img src='" . __HTTPURL__  . "$p_img_1' width='85' height='85' border='0' /></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_2');\"><img src='" . __HTTPURL__  . "$p_img_2' width='85' height='85' border='0' /></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_3');\"><img src='" . __HTTPURL__  . "$p_img_3' width='85' height='85' border='0' /></a></td>
					</tr>
					<tr>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_0');\">$p_title_0 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_1');\">$p_title_1 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_2');\">$p_title_2 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_3');\">$p_title_3 </a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>

		<table width='100' height='5' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>

		<table width='410' height='147' border='0' cellpadding='0' cellspacing='0' background='/img/bg_today.gif'>
			<tr>
				<td align='center'>
				<table border='0' cellspacing='0' cellpadding='4'>
					<tr>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_4');\"><img src='" . __HTTPURL__  . "$p_img_4' width='85' height='85' border='0'></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_5');\"><img src='" . __HTTPURL__  . "$p_img_5' width='85' height='85' border='0'></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_6');\"><img src='" . __HTTPURL__  . "$p_img_6' width='85' height='85' border='0'></a></td>
						<td width='90' height='95' align='center' valign='top'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_7');\"><img src='" . __HTTPURL__  . "$p_img_7' width='85' height='85' border='0'></a></td>
					</tr>
					<tr>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_4');\">$p_title_4 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_5');\">$p_title_5 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_6');\">$p_title_6 </a></td>
						<td width='90' align='center' class='evmem'><a href='#today_recom_pos' onClick=\"codi_view('$p_idx_7');\">$p_title_7 </a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
		";

	}	// for ��

}

$str .= "<script language='javascript'>main_today_recom_page_view('$total_page','1');</script>";

$mainconn->close();


echo $str;
?>

