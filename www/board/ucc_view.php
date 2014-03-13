<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/ucc_view.php
 * date   : 2009.01.19
 * desc   : 코디 ucc 상세보기 (전체 카테고리)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

$ucc_idx = trim($_REQUEST['ucc_idx']);

if ( !$ucc_idx ) {
	echo "<script>alert('잘못된 접근입니다.');history.go(-1);</script>";
	exit;
}

$mainconn->open();
$sql = "select *,(select mem_name from tblMember where mem_id=tblUcc.mem_id) as mem_name, (select ifnull(sum(ucc_s_score),0) from tblUccScore where ucc_idx=tblUcc.ucc_idx) as score from tblUcc where ucc_idx = $ucc_idx";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$ucc_categ		= trim($row['ucc_categ']);
$s_mem_id			= trim($row['mem_id']);
$s_mem_name		= trim($row['mem_name']);
$ucc_title		= trim($row['ucc_title']);
$ucc_content	= trim($row['ucc_content']);
$ucc_file		= trim($row['ucc_file']);
$ucc_view		= trim($row['ucc_view']);
$ucc_ip			= trim($row['ucc_ip']);
$ucc_reg_dt		= trim($row['ucc_reg_dt']);
$score			= trim($row['score']);

$ucc_title		= strip_str($ucc_title,"V");
$ucc_content	= strip_str($ucc_content,"V");
$ucc_reg_dt		= str_replace("-",".",substr($ucc_reg_dt,0,10));

// 최근 1시간 이내 보지 않았으면 조회수를 증가시킨다.(ip+categ+idx)
if ( !$_COOKIE["cookie_U_".$ucc_idx] ) {
	$sql = "update tblUcc set ucc_view = ucc_view + 1 where ucc_idx = $ucc_idx ";
	$res = $mainconn->query($sql);
	if ( $res ) {	// 쿠키를 굽는다.
		setcookie("cookie_U_".$ucc_idx, "Y", time()+3600, "/", "coditop10.com");
	}
}

$mainconn->close();

$view_url = "/common/ajax_comment.php?p_idx=$ucc_idx";
$write_url = "/common/ajax_comment_ok.php";
$rurl = my64encode($_SERVER['REQUEST_URI']."#reply_anc");
?>

<? require_once "../include/_head.php"; ?>

<script language="javascript">
function goUccScoreProc() {
	var f = document.board_frm;

	cnt = 0;
	for ( i=0; i<f.ucc_s_score.length; i++ ) {
		if ( f.ucc_s_score[i].checked == true ) {
			cnt++;
			break;
		}
	}
	if ( cnt < 1 ) {
		alert("점수를 선택하세요.");
		//f.ucc_s_score.focus();
		return;
	}
	var id = "<?=$_SESSION['mem_id']?>";
	if ( id == "" ) {
		alert("로그인을 하셔야 점수를 매길수 있습니다.");
		f.target = "_self";
		f.action = "/member/login.php";
		f.submit();
	}
	if ( id == '<?=$s_mem_id?>' ) {
		alert("자신이 평가할 수 없습니다.");
		return false;
	}
	f.target = "__blank__";
	f.action = "/board/ucc_score_proc.php";
	f.submit();
}
</script>


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
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">코디UCC :</font></b> <font color="#FFFFFF">자신의 코디를 등록해 보세요. 다양한 평가를 받을 수 있습니다.</font> </td>
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
              <td height="26"><img src="/img/icon_list.gif"  align="absmiddle" /> <font color="#DD2457"><?=$ucc_title?></font></td>
              <td width="160" align="right">작성자 : <b><?=$s_mem_name?></b></td>
            </tr>
            <tr>
              <td height="1" colspan="2" background="/img/dot00.gif"></td>
            </tr>
            <tr>
              <td height="28" colspan="2" style="padding-top:3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" style="padding-left:16" class="date"><?=$ucc_reg_dt?> </td>
                    <td >조회수 : <?=$ucc_view?> </td>
                    <td width="80">총점수 : <span id="label_ucc_score"><?=$score?></span> </td>
                    <td width="60" align="right"><font color="FF0078"><?=$UCC_CATEG[$ucc_categ][0]?></font></td>
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
				if ( $ucc_file ) {
					$arr_file = explode(";", $ucc_file);
					foreach ( $arr_file as $k => $v ) {
						if ( trim($v) == "" ) continue;
						$t_ucc_file = trim($v);
						$t_ucc_file = $UP_URL."/attach/".$t_ucc_file;
						$file_disp .= "<a href='$t_ucc_file' rel='lightbox'><img id='big_pic_$k' src='$t_ucc_file' border='0'></a>&nbsp;<br>";
					}
					echo $file_disp;
				}
				?>
				
				<br>

				<?=$ucc_content?>


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
				<a href='#' onClick="go_ucc_write('','','')"><img src='/img/btn_write.gif' width='60' height='20' border='0' /></a>
				<? if ( $_SESSION['mem_id'] == $s_mem_id ) { ?>
				<a href='#' onClick="go_ucc_write('E','<?=$ucc_categ?>','<?=$ucc_idx?>')"><img src='/img/btn_modify03.gif' width='60' height='20' border='0' /></a>
				<a href='#' onClick="go_ucc_del()"><img src='/img/btn_delete.gif' width='60' height='20' border='0' /></a>
				<? } ?>
			  </td>
			</tr>
		</table>

      <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

	  <a name="ucc_score_tag"></a>
	  <table width="645" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
	  <form id="board_frm" name="board_frm" method="post">
	  <input type="hidden" id="ucc_idx" name="ucc_idx" value="<?=$ucc_idx?>" />
	  <input type="hidden" id="mode" name="mode" value="" />
        <tr>
          <td align="center" style="padding:15 15 15 15">
            <tr>		  <table border="0" cellspacing="0" cellpadding="0">

              <td>
                <input id="ucc_s_score" name="ucc_s_score" type="radio" value="1" />1점
				<input id="ucc_s_score" name="ucc_s_score" type="radio" value="2" />2점
				<input id="ucc_s_score" name="ucc_s_score" type="radio" value="3" />3점
				<input id="ucc_s_score" name="ucc_s_score" type="radio" value="4" />4점
				<input id="ucc_s_score" name="ucc_s_score" type="radio" value="5" />5점
			  </td>
              <td width="90" align="right"><a href="#ucc_score_tag" onClick="goUccScoreProc();"><img src="/img/btn_point.gif" width="80" height="20" border="0" /></a></td>
            </tr>
          </table></td>
        </tr>
	  </form>
      </table>
	  
      <table width="100" height="12" border="0" cellpadding="0" cellspacing="0">
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




<form name="frm" id="frm" method="post">
<input type="hidden" id="sel_id" name="sel_id" value="" />
</form>

<script language="javascript">
// lightbox 로딩
initLightbox();

// 이미지 크기에 맞게 로딩
// 페이지 로딩되고 1초후에 리사이즈 된다.
window.setTimeout("img_resize(600)",500);

// 댓글
loadBoardComment('U','<?=$ucc_idx?>','<?=$view_url?>','1','<?=$write_url?>','<?=$_SESSION[mem_id]?>','<?=$rurl?>');

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
loadTailBoard('U','','','1','');
</script>

<? include "../include/_foot.php"; ?>