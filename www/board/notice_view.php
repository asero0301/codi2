<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/notice_view.php
 * date   : 2009.01.22
 * desc   : 공지사항 상세보기 (전체 카테고리)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$notice_idx = trim($_REQUEST['notice_idx']);

if ( !$notice_idx ) {
	echo "<script>alert('잘못된 접근입니다.');history.go(-1);</script>";
	exit;
}

$mainconn->open();

$sql = "select A.notice_title, A.notice_content, A.notice_file, A.notice_view, A.notice_reg_dt, B.mem_id, B.mem_name from tblNotice A, tblMember B where A.mem_id = B.mem_id and A.notice_idx = $notice_idx ";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$s_mem_id			= trim($row['mem_id']);
$s_mem_name		= trim($row['mem_name']);
$notice_title		= trim($row['notice_title']);
$notice_content		= trim($row['notice_content']);
$notice_file		= trim($row['notice_file']);
$notice_view		= trim($row['notice_view']);
$notice_reg_dt		= trim($row['notice_reg_dt']);

$notice_title		= strip_str($notice_title,"V");
$notice_content	= strip_str($notice_content,"V");
$notice_reg_dt		= str_replace("-",".",substr($notice_reg_dt,0,10));

// 최근 1시간 이내 보지 않았으면 조회수를 증가시킨다.(ip+categ+idx)
if ( !$_COOKIE["cookie_N_".$notice_idx] ) {
	$sql = "update tblNotice set notice_view = notice_view + 1 where notice_idx = $notice_idx ";
	$res = $mainconn->query($sql);
	if ( $res ) {	// 쿠키를 굽는다.
		setcookie("cookie_N_".$notice_idx, "Y", time()+3600, "/", "coditop10.com");
	}
}

$mainconn->close();

$view_url = "/common/ajax_comment.php?p_idx=$notice_idx";
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
			
			 <!-- 게시판 메뉴 시작 //-->
			
			<? include "../include/left_board.php" ?>
			
			 <!-- 게시판 메뉴 끝 //-->
			</td>
          </tr>
        </table>
       
          </td>
    <td width="15"></td>
    <td valign="top">
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">공지사항 :</font></b> <font color="#FFFFFF">코디탑텐 공지사항입니다.</font> </td>
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
              <td height="26"><img src="/img/icon_list.gif"  align="absmiddle" /> <font color="#DD2457"><?=$notice_title?></font></td>
              <td width="160" align="right">작성자 : <b><?=$s_mem_name?></b></td>
            </tr>
            <tr>
              <td height="1" colspan="2" background="/img/dot00.gif"></td>
            </tr>
            <tr>
              <td height="28" colspan="2" style="padding-top:3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" style="padding-left:16" class="date"><?=$notice_reg_dt?> </td>
                    <td align='right'>조회수 : <?=$notice_view?> </td>
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
				if ( $notice_file ) {
					$arr_file = explode(";", $notice_file);
					foreach ( $arr_file as $k => $v ) {
						if ( trim($v) == "" ) continue;
						$t_notice_file = trim($v);
						$t_notice_file = $UP_URL."/attach/".$t_notice_file;
						$file_disp .= "<a href='$t_notice_file' rel='lightbox'><img id='big_pic_$k' src='$t_notice_file' border='0'></a>&nbsp;<br>";
					}
					echo $file_disp;
				}
				?>
				
				<br>

				<?=$notice_content?>


		  </td>
        </tr>
      </table>

      <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>


<!-- 댓글 영역 시작 -->
	  <a name="reply_anc"></a>
	  <div id="BoardCommentArea"></div>
<!-- 댓글 영역 끝 -->


      <table width="100" height="35" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>

	  

<!-- 하단 게시판 시작 -->
	  <a name="tail_board_anc"></a>
	  <div id="TailBoardArea"></div>
<!-- 하단 게시판 끝 -->
	  



	  </td>
  </tr>
</table>


<form id="board_frm" name="board_frm" method="post">
<input type="hidden" id="notice_idx" name="notice_idx" value="<?=$notice_idx?>" />
<input type="hidden" id="mode" name="mode" value="" />
</form>


<script language="javascript">
// lightbox 로딩
initLightbox();

// 이미지 크기에 맞게 로딩
// 페이지 로딩되고 1초후에 리사이즈 된다.
window.setTimeout("img_resize(600)",500);

// 댓글
//loadBoardComment('N','<?=$notice_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');

<?
/*
loadTailBoard(tkind,tkey,tkwd,tpage,ttkind)
tkind : "U"->UCC, "N"->Notice, "P"->Pr
tkey : 검색구분자("M"->회원이름, "T"->제목, "C"->내용, "TC"->제목+내용
tkwd : 검색어
tpage : 페이지, 위 댓글 페이지와 구분하기 위해 page가 아닌 tpage
ttkind : UCC일때 ""->전체, "A"->코디평가, "B"->코디추천, "C"->코디의뢰, UCC가 아닐때는 그냥 공백
*/
?>
// 하단 게시판
loadTailBoard('N','','','1','');
</script>

<? include "../include/_foot.php"; ?>