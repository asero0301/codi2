<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/board/faq_list.php
 * date   : 2008.08.28
 * desc   : Admin faq list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();


$mainconn->open();

$faq_categ = trim($_REQUEST['faq_categ']);
$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

if ( $faq_categ != "" ) {
	$cond .= " and faq_categ = '$faq_categ' ";
	$faq_categ_str = $FAQ[$faq_categ];
} else {
	$faq_categ_str = "��ü";
}

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblFaq $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd&faq_categ=$faq_categ";
$orderby = " order by faq_reg_dt desc ";

$sql = "select * from tblFaq $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {

	$t_faq_idx		= trim($row['faq_idx']);
	$t_faq_title		= trim($row['faq_title']);
	$t_faq_content	= trim($row['faq_content']);
	$t_faq_categ		= trim($row['faq_categ']);
	$t_faq_reg_dt		= trim($row['faq_reg_dt']);

	$t_faq_content	= strip_str($t_faq_content,"V");
	$t_faq_title	= strip_str($t_faq_title);
	$t_faq_title	= cutStringHan($t_faq_title,40);

	$LIST .= "
		<div id='FAQTITLE_${cnt}'>
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='50'><input type='checkbox' id='itemchk' name='itemchk' value='$t_faq_idx'></td>
				<td width='20'> Q : </td>
				<td width='300'> <a href='javascript:menuclick($cnt);'>$t_faq_title</a> </td>
				<td width='100'> <input type='button' value='����' onClick=\"location.href='faq_write.php?sel_idx=$t_faq_idx&mode=E';\"><input type='button' value='����' onClick=\"delBoard('$t_faq_idx');\"></td>
			</tr>
		</table>

		<div id='FAQ_${cnt}' style='display:none;'>
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='20'> A : </td>
				<td width='300'> $t_faq_content </td>
				<td width='100'>&nbsp;</td>
			</tr>
		</table>
		</div>
		";
	$cnt++;
}

if ( $LIST == "" ) {
	$LIST = "<table><tr height='50' bgcolor='#ffffff' align='center'><td colspan='6' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr></table>";
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
function menuclick(num) {
	for (i=1; i<=num; i++) {
		menu=eval("document.all.FAQ_"+i+".style");
		menu2=eval("document.all.FAQTITLE_"+i+".style");

		if (num==i) {
			if (menu.display=="block") menu.display="none";
			else menu.display="block";
		}
	}
}

function goSearch() {
	var f = document.frm;
	f.action = "<?=$_SERVER['PHP_SELF']?>";
	f.submit();
}

function delBoard(idx) {
	if ( !confirm("���õ� �׸��� �����Ͻðڽ��ϱ�?") ) { return; }

	if ( idx == "" ) {	// ��ü ����
		var str = "";
		for (i = 0; document.getElementById('frm').elements[i]; i++) {
			if (document.getElementById('frm').elements[i].name == "itemchk") {
				if (document.getElementById('frm').elements[i].checked == true) {
					str += document.getElementById('frm').elements[i].value+";";
				}
			}
		}
		
	} else {	// ���� ����
		str = idx;
	}

	if ( str == "" || str == undefined ) {
		alert("���õ� �׸��� �����ϴ�.");
		return;
	} else {
		var f = document.frm;
		f.sel_idx.value = str;
		f.mode.value = "D";
		f.action = "faq_write_ok.php";
		f.submit();
	}
}

function editBoard(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "faq_write.php";
	f.submit();
}

function chgFaqCateg() {
	var f = document.frm;
	location.href = "faq_list.php?faq_categ="+f.faq_categ.options[f.faq_categ.selectedIndex].value;
}
</script>

<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">�� FAQ</font></b> - <?=$faq_categ_str?> </td>
		<td width="50%" align="right" class="tienom">
			�� <?=$total_record?>���� ���ڵ尡 �ֽ��ϴ�.
			<select id="faq_categ" name="faq_categ" onChange="chgFaqCateg();">
				<option value="">::��ü::</option>
				<?
				foreach ( $FAQ as $k => $v ) {
					$selected = ( $faq_categ == $k ) ? " selected" : "";
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
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25">
				
				<?=$LIST?>

				
				</td>
              </tr>
          </table></td>
        </tr>
      </table>
      
	  
	  <table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="790" valign="bottom">
			<input type="button" value="��ü����" onClick="checkAll();">
			<input type="button" value="��ü����" onClick="checkFree();">
			<input type="button" value="���û���" onClick="delBoard('');">
		  </td>
		  <td align="right">
			<input type="button" value="�۾���" onClick="location.href='faq_write.php';">
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
						<option value="">����</option>
						<option value="faq_title" <? if ( $key == "faq_title" ) echo " selected"; ?>>����</option>
						<option value="faq_content" <? if ( $key == "faq_content" ) echo " selected"; ?>>����</option>
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