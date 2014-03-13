<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/focus_write.php
 * date   : 2008.08.20
 * desc   : Admin focus write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
//referer_chk();

$mode		= trim($_REQUEST['mode']);
$focus_idx	= trim($_REQUEST['sel_idx']);

$mainconn->open();

if ( $mode == "E" ) {
	$title_tail = "����";
	
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
	$title_tail = "�߰�";
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
	<td width="50%" height="23"><b><font color="#333333">�� ��Ŀ������ <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> URL&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="focus_url" name="focus_url" value="<?=$focus_url?>" size="50"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �켱����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<strong><input type="text" id="focus_prior" name="focus_prior" value="<?=$focus_prior?>" size="50"></strong>
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ����ɼ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    <input type="radio" id="focus_display_opt" name="focus_display_opt" value="M" <? if ( $focus_display_opt == "M" ) echo " checked"; ?>> ����
				<input type="radio" id="focus_display_opt" name="focus_display_opt" value="S" <? if ( $focus_display_opt == "S" ) echo " checked"; ?>> ����
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��â�ɼ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
				<input type="radio" id="focus_target_opt" name="focus_target_opt" value="N" <? if ( $focus_target_opt == "N" ) echo " checked"; ?>> ��â
				<input type="radio" id="focus_target_opt" name="focus_target_opt" value="C" <? if ( $focus_target_opt == "C" ) echo " checked"; ?>> ����â
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ÷������&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<a href="#" onclick="addFileField()">÷������ �߰�</a> <font color="red">(���� 200px, ���� 344px �� �����ּ���)</font>
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
		<input type="button" value="��  ��" onClick="insertPost();">
	</td>
  </tr>
</table>



</form>



<?php 

$mainconn->close();

require_once "../_bottom.php";

?> 