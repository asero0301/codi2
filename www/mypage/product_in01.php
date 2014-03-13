<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in01.php
 * date   : 2008.10.10
 * desc   : ���������� �ڵ��ǰ ��� 1�ܰ�
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mode		= trim($_POST['mode']);
$tbl		= trim($_POST['tbl']);
$p_idx		= trim($_POST['p_idx']);
$mem_id		= $_SESSION['mem_id'];
$mem_name	= $_SESSION['mem_name'];
$mem_date	= date("Ymd", time());

if ( $mode == "E" ) {
	$tbl_name = ( $tbl == "R" ) ? "tblProduct" : "tblProductTmp";
	$sql = "select * from $tbl_name where p_idx = $p_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$e_shop_idx = trim($row['shop_idx']);
	$e_p_categ = trim($row['p_categ']);
	$e_p_style_kwd = trim($row['p_style_kwd']);
	$e_p_item_kwd = trim($row['p_item_kwd']);
	$e_p_theme_kwd = trim($row['p_theme_kwd']);
	$e_p_etc_kwd = trim($row['p_etc_kwd']);
	$e_p_gift = trim($row['p_gift']);
	$e_p_gift_cond = trim($row['p_gift_cond']);
	$e_p_gift_cnt = trim($row['p_gift_cnt']);
	$e_p_pay_cash = trim($row['p_pay_cash']);

	$e_style_kwd_arr = explode(",", $e_p_style_kwd);
	$p_style_kwd = $e_style_kwd_arr[0];
	$p_style_kwd2 = $e_style_kwd_arr[1];

	$e_item_kwd_arr = explode(",", $e_p_item_kwd);
	$p_item_kwd = $e_item_kwd_arr[0];
	$p_item_kwd2 = $e_item_kwd_arr[1];

	$e_theme_kwd_arr = explode(",", $e_p_theme_kwd);
	$p_theme_kwd = $e_theme_kwd_arr[0];
	$p_theme_kwd2 = $e_theme_kwd_arr[1];
}

$p_key = md5($mem_id.$mem_name.$mem_date);

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

$p_current_cash = $e_p_pay_cash;
if ( !$p_current_cash ) $p_current_cash = $CASHCODE['CC59'][1];

// ���� ���Ѵ�.
$sql = "select shop_idx,shop_name from tblShop where mem_id = '$mem_id' and shop_status = 'Y' order by shop_kind, shop_idx desc ";
$res = $mainconn->query($sql);
//echo $sql;

$shop_options = "";
while ( $row = $mainconn->fetch($res) ) {
	$t_shop_idx = trim($row['shop_idx']);
	$t_shop_name = trim($row['shop_name']);
	$selected = ( $t_shop_idx == $e_shop_idx ) ? " selected" : "";	
	$shop_options .= "<option value='$t_shop_idx' $selected>$t_shop_name</option>";
}

// Ű���带 ���Ѵ�.
$sql2 = "select kwd_idx,kwd_categ,kwd_kind,kwd from tblKwd where kwd_status != 'N' ";
$res2 = $mainconn->query($sql2);

//$style_kwd = $item_kwd = $theme_kwd = "";
$kwd_str = "";
while ( $row2 = $mainconn->fetch($res2) ) {
	$t_kwd_idx = trim($row2['kwd_idx']);
	$t_kwd_categ = trim($row2['kwd_categ']);
	$t_kwd_kind = trim($row2['kwd_kind']);
	$t_kwd = trim(strip_tags($row2['kwd']));
	
	$kwd_str .= $t_kwd_categ.":".$t_kwd_kind.":".$t_kwd_idx.":".$t_kwd."@#";
}




$mainconn->close();

?>

<? include "../include/_head.php"; ?>

<script language="javascript">
var g_p_style_kwd2 = g_p_item_kwd2 = g_p_theme_kwd2 = 0;

<?
if ( $p_style_kwd2 ) echo "g_p_style_kwd2 = 1;";
if ( $p_item_kwd2 ) echo "g_p_item_kwd2 = 1;";
if ( $p_theme_kwd2 ) echo "g_p_theme_kwd2 = 1;";
?>

var g_p_kwd2 = g_p_style_kwd2 + g_p_item_kwd2 + g_p_theme_kwd2;

