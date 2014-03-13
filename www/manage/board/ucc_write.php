<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/ucc_write.php
 * date   : 2008.08.22
 * desc   : Admin ucc write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode		= trim($_REQUEST['mode']);
$ucc_idx	= trim($_REQUEST['sel_idx']);
$ucc_categ	= trim($_REQUEST['ucc_categ']);

if ( $mode == "E" ) {
	$title_tail = "수정";
	$mainconn->open();
	$sql = "select * from tblUcc where ucc_idx = $ucc_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$ucc_categ		= trim($row['ucc_categ']);
	$mem_id			= trim($row['mem_id']);
	$ucc_title		= trim($row['ucc_title']);
	$ucc_content	= trim($row['ucc_content']);
	$ucc_file		= trim($row['ucc_file']);
	$ucc_view		= trim($row['ucc_view']);
	$ucc_ip			= trim($row['ucc_ip']);
	$ucc_reg_dt		= trim($row['ucc_reg_dt']);

	$ucc_title		= strip_str($ucc_title);
	$ucc_content	= strip_str($ucc_content);

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
	f.action = "ucc_write_ok.php";
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
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$ucc_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$ucc_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 코디 UCC <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$ucc_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 분류&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<select id="categ" name="categ">
				<option value="">::: 선택 :::</option>
				<option value="A" <? if ($ucc_categ == "A") echo " selected"; ?>>내 코디를 평가해 주세요</option>
				<option value="B" <? if ($ucc_categ == "B") echo " selected"; ?>>어떤 코디가 좋을까요?</option>
				<option value="C" <? if ($ucc_categ == "C") echo " selected"; ?>>코디를 제안드려요</option>
			</select>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$ucc_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $ucc_file ) {
				$arr_file = explode(";", $ucc_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_ucc_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_ucc_file&savename=$t_ucc_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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