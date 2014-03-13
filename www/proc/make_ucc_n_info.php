<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_ucc_n_info.php
 * date   : 2009.01.06
 * desc   : 메인 코디UCC 및 정보링크 proc
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";
$mainconn->open();

$str = "
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='285' valign='top'>
		<table width='271' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td height='40'><a href='#' onClick=\"go_ucc('');\"><img src='" . __HTTPURL__  . "/images/box_ucc_01.gif' alt='코디 UCC' width='271' height='40' border='0'></a></td>
			</tr>
			<tr>
				<td align='center' background='/images/box_ucc_02.gif'>
				<table width='100' height='7' border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td></td>
					</tr>
				</table>
				<table width='250' border='0' cellspacing='0' cellpadding='0'>
";


$sql = "select ucc_idx, ucc_title, unix_timestamp(ucc_reg_dt) as ucc_timestamp from tblUcc order by ucc_reg_dt desc limit 5";
$res = $mainconn->query($sql);

$time = time();

while ( $rows = $mainconn->fetch($res) ) {
	$ucc_idx		= trim($rows['ucc_idx']);
	$ucc_title		= strip_str(trim($rows['ucc_title']));
	$ucc_timestamp	= trim($rows['ucc_timestamp']);

	if ( ($time - $ucc_timestamp) < $UCC_NEW_STAMP ) {
		$icon = "<img src='" . __HTTPURL__  . "/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$ucc_title = cutStringHan($ucc_title, 35);
	} else {
		$icon = "";
		$ucc_title = cutStringHan($ucc_title, 38);
	}
	
	$str .= "
	<tr>
		<td height='20'><img src='" . __HTTPURL__  . "/img/barbar.gif' width='7' height='3' align='absmiddle'><a href='#' onClick=\"go_ucc_view('$ucc_idx');\">$ucc_title </a> $icon</td>
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
				<td height='7'><img src='" . __HTTPURL__  . "/images/box_ucc_03.gif' width='271' height='7' alt=''></td>
			</tr>
		</table>
		</td>
		<td align='right' valign='top'>
		<table width='360' height='165' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td><a href='#' onClick='go_user_guide();'><img src='" . __HTTPURL__  . "/images/coustomer_01.gif' width='213' height='51' alt='이용안내' border='0' /></a></td>
				<td><a href='#' onClick='go_user_guide();'><img src='" . __HTTPURL__  . "/images/coustomer_02.gif' alt='일반회원이용안내' width='147' height='51' border='0'></a></td>
			</tr>
			<tr>
				<td><img src='" . __HTTPURL__  . "/images/coustomer_03.gif' width='213' height='53' alt=''></td>
				<td><a href='#' onClick='go_shop_guide();'><img src='" . __HTTPURL__  . "/images/coustomer_04.gif' alt='샵회원이용안내' width='147' height='53' border='0'></a></td>
			</tr>
			<tr>
				<td><a href='#' onClick='go_bad_shop();'><img src='" . __HTTPURL__  . "/images/coustomer_05.gif' alt='불량샵 신고' width='213' height='61' border='0'></a></td>
				<td><a href='#' onClick='go_faq();'><img src='" . __HTTPURL__  . "/images/coustomer_06.gif' alt='FAQ' width='147' height='61' border='0'></a></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
";


$mainconn->close();
echo $str;
?>
