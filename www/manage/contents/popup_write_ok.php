<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/popup_write_ok.php
 * date   : 2008.08.25
 * desc   : Admin popup insert/update/delete
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
$pop_title		= addslashes(trim($_POST['pop_title']));
$pop_content	= addslashes(trim($_POST['pop_content']));
$old_file_list	= trim($_POST['old_file_list']);

$pop_start_dt	= trim($_POST['pop_start_dt']);
$pop_end_dt		= trim($_POST['pop_end_dt']);
$pop_kind		= trim($_POST['pop_kind']);
$pop_display_opt= trim($_POST['pop_display_opt']);
$pop_today_opt	= trim($_POST['pop_today_opt']);
$pop_width		= trim($_POST['pop_width']);
$pop_height		= trim($_POST['pop_height']);
$pop_top		= trim($_POST['pop_top']);
$pop_left		= trim($_POST['pop_left']);
$pop_status		= trim($_POST['pop_status']);

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
		$file_list .= $upfile;
		break;
	}
} else {
	$file_list = $old_file_list;
}

if ( $mode == "I" ) {
	$sql = "
		insert into tblPopup (pop_title,pop_content,pop_start_dt,pop_end_dt,pop_kind,pop_display_opt,pop_today_opt,pop_width,pop_height,pop_top,pop_left,pop_file,pop_reg_dt) values 
		('$pop_title','$pop_content','$pop_start_dt','$pop_end_dt','$pop_kind','$pop_display_opt','$pop_today_opt',$pop_width,$pop_height,$pop_top,$pop_left,'$file_list',now())
		";
	$mainconn->query($sql);
	$sel_idx = mysql_insert_id();

} else if ( $mode == "E" ) {
	$sql = "
		update tblPopup set 
			pop_title = '$pop_title', pop_content = '$pop_content', pop_file = '$file_list',
			pop_start_dt = '$pop_start_dt', pop_end_dt = '$pop_end_dt', pop_kind = '$pop_kind',
			pop_display_opt = '$pop_display_opt', pop_today_opt = '$pop_today_opt', pop_width = $pop_width, pop_height= $pop_height, pop_top = $pop_top, pop_left = $pop_left 
		where pop_idx = $sel_idx
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
/*
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
*/
		$new_status = ( $pop_status == "Y" ) ? "N" : "Y";
		$sql = "update tblPopup set pop_status = '$new_status' where pop_idx = $v";

		$mainconn->query($sql);
	}
}

//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();


// 텍스트/htm 생성
if ( $mode == "I" || $mode == "E" ) {	
	$contents = "";
	if ( $file_list ) {
		$file_url = $UP_URL."/attach/".$file_list;
		if ( substr($file_list, -3) == "swf" ) {
			$contents = "
				<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='$pop_width' height='$pop_height'>
					<param name='movie' value='$file_url' />
					<param name='quality' value='high' />
					<embed src='$file_url' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$pop_width' height='$pop_height'></embed>
				</object>
				";
		} else {
			$contents = "<img src='$file_url' border='0'>";
		}
	} else {
		$contents = $pop_content;
	}

	//$html_file = ($pop_kind == "L") ? $TPL_DIR."/pop_".$sel_idx.".txt" : $TPL_DIR."/pop_".$sel_idx.".htm";

	$htm_file = $TPL_DIR."/pop_".$sel_idx.".htm";
	$txt_file = $TPL_DIR."/pop_".$sel_idx.".txt";

	$fp = fopen($htm_file, "w");
	$fp2 = fopen($txt_file, "w");

	$htm_head = "<html><head><title>$pop_title</title></head><body>";
	$htm_tail = "</body></html>";

	$txt_head = "<div id='theLayer' style='width:${pop_width}px; position:absolute; left:${pop_left}px; top:${pop_top}px; z-index:90000; visibility:visible; display:none;'>";
	$txt_tail = "</div>";

	if ( $pop_kind == "L" ) {
		$chk_click = "popup_setCookie('layerpopup','done',1); hideMe();";
		$close_click = "hideMe(); return false";
	} else {
		$chk_click = "opener.popup_setCookie('layerpopup','done',1); self.close();";
		$close_click = "self.close(); return false";
	}

	$str = "
		<table border='0' width='$pop_width' bgcolor='#424242' cellspacing='0' cellpadding='5'>
			<tr>
				<td id='titleBar' style='cursor:move' width='100%'>
				
				<table border='0' width='100%' cellspacing='0' cellpadding='0' height='36'>
					<tr>
						<td><font color='white'>$pop_title</font></td>
					</tr>
					<tr>
						<td width='90%'>
							<ilayer width='100%' onSelectStart='return false'>
							<layer width='100%' onMouseover='isHot=true;if (isN4) ddN4(theLayer)' onMouseout='isHot=false' z-index='90000'>
							
							$contents
							
							</layer>
							</ilayer>
						</td>
					</tr>

					<tr>
						<td height='5'></td>
					</tr>

					<tr>
						<td align=center width='$pop_width' id='todayarea' style='display:block;'>
							<INPUT TYPE='checkbox' NAME='popupCookie_${sel_idx}' onclick=\"$chk_click\" style='cursor:hand' valign='top' width='20%' align='right'> <FONT COLOR='#FFFFFF'>하루동안 이창 보이지 않기</FONT>
							&nbsp;&nbsp;
							<a href='#' onClick='$close_click'><font color='#ffffff'  face='arial'  style='text-decoration:none'>닫기X</font></a>
						</td>
					</tr>
				</table>
				
				</td>
			</tr>
		</table>
		";

	
	fwrite($fp, $htm_head.$str.$htm_tail);
	fwrite($fp2, $txt_head.$str.$txt_tail);

	fclose($fp);
	fclose($fp2);
}

goto_url("popup_list.php");
//require_once "../_bottom.php";
?>