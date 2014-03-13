<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/ucc_view.php
 * date   : 2008.08.21
 * desc   : Admin ucc view
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_REQUEST['mode']);
$ucc_idx = trim($_REQUEST['sel_idx']);

$title_tail = "보기";
$mainconn->open();
$sql = "select *,(select mem_name from tblMember where mem_id=tblUcc.mem_id) as mem_name from tblUcc where ucc_idx = $ucc_idx";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$ucc_title		= trim($row['ucc_title']);
$ucc_content	= trim($row['ucc_content']);
$ucc_categ		= trim($row['ucc_categ']);
$mem_id			= trim($row['mem_id']);
$mem_name		= trim($row['mem_name']);
$ucc_file		= trim($row['ucc_file']);
$ucc_view		= trim($row['ucc_view']);
$ucc_ip			= trim($row['ucc_ip']);
$ucc_reg_dt		= trim($row['ucc_reg_dt']);

switch ( $ucc_categ ) {
	case "A" :
		$ucc_categ_str = "내 코디를 평가해 주세요";
		break;
	case "A" :
		$ucc_categ_str = "떤 코디가 좋을까요?";
		break;
	case "A" :
		$ucc_categ_str = "코디를 제안드려요";
		break;
	default :
		break;
}

$ucc_title		= strip_str($ucc_title,"V");
$ucc_content	= strip_str($ucc_content,"V");

$mainconn->close();


$view_url = "/common/ajax_comment.php?p_idx=$ucc_idx";
$write_url = "/common/ajax_comment_ok.php";
$rurl = my64encode($_SERVER['REQUEST_URI']);

require_once "../_top.php";
?>

<script language="javascript">
function listBoard() {
	var f = document.frm;
	f.action = "ucc_list.php";
	f.submit();
}
function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "ucc_write.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$ucc_idx?>">
<input type="hidden" id="ucc_categ" name="ucc_categ" value="<?=$ucc_categ?>">
<input type="hidden" id="sel_id" name="sel_id" value="">
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
			<font color="#666666"><strong><?=$ucc_title?></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 분류&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><?=$ucc_categ_str?></font>
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
			<font color="#666666"><?=$ucc_reg_dt?></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 내용&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<?=$ucc_content?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
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
		<input type="button" value="목  록" onClick="listBoard();">
		<input type="button" value="수  정" onClick="editBoard('<?=$ucc_idx?>');">
	</td>
  </tr>
</table>

</form>






<!-- 댓글 출력 -->
<div id="BoardCommentArea"></div>

<script language="javascript" src="/js/ajax.js"></script>
<script language="javascript">
loadBoardComment('U','<?=$ucc_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');
</script>
<!-- 댓글 출력 끝 -->



<?php 
require_once "../_bottom.php";
?> 