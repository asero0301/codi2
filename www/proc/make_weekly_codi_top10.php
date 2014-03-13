<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_weekly_codi_top10.php
 * date   : 2008.10.23
 * desc   : 주간 코디 top10을 만드는 proc 스크립트
 *******************************************************/
require_once "/coditop/inc/common.inc.php";
$mainconn->open();

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

$prt_f_date = str_replace("-",".",$f_date);
$prt_l_date = str_replace("-",".",$l_date);

$f_full_date = $f_date." 00:00:00";
$l_full_date = $l_date." 23:59:59";

$str = "
<table width='200' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td><img src='/img/week_codi01.gif' ></td>
	</tr>
	<tr>
		<td height='200' align='center' valign='top' background='/img/week_codi02.gif'>
		<table width='180' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='10'></td>
			</tr>
			<tr>
				<td align='center' class='date'><b>$prt_f_date ~ $prt_l_date</b></td>
			</tr>
			<tr>
				<td height='5'></td>
			</tr>
			<tr>
				<td height='1' background='/img/dot00.gif'></td>
			</tr>
			<tr>
				<td height='10'></td>
			</tr>
		</table>
		<table width='180' border='0' cellspacing='0' cellpadding='0'>
";

// tblProduct, tblRankProduct, tblProductUpDown
$sql = "
select A.p_idx, A.p_title, A.p_main_img, B.rp_rank,
(select count(*) from tblProductUpDown where p_idx = A.p_idx and p_u_reg_dt between '$f_full_date' and '$l_full_date') as up_cnt
from tblProduct A, tblRankProduct B
where 1
and A.p_idx = B.p_idx
and rp_start_dt = '$f_date' and rp_end_dt = '$l_date'
order by B.rp_rank asc, A.p_idx desc 
limit 10
";
$res = $mainconn->query($sql);

while ( $rows = $mainconn->fetch($res) ) {
	$p_idx = trim($rows['p_idx']);
	$p_title = trim($rows['p_title']);
	$p_main_img = trim($rows['p_main_img']);
	$rp_rank = trim($rows['rp_rank']);
	$up_cnt = trim($rows['up_cnt']);

	$p_main_img = $UP_URL."/thumb/".$p_main_img;
	$p_title	= cutStringHan($p_title,35);

	$str .= "
	<tr>
		<td width='60'>
		<table width='50' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
			<tr>
				<td bgcolor='#FFFFFF'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='50' height='50' border='0'></a></td>
			</tr>
		</table>
		</td>
		<td>
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td class='shopname'><img src='/img/nomber_0{$rp_rank}.gif'  align='absmiddle' /> <a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
			</tr>
			<tr>
				<td class='shopname'><b><span class='evfont'>코디업 :</span> <font color='#CC3300'>$up_cnt</font></b></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='6' colspan='2'></td>
	</tr>
	";
}

$str .= "
		</table>
		</td>
	</tr>
	<tr>
		<td><img src='/img/week_codi04.gif' width='200' height='13'></td>
	</tr>
</table>
";


$mainconn->close();


echo $str;
?>
