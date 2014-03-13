<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_categ_kwd.php
 * date   : 2008.10.23
 * desc   : "평가해주세요" 상단 카테고리/키워드
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";
$mainconn->open();


$str = "
<table width='645' height='178' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td valign='top'>
";
 
$all_style_kwd_list = $all_item_kwd_list = $all_theme_kwd_list = "";
foreach ( $P_CATEG as $k => $v ) {
	if ( $k == "T" ) {
		$ct_img = "list01_ov_02.gif"; $cb_img = "list_03.gif"; $co_img = "list_04.gif"; $cu_img = "list_05.gif"; $ca_img = "list_06.gif";
	} else if ( $k == "B" ) {
		$ct_img = "list_02.gif"; $cb_img = "list01_ov_03.gif"; $co_img = "list_04.gif"; $cu_img = "list_05.gif"; $ca_img = "list_06.gif";
	} else if ( $k == "O" ) {
		$ct_img = "list_02.gif"; $cb_img = "list_03.gif"; $co_img = "list01_ov_04.gif"; $cu_img = "list_05.gif"; $ca_img = "list_06.gif";
	} else if ( $k == "U" ) {
		$ct_img = "list_02.gif"; $cb_img = "list_03.gif"; $co_img = "list_04.gif"; $cu_img = "list01_ov_05.gif"; $ca_img = "list_06.gif";
	} else {
		$ct_img = "list_02.gif"; $cb_img = "list_03.gif"; $co_img = "list_04.gif"; $cu_img = "list_05.gif"; $ca_img = "list01_ov_06.gif";
	}

	$str .= "
	<div id='categ_{$k}_area' style='display:none;'>
	<table width='645' height='48' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td><a href='#' onClick=\"loadCategKwdList('','','',1,'A','','');\" onmouseover=\"chg_main_categ('');\"><img src='" . __HTTPURL__  . "/img/list_01.gif' width='113' height='48' border='0' /></a></td>
			<td><a href='#' onClick=\"loadCategKwdList('T','','',1,'A','','');\" onmouseover=\"chg_main_categ('T');\"><img src='" . __HTTPURL__  . "/img/{$ct_img}' width='87' height='48' border='0' /></td>
			<td><a href='#' onClick=\"loadCategKwdList('B','','',1,'A','','');\" onmouseover=\"chg_main_categ('B');\"><img src='" . __HTTPURL__  . "/img/{$cb_img}' width='89' height='48' border='0'></a></td>
			<td><a href='#' onClick=\"loadCategKwdList('O','','',1,'A','','');\" onmouseover=\"chg_main_categ('O');\"><img src='" . __HTTPURL__  . "/img/{$co_img}' width='130' height='48' border='0'></a></td>
			<td><a href='#' onClick=\"loadCategKwdList('U','','',1,'A','','');\" onmouseover=\"chg_main_categ('U');\"><img src='" . __HTTPURL__  . "/img/{$cu_img}' width='133' height='48' border='0'></a></td>
			<td><a href='#' onClick=\"loadCategKwdList('A','','',1,'A','','');\" onmouseover=\"chg_main_categ('A');\"><img src='" . __HTTPURL__  . "/img/{$ca_img}' width='93' height='48' border='0'></a></td>
		</tr>
	</table>
	";

	$sql = "select kwd_kind,kwd from tblKwd where kwd_status != 'N' and kwd_categ = '$k'";
	$res = $mainconn->query($sql);
	$style_kwd_list = $item_kwd_list = $theme_kwd_list = "";
	while ( $row = $mainconn->fetch($res) ) {
		$t_kwd_kind = trim($row['kwd_kind']);
		$t_kwd		= trim($row['kwd']);
		$t_kwd		= strip_tags($t_kwd);

		// javascript: loadCategKwdList(카테고리별,분류별,검색어,페이지,order)
		// order : A-최근등록순서, B-평가마감순서, C-랭킹순서
		if ( $t_kwd_kind == "S" ) {
			$style_kwd_list .= "<a href='#' onClick=\"loadCategKwdList('$k','$t_kwd_kind','$t_kwd',1,'A','','');\">$t_kwd</a>&nbsp;&nbsp; ";
		} else if ( $t_kwd_kind == "I" ) {
			$item_kwd_list .= "<a href='#' onClick=\"loadCategKwdList('$k','$t_kwd_kind','$t_kwd',1,'A','','');\">$t_kwd</a>&nbsp;&nbsp; ";
		} else if ( $t_kwd_kind == "T" ) {
			$theme_kwd_list .= "<a href='#' onClick=\"loadCategKwdList('$k','$t_kwd_kind','$t_kwd',1,'A','','');\">$t_kwd</a>&nbsp;&nbsp; ";
		}
	}

	$str .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='6'  background='/img/bar_sero_02.gif'>&nbsp;</td>
			<td align='center' valign='top'><br>
			<table width='600' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='80'><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon001.gif' align='absmiddle'> 스타일별</font></b></td>
					<td style='padding-top:8;padding-bottom:8' class=evmem>$style_kwd_list</td>
				</tr>
				<tr>
					<td height='1' colspan='2' background='/img/dot00.gif'></td>
				</tr>
				<tr>
					<td><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon002.gif' align='absmiddle'> 아이템별</font></b></td>
					<td style='padding-top:8;padding-bottom:8' class=evmem>$item_kwd_list</td>
				</tr>
				<tr>
					<td height='1' colspan='2' background='/img/dot00.gif'></td>
				</tr>
				<tr>
					<td><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon003.gif' align='absmiddle'> 테 마 별</font></b></td>
					<td style='padding-top:8;padding-bottom:8' class=evmem>$theme_kwd_list</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</div>
	";

	$all_style_kwd_list .= $style_kwd_list;
	$all_item_kwd_list .= $item_kwd_list;
	$all_theme_kwd_list .= $theme_kwd_list;

}	// foreach 종료

