<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/user_ok.php
 * date   : 2008.10.06
 * desc   : member insert/update
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
$mem_key		= trim($_POST['mem_key']);

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

$mem_kind		= trim($_POST['mem_kind']);
$mem_id			= trim($_POST['mem_id']);
$mem_pwd		= trim($_POST['mem_pwd']);
$mem_re_pwd		= trim($_POST['mem_re_pwd']);
$mem_name		= trim($_POST['mem_name']);
$mem_jumin		= trim($_POST['mem_jumin']);

$mail_id		= trim($_POST['mail_id']);
$mail_host		= trim($_POST['mail_host']);
$mem_email = $mail_id."@".$mail_host;

$mem_recom_id	= trim($_POST['mem_recom_id']);
$mem_mailing	= trim($_POST['mem_mailing']);
if ( $mem_mailing != "Y" ) $mem_mailing = "N";

$mobile_1		= trim($_POST['mobile_1']);
$mobile_2		= trim($_POST['mobile_2']);
$mobile_3		= trim($_POST['mobile_3']);
$mem_mobile		= $mobile_1."-".$mobile_2."-".$mobile_3;

$zipcode		= trim($_POST['zipcode']);
$mem_addr1		= trim($_POST['mem_addr1']);
$mem_addr2		= trim($_POST['mem_addr2']);

/*
foreach ( $_POST as $k => $v ) {
	echo "$k:$v<br>";
}
exit;
*/

if ( $mode == "I" ) {
	$this_mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);

	if ( $this_mem_key != $mem_key ) {
		echo "<script>alert('비정상적인 접근입니다.'); location.href='/main.php';</script>";
		exit;
	}
}


if ( !ereg("([^[:space:]]+)", $mem_id) ) {
	echo "<script>alert('아이디가 잘못되었습니다'); history.go(-1);</script>";
	exit;
}

if ( $mem_pwd ) {
	if ( !ereg("(^[0-9a-zA-Z]{6,}$)", $mem_pwd) ) {
		echo "<script>alert('비밀번호가 잘못되었습니다'); history.go(-1);</script>";
		exit;
	}
}

if ( $mem_pwd && $mem_re_pwd ) {
	if ( $mem_pwd != $mem_re_pwd ) {
		echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.go(-1);</script>";
		exit;
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

if ( $mode == "I" ) {
	$sql = "
		insert into tblMember
		(mem_id,mem_pwd,mem_kind,mem_name,mem_jumin,mem_email,mem_mobile,zipcode,mem_addr1,mem_addr2,mem_recom_id,mem_mailing,mem_reg_dt,last_reg_dt)

		values
		('$mem_id','$mem_pwd','$mem_kind','$mem_name','$mem_jumin','$mem_email','$mem_mobile','$zipcode','$mem_addr1','$mem_addr2','$mem_recom_id','$mem_mailing',now(),now())
		";
	$str = "축하합니다. 회원가입 되었습니다.";
} else if ( $mode == "E" ) {
	// 수정
	if ( $mem_pwd ) {
		$pwd_str = " mem_pwd='$mem_pwd', ";
	} else {
		$pwd_str = "";
	}
	$sql = "
		update tblMember set
		$pwd_str mem_email='$mem_email',mem_mobile='$mem_mobile',zipcode='$zipcode',mem_addr1='$mem_addr1',mem_addr2='$mem_addr2',mem_mailing='$mem_mailing'
		where mem_id='$mem_id'
		";
	$str = "회원정보가 수정되었습니다.";
} else if ( $mode == "B" ) {
	// 블록
	$sql = "update tblMember set mem_status = 'D' where mem_id='$mem_id'";
	$str = "일시정지 되었습니다.";
} else {
	// 탈퇴
	$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
	$str = "탈퇴 되었습니다.";
}

$mainconn->query($sql);

$mainconn->close();

echo "<script>alert('$str');</script>";
goto_url("/mypage/mypage.php");
//require_once "../_bottom.php";
?>