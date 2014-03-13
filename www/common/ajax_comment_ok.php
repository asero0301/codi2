<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/common/ajax_comment_ok.php
 * date   : 2008.08.21
 * desc   : ajax comment process
 *******************************************************/
session_start();
ini_set("default_charset", "utf-8");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk();
auth_chk($RURL);

// 리퍼러 체크
referer_chk();

$kind		= trim($_REQUEST['kind']);
$mode		= trim($_REQUEST['mode']);
$p_idx		= trim($_REQUEST['p_idx']);
$pc_idx		= trim($_REQUEST['pc_idx']);
$pc_comment	= trim($_REQUEST['pc_comment']);	// addslashes 없어도 된다.
//$c_score	= trim($_REQUEST['c_score']);



// iconv - define public.inc.php
$pc_comment = iconv("utf-8", "euc-kr", $pc_comment);


$mem_id		= trim($_SESSION['mem_id']);
if ( !$mem_id ) $mem_id = trim($_SESSION['admin_id']);

$mainconn->open();

//echo "kind:[$kind]==mode:[$mode]==p_idx:[$p_idx]==pc_comment:[$pc_comment]";

if ( $kind == "N" ) {

	if ( $mode == "I" ) {
		$sql = "
			insert into tblNoticeComment 
			(notice_idx,mem_id,notice_c_comment,notice_c_ip,notice_c_reg_dt)
			values
			($p_idx,'$mem_id','$pc_comment','$_SERVER[REMOTE_ADDR]',now())
			";
		if ( $mainconn->query($sql) ) {
			echo "1";
		}

	} else if ( $mode == "E" ) {

	} else if ( $mode == "D" ) {
		$sql = "delete from tblNoticeComment where notice_c_idx = $pc_idx";
		$mainconn->query($sql);

		echo "1";
	} else {

	}

} else if ( $kind == "U" ) {
	if ( $mode == "I" ) {
		$sql = "
			insert into tblUccComment 
			(ucc_idx,mem_id,ucc_c_comment,ucc_c_ip,ucc_c_reg_dt)
			values
			($p_idx,'$mem_id','$pc_comment','$_SERVER[REMOTE_ADDR]',now())
			";
		if ( $mainconn->query($sql) ) {
			echo "1";
		}
	} else if ( $mode == "D" ) {
		$sql = "delete from tblUccComment where ucc_c_idx = $pc_idx";
		$mainconn->query($sql);

		echo "1";
	}
} else if ( $kind == "P" ) {

	if ( $mode == "I" ) {
		$sql = "
			insert into tblPrComment 
			(pr_idx,mem_id,pr_c_comment,pr_c_ip,pr_c_reg_dt)
			values
			($p_idx,'$mem_id','$pc_comment','$_SERVER[REMOTE_ADDR]',now())
			";
		if ( $mainconn->query($sql) ) {
			echo "1";
		}

	} else if ( $mode == "E" ) {

	} else if ( $mode == "D" ) {
		$sql = "delete from tblPrComment where pr_c_idx = $pc_idx";
		$mainconn->query($sql);

		echo "1";
	} else {

	}
} else if ( $kind == "B" ) {

	if ( $mode == "I" ) {
		$sql = "
			insert into tblBadShopComment 
			(bad_idx,mem_id,bad_c_comment,bad_c_ip,bad_c_reg_dt)
			values
			($p_idx,'$mem_id','$pc_comment','$_SERVER[REMOTE_ADDR]',now())
			";
		if ( $mainconn->query($sql) ) {
			echo "1";
		}

	} else if ( $mode == "E" ) {

	} else if ( $mode == "D" ) {
		$sql = "delete from tblBadShopComment where bad_c_idx = $pc_idx";
		$mainconn->query($sql);

		echo "1";
	} else {

	}
}

$mainconn->close();
?>
