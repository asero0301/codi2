<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/contents/kwd_new.php
 * date   : 2008.08.28
 * desc   : Admin kwd new list
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

$cond = " where 1 and p_etc_kwd != '' ";

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblProduct $cond ";
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
$orderby = " order by p_reg_dt desc ";

$sql = "select p_idx,p_etc_kwd,p_reg_dt, (select shop_name from tblShop where shop_idx=tblProduct.shop_idx) as shop_name from tblProduct $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$p_idx			= trim($row['p_idx']);
	$p_etc_kwd		= trim($row['p_etc_kwd']);
	$p_reg_dt		= trim($row['p_reg_dt']);
	$shop_name		= trim($row['shop_name']);

	$tmp_arr = explode(",", $p_etc_kwd);
	$new_etc_kwd = "";
	foreach ( $tmp_arr as $k => $v ) {
		if ( trim($v) == "" ) continue;
		$new_etc_kwd .= "<a href='kwd_new.php?key=p_etc_kwd&kwd=".trim($v)."'>".trim($v)."</a>, ";
	}
	
	$LIST .= "
		<tr>
		  <td align='left' bgcolor='#FFFFFF'>$article_num</td>
			<td align='left' bgcolor='#FFFFFF'>$new_etc_kwd</td>
   		  <td align='center' bgcolor='#FFFFFF'class='stext'>$shop_name</td>  
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$p_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='보기' onClick=\"location.href='/manage/product/product_view.php?p_idx=$p_idx';\">
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='5' ></td>
		</tr>
		";
	$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='5' align='center' bgcolor='#FFFFFF'>결과가 없습니다.</td></tr>";
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
		f.banner_status.value = status;
		f.mode.value = "A";
		f.action = "banner_write_ok.php";
		f.submit();
	}
}

</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ 신규 키워드 관리</font></b>  </td>
		<td width="50%" align="right" class="tienom">총 <?=$total_record?>개의 레코드가 있습니다.</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="banner_status" name="banner_status" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
					  <td width="60" align="center" class="stextbold"><font color="#000000"><b>번호</b></font></td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>신규 키워드</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>신청샵</b></font></td>
					  <td width="80" align="center" class="stextbold"><font color="#000000"><b>입력일</b></font></td>
					  <td width="150" align="center" class="stextbold"><font color="#000000"><b>신청코디상품</b></font></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="5" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      
<!--  
	  <table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="790" valign="bottom">
			<input type="button" value="전체선택" onClick="checkAll();">
			<input type="button" value="전체해제" onClick="checkFree();">
			<input type="button" value="선택적용" onClick="editStatusContent('','N');">
		  </td>
		  <td align="right">
			<input type="button" value="생성하기" onClick="location.href='banner_write.php';">
		  </td>
        </tr>
      </table>
-->

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
						<option value="p_etc_kwd" <? if ( $key == "p_etc_kwd" ) echo " selected"; ?>>키워드</option>
						
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



<script language="javascript">
//if ( popup_getCookie("layerpopup") != "done" ) 
//popLayer('');
</script>

<?php 
require_once "../_bottom.php";

?> 