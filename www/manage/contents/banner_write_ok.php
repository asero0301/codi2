<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/banner_write_ok.php
 * date   : 2008.08.25
 * desc   : Admin banner insert/update/delete
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


$banner_url		= trim($_POST['banner_url']);
$rd_main_area	= trim($_POST['rd_main_area']);
$rd_codi_area	= trim($_POST['rd_codi_area']);
$rd_board_area	= trim($_POST['rd_board_area']);
$rd_join_area	= trim($_POST['rd_join_area']);
$rd_etc_area	= trim($_POST['rd_etc_area']);

//$banner_area = $rd_main_area.";".$rd_codi_area.";".$rd_board_area.";".$rd_join_area.";".$rd_etc_area;

$banner_area = ";";
if ( $rd_main_area ) $banner_area .= $rd_main_area.";";
if ( $rd_codi_area ) $banner_area .= $rd_codi_area.";";
if ( $rd_board_area ) $banner_area .= $rd_board_area.";";
if ( $rd_join_area ) $banner_area .= $rd_join_area.";";
if ( $rd_etc_area ) $banner_area .= $rd_etc_area;

$banner_status	= trim($_POST['banner_status']);

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
		insert into tblBanner (banner_url,banner_area,banner_file,banner_reg_dt) values 
		('$banner_url','$banner_area','$file_list',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblBanner set 
			banner_file = '$file_list', banner_url = '$banner_url', banner_area = '$banner_area'
		where banner_idx = $sel_idx
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

		$new_status = ( $banner_status == "Y" ) ? "N" : "Y";
		$sql = "update tblBanner set banner_status = '$new_status' where banner_idx = $v";

		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////


// html 파일을 만든다.
require_once "../../proc/make_banner.php";


$mainconn->close();

goto_url("banner_list.php");
?>