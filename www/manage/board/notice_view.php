<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/notice_view.php
 * date   : 2008.08.21
 * desc   : Admin notice view
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$notice_idx = trim($_REQUEST['sel_idx']);

$title_tail = "보기";
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

$notice_title		= strip_str($notice_title,"V");
$notice_content		= strip_str($notice_content,"V");

$mainconn->close();


$view_url = "/common/ajax_comment.php?p_idx=$notice_idx";
$write_url = "/common/ajax_comment_ok.php";
$rurl = my64encode($_SERVER['REQUEST_URI']);

require_once "../_top.php";
?>

<script language="javascript">
function listBoard() {
	var f = document.frm;
	f.action = "notice_list.php";
	f.submit();
}
function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "notice_write.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$notice_idx?>">
<input type="hidden" id="sel_id" name="sel_id" value="">
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
			<font color="#666666"><strong><?=$notice_title?></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?=$notice_content?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?
			if ( $notice_file ) {
				$arr_file = explode(";", $notice_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_notice_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_notice_file&savename=$t_notice_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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
		<input type="button" value="수  정" onClick="editBoard('<?=$notice_idx?>');">
	</td>
  </tr>
</table>

</form>






<!-- 댓글 출력 -->
<div id="BoardCommentArea"></div>

<script language="javascript" src="/js/ajax.js"></script>
<script language="javascript">
loadBoardComment('N','<?=$notice_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');
</script>
<!-- 댓글 출력 끝 -->



<?php 
require_once "../_bottom.php";
?> 