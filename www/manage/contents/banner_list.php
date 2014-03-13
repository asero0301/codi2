<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/contents/banner_list.php
 * date   : 2008.08.25
 * desc   : Admin banner list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
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
$sql = "select count(*) from tblBanner $cond ";
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
$orderby = " order by banner_reg_dt desc ";

$sql = "select * from tblBanner $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$banner_idx			= trim($row['banner_idx']);
	$banner_url			= trim($row['banner_url']);
	$banner_area		= trim($row['banner_area']);
	$banner_file		= trim($row['banner_file']);
	$banner_reg_dt		= trim($row['banner_reg_dt']);
	$banner_status		= trim($row['banner_status']);

	$banner_status_str = ( $banner_status == "Y" ) ? "����" : "������";
	$btn_str = ( $banner_status == "Y" ) ? "������" : "����";

	$file_disp = "";
	if ( $banner_file ) {
		$arr_file = explode(";", $banner_file);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_banner_file = trim($v);
			//$file_disp .= "<a href='/common/download.php?filename=$t_banner_file&savename=$t_banner_file'><img src='/img/file.gif' border='0'></a>&nbsp;";
			$file_disp = "<img src='".$UP_URL."/attach/".$t_banner_file."'>";
		}
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$banner_idx'>
		  </td>
		  <td align='left' bgcolor='#FFFFFF'><a href='banner_write.php?sel_idx=$banner_idx&mode=E'>$file_disp</a></td>
   		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='$banner_url' target='_blank'>$banner_url</a></td>  
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$banner_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='����' onClick='editContent(\"$banner_idx\");'>
			<input type='button' value='$btn_str' onClick='editStatusContent(\"$banner_idx\",\"$banner_status\");'>
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='5' ></td>
		</tr>
		";
	//$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='5' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
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
	if ( !confirm("���õ� �׸��� ���°��� �����ұ��?") ) { return; }

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
		f.banner_status.value = status;
		f.mode.value = "A";
		f.action = "banner_write_ok.php";
		f.submit();
	}
}

function editContent(idx) {
	var f = document.frm;
	f.mode.value = "E";
	f.sel_idx.value = idx;
	f.action = "banner_write.php";
	f.submit();
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">�� ��ʰ���</font></b>  </td>
		<td width="50%" align="right" class="tienom">�� <?=$total_record?>���� ���ڵ尡 �ֽ��ϴ�.</td>
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
                      <td width="50" height="28" align="center" class="join"><font color="#000000"><b>��ü</b></font></td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>���</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>URL</b></font></td>
					  <td width="150" align="center" class="stextbold"><font color="#000000"><b>�����</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">ó��</font></b></td>
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
			<input type="button" value="��ü����" onClick="checkAll();">
			<input type="button" value="��ü����" onClick="checkFree();">
			<input type="button" value="��������" onClick="editStatusContent('','N');">
		  </td>
		  <td align="right">
			<input type="button" value="�����ϱ�" onClick="location.href='banner_write.php';">
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
						<option value="banner_title" <? if ( $key == "banner_title" ) echo " selected"; ?>>����</option>
						<option value="banner_content" <? if ( $key == "banner_content" ) echo " selected"; ?>>����</option>
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