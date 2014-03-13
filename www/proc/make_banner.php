<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_banner.php
 * date   : 2009.01.06
 * desc   : 전체 배너 html 만드는 proc 스크립트
 *			주의 -  파일생성시간을 체크하는게 아니고 어드민에서
 *					입력/수정/삭제시 파일을 다시 생성한다.
 *			/manage/contents/banner_write_ok.php에 삽입되어 있다.
 *******************************************************/
//require_once "/coditop/inc/common.inc.php";
//$mainconn->open();


$MAINT = $MAINB = $MAINL = $MAINR = $CODIT = $CODIB = $CODIL = $CODIR = $BOARDT = $BOARDB = $BOARDL = $BOARDR = $JOINT = $JOINB = $JOINL = $JOINR = $ETCT = $ETCB = $ETCL = $ETCR = "";

$banner_head = "<table width='200' border='0' cellspacing='0' cellpadding='0'>";

$sql = "select banner_idx, banner_url, banner_area, banner_file from tblBanner where banner_status = 'Y' ";
$res = $mainconn->query($sql);

while ( $rows = $mainconn->fetch($res) ) {
	$banner_idx = trim($rows['banner_idx']);
	$banner_url = trim($rows['banner_url']);
	$banner_area = trim($rows['banner_area']);
	$banner_file = trim($rows['banner_file']);

	if ( $banner_file ) {
		$arr_file = explode(";", $banner_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_banner_file = trim($v);
			$file_disp = "<img src='".$UP_URL."/attach/".$t_banner_file."' width='200' height='75' border='0' />";
		}
	}

	if ( $banner_area ) {
		$arr_area = explode(";", $banner_area);
		foreach ( $arr_area as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_banner_area = trim($v);
			${$t_banner_area} .= "
				<tr>
					<td><a href='$banner_url' target='_blank'>$file_disp</a></td>
				</tr>
				<tr>
					<td height='6'></td>
				</tr>
			";
		}
	}

}	// while

$banner_tail = "</table>";

foreach ( $BANNER_AREA as $k => $v ) {
	$area = $v;
	if ( ${$area} ) {
		$TXT = $banner_head . ${$area} . $banner_tail;
		$fp = fopen($TPL_DIR."/banner/".$area.".tpl", "w");
		fwrite($fp, $TXT);
		fclose($fp);
	}
}

//$mainconn->close();
//echo $banner_str;
?> 