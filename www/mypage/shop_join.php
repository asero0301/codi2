<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/shop_join.php
 * date   : 2008.10.07
 * desc   : shop join
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";


$mem_name = trim($_POST['mem_name']);
$mem_jumin = trim($_POST['mem_jumin']);
$mem_key = trim($_POST['mem_key']);

$this_mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);

if ( $this_mem_key != $mem_key ) {
	echo "<script>alert('�Ǹ����� ���������� �����Դϴ�.'); location.href='/main.php';</script>";
	exit;
}

$mobile_certify_num = trim($_POST['mobile_certify_num']);
$pno_1 = trim($_POST['pno_1']);
$pno_2 = trim($_POST['pno_2']);
$pno_3 = trim($_POST['pno_3']);
$mobile_no = $pno_1."-".$pno_2."-".$pno_3;

$mainconn->open();

$sql = "select certify_no from tblCertifyMobile where mobile_no = '$mobile_no' order by idx desc limit 1";
$certify_no = $mainconn->count($sql);

if ( $certify_no != $mobile_certify_num ) {
	echo "<script>alert('�޴��� ������ȣ�� ��ġ���� �ʽ��ϴ�.'); history.back();</script>";
	exit;
}


require_once "../include/_head.php";


?>
<script type="text/JavaScript">
<!--
g_layer = 1;
shop_max_cnt = parseInt('<?=$SHOP_MAX_COUNT?>');
function add_shop() {
	var f = document.mem;
	// ���� �Է��� ���� �ʼ��׸��� �Էµ��� ������ �߰��� �� ����.
	for ( var i=0; i<shop_max_cnt; i++ ) {
		shop_name = eval("f.shop_name_"+i);
		shop_kind = eval("f.shop_kind_"+i);
		shop_url = eval("f.shop_url_"+i);
		shop_num = eval("f.shop_num_"+i);
		shop_tax = eval("f.shop_tax_"+i);
		shop_person = eval("f.shop_person_"+i);
		shop_mail_id = eval("f.shop_mail_id_"+i);
		shop_mail_host = eval("f.shop_mail_host_"+i);
		smobile_1 = eval("f.smobile_1_"+i);
		smobile_2 = eval("f.smobile_2_"+i);
		smobile_3 = eval("f.smobile_3_"+i);
		sphone_1 = eval("f.sphone_1_"+i);
		sphone_2 = eval("f.sphone_2_"+i);
		sphone_3 = eval("f.sphone_3_"+i);
		shop_zipcode = eval("f.shop_zipcode_"+i);
		shop_addr1 = eval("f.shop_addr1_"+i);
		shop_addr2 = eval("f.shop_addr2_"+i);
		
		var chk_obj = document.getElementById("shop_info_area_"+i);
		if ( chk_obj.style.display == "block" ) {
			if ( trim(shop_name.value) == "" ) {
				alert("�� �̸��� �Է��ϼ���.");
				shop_name.focus();
				return;
			}
			if ( trim(shop_url.value) == "" ) {
				alert("�� URL�� �Է��ϼ���.");
				shop_url.focus();
				return;
			}
			if ( trim(shop_num.value) == "" ) {
				alert("����� ��Ϲ�ȣ�� �Է��ϼ���.");
				shop_num.focus();
				return;
			}
			if ( trim(shop_person.value) == "" ) {
				alert("�� å���ڸ� �Է��ϼ���.");
				shop_person.focus();
				return;
			}
			if ( trim(shop_mail_id.value) == "" ) {
				alert("�����ּҸ� �Է��ϼ���.");
				shop_mail_id.focus();
				return;
			}
			if ( trim(shop_mail_host.value) == "" ) {
				alert("�����ּҸ� �Է��ϼ���.");
				shop_mail_host.focus();
				return;
			}
			if ( trim(smobile_2.value) == "" ) {
				alert("�޴���ȭ ��ȣ�� �Է��ϼ���.");
				smobile_2.focus();
				return;
			}
			if ( trim(smobile_3.value) == "" ) {
				alert("�޴���ȭ ��ȣ�� �Է��ϼ���.");
				smobile_3.focus();
				return;
			}
			if ( trim(sphone_1.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_1.focus();
				return;
			}
			if ( trim(sphone_2.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_2.focus();
				return;
			}
			if ( trim(sphone_3.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_3.focus();
				return;
			}
			if ( trim(shop_zipcode.value) == "" ) {
				alert("�����ȣ�� �Է��ϼ���.");
				shop_zipcode.focus();
				return;
			}
			if ( trim(shop_addr1.value) == "" ) {
				alert("�ּҸ� �Է��ϼ���.");
				shop_addr1.focus();
				return;
			}
			if ( trim(shop_addr2.value) == "" ) {
				alert("�ּҸ� �Է��ϼ���.");
				shop_addr2.focus();
				return;
			}
		}
	}

	if ( g_layer == shop_max_cnt ) {
		alert("��ϰ����� ���� �ִ� "+shop_max_cnt+"�� �Դϴ�.");
		return;
	}
	var obj = document.getElementById("shop_info_area_"+g_layer);
	obj.style.display = "block";
	g_layer++;
}
function hide_shop(idx) {
	if ( idx == (g_layer-1) ) g_layer--;
	var obj = document.getElementById("shop_info_area_"+idx);
	obj.style.display = "none";

	var f = document.mem;
	eval("f.shop_name_"+idx).value = "";
	eval("f.shop_kind_"+idx).value = "D";
	eval("f.shop_url_"+idx).value = "";
	eval("f.shop_num_"+idx).value = "";
	eval("f.shop_tax_"+idx).value = "N";
	eval("f.shop_person_"+idx).value = "";
	eval("f.shop_mail_id_"+idx).value = "";
	eval("f.shop_mail_host_"+idx).value = "";
	eval("f.shop_txt_host_"+idx).value = "";
	eval("f.smobile_1_"+idx).value = "010";
	eval("f.smobile_2_"+idx).value = "";
	eval("f.smobile_3_"+idx).value = "";
	eval("f.sphone_1_"+idx).value = "";
	eval("f.sphone_2_"+idx).value = "";
	eval("f.sphone_3_"+idx).value = "";
	eval("f.sfax_1_"+idx).value = "";
	eval("f.sfax_2_"+idx).value = "";
	eval("f.sfax_3_"+idx).value = "";
	eval("f.shop_etc1_"+idx).value = "";
	eval("f.shop_etc2_"+idx).value = "";
	eval("f.shop_zipcode_"+idx).value = "";
	eval("f.shop_addr1_"+idx).value = "";
	eval("f.shop_addr2_"+idx).value = "";
}

function del_shop() {
	g_layer--;
	var obj = document.getElementById("shop_info_area_"+g_layer);
	obj.style.display = "none";
}

function mail_host_chk() {
	var f = document.mem;
	if ( f.txt_host.options[f.txt_host.selectedIndex].value == "other" ) {
		f.mail_host.value = "";
		f.mail_host.focus();
	} else {
		f.mail_host.value = f.txt_host.options[f.txt_host.selectedIndex].value;
	}
}
function shop_mail_host_chk(id) {
	var f = document.mem;
	var obj = eval("document.mem.shop_txt_host_"+id);

	if ( obj.options[obj.selectedIndex].value == "other" ) {
		obj.value = "";
		obj.focus();
	} else {
		obj.value = obj.options[obj.selectedIndex].value;
	}
}
function goShopUserReg() {
	var f = document.mem;

	if ( f.agree1[0].checked == false ) {
		alert("�̿����� �����ؾ� �մϴ�");
		return;
	}

	if ( f.agree2[0].checked == false ) {
		alert("����������ȣ��å�� �����ؾ� �մϴ�");
		return;
	}

	if ( f.mem_id.value == "" || !isID(f.mem_id) ) {
		alert("���̵� �Էµ��� �ʾҰų� �ùٸ� ������ ���̵� �ƴմϴ�");
		f.mem_id.value = "";
		f.mem_id.focus();
		return;
	}

	if ( f.mem_pwd.value == "" || !isPWD(f.mem_pwd) ) {
		alert("�����ȣ�� �Էµ��� �ʾҰų� �ùٸ� ������ ��й�ȣ�� �ƴմϴ�");
		f.mem_pwd.value = "";
		f.mem_pwd.focus();
		return;
	}

	if ( f.mem_re_pwd.value == "" || !isPWD(f.mem_re_pwd) ) {
		alert("�����ȣ�� �Էµ��� �ʾҰų� �ùٸ� ������ ��й�ȣ�� �ƴմϴ�");
		f.mem_re_pwd.value = "";
		f.mem_re_pwd.focus();
		return;
	}

	if ( !isSame(f.mem_pwd, f.mem_re_pwd) ) {
		alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.");
		f.mem_re_pwd.value = "";
		f.mem_re_pwd.focus();
		return;
	}

	if ( f.mail_id.value == "" || !isEmail(f.mail_id.value+"@"+f.mail_host.value) ) {
		alert("�����ּҰ� �Էµ��� �ʾҰų� �ùٸ� ������ �����ּҰ� �ƴմϴ�");
		f.mail_id.value = "";
		f.mail_id.focus();
		return;
	}

	if ( f.mobile_2.value == "" || f.mobile_3.value == "" ) {
		alert("�޴���ȭ ��ȣ�� �Է��ϼ���");
		f.mobile_2.focus();
		return;
	}

	if ( f.mem_mailing.checked == false || f.mem_sms.checked == false ) {
		alert("�������� �Ǵ� SMS ���ŵ��ǰ� ���� �ʾҽ��ϴ�.");
		return;
	}

	for ( var i=0; i<shop_max_cnt; i++ ) {
		shop_name = eval("f.shop_name_"+i);
		shop_kind = eval("f.shop_kind_"+i);
		shop_url = eval("f.shop_url_"+i);
		shop_num = eval("f.shop_num_"+i);
		shop_tax = eval("f.shop_tax_"+i);
		shop_person = eval("f.shop_person_"+i);
		shop_mail_id = eval("f.shop_mail_id_"+i);
		shop_mail_host = eval("f.shop_mail_host_"+i);
		smobile_1 = eval("f.smobile_1_"+i);
		smobile_2 = eval("f.smobile_2_"+i);
		smobile_3 = eval("f.smobile_3_"+i);
		sphone_1 = eval("f.sphone_1_"+i);
		sphone_2 = eval("f.sphone_2_"+i);
		sphone_3 = eval("f.sphone_3_"+i);
		shop_zipcode = eval("f.shop_zipcode_"+i);
		shop_addr1 = eval("f.shop_addr1_"+i);
		shop_addr2 = eval("f.shop_addr2_"+i);
		
		var chk_obj = document.getElementById("shop_info_area_"+i);
		if ( chk_obj.style.display == "block" ) {
			if ( trim(shop_name.value) == "" ) {
				alert("�� �̸��� �Է��ϼ���.");
				shop_name.focus();
				return;
			}
			if ( trim(shop_url.value) == "" ) {
				alert("�� URL�� �Է��ϼ���.");
				shop_url.focus();
				return;
			}
			if ( trim(shop_num.value) == "" ) {
				alert("����� ��Ϲ�ȣ�� �Է��ϼ���.");
				shop_num.focus();
				return;
			}
			if ( !isNumber(shop_num) ) {
				alert("����ڵ�Ϲ�ȣ�� ���ڿ��� �մϴ�.");
				shop_num.value = "";
				shop_num.focus();
				return;
			}
			if ( trim(shop_person.value) == "" ) {
				alert("�� å���ڸ� �Է��ϼ���.");
				shop_person.focus();
				return;
			}
			if ( trim(shop_mail_id.value) == "" ) {
				alert("�����ּҸ� �Է��ϼ���.");
				shop_mail_id.focus();
				return;
			}
			if ( trim(shop_mail_host.value) == "" ) {
				alert("�����ּҸ� �Է��ϼ���.");
				shop_mail_host.focus();
				return;
			}
			if ( !isEmail(trim(shop_mail_id.value)+"@"+trim(shop_mail_host.value)) ) {
				alert("�����ּҰ� �Էµ��� �ʾҰų� �ùٸ� ������ �����ּҰ� �ƴմϴ�");
				shop_mail_id.value = "";
				shop_mail_id.focus();
				return;
			}
			if ( trim(smobile_2.value) == "" ) {
				alert("�޴���ȭ ��ȣ�� �Է��ϼ���.");
				smobile_2.focus();
				return;
			}
			if ( trim(smobile_3.value) == "" ) {
				alert("�޴���ȭ ��ȣ�� �Է��ϼ���.");
				smobile_3.focus();
				return;
			}
			if ( !isNumber(smobile_2) ) {
				alert("�޴���ȭ��ȣ�� ���ڿ��� �մϴ�.");
				smobile_2.value = "";
				smobile_2.focus();
				return;
			}
			if ( !isNumber(smobile_3) ) {
				alert("�޴���ȭ��ȣ�� ���ڿ��� �մϴ�.");
				smobile_3.value = "";
				smobile_3.focus();
				return;
			}
			if ( trim(sphone_1.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_1.focus();
				return;
			}
			if ( trim(sphone_2.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_2.focus();
				return;
			}
			if ( trim(sphone_3.value) == "" ) {
				alert("��ȭ��ȣ�� �Է��ϼ���.");
				sphone_3.focus();
				return;
			}
			if ( !isNumber(sphone_1) ) {
				alert("��ȭ��ȣ�� ���ڿ��� �մϴ�.");
				sphone_1.value = "";
				sphone_1.focus();
				return;
			}
			if ( !isNumber(sphone_2) ) {
				alert("��ȭ��ȣ�� ���ڿ��� �մϴ�.");
				sphone_2.value = "";
				sphone_2.focus();
				return;
			}
			if ( !isNumber(sphone_3) ) {
				alert("��ȭ��ȣ�� ���ڿ��� �մϴ�.");
				sphone_3.value = "";
				sphone_3.focus();
				return;
			}
			if ( trim(shop_zipcode.value) == "" ) {
				alert("�����ȣ�� �Է��ϼ���.");
				shop_zipcode.focus();
				return;
			}
			if ( trim(shop_addr1.value) == "" ) {
				alert("�ּҸ� �Է��ϼ���.");
				shop_addr1.focus();
				return;
			}
			if ( trim(shop_addr2.value) == "" ) {
				alert("�ּҸ� �Է��ϼ���.");
				shop_addr2.focus();
				return;
			}
		}
	}	// for

	f.mode.value = "I";
	f.mem_kind.value = "S";
	f.encoding = "multipart/form-data";
	f.action = "shop_member_ok.php";
	f.submit();
}

//-->
</script>

<form name="mem" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="mem_kind" name="mem_kind" value="" />
<input type="hidden" id="mem_key" name="mem_key" value="<?=$mem_key?>" />


<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15"><img src="/img/pro_in07.gif" width="15" height="29" /></td>
    <td background="/img/pro_in09.gif" style="padding-top:3"width="108" align=center><b><font color="FFF600">��ȸ�� ����</font></b></td>
    <td width="33"><img src="/img/pro_in06.gif" width="33" height="29" /></td>
    <td background="/img/pro_in10.gif" style="padding-top:3"><font color="#FFFFFF">: �ڵ�ž�ٿ� �мǻ�ǰ �� �ڵ� ����� �������� ������� ������ȯ���� ���� Ÿ�� �������� ������ �� �ֽ��ϴ�.</font></td>
    <td width="15"><img src="/img/pro_in08.gif" width="15" height="29" /></td>
  </tr>
</table>
<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="14"><img src="/img/box11.gif" width="14" height="14" /></td>
    <td background="/img/box15.gif"></td>
    <td width="14"><img src="/img/box12.gif" width="14" height="14" /></td>
  </tr>
  <tr>
    <td background="/img/box17.gif"></td>
    <td bgcolor="FFF3F6"> <font color="E4204A">�� </font><font color="E4204A">�ڵ�ž���� �������� ��ȣ��å�� ���� ������� �������� ��ȣ�� ���Ͽ� �ּ��� ���ϰ� ������, ȸ������ ���Ǿ��� ������ �������� �ʽ��ϴ�. </font>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <font color="E4204A">
    �� �ڵ�ž���� ȸ�������� �����Դϴ�. </font></td>
    <td background="/img/box18.gif"></td>
  </tr>
  <tr>
    <td><img src="/img/box13.gif" width="14" height="14" /></td>
    <td background="/img/box16.gif"></td>
    <td><img src="/img/box14.gif" width="14" height="14" /></td>
  </tr>
</table>
<table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
</table>
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember01.gif" width="180" height="18" /></td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><textarea name="textarea" class="memberbox "  style="width:100%; height:250; " >



		<? require_once "../member/txt/shop1.php"; ?>




</textarea></td>
    </tr>
  </table>
  <table width="860" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">
          <input name="agree1" id="agree1" type="radio" value="Y" />
          ������
          <input name="agree1" id="agree1" type="radio" value="N" />
          ���Ǿ���</td>
    </tr>
    
</table>
  <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
  </table>
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember02.gif" width="180" height="18" /></td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><textarea name="textarea2" class="memberbox "  style="width:100%; height:250; " >
	  
		<? require_once "../member/txt/shop2.php"; ?>

</textarea></td>
    </tr>
  </table>
  <table width="860" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">
		<input id="agree2" name="agree2" type="radio" value="Y" />
        ������
        <input id="agree2" name="agree2" type="radio" value="N" />
        ���Ǿ���</td>
    </tr>
  </table>
  <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
  </table>


<!-- ȸ�� �������� -->
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember03.gif" width="180" height="18" /></td>
    </tr>
	<tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:10 10 10 10" class="intext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
                      <tr>
                        <td width="120" height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> �� �� </td>
                        <td><input type="text" id="mem_name" name="mem_name" value="<?=$mem_name?>" class="logbox"  style="width:100" readOnly /></td>
                      </tr>
                      <tr>
                        <td height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> �ֹε�Ϲ�ȣ</td>
                        <td><input type="text" id="mem_jumin" name="mem_jumin" value="<?=$mem_jumin?>" class="logbox"  style="width:100" readOnly />
                          </td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                      <td><input type="text" name="mem_id" id="mem_id" value="" class="logbox"  style="width:150" readOnly />
                        <a href="javascript:id_check();"><img src="/img/btn_id.gif" border="0"  align="absmiddle"></a>
						<span class="infont">��4~20���� ����(��ҹ��ڱ���),����,�����(_)</span>
						</td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> ��й�ȣ <span class="num8">*</span></td>
                      <td><input type="password" id="mem_pwd" name="mem_pwd" class="logbox"  style="width:150" />
                          <span class="infont">��6~20���� ����(��ҹ��ڱ���),����,Ư������</span> </td>
                    </tr>
					 <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> ��й�ȣ Ȯ�� <span class="num8">*</span> </td>
                      <td><input type="password" id="mem_re_pwd" name="mem_re_pwd" class="logbox"  style="width:150" /></td>
                    </tr>

                   <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                      <td><input type="text" name="mail_id" id="meil_id" class="logbox"  style="width:150" />
                        ��
						<input type="text" name="mail_host" id="meil_host" class="logbox"  style="width:150" />
                        <select name="txt_host" id="txt_host" class="logbox"  style="width:150" onChange="mail_host_chk();">
							<option value="">::: �����ϼ��� :::</option>
							<?
							
							$fp = fopen("/coditop/member/txt/mail_host.inc", "r");
							while ( !feof($fp) ) {
								$line = trim(fgets($fp, 100));
								$mail_arr = explode(",", $line);
								if ( $email_host == $mail_arr[1] ) {
									echo "<option value='".$mail_arr[1]."' selected>".$mail_arr[0]."</option>";
								} else {
									echo "<option value='".$mail_arr[1]."'>".$mail_arr[0]."</option>";
								}
							}
							fclose($fp);
							
							?>
							<option value="other">�����Է�</option>
                        </select>
						
						</td>
                    </tr>
					<tr>
                      <td height="24" class="intitle" >&nbsp;</td>
                      <td>
                          <input type="checkbox" id="mem_mailing" name="mem_mailing" value="Y" checked />
                         
                      �������͸� �ްڽ��ϴ�. </td>
				    </tr>
					 <tr>
                      <td height="24" class="intitle"  >&nbsp;</td>
                      <td>�� ��ȸ������ �߼۵Ǵ� <u><font color="#333333">��ǰ���� �ȳ�����</font></u>�� ����, �������ʹ� �ʼ��Դϴ�.</td>
					 </tr>
					<tr>
                        <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                      <td>
						  <input type="text" name="mobile_1" id="mobile_1" value="<?=$pno_1?>" class="logbox"  style="width:60" readOnly />
                          -
                          <input type="text" name="mobile_2" id="mobile_2" value="<?=$pno_2?>" class="logbox"  style="width:60" readOnly />
                          -
                        <input type="text" name="mobile_3" id="mobile_3" value="<?=$pno_3?>" class="logbox"  style="width:60" readOnly /> <input type="checkbox" id="mem_sms" name="mem_sms" value="Y" checked /> SMS�ޱ� &nbsp;&nbsp; * ��ǰ���޾ȳ��� �ޱ� ���� �ʼ��Դϴ�.</td>
                    </tr>
					
					<tr>
                      <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �ּ� <span class="num8">*</span></td>
                      <td class="infont"><input type="text" name="zipcode" id="zipcode" value="<?=$zipcode?>" class="logbox"  style="width:100" readOnly />
                          <a href="javascript:zip_check('U');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a>����ǰ���ް� ���õ� �߿������Դϴ�. ��Ȯ�� �ּҸ� �Է����ּ���.</td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr1" id="mem_addr1" value="" class="logbox"  style="width:400" /></td>
                    </tr>
                    <tr>
                      <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr2" id="mem_addr2" value="" class="logbox"  style="width:400" /></td>
                    </tr>
					<!--<tr>-->
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
                      <td width="110" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> ��õ�� ���̵� </td>
                      <td><input type="text" name="mem_recom_id" id="mem_recom_id" class="logbox"  style="width:150" /> 
                        <span class="infont">�� ��� �� �����Ұ���(���� ���̵� �ƴ� ��� ��Ͼȵ�) </span></td>
                    </tr>
                  </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
  </table>




  <!-- ��ȸ�� �⺻���� -->
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember05.gif" width="180" height="18" /></td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>


<?
for ( $i=0; $i<$SHOP_MAX_COUNT; $i++ ) {
	if ( $i==0 ) {
		$display = "display:block;";
	} else {
		$display = "display:none;";
	}
?>
<div id="shop_info_area_<?=$i?>" style="<?=$display?>">
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
          <tr>
            <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                  <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                      <tr>
                        <td style="padding:10 10 10 10" class="intext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="40" height="24" ><img src="/img/icon_oh.gif"  align="absmiddle"></td>
                              <td height="24" class="intext" >����� ���θ��� �������� ��� ���� �߰��� �� �ֽ��ϴ�. </td>
                            </tr>
							<tr>
                              <td width="40" height="18" >&nbsp;</td>
                              <td class="intext" ><u><font color=DD2457 >���� �̸����� ���� ���¸��Ͽ��� �̴ϼ��� ��ϴ� ��쿡�� �ϳ��� ����� �� �湮�� ���߽�Ű�� ���� ����</font></u>�մϴ�. </td>
                            </tr>
                            
                            
                        </table></td>
                      </tr>
                    </table>
                      <table width="100" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �̸� <span class="num8">*</span></td>
                          <td><input type="text" name="shop_name_<?=$i?>" id="shop_name_<?=$i?>" value="<?=$shop_name?>" class="logbox"  style="width:150" />  
                            <span class="infont">������Ʈ �̸� �Ǵ� �̴ϼ� �̸� </span></td>
                        </tr>
                        <tr>
                          <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� ���� <span class="num8">*</span></td>
                          <td>
						  <select name="shop_kind_<?=$i?>" id="shop_kind_<?=$i?>" class="logbox" style="width:150" readOnly>
                            <option value="I" <?if ($i==0) echo " selected";?>>��ǥ��</option>
							<option value="D" <?if ($i!=0) echo " selected";?>>�߰���</option>
                          </select>
						  <span class="infont">������� ���� 1�� �̻��� ���, ��ǥ�� �Ǵ� ���� �����մϴ�.</span>
						  </td>
                        </tr>
                        <tr>
                          <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� URL <span class="num8">*</span></td>
                          <td><input name="shop_url_<?=$i?>" id="shop_url_<?=$i?>" type="text" class="logbox"  style="width:400" value="http://" /></td>
                        </tr>
                        <tr>
                          <td height="24" class="intitle"  >&nbsp;</td>
                          <td><span class="infont">�����¸��� ���� �̴ϼ��� ��� �̴ϼ����� �̵��� �� �ִ� ��ü �ּҸ� �Է��ϼ��� </span></td>
                        </tr>
						<tr>
                          <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> ����ڵ�Ϲ�ȣ <span class="num8">*</span></td>
                          <td><input name="shop_num_<?=$i?>" id="shop_num_<?=$i?>" type="text" class="logbox"  style="width:150" value="<?=$shop_num?>" /><span class="infont">��"-" ���� �Է� </span></td>
                        </tr>
						<tr>
                          <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> ���ݰ�꼭 <span class="num8">*</span></td>
                          <td>
						  <select name="shop_tax_<?=$i?>" id="shop_tax_<?=$i?>" class="logbox" style="width:150">
                            <option value="N" <?if ($shop_tax=="N") echo " selected";?>>�̹߱�</option>
							<option value="Y" <?if ($shop_tax=="Y") echo " selected";?>>�߱�</option>
                          </select>
						  </td>
                        </tr>
						<tr>
                          <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� å���� <span class="num8">*</span> </td>
                          <td><input type="text" name="shop_person_<?=$i?>" id="shop_person_<?=$i?>" class="logbox" value="<?=$shop_person?>" style="width:150" />
                            <span class="infont">���� � å���� �̸� </span></td>
                        </tr>
						<tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                      <td><input type="text" name="shop_mail_id_<?=$i?>" id="shop_mail_id_<?=$i?>" value="<?=$shop_mail_id?>" class="logbox"  style="width:150" />
                        ��
						<input type="text" name="shop_mail_host_<?=$i?>" id="shop_meil_host_<?=$i?>" class="logbox"  style="width:150" />
                        <select name="shop_txt_host_<?=$i?>" id="shop_txt_host_<?=$i?>" class="logbox"  style="width:150" onChange="shop_mail_host_chk('<?=$id?>');">
							<option value="">::: �����ϼ��� :::</option>
							<?
							
							$fp = fopen("/coditop/member/txt/mail_host.inc", "r");
							while ( !feof($fp) ) {
								$line = trim(fgets($fp, 100));
								$mail_arr = explode(",", $line);
								if ( $email_host == $mail_arr[1] ) {
									echo "<option value='".$mail_arr[1]."' selected>".$mail_arr[0]."</option>";
								} else {
									echo "<option value='".$mail_arr[1]."'>".$mail_arr[0]."</option>";
								}
							}
							fclose($fp);
							
							?>
							<option value="other">�����Է�</option>
                        </select></td>
                    </tr>
						 <tr>
                          <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                          <td>
						  <select name="smobile_1_<?=$i?>" class="logbox"  style="width:50">
                            <option value="010" <?if ($pno_1=="010") echo " selected";?>>010</option>
							<option value="011" <?if ($pno_1=="011") echo " selected";?>>011</option>
							<option value="016" <?if ($pno_1=="016") echo " selected";?>>016</option>
							<option value="017" <?if ($pno_1=="017") echo " selected";?>>017</option>
							<option value="018" <?if ($pno_1=="018") echo " selected";?>>018</option>
							<option value="019" <?if ($pno_1=="019") echo " selected";?>>019</option>
                          </select>
                          -
                          <input type="text" name="smobile_2_<?=$i?>" id="smobile_2_<?=$i?>" value="<?=$pno_2?>" maxlength="4" class="logbox"  style="width:60" />
                          -
                        <input type="text" name="smobile_3_<?=$i?>" id="smobile_3_<?=$i?>" value="<?=$pno_3?>" maxlength="4" class="logbox"  style="width:60" />
						  </td>
                        </tr>
						  <tr>
                          <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� ȭ <span class="num8">*</span></td>
                          <td><input type="text" name="sphone_1_<?=$i?>" id="sphone_1_<?=$i?>" value="<?=$sphone_1?>" maxlength="4" class="logbox"  style="width:50" />
                            -
                            <input type="text" name="sphone_2_<?=$i?>" id="sphone_2_<?=$i?>" value="<?=$sphone_2?>" maxlength="4" class="logbox"  style="width:60" />
                            -
                            <input type="text" name="sphone_3_<?=$i?>" id="sphone_3_<?=$i?>" value="<?=$sphone_3?>" maxlength="4" class="logbox"  style="width:60" /></td>
                        </tr>
						  <tr>
                          <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                          <td><input type="text" name="sfax_1_<?=$i?>" id="sfax_1_<?=$i?>" value="<?=$sfax_1?>" maxlength="4" class="logbox"  style="width:50" />
-
  <input type="text" name="sfax_2_<?=$i?>" id="sfax_2_<?=$i?>" value="<?=$sfax_2?>" maxlength="4" class="logbox"  style="width:60" />
-
<input type="text" name="sfax_3_<?=$i?>" id="sfax_3_<?=$i?>" value="<?=$sfax_3?>" maxlength="4" class="logbox"  style="width:60" /></td>
                        </tr>

						<tr>
                          <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> ���� </td>
                          <td><input type="text" name="shop_etc1_<?=$i?>" id="shop_etc1_<?=$i?>" value="<?=$shop_etc1?>" class="logbox"  style="width:150" />  
                            </td>
                        </tr>

						<tr>
                          <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> ���� </td>
                          <td><input type="text" name="shop_etc2_<?=$i?>" id="shop_etc2_<?=$i?>" value="<?=$shop_etc2?>" class="logbox"  style="width:150" />  
                            </td>
                        </tr>

						<tr>
						  <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ����� �ּ� <span class="num8">*</span></td>
						  <td class="infont"><input type="text" name="shop_zipcode_<?=$i?>" id="shop_zipcode_<?=$i?>" value="<?=$shop_zipcode?>" class="logbox"  style="width:100" readOnly />
							  <a href="javascript:zip_check_shop('S','<?=$i?>');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a></td>
						</tr>
						<tr>
						  <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
						  <td><input type="text" name="shop_addr1_<?=$i?>" id="shop_addr1_<?=$i?>" value="<?=$shop_addr1?>" class="logbox"  style="width:400" /></td>
						</tr>
						<tr>
						  <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
						  <td><input type="text" name="shop_addr2_<?=$i?>" id="shop_addr2_<?=$i?>" value="<?=$shop_addr2?>" class="logbox"  style="width:400" /></td>
						</tr>
						

                        <tr>
                          <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �ΰ� </td>
                          <td class="infont"><input type="file" name="shop_logo_<?=$i?>" id="shop_logo" class="logbox"  style="width:474" />
                          ������ 64�ȼ�, ���� 64�ȼ� ����</td>
                        </tr>

                    </table>

                    </td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>

  <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
  </table>
</div>
<? } ?>




  <table width="860" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
		<td height="24" colspan="2" align="right" valign="bottom"><a href="javascript:add_shop();"><img src="/img/btn_shop_add.gif" width="80" height="20" border="0" /></a></td>
	</tr>
  </table>



  <table width="860" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><img src="/img/btn_ok03.gif" width="148" height="30" border="0" onClick="goShopUserReg();" style="cursor:hand;" /></td>
    </tr>
  </table>
  
  </form>

  <? include "../include/_foot.php"; ?>
