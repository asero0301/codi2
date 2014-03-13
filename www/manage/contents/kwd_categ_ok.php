<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/kwd_categ_ok.php
 * date   : 2008.08.25
 * desc   : Admin kwd categ insert/update/delete
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();

$mode			= trim($_POST['mode']);
$sel_idx		= trim($_POST['sel_idx']);

$kwd_categ		= trim($_POST['kwd_categ']);
$kwd_kind	= trim($_POST['kwd_kind']);
$kwd	= addslashes(trim($_POST['kwd']));

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

if ( $mode == "I" ) {
	$sql = "select count(*) from tblKwd where kwd = '$kwd'";
	$cnt = $mainconn->count($sql);
	if ( $cnt != "0" ) {
		echo "<script>alert('�̹� ��ϵ� Ű���� �Դϴ�'); history.go(-1);</script>";
		exit;
	}
	$sql = "
		insert into tblKwd (kwd_categ,kwd_kind,kwd,kwd_status,kwd_reg_dt) values 
		('$kwd_categ','$kwd_kind','$kwd','Y',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblKwd set 
			kwd_categ = '$kwd_categ', kwd_kind = '$kwd_kind', kwd = '$kwd'
		where kwd_idx = $sel_idx
		";
	$mainconn->query($sql);

}

//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

$mainconn->close();

goto_url("kwd_categ.php");
//require_once "../_bottom.php";
?>