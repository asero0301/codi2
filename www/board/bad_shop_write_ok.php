<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/bad_shop_write_ok.php
 * date   : 2009.01.23
 * desc   : 불량샵 신고 입력/수정/삭제
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

// 인증여부 체크
auth_chk($RURL);

// 샵회원만 가능
/*
if ( $_SESSION['mem_kind'] != "S" ) {
	echo "<script>alert('샵회원만 작성가능합니다'); location.href='/board/bad_shop_list.php';</script>";
	exit;
}
*/

$mode			= trim($_POST['mode']);
$bad_idx		= trim($_POST['bad_idx']);
$shop_idx		= trim($_POST['shop_idx']);
$mem_id			= $_SESSION['mem_id'];
$bad_title		= addslashes(trim($_POST['bad_title']));
$bad_content	= addslashes(trim($_POST['bad_content']));

$old_file_list	= trim($_POST['old_file_list']);
$file_offset	= trim($_POST['file_offset']);		// 수정시에만 사용된다.

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

/****************************************************
 * 파일 저장 알고리즘 (파일 입력이 3개라고 가정한다)
 * 입력일땐 그냥 그대로...
 * 수정일때는 file_offset 값으로 구분해서 
 * 삭제할 파일들은 $del_file_list에,
 * 남길 파일들은 $file_list에 저장한다.
 * 이후 프로세스는 기존(코디 이미지등록) 방식과 동일
 ****************************************************/
$file_list = "";
if ( $_FILES['upfile']['size'][0]>0 || $_FILES['upfile']['size'][1]>0 || $_FILES['upfile']['size'][2]>0 ) {	// 첨부파일
	$del_file_list = "";
	if ( $mode == "E" && $old_file_list ) {
		$old_arr = explode(";", $old_file_list);

		$off_arr = explode(";", $file_offset);
		$file_list = $old_file_list;
		foreach ( $off_arr as $key => $value ) {
			if ( $value == "" ) continue;
			if ( $old_arr[$value-1] ) {
				$del_file_list .= $old_arr[$value-1].";";
				$file_list = str_replace($old_arr[$value-1].";", "", $file_list);
			} else {
				$file_list = $old_file_list;
			}
		}
	}
	for ( $i=0; $i< sizeof($_FILES['upfile']['size']); $i++ ) {
		if ( !$_FILES['upfile']['size'][$i] ) continue;
		$path = $UP_DIR."/attach/";
		@mkdir($path.date("Ym"), 0777);
		$upfile = date("Ym")."/".date("His").random_code2(10).strtolower(strrchr($_FILES["upfile"]['name'][$i], "."));
		$result = MultiFileUpload("upfile", $i, $path, $upfile);
		$file_list .= $upfile.";";
	}
} else {
	$file_list = $old_file_list;
}

if ( $mode == "I" ) {
	$sql = "
		insert into tblBadShop (shop_idx,mem_id,bad_title,bad_content,bad_file,bad_ip,bad_reg_dt) values 
		('$shop_idx','$mem_id','$bad_title','$bad_content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblBadShop set 
			bad_title = '$bad_title', bad_content = '$bad_content', bad_file = '$file_list',
			bad_ip = '$_SERVER[REMOTE_ADDR]', shop_idx = '$shop_idx'
		where bad_idx = $bad_idx
		";
	$mainconn->query($sql);

	if ( $del_file_list ) {
		$arr_file = explode(";", $del_file_list);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_file = trim($v);
			@unlink($UP_DIR."/attach/".$t_file);
		}
	}

} else {
	$arr = explode(";", $bad_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		// 첨부파일이 있으면 삭제
		$sql = "select mem_id,bad_file,bad_reg_dt from tblBadShop where bad_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		if ( trim($row['bad_file']) ) {
			$arr_file = explode(";", trim($row['bad_file']));
			foreach ( $arr_file as $kk => $vv ) {
				if ( trim($vv) == "" ) continue;
				$t_file = trim($vv);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}


		$sql = "delete from tblBadShop where bad_idx = $v";
		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();

goto_url("/board/bad_shop_list.php");

?>