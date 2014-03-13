<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/bad_write.php
 * date   : 2008.08.25
 * desc   : Admin bad write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mainconn->open();

$mode = trim($_REQUEST['mode']);
$bad_idx = trim($_REQUEST['sel_idx']);

if ( $mode == "E" ) {
	$title_tail = "수정";
	
	$sql = "select a.*, b.shop_url, b.shop_name from tblBadShop a, tblShop b where a.shop_idx = b.shop_idx and a.bad_idx = $bad_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$bad_title		= trim($row['bad_title']);
	$bad_content	= trim($row['bad_content']);
	$bad_file		= trim($row['bad_file']);
	$bad_view		= trim($row['bad_view']);
	$bad_ip			= trim($row['bad_ip']);
	$bad_reg_dt		= trim($row['bad_reg_dt']);

	$mem_id			= trim($row['mem_id']);
	$mem_name		= trim($row['mem_name']);

	$shop_url		= trim($row['shop_url']);
	$shop_name		= trim($row['shop_name']);
	$shop_idx		= trim($row['shop_idx']);

	$bad_title		= strip_str($bad_title);
	$bad_content	= strip_str($bad_content);

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
	f.action = "bad_write_ok.php";
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
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$bad_idx?>">
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$bad_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 불량샵 신고 <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 제목&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="title" name="title" value="<?=$bad_title?>" size="50"></strong></font>
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
			<textarea name="content" id="content" type="editor" style="width:700px; height:300px;"><?=$bad_content?></textarea>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a>
			<ol id="uploads"></ol>
			<?
			if ( $bad_file ) {
				$arr_file = explode(";", $bad_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_bad_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_bad_file&savename=$t_bad_file' target='_blank'><img src='/img/file.gif' border='0'></a>&nbsp;";
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