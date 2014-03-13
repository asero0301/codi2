<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/contents/popup_list.php
 * date   : 2008.08.25
 * desc   : Admin popup list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();


$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblPopup $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd";
$orderby = " order by pop_reg_dt desc ";

$sql = "select * from tblPopup $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$pop_idx		= trim($row['pop_idx']);
	$pop_title		= trim($row['pop_title']);
	$pop_start_dt	= trim($row['pop_start_dt']);
	$pop_end_dt		= trim($row['pop_end_dt']);
	$pop_kind		= trim($row['pop_kind']);
	$pop_display_opt= trim($row['pop_display_opt']);
	$pop_today_opt	= trim($row['pop_today_opt']);
	$pop_width		= trim($row['pop_width']);
	$pop_height		= trim($row['pop_height']);
	$pop_top		= trim($row['pop_top']);
	$pop_left		= trim($row['pop_left']);
	$pop_content	= trim($row['pop_content']);
	$pop_file		= trim($row['pop_file']);
	$pop_status		= trim($row['pop_status']);
	$pop_reg_dt		= trim($row['pop_reg_dt']);

	$pop_title	= strip_str($pop_title);
	$pop_title	= cutStringHan($pop_title,40);

	$pop_kind_str = ( $pop_kind == "L" ) ? "레이어" : "윈도우";
	$pop_display_opt_str = ( $pop_display_opt == "M" ) ? "메인" : "서브";
	$pop_today_opt_str = ( $pop_today_opt == "Y" ) ? "적용" : "미적용";

	$pop_status_str = ( $pop_status == "Y" ) ? "적용" : "미적용";
	$btn_str = ( $pop_status == "Y" ) ? "미적용" : "적용";


 

	$contents = "";
	if ( $pop_file ) {
		$file_url = $UP_URL."/attach/".$pop_file;
		if ( substr($pop_file, -3) == "swf" ) {
			$contents = "
				<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='$pop_width' height='$pop_height'>
					<param name='movie' value='$file_url' />
					<param name='quality' value='high' />
					<embed src='$file_url' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$pop_width' height='$pop_height'></embed>
				</object>
				";
		} else {
			$contents = "<img src='$file_url' border='0'>";
		}
	} else {
		$contents = $pop_content;
	}

	${'theLayer_'.$pop_idx} = "
		<div id='theLayer_${pop_idx}' style='width:${pop_width}px; position:absolute; left:${pop_left}px; top:${pop_top}px; z-index:${pop_idx}; visibility:visible; display:none;'>
		<table border='0' width='$pop_width' bgcolor='#424242' cellspacing='0' cellpadding='5'>
			<tr>
				<td width='100%'>
				
				<table border='0' width='100%' cellspacing='0' cellpadding='0' height='36'>
					<tr>
						<td><font color='white'>$pop_title</font></td>
					</tr>
					<tr>
						<td id='titleBar' style='cursor:move' width='90%'>
							<ilayer width='100%' onSelectStart='return false'>
							<layer width='100%' onMouseover='isHot=true;if (isN4) ddN4(theLayer_${pop_idx})' onMouseout='isHot=false' z-index='$pop_idx'>
							
							<!-- 팝업 내용 -->
							$contents
							
							</layer>
							</ilayer>
						</td>
					</tr>

					<tr>
						<td height='5'>
					</td>
		  
					</tr>
					<tr>
						<td align=center width='$pop_width'>
							<INPUT TYPE='checkbox' NAME='popupCookie_${pop_idx}' onclick=\"popup_setCookie('popup_${pop_idx}','done',1);hideMe();\" style='cursor:hand' valign='top' width='20%' align='right'> <FONT COLOR='#FFFFFF'>하루동안 이창 보이지 않기</FONT>
							&nbsp;&nbsp;
							<a href='#' onClick='hideMe();return false'><font color='#ffffff'  face='arial'  style='text-decoration:none'>닫기X</font></a>
						</td>
					</tr>
				</table>
				
				</td>
			</tr>
		</table>
		</div>
		";

	//echo ${'theLayer_'.$pop_idx};
	
	$file_disp = "";
	if ( $pop_file ) {
		$arr_file = explode(";", $pop_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_pop_file = trim($v);
			$file_disp .= "<a href='/common/download.php?filename=$t_pop_file&savename=$t_pop_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
		}
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$pop_idx'>
		  </td>
		  <td align='left' bgcolor='#FFFFFF'><a href=\"javascript:pop_test('$pop_idx');\">$pop_title</a></td>
		  <td align='center'  bgcolor='#FFFFFF'>$pop_start_dt ~<br>$pop_end_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>$pop_kind_str</td>
   		  <td align='center' bgcolor='#FFFFFF'class='stext'>$pop_display_opt_str</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>$pop_today_opt_str</td>
		  <td align='center'  bgcolor='#FFFFFF'>$pop_width ~<br>$pop_height</td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$pop_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='수정' onClick='editContent(\"$pop_idx\");'>
			<input type='button' value='$btn_str' onClick='editStatusContent(\"$pop_idx\",\"$pop_status\");'>
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='9' ></td>
		</tr>
		";

	//$LIST .= ${'theLayer_'.$pop_idx};
	//$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='9' align='center' bgcolor='#FFFFFF'>결과가 없습니다.</td></tr>";
}

$total_block = ceil($total_page/$ADMIN_PAGE_BLOCK);
$block = ceil($page/$ADMIN_PAGE_BLOCK);
$first_page = ($block-1)*$ADMIN_PAGE_BLOCK;
$last_page = $block*$ADMIN_PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$mainconn->close();

