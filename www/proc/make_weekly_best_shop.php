<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_weekly_best_shop.php
 * date   : 2008.10.17
 * desc   : 메인 "주간 베스트 샵" 만드는 proc 스크립트
 *			주의 -  파일생성시간을 체크하는게 아니고 
 *					perl 스크립트 생성시 마지막 부분에 자동생성
 *			/www/sites/coditop_cron/weekly_shop_rank.pl에 삽입되어 있다.
 *			현재는 사용하지 않음.....
 *******************************************************/
require_once "/coditop/inc/common.inc.php";
$mainconn->open();

$ret_arr = getWeekDay("last", time());

$f_date = $ret_arr[0];
$l_date = $ret_arr[1];

$sql = "select count(*) from tblRankShop where rs_start_dt = '$f_date' and rs_end_dt = '$l_date'";
$record_cnt = $mainconn->count($sql);

if ( $record_cnt == 0 ) {
	$ret_arr = getWeekDay("last", time()-86400);
	$f_date = $ret_arr[0];
	$l_date = $ret_arr[1];
}


$str = "
<table width='200' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td height='36'><a href='#' onClick=\"go_best_shop();\"><img src='/images/week_bestshop_01.gif' alt='주간 베스트샵' width='200' height='36' border='0'></a></td>
	</tr>
	<tr>
		<td align='center' background='/images/week_bestshop_02.gif'>
		<table width='170' border='0' cellspacing='0' cellpadding='0'>
		";


$sql = "select *,(select shop_name from tblShop where shop_idx = tblRankShop.shop_idx) as shop_name from tblRankShop where rs_start_dt = '$f_date' and rs_end_dt = '$l_date' limit 9";

$res = $mainconn->query($sql);

while ( $rows = $mainconn->fetch($res) ) {
	$rs_idx = trim($rows['rs_idx']);
	$shop_idx = trim($rows['shop_idx']);
	$shop_name = trim($rows['shop_name']);
	$rs_score = trim($rows['rs_score']);
	$rs_rank = trim($rows['rs_rank']);
	$rs_last_score = trim($rows['rs_last_score']);
	$rs_last_rank = trim($rows['rs_last_rank']);

	if ( $rs_last_rank == 0 ) {
		$rank_icon = "icon_plus.gif";
		$abs = "↑";
	} else {
		if ( $rs_rank < $rs_last_rank ) {
			$rank_icon = "icon_plus.gif";
		} else if ( $rs_rank > $rs_last_rank ) {
			$rank_icon = "icon_minus.gif";
		} else {
			$rank_icon = "icon_tie.gif";
		}
		$abs = abs($rs_rank - $rs_last_rank);
	}

	$str .= "
			<tr>
				<td width='17' height='20'><img src='/img/nomber_0{$rs_rank}.gif' width='12' height='12'></td>
				<td class='shopname'><b><font color='#333333'><a href='#'>$shop_name</a></font></b></td>
				<td width='20' align='center'><img src='/img/$rank_icon' width='10' height='10'></td>
				<td width='30' align='center' class='nomber'>$abs</td>
			</tr>
			<tr>
				<td height='1' colspan='4' background='/img/dot_garo_mini.gif'></td>
			</tr>
				";

}

$str .= "
		</table>
		</td>
	</tr>
	<tr>
		<td height='13'><img src='/images/week_bestshop_03.gif' width='200' height='13' alt=''></td>
	</tr>
</table>
";


$mainconn->close();


echo $str;
?>
