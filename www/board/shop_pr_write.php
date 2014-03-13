<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/shop_pr_write.php
 * date   : 2009.01.22
 * desc   : 샵 PR 작성 (전체 카테고리)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// 인증여부 체크
auth_chk($RURL);

// 일반회원만 가능
if ( $_SESSION['mem_kind'] != "S" ) {
	echo "<script>alert('샵회원만 작성가능합니다'); location.href='/board/shop_pr_list.php';</script>";
	exit;
}

$mode = trim($_REQUEST['mode']);
$pr_idx = trim($_REQUEST['pr_idx']);

if ( !$mode ) $mode = "I";

$mainconn->open();

if ( $mode == "E" ) {
	
	$sql = "select * from tblPr where pr_idx = $pr_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$shop_idx		= trim($row['shop_idx']);
	$mem_id			= trim($row['mem_id']);
	$pr_title		= trim($row['pr_title']);
	$pr_content		= trim($row['pr_content']);
	$pr_file		= trim($row['pr_file']);
	$pr_view		= trim($row['pr_view']);
	$pr_ip			= trim($row['pr_ip']);
	$pr_reg_dt		= trim($row['pr_reg_dt']);

	if ( $pr_file ) {
		$arr_file = explode(";", $pr_file);
		$cnt = 0;
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$cnt++;
			$t_pr_file = trim($v);
			$t_pr_file = $UP_URL."/attach/".$t_pr_file;
			${'file_'.$cnt.'_view'} .= "<a href='$t_pr_file' rel='lightbox'><img src='$t_pr_file' border='0' width='20' height='20' align='absmiddle' style='cursor:hand;' /></a>";
		}
	}

	$pr_title	= strip_str($pr_title);
	$pr_content	= strip_str($pr_content);

}

$sql = "select shop_idx, shop_name from tblShop where mem_id = '".$_SESSION['mem_id']."' ";
$res = $mainconn->query($sql);
$sel_list = "";
while ( $row = $mainconn->fetch($res) ) {
	$t_shop_idx = $row['shop_idx'];
	$t_shop_name = $row['shop_name'];

	$sel = ( $shop_idx == $t_shop_idx ) ? " selected" : "";
	$sel_list .= "<option value='".$t_shop_idx."' $sel>".$t_shop_name."</option>";
}

$mainconn->close();
?>

<? require_once "../include/_head.php"; ?>

<script language="JavaScript" src="/wysiwyg/wysiwyg.js"></script>
<script language="JavaScript">
function goPrSubmit() {
	var f = document.board_frm;

	if ( f.shop_idx.value == "" ) {
		alert("샵을 선택하세요.");
		f.shop_idx.focus();
		return;
	}
	if ( f.pr_title.value == "" ) {
		alert("제목을 입력하세요");
		f.pr_title.focus();
		return;
	}
	if ( f.pr_content.value == "" ) {
		alert("내용을 입력하세요");
		f.pr_content.focus();
		return;
	}
	if ( document.getElementById("up_1").value ) {
		if ( checkExt(document.getElementById("up_1").value) == false ) return;
	}
	if ( document.getElementById("up_2").value ) {
		if ( checkExt(document.getElementById("up_2").value) == false ) return;
	}
	if ( document.getElementById("up_3").value ) {
		if ( checkExt(document.getElementById("up_3").value) == false ) return;
	}
	
	f.action = "/board/shop_pr_write_ok.php";
	f.encoding = "multipart/form-data";
	f.submit();
}
function checkExt(val) {
    var img_format = "\\.(gif|jpg|png)$";
    if((new RegExp(img_format, "i")).test(val)) return true;
    alert("jpg, gif, png 파일만 업로드 가능합니다.");
    return false;
}
function file_offset_reset(num) {
	var f = document.board_frm;
	str = f.file_offset.value;
	obj = document.getElementById("up_"+num);
	
	if ( str.indexOf(num) == -1 && obj.value ) {
		f.file_offset.value = str + num + ";";
	}	
}
</script>
<table border="0" cellspacing="0" cellpadding="0">
<form id="board_frm" name="board_frm" method="post">
<input type="hidden" name="mode" id="mode" value="<?=$mode?>" />
<input type="hidden" name="pr_idx" id="pr_idx" value="<?=$pr_idx?>" />
<input type="hidden" name="old_file_list" id="old_file_list" value="<?=$pr_file?>" />
<input type="hidden" name="file_offset" id="file_offset" value="" />

  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 게시판 메뉴 시작 //-->
			
			<? require_once "../include/left_board.php" ?>
			
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
        <td background="/img/bar03.gif"><b><font color="FFFC11">샵PR 게시판 :</font></b> <font color="#FFFFFF">자신의 쇼핑몰을 홍보할 수 있습니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                    <tr>
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">샵 PR 게시판의 글 등록은 <font color="FF0078">샵회원만 가능</font>합니다. (일반회원은 댓글만 가능)</font> 

<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>

                          <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> 도배, 음란, 직접적인 홍보/광고, 기타 게시판 운영기준에 어긋나는 게시물은 별다른 통보없이 삭제 또는 수정될 수<br />
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;있습니다. </td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>

      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="80" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 구 분 </td>
                      <td>
						  <select name="shop_idx" id="shop_idx" class="logbox"  style="width:150">
							<option value="">::: 선택해주세요 :::</option>
							<? echo $sel_list; ?>
						  </select>
					  </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 제 목 </td>
                      <td><input type="text" name="pr_title" id="pr_title" class="logbox" value="<?=$pr_title?>" style="width:100%" /></td>
                    </tr>
                    <tr>
                       <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 내 용 </td>
                      <td>
					  <textarea name="pr_content" id="pr_content" class="memobox" type="editor" style="width:100%; height:300;"><?=$pr_content?>
					  </textarea>
					  </td>
                    </tr>
                  </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="1" background="/img/dot00.gif"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
					  <tr>
                        <td width="80" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 이미지 1 </td>
                        <td valign='absmiddle'><input type="file" id="up_1" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('1');" />&nbsp;<?=$file_1_view?></td>
                      </tr>

					  <tr>
                        <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 이미지 2 </td>
                        <td valign='absmiddle'><input type="file" id="up_2" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('2');" />&nbsp;<?=$file_2_view?></td>
                      </tr>
					  
					  <tr>
                        <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 이미지 3 </td>
                        <td valign='absmiddle'><input type="file" id="up_3" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('3');" />&nbsp;<?=$file_3_view?></td>
                      </tr>
                    </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
			<a href="#" onClick="goPrSubmit();"><img src="/img/btn_write_ok.gif" width="60" height="20" border="0" /></a>&nbsp;
			<a href="#" onClick="go_shop_pr();"><img src="/img/btn_cancle05.gif" width="60" height="20" border="0" /></a></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>

<script language="javascript">
// lightbox 로딩
initLightbox();
</script>

<? include "../include/_foot.php"; ?>