<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/shop_cash_config.php
 * date   : 2008.08.11
 * desc   : Admin shop member cash config
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();


$mainconn->open();

$cond = " where 1 ";
$orderby = " order by cc_cid ";

$sql = "select * from tblCashConfig $cond $orderby";
$res = $mainconn->query($sql);

$LIST = "";

while ( $row = $mainconn->fetch($res) ) {
	
	$t_cc_cid = $row['cc_cid'];
	$t_cc_cval = $row['cc_cval'];
	$t_cash = $row['cash'];
	$t_etc_conf = $row['etc_conf'];

	if ( substr($t_cc_cid,0,3) != "CC0" ) continue;

	$LIST .= "
		<tr>
		  
		  <td align='left' bgcolor='#FFFFFF'class='stext'><font color='ff6600'>$t_cc_cval</font></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'><input type='text' id='cash_$t_cc_cid' name='cash_$t_cc_cid' value='$t_cash'></td>
		  <td align='center' bgcolor='#FFFFFF' class='stext'><input type='button' value='�����ϱ�' onClick=\"editEachCash('$t_cc_cid');\"></td>
		  
		</tr>
		<tr>
		  <td height='1' colspan='3' ></td>
		</tr>
		";
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='3' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
}

$mainconn->freeResult($res);
$mainconn->close();

require_once "../_top.php";
?> 

<script language="javascript">
function editEachCash(cc_cid) {
	var f = document.frm;
	f.idx.value = cc_cid;
	f.mode.value = "E";
	f.action = "shop_cash_config_ok.php";
	f.submit();
}

function editAll() {
	if ( !confirm("������ ���� �ϰ����� �Ͻðڽ��ϱ�?") ) {
		return;
	}
	var f = document.frm;

	f.mode.value = "E";
	f.action = "shop_cash_config_ok.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">
<input type="hidden" id="idx" name="idx">
<input type="hidden" id="kind" name="kind">
<input type="hidden" id="mode" name="mode">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">�� ���ʽ�ĳ�� ����</font></b> ��ȸ���� Ȱ���� ���� ���ʽ� ĳ���� �����մϴ�. </td>
  </tr>
</table>

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="220" align="center" class="stextbold"><font color="#000000"><b>�׸�</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>����ĳ��</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
                  
                    </tr>
                    <tr>
                      <td height="1" colspan="3" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
    
<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td align="center" height="23"><input type="button" value="��ü����" onClick="editAll();"></td>
  </tr>
</table>

</form>


<?php 
require_once "../_bottom.php";

?> 