<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/faq_write_ok.php
 * date   : 2008.08.20
 * desc   : Admin faq insert/update/delete
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
$title			= addslashes(trim($_POST['title']));
$content		= addslashes(trim($_POST['content']));
$categ			= addslashes(trim($_POST['categ']));

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

if ( $mode == "I" ) {
	$sql = "
		insert into tblFaq (faq_title,faq_content,faq_categ,faq_reg_dt) values 
		('$title','$content','$categ',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblFaq set 
			faq_title = '$title', faq_content = '$content', faq_categ = '$categ'
		where faq_idx = $sel_idx
		";
	$mainconn->query($sql);

} else {
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		$sql = "delete from tblFaq where faq_idx = $v";
		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();

goto_url("faq_list.php");
//require_once "../_bottom.php";
?>