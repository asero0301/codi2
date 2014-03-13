<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_deli_check.php
 * date   : 2009.02.06
 * desc   : ���������� ��ǰ�� �߹޾Ҵ��� üũ�ϴ� �˾�
 *			�� �������� ���� �ڸ�Ʈ�ް� ����Ȯ���� Ŭ���ϸ� C,D -> E �� �ٲ��.(�Ϸ�)
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
$gt_idx = $_POST['gt_idx'];

if ( !$gt_idx ) {
	echo "<script>alert('�߸��� �����Դϴ�.'); self.close();</script>";
	exit;
}


// �ش� ��ǰ�� ������ ���Ѵ�.
$sql = "
select A.p_title, C.p_u_reg_dt, B.end_dt, A.p_gift, D.shop_name
from tblProduct A, tblProductEach B, tblProductUpDown C, tblShop D, tblGiftTracking E
where 1 
and A.p_idx = B.p_idx
and B.p_e_idx = C.p_e_idx
and A.shop_idx = D.shop_idx
and B.p_e_idx = E.p_e_idx
and E.gt_idx = $gt_idx
and C.mem_id = '$mem_id'
";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$p_title = strip_str(trim($row['p_title']));
$p_gift = strip_str(trim($row['p_gift']));
$shop_name = trim($row['shop_name']);
$p_u_reg_dt = trim($row['p_u_reg_dt']);
$end_dt = trim($row['end_dt']);



$mainconn->close();
?>

<SCRIPT LANGUAGE="JavaScript" SRC="/js/ajax.js"></SCRIPT>
<script language="javascript">
function go_deli_submit() {
	var f = document.deli_frm;
	f.target = "_self";
	f.action = "/mypage/pop_deli_ok.php";
	f.submit();
}
</script>

<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form id="deli_frm" name="deli_frm" method="post">
<input type="hidden" id="gt_idx" name="gt_idx" value="<?=$gt_idx?>" />

  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>��ǰ���� Ȯ��</b></font></td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
      <tr>
        <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_oh.gif" width="27" height="16"  align="absmiddle" /> <font color="#333333">�̻���� ��ǰ�� �����̳���? <font color="FF5B5C"><u>�׷��ٸ� ����Ȯ���� ���ּ���.</u></font>
		<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
		
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ǰ�� ������ ��ȸ������ ������ �Ѹ���� ū ����� �˴ϴ�. </font></td>
      </tr>
    </table>
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="14" valign="top"><img src="/img/icon_list.gif" align="absmiddle" /></td>
        <td><font color="DD2457"><?=$p_title?></font></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:12 12 12 12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��&nbsp;&nbsp;��&nbsp;&nbsp;�� </td>
                      <td><b><font color="#333333"><?=$shop_name?></font></b></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle" style="LETTER-SPACING: 1px" ><img src="/img/pop_icon.gif"  align="absmiddle" /> ��&nbsp;&nbsp;��&nbsp;&nbsp;�� </td>
                      <td><?=$p_u_reg_dt?> </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �򰡸����� </td>
                      <td><?=$end_dt?> </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� ÷ �� ǰ </td>
                      <td><?=$p_gift?> </td>
                    </tr>
                  </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="1" background="/img/dot00.gif"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ����Ȯ�� �Ѹ��� <span class="evgray">(��ǰ�� �߼��� ��ȸ������ �Ѹ��� ���ּ���.)</span></td>
                        <td align="right" class="evgray" style="LETTER-SPACING: 1px"><font color="FF0078"><span id='textlimit'>0</span>/500</font></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="2" ><textarea id="gt_comment" name="gt_comment" class="memobox" onKeyUp="updateChar(500,this.form.gt_comment,'textlimit');" onFocus="check_msg(this.form.gt_comment);" onBlur="check_msg(this.form.gt_comment);" style="width:100%; height:80;"></textarea></td>
                      </tr>
                    </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td width="32">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><a href="#" onClick="go_deli_submit();"><img src="/img/btn_deli_ok.gif" width="70" height="20" border="0" /></a>&nbsp;<a href="#" onClick="self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a></td>
        </tr>
      </table></td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>
</form>
</table>
