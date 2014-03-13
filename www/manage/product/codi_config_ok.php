<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/shop_cash_config_ok.php
 * date   : 2008.08.11
 * desc   : Admin shop member cash config process
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_POST['mode']);
$idx = trim($_POST['idx']);

$mainconn->open();

if ( $mode == "E" ) {
	if ( $idx != "" ) {		// 개별 수정	
		$sql = "update tblCashConfig set etc_conf = ".$_POST['etc_conf_'.$idx].", cash = ".$_POST['cash_'.$idx]." where cc_cid = '$idx'";
		$mainconn->query($sql);
		goto_url("codi_config.php");

	} else {		// 전체 수정
		foreach ( $_POST as $k => $v ) {
			if ( substr($k, 0, 4) == "cash" ) {
				$sql = "update tblCashConfig set cash = $v where cc_cid = '".substr($k, 5)."'";
				$mainconn->query($sql);
			} else if ( substr($k, 0, 8) == "etc_conf" ) {
				$sql = "update tblCashConfig set etc_conf = $v where cc_cid = '".substr($k, 9)."'";
				$mainconn->query($sql);
			}
			goto_url("codi_config.php");
		}
	}
}

require_once "../_bottom.php";