function chkCashKwd(kind) {
	var f = document.frm;
	
	if ( kind == "S" ) {
		obj = f.p_style_kwd2;
		if ( obj.options[obj.selectedIndex].value != "0" ) {
			if ( g_p_style_kwd2 == 0 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",1);
			}
			g_p_style_kwd2 = 1;
		} else {
			if ( g_p_style_kwd2 == 1 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",0);
			}
			g_p_style_kwd2 = 0;
		}
	} else if ( kind == "I" ) {
		obj = f.p_item_kwd2;
		if ( obj.options[obj.selectedIndex].value != "0" ) {
			if ( g_p_item_kwd2 == 0 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",1);
			}
			g_p_item_kwd2 = 1;
		} else {
			if ( g_p_item_kwd2 == 1 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",0);
			}
			g_p_item_kwd2 = 0;
		}
	} else {
		obj = f.p_theme_kwd2;
		if ( obj.options[obj.selectedIndex].value != "0" ) {
			if ( g_p_theme_kwd2 == 0 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",1);
			}
			g_p_theme_kwd2 = 1;
		} else {
			if ( g_p_theme_kwd2 == 1 ) {
				cash_change("<?=$CASHCODE[CC57][1]?>",0);
			}
			g_p_theme_kwd2 = 0;
		}
	}
}

function goStep2() {
	var f = document.frm;
	if ( f.p_agree[0].checked == false ) {
		alert("�� ���׿� �����ϼž� �����ܰ�� �Ѿ�ϴ�.");
		return;
	}

	if ( f.p_categ.options[f.p_categ.selectedIndex].value == "0" ) {
		alert("ī�װ��� �����ϼ���");
		f.p_categ.focus();
		return;
	}

	if ( (f.p_gift_kind[0].checked == false) && (f.p_gift_kind[1].checked == false) ) {
		alert("���ް�ǰ�� ������ �ּ���.");
		f.p_gift_kind[0].focus();
		return;
	}

	if ( (f.p_gift_cond[0].checked == false) && (f.p_gift_cond[1].checked == false) ) {
		alert("��ǰ���� ������ ������ �ּ���.");
		f.p_gift_cond[0].focus();
		return;
	}

	if ( (f.p_gift_kind[1].checked == true) && (f.p_gift.value == "") ) {
		alert("������ǰ ���޽� ��ǰ������ �Է��ؾ� �մϴ�.");
		f.p_gift.focus();
		return;
	}

	f.target = "_self";
	f.action = "/mypage/product_in02.php";
	f.submit();
}

function chgCateg() {
	var f = document.frm;
	if ( f.p_categ.options[f.p_categ.selectedIndex].value == "0" ) return;
	
	// init
	delItem(document.frm.p_style_kwd);
	delItem(document.frm.p_item_kwd);
	delItem(document.frm.p_theme_kwd);
	delItem(document.frm.p_style_kwd2);
	delItem(document.frm.p_item_kwd2);
	delItem(document.frm.p_theme_kwd2);

	var kwd_arr = new Array();
	kwd_arr = "<?=$kwd_str?>".split("@#");
	for ( var i=0; i<kwd_arr.length; i++ ) {
		var tmp_arr = new Array();
		tmp_arr = kwd_arr[i].split(":");
		if ( tmp_arr[1] == "S" ) {
			if ( f.p_categ.options[f.p_categ.selectedIndex].value == tmp_arr[0] ) {
				obj = document.frm.p_style_kwd;
				obj2 = document.frm.p_style_kwd2;
				addItem(obj, tmp_arr[3], tmp_arr[3]);
				addItem(obj2, tmp_arr[3], tmp_arr[3]);
			}
		} else if ( tmp_arr[1] == "I" ) {
			if ( f.p_categ.options[f.p_categ.selectedIndex].value == tmp_arr[0] ) {
				obj = document.frm.p_item_kwd;
				obj2 = document.frm.p_item_kwd2;
				addItem(obj, tmp_arr[3], tmp_arr[3]);
				addItem(obj2, tmp_arr[3], tmp_arr[3]);
			}
		} else if ( tmp_arr[1] == "T" ) {
			if ( f.p_categ.options[f.p_categ.selectedIndex].value == tmp_arr[0] ) {
				obj = document.frm.p_theme_kwd;
				obj2 = document.frm.p_theme_kwd2;
				addItem(obj, tmp_arr[3], tmp_arr[3]);
				addItem(obj2, tmp_arr[3], tmp_arr[3]);
			}
		}
	}
}
</script>

<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="<?=$mode?>" />
<input type="hidden" id="tbl" name="tbl" value="<?=$tbl?>" />
<input type="hidden" id="p_idx" name="p_idx" value="<?=$p_idx?>" />
<input type="hidden" id="p_key" name="p_key" value="<?=$p_key?>" />
<input type="hidden" id="p_current_cash" name="p_current_cash" value="<?=$p_current_cash?>" />

