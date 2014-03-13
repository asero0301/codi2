<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/content/banner_write.php
 * date   : 2008.08.25
 * desc   : Admin banner write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
//referer_chk();

$mode		= trim($_REQUEST['mode']);
$banner_idx	= trim($_REQUEST['sel_idx']);

$mainconn->open();

if ( $mode == "E" ) {
	$title_tail = "수정";
	
	$sql = "select * from tblBanner where banner_idx = $banner_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$banner_url			= trim($row['banner_url']);
	$banner_area		= trim($row['banner_area']);
	$banner_file		= trim($row['banner_file']);
	$banner_status		= trim($row['banner_status']);
	$banner_reg_dt		= trim($row['banner_reg_dt']);
	
} else {
	$title_tail = "추가";
}

require_once "../_top.php";
?>

<script language="JavaScript">
function insertPost() {
	var f = document.frm;
	f.encoding = "multipart/form-data";
	f.action = "banner_write_ok.php";
	f.submit();
}

function addFileField() {
	upload_list = document.getElementById('uploads');
	list_item = document.createElement("LI");
	file_field = document.createElement("INPUT");
	file_field.type = "file";
	file_field.name = "upfile[]";
	list_item.appendChild(file_field);
	upload_list.appendChild(list_item);
}

function chgBannerAreaConfig(id) {
	obj = document.getElementById("cb_"+id);
	lay_obj = document.getElementById("cb_"+id+"_layer");
	if ( obj.checked == true ) {
		lay_obj.style.display = "block";
	} else {
		obj2 = eval("document.frm.rd_"+id);
		for ( var i=0; i<obj2.length; i++ ) {
			obj2[i].checked = false;
		}
		lay_obj.style.display = "none";
	}
}
</script>

