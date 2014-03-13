<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/focus_write.php
 * date   : 2008.08.20
 * desc   : Admin focus write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
//referer_chk();

$mode		= trim($_REQUEST['mode']);
$focus_idx	= trim($_REQUEST['sel_idx']);

$mainconn->open();

if ( $mode == "E" ) {
	$title_tail = "수정";
	
	$sql = "select * from tblFocus where focus_idx = $focus_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$focus_url			= trim($row['focus_url']);
	$focus_prior		= trim($row['focus_prior']);
	$focus_display_opt	= trim($row['focus_display_opt']);
	$focus_target_opt	= trim($row['focus_target_opt']);
	$focus_file			= trim($row['focus_file']);
	$focus_status		= trim($row['focus_status']);
	$focus_reg_dt		= trim($row['focus_reg_dt']);
	
} else {
	$title_tail = "추가";
}

require_once "../_top.php";
?>

<script language="JavaScript">
function insertPost() {
	var f = document.frm;
	f.encoding = "multipart/form-data";
	f.action = "focus_write_ok.php";
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
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$focus_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$focus_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 포커스관리 <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> URL&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="focus_url" name="focus_url" value="<?=$focus_url?>" size="50"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 우선순위&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<strong><input type="text" id="focus_prior" name="focus_prior" value="<?=$focus_prior?>" size="50"></strong>
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 노출옵션&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    <input type="radio" id="focus_display_opt" name="focus_display_opt" value="M" <? if ( $focus_display_opt == "M" ) echo " checked"; ?>> 메인
				<input type="radio" id="focus_display_opt" name="focus_display_opt" value="S" <? if ( $focus_display_opt == "S" ) echo " checked"; ?>> 서브
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 새창옵션&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<input type="radio" id="focus_target_opt" name="focus_target_opt" value="N" <? if ( $focus_target_opt == "N" ) echo " checked"; ?>> 새창
				<input type="radio" id="focus_target_opt" name="focus_target_opt" value="C" <? if ( $focus_target_opt == "C" ) echo " checked"; ?>> 현재창
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<a href="#" onclick="addFileField()">첨부파일 추가</a> <font color="red">(가로 200px, 세로 344px 로 맞춰주세요)</font>
			<ol id="uploads"></ol>
			<?
			if ( $focus_file ) {
				$arr_file = explode(";", $focus_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_focus_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_focus_file&savename=$t_focus_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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