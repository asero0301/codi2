<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/logout.php
 * date   : 2008.09.18
 * desc   : logout
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

/*
// tpl ������ ���丮�� ���Ѵ�.
$my_dir_head = strtolower(substr($_SESSION['mem_id'], 0, 1));
$my_dir = $TPL_DIR."/myquick/".$my_dir_head;
if ( !is_dir($my_dir) ) {
	$my_dir = $TPL_DIR."/myquick/1";
}

$info_f = $my_dir."/".$_SESSION['mem_id'].".info";
@unlink($info_f);
*/

//$rurl = trim($_POST['rurl']);
//if ( strlen($rurl) < 1 ) {
	$rurl = "/main.php";
//}

session_destroy(); 

goto_url($rurl);
?>