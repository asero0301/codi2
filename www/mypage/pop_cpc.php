<?
require_once "../inc/common.inc.php";

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

$mainconn->close();
?>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>CPC �����̶�?</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>CPC(Cost Per Click)�� Ŭ���� ������ ���մϴ�. �ڵ�ž���� CPC�� �ڵ�ž�� �湮����(�Ϲ�ȸ��+�մ�)�� ��ȸ���� ����� �ڵ𱸸�URL�� <b><font color="#DF2859"><?=$CASHCODE['CC53'][2]?>ȸ �̻� Ŭ���ϰ� �Ǹ�, �׶����� 1Ŭ���� <?=$CASHCODE['CC53'][1]?>ĳ���� ���</font></b>�� ���ݵ˴ϴ�.</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>ĳ���� ������ ���� <?=number_format($CASHCODE['CC54'][2]);?>ĳ������ �ܻ��� ����������, �ܻ��� ���� ��� �ڵ��ǰ�� �߰������ �� �� �����ϴ�.</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center"><a href="javascript:self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0"></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="/img/pop_shop03.gif" ></td>
  </tr>
</table>
