<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/pr_view.php
 * date   : 2008.08.21
 * desc   : Admin pr view
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$pr_idx = trim($_REQUEST['sel_idx']);

$title_tail = "보기";
$mainconn->open();

$sql = "select a.*, b.shop_url, b.shop_name, (select mem_name from tblMember where mem_id=a.mem_id) as mem_name from tblPr a, tblShop b where a.shop_idx = b.shop_idx and a.pr_idx = $pr_idx";

$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$pr_title		= trim($row['pr_title']);
$pr_content		= trim($row['pr_content']);
$shop_idx		= trim($row['shop_idx']);
$shop_url		= trim($row['shop_url']);
$shop_name		= strip_str(trim($row['shop_name']));
$mem_id			= trim($row['mem_id']);
$mem_name		= trim($row['mem_name']);
$pr_file		= trim($row['pr_file']);
$pr_view		= trim($row['pr_view']);
$pr_ip			= trim($row['pr_ip']);
$pr_reg_dt		= trim($row['pr_reg_dt']);

$pr_title		= strip_str($pr_title,"V");
$pr_content		= strip_str($pr_content,"V");

$mainconn->close();


$view_url = "/common/ajax_comment.php?p_idx=$pr_idx";
$write_url = "/common/ajax_comment_ok.php";
$rurl = my64encode($_SERVER['REQUEST_URI']);

require_once "../_top.php";
?>

<script language="javascript">
function listBoard() {
	var f = document.frm;
	f.action = "pr_list.php";
	f.submit();
}
function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "pr_write.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$pr_idx?>">
<input type="hidden" id="shop_idx" name="shop_idx" value="<?=$shop_idx?>">
<input type="hidden" id="sel_id" name="sel_id" value="">
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
			<font color="#666666"><strong><?=$pr_title?></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><a href="<?=$shop_url?>" target="_blank"><?=$shop_name?></a></font>
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
			<font color="#666666"><?=$pr_reg_dt?></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?=$pr_content?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?
			if ( $pr_file ) {
				$arr_file = explode(";", $pr_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_pr_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_pr_file&savename=$t_pr_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
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
		<input type="button" value="수  정" onClick="editBoard('<?=$pr_idx?>');">
	</td>
  </tr>
</table>

</form>






<!-- 댓글 출력 -->
<div id="BoardCommentArea"></div>

<script language="javascript" src="/js/ajax.js"></script>
<script language="javascript">
loadBoardComment('P','<?=$pr_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');
</script>
<!-- 댓글 출력 끝 -->



<?php 
require_once "../_bottom.php";
?> 