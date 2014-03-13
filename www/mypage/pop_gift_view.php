<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_gift_view.php
 * date   : 2009.02.04
 * desc   : ���������� ��ǰ������ �˾�
 *			�� �������� ���� gt_status ���� B(�߼۴��)�� �ٲ��.
 *
 * ============ �߿� : gt_status ���� ��ȭ���� ==========
 *
 * A (Ȯ��)		: ó�� ��ǰ�� ��÷�Ǿ������� ��
 * B (�߼۴��) : ��ȸ���� Ȯ�ι����� ������ �˾��� �����
 * C (�߼ۿϷ�) : ��ȸ���� ������ �߼��ϰ� ������.
 * D (����Ȯ����) : �ѻ���̶� �޾�����(���� �� ������ ���� ����) - gt_ok == "Y"
 * E (�Ϸ�)		: ��� ������, �Ǵ� �߼ۿϷ���� 7���� ������
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// �������� üũ
pop_auth_chk();

// ���۷� üũ
pop_referer_chk();

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$p_e_idx = $_POST['p_e_idx'];

/*
echo "mem_id : $mem_id <br>";
echo "p_e_idx : $p_e_idx <br>";
exit;
*/

if ( !$p_e_idx ) {
	echo "<script>alert('�߸��� �����Դϴ�.'); self.close();</script>";
	exit;
}


// �ش� ��ǰ�� ������ ���Ѵ�.
$sql = "select A.p_title, A.p_gift_cnt, A.p_gift, C.shop_name, B.end_dt from tblProduct A, tblProductEach B, tblShop C where A.p_idx = B.p_idx and A.shop_idx = C.shop_idx and B.p_e_idx = $p_e_idx ";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);
$p_title = strip_str(trim($row['p_title']));
$p_gift_cnt = trim($row['p_gift_cnt']);
$p_gift = strip_str(trim($row['p_gift']));
$shop_name = trim($row['shop_name']);
$end_dt = trim($row['end_dt']);


// ��÷�� ������ ���Ѵ�.
$sql = "select A.user_mem_id, A.gt_status, C.mem_name, C.zipcode, C.mem_addr1, C.mem_addr2, C.mem_mobile from tblGiftTracking A, tblProductEach B, tblMember C where A.p_e_idx = B.p_e_idx and A.user_mem_id = C.mem_id and A.p_e_idx = $p_e_idx ";
$res = $mainconn->query($sql);
$msg_id_list = "";
while ( $row = $mainconn->fetch($res) ) {
	$user_mem_id	= trim($row['user_mem_id']);
	$gt_status	= trim($row['gt_status']);
	$mem_name	= trim($row['mem_name']);
	$zipcode	= trim($row['zipcode']);
	$mem_addr1	= strip_str(trim($row['mem_addr1']));
	$mem_addr2	= strip_str(trim($row['mem_addr2']));
	$mem_mobile	= trim($row['mem_mobile']);

	$msg_id_list .= $user_mem_id.";";
	
	$TXT .= "
        <tr>
          <td width='152' height='40' align='center' bgcolor='F9F9F9'><a href='#' onClick=\"\">$user_mem_id($mem_name)</a></td>
          <td bgcolor='F9F9F9'>[$zipcode] $mem_addr1 $mem_addr2 </td>
          <td width='130' align='center' bgcolor='F9F9F9'>$mem_mobile</td>
        </tr>
        <tr>
          <td height='1' colspan='3' bgcolor='#E0E0E0'></td>
        </tr>
	";

}

// gt_status ���� "A" �̸� B�� �ٲ۴�.
if ( $gt_status == "A" ) {
	$sql = "update tblGiftTracking set gt_status = 'B',status_reg_dt = now() where p_e_idx = $p_e_idx ";
	$mainconn->query($sql);

	// ���޴��� �ٽ� �����.
	make_quick_html($mem_id, $_SESSION['mem_kind']);

	$btn = "<a href='#' onClick='chg_tracking(&#039;$p_e_idx&#039;,&#039;C&#039;);'><img src='/img/btn_deli_ok02.gif' border='0' /></a>";
	echo "<script>opener.document.getElementById('btn_chg_area_{$p_e_idx}').innerHTML = \"$btn\";</script>";
}

$mainconn->close();
?>

<link href="/css/style.css" rel="stylesheet" type="text/css">

<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100">&nbsp;</td>
        <td align="center" class="intitle"><font color="#FFFFFF"><b>��÷ȸ�� ������</b></font></td>
        <td width="100" align="right"><span class="intitle" style="padding-bottom:10"><a href="javascript:self.close()"><img src="/img/btn_close02.gif" border="0"  align="absmiddle"/></a></span></td>
      </tr>
    </table>      
    </td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td height="300" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
      <tr>
        <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">��ǰ�� ��÷�� ȸ���� �������Դϴ�. �Ʒ� ������ ��ǰ�� �߼��Ͻø� �˴ϴ�.

<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
            </table>

         <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> ����ó�� ���� ���� �� ������ ��ǰ�߼ۻ�Ȳ�� �˷��ֽô� �͵� ����������!! </font></td>
      </tr>
    </table>
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="18" valign="top"><img src="/img/icon_list.gif"  align="absmiddle" /></td>
        <td><font color="DD2457"><b>[<?=$shop_name?>]</b> <?=$p_title?> </font></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
        <tr>
          <td style="padding:15 15 15 15" class="intext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="22"><img src="/img/icon_aa.gif"  align="absmiddle"> <font color="#333333">�򰡸����� :</font> <?=$end_dt?> </td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle"> <font color="#333333">��÷�� �� :</font> <?=$p_gift_cnt?>�� </td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">��÷��ǰ :</font> <?=$p_gift?> </td>
            </tr>
          </table>
          </td>
        </tr>
      </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="2" colspan="3" bgcolor="E0295A"></td>
        </tr>
        <tr>
          <td width="152" height="26" align="center" class="intitle">��÷��</td>
          <td align="center" class="intitle">�ּ�</td>
          <td width="130" align="center" class="intitle">����ó</td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="E0295A"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <?=$TXT?>

      </table>
	  <!--
      <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><a href="#"><img src="/img/btn_first_go2.gif" width="20" height="16" border="0" align="absmiddle" /></a><a href="#"><img src="/img/btn_prev6.gif" width="44" height="16" border="0" align="absmiddle" /></a>&nbsp;<a href="#"> 1</a> | <a href="#"><b><font color="#333333">2</font></b></a> | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>&nbsp; <a href="#"><img src="/img/btn_next6.gif" width="44" height="16" border="0" align="absbottom" /></a><a href="#"><img src="/img/btn_end_go2.gif" width="20" height="16" border="0" align="absmiddle" /></a></td>
        </tr>
      </table>
	  -->
	  <table width="100%" border="0"><tr><td height="5">&nbsp;</td></tr></table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
        <tr>
          <td width="150" align="center"><a href="#" onClick="opener.pop_msg('<?=$msg_id_list?>');"><img src="/img/btn_send_memo.gif" width="150" height="20" border="0" /></a></td>
          <td align="right"><a href="#" onClick="self.close();"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a></td>
        </tr>
      </table>
    </td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>
</table>
