<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_extend.php
 * date   : 2008.11.26
 * desc   : �ڵ� ���� �˾�
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

pop_auth_chk();

$p_idx = trim($_POST['p_idx']);
$p_judgment = trim($_POST['p_judgment']);

$mainconn->open();
// �ڵ�/ĳ�� ���� ���Ѵ�.
$inc_sql = "select * from tblCashConfig ";
$inc_res = $mainconn->query($inc_sql);
$CASHCODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_cc_cid = trim($inc_row['cc_cid']);
	$inc_cc_cval = trim($inc_row['cc_cval']);
	$inc_etc_conf = trim($inc_row['etc_conf']);
	$inc_cash = trim($inc_row['cash']);

	//$CASHCODE[$inc_cc_cid] = $inc_cash;
	$CASHCODE[$inc_cc_cid] = array($inc_cc_cval, $inc_cash, $inc_etc_conf);
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>�ڵ�ž�� �ڵ���</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/common.js"></script>
<script language="javascript" src="/js/codi.js"></script>
<script language="javascript">
function sel_extend() {
	var f = document.frm;
	cash = parseInt('<?=$CASHCODE[CC55][1]?>') * parseInt(f.p_extend.options[f.p_extend.selectedIndex].value);
	document.getElementById("p_extend_area").innerHTML = cash;
}
function goExtendProc() {
	var f = document.frm;
	cash = parseInt('<?=$CASHCODE[CC55][1]?>') * parseInt(f.p_extend.options[f.p_extend.selectedIndex].value);
	if ( confirm(cash+"ĳ�ð� ���ҵ˴ϴ�.\n�Ⱓ������ �ұ��?") ) {
		if ( f.p_extend.options[f.p_extend.selectedIndex].value == "0" ) {
			alert("����Ⱓ�� �����ϼ���.");
			return;
		}
		f.action = "/mypage/pop_extend_ok.php";
		f.submit();
	}
}
</script>
</head>
<body>

<form id="frm" name="frm" method="post">
<input type="hidden" id="p_idx" name="p_idx" value="<?=$p_idx?>">
<input type="hidden" id="p_judgment" name="p_judgment" value="<?=$p_judgment?>">

<table width="300" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>�ڵ�ž�� �ڵ���</b></font></td>
	</tr>
	<tr>
		<td align="center" background="/img/pop_shop02.gif">
		<table width="90%" border="0" cellspacing="0" cellpadding="0">
			
			<tr>
				<td>
					����Ⱓ : 
					<select id="p_extend" name="p_extend" onChange="sel_extend();">
						<option value="0">:: �Ⱓ���� ::</option>
						<option value="1">1��</option>
						<option value="2">2��</option>
						<option value="3">3��</option>
						<option value="4">4��</option>
						<option value="5">5��</option>
					</select> &nbsp;&nbsp;
					<font color="FF0078">�ʿ�ĳ�� : <span id="p_extend_area">0</span></font>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">
				<a href="#" onClick="goExtendProc();"><img src="/img/btn_ok02.gif" width="70" height="20" border="0" /></a>
				<a href="javascript:self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="/img/pop_shop03.gif" ></td>
	</tr>
</table>

</form>

</body>
</html>