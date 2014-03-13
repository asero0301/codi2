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

// ���۷� üũ
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
		echo "<script>alert('���������� �����Դϴ�.'); location.href='/main.php';</script>";
		exit;
	}
}


if ( !ereg("([^[:space:]]+)", $mem_id) ) {
	echo "<script>alert('���̵� �߸��Ǿ����ϴ�'); history.go(-1);</script>";
	exit;
}

if ( $mem_pwd ) {
	if ( !ereg("(^[0-9a-zA-Z]{6,}$)", $mem_pwd) ) {
		echo "<script>alert('��й�ȣ�� �߸��Ǿ����ϴ�'); history.go(-1);</script>";
		exit;
	}
}

if ( $mem_pwd && $mem_re_pwd ) {
	if ( $mem_pwd != $mem_re_pwd ) {
		echo "<script>alert('��й�ȣ�� ��ġ���� �ʽ��ϴ�.'); history.go(-1);</script>";
		exit;
	}
}

//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

if ( $mode == "I" ) {
	$sql = "
		insert into tblMember
		(mem_id,mem_pwd,mem_kind,mem_name,mem_jumin,mem_email,mem_mobile,zipcode,mem_addr1,mem_addr2,mem_recom_id,mem_mailing,mem_reg_dt,last_reg_dt)

		values
		('$mem_id','$mem_pwd','$mem_kind','$mem_name','$mem_jumin','$mem_email','$mem_mobile','$zipcode','$mem_addr1','$mem_addr2','$mem_recom_id','$mem_mailing',now(),now())
		";
	$str = "�����մϴ�. ȸ������ �Ǿ����ϴ�.";
} else if ( $mode == "E" ) {
	// ����
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
	$str = "ȸ�������� �����Ǿ����ϴ�.";
} else if ( $mode == "B" ) {
	// ���
	$sql = "update tblMember set mem_status = 'D' where mem_id='$mem_id'";
	$str = "�Ͻ����� �Ǿ����ϴ�.";
} else {
	// Ż��
	$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
	$str = "Ż�� �Ǿ����ϴ�.";
}

$mainconn->query($sql);

$mainconn->close();

echo "<script>alert('$str');</script>";
goto_url("/mypage/mypage.php");
//require_once "../_bottom.php";
?>