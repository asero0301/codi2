<?
require_once "../inc/common.inc.php";

$mainconn->open();

// 코드/캐시 값을 구한다.
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
    <td height="53" align="center" background="/img/pop_title.gif" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>CPC 형식이란?</b></font></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_shop02.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>CPC(Cost Per Click)는 클릭당 과금을 말합니다. 코디탑텐의 CPC는 코디탑텐 방문객이(일반회원+손님)이 샵회원이 등록한 코디구매URL을 <b><font color="#DF2859"><?=$CASHCODE['CC53'][2]?>회 이상 클릭하게 되면, 그때부터 1클릭당 <?=$CASHCODE['CC53'][1]?>캐쉬의 비용</font></b>이 과금됩니다.</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td width="10" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle"></td>
        <td>캐쉬가 부족할 경우는 <?=number_format($CASHCODE['CC54'][2]);?>캐쉬까지 외상이 가능하지만, 외상이 있을 경우 코디상품의 추가등록은 할 수 없습니다.</td>
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
