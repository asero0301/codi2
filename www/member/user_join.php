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
	echo "<script>alert('실명인증 비정상적인 접근입니다.'); location.href='/main.php';</script>";
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
		alert("이용약관에 동의해야 합니다");
		return;
	}

	if ( f.agree2[0].checked == false ) {
		alert("개인정보보호정책에 동의해야 합니다");
		return;
	}

	if ( trim(f.mem_id.value) == "" || !isID(f.mem_id) ) {
		alert("아이디가 입력되지 않았거나 올바른 형식의 아이디가 아닙니다");
		f.mem_id.value = "";
		f.mem_id.focus();
		return;
	}

	if ( f.mem_pwd.value == "" || !isPWD(f.mem_pwd) ) {
		alert("비빌번호가 입력되지 않았거나 올바른 형식의 비밀번호가 아닙니다");
		f.mem_pwd.value = "";
		f.mem_pwd.focus();
		return;
	}

	if ( f.mem_re_pwd.value == "" || !isPWD(f.mem_re_pwd) ) {
		alert("비빌번호가 입력되지 않았거나 올바른 형식의 비밀번호가 아닙니다");
		f.mem_re_pwd.value = "";
		f.mem_re_pwd.focus();
		return;
	}

	if ( !isSame(f.mem_pwd, f.mem_re_pwd) ) {
		alert("비밀번호가 일치하지 않습니다.");
		f.mem_re_pwd.value = "";
		f.mem_re_pwd.focus();
		return;
	}

	if ( trim(f.mail_id.value) == "" || !isEmail(f.mail_id.value+"@"+f.mail_host.value) ) {
		alert("메일주소가 입력되지 않았거나 올바른 형식의 메일주소가 아닙니다");
		f.mail_id.value = "";
		f.mail_id.focus();
		return;
	}

	if ( trim(f.mobile_2.value) == "" || trim(f.mobile_3.value) == "" ) {
		alert("휴대전화 번호를 입력하세요");
		f.mobile_2.focus();
		return;
	}

	if ( trim(f.zipcode.value) == "" ) {
		alert("우편번호가 입력되지 않았거나 올바른 형식의 우편번호가 아닙니다");
		f.zipcode.value = "";
		f.zipcode.focus();
		return;
	}

	if ( trim(f.mem_addr1.value) == "" ) {
		alert("주소가 입력되지 않았습니다.");
		f.mem_addr1.value = "";
		f.mem_addr1.focus();
		return;
	}

	if ( trim(f.mem_addr2.value) == "" ) {
		alert("주소가 입력되지 않았습니다.");
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
    <td background="/img/pro_in09.gif" style="padding-top:3" width="108" align=center><b><font color="FFF600">일반회원가입</font></b></td>
    <td width="33"><img src="/img/pro_in06.gif" width="33" height="29" /></td>
    <td background="/img/pro_in10.gif" style="padding-top:3"><font color="#FFFFFF">: 코디탑텐의 모든 패션상품 및 코디정보를 보실 수 있고, 코디추천 및 평가를 통해 경품당첨의 기회를 갖게 됩니다.</font></td>
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
    <td bgcolor="FFF3F6"> <font color="E4204A">· </font><font color="E4204A">코디탑텐은 개인정보 보호정책에 따라 사용자의 개인정보 보호를 위하여 최선을 다하고 있으며, 회원님의 동의없이 정보를 공개하지 않습니다. </font>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <font color="E4204A">
    · 코디탑텐의 회원가입은 무료입니다. </font>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
	  <font color="E4204A">
	· 쇼핑몰을 운영하시는 샵회원은 상단 <a href="/member/real_chk.php?mem_kind=S"><b><font color="E4204A">샵회원가입</font></b></a>으로 회원가입을 해주세요. </font></td>
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
          동의함
          <input name="agree1" id="agree1" type="radio" value="N" />
          동의안함</td>
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
        동의함
        <input id="agree2" name="agree2" type="radio" value="N" />
        동의안함</td>
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
      <td><font color="E4204A"> · <b>일반회원 가입양식입니다.</b> 쇼핑몰을 운영하시는 샵회원은 상단 <a href="/member/real_chk.php?mem_kind=S"><b><font color="E4204A">샵회원가입</font></b></a>으로 회원가입을 해주세요. (중복가입 불가) </font></td>
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
                        <td width="120" height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> 이 름 </td>
                        <td><input type="text" id="mem_name" name="mem_name" value="<?=$mem_name?>" class="logbox"  style="width:100" readOnly /></td>
                      </tr>
                      <tr>
                        <td height="24" class="intitle" ><img src="/img/icon_aa.gif"  align="absmiddle"> 주민등록번호</td>
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
                      <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 아 이 디 <span class="num8">*</span></td>
                      <td><input type="text" name="mem_id" id="mem_id" value="" class="logbox"  style="width:150" readOnly />
                        <a href="javascript:id_check();"><img src="/img/btn_id.gif" border="0"  align="absmiddle"></a>
						<span class="infont">＊4~20자의 영문(대소문자구분),숫자,언더바(_)</span>
						</td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 비밀번호 <span class="num8">*</span></td>
                      <td><input type="password" id="mem_pwd" name="mem_pwd" class="logbox"  style="width:150" />
                          <span class="infont">＊6자 이상의 영문(대소문자구분),숫자,특수문자</span> </td>
                    </tr>
					 <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 비밀번호 확인 <span class="num8">*</span> </td>
                      <td><input type="password" id="mem_re_pwd" name="mem_re_pwd" class="logbox"  style="width:150" /></td>
                    </tr>

                   <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 이 메 일 <span class="num8">*</span></td>
                      <td><input type="text" name="mail_id" id="meil_id" class="logbox"  style="width:150" />
                        ＠
						<input type="text" name="mail_host" id="meil_host" class="logbox"  style="width:150" />
                        <select name="txt_host" id="txt_host" class="logbox"  style="width:150" onChange="mail_host_chk();">
							<option value="">::: 선택하세요 :::</option>
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
							<option value="other">직접입력</option>
                        </select>
						
						</td>
                    </tr>
					<tr>
                      <td height="24" class="intitle" >&nbsp;</td>
                      <td>
                          <input type="checkbox" id="mem_mailing" name="mem_mailing" value="Y" checked />
                         
                      뉴스레터를 받겠습니다. </td>
				    </tr>
					 <tr>
                      <td height="24" class="intitle"  >&nbsp;</td>
                      <td>＊ 수신 거부시 <u><font color="#333333">경품 응모가 제한</font></u>될 수 있습니다.</td>
					 </tr>
					<tr>
                        <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 휴 대 폰 <span class="num8">*</span></td>
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
                      <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 주소 <span class="num8">*</span></td>
                      <td class="infont"><input type="text" name="zipcode" id="zipcode" value="<?=$zipcode?>" class="logbox"  style="width:100" readOnly />
                          <a href="javascript:zip_check('U');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a>＊경품수령을 위해 정확한 주소를 입력해주세요.</td>
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
                      <td width="110" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 추천인 아이디 </td>
                      <td><input type="text" name="mem_recom_id" id="mem_recom_id" class="logbox"  style="width:150" /> 
                        <span class="infont">＊ 등록 후 수정불가능(정상 아이디가 아닌 경우 등록안됨) </span></td>
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
