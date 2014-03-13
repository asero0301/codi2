<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/include/_foot.php
 * date   : 2008.11.21
 * desc   : 하단 정보, 팝업레이어, 쪽지 20초마다 체크(ajax)
 *******************************************************/
?>


						</td>
						<td width="10"></td>
						<td width="110" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="60">&nbsp;</td>
							</tr>
							<tr>
								<td height="61" valign="bottom" background="/img/bg_top_menu.gif">
								<table  height="53" border="0" cellpadding="0" cellspacing="0" bgcolor="D31A1C">
									<tr>
										<td width="1"></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td height="40" align="center" bgcolor="E8E8E8">
								<table width="90%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center"><a href="#" onClick="this.style.behavior='url(#default#homepage)'; this.setHomePage('http://www.coditop10.com/');"><img src="/img/icon_home.gif" alt="시작페이지로" width="21" height="21" border="0"></a></td>
										<td align="center"><a href="javascript:void(0)" onClick="window.external.AddFavorite(parent.location.href, document.title);"><img src="/img/icon_star.gif" alt="즐겨찾기추가" width="21" height="21" border="0"></a></td>
										<td align="center"><a href="/info/home_join.php"><img src="/img/icon_comm.gif" alt="관리자문의" width="21" height="21" border="0"></a></td>
									</tr>
								</table>
								</td>
							</tr>
							
							<tr>
								<td height="10" align="center">&nbsp;</td>
							</tr>
							
							
							<tr>
								<td align="left" valign="top">

<? if ( $_SESSION['mem_id'] && $_SESSION['mem_kind'] ) { ?>

<div id="floater" style="position:relative; z-index:100; top:10px; left:10px; width:110px">




	<?
	// 로그인할때 "아이디.info" 파일을 생성한다.
	//require_once $TPL_DIR."/myquick/".strtolower(substr($_SESSION['mem_id'],0,1))."/".$_SESSION['mem_id'].".info";
	echo make_quick_html($_SESSION['mem_id'], $_SESSION['mem_kind']);
	if ( strtolower($_SERVER['PHP_SELF']) == "/product/product_view.php" ) {
	?>
	
		<table height="70" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><a href="#" onClick="<? if ($prev_p_idx) echo "codi_view('$prev_p_idx');"; else echo "alert('이전 코디가 없습니다.');"; ?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image378','','/images/nextpre_ov_01.gif',1)"><img src="/images/nextpre_01.gif" name="Image378" width="33" height="54" border="0"></a></td>
				<td><a href="#" onClick="location.href='/product/product_list.php';" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image478','','/images/nextpre_ov_02.gif',1)"><img src="/images/nextpre_02.gif" name="Image478" width="34" height="54" border="0"></a></td>
				<td><a href="#" onClick="<? if ($next_p_idx) echo "codi_view('$next_p_idx');"; else echo "alert('다음 코디가 없습니다.');"; ?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image578','','/images/nextpre_ov_03.gif',1)"><img src="/images/nextpre_03.gif" name="Image578" width="33" height="54" border="0"></a></td>
			</tr>
		</table>

	<?
	}
	?>
	
</div>



<script language="javascript">
InitializeStaticMenu();
if ( document.getElementById("my_quick_grade_area") ) {
	document.getElementById("my_quick_grade_area").innerHTML = "<?=$_SESSION[mem_grade]?>";
}
if ( document.getElementById("my_quick_percent_area") ) {
	document.getElementById("my_quick_percent_area").innerHTML = "<?=$_SESSION[mem_percent]?>";
}
</script> 



<? } // 로그인 했을때 ?>

								</td>
							</tr>
							
						</table>
						</td>
					</tr>
				</table>
				</td>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="60">&nbsp;</td>
					</tr>
					<tr>
						<td height="61" background="/img/bg_top_menu.gif">&nbsp;</td>
					</tr>
					<tr>
						<td height="40" bgcolor="E8E8E8">&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="47"></td>
					</tr>
					<tr>
						<td height="1" background="/img/dot_foot_bg.gif"></td>
					</tr>
				</table>
				<p></p><p></p>
				</td>
				<td>
				<table width="100" height="30" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td></td>
					</tr>
				</table>
				<table id="Table_01" width="980" height="45" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><img src="/images/foot_menu_01.gif" width="305" height="45" alt=""></td>
						<td><a href="<?=$WEB_3RDBRAIN_URL?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image141','','/images/foot_menu_ov_02.gif',1)" target="_blank"><img src="/images/foot_menu_02.gif" name="Image141" width="70" height="45" border="0"></a></td>
						<td><a href="/info/info.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','..//images/foot_menu_ov_12.gif',1)"><img src="/images/foot_menu_12.gif" name="Image18" width="77" height="45" border="0"></a></td>
						<td><a href="/info/home_guide.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image142','','/images/foot_menu_ov_03.gif',1)"><img src="/images/foot_menu_03.gif" name="Image142" width="70" height="45" border="0"></a></td>
						<td><a href="/info/user_guide.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image143','','/images/foot_menu_ov_04.gif',1)"><img src="/images/foot_menu_04.gif" name="Image143" width="70" height="45" border="0"></a></td>
						<td><a href="/info/home_protect.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image144','','/images/foot_menu_ov_05.gif',1)"><img src="/images/foot_menu_05.gif" name="Image144" width="105" height="45" border="0"></a></td>
						<td><a href="/info/home_join.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image145','','/images/foot_menu_ov_06.gif',1)"><img src="/images/foot_menu_06.gif" name="Image145" width="81" height="45" border="0"></a></td>
						<td><a href="/info/home_join.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image146','','/images/foot_menu_ov_07.gif',1)"><img src="/images/foot_menu_07.gif" name="Image146" width="94" height="45" border="0"></a></td>
						<td><a href="/main.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image147','','/images/foot_menu_ov_08.gif',1)"><img src="/images/foot_menu_08.gif" name="Image147" width="40" height="45" border="0"></a></td>
						<td><a href="javascript:history.back();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image148','','/images/foot_menu_ov_09.gif',1)"><img src="/images/foot_menu_09.gif" name="Image148" width="33" height="45" border="0"></a></td>
						<td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image149','','/images/foot_menu_ov_10.gif',1)"><img src="/images/foot_menu_10.gif" name="Image149" height="45" border="0"></a></td>
					</tr>
				</table>
				<table width="980" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="/img/copyright.gif" width="858" height="84"></td>
					</tr>
				</table>
				</td>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="47"></td>
					</tr>
					<tr>
						<td height="1" background="/img/dot_foot_bg.gif"></td>
					</tr>
				</table>
				<p></p>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
















