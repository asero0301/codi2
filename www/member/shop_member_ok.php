<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/shop_member_ok.php
 * date   : 2008.10.08
 * desc   : shop member insert/update
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

// 체크
$this_mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);
if ( $this_mem_key != $mem_key ) {
	echo "<script>alert('비정상적인 접근입니다.'); location.href='/main.php';</script>";
	exit;
}



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

if ( $mem_pwd != $mem_re_pwd ) {
	echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.go(-1);</script>";
	exit;
}

// 샵입력
for ( $i=0; $i<$SHOP_MAX_COUNT; $i++ ) {
	$shop_name	= trim($_POST['shop_name_'.$i]);
	$shop_kind	= trim($_POST['shop_kind_'.$i]);
	$shop_url	= trim($_POST['shop_url_'.$i]);
	$shop_person	= trim($_POST['shop_person_'.$i]);
	$smobile_1	= trim($_POST['smobile_1_'.$i]);
	$smobile_2	= trim($_POST['smobile_2_'.$i]);
	$smobile_3	= trim($_POST['smobile_3_'.$i]);
	$sphone_1	= trim($_POST['sphone_1_'.$i]);
	$sphone_2	= trim($_POST['sphone_2_'.$i]);
	$sphone_3	= trim($_POST['sphone_3_'.$i]);
	$sfax_1	= trim($_POST['sfax_1_'.$i]);
	$sfax_2	= trim($_POST['sfax_2_'.$i]);
	$sfax_3	= trim($_POST['sfax_3_'.$i]);
	$shop_mail_id	= trim($_POST['shop_mail_id_'.$i]);
	$shop_mail_host	= trim($_POST['shop_mail_host_'.$i]);

	$shop_mobile = $smobile_1."-".$smobile_2."-".$smobile_3;
	$shop_phone = $sphone_1."-".$sphone_2."-".$sphone_3;
	$shop_fax = $sfax_1."-".$sfax_2."-".$sfax_3;

	$shop_email = $shop_mail_id."@".$shop_mail_host;

	$shop_num	= trim($_POST['shop_num_'.$i]);
	$shop_tax	= trim($_POST['shop_tax_'.$i]);
	$shop_zipcode	= trim($_POST['shop_zipcode_'.$i]);
	$shop_addr1	= trim($_POST['shop_addr1_'.$i]);
	$shop_addr2	= trim($_POST['shop_addr2_'.$i]);
	$shop_etc1	= trim($_POST['shop_etc1_'.$i]);
	$shop_etc2	= trim($_POST['shop_etc2_'.$i]);

	$shop_medal = "N";
	$old_shop_logo	= trim($_POST['old_shop_logo_'.$i]);

	if ( $shop_name == "" && $shop_person == "" && $shop_zipcode == "" ) continue;


	if ( $_FILES['shop_logo_'.$i]['name'] ) {
		if ( $_FILES['shop_logo_'.$i][name] && !eregi("\.(gif|jpg|png)$", $_FILES['shop_logo_'.$i][name]) ) {
			echo "<script> alert('로고파일 확장자는 gif,jpg,png 이어야 합니다.'); history.go(-1);</script>";
			exit;
		}

		$path = $UP_DIR."/thumb/";
		@mkdir($path.date("Ym"), 0777);

		$shop_logo = date("Ym")."/".date("YmdHis").random_code2(5).strtolower(strrchr($_FILES['shop_logo_'.$i][name], "."));
		$result = FileUpload("shop_logo_".$i, $path, $shop_logo);
	} else {
		$shop_logo = $old_shop_logo;
	}

	// tblShop insert
	$sql3 = "
		insert into tblShop 
		(mem_id,shop_name,shop_kind,shop_url,shop_person,shop_mobile,shop_phone,shop_fax,shop_email,shop_logo,
		shop_medal,shop_num,shop_tax,zipcode,shop_addr1,shop_addr2,shop_etc1,shop_etc2,shop_reg_dt) 
			values
		('$mem_id','$shop_name','$shop_kind','$shop_url','$shop_person','$shop_mobile','$shop_phone','$shop_fax','$shop_email','$shop_logo',
		'$shop_medal','$shop_num','$shop_tax','$shop_zipcode','$shop_addr1','$shop_addr2','$shop_etc1','$shop_etc2',now())
		";
	$mainconn->query($sql3);

}



//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

if ( $mode == "I" ) {
	
	$sql = "select count(*) from tblMember where mem_id='$mem_id'";
	$cnt = $mainconn->count($sql);

	// 가입 보너스 캐쉬
	$sql_cash = "select cash from tblCashConfig where cc_cid = 'CC01'";
	$cash = $mainconn->count($sql_cash);

	if ( $cnt == "0" ) {	// 처음 가입한 아이디면
		$sql2 = "
			insert into tblMember
			(mem_id,mem_pwd,mem_kind,mem_name,mem_jumin,mem_email,mem_mobile,zipcode,mem_addr1,mem_addr2,mem_recom_id,mem_mailing,mem_cash,mem_reg_dt)

			values
			('$mem_id','$mem_pwd','$mem_kind','$mem_name','$mem_jumin','$mem_email','$mem_mobile','$zipcode','$mem_addr1','$mem_addr2','$mem_recom_id','$mem_mailing',0,now())
			";
	} else {	// 탈퇴,블럭 처리해도 삭제되지 않기때문에 update 처리
		$sql2 = "
			update tblMember set
			mem_pwd='$mem_pwd', mem_kind='$mem_kind', mem_name='$mem_name', mem_email='$mem_email',
			mem_mobile='$mem_mobile', zipcode='$zipcode', mem_addr1='$mem_addr1', mem_addr2='$mem_addr2',
			mem_recom_id='$mem_recom_id', mem_mailing='$mem_mailing', mem_status='Y', mem_grade=10, mem_cash=0,
			mem_score=0, mem_reg_dt=now()
			where mem_id = '$mem_id'
			";
	}
	$mainconn->query($sql2);

	
	// 샵회원 가입 보너스 캐시
	$result = InsertCash($mem_id, 'CC01', 'I', $cash);

	// tblMember
	$result = UpdateMyCash( $mem_id, $cash );

} else if ( $mode == "E" ) {
	// 수정
	$sql = "
		update tblMember set
		mem_id='$mem_id',mem_pwd='$mem_pwd',mem_kind='$mem_kind',mem_name='$mem_name',mem_jumin='$mem_jumin',mem_email='$mem_email',mem_mobile='$mem_mobile',zipcode='$zipcode',mem_addr1='$mem_addr1',mem_addr2='$mem_addr2',mem_recom_id='$mem_recom_id',mem_mailing='$mem_mailing',mem_status='$mem_status',mem_grade=$mem_grade 
		where mem_id='$mem_id'
		";
	$mainconn->query($sql);

} else if ( $mode == "B" ) {
	// 블록
	$sql = "update tblMember set mem_status = 'D' where mem_id='$mem_id'";
	$mainconn->query($sql);
} else {
	// 탈퇴
	$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
	$mainconn->query($sql);
}



$mainconn->close();

goto_url("/main.php", "회원가입이 되었습니다");
?>