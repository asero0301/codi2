<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/faq_write.php
 * date   : 2008.08.28
 * desc   : Admin faq write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$faq_idx = trim($_REQUEST['sel_idx']);

if ( $mode == "E" ) {
	$title_tail = "수정";
	$mainconn->open();
	$sql = "select * from tblFaq where faq_idx = $faq_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$faq_categ		= trim($row['faq_categ']);
	$faq_title		= trim($row['faq_title']);
	$faq_content	= trim($row['faq_content']);
	$faq_reg_dt		= trim($row['faq_reg_dt']);

	$faq_title		= strip_str($faq_title);
	$faq_content	= strip_str($faq_content);

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
	f.action = "faq_write_ok.php";
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
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$faq_idx?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ FAQ <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 분류&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<select id="categ" name="categ">
				<option value="">::선택하세요::</option>
				<?
				foreach ( $FAQ as $k => $v ) {
					$selected = ( $faq_categ == $k ) ? " selected" : "";
					echo "<option value='$k' $selected>$v</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$faq_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$faq_content?></textarea>
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