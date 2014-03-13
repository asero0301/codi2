<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/pr_write.php
 * date   : 2008.08.25
 * desc   : Admin pr write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode		= trim($_REQUEST['mode']);
$pr_idx		= trim($_REQUEST['sel_idx']);

$mainconn->open();

if ( $mode == "E" ) {
	$title_tail = "수정";

	$sql = "select a.*, b.shop_url, b.shop_name from tblPr a, tblShop b where a.shop_idx = b.shop_idx and a.pr_idx = $pr_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$mem_id			= trim($row['mem_id']);
	$pr_title		= trim($row['pr_title']);
	$pr_content		= trim($row['pr_content']);
	$pr_file		= trim($row['pr_file']);
	$pr_view		= trim($row['pr_view']);
	$pr_ip			= trim($row['pr_ip']);
	$pr_reg_dt		= trim($row['pr_reg_dt']);

	$shop_idx		= trim($row['shop_idx']);
	$shop_url		= trim($row['shop_url']);
	$shop_name		= trim($row['shop_name']);

	$pr_title		= strip_str($pr_title);
	$pr_content		= strip_str($pr_content);

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
	f.action = "pr_write_ok.php";
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
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$pr_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$pr_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 샵 PR <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$pr_title?>" size="50"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<select id="shop_idx" name="shop_idx">
				<option value="">::: 선택 :::</option>
				<?

				$sql = "select shop_idx, shop_name from tblShop where shop_status = 'Y' order by shop_name ";
				$res = $mainconn->query($sql);
				while ( $row = $mainconn->fetch($res) ) {
					$t_shop_idx		= trim($row['shop_idx']);
					$t_shop_name	= trim($row['shop_name']);
					$selected = ( $t_shop_idx == $shop_idx ) ? " selected" : "";
					echo "<option value='$t_shop_idx' $selected>$t_shop_name</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$pr_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $pr_file ) {
				$arr_file = explode(";", $pr_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_pr_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_pr_file&savename=$t_pr_file' target='_blank'><img src='/img/file.gif' border='0'></a>&nbsp;";
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