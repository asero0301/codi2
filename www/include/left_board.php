<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/include/left_board.php
 * date   : 2009.01.16
 * desc   : 게시판 좌측메뉴
 *******************************************************/

$php_self = trim(strtolower($_SERVER['PHP_SELF']));

//if ( eregi("/board/ucc*.", $php_self) ) {
if ( preg_match("#/board/ucc*.#i" , $php_self) ) {
	$left_icon_1 = "icon_tieov.gif";
	$left_icon_2 = $left_icon_3 = $left_icon_4 = "icon_tie.gif";
	$font_1_a = "<b><font color='#DD2457'>"; $font_1_b = "</font></b>";
} else if ( preg_match("#/board/shop_pr_*.#i", $php_self) ) {
	$left_icon_2 = "icon_tieov.gif";
	$left_icon_1 = $left_icon_3 = $left_icon_4 = "icon_tie.gif";
	$font_2_a = "<b><font color='#DD2457'>"; $font_2_b = "</font></b>";
} else if ( preg_match("#/board/notice_*.#i", $php_self) ) {
	$left_icon_3 = "icon_tieov.gif";
	$left_icon_2 = $left_icon_1 = $left_icon_4 = "icon_tie.gif";
	$font_3_a = "<b><font color='#DD2457'>"; $font_3_b = "</font></b>";
} else if ( preg_match("#/board/bad_shop_*.#i", $php_self) ) {
	$left_icon_4 = "icon_tieov.gif";
	$left_icon_2 = $left_icon_3 = $left_icon_1 = "icon_tie.gif";
	$font_4_a = "<b><font color='#DD2457'>"; $font_4_b = "</font></b>";
} else {
	$left_icon_1 = $left_icon_2 = $left_icon_3 = $left_icon_4 = "icon_tie.gif";
}
?>

<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="/img/left_board_title.gif" ></td>
  </tr>
  <tr>
    <td align="center" background="../img/left_bg01.gif"><table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
      <tr>
        <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_1?>" width="10" height="10" align="absmiddle"> <a href="/board/ucc_list.php"><?=$font_1_a?>코디 UCC<?=$font_1_b?> </a></td>
      </tr>

    </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_2?>" width="10" height="10" align="absmiddle"> <a href="/board/shop_pr_list.php"><?=$font_2_a?>샵 PR 게시판<?=$font_2_b?> </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_3?>" width="10" height="10" align="absmiddle"> <a href="/board/notice_list.php"><?=$font_3_a?>공지사항<?=$font_3_b?> </a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_4?>" width="10" height="10" align="absmiddle"> <a href="/board/bad_shop_list.php"><?=$font_4_a?>불량샵 신고<?=$font_4_b?> </a></td>
        </tr>
      </table>
	  
     

    
   

    </td>
  </tr>
  <tr>
    <td><img src="../img/left_bg02.gif" width="200" height="16"></td>
  </tr>
</table>
  <table width="100" height="3" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>
      </table>

<a href="/board/luck_list.php"><img src="/img/btn_luck.gif" width="200" height="79" border="0" /></a>