// 전체 키워드에 대한 레이어정의
$str .= "
<div id='categ__area' style='display:none;'>
<table width='645' height='48' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td><a href='#' onClick=\"loadCategKwdList('','','',1,'A','','');\" onmouseover=\"chg_main_categ('');\"><img src='" . __HTTPURL__  . "/img/list01_ov_01.gif' width='113' height='48' border='0' /></a></td>
		<td><a href='#' onClick=\"loadCategKwdList('T','','',1,'A','','');\" onmouseover=\"chg_main_categ('T');\"><img src='" . __HTTPURL__  . "/img/list_02.gif' width='87' height='48' border='0' /></td>
		<td><a href='#' onClick=\"loadCategKwdList('B','','',1,'A','','');\" onmouseover=\"chg_main_categ('B');\"><img src='" . __HTTPURL__  . "/img/list_03.gif' width='89' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCategKwdList('O','','',1,'A','','');\" onmouseover=\"chg_main_categ('O');\"><img src='" . __HTTPURL__  . "/img/list_04.gif' width='130' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCategKwdList('U','','',1,'A','','');\" onmouseover=\"chg_main_categ('U');\"><img src='" . __HTTPURL__  . "/img/list_05.gif' width='133' height='48' border='0'></a></td>
		<td><a href='#' onClick=\"loadCategKwdList('A','','',1,'A','','');\" onmouseover=\"chg_main_categ('A');\"><img src='" . __HTTPURL__  . "/img/list_06.gif' width='93' height='48' border='0'></a></td>
	</tr>
</table>
<table width='645' border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='6'  background='/img/bar_sero_02.gif'>&nbsp;</td>
		<td align='center' valign='top'><br>
		<table width='600' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='80'><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon001.gif' align='absmiddle'> 스타일별</font></b></td>
				<td style='padding-top:8;padding-bottom:8' class=evmem>$all_style_kwd_list</td>
			</tr>
			<tr>
				<td height='1' colspan='2' background='/img/dot00.gif'></td>
			</tr>
			<tr>
				<td><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon002.gif' align='absmiddle'> 아이템별</font></b></td>
				<td style='padding-top:8;padding-bottom:8' class=evmem>$all_item_kwd_list</td>
			</tr>
			<tr>
				<td height='1' colspan='2' background='/img/dot00.gif'></td>
			</tr>
			<tr>
				<td><b><font color='#333333'><img src='" . __HTTPURL__  . "/img/icon003.gif' align='absmiddle'> 테 마 별</font></b></td>
				<td style='padding-top:8;padding-bottom:8' class=evmem>$all_theme_kwd_list</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
";


$str .= "
		</td>
	</tr>
</table>
<script>chg_main_categ('');</script>
";

$mainconn->close();


echo $str;
?>