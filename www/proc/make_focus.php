<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_main_codi_list.php
 * date   : 2009.01.05
 * desc   : 메인 "평가 대기중인 코디" 만드는 proc 스크립트
 *			주의 -  파일생성시간을 체크하는게 아니고 어드민에서
 *					입력/수정/삭제시 파일을 다시 생성한다.
 *			/manage/contents/focus_write_ok.php에 삽입되어 있다.
 *******************************************************/
//require_once "/coditop/inc/common.inc.php";
//$mainconn->open();

$focus_str = "
	<table width='200' border='0' cellspacing='0' cellpadding='0'>
		<tr>
	<td height='368' valign='top'>
	";

$sql = "select * from tblFocus where focus_status = 'Y' order by focus_prior, focus_reg_dt desc limit 5";
$res = $mainconn->query($sql);

$cnt = 0;
while ( $rows = $mainconn->fetch($res) ) {
	$cnt++;

	$focus_idx = trim($rows['focus_idx']);
	$focus_url = trim($rows['focus_url']);
	$focus_target_opt = trim($rows['focus_target_opt']);
	$focus_file = trim($rows['focus_file']);

	$focus_target = ( $focus_target_opt == "N" ) ? "target='_blank'" : "";
	if ( $focus_file ) {
		$arr_file = explode(";", $focus_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_focus_file = trim($v);
			$file_disp = "<a href='$focus_url' $focus_target ><img src='".$UP_URL."/attach/".$t_focus_file."' width='200' height='344' border='0' /></a>";
		}
	}

	$focus_str .= "
	<div id='event0{$cnt}'>
	<table width='200' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		";

	for ( $j = 1; $j <= 5; $j++ ) {
		if ( $j == $cnt ) {
			$focus_str .= "<td width='41'><a href='#'><img src='img/tap_event0{$j}ov.gif' width='38' height='16' border='0' /></a></td>";
		} else {
			$hs1 = ( $j == 1 ) ? "show" : "hide";
			$hs2 = ( $j == 2 ) ? "show" : "hide";
			$hs3 = ( $j == 3 ) ? "show" : "hide";
			$hs4 = ( $j == 4 ) ? "show" : "hide";
			$hs5 = ( $j == 5 ) ? "show" : "hide";

			$focus_str .= "<td width='41'><a href='#' onmouseover=\"MM_showHideLayers('event01','','{$hs1}','event02','','{$hs2}','event03','','{$hs3}','event04','','{$hs4}','event05','','{$hs5}');\"><img src='img/tap_event0{$j}.gif' width='38' height='16' border='0' /></a></td>";
		}
	}

	$focus_str .= "
		</tr>
		<tr>
			<td height='8' colspan='5'></td>
		</tr>
		<tr>
			<td colspan='5'>{$file_disp}</td>
		</tr>
	</table>
	</div>
	";

}	// while


$focus_str .= "
			</td>
		</tr>
	</table>
	";

$fp = fopen($TPL_DIR."/main/focus.tpl", "w");
fwrite($fp, $focus_str);


//$mainconn->close();
//echo $focus_str;
?> 