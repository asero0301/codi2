<?
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

$rurl = trim($_REQUEST['rurl']);
?>

<? include "../include/_head.php"; ?>

<script type="text/JavaScript">
<!--
function sub_login() {
	var f = document.subloginfrm;

	if ( f.id.value == "" ) {
		alert("아이디를 입력하세요");
		f.id.focus();
		return;
	}

	if ( f.pwd.value == "" ) {
		alert("비밀번호을 입력하세요");
		f.pwd.focus();
		return;
	}
	f.action = "/member/login_ok.php";
	f.submit();
}

//-->
</script>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? //include "../include/left_my.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
 </td>
    <td width="15"></td>
    <td valign="top">
	
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">로그인 :</font></b> <font color="#FFFFFF">회원 로그인</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>

      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>





<form id="subloginfrm" name="subloginfrm" method="post">




<input type="hidden" id="rurl" name="rurl" value="<?=$rurl?>" />





<!-- 기존꺼

      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1">
		
		아이디저장 : <input type="checkbox" id="idsave" name="idsave" value="Y" /> 
		아이디 : <input type="text" id="id" name="id" value="<?=$_COOKIE['idsave']?>" /><br>
		비밀번호 : <input type="password" id="pwd" name="pwd" onKeyPress="javascript:if(event.keyCode==13) sub_login();" /><br>
		<input type="button" value="로그인" onClick="sub_login();">
		<input type="button" value="ID/비번 찾기" onClick="find_IDPWD();">
		<input type="button" value="가입" onClick="location.href='/member/real_chk.php';">
		  
		  </td>
        </tr>
      </table>

//-->

<table width="645" height="200" border="0" cellpadding="0" cellspacing="0" background="img/bg.jpg">
  <tr>
    <td><table width="645" height="200" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="295" align="center" valign="top"><table width="50" height="50" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="infont">회원가입시 등록한 아이디와 비빌번호를 입력하세요. </td>
          </tr>
          <tr>
            <td height=8></td>
          </tr>
        </table>
          <table width="80%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="60" height="26" class="intitle" ><img src="img/barbar.gif" width="7" height="3"  align="absmiddle" /> <b><font color="000000">아이디</font></b> </td>
              <td ><input type="text" id="id" name="id"class="logbox"  style="width:150"  value="<?=$_COOKIE['idsave']?>" />
              </td>
            </tr>
            <tr>
              <td   class="intitle" ><img src="img/barbar.gif" width="7" height="3"  align="absmiddle" /> <b><font color="000000">비밀번호</font></b> </td>
              <td ><input type="password" id="pwd" name="pwd" class="logbox"  style="width:150"   onKeyPress="javascript:if(event.keyCode==13) sub_login();" />
              </td>
            </tr>
          </table>
          <table width="80%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="5" background="../img/dot_lint_big.gif" ></td>
            </tr>
            <tr>
              <td height="30" align="center" valign="bottom"><a href="#"  onClick="sub_login();"><img src="img/btn_login_go.gif" width="100" height="20" border="0" /></a> <a href="/main.php"><img src="img/btn_join_cancle.gif" width="100" height="20" border="0" /></a></td>
            </tr>
          </table>
          </td>
        <td width="350" align="center" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="64">&nbsp;</td>
            </tr>
          <tr>
            <td><font color="#FFFFFF">하나, 코디탑텐은 무료가입<br />
             두울, 일반회원가입으로 자유롭게 이용<br> 세엣, 샵회원으로 코디상품판매 </font></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="tienom"><img src="img/arr_black.gif" width="14" height="7" /><a href="#"  onClick="location.href='/member/real_chk.php';"> 아직 코디탑텐 회원이 아니세요? </a></td>
                </tr>
                <tr>
                  <td class="tienom"><img src="img/arr_black.gif" width="14" height="7" align="absmiddle" /><a href="#"  onClick="find_IDPWD();"> 아이디나 비밀번호를 잊으셨나요? </a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>



</form>

<!--

<br />
<table width="645" height="120" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">회원가입에 따른 특별 서비스 내용 삽입 (예정)  </td>
  </tr>
</table>

//-->



</td>
  </tr>
</table>

<script language="javascript">document.subloginfrm.id.focus();</script>

<? include "../include/_foot.php"; ?>