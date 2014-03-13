<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/bad_view.php
 * date   : 2008.08.21
 * desc   : Admin bad view
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$bad_idx = trim($_REQUEST['sel_idx']);

$title_tail = "보기";
$mainconn->open();
$sql = "select a.*, b.shop_url, b.shop_name, (select mem_name from tblMember where mem_id=a.mem_id) as mem_name from tblBadShop a, tblShop b where a.shop_idx = b.shop_idx and bad_idx = $bad_idx";

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

$bad_title		= strip_str($bad_title,"V");
$bad_content	= strip_str($bad_content,"V");

$mainconn->close();

require_once "../_top.php";
?>

<script language="javascript">
function listBoard() {
	var f = document.frm;
	f.action = "bad_list.php";
	f.submit();
}
function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "bad_write.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$bad_idx?>">
<input type="hidden" id="sel_id" name="sel_id" value="">
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
			<font color="#666666"><strong><?=$bad_title?></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><a href="<?=$shop_url?>" target="_blank"><?=$shop_name?></a></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?=$bad_content?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?
			if ( $bad_file ) {
				$arr_file = explode(";", $bad_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_bad_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_bad_file&savename=$t_bad_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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
		<input type="button" value="목  록" onClick="listBoard();">
		<input type="button" value="수  정" onClick="editBoard('<?=$bad_idx?>');">
	</td>
  </tr>
</table>

</form>


<?php 
require_once "../_bottom.php";
?> 