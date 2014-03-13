<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/kwd_change.php
 * date   : 2008.10.10
 * desc   : 상품등록에서 카테고리 선택시 바뀌는 키워드 값
 *			을 처리해서 parent에 지정
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

$mainconn->open();

$p_categ = trim($_POST['p_categ']);
$kwd_categ = substr($p_categ, 0, 1);

$sql = "select kwd_idx,kwd_categ,kwd_kind,kwd from tblKwd where kwd_categ = '$kwd_categ' and kwd_status != 'N' ";
$res = $mainconn->query($sql);

$style_kwd = $item_kwd = $theme_kwd = "";
while ( $row = $mainconn->fetch($res) ) {
	$kwd_idx = trim($row['kwd_idx']);
	$kwd_kind = trim($row['kwd_kind']);
	$kwd = trim(strip_tags($row['kwd']));
	
	if ( $kwd_kind == "S" ) {
		$style_kwd .= "<option value='$kwd_idx'>$kwd</option>";
	} else if ( $kwd_kind == "I" ) {
		$item_kwd .= "<option value='$kwd_idx'>$kwd</option>";
	} else if ( $kwd_kind == "T" ) {
		$theme_kwd .= "<option value='$kwd_idx'>$kwd</option>";
	}
}

$mainconn->close();
?>

<script language="javascript">

</script>