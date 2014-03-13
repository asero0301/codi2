<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member_write_ok.php
 * date   : 2008.08.12
 * desc   : Admin member insert/update
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";
require_once "../../inc/util.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

$mem_id			= trim($_POST['mem_id']);
$mem_pwd		= trim($_POST['mem_pwd']);
$mem_kind		= trim($_POST['mem_kind']);
$mem_name		= trim($_POST['mem_name']);
$mem_jumin		= trim($_POST['mem_jumin']);
$mem_email		= trim($_POST['mem_email']);
$mem_mobile		= trim($_POST['mem_mobile']);
$zipcode		= trim($_POST['zipcode']);
$mem_addr1		= trim($_POST['mem_addr1']);
$mem_addr2		= trim($_POST['mem_addr2']);
$mem_recom_id	= trim($_POST['mem_recom_id']);
$mem_mailing	= trim($_POST['mem_mailing']);
$mem_status		= trim($_POST['mem_status']);
$mem_grade		= trim($_POST['mem_grade']);
$mem_cash		= trim($_POST['mem_cash']);
$mem_score		= trim($_POST['mem_score']);

if ( !ereg("([^[:space:]]+)", $mem_id) ) {
	echo "<script>alert('아이디가 잘못되었습니다'); history.go(-1);</script>";
	exit;
}

if ( !ereg("(^[0-9a-zA-Z]{6,}$)", $mem_pwd) ) {
	echo "<script>alert('비밀번호가 잘못되었습니다'); history.go(-1);</script>";
	exit;
}

if ( $mem_kind != "U" && $mem_kind != "S" && $mem_kind != "A" ) {
	echo "<script>alert('회원구분이 잘못되었습니다.'); history.go(-1);</script>";
	exit;
}

