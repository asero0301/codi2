<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/focus_write_ok.php
 * date   : 2008.08.25
 * desc   : Admin focus insert/update/delete
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";
require_once "../../inc/util.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
$sel_idx		= trim($_POST['sel_idx']);
$old_file_list	= trim($_POST['old_file_list']);


$focus_display_opt	= trim($_POST['focus_display_opt']);
$focus_target_opt	= trim($_POST['focus_target_opt']);
$focus_url			= trim($_POST['focus_url']);
$focus_status		= trim($_POST['focus_status']);
$focus_prior		= trim($_POST['focus_prior']);

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();


if ( sizeof($_FILES['upfile']['size']) ) {	// 첨부파일이 있으면
	$file_list = "";
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
		insert into tblFocus (focus_url,focus_prior,focus_display_opt,focus_target_opt,focus_file,focus_reg_dt) values 
		('$focus_url',$focus_prior,'$focus_display_opt','$focus_target_opt','$file_list',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblFocus set 
			focus_file = '$file_list', focus_url = '$focus_url', focus_prior = $focus_prior, 
			focus_display_opt = '$focus_display_opt', focus_target_opt = '$focus_target_opt'
		where focus_idx = $sel_idx
		";
	$mainconn->query($sql);

	if ( ($file_list != $old_file_list) && $old_file_list ) {	// 첨부파일 이전꺼 삭제
		if ( $old_file_list ) {
			$arr_file = explode(";", $old_file_list);
			foreach ( $arr_file as $k => $v ) {
				if ( trim($v) == "" ) continue;
				$t_file = trim($v);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}
	}

} else if ( $mode == "A" ) {
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;
/*
		// 첨부파일이 있으면 삭제
		$sql = "select notice_file from tblNotice where notice_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		if ( trim($row['notice_file']) ) {
			$arr_file = explode(";", trim($row['notice_file']));
			foreach ( $arr_file as $kk => $vv ) {
				if ( trim($vv) == "" ) continue;
				$t_file = trim($vv);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}
*/
		$new_status = ( $focus_status == "Y" ) ? "N" : "Y";
		$sql = "update tblFocus set focus_status = '$new_status' where focus_idx = $v";

		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////




// html 파일을 만든다.
require_once "../../proc/make_focus.php";


$mainconn->close();

goto_url("focus_list.php");
//require_once "../_bottom.php";
?>