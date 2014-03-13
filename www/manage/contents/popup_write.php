<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/popup_write.php
 * date   : 2008.08.20
 * desc   : Admin popup write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
//referer_chk();

$mode		= trim($_REQUEST['mode']);
$pop_idx	= trim($_REQUEST['sel_idx']);

$mainconn->open();

if ( $mode == "E" ) {
	$title_tail = "수정";
	
	$sql = "select * from tblPopup where pop_idx = $pop_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$pop_title		= trim($row['pop_title']);
	$pop_start_dt	= trim($row['pop_start_dt']);
	$pop_end_dt		= trim($row['pop_end_dt']);
	$pop_kind		= trim($row['pop_kind']);
	$pop_display_opt= trim($row['pop_display_opt']);
	$pop_today_opt	= trim($row['pop_today_opt']);
	$pop_width		= trim($row['pop_width']);
	$pop_height		= trim($row['pop_height']);
	$pop_top		= trim($row['pop_top']);
	$pop_left		= trim($row['pop_left']);
	$pop_file		= trim($row['pop_file']);
	$pop_content	= trim($row['pop_content']);
	$pop_status		= trim($row['pop_status']);
	$pop_reg_dt		= trim($row['pop_reg_dt']);

	$pop_title		= strip_str($pop_title);
	$pop_content	= strip_str($pop_content);
	
} else {
	$title_tail = "추가";
}

require_once "../_top.php";
?>

<style type='text/css'>
//*p{ margin:0px; }*/
ul,ol{ margin-top:0; margin-bottom:0; }
body, table, td{font-family:'Tahoma'; font-size:9pt; line-height:140%;}
</style>
<script language="JavaScript" src="/wysiwyg/wysiwyg.js"></script>
<script src="/js/js_date.js" type="text/javascript" ></script>
<script src="/js/jsCalendar.js" type="text/javascript" ></script>
<link rel="stylesheet" type="text/css" href="/css/jsCalendar.css" />


<script language="JavaScript">
function insertPost() {
	var f = document.frm;
	f.encoding = "multipart/form-data";
	f.action = "popup_write_ok.php";
	f.submit();
}

function addFileField() {
	upload_list = document.getElementById('uploads');
	list_item = document.createElement("LI");
	file_field = document.createElement("INPUT");
	file_field.type = "file";
	file_field.name = "upfile[]";
	list_item.appendChild(file_field);
	upload_list.appendChild(list_item);
}
</script>

<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$pop_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$pop_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 팝업관리 <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<font color="#666666"><strong><input type="text" id="pop_title" name="pop_title" value="<?=$pop_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 기간&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    <input type="text" id="pop_start_dt" name="pop_start_dt" value="<?=$pop_start_dt?>" size="10" />
				<input name="" type="button" id="btn00" value="시작" /> ~

				<input type="text" id="pop_end_dt" name="pop_end_dt" value="<?=$pop_end_dt?>" size="10" />
				<input name="" type="button" id="btn01" value="종료" />

				<script type="text/javascript">
				var cal0 = new jsCalendar(document.getElementById('pop_start_dt'),document.getElementById('btn00'));
				var cal1 = new jsCalendar(document.getElementById('pop_end_dt'),document.getElementById('btn01'));
				</script>

			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 팝업형태&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<input type="radio" id="pop_kind" name="pop_kind" value="L" <? if ( $pop_kind == "L" ) echo " checked"; ?>> 레이어
				<input type="radio" id="pop_kind" name="pop_kind" value="W" <? if ( $pop_kind == "W" ) echo " checked"; ?>> 윈도우
			</font>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 너비/높이&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    width : <input type="text" id="pop_width" name="pop_width" value="<?=$pop_width?>" size="10" />pixel &nbsp;&nbsp;
				height : <input type="text" id="pop_height" name="pop_height" value="<?=$pop_height?>" size="10" />pixel 
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 상단/좌측&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    top : <input type="text" id="pop_top" name="pop_top" value="<?=$pop_top?>" size="10" />pixel &nbsp;&nbsp;
				left : <input type="text" id="pop_left" name="pop_left" value="<?=$pop_left?>" size="10" />pixel 
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 노출옵션&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    <input type="radio" id="pop_display_opt" name="pop_display_opt" value="M" <? if ( $pop_display_opt == "M" ) echo " checked"; ?>> 메인
				<input type="radio" id="pop_display_opt" name="pop_display_opt" value="S" <? if ( $pop_display_opt == "S" ) echo " checked"; ?>> 서브
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 오늘만옵션&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<input type="radio" id="pop_today_opt" name="pop_today_opt" value="Y" <? if ( $pop_today_opt == "Y" ) echo " checked"; ?>> 적용
				<input type="radio" id="pop_today_opt" name="pop_today_opt" value="N" <? if ( $pop_today_opt == "N" ) echo " checked"; ?>> 미적용
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<textarea name="pop_content" id="pop_content" type="editor" style="width:700px; height:300px;"><?=$pop_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $pop_file ) {
				$arr_file = explode(";", $pop_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_popup_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_popup_file&savename=$t_popup_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
				}
				echo $file_disp;
			}
			?>
		</td>
	</tr>
</table>


<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td align="center" height="23">
		<input type="button" value="저  장" onClick="insertPost();">
	</td>
  </tr>
</table>



</form>



<?php 

$mainconn->close();

require_once "../_bottom.php";

?> 