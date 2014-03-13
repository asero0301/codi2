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
$data			= trim($_POST['data']);


$font	= trim($_POST['font']);
$kwd	= addslashes(trim($_POST['kwd']));

switch ( $font ) {
	case "2" :
		$kwd = "<strong>$kwd</strong>";
		break;
	case "3" :
		$kwd = "<b><font color=#3366CC>$kwd</font></b>";
		break;
	case "4" :
		$kwd = "<b><font color=#FF3300>$kwd</font></b>";
		break;
	default :
		break;
}

$tmp_arr = explode(";", $data);

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
	// �ϴ� ���δ� Y�� ����
	$sql = "update tblKwd set kwd_status = 'Y',kwd_reg_dt = now() where kwd_status != 'N'";
	$mainconn->query($sql);

	foreach ( $tmp_arr as $k => $v ) {
		if ( trim($v) == "" ) continue;
		$t_arr = explode(":", trim($v));
		$kwd_idx = trim($t_arr[0]);
		$kwd = trim($t_arr[1]);
		$sql = "
			update tblKwd set 
				kwd_status = 'M', kwd = '$kwd'
			where kwd_idx = $kwd_idx
			";
		$mainconn->query($sql);
	}

}


//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////


// html ������ �����.
require_once "../../proc/make_main_kwd.php";


$mainconn->close();

goto_url("kwd_main.php");
//require_once "../_bottom.php";
?>