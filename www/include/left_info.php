<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/include/left_info.php
 * date   : 2008.12.22
 * desc   : info �����޴�
 *******************************************************/

$php_self = trim(strtolower($_SERVER['PHP_SELF']));

if ( $php_self == "/info/info.php" ) {
	$left_icon_info = "icon_tieov.gif";
	$left_icon_guide = $left_icon_policy = $left_icon_protect = $left_icon_contact = "icon_tie.gif";
} else if ( $php_self == "/info/home_guide.php" ) {
	$left_icon_policy = "icon_tieov.gif";
	$left_icon_info = $left_icon_guide = $left_icon_protect = $left_icon_contact = "icon_tie.gif";
} else if ( $php_self == "/info/home_protect.php" ) {
	$left_icon_protect = "icon_tieov.gif";
	$left_icon_info = $left_icon_guide = $left_icon_policy = $left_icon_contact = "icon_tie.gif";
} else if ( $php_self == "/info/home_join.php" ) {
	$left_icon_contact = "icon_tieov.gif";
	$left_icon_info = $left_icon_guide = $left_icon_policy = $left_icon_protect = "icon_tie.gif";
} else {
	$left_icon_guide = "icon_tieov.gif";
	$left_icon_info = $left_icon_policy = $left_icon_protect = $left_icon_contact = "icon_tie.gif";
}
?>

<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="/img/left_info_title.gif"></td>
  </tr>
  <tr>
    <td align="center" background="/img/left_bg01.gif"><table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
      <tr>
        <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_info?>" width="10" height="10" align="absmiddle"> <a href="/info/info.php">����Ʈ �Ұ� </a></td>
      </tr>

    </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_guide?>" width="10" height="10" align="absmiddle"> <a href="/info/user_guide.php">����Ʈ �̿�ȳ� </a></td>
        </tr>
      </table>
      <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="130" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="14" class="evmem"><a href="/info/user_guide.php">�� �Ϲ�ȸ�� �̿�ȳ�</a> </td>
        </tr>
        <tr>
          <td height="14" class="evmem"><a href="/info/shop_guide.php">�� ��ȸ�� �̿�ȳ� </a></td>
        </tr>
        <tr>
          <td height="14" class="evmem"><a href="/info/faq.php">�� �ڵ�ž�� FAQ </a></td>
        </tr>
      </table>
      <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_policy?>" width="10" height="10" align="absmiddle"> <a href="/info/home_guide.php">�̿���</a></td>
        </tr>
      </table>
      <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_protect?>" width="10" height="10" align="absmiddle"> <a href="/info/home_protect.php">����������ȣ��å </a></td>
        </tr>
      </table>
	  <table width="100" height="4" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="170" border="0" cellpadding="0" cellspacing="1" bgcolor="DCDCDC">
        <tr>
          <td height="26" bgcolor="F6F6F6" style="padding-left:10"><img src="/img/<?=$left_icon_contact?>" width="10" height="10" align="absmiddle"> <a href="/info/home_join.php">���� �� ���� </a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><img src="/img/left_bg02.gif" width="200" height="16"></td>
  </tr>
</table>
