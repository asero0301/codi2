<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/user_join.php
 * date   : 2008.09.18
 * desc   : user join
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";


$mem_name = trim($_REQUEST['mem_name']);
$mem_jumin = trim($_REQUEST['mem_jumin']);
$mem_key = trim($_REQUEST['mem_key']);

$this_mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);

if ( $this_mem_key != $mem_key ) {
	echo "<script>alert('�Ǹ����� ���������� �����Դϴ�.'); location.href='/main.php';</script>";
	exit;
}

require_once "../include/_head.php";


?>

<script type="text/JavaScript">
<!--
function mail_host_chk() {
	var f = document.mem;
	if ( f.txt_host.options[f.txt_host.selectedIndex].value == "other" ) {
		f.mail_host.value = "";
		f.mail_host.focus();
	} else {
		f.mail_host.value = f.txt_host.options[f.txt_host.selectedIndex].value;
	}
}

function goUserReg() {
	var f = document.mem;

	if ( f.agree1[0].checked == false ) {
		alert("�̿����� �����ؾ� �մϴ�");
		return;
	}

	if ( f.agree2[0].checked == false ) {
		alert("����������ȣ��å�� �����ؾ� �մϴ�");
		return;
	}

	if ( trim(f.mem_id.value) == "" || !isID(f.mem_id) ) {
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

	if ( trim(f.mail_id.value) == "" || !isEmail(f.mail_id.value+"@"+f.mail_host.value) ) {
		alert("�����ּҰ� �Էµ��� �ʾҰų� �ùٸ� ������ �����ּҰ� �ƴմϴ�");
		f.mail_id.value = "";
		f.mail_id.focus();
		return;
	}

	if ( trim(f.mobile_2.value) == "" || trim(f.mobile_3.value) == "" ) {
		alert("�޴���ȭ ��ȣ�� �Է��ϼ���");
		f.mobile_2.focus();
		return;
	}

	if ( trim(f.zipcode.value) == "" ) {
		alert("�����ȣ�� �Էµ��� �ʾҰų� �ùٸ� ������ �����ȣ�� �ƴմϴ�");
		f.zipcode.value = "";
		f.zipcode.focus();
		return;
	}

	if ( trim(f.mem_addr1.value) == "" ) {
		alert("�ּҰ� �Էµ��� �ʾҽ��ϴ�.");
		f.mem_addr1.value = "";
		f.mem_addr1.focus();
		return;
	}

	if ( trim(f.mem_addr2.value) == "" ) {
		alert("�ּҰ� �Էµ��� �ʾҽ��ϴ�.");
		f.mem_addr2.value = "";
		f.mem_addr2.focus();
		return;
	}

	f.mode.value = "I";
	f.mem_kind.value = "U";
	f.action = "member_ok.php";
	f.submit();
}
//-->
</script>

<form name="mem" id="mem" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="mem_kind" name="mem_kind" value="" />
<input type="hidden" id="mem_key" name="mem_key" value="<?=$mem_key?>" />

<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15"><img src="/img/pro_in07.gif" width="15" height="29" /></td>
    <td background="/img/pro_in09.gif" style="padding-top:3" width="108" align=center><b><font color="FFF600">�Ϲ�ȸ������</font></b></td>
    <td width="33"><img src="/img/pro_in06.gif" width="33" height="29" /></td>
    <td background="/img/pro_in10.gif" style="padding-top:3"><font color="#FFFFFF">: �ڵ�ž���� ��� �мǻ�ǰ �� �ڵ������� ���� �� �ְ�, �ڵ���õ �� �򰡸� ���� ��ǰ��÷�� ��ȸ�� ���� �˴ϴ�.</font></td>
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
    �� �ڵ�ž���� ȸ�������� �����Դϴ�. </font>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
	  <font color="E4204A">
	�� ���θ��� ��Ͻô� ��ȸ���� ��� <a href="/member/real_chk.php?mem_kind=S"><b><font color="E4204A">��ȸ������</font></b></a>���� ȸ�������� ���ּ���. </font></td>
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
      <td>
	  
	  
	  <textarea id="textareaagree1" name="textareaagree1" class="memberbox "  style="width:100%; height:250; " >
	 
	  <? require_once "../member/txt/user1.php"; ?>
	  
	  </textarea>
	  
	  </td>
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
      <td>
	  
	  <textarea id="textareaagree2" name="textareaagree2" class="memberbox "  style="width:100%; height:250; " >
	  
	  <? require_once "../member/txt/user2.php"; ?>
	  
	  </textarea>
	  
	  </td>
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
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="22" valign="top"><img src="/img/smember03.gif" width="180" height="18" /> </td>
    </tr>
    <tr>
      <td width="1" background="/img/dot00.gif"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font color="E4204A"> �� <b>�Ϲ�ȸ�� ���Ծ���Դϴ�.</b> ���θ��� ��Ͻô� ��ȸ���� ��� <a href="/member/real_chk.php?mem_kind=S"><b><font color="E4204A">��ȸ������</font></b></a>���� ȸ�������� ���ּ���. (�ߺ����� �Ұ�) </font></td>
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
                          <span class="infont">��6�� �̻��� ����(��ҹ��ڱ���),����,Ư������</span> </td>
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
                      <td>�� ���� �źν� <u><font color="#333333">��ǰ ���� ����</font></u>�� �� �ֽ��ϴ�.</td>
					 </tr>
					<tr>
                        <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� <span class="num8">*</span></td>
                      <td><select name="mobile_1" class="logbox"  style="width:50">
                            <option value="010" <?if ($mobile_1=="010") echo " selected";?>>010</option>
							<option value="011" <?if ($mobile_1=="011") echo " selected";?>>011</option>
							<option value="016" <?if ($mobile_1=="016") echo " selected";?>>016</option>
							<option value="017" <?if ($mobile_1=="017") echo " selected";?>>017</option>
							<option value="018" <?if ($mobile_1=="018") echo " selected";?>>018</option>
							<option value="019" <?if ($mobile_1=="019") echo " selected";?>>019</option>
                          </select>
                          -
                          <input type="text" name="mobile_2" id="mobile_2" value="<?=$mobile_2?>" class="logbox"  style="width:60"/>
                          -
                        <input type="text" name="mobile_3" id="mobile_3" value="<?=$mobile_3?>" class="logbox"  style="width:60"/></td>
                    </tr>
					
					<tr>
                      <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �ּ� <span class="num8">*</span></td>
                      <td class="infont"><input type="text" name="zipcode" id="zipcode" value="<?=$zipcode?>" class="logbox"  style="width:100" readOnly />
                          <a href="javascript:zip_check('U');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a>����ǰ������ ���� ��Ȯ�� �ּҸ� �Է����ּ���.</td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr1" id="mem_addr1" value="" class="logbox"  style="width:400" /></td>
                    </tr>
                    <tr>
                      <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr2" id="mem_addr2" value="" class="logbox"  style="width:400" /></td>
                    </tr>
					<tr>
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
  <table width="860" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><img src="/img/btn_ok03.gif" width="148" height="30" border="0" onClick="goUserReg();" style="cursor:hand;" /></td>
    </tr>
  </table>
  </form>
  <? require_once "../include/_foot.php"; ?>
