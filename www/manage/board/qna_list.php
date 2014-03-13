<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/qna_list.php
 * date   : 2008.08.28
 * desc   : Admin qna list
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
$qna_categ = trim($_REQUEST['qna_categ']);

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

if ( $qna_categ != "" ) {
	$cond .= " and qna_categ = '$qna_categ' ";
	$qna_categ_str = $QNA[$qna_categ];
} else {
	$qna_categ_str = "전체";
}

// record count
$sql = "select count(*) from tblQna $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd&qna_categ=$qna_categ";
$orderby = " order by qna_f_idx desc, qna_depth asc ";

$sql = "select *,(select mem_name from tblMember where mem_id=tblQna.mem_id) as mem_name from tblQna $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$t_qna_idx	= trim($row['qna_idx']);
	$t_qna_f_idx	= trim($row['qna_f_idx']);
	$t_qna_depth	= trim($row['qna_depth']);
	$t_qna_categ	= trim($row['qna_categ']);
	$mem_id		= trim($row['mem_id']);
	$mem_name	= trim($row['mem_name']);
	$t_qna_title	= trim($row['qna_title']);
	$t_qna_file	= trim($row['qna_file']);
	$t_qna_view	= trim($row['qna_view']);
	$t_qna_ip		= trim($row['qna_ip']);
	$t_qna_reg_dt	= trim($row['qna_reg_dt']);

	$t_qna_title	= strip_str($t_qna_title);
	$t_qna_title	= cutStringHan($t_qna_title,40);

	$spacer = strlen($t_qna_depth) - 1;
	if ( $spacer > $REPLY_INDENT ) $spacer = $REPLY_INDENT;
	$blank = "";
	for ( $j=0; $j<$spacer; $j++ ) {
		$blank .= "&nbsp;";
	}

	$title_head = "";
	if ( !strcmp($t_qna_depth,"A") ) {
		$title_head = "";
	} else {
		$title_head = "[RE]: ";
	}
	
	$file_disp = "";
	if ( $t_qna_file ) {
		$arr_file = explode(";", $t_qna_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$tt_qna_file = trim($v);
			$file_disp .= "<a href='/common/download.php?filename=$tt_qna_file&savename=$tt_qna_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
		}
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$t_qna_idx'>
		  </td>
		  <td align='left' bgcolor='#FFFFFF'><a href='qna_view.php?sel_idx=$t_qna_idx'>${title_head}${t_qna_title}</a></td>
		  <td align='left' bgcolor='#FFFFFF'><a href=\"javascript:pop_member_info('$mem_id');\">$mem_name</a></td>
		  <td align='center'  bgcolor='#FFFFFF'>$t_qna_view</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='#'>$file_disp</a></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$t_qna_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='수정' onClick='editBoard(\"$t_qna_idx\");'>
			<input type='button' value='삭제' onClick='delBoard(\"$t_qna_idx\");'>
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
		f.action = "qna_write_ok.php";
		f.submit();
	}
}

function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "qna_write.php";
	f.submit();
}

function chgQnaCateg() {
	var f = document.frm;
	location.href = "qna_list.php?qna_categ="+f.qna_categ.options[f.qna_categ.selectedIndex].value;
}
</script>

<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">


<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ QNA</font></b> - <?=$qna_categ_str?>  </td>
		<td width="50%" align="right" class="tienom">
			총 <?=$total_record?>개의 레코드가 있습니다.
			<select id="qna_categ" name="qna_categ" onChange="chgQnaCateg();">
				<option value="">::전체::</option>
				<?
				foreach ( $QNA as $k => $v ) {
					$selected = ( $qna_categ == $k ) ? " selected" : "";
					echo "<option value='$k' $selected>$v</option>";
				}
				?>
			</select>
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
                      <td height="1" colspan="7" align="center" bgcolor="#D4D4D4" ></td>
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
			<input type="button" value="글쓰기" onClick="location.href='qna_write.php';">
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
						<option value="qna_title" <? if ( $key == "qna_title" ) echo " selected"; ?>>제목</option>
						<option value="qna_content" <? if ( $key == "qna_content" ) echo " selected"; ?>>내용</option>
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