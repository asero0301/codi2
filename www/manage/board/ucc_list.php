<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/ucc_list.php
 * date   : 2008.08.22
 * desc   : Admin ucc list
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
$ucc_categ = trim($_REQUEST['ucc_categ']);

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

if ( $ucc_categ != "" ) {
	$cond .= " and ucc_categ = '$ucc_categ' ";
}

// record count
$sql = "select count(*) from tblUcc $cond ";
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
$orderby = " order by ucc_reg_dt desc ";

$sql = "select *,(select mem_name from tblMember where mem_id=tblUcc.mem_id) as mem_name from tblUcc $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$ucc_idx	= trim($row['ucc_idx']);
	$ucc_categ	= trim($row['ucc_categ']);
	$mem_id		= trim($row['mem_id']);
	$mem_name	= trim($row['mem_name']);
	$ucc_title	= trim($row['ucc_title']);
	$ucc_file	= trim($row['ucc_file']);
	$ucc_view	= trim($row['ucc_view']);
	$ucc_ip		= trim($row['ucc_ip']);
	$ucc_reg_dt	= trim($row['ucc_reg_dt']);

	$ucc_title	= strip_str($ucc_title);
	$ucc_title	= cutStringHan($ucc_title,40);
	
	$file_disp = "";
	if ( $ucc_file ) {
		$arr_file = explode(";", $ucc_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_ucc_file = trim($v);
			$file_disp .= "<a href='/common/download.php?filename=$t_ucc_file&savename=$t_ucc_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
		}
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$ucc_idx'>
		  </td>
		  <td align='left' bgcolor='#FFFFFF'><a href='ucc_view.php?sel_idx=$ucc_idx'>$ucc_title</a></td>
		  <td align='left' bgcolor='#FFFFFF'><a href=\"javascript:pop_member_info('$mem_id');\">$mem_name</a></td>
		  <td align='center'  bgcolor='#FFFFFF'>$ucc_view</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='#'>$file_disp</a></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$ucc_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='수정' onClick='editBoard(\"$ucc_idx\");'>
			<input type='button' value='삭제' onClick='delBoard(\"$ucc_idx\");'>
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='7' ></td>
		</tr>
		";
	//$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='7' align='center' bgcolor='#FFFFFF'>결과가 없습니다.</td></tr>";
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

<script language="javascript">
function goSearch() {
	var f = document.frm;
	f.action = "<?=$_SERVER['PHP_SELF']?>";
	f.submit();
}

function delBoard(idx) {
	if ( !confirm("선택된 항목을 삭제하시겠습니까?") ) { return; }

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
		f.mode.value = "D";
		f.action = "ucc_write_ok.php";
		f.submit();
	}
}

function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "ucc_write.php";
	f.submit();
}

function goSubUcc(ucc_categ) {
	location.href = "ucc_list.php?ucc_categ="+ucc_categ;
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ 코디 UCC</font></b>  </td>
		<td width="50%" align="right" class="tienom">총 <?=$total_record?>개의 레코드가 있습니다.</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">
<input type="hidden" id="ucc_categ" name="ucc_categ" value="<?=$ucc_categ?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23">
			<input type="button" value="전체보기" onClick="goSubUcc('');" <? if ( $ucc_categ == "" ) echo " disabled"; ?>>
			<input type="button" value="내 코디를 평가해 주세요" onClick="goSubUcc('A');" <? if ( $ucc_categ == "A" ) echo " disabled"; ?>>
			<input type="button" value="어떤 코디가 좋을까요?" onClick="goSubUcc('B');" <? if ( $ucc_categ == "B" ) echo " disabled"; ?>>
			<input type="button" value="코디를 제안드려요" onClick="goSubUcc('C');" <? if ( $juducc_categge == "C" ) echo " disabled"; ?>>
		</td>
	</tr>
</table>

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="28" align="center" class="join"><font color="#000000"><b>전체</b></font></td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>제목</b></font></td>
					  <td width="100" align="center" class="stextbold"><font color="#000000"><b>글쓴이</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>조회수</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>첨부파일</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>등록일</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">처리</font></b></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="6" align="center" bgcolor="#D4D4D4" ></td>
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
			<input type="button" value="선택삭제" onClick="delBoard('');">
		  </td>
		  <td align="right">
			<input type="button" value="글쓰기" onClick="location.href='ucc_write.php';">
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
						<option value="ucc_title" <? if ( $key == "ucc_title" ) echo " selected"; ?>>제목</option>
						<option value="ucc_content" <? if ( $key == "ucc_content" ) echo " selected"; ?>>내용</option>
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





<?php 
require_once "../_bottom.php";

?> 