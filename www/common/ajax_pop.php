<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/common/ajax_pop.php
 * date   : 2008.08.27
 * desc   : ajax를 이용한 레이어 팝업
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 관리자 인증여부 체크
//auth_chk();

// 리퍼러 체크
referer_chk();

$pop_idx	= trim($_REQUEST['pop_idx']);
$TXT = "";
$tmp_str = "";

$mainconn->open();

if ( $pop_idx ) {
	$sql = "select * from tblPopup where pop_idx = $pop_idx ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$pop_kind = trim($row['pop_kind']);
	$pop_display_opt = trim($row['pop_display_opt']);
	$pop_today_opt = trim($row['pop_today_opt']);
	$pop_width = trim($row['pop_width']);
	$pop_height = trim($row['pop_height']);
	$pop_top = trim($row['pop_top']);
	$pop_left = trim($row['pop_left']);

	if ( $pop_kind == "L" ) {
		if ( $fp = fopen($TPL_DIR."/pop_".$pop_idx.".txt", "r") ) {
			$tmp_str = fread($fp, 10000);
			fclose($fp);
		}
		$TXT .= "L$^!".$tmp_str."^|";
	} else {
		$TXT .= "W$^!".$pop_width."$^!".$pop_height."$^!".$pop_top."$^!".$pop_left."$^!".$pop_idx."^|";
	}

} else {
	

	$sql = "select * from tblPopup where pop_status = 'Y' and  now() BETWEEN pop_start_dt AND pop_end_dt order by pop_idx desc ";
	$res = $mainconn->query($sql);

	//echo $sql;

	$cnt = 0;
	while ( $row = $mainconn->fetch($res) ) {
		
		$pop_idx = trim($row['pop_idx']);
		$pop_kind = trim($row['pop_kind']);
		$pop_display_opt = trim($row['pop_display_opt']);
		$pop_today_opt = trim($row['pop_today_opt']);
		$pop_width = trim($row['pop_width']);
		$pop_height = trim($row['pop_height']);
		$pop_top = trim($row['pop_top']);
		$pop_left = trim($row['pop_left']);

		if ( $pop_kind == "L" && !$cnt ) {	// 처음이고 레이어이면
			if ( $fp = fopen($TPL_DIR."/pop_".$pop_idx.".txt", "r") ) {
				$tmp_str = fread($fp, 10000);
				fclose($fp);
			}
			$TXT .= "L$^!".$tmp_str."^|";
			$cnt++;
		} else {	// 그렇지 않으면(두번째 이후이거나 처음이라도 윈도우면)
			$TXT .= "W$^!".$pop_width."$^!".$pop_height."$^!".$pop_top."$^!".$pop_left."$^!".$pop_idx."^|";
		}
	}
}

$mainconn->close();
echo $TXT;
?>
