<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/pop/pop_post.php
 * date   : 2008.08.13
 * desc   : popup post
 *******************************************************/
require_once "/coditop/inc/common.inc.php";

$dong = trim($_REQUEST['dong']);
$kind = trim($_REQUEST['kind']);

if ( $dong ) {
	$mainconn->open();

	$sql = "select * from tblZipcode where dong like '%$dong%'";
	$res = $mainconn->query($sql);

	$STR = "";
	while ( $row = $mainconn->fetch($res) ) {
		$seq		= trim($row['seq']);
		$zipcode	= trim($row['zipcode']);
		$sido		= trim($row['sido']);
		$gugun		= trim($row['gugun']);
		$dong		= trim($row['dong']);
		$bunji		= trim($row['bunji']);

		$STR .= "<option value='$zipcode'>$sido $gugun $dong $bunji</option>";
	}

	$mainconn->close();
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>코디탑텐 우편번호 입력</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/common.js"></script>
<script language="javascript" src="/js/codi.js"></script>
<script language="javascript">
function openerinputaddr(kind) {
	var f = document.frm;
	var of = opener.document.frm;

	if ( kind == "M" ) {
		of.zipcode.value = f.zipcode.options[f.zipcode.selectedIndex].value;
		of.mem_addr1.value = f.zipcode.options[f.zipcode.selectedIndex].text;
	} else {
		of.shop_zipcode.value = f.zipcode.options[f.zipcode.selectedIndex].value;
		of.shop_addr1.value = f.zipcode.options[f.zipcode.selectedIndex].text;
	}
	self.close();
}
</script>
</head>
<body>

<form id="frm" name="frm" method="post">
<input type="hidden" id="kind" name="kind" value="<?=$kind?>">

<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>우편번호 검색</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>해당 동이름(예:백석동)을 입력해 주세요</td>
      </tr>
	  <tr>
        <td height="6" colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" id="dong" name="dong" value="" class="logbox"  style="width:200"/>
          <a href="#"><img src="/img/btn_search02.gif" border="0" align="absmiddle" /></a></td>
      </tr>
	   <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	   <tr>
	     <td height="1" colspan="2" background="/img/dot00.gif"></td>
        </tr>
	   <tr>
	     <td colspan="2" style="padding:5 5 5 5" height=189>
			<!--<textarea name="textarea" class="memobox"  style="width:100%; height:170; ">해당하는 지역우편번호 목록입니다</textarea>-->
			<select id="zipcode" name="zipcode" size="12">
			<?=$STR?>
			</select>
		 </td>
       </tr>
	   <tr>
	     <td height="1" colspan="2" background="/img/dot00.gif"></td>
        </tr>
	   <tr>
	     <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="center">
			<? if ( $STR ) { ?>
			<a href="#"><img src="/img/btn_ok02.gif" width="70" height="20" border="0" onClick="openerinputaddr('<?=$kind?>');" /></a>
			<? } ?>
			<a href="javascript:self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</table>
</form>
<script>document.frm.dong.focus();</script>

</body>
</html>