if ( !ereg("([^[:space:]]+)", $mem_name) ) {
	echo "<script>alert('이름이 잘못되었습니다'); history.go(-1);</script>";
	exit;
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

if ( $mode == "I" ) {
	$sql = "
		insert into tblMember
		(mem_id,mem_pwd,mem_kind,mem_name,mem_jumin,mem_email,mem_mobile,zipcode,mem_addr1,mem_addr2,mem_recom_id,mem_mailing,mem_status,mem_grade,mem_reg_dt,last_reg_dt)

		values
		('$mem_id','$mem_pwd','$mem_kind','$mem_name','$mem_jumin','$mem_email','$mem_mobile','$zipcode','$mem_addr1','$mem_addr2','$mem_recom_id','$mem_mailing','$mem_status',$mem_grade,now(),now())
		";
} else if ( $mode == "E" ) {
	// 수정
	$sql = "
		update tblMember set
		mem_id='$mem_id',mem_pwd='$mem_pwd',mem_kind='$mem_kind',mem_name='$mem_name',mem_jumin='$mem_jumin',mem_email='$mem_email',mem_mobile='$mem_mobile',zipcode='$zipcode',mem_addr1='$mem_addr1',mem_addr2='$mem_addr2',mem_recom_id='$mem_recom_id',mem_mailing='$mem_mailing',mem_status='$mem_status',mem_grade=$mem_grade,mem_cash=$mem_cash 
		where mem_id='$mem_id'
		";
} else if ( $mode == "B" ) {
	// 블록
	$sql = "update tblMember set mem_status = 'D' where mem_id='$mem_id'";
} else {
	// 탈퇴
	$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
}

$mainconn->query($sql);


if ( $mem_kind == "A" ) {
	// 관리자
	if ( $mode == "I" ) {
		$sql = "insert into tblAdmin values ('$mem_id','$mem_pwd','$mem_name','A',now())";
	} else if ( $mode == "E" ) {
		// 수정
		$sql = "update tblAdmin set admin_id='$mem_id',admin_pwd='$mem_pwd',admin_name='$mem_name' where admin_id='$mem_id'";
	} else {
		// 삭제
		$sql = "delete from tblAdmin where admin_id = '$mem_id'";
	}
	$mainconn->query($sql);

} else if ( $mem_kind == "S" ) {
	// 샵회원
	$shop_idx		= trim($_POST['shop_idx']);
	$shop_name		= trim($_POST['shop_name']);
	$shop_kind		= trim($_POST['shop_kind']);
	$shop_url		= trim($_POST['shop_url']);
	$shop_person	= trim($_POST['shop_person']);
	$shop_mobile	= trim($_POST['shop_mobile']);
	$shop_phone		= trim($_POST['shop_phone']);
	$shop_fax		= trim($_POST['shop_fax']);
	$shop_email		= trim($_POST['shop_email']);
	$shop_medal		= trim($_POST['shop_medal']);
	$shop_status	= trim($_POST['shop_status']);
	$shop_num		= trim($_POST['shop_num']);
	$shop_tax		= trim($_POST['shop_tax']);
	$shop_zipcode	= trim($_POST['shop_zipcode']);
	$shop_addr1		= trim($_POST['shop_addr1']);
	$shop_addr2		= trim($_POST['shop_addr2']);
	$shop_etc1		= trim($_POST['shop_etc1']);
	$shop_etc2		= trim($_POST['shop_etc2']);

	$old_shop_logo	= trim($_POST['old_shop_logo']);


	if ( $_FILES['shop_logo']['name'] ) {
		if ( $_FILES["shop_logo"][name] && !eregi("\.(gif|jpg|png)$", $_FILES["shop_logo"][name]) ) {
			echo "<script> alert('로고파일 확장자는 gif,jpg,png 이어야 합니다.'); history.go(-1);</script>";
			exit;
		}

		$path = $UP_DIR."/thumb/";
		@mkdir($path.date("Ym"), 0777);

		$shop_logo = date("Ym")."/".date("YmdHis").random_code2(5).strtolower(strrchr($_FILES["shop_logo"][name], "."));
		$result = FileUpload("shop_logo", $path, $shop_logo);
	} else {
		$shop_logo = $old_shop_logo;
	}

	/*
	foreach ( $result as $k => $v ) {
		echo "$k : $v <br>";
	}
	*/

	if ( $mode == "I" ) {
		$sql = "
		insert into tblShop
		(mem_id,shop_name,shop_kind,shop_url,shop_person,shop_mobile,shop_phone,shop_fax,shop_email,shop_logo,shop_medal,shop_status,shop_num,shop_tax,zipcode,shop_addr1,shop_addr2,shop_etc1,shop_etc2,shop_reg_dt)

		values

		('$mem_id','$shop_name','$shop_kind','$shop_url','$shop_person','$shop_mobile','$shop_phone','$shop_fax','$shop_email','$shop_logo','$shop_medal','$shop_status','$shop_num','$shop_tax','$shop_zipcode','$shop_addr1','$shop_addr2','$shop_etc1','$shop_etc2',now())
		";
		$mainconn->query($sql);

		$sql_cash = "select cash from tblCashConfig where cc_cid = 'CC01'";
		$cash = $mainconn->count($sql_cash);


		// 샵회원 가입 보너스 캐시
		$result = InsertCash($mem_id, 'CC01', 'I', $cash);

		// tblMember
		$result = UpdateMyCash( $mem_id, $cash );

	} else if ( $mode == "E" ) {
		// 수정
		$sql = "
		update tblShop set
		mem_id='$mem_id',shop_name='$shop_name',shop_kind='$shop_kind',shop_url='$shop_url',shop_person='$shop_person',shop_mobile='$shop_mobile',shop_phone='$shop_phone',shop_fax='$shop_fax',shop_email='$shop_email',shop_logo='$shop_logo',shop_medal='$shop_medal',shop_status='$shop_status',shop_num='$shop_num',shop_tax='$shop_tax',zipcode='$shop_zipcode',shop_addr1='$shop_addr1',shop_addr2='$shop_addr2',shop_etc1='$shop_etc1',shop_etc2='$shop_etc2'
		where shop_idx=$shop_idx
		";

	} else if ( $mode == "B" ) {
		// 불량샵
		$sql = "update tblShop set shop_status='B' where shop_idx=$shop_idx";
	} else {
		// 삭제
		$sql = "update tblShop set shop_status='N' where shop_idx=$shop_idx";
	}

	$mainconn->query($sql);

}

$mainconn->close();

goto_url($ADMIN_MAIN_URL);
//require_once "../_bottom.php";
?>