<form id="frm" name="frm" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="sel_idx" name="sel_idx" value="<?=$banner_idx?>">
<input type="hidden" id="old_file_list" name="old_file_list" value="<?=$banner_file?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 배너관리 <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> URL&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="banner_url" name="banner_url" value="<?=$banner_url?>" size="50"></strong></font>
		</td>
	</tr>
	
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 첨부파일&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<a href="#" onclick="addFileField()">첨부파일 추가</a> <font color="red">(가로 200px, 세로 75px 에 최적화되어 있습니다.)</font>
			<ol id="uploads"></ol>
			<?
			if ( $banner_file ) {
				$arr_file = explode(";", $banner_file);
				foreach ( $arr_file as $k => $v ) {
					if ( trim($v) == "" ) continue;
					$t_banner_file = trim($v);
					$file_disp .= "<a href='/common/download.php?filename=$t_banner_file&savename=$t_banner_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
				}
				echo $file_disp;
			}
			?>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 노출옵션&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			    <input type="checkbox" id="cb_main_area" name="cb_main_area" value="MAIN" <? if ( strpos($banner_area,"MAIN") ) echo " checked"; ?> onClick="chgBannerAreaConfig('main_area');"> 메인 영역

				<div id="cb_main_area_layer" style="display:none;">
				&nbsp;&nbsp;
				<input type="radio" id="rd_main_area" name="rd_main_area" value="MAINT" <? if ( strpos($banner_area,"MAINT") ) echo " checked"; ?>> 메인 상단
				<input type="radio" id="rd_main_area" name="rd_main_area" value="MAINB" <? if ( strpos($banner_area,"MAINB") ) echo " checked"; ?>> 메인 하단
				<input type="radio" id="rd_main_area" name="rd_main_area" value="MAINL" <? if ( strpos($banner_area,"MAINL") ) echo " checked"; ?>> 메인 좌측
				<input type="radio" id="rd_main_area" name="rd_main_area" value="MAINR" <? if ( strpos($banner_area,"MAINR") ) echo " checked"; ?>> 메인 우측
				</div>

				<p>

				<input type="checkbox" id="cb_codi_area" name="cb_codi_area" value="CODI" <? if ( strpos($banner_area,"CODI") ) echo " checked"; ?> onClick="chgBannerAreaConfig('codi_area');"> 코디 영역

				<div id="cb_codi_area_layer" style="display:none;">
				&nbsp;&nbsp;
				<input type="radio" id="rd_codi_area" name="rd_codi_area" value="CODIT" <? if ( strpos($banner_area,"CODIT") ) echo " checked"; ?>> 코디 상단
				<input type="radio" id="rd_codi_area" name="rd_codi_area" value="CODIB" <? if ( strpos($banner_area,"CODIB") ) echo " checked"; ?>> 코디 하단
				<input type="radio" id="rd_codi_area" name="rd_codi_area" value="CODIL" <? if ( strpos($banner_area,"CODIL") ) echo " checked"; ?>> 코디 좌측
				<input type="radio" id="rd_codi_area" name="rd_codi_area" value="CODIR" <? if ( strpos($banner_area,"CODIR") ) echo " checked"; ?>> 코디 우측
				</div>

				<p>

				<input type="checkbox" id="cb_board_area" name="cb_board_area" value="BOARD" <? if ( strpos($banner_area,"BOARD") ) echo " checked"; ?> onClick="chgBannerAreaConfig('board_area');"> 게시판 영역

				<div id="cb_board_area_layer" style="display:none;">
				&nbsp;&nbsp;
				<input type="radio" id="rd_board_area" name="rd_board_area" value="BOARDT" <? if ( strpos($banner_area,"BOARDT") ) echo " checked"; ?>> 게시판 상단
				<input type="radio" id="rd_board_area" name="rd_board_area" value="BOARDB" <? if ( strpos($banner_area,"BOARDB") ) echo " checked"; ?>> 게시판 하단
				<input type="radio" id="rd_board_area" name="rd_board_area" value="BOARDL" <? if ( strpos($banner_area,"BOARDL") ) echo " checked"; ?>> 게시판 좌측
				<input type="radio" id="rd_board_area" name="rd_board_area" value="BOARDR" <? if ( strpos($banner_area,"BOARDR") ) echo " checked"; ?>> 게시판 우측
				</div>

				<p>

				<input type="checkbox" id="cb_join_area" name="cb_join_area" value="JOIN" <? if ( strpos($banner_area,"JOIN") ) echo " checked"; ?> onClick="chgBannerAreaConfig('join_area');"> 가입/로그인 영역

				<div id="cb_join_area_layer" style="display:none;">
				&nbsp;&nbsp;
				<input type="radio" id="rd_join_area" name="rd_join_area" value="JOINT" <? if ( strpos($banner_area,"JOINT") ) echo " checked"; ?>> 가입/로그인 상단
				<input type="radio" id="rd_join_area" name="rd_join_area" value="JOINB" <? if ( strpos($banner_area,"JOINB") ) echo " checked"; ?>> 가입/로그인 하단
				<input type="radio" id="rd_join_area" name="rd_join_area" value="JOINL" <? if ( strpos($banner_area,"JOINL") ) echo " checked"; ?>> 가입/로그인 좌측
				<input type="radio" id="rd_join_area" name="rd_join_area" value="JOINR" <? if ( strpos($banner_area,"JOINR") ) echo " checked"; ?>> 가입/로그인 우측
				</div>

				<p>

				<input type="checkbox" id="cb_etc_area" name="cb_etc_area" value="ETC" <? if ( strpos($banner_area,"ETC") ) echo " checked"; ?> onClick="chgBannerAreaConfig('etc_area');"> 기타 영역

				<div id="cb_etc_area_layer" style="display:none;">
				&nbsp;&nbsp;
				<input type="radio" id="rd_etc_area" name="rd_etc_area" value="ETCT" <? if ( strpos($banner_area,"ETCT") ) echo " checked"; ?>> 가입/로그인 상단
				<input type="radio" id="rd_etc_area" name="rd_etc_area" value="ETCB" <? if ( strpos($banner_area,"ETCB") ) echo " checked"; ?>> 가입/로그인 하단
				<input type="radio" id="rd_etc_area" name="rd_etc_area" value="ETCL" <? if ( strpos($banner_area,"ETCL") ) echo " checked"; ?>> 가입/로그인 좌측
				<input type="radio" id="rd_etc_area" name="rd_etc_area" value="ETCR" <? if ( strpos($banner_area,"ETCR") ) echo " checked"; ?>> 가입/로그인 우측
				</div>

			</font>
		</td>
	</tr>
</table>


<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td align="center" height="23">
		<input type="button" value="저  장" onClick="insertPost();">
	</td>
  </tr>
</table>



</form>

<script language="javascript">
function initAreaLayer(str) {
	if ( str.indexOf("MAIN") > -1 ) {
		obj = document.getElementById("cb_main_area_layer");
		obj.style.display = "block";
	}
	if ( str.indexOf("CODI") > -1 ) {
		obj = document.getElementById("cb_codi_area_layer");
		obj.style.display = "block";
	}
	if ( str.indexOf("BOARD") > -1 ) {
		obj = document.getElementById("cb_board_area_layer");
		obj.style.display = "block";
	}
	if ( str.indexOf("JOIN") > -1 ) {
		obj = document.getElementById("cb_join_area_layer");
		obj.style.display = "block";
	}
	if ( str.indexOf("ETC") > -1 ) {
		obj = document.getElementById("cb_etc_area_layer");
		obj.style.display = "block";
	}
}
initAreaLayer('<?=$banner_area?>');
</script>

<?php 

$mainconn->close();

require_once "../_bottom.php";

?> 