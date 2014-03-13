<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/include/left_my.php
 * date   : 2008.10.08
 * desc   : 마이페이지 좌측메뉴
 *******************************************************/

$php_self = strtolower(trim(strtolower($_SERVER['PHP_SELF'])));

if ( $php_self == "/mypage/mypage.php" ) {
	$left_icon_mypage = "icon_tieov.gif";
	$left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/level.php" ) {
	$left_icon_level = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/history.php" ) {
	$left_icon_history = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/comment.php" ) {
	$left_icon_comment = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/mshop.php" ) {
	$left_icon_Mshop = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/mcodi.php" ) {
	$left_icon_Mcodi = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/mgift.php" ) {
	$left_icon_Mgift = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/mcash.php" ) {
	$left_icon_Mcash = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mtax = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/mypage/mtax.php" ) {
	$left_icon_Mtax = "icon_tieov.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = "icon_tie.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
} else if ( $php_self == "/msg/msg_recv_list.php" ) {
	$memo_img_1 = "meno_title01ov.gif";
	$memo_img_2 = "meno_title02.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
} else if ( $php_self == "/msg/msg_send_list.php" ) {
	$memo_img_2 = "meno_title02ov.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_4 = "meno_title04.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
} else if ( $php_self == "/msg/msg_forever_list.php" ) {
	$memo_img_3 = "meno_title03ov.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_2 = "meno_title02.gif"; $memo_img_4 = "meno_title04.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
} else if ( $php_self == "/msg/msg_write.php" ) {
	$memo_img_4 = "meno_title04ov.gif";
	$memo_img_1 = "meno_title01.gif"; $memo_img_3 = "meno_title03.gif"; $memo_img_2 = "meno_title02.gif";
	$left_icon_mypage = $left_icon_level = $left_icon_history = $left_icon_comment = $left_icon_Mshop = $left_icon_Mcodi = $left_icon_Mgift = $left_icon_Mcash = $left_icon_Mtax = "icon_tie.gif";
}
?>


<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="/img/left_my_title.gif" ></td>
  </tr>
  <tr>
    <td align="center" background="/img/left_bg01.gif">
	<table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
      <tr>
        <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_mypage?>" width="10" height="10" align="absmiddle"> <a href="/mypage/mypage.php">기본정보관리 </a></td>
      </tr>

    </table>

      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

<? if ( $_SESSION['mem_kind'] == "U" ) { ?>

	  <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_level?>" width="10" height="10" align="absmiddle"> <a href="/mypage/level.php">당첨등급 </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_history?>" width="10" height="10" align="absmiddle"> <a href="/mypage/history.php">당첨내역 </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_comment?>" width="10" height="10" align="absmiddle"> <a href="/mypage/comment.php">평가한 코디 </a></td>
        </tr>
      </table>

<? } else { ?>

      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_Mshop?>" width="10" height="10" align="absmiddle"> <a href="/mypage/Mshop.php">샵관리 </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_Mcodi?>" width="10" height="10" align="absmiddle"> <a href="/mypage/Mcodi.php">코디상품관리 </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_Mgift?>" width="10" height="10" align="absmiddle"> <a href="/mypage/Mgift.php">경품지급관리 </a></td>
        </tr>
      </table>
	  
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>      
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_Mcash?>" width="10" height="10" align="absmiddle"> <a href="/mypage/Mcash.php">캐쉬관리 </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_Mtax?>" width="10" height="10" align="absmiddle"> <a href="/mypage/Mtax.php">세금계산서 </a></td>
        </tr>
      </table>
<? } ?>


<table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
        </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="FF5B5C">
          <tr>
            <td height="26" bgcolor="FFDBDB" style="padding-left:10"><img src="/img/icon_memo02.gif" width="12" height="14" align="absmiddle"> <a href="#" onClick="go_recv_msg();">쪽지함 </a></td>
          </tr>
        </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
        </table>
      <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><a href="#" onClick="go_recv_msg();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('memo01','','/img/meno_title01ov.gif',1)"><img src="/img/<?=$memo_img_1?>" name="memo01" border="0" id="memo01" /></a></td>
          </tr>
          <tr>
            <td><a href="#" onClick="go_send_msg();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('memo02','','/img/meno_title02ov.gif',1)"><img src="/img/<?=$memo_img_2?>" name="memo02" width="66" height="18" border="0" id="memo02" /></a></td>
          </tr>
          <tr>
            <td><a href="#" onClick="go_forever_msg();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('memo03','','/img/meno_title03ov.gif',1)"><img src="/img/<?=$memo_img_3?>" name="memo03" width="66" height="18" border="0" id="memo03" /></a></td>
          </tr>
          <tr>
            <td><a href="#" onClick="go_write_msg();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('memo04','','/img/meno_title04ov.gif',1)"><img src="/img/<?=$memo_img_4?>" name="memo04" width="66" height="18" border="0" id="memo04" /></a></td>
          </tr>
      </table> 

    </td>
  </tr>
  <tr>
    <td><img src="/img/left_bg02.gif" width="200" height="16"></td>
  </tr>
</table>


