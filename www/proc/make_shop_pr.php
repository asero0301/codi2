<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_shop_pr.php
 * date   : 2009.01.06
 * desc   : ¸ÞÀÎ ¼¥ PR proc
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";
$mainconn->open();

$str = "
<table width='205' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td><a href='#' onClick='go_shop_pr();'><img src='" . __HTTPURL__  . "/img/title_pr.jpg' alt='¼¥È¸¿ø PR' width='205' height='98' border='0'></a></td>
	</tr>
</table>
<table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td></td>
	</tr>
</table>

<table width='205' border='0' cellspacing='0' cellpadding='0'>
";


$sql = "select pr_idx, pr_title, unix_timestamp(pr_reg_dt) as pr_timestamp from tblPr order by pr_reg_dt desc limit 9";
$res = $mainconn->query($sql);

$time = time();

while ( $rows = $mainconn->fetch($res) ) {
	$pr_idx			= trim($rows['pr_idx']);
	$pr_title		= strip_str(trim($rows['pr_title']));
	$pr_timestamp	= trim($rows['pr_timestamp']);

	if ( ($time - $pr_timestamp) < $PR_NEW_STAMP ) {
		$icon = "<img src='" . __HTTPURL__  . "/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$pr_title = cutStringHan($pr_title, 25);
	} else {
		$icon = "";
		$pr_title = cutStringHan($pr_title, 30);
	}
	
	$str .= "
	<tr>
		<td width='15' height='23'><img src='" . __HTTPURL__  . "/img/arr_arow.gif' width='8' height='10'></td>
		<td ><font color='#333333'><a href='#' onClick=\"go_shop_pr_view('$pr_idx');\">$pr_title </a></font>$icon</td>
	</tr>
	<tr>
		<td height='1' colspan='2' background='/img/dot_garo_mini.gif'></td>
	</tr>
	";

}

$str .= "</table>";


$mainconn->close();
echo $str;
?>
