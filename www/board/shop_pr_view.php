<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/shop_pr_view.php
 * date   : 2009.01.22
 * desc   : �� PR �󼼺��� (��ü ī�װ�)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$pr_idx = trim($_REQUEST['pr_idx']);

if ( !$pr_idx ) {
	echo "<script>alert('�߸��� �����Դϴ�.');history.go(-1);</script>";
	exit;
}

$mainconn->open();

$sql = "select A.pr_title, A.pr_content, A.pr_file, A.pr_view, A.pr_reg_dt, B.mem_id, B.mem_name, C.shop_idx, C.shop_name from tblPr A, tblMember B, tblShop C where A.mem_id = B.mem_id and A.shop_idx = C.shop_idx and A.pr_idx = $pr_idx ";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$s_mem_id			= trim($row['mem_id']);
$s_mem_name		= trim($row['mem_name']);
$pr_title		= trim($row['pr_title']);
$pr_content		= trim($row['pr_content']);
$pr_file		= trim($row['pr_file']);
$pr_view		= trim($row['pr_view']);
$pr_reg_dt		= trim($row['pr_reg_dt']);
$shop_idx		= trim($row['shop_idx']);
$s_shop_name		= trim($row['shop_name']);

$pr_title		= strip_str($pr_title,"V");
$pr_content	= strip_str($pr_content,"V");
$pr_reg_dt		= str_replace("-",".",substr($pr_reg_dt,0,10));

// �ֱ� 1�ð� �̳� ���� �ʾ����� ��ȸ���� ������Ų��.(ip+categ+idx)
if ( !$_COOKIE["cookie_Pr_".$pr_idx] ) {
	$sql = "update tblPr set pr_view = pr_view + 1 where pr_idx = $pr_idx ";
	$res = $mainconn->query($sql);
	if ( $res ) {	// ��Ű�� ���´�.
		setcookie("cookie_Pr_".$pr_idx, "Y", time()+3600, "/", "coditop10.com");
	}
}

$mainconn->close();

$view_url = "/common/ajax_comment.php?p_idx=$pr_idx";
$write_url = "/common/ajax_comment_ok.php";
$rurl = my64encode($_SERVER['REQUEST_URI']."#reply_anc");
?>

<? require_once "../include/_head.php"; ?>


<iframe name="__blank__" width="0" height="0"></iframe>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- �Խ��� �޴� ���� //-->
			
			<? include "../include/left_board.php" ?>
			
			 <!-- �Խ��� �޴� �� //-->
			</td>
          </tr>
        </table>
       
          </td>
    <td width="15"></td>
    <td valign="top">
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">��PR �Խ��� :</font></b> <font color="#FFFFFF">�ڽ��� ���θ��� ȫ���� �� �ֽ��ϴ�.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="7">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="26"><img src="/img/icon_list.gif"  align="absmiddle" /> <font color="#DD2457"><?=$pr_title?></font></td>
              <td width="160" align="right">�ۼ��� : <b><?=$s_mem_name?></b></td>
            </tr>
            <tr>
              <td height="1" colspan="2" background="/img/dot00.gif"></td>
            </tr>
            <tr>
              <td height="28" colspan="2" style="padding-top:3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" style="padding-left:16" class="date"><?=$pr_reg_dt?> </td>
                    <td align='right'>��ȸ�� : <?=$pr_view?> </td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="15" cellspacing="1" bgcolor="#E1E1E1">
        <tr>
          <td bgcolor="#FFFFFF">

				<?
				if ( $pr_file ) {
					$arr_file = explode(";", $pr_file);
					foreach ( $arr_file as $k => $v ) {
						if ( trim($v) == "" ) continue;
						$t_pr_file = trim($v);
						$t_pr_file = $UP_URL."/attach/".$t_pr_file;
						$file_disp .= "<a href='$t_pr_file' rel='lightbox'><img id='big_pic_$k' src='$t_pr_file' border='0'></a>&nbsp;<br>";
					}
					echo $file_disp;
				}
				?>
				
				<br>

				<?=$pr_content?>


		  </td>
        </tr>
      </table>

      <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
			  <td height='24' align='right' valign='bottom'>
				<a href='#' onClick="go_shop_pr_write('','')"><img src='/img/btn_write.gif' width='60' height='20' border='0' /></a>
				<? if ( $_SESSION['mem_id'] == $s_mem_id ) { ?>
				<a href='#' onClick="go_shop_pr_write('E','<?=$pr_idx?>')"><img src='/img/btn_modify03.gif' width='60' height='20' border='0' /></a>
				<a href='#' onClick="go_shop_pr_del()"><img src='/img/btn_delete.gif' width='60' height='20' border='0' /></a>
				<? } ?>
			  </td>
			</tr>
		</table>

      <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

	  
      <table width="100" height="12" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>



<!-- ��� ���� ���� -->
	  <a name="reply_anc"></a>
	  <div id="BoardCommentArea"></div>
<!-- ��� ���� �� -->


      <table width="100" height="35" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>

	  

<!-- �ϴ� �Խ��� ���� -->
	  <a name="tail_board_anc"></a>
	  <div id="TailBoardArea"></div>
<!-- �ϴ� �Խ��� �� -->
	  



	  </td>
  </tr>
</table>


<form id="board_frm" name="board_frm" method="post">
<input type="hidden" id="pr_idx" name="pr_idx" value="<?=$pr_idx?>" />
<input type="hidden" id="mode" name="mode" value="" />
</form>

<script language="javascript">
// lightbox �ε�
initLightbox();

// �̹��� ũ�⿡ �°� �ε�
// ������ �ε��ǰ� 1���Ŀ� �������� �ȴ�.
window.setTimeout("img_resize(600)",500);

// ���
loadBoardComment('P','<?=$pr_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');

<?
/*
loadTailBoard(tkind,tkey,tkwd,tpage,ttkind)
tkind : "U"->UCC, "N"->Notice, "P"->Pr
tkey : �˻�������("M"->ȸ���̸�, "T"->����, "C"->����, "TC"->����+����
tkwd : �˻���
tpage : ������, �� ��� �������� �����ϱ� ���� page�� �ƴ� tpage
ttkind : UCC�϶� ""->��ü, "A"->�ڵ���, "B"->�ڵ���õ, "C"->�ڵ��Ƿ�, UCC�� �ƴҶ��� �׳� ����
*/
?>
// �ϴ� �Խ���
loadTailBoard('P','','','1','');
</script>

<? include "../include/_foot.php"; ?>