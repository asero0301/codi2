<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_weekly_best_shop.php
 * date   : 2009.01.06
 * desc   : 메인 공지사항 proc
 *******************************************************/


require_once "../inc/common.inc.php";
require_once "../config/config.php";


$mainconn->open();

$str = "
<table width='200' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td height='39'><a href='#' onClick='go_notice();'><img src='" . __HTTPURL__  . "/images/notice_01.gif' alt='공지사항' width='200' height='39' border='0'></a></td>
	</tr>
	<tr>
		<td align='center' background='/images/notice_02.gif'>
		<table width='100' height='7' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>
		<table width='180' border='0' cellspacing='0' cellpadding='0'>
";


$sql = "select notice_idx, notice_title, unix_timestamp(notice_reg_dt) as notice_timestamp from tblNotice order by notice_reg_dt desc limit 5";
$res = $mainconn->query($sql);

$time = time();

while ( $rows = $mainconn->fetch($res) ) {
	$notice_idx			= trim($rows['notice_idx']);
	$notice_title		= strip_str(trim($rows['notice_title']));
	$notice_timestamp	= trim($rows['notice_timestamp']);

	if ( ($time - $notice_timestamp) < $NOTICE_NEW_STAMP ) {
		$icon = "<img src='" . __HTTPURL__  . "/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$notice_title = cutStringHan($notice_title, 22);
	} else {
		$icon = "";
		$notice_title = cutStringHan($notice_title, 28);
	}
	
	$str .= "
	<tr>
		<td height='20'><img src='" . __HTTPURL__  . "/img/barbar.gif' width='7' height='3' align='absmiddle'><a href='#' onClick=\"go_notice_view('$notice_idx');\">$notice_title </a>$icon</td>
	</tr>
	";

}

$str .= "
		</table>
		<table width='100' height='7' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='6'><img src='" . __HTTPURL__  . "/images/notice_03.gif' width='200' height='6' alt=''></td>
	</tr>
</table>
";


$mainconn->close();
echo $str;
?>
