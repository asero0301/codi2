<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/search/search_process.php
 * date   : 2008.10.01
 * desc   : ajax comment process
 *******************************************************/
//session_start();
//$txt = "<div id='r0'>검색어 자동완성</div>";

ini_set("default_charset", "utf-8");

require_once "/coditop/inc/common.inc.php";

// 리퍼러 체크
referer_chk();

$s_key			= trim($_REQUEST['s_key']);
$keyword		= trim($_REQUEST['keyword']);
$keyword = ereg_replace("[<>\'\"]", "", $keyword);

//$search_title	= trim($_REQUEST['search_title']);

// iconv - define public.inc.php
$keyword = iconv("utf-8", "euc-kr", $keyword);
//$search_title = iconv("utf-8", "euc-kr", $search_title);

if ( strlen($keyword) > 0 ) {

	$mainconn->open();
	$sql = "insert into tblSearchKeyword (s_key,s_kwd,s_reg_dt) values ('$s_key','$keyword',now())";
	//echo $sql;
	$res = $mainconn->query($sql);

	$mainconn->close();
}	// 검색어 길이가 0보다 클때

?>