require_once "../_top.php";
?> 

<script language="javascript" src="/js/ajax.js"></script>
<script language="javascript">
function pop_test(pop_idx) {
	//theLayer.style.display = "none";
	popLayer(pop_idx);
}
function goSearch() {
	var f = document.frm;
	f.action = "<?=$_SERVER['PHP_SELF']?>";
	f.submit();
}

function editStatusContent(idx, status) {
	if ( !confirm("선택된 항목의 상태값을 변경할까요?") ) { return; }

	if ( idx == "" ) {	// 전체 삭제
		var str = "";
		for (i = 0; document.getElementById('frm').elements[i]; i++) {
			if (document.getElementById('frm').elements[i].name == "itemchk") {
				if (document.getElementById('frm').elements[i].checked == true) {
					str += document.getElementById('frm').elements[i].value+";";
				}
			}
		}
	} else {	// 개별 삭제
		str = idx;
	}

	if ( str == "" || str == undefined ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		var f = document.frm;
		f.sel_idx.value = str;
		f.pop_status.value = status;
		f.mode.value = "A";
		f.action = "popup_write_ok.php";
		f.submit();
	}
}

function editContent(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "popup_write.php";
	f.submit();
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ 팝업관리</font></b>  </td>
		<td width="50%" align="right" class="tienom">총 <?=$total_record?>개의 레코드가 있습니다.</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="pop_status" name="pop_status" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="28" align="center" class="join"><font color="#000000"><b>전체</b></font></td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>제목</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>기간</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>팝업구분</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>위치</b></font></td>
					  <td width="80" align="center" class="stextbold"><font color="#000000"><b>오늘만적용</b></font></td>
					  <td width="100" align="center" class="stextbold"><font color="#000000"><b>가로/세로</b></font></td>
					  <td width="150" align="center" class="stextbold"><font color="#000000"><b>등록일</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">처리</font></b></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="9" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      
	  
	  <table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="790" valign="bottom">
			<input type="button" value="전체선택" onClick="checkAll();">
			<input type="button" value="전체해제" onClick="checkFree();">
			<input type="button" value="선택적용" onClick="editStatusContent('','N');">
		  </td>
		  <td align="right">
			<input type="button" value="생성하기" onClick="location.href='popup_write.php';">
		  </td>
        </tr>
      </table>
	

      <br>

<? if ( $total_record != 0 ) { ?>
      <table width="980" border="0" cellspacing="0" cellpadding="0" align=center>
        <tr>
          <td width="100"><img src="../board_img/text_page.gif" width="35" height="13" align="absmiddle"><span class="date"><?=$page?>/<?=$total_page?></span></td>
          <td align="center">

		  <?php
			echo admin_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str); ?>
		  
		  </td>
          <td width="100" align="right"> </td>
        </tr>
      </table>
<? } ?>

      <table width="100" height="18" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="980" border="0" cellpadding="0" cellspacing="1" bgcolor="E5E5E5" align=center>
        <tr>
          <td height="27" bgcolor="F7F7F7" style="padding-left:4;padding-right:4">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
				<td width="120" style="padding-top:1">
					<select id="key" name="key" class="goodcss">
						<option value="">선택</option>
						<option value="pop_title" <? if ( $key == "pop_title" ) echo " selected"; ?>>제목</option>
						<option value="pop_content" <? if ( $key == "pop_content" ) echo " selected"; ?>>내용</option>
					</select>
				</td>
                <td><input type="text" id="kwd" name="kwd" value="<?=$kwd?>" class="goodcss" onFocus="document.frm.kwd.value='';" onKeyPress="javascript:if(event.keyCode==13) goSearch();">
                </td>
                <td width="70" align="right"><a href="javascript:goSearch();"><img src="../board_img/btn_search.gif" width="66" height="19" border="0"></a></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br>

</form>


<!-- 레이어 팝업 내용 시작 -->
<!--
<div id="theLayer" style="width:250px; position:absolute; left:100px; top:100px; z-index:1; visibility:visible; display:none;">
<table border="0" width="250" bgcolor="#ffffff" cellspacing="0" cellpadding="5" background="/img/bg_black.gif">
	<tr>
		<td width="100%">
		
		<table border="0" width="100%" cellspacing="0" cellpadding="0" height="36">
			<tr>
				<td><font color="white">여기는 제목이 들어갑니다.</font></td>
			</tr>
			<tr>
				<td id="titleBar" style="cursor:move" width="90%">
					<ilayer width="100%" onSelectStart="return false">
					<layer width="100%" onMouseover="isHot=true;if (isN4) ddN4(theLayer)" onMouseout="isHot=false" z-index="1">
					
					<img src="/img/pop_open.gif" border="0">
					
					</layer>
					</ilayer>
				</td>
	        </tr>

			<tr>
				<td height="5">
			</td>
  
			</tr>
			<tr>
				<td align=center width="250">
					<INPUT TYPE="checkbox" NAME="popupCookie" onclick="popup_setCookie('popup','done',1);hideMe();" style="cursor:hand" valign="top" width="20%" align="right"> <FONT COLOR="#FFFFFF">하루동안 이창 보이지 않기</FONT>
					&nbsp;&nbsp;
					<a href="#" onClick="hideMe(); return false"><font color='#ffffff'  face='arial'  style="text-decoration:none">닫기X</font></a>
				</td>
			</tr>
        </table>
		
		</td>
	</tr>
</table>
</div>
-->

<!-- 레이어 팝업 내용 끝 -->

<?php 
require_once "../_bottom.php";

?> 