<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/qna_write_ok.php
 * date   : 2008.08.20
 * desc   : Admin qna insert/update/delete
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
$categ			= trim($_POST['categ']);
$f_idx			= trim($_POST['f_idx']);
$depth			= trim($_POST['depth']);
$mem_id			= trim($_POST['mem_id']);
$title			= addslashes(trim($_POST['title']));
$content		= addslashes(trim($_POST['content']));
$old_file_list	= trim($_POST['old_file_list']);

if ( $mem_id == "" ) {
	$mem_id = trim($_SESSION['mem_id']);
}

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
	if ( $mode == "E" ) $file_list = $old_file_list;
}

if ( $mode == "I" ) {
	$depth = "A";
	$sql = "
		insert into tblQna (qna_f_idx,qna_depth,qna_categ,mem_id,qna_title,qna_content,qna_file,qna_ip,qna_reg_dt) values 
		(0,'$depth','$categ','$mem_id','$title','$content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);
	$f_idx = mysql_insert_id();
	$sql = "update tblQna set qna_f_idx = $f_idx where qna_idx = $f_idx";
	$mainconn->query($sql);

} else if ( $mode == "R" ) {
	$sql = "select qna_depth,right(qna_depth,1) as r_depth from tblQna where qna_f_idx = $f_idx and length(qna_depth) = length('$depth')+1 and locate('$depth',qna_depth) = 1 order by qna_depth desc limit 1";
	//echo "sql : $sql <br>";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( is_array($row) ) {
		$t_qna_depth = trim($row['qna_depth']);
		$r_depth	 = trim($row['r_depth']);
		$depth_head = substr($t_qna_depth, 0, -1);
		$depth_tail = ++$r_depth;
		$new_depth = $depth_head.$depth_tail;
	} else {
		$new_depth = $depth."A";
	}

	$sql = "
		insert into tblQna (qna_f_idx,qna_depth,qna_categ,mem_id,qna_title,qna_content,qna_file,qna_ip,qna_reg_dt) values 
		($f_idx,'$new_depth','$categ','$mem_id','$title','$content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);
	//echo "sql2 : $sql <br>";

} else if ( $mode == "E" ) {
	$sql = "
		update tblQna set 
			qna_title = '$title', qna_content = '$content', qna_file = '$file_list',
			qna_ip = '$_SERVER[REMOTE_ADDR]', qna_categ = '$categ'
		where qna_idx = $sel_idx
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
		$sql = "select qna_file from tblQna where qna_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		if ( trim($row['qna_file']) ) {
			$arr_file = explode(";", trim($row['qna_file']));
			foreach ( $arr_file as $kk => $vv ) {
				if ( trim($vv) == "" ) continue;
				$t_file = trim($vv);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}


		$sql = "delete from tblQna where qna_idx = $v";
		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();

goto_url("qna_list.php");
//require_once "../_bottom.php";
?>