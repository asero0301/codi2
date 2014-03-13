<? 
if ( strlen($_SESSION['mem_id']) >= 4 ) { 
	$welcome_info = "";
	if ( $_SESSION['mem_kind'] == "U" ) {
		$welcome_info = "(".$_SESSION['mem_grade']."등급)";
	} else if ( $_SESSION['mem_kind'] == "S" ) {
		$welcome_info = "(".$_SESSION['shop_name'].")";
	}
		
?>

<script language="javascript">
function main_logout() {
	var f = document.logoutfrm;
	//f.rurl.value = "<?=$_SERVER['REQUEST_URI']?>";
	f.action = "/member/logout.php";
	f.submit();
}
</script>


<form id="logoutfrm" name="logoutfrm" method="post">
<input type="hidden" id="rurl" name="rurl" value="" />
<input type="hidden" id="session_id" name="session_id" value="<?=$_SESSION['mem_id']?>" />
<input type="hidden" id="session_name" name="session_name" value="<?=$_SESSION['mem_name']?>" />
<input type="hidden" id="session_grade" name="session_grade" value="<?=$_SESSION['mem_grade']?>" />
</form>

<!-- 로그인후 모습 -->
<table width="560" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td align="right"  class="evmem">
		<img src="/img/icon_key.gif" width="16" height="17" valign="absmiddle">
		<?=$_SESSION['mem_name']?>님의 방문을 환영합니다. <?=$welcome_info?> &nbsp; 
		<a href="#" onclick="main_logout();"><img src="/img/btn_logout.gif" alt="로그아웃" width="64" height="20" border="0" valign="absmiddle"></a>&nbsp; &nbsp; 
		
		<!--<img src="/img/arr_gray_box.gif" width="6" height="7">  
		<a href="/mypage/mypage.php"><b>마이페이지</b></a>&nbsp; -->
		<a href="/mypage/mypage.php"><img src="/img/btn_mypage.gif" border="0" valign="absmiddle"></a>

		<!--<img src="/img/arr_gray_box.gif" width="6" height="7"> 
		<a href="#" onclick="main_logout();" class="evlink">로그아웃</a>-->
	
		<a href="#" onClick="go_recv_msg();"><img id="head_msg_icon" src="/img/icon_memo_10.gif" border="0" alt="새 쪽지가 없습니다." valign="absmiddle" /></a>
	</td>
	</tr>
</table>
<!-- 로그인후 모습 end //-->

<? } else { ?>

<script language="javascript">
function main_login() {
	var f = document.loginfrm;
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
</script>

<!-- 로그인전 //-->
<table width="560" border="0" cellpadding="0" cellspacing="0">

<form id="loginfrm" name="loginfrm" method="post">
<input type="hidden" id="rurl" name="rurl" value="" />

	<tr>
		<td align="right"  class="evmem">
			<img src="/img/icon_key.gif" width="16" height="17" align="absmiddle">
			<input type="checkbox" id="idsave" name="idsave" value="Y" />
			ID저장&nbsp; <input name="id" id="id" type="text" value="<?=$_COOKIE['idsave']?>" class="logbox" style="width:110px;" tabindex="1" />
			<input name="pwd" id="pwd" type="password" class="logbox" style="width:110px; BACKGROUND-IMAGE: url(/img/pw.gif); BACKGROUND-REPEAT: no-repeat;" onFocus="this.style.backgroundImage = 'url(none)'" onKeyPress="javascript:if(event.keyCode==13) main_login();" tabindex="2" />
			<a href="#" onClick="main_login();"><img src="/img/btn_login.gif" alt="로그인하기" width="64" height="20" border="0" align="absmiddle" tabindex="3"></a>
			<!--
			<img src="/img/arr_gray_box.gif" width="6" height="7">  <a href="/member/real_chk.php"><b>무료회원가입</b></a>&nbsp; <img src="/img/arr_gray_box.gif" width="6" height="7"> <a href="#" onclick="find_IDPWD();" class="evlink">ID/PW?</a>
			-->
			
			<a href="/member/real_chk.php"><img src="/img/btn_join_member.gif" border="0"></a>
			<a href="#" onclick="find_IDPWD();" class="evlink"><img src="/img/btn_find_idpwd.gif" border="0"></a>
			
		</td>
	</tr>
</form>
</table>
<!-- 로그인전 end //-->

<? } ?>

