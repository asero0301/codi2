<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/mypage.php
 * date   : 2008.10.08
 * desc   : ����������
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";


//print __FILE__ . __LINE__ . " RURL : " . $RURL . "<br>"; exit;

auth_chk($RURL);

$mainconn->open();



$mem_id = $_SESSION['mem_id'];

$sql = "select * from tblMember where mem_id = '$mem_id' ";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$mem_name = trim($row['mem_name']);
$mem_pwd = trim($row['mem_pwd']);
$mem_jumin = trim($row['mem_jumin']);
$mem_mobile = trim($row['mem_mobile']);
$zipcode = trim($row['zipcode']);
$mem_addr1 = trim($row['mem_addr1']);
$mem_addr2 = trim($row['mem_addr2']);
$mem_mailing = trim($row['mem_mailing']);
$mem_email = trim($row['mem_email']);

$t_mail_arr = explode("@", $mem_email);
$t_mobile_arr = explode("-", $mem_mobile);

$mail_str = ( $_SESSION['mem_kind'] == "S" ) ? "����ȸ������ �߼۵Ǵ� ��ǰ���޾ȳ������� ����, �������ʹ� �ʼ��Դϴ�." : "������ �źν� ��ǰ ���� ���ѵ� �� �ֽ��ϴ�.";

?>

<? include "../include/_head.php"; ?>

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
function goEditMember() {
	var f = document.mem;
/*
	if ( f.mem_pwd.value && !isPWD(f.mem_pwd) ) {
		alert("�����ȣ�� �ùٸ� ������ �ƴմϴ�1.");
		f.mem_pwd.value = "";
		f.mem_pwd.focus();
		return;
	}

	if ( f.mem_re_pwd.value && !isPWD(f.mem_re_pwd) ) {
		alert("�����ȣ�� �ùٸ� ������ �ƴմϴ�.");
		f.mem_re_pwd.value = "";
		f.mem_re_pwd.focus();
		return;
	}
*/
	if ( f.mem_pwd.value || f.mem_re_pwd.value ) {
		if ( f.mem_pwd.value != f.mem_re_pwd.value ) {
			alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.");
			f.mem_re_pwd.value = "";
			f.mem_re_pwd.focus();
			return;
		}
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

	f.mode.value = "E";
	f.action = "/member/member_ok.php";
	f.submit();
}
//-->
</script>


<table border="0" cellspacing="0" cellpadding="0">

<form id="mem" name="mem" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>" />

<input type="hidden" id="session_id" name="session_id" value="<?=$_SESSION['mem_id']?>" />

  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- ���������� ���� //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
	</td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">�⺻�������� :</font></b> <font color="#FFFFFF">�⺻���� ȸ�������� ������ �� �ֽ��ϴ�.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� </td>
                    <td><b><font color="FF5B5C"><?=$_SESSION['mem_id']?></font> (<?=$_SESSION['mem_name']?>)</b></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> ��й�ȣ ���� </td>
                    <td><input type="password" name="mem_pwd" id="mem_pwd" class="logbox"  style="width:150" />
                        <span class="infont">��6�� �̻��� ���� ��ҹ���,����,Ư������(��ҹ��ڱ���)</span> </td>
                  </tr>
                </table>


                


                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��й�ȣ Ȯ�� </td>
                      <td><input type="password" name="mem_re_pwd" id="mem_re_pwd" class="logbox"  style="width:150" /></td>
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
                      <td height="24" class="intitle"  style="LETTER-SPACING: 1px" width="110" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� </td>
                      <td><input type="text" name="mail_id" id="meil_id" class="logbox" value="<?=$t_mail_arr[0]?>" style="width:150" />
                        ��
						<input type="text" name="mail_host" id="meil_host" class="logbox" value="<?=$t_mail_arr[1]?>" style="width:150" />
                        <select name="txt_host" id="txt_host" class="logbox"  style="width:150" onChange="mail_host_chk();">
							<option value="">::: �����ϼ��� :::</option>
							<?
							
							$fp = fopen("../member/txt/mail_host.inc", "r");
							while ( !feof($fp) ) {
								$line = trim(fgets($fp, 100));
								$mail_arr = explode(",", $line);
								if ( $t_mail_arr[1] == $mail_arr[1] ) {
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
                      <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input name="mem_mailing" id="mem_mailing" type="checkbox" value="Y" <?if ($mem_mailing=="Y") echo " checked";?> />
                        �������͸� �ްڽ��ϴ�. </td>
                    </tr>
                    <tr>
                      <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><?=$mail_str?> </td>
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
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� </td>
                      <td ><select name="mobile_1" class="logbox"  style="width:50">
							<option value="010" <?if ($t_mobile_arr[0]=="010") echo " selected";?>>010</option>
							<option value="011" <?if ($t_mobile_arr[0]=="011") echo " selected";?>>011</option>
							<option value="016" <?if ($t_mobile_arr[0]=="016") echo " selected";?>>016</option>
							<option value="017" <?if ($t_mobile_arr[0]=="017") echo " selected";?>>017</option>
							<option value="018" <?if ($t_mobile_arr[0]=="018") echo " selected";?>>018</option>
							<option value="019" <?if ($t_mobile_arr[0]=="019") echo " selected";?>>019</option>
                        </select>
                        -
                        <input type="text" name="mobile_2" id="mobile_2" value="<?=$t_mobile_arr[1]?>" class="logbox"  style="width:60"/>
                        -
                        <input type="text" name="mobile_3" id="mobile_3" value="<?=$t_mobile_arr[2]?>" class="logbox"  style="width:60"/></td>
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
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��&nbsp;&nbsp;&nbsp;&nbsp;�� </td>
                      <td><input type="text" name="zipcode" id="zipcode" value="<?=$zipcode?>" class="logbox"  style="width:100" readOnly />
                          <a href="javascript:zip_check('U');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr1" id="mem_addr1" value="<?=$mem_addr1?>" class="logbox"  style="width:400" /></td>
                    </tr>
                    <tr>
                      <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                      <td><input type="text" name="mem_addr2" id="mem_addr2" value="<?=$mem_addr2?>" class="logbox"  style="width:400" /></td>
                    </tr>
                  </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><img src="/img/btn_ok03.gif" border="0" onClick="goEditMember();" style="cursor:hand;" /></td>
        </tr>
      </table></td>
  </tr>

</form>

</table>

<? include "../include/_foot.php"; ?>