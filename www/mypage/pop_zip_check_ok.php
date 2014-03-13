<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/pop_zip_check_ok.php
 * date   : 2008.10.06
 * desc   : popup zip check
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$addr = trim($_POST['addr']);
$mem_kind = trim($_POST['mem_kind']);
$ob = trim($_POST['ob']);

if ( !$ob ) $ob = "0";

$mainconn->open();
$sql ="SELECT seq,zipcode,sido,gugun,dong,bunji FROM  tblZipcode where dong like '%$addr%' ORDER BY seq ASC ";
$res = $mainconn->query($sql);

$str = "<select id='post_no' name='post_no' class='logbox'  style='width:280'><option value=''>-->�ش� ������ �������ּ���</option>";
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$seq = trim($row['seq']);
	$zipcode = trim($row['zipcode']);
	$sido = trim($row['sido']);
	$gugun = trim($row['gugun']);
	$dong = trim($row['dong']);
	$bunji = trim($row['bunji']);

	$str .= "<option value='$zipcode'>$sido $gugun $dong $bunji</option>";

	$cnt++;
}
$str .= "</select>";
$mainconn->close();

?>
<script language="javascript">
function goZip() {
	var f = document.frm;
	if ( f.addr.value == "" || f.addr.value == null ) {
		alert("��/��/��, ���, �б� ���� �̸��� �Է��ϼ���.");
		f.addr.focus();
		return;
	}
	f.submit();
}

function update_address(f,i) {
	flag = '<?=$mem_kind?>';
	if (document.frm.post_no.value == "") {
		alert("������ ������ �ּ���.");
		document.frm.post_no.focus();
		return;
	}
	
	if ( flag == "S" ) {
		zip_obj = eval("opener.document.mem.shop_zipcode_"+<?=$ob?>);
		addr1_obj = eval("opener.document.mem.shop_addr1_"+<?=$ob?>);
		addr2_obj = eval("opener.document.mem.shop_addr2_"+<?=$ob?>);
		zip_obj.value = frm.post_no[i].value.substring(0,7);;
		addr1_obj.value = frm.post_no[i].text;
		addr2_obj.value = frm.addr2.value;
		/*
		opener.document.mem.shop_zipcode.value = frm.post_no[i].value.substring(0,7);
		opener.document.mem.shop_addr1.value = frm.post_no[i].text;
		opener.document.mem.shop_addr2.value = frm.addr2.value;
		*/
	} else {
		opener.document.mem.zipcode.value = frm.post_no[i].value.substring(0,7);
		opener.document.mem.mem_addr1.value = frm.post_no[i].text;
		opener.document.mem.mem_addr2.value = frm.addr2.value;
	}

	self.close();
}
</script>

<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="300" border="0" cellspacing="0" cellpadding="0">
<form id="frm" name="frm" method="post" action="pop_zip_check_ok.php">
<input type="hidden" id="mem_kind" name="mem_kind" value="<?=$mem_kind?>" />

  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>�����ȣ �˻�</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif">

	<table width="90%" border="0" cellspacing="0" cellpadding="0">

<? if ( $cnt > 0 ) { ?>
		<tr> 
			<td>
				<B><?=$addr?></B>(��)�� �˻��� �����Դϴ�. <BR>
				<? 
				if ( $cnt > 0 ) {
					echo $str;
				} 
				?>
			</td>
		</tr>
		<tr> 
			<td height=5>&nbsp;</td>
		</tr>
		<tr> 
			<td height="26" >
				* ������ �ּҸ� �Է��ϼ���. <BR>
				<input type="text" id="addr2" name="addr2" value="" class="logbox"  style="width:280" />
			</td>
		</tr> 
	  <tr>
        <td height="6"></td>
      </tr>
      <tr>
        <td colspan="2">			
			<a href="javascript:update_address(document.frm,document.frm.post_no.selectedIndex);"><img src="/img/btn_ok2_0311.gif" border="0" align="absmiddle" alt="�����ϱ�" /></a>
			<a href="javascript:history.back();"><img src="/img/btn_search.gif" border="0" align="absmiddle" alt="�ٽð˻�" /></a>
			<a href="javascript:self.close();"><img src="/img/btn_close.gif" border="0" align="absmiddle" alt="â�ݱ�" /></a>
		</td>
      </tr>

<? } else { ?>
	<tr>
		<td colspan="2">
			<b><?=$addr?></b>(��)�� �˻��� ������ �����ϴ�.<br>
		</td>
	</tr>

	<tr>
        <td height="10" colspan="2">&nbsp;</td>
      </tr>

	<tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>��/��/��, ���, �б� ���� �̸��� �Է��ϼ���.</td>
      </tr>
	  <tr>
        <td height="6" colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" id="addr" name="addr" value="" class="logbox"  style="width:170" />
          <a href="#" onClick="goZip();"><img src="/img/btn_search.gif" border="0" align="absmiddle" /></a>
		</td>
      </tr>
	<tr>
        <td height="5" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">			
			
			<a href="javascript:history.back();"><img src="/img/btn_search.gif" border="0" align="absmiddle" alt="�ٽð˻�" /></a>
			<a href="javascript:self.close();"><img src="/img/btn_close.gif" border="0" align="absmiddle" alt="â�ݱ�" /></a>
		</td>
      </tr>

<? } ?>
	
    </table>

	</td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</form>
</table>
