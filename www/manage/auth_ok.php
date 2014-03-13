<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/auth_ok.php
 * date   : 2008.08.07
 * desc   : Admin Authentication Process
 *******************************************************/
session_start();

// require
require_once "../inc/common.inc.php";

// referer check
referer_chk();

$admin_id = trim($_POST['admin_id']);
$admin_pwd = trim($_POST['admin_pwd']);
$admin_idsave = trim($_POST['admin_idsave']);

// sql injection check
sql_injection_chk($admin_id, $admin_pwd);


// authentication process
$mainconn->open();

$sql = "select count(*) from tblAdmin where admin_id = '$admin_id' and admin_pwd = '$admin_pwd';";
$cnt = $mainconn->count($sql);


if ( $cnt == "0" ) {
	echo "<script>alert('관리자 인증에 실패했습니다.'); history.go(-1);</script>";
	exit;
} else {
	$res = $mainconn->query("select admin_id,admin_name,admin_level from tblAdmin where admin_id = '$admin_id' and admin_pwd = '$admin_pwd';");
	$row = $mainconn->fetch($res);


	$admin_id = $row['admin_id'];
	$admin_name = $row['admin_name'];
	$admin_level = $row['admin_level'];

	$_SESSION['admin_id'] = $admin_id;
	$_SESSION['admin_name'] = $admin_name;
	$_SESSION['admin_level'] = $admin_level;
	$_SESSION['mem_id'] = $admin_id;
	$_SESSION['mem_name'] = $admin_name;

	session_register("admin_id","admin_name","admin_level","mem_id","mem_name");

	if ( $admin_idsave == "Y" ) {
		setCookie("admin_idsave", $admin_id, time()+86400*30, "/", "coditop10.com");
	}

	// 최근 로그인 기록을 추가한다.
	$sql = "insert into tblLoginLog (log_id,log_reg_dt,log_ip) values ('$admin_id',now(),'$_SERVER[REMOTE_ADDR]')";
	$mainconn->query($sql);

	// redirect
	goto_url($ADMIN_MAIN_URL);
}

$mainconn->close();
?>
