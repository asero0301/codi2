<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/notice_write_ok.php
 * date   : 2008.08.20
 * desc   : Admin notice insert/update/delete
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
$mem_id			= trim($_POST['mem_id']);
$title			= addslashes(trim($_POST['title']));
$content		= addslashes(trim($_POST['content']));
$old_file_list	= trim($_POST['old_file_list']);

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
		insert into tblNotice (notice_title,mem_id,notice_content,notice_file,notice_ip,notice_reg_dt) values 
		('$title','$mem_id','$content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblNotice set 
			notice_title = '$title', notice_content = '$content', notice_file = '$file_list',
			notice_ip = '$_SERVER[REMOTE_ADDR]', notice_reg_dt = now()
		where notice_idx = $sel_idx
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

} else {
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

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


		$sql = "delete from tblNotice where notice_idx = $v";
		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();

goto_url("notice_list.php");
//require_once "../_bottom.php";
?>