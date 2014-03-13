<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/shop_edit_ok.php
 * date   : 2008.10.09
 * desc   : shop info insert/update
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
$mem_id	= $_SESSION['mem_id'];

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

if ( $mode == "E" ) {
	for ( $i=0; $i<$SHOP_MAX_COUNT; $i++ ) {

		$shop_idx	= trim($_POST['shop_idx_'.$i]);
		$shop_medal	= trim($_POST['shop_medal_'.$i]);
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

		// tblShop edit
		if ( $shop_idx ) {
			$sql = "
				update tblShop set 
					mem_id='$mem_id',shop_name='$shop_name',shop_kind='$shop_kind',shop_url='$shop_url',
					shop_person='$shop_person',shop_mobile='$shop_mobile',shop_phone='$shop_phone',shop_fax='$shop_fax',
					shop_email='$shop_email',shop_logo='$shop_logo',shop_medal='$shop_medal',shop_num='$shop_num',
					shop_tax='$shop_tax',zipcode='$shop_zipcode',shop_addr1='$shop_addr1',shop_addr2='$shop_addr2',
					shop_etc1='$shop_etc1',shop_etc2='$shop_etc2' 
				where shop_idx = $shop_idx
				";
		} else {
			$sql = "
			insert into tblShop 
			(mem_id,shop_name,shop_kind,shop_url,shop_person,shop_mobile,shop_phone,shop_fax,shop_email,shop_logo,
			shop_medal,shop_num,shop_tax,zipcode,shop_addr1,shop_addr2,shop_etc1,shop_etc2,shop_reg_dt) 
				values
			('$mem_id','$shop_name','$shop_kind','$shop_url','$shop_person','$shop_mobile','$shop_phone','$shop_fax','$shop_email','$shop_logo',
			'N','$shop_num','$shop_tax','$shop_zipcode','$shop_addr1','$shop_addr2','$shop_etc1','$shop_etc2',now())
			";
		}
		$mainconn->query($sql);

	}

} else if ( $mode == "K" ) {
	// 대표샵 수정
	$sql = "update tblShop set shop_kind = 'D' where mem_id='$mem_id'";
	$mainconn->query($sql);
	$sql = "update tblShop set shop_kind = 'I' where shop_idx=$shop_idx";
	$mainconn->query($sql);

} else if ( $mode == "D" ) {
	// 샵 삭제
	$sql = "update tblShop set shop_status = 'N' where shop_idx=$shop_idx";
	$mainconn->query($sql);
}

$mainconn->close();

goto_url("/mypage/mypage.php");
?>