<!-- 레이어 팝업 영역 -->
<div id="PopLayerArea"></div>
<script language="javascript" src="/js/popup.js"></script>
<script language="javascript">
if ( popup_getCookie("layerpopup") != "done" ) popLayer('');
</script>

<!-- 쪽지 프레임 -->
<? if ( $_SESSION['mem_id'] != "" ) { ?>
	<iframe name="msg_frame" src="/msg/msg_frame.php" width="0" height="0"></iframe>
<? } ?>

<form name="popmsgfrm" id="popmsgfrm" method="post">
<input type="hidden" id="sel_id" name="sel_id" value="" />
</form>

</body>
</html>


<?
/*
if ( $_SERVER['REMOTE_ADDR'] == "61.102.154.40" ) {

	echo "*********** GET ***********<br>";
	foreach ( $_GET as $k => $v ) {
	echo "\$_GET[$k] : $v <br>";
	}
	echo "***************************<br><br>";

	echo "*********** POST ***********<br>";
	foreach ( $_POST as $k => $v ) {
	echo "\$_POST[$k] : $v <br>";
	}
	echo "***************************<br><br>";

	echo "*********** FILES ***********<br>";
	foreach ( $_FILES as $k => $v ) {
	echo "\$_FILES[$k] : $v <br>";
	}
	echo "<br>".print_r($_FILES)."<br>";
	echo "<br> size : ".sizeof($_FILES[upfile][size])."<br>";
	echo "***************************<br><br>";

	echo "*********** _REQUEST ***********<br>";
	foreach ( $_REQUEST as $k => $v ) {
	echo "\$_REQUEST[$k] : $v <br>";
	}
	echo "***************************<br><br>";

	echo "*********** COOKIE ***********<br>";
	foreach ( $_COOKIE as $k => $v ) {
	echo "\$_COOKIE[$k] : $v <br>";
	}
	echo "***************************<br><br>";

	echo "*********** SESSION ***********<br>";
	foreach ( $_SESSION as $k => $v ) {
	echo "\$_SESSION[$k] : $v <br>";
	}
	echo "***************************<br><br>";

	echo "*********** SERVER ***********<br>";
	foreach ( $_SERVER as $k => $v ) {
	echo "\$_SERVER[$k] : $v <br>";
	}
	echo "***************************<br><br>";

}
*/
?>