<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/notice_write.php
 * date   : 2008.08.20
 * desc   : Admin notice write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$notice_idx = trim($_REQUEST['sel_idx']);

if ( $mode == "E" ) {
	$title_tail = "수정";
	$mainconn->open();
	$sql = "select * from tblNotice where notice_idx = $notice_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$notice_title		= trim($row['notice_title']);
	$notice_content		= trim($row['notice_content']);
	$notice_file		= trim($row['notice_file']);
	$notice_view		= trim($row['notice_view']);
	$notice_ip			= trim($row['notice_ip']);
	$notice_reg_dt		= trim($row['notice_reg_dt']);

	$notice_title		= strip_str($notice_title);
	$notice_content		= strip_str($notice_content);

	$mainconn->close();
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
<script language="javascript">
function insertPost() {
	var f = document.frm;
	f.encoding = "multipart/form-data";
	f.action = "notice_write_ok.php";
	f.submit();
}

function chgKind() {
	var f = document.frm;
	if ( f.mem_kind[1].checked == true ) {
		document.getElementById('shop_area').style.display = "block";
	} else {
		document.getElementById('shop_area').style.display = "none";
	}
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
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$notice_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$notice_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 공지사항 <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$notice_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$notice_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $notice_file ) {
				$arr_file = explode(";", $notice_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_notice_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_notice_file&savename=$t_notice_file' target='_blank'><img src='/img/file.gif' border='0'></a>&nbsp;";
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
require_once "../_bottom.php";

?> 