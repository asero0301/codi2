<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/pop/pop_id_check.php
 * date   : 2008.08.13
 * desc   : popup id checker
 *******************************************************/
require_once "/coditop/inc/common.inc.php";

$mem_id = trim($_REQUEST['mem_id']);
$chk = trim($_REQUEST['chk']);

$mainconn->open();

$sql = "select count(*) from tblMember where mem_id='$mem_id'";
$cnt = $mainconn->count($sql);

$mainconn->close();

if ( $chk == "" ) {
	$disp = "���̵� �Է��ϼ���";
} else {
	if ( $cnt == "0" ) {
		$disp = "<font color='blue'>$mem_id</font>��(��) ��� �����մϴ�.";
		$mem_value = $mem_id;
	} else {
		$disp = "<font color='red'>$mem_id</font>��(��) ����� �� �����ϴ�.";
		$mem_value = "";
	}
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>�ڵ�ž�� ���̵� üũ</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/common.js"></script>
<script language="javascript" src="/js/codi.js"></script>
<script language="javascript">
function idSearch() {
	var f = document.mem;
	if ( f.mem_id.value == "" ) {
		alert("���̵� �Է��ϼ���");
		f.mem_id.focus();
		return;
	}
	f.submit();
}

function openerinput() {
	opener.document.mem.mem_id.value = document.mem.mem_id.value;
	self.close();
}
</script>
</head>

<body>
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>���̵� �ߺ��˻�</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td><?=$disp?></td>
      </tr>
	  <tr>
        <td height="6" colspan="2"></td>
      </tr>
	  <form id="mem" name="mem" method="post">
	  <input type="hidden" id="chk" name="chk" value="Y">
      <tr>
        <td colspan="2"><input type="text" name="mem_id" id="mem_id" value="<?=$mem_value?>" class="logbox"  style="width:200"/>
          <a href="#"><img src="/img/btn_search02.gif" border="0" align="absmiddle" onClick="idSearch();" /></a></td>
      </tr>
	  </form>
	  
	   <tr>
	     <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="center">
			<? if ( $chk == "Y" && $cnt == "0" ) { ?>
			<a href="#"><img src="/img/btn_ok02.gif" width="70" height="20" border="0" onClick="openerinput();" /></a>
			<? } ?>
			<a href="#"><img src="/img/btn_close.gif" width="70" height="20" border="0" onClick="self.close();" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</table>
<script>document.mem.mem_id.focus();</script>

</body>
</html>