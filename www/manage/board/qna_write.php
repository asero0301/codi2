<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/qna_write.php
 * date   : 2008.08.28
 * desc   : Admin qna write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode		= trim($_REQUEST['mode']);
$qna_idx	= trim($_REQUEST['sel_idx']);
$qna_categ	= trim($_REQUEST['qna_categ']);

if ( $mode == "E" || $mode == "R" ) {
	$title_tail = ( $mode == "E" ) ? "수정" : "답변";
	$mainconn->open();
	$sql = "select * from tblQna where qna_idx = $qna_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$qna_f_idx		= trim($row['qna_f_idx']);
	$qna_depth		= trim($row['qna_depth']);
	$qna_categ		= trim($row['qna_categ']);
	$mem_id			= trim($row['mem_id']);
	$qna_title		= trim($row['qna_title']);
	$qna_content	= trim($row['qna_content']);
	$qna_file		= trim($row['qna_file']);
	$qna_view		= trim($row['qna_view']);
	$qna_ip			= trim($row['qna_ip']);
	$qna_reg_dt		= trim($row['qna_reg_dt']);

	$qna_title		= strip_str($qna_title);
	$qna_content	= ( $mode == "E" ) ? strip_str($qna_content) : "<b>".$mem_id."</b>님의 글입니다<p>".strip_str($qna_content);

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
	f.action = "qna_write_ok.php";
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
<input type="hidden" id="f_idx" name="f_idx" value="<?=$qna_f_idx?>">
<input type="hidden" id="depth" name="depth" value="<?=$qna_depth?>">
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$qna_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$qna_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ QNA <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$qna_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 분류&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<select id="categ" name="categ">
				<option value="">::선택하세요::</option>
				<?
				foreach ( $QNA as $k => $v ) {
					$selected = ( $qna_categ == $k ) ? " selected" : "";
					echo "<option value='$k' $selected>$v</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$qna_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $qna_file ) {
				$arr_file = explode(";", $qna_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_qna_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_qna_file&savename=$t_qna_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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