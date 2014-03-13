<?php
$s_key = trim($_REQUEST['s_key']);
$keyword = trim($_REQUEST['keyword']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title><?=$TITLE?></title>
<link rel = StyleSheet HREF='/css/style.css' type='text/css' title='thehigh CSS'>
<SCRIPT LANGUAGE="JavaScript" SRC="/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="/js/common.js"></SCRIPT>
<script language="javascript" src="/js/lightbox.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="/js/codi.js"></SCRIPT>
<script language="javascript" src="/js/Floating.js"></script>
<script language="JavaScript" type="text/JavaScript" src="/js/FlashLink.js"></script>
<script language="JavaScript">
<!--
self.onError=null;
currentX = currentY = 0; 
whichIt = null; 
lastScrollX = 0; lastScrollY = 0;
NS = (document.layers) ? 1 : 0;
IE = (document.all) ? 1: 0;
<!-- STALKER CODE -->

function heartBeat() {
	if(IE) { 
		diffY = document.body.scrollTop; 
		diffX = 0; 
	}
	if(NS) { diffY = self.pageYOffset; diffX = self.pageXOffset; }
	if(diffY != lastScrollY) {
		percent = .1 * (diffY - lastScrollY);
		if(percent > 0) percent = Math.ceil(percent);
		else percent = Math.floor(percent);
		if(IE) document.all.floater.style.pixelTop += percent;
		if(NS) document.floater.top += percent; 
		lastScrollY = lastScrollY + percent;
	}
	if(diffX != lastScrollX) {
		percent = .1 * (diffX - lastScrollX);
		if(percent > 0) percent = Math.ceil(percent);
		else percent = Math.floor(percent);
		if(IE) document.all.floater.style.pixelLeft += percent;
		if(NS) document.floater.top += percent;
		lastScrollY = lastScrollY + percent;
	} 
} 

//if(NS || IE) action = window.setInterval("heartBeat()",1);
left_px = "";
if ( IE ) {
	left_px = '-288';
} else {
	left_px = '333';
}
//-->
</script>


</head>

<body onLoad="MM_preloadImages('images/nextpre_ov_01.gif','images/nextpre_ov_02.gif','images/foot_menu_ov_02.gif','images/foot_menu_ov_03.gif','images/foot_menu_ov_04.gif','images/foot_menu_ov_05.gif','images/foot_menu_ov_06.gif','images/foot_menu_ov_07.gif','images/foot_menu_ov_08.gif','images/foot_menu_ov_09.gif','images/foot_menu_ov_10.gif');">

<form id="headfrm" name="headfrm" method="post">
<input type="hidden" id="rurl" name="rurl" value="" />
<input type="hidden" id="session_id" name="session_id" value="<?=$_SESSION['mem_id']?>" />
<input type="hidden" id="session_name" name="session_name" value="<?=$_SESSION['mem_name']?>" />
</form>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
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
				<td width="980">
				<table width="980" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="860" valign="top">
						<table width="860" height="60" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="260" valign="bottom"><a href="/main.php"><img src="/img/logo_ori.jpg" border="0"></a></td>
								<td align="right" valign="bottom">


<!-- 로그박스 start //-->
<?// require_once "/include/_log.php"; ?>
<? require_once "_log.php"; ?>
<!-- 로그박스 end //-->			  
				  

								</td>
							</tr>
						</table>
						<table width="860" height="61" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<script language="javascript">flashToJS('860','61','/img/global_menu.swf','');</script>
								</td>
							</tr>
						</table>
						<table width="100%" height="40" border="0" cellpadding="0" cellspacing="0" bgcolor="E8E8E8">
							<tr>
								<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="240">

										<!-- 탑부분 텍스트형 광고배너 start //-->
										<table width="202" height="40" border="0" cellpadding="0" cellspacing="0" background="/img/banner_top_text.gif">
											<tr>
												<td align="center" class="evgray" style="PADDING-top: 4px;"><a href="#"><b><font color="#000000">평가만 하면</font></b> 경품을<br>
										받을 수 있는 <font color="#FF3300"><b>코디탑텐</b></font></a></td>
											</tr>
										</table>
										<!-- 탑부분 텍스트형 광고배너 end //-->				  
					  
										</td>

										<td align="right" class="evgray">
					  


<!-- 탑부분 검색 start //-->
<!-- Search -->
<div id="searchWrap">
<table border="0" cellspacing="0" cellpadding="0">
<form name="MainSearchFrm" autocomplete="off" action="/product/product_list.php">
	<tr>
		<td width="80"><img src="/img/icon_search.gif" width="78" height="20" align="absmiddle"></td>

		<td width="18" align="center"><input type="radio" name="s_key" id="s_key" value="S" <?if ( $s_key == "S" ) echo " checked"; ?> /> </td>
		<td width="22" class="evgray">샵</td>
		
		<td width="18" align="center"><input type="radio" name="s_key" id="s_key" value="P" <?if ( $s_key == "P" ) echo " checked"; ?> /></td>
		<td width="30" class="evgray">제목</td>
		
		<td width="18"><input type="radio" name="s_key" id="s_key" value="A" <?if ( $s_key != "S" && $s_key != "P"  && $s_key != "K" ) echo " checked"; ?> /></td>

		<td width="46" class="evgray">샵+제목</td>
		
		<td width="18"><input type="radio" name="s_key" id="s_key" value="K" <?if ( $s_key == "K" ) echo " checked"; ?> /></td>
		<td width="45" class="evgray">키워드</td>
		
		<td width="205"><input type="text" id="keyword" name="keyword" class="logbox" OnKeyUp="searchRequest();" onKeyPress="if (event.keyCode == 13) AjaxSearch();" style="width:200px;" tabindex="5" /></td>

		<td><a href="#" onClick="AjaxSearch();"><img src="/img/btn_search.gif" width="70" height="20" border="0" align="absmiddle" alt="검색" tabindex="5" /></a></td>
		<td width="10"></td>
	</tr>
</form>
</table>
</div>
<!--
<div style="position:relative; z-index:222;">
	<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:absolute; z-index:333; top:1px; left:-288px; width:205px; display:block;"></div>
</div>
-->
<div style="position:relative; z-index:222;">
	<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:absolute; z-index:333; top:1px; width:205px; display:none;"></div>
</div>
<script>SearchResultArea.style.left = left_px;</script>
<!--
<div style="position:relative; margin:0 0 0 0;">
	<div id="SearchResultArea" style='position:absolute;z-index:1;margin:20 0 3 55;display:;'>
		<iframe id="hFrame" name="hFrame" src="about:blank" style="width:280px;display:block;" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
-->
<!--
<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:relative; z-index:200; top:178px; left:657px; width:205px; visibility: show;"></div>-->


<!--
<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='296' colspan='9' bgcolor="yellow">&nbsp;</td>
		<td width='205' align="center" bgcolor="red">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
			<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:relative; z-index:200; top:10px; left:-75px; width:205px"></div>
					</td>
				</tr>
			</table>
		</td>
		<td width='83' colspan='2'>&nbsp;</td>
	</tr>
</table>
-->

<!--
<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="display:none;">
<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='296' colspan='9'>&nbsp;</td>
		<td width='205' bgcolor='gray'>aaa</td>
		<td width='83' colspan='2'>&nbsp;</td>
	</tr>
</table>
</div>
-->

<!--
<div id="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:relative; left:10px; top:50px; visibility:hidden;">
 <div style="position:absolute; z-index:440;">
 </div>
</div>
-->
<!-- 탑부분 검색 end //-->			  
					  
										</td>
									</tr>
								</table>
								</td>
							</tr>
						</table>

						<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td></td>
							</tr>
						</table>




<!--
<div id="SearchResultArea" name="SearchResultArea" onmouseover="showArea();" onmouseout="hiddenArea();" style="position:relative; z-index:200; top:1px; left:-77px; width:205px; visibility: hidden;">
<div STYLE='position: absolute; z-index: 199;'>
</div>
</div>
-->

