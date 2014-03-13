<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/qna_view.php
 * date   : 2008.08.21
 * desc   : Admin qna view
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$qna_idx = trim($_REQUEST['sel_idx']);

$title_tail = "보기";
$mainconn->open();
$sql = "select *,(select mem_name from tblMember where mem_id=tblQna.mem_id) as mem_name from tblQna where qna_idx = $qna_idx";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$qna_f_idx		= trim($row['qna_f_idx']);
$qna_depth		= trim($row['qna_depth']);
$qna_title		= trim($row['qna_title']);
$qna_content	= trim($row['qna_content']);
$qna_categ		= trim($row['qna_categ']);
$mem_id			= trim($row['mem_id']);
$mem_name		= trim($row['mem_name']);
$qna_file		= trim($row['qna_file']);
$qna_view		= trim($row['qna_view']);
$qna_ip			= trim($row['qna_ip']);
$qna_reg_dt		= trim($row['qna_reg_dt']);

$qna_title		= strip_str($qna_title,"V");
$qna_content	= strip_str($qna_content,"V");

$mainconn->close();

require_once "../_top.php";
?>

<script language="javascript">
function listBoard() {
	var f = document.frm;
	f.action = "qna_list.php";
	f.submit();
}
function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "qna_write.php";
	f.submit();
}
function replyBoard(idx) {
	var f = document.frm;
	f.mode.value = "R";
	f.sel_idx.value = idx;
	f.action = "qna_write.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$qna_idx?>">
<!--<input type="hidden" id="qna_categ" name="qna_categ" value="<?=$qna_categ?>">-->
<input type="hidden" id="sel_id" name="sel_id" value="">
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
			<font color="#666666"><strong><?=$qna_title?></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 분류&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><?=$QNA[$qna_categ]?></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 작성자&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><?=$mem_name?></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 작성일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><?=$qna_reg_dt?></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?=$qna_content?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
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
		<input type="button" value="목  록" onClick="listBoard();">
		<input type="button" value="수  정" onClick="editBoard('<?=$qna_idx?>');">
		<input type="button" value="답  변" onClick="replyBoard('<?=$qna_idx?>');">
	</td>
  </tr>
</table>

</form>

<?php 
require_once "../_bottom.php";
?> 