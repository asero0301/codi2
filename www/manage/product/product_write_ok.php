<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/product/product_write_ok.php
 * date   : 2008.08.20
 * desc   : 관리자가 제품을 입력/수정/삭제

 삭제시 적용받는 테이블
 - tblProduct, tblProductEach, tblGiftTracking
 - tblProductComment, tblMemberScore

 삭제시 적용받지 않는 테이블
 - tblCash (관리자에 의한경우 캐시테이블은 적용되지 않음)
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";
require_once "../../inc/util.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
$kind			= trim($_POST['kind']);
$sel_idx		= trim($_POST['sel_idx']);

//echo "mode : $mode \t kind : $kind \t sel_idx : $sel_idx \t";

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

if ( $mode == "D" ) {
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		// tblProduct 테이블 삭제
		$sql = "delete from tblProduct where p_idx = $v";
		$mainconn->query($sql);

		// tblProductEach의 p_e_idx 값을 구한다.
		$sql = "select p_e_idx from tblProductEach where p_idx = $v";
		$res = $mainconn->query($sql);
		$p_e_idx_list = "";
		while ( $row = $mainconn->fetch($res) ) {
			$p_e_idx_list .= trim($row['p_e_idx']).",";
		}
		$p_e_idx_list = substr($p_e_idx_list,0,strlen($p_e_idx_list)-1);

		// tblProductEach 테이블 삭제
		$sql = "delete from tblProductEach where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblGiftTracking 테이블 삭제
		$sql = "delete from tblGiftTracking where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblMemberScore 테이블 삭제
		$sql = "delete from tblMemberScore where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblProductComment 테이블 삭제
		$sql = "delete from tblProductComment where p_idx = $v ";
		$mainconn->query($sql);

	}
}


//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////





$mainconn->close();

goto_url("wait_list.php");
//require_once "../_bottom.php";
?>