<table width="860" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="332" background="/img/pro_in04.gif" style="padding-top:3" >&nbsp;&nbsp;&nbsp;<b><font color="FFF600">�ڵ���</font></b> <font color="#FFFFFF">: �ڵ� ����Ͽ� �򰡸� ��û�մϴ�.</font></td>
    <td ><img src="/img/pro_in01.gif" /></td>
  </tr>
</table>

  <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><font color="#333333"><b><img src="/img/in_title01.gif"  align="absmiddle"/></b></font> ����� �ڵ��� �⺻������ ����մϴ�. </td>
      <td align="right" class="evfont"><img src="/img/icon_aa.gif"  align="absmiddle">��Ͽ� �ʿ��� ĳ�� <img src="/img/icon_cash.gif"  align="absmiddle"/><b><font color="FF0078"><span id="p_current_cash_area"><?=$p_current_cash?></span> / <?=$_SESSION['mem_cash']?></font></b></td>
    </tr>
    <tr>
      <td height="4" colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2">
	  <table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="8D2D45">
        <tr>
          <td bgcolor="580C1F" style="padding:1 1 1 1">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td style="padding:15 15 15 15">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle"> ��&nbsp;&nbsp;��&nbsp;&nbsp;��</td>
                  <td>
                      <select name="shop_idx" id="shop_idx" class="logbox"  style="width:150">
						<?=$shop_options?>
                      </select>
                      <img src="/img/btn_shop03.gif" width="44" height="19" border="0" align="absmiddle" onClick="location.href='Mshop.php';" style="cursor:hand;" /><span class="infont">������� �ڵ��� ���� �����մϴ�. </span></td>
                  </tr>
                <tr>
                  <td height="24" class="intitle"  style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle"> ī�װ�</td>
                  <td>
				  <select name="p_categ" id="p_categ" class="logbox"  style="width:150" onchange="chgCateg();">
					<option value="0">::: ī�װ� ���� :::</option>
					<?
					foreach ( $P_CATEG as $k => $v ) {
						$selected2 = ( $k == $e_p_categ ) ? " selected" : "";
						echo "<option value='$k' $selected2>$v</option>";
					}
					?>
                  </select>
				  <span class="infont">������� �ڵ��� �з��� �����մϴ� .�ڵ��򰡼����� ����� �˴ϴ�. </span>
				  </td>
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
                    <td width="100" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �⺻ Ű����</td>
                    <td width="311"><img src="/img/icon00.gif" align=absmiddle> ��Ÿ�� Ű����
                      <select name="p_style_kwd" id="p_style_kwd" class="logbox"  style="width:150">
                        <option value="0">�������ּ���</option>
                        </select></td>
                    <td width="100" rowspan="2" valign="top" style="padding-top:5"><span class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �߰� Ű����</span><br />
                      <span class="evfont">&nbsp;&nbsp;&nbsp;<font color="FF5B5C">(1���� +100ĳ��)</font></span></td>
                    <td width="311"><img src="/img/icon00.gif" align=absmiddle> ��Ÿ�� Ű����
                      <select name="p_style_kwd2" id="p_style_kwd2" class="logbox" onChange="chkCashKwd('S');" style="width:150">
                        <option value="0">�������ּ���</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> ������ Ű����
                      <select name="p_item_kwd" id="p_item_kwd" class="logbox"  style="width:150">
                        <option value="0">�������ּ���</option>
                      </select></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> ������ Ű����
                      <select name="p_item_kwd2" id="p_item_kwd2" class="logbox" onChange="chkCashKwd('I');" style="width:150">
                        <option value="0">�������ּ���</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> �׸��� Ű����
                      <select name="p_theme_kwd" id="p_theme_kwd" class="logbox"  style="width:150">
                        <option value="0">�������ּ���</option>
                      </select></td>
                    <td>&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> �׸��� Ű����
                      <select name="p_theme_kwd2" id="p_theme_kwd2" class="logbox" onChange="chkCashKwd('T');" style="width:150">
                        <option value="0">�������ּ���</option>
                      </select></td>
                  </tr>
				  <tr>
                    <td height="6" colspan="4" ></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��Ÿ Ű����</td>
                    <td colspan="3">
                        <input type="text" name="p_etc_kwd" id="p_etc_kwd" class="logbox" value="<?=$e_p_etc_kwd?>" style="width:646" /></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" class="infont">�� �� �����Ǵ� Ű���尡 �ƴ� ���� ����ϰ� ���� Ű���带 �Է����ּ���. �� Ű���� �ܾ�� ��ǥ(,)�� ���е˴ϴ�. </td>
                  </tr>
                  <tr>
                    <td class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" class="infont">�� ���� ������ Ű���� ������ �߰� �ݿ��� �� �ֵ��� �ϰڽ��ϴ�.</td>
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
                    <td width="100" rowspan="2" class="intitle" valign="top" style="padding-top:5"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� ǰ
					<br />
                      <span class="evfont"><font color="FF5B5C">(��� �� �����Ұ�)</font></span>					</td>
                    <td width="311" height="24">
                        <input name="p_gift_kind" id="p_gift_kind" type="radio" value="Y" <?if ($e_p_gift==$DEFAULT_GIFT_STR) echo " checked";?> />
                     
                      ����� �ڵ��ǰ ��ü </td>
                    </tr>
                  <tr>
                    <td height="24"><input name="p_gift_kind" id="p_gift_kind" type="radio" value="N" <?if ($e_p_gift!=$DEFAULT_GIFT_STR && $e_p_gift != "") echo " checked";?> />
                      ���� ��ǰ 
                      <input type="text" name="p_gift" id="p_gift" class="logbox"  style="width:562" value="<?=$e_p_gift?>" /></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td  class="infont">�� ��ǰ�������ǿ� ���� ��÷�ڿ��� ������ ��ǰ�� ���� �Ǵ� �Է����ּ���. </td>
                    </tr>
                  <tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                  <tr>
                    <td rowspan="2" valign="top" class="intitle"  style="padding-top:3"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��ǰ��������
						<br />
                      <span class="evfont"><font color="FF5B5C">(��� �� �����Ұ�)</font></span>					</td>
                    <td height="24"><input name="p_gift_cond" id="p_gift_cond" type="radio" value="T" <?if ($e_p_gift_cond == "T") echo " checked";?> />
                      �򰡱Ⱓ�� �����ǰ� ��� ī�װ����� <b><font color="FF0078">�ְ� TOP10�� ����</font></b>�Ǿ��� ��� </td>
                  </tr>
				  <tr>
                    <td height="20"><input name="p_gift_cond" id="p_gift_cond" type="radio" value="A" <?if ($e_p_gift_cond == "A") echo " checked";?> />
                      �򰡱Ⱓ�� �����Ǹ� ��� ī�װ�����  �ְ� TOP10 ������ ������� <b><font color="FF0078">������ ��÷�� ����</font> </b></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px"><span class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� ÷ �� �� </span></td>
                    <td>
					<select name="p_gift_cnt" id="p_gift_cnt" class="logbox"  style="width:60">
						<option value="1" <?if ($e_p_gift_cnt == "1") echo " selected";?>>1��</option>
						<option value="2" <?if ($e_p_gift_cnt == "2") echo " selected";?>>2��</option>
						<option value="3" <?if ($e_p_gift_cnt == "3") echo " selected";?>>3��</option>
                    </select>
                      <span class="infont">�� �򰡱Ⱓ�� ������ �� �ڵ���÷�� ���� ��÷�Ǵ� ��÷���� �� (�ִ�3��) </span></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
        <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
          <tr>
            <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                  <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="24"  class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> �����ϱ�� �� ��ǰ�� ��ǰ�������ǰ� ������ ����, ��÷�� ��ǥ �� ������ ��÷�ڿ��� <b><u>�ִ� 7�� �̳��� �����ϴ� ���� ��Ģ</u></b>���� �մϴ�. </td>
                      </tr>
                      <tr>
                        <td height="24" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> �����ϱ�� �� ��ǰ�� <b>���ٸ� ������ ���ų� Ÿ������ ���� ���� ������ ������ ������ �ǰų�, �����ϱ�� �� ����� �ٸ� ��ǰ�� ���޵� ���</b>�� �߻��� �� �ִ�<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="FF5B5C"> <u><b>��������� ��� å���� ����ڿ��� �ֽ��ϴ�.</b></u></font> </td>
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
                        <tr>
                          <td align="center">
                              <input name="p_agree" id="p_agree" type="radio" value="Y" checked />
                              <b><font color="4B4B4B">�� ���׿� �����մϴ�.</font> </b>
                              <input name="p_agree" id="p_agree" type="radio" value="N" />
                              <b><font color="4B4B4B">�� ���׿� �������� �ʽ��ϴ�.</font>  </b></td>
                        </tr>
                      </table>
                  </td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="130"><img src="/img/btn_next01.gif" width="120" height="25" border="0" onClick="goStep2();" style="cursor:hand;" /></td>
            <td><img src="/img/btn_cancle.gif" width="120" height="25" border="0" onClick="document.frm.reset();" style="cursor:hand;" /></td>
          </tr>
        </table></td>
    </tr>
  </table>

</form>



<? include "../include/_foot.php"; ?>

