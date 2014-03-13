<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_sub_today_codi.php
 * date   : 2009.01.08
 * desc   : 오늘의 추천코디 html 생성
 *******************************************************/
require_once "../inc/common.inc.php";
$mainconn->open();

$today = date("Y-m-d", time());
$today_str = str_replace("-", ".", $today);

$sql = "select count(*) from tblProductTodayRecom where p_tr_today = '$today' ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$SUB_TODAY_RECOM_PAGE_SIZE);

$cond = " and A.p_idx = B.p_idx and A.p_judgment = 'Y' and B.p_e_idx = C.p_e_idx and C.p_tr_today = '$today' ";
$orderby = " order by C.p_tr_idx desc ";

$str = "";
for ( $i=1; $i<=$total_page; $i++ ) {
	$str .= "
	<div id='sub_codi_of_today_area_$i' style='display:none;'>
	<table width='200' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td height='41' align='right' background='/img/today_codi01.gif' style='padding-right:6'>
			<table border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='20'><a href=\"javascript:sub_today_recom_page_view('$total_page','".($i-1)."');\"><img src='/img/btn_pre007.gif' width='18' height='13' border='0'></a></td>
					<td width='18'><a href=\"javascript:sub_today_recom_page_view('$total_page','".($i+1)."');\"><img src='/img/btn_next007.gif' width='18' height='13' border='0'></a></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td height='215' align='center' valign='top' background='/img/week_codi02.gif'>
			<table width='180' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td align='center'><img src='/img/icon_calender.gif'  align='absmiddle'><b><font color='#333333'>Today</font><font color='#FF0033'> $today_str</font></b> </td>
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

	
	$first = $SUB_TODAY_RECOM_PAGE_SIZE * ($i-1);
	$last = $SUB_TODAY_RECOM_PAGE_SIZE * $i;


	// 오늘날짜 추천코디만 검출한다.
	$sql = "
	select A.p_idx, A.p_title, A.p_main_img
	from tblProduct A, tblProductEach B, tblProductTodayRecom C
	where 1 $cond
	$orderby limit $first, $SUB_TODAY_RECOM_PAGE_SIZE 
	";
	//echo "today_recom : ".$sql."<p>";
	$res = $mainconn->query($sql);

	while ( $row = $mainconn->fetch($res) ) {
		$p_idx = $row['p_idx'];
		$p_title = strip_str(trim($row['p_title']));
		$p_title = cutStringHan($p_title, 60);
		$p_main_img = $UP_URL."/thumb/".trim($row['p_main_img']);

		$str .= "
		<tr>
			<td width='60'>
			<table width='50' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
				<tr>
					<td bgcolor='#FFFFFF'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='50' height='50' border='0'></a></td>
				</tr>
			</table>
			</td>
			<td class='shopname'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a></td>
		</tr>
		<tr>
			<td height='5' colspan='2'></td>
		</tr>
		";
	}

	$str .= "
			</table>
			</td>
		</tr>
		<tr>
			<td><img src='/img/week_codi04.gif' width='200' height='13' /></td>
		</tr>
	</table>
	</div>
	";

}	// for

$str .= "<script language='javascript'>sub_today_recom_page_view('$total_page','1');</script>";

$mainconn->close();
echo $str;
?>
