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

require_once "../inc/common.inc.php";

// 리퍼러 체크
referer_chk();

$s_key		= trim($_REQUEST['s_key']);
$keyword		= trim($_REQUEST['keyword']);

// iconv - define public.inc.php
$keyword = iconv("utf-8", "euc-kr", $keyword);

$txt = "";

$txt .= "<div id=r0>검색어 자동완성</div>";

if ( strlen($keyword) > 0 ) {

	$mainconn->open();
	$sql = "select distinct(s_kwd) from tblSearchKeyword where s_key = '$s_key' and s_kwd like '{$keyword}%' ";
	//echo $sql;
	$res = $mainconn->query($sql);

	$cnt = 1;
	while ( $row = $mainconn->fetch($res) ) {
		$k = trim($row['s_kwd']);
		$k = str_replace($keyword, "<b>$keyword</b>", $k);

		$omv = "this.style.backgroundColor=&#039;E3FAFF&#039;";
		$omu = "this.style.backgroundColor=&#039;FFFFFF&#039;";

		$syl = "style=padding:3px;cursor:hand;font:12px;";
		
		$txt .= "<div id=r{$cnt} align=left onClick=AutoInput($cnt); onMouseOver=$omv; onMouseOut=$omu; $syl>$k</div>";

		$cnt++;
	}

	$mainconn->close();
}	// 검색어 길이가 0보다 클때

echo iconv("euc-kr","utf-8",$txt);
?>