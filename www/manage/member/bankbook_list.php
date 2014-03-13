<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/bankbook_list.php
 * date   : 2009.02.06
 * desc   : Admin �������Ա� ó��
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
$bb_status = trim($_REQUEST['bb_status']);

$arr_chk = trim($_POST['chk']);
if ( is_array($arr_chk) ) {
	foreach ( $arr_chk as $k => $v ) {
		echo "\$arr_chk[$k] : $v <br>";
	}
}

if ( $page == "" ) $page = 1;

$cond = " where 1 and A.mem_id = B.mem_id and B.mem_id = C.mem_id ";

if ( $bb_status ) {
	$cond .= " and A.bb_status = '$bb_status' ";
}

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblChargeBankBook A, tblMember B, tblShop C $cond ";
$total_record = $mainconn->count($sql);

//echo $sql;


$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd";

$orderby = " order by bb_status desc, bb_idx desc ";
$sql = "select A.bb_idx, A.bb_code, A.bb_cash, A.bb_status, A.bb_reg_dt, B.mem_id, B.mem_name, B.mem_mobile, C.shop_idx, C.shop_name from tblChargeBankBook A, tblMember B, tblShop C $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";



$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$bb_idx = $row['bb_idx'];
	$bb_code = $row['bb_code'];
	$bb_cash = $row['bb_cash'];
	$t_bb_status = $row['bb_status'];
	$bb_reg_dt = $row['bb_reg_dt'];
	$mem_id = $row['mem_id'];
	$mem_name = $row['mem_name'];
	$mem_mobile = $row['mem_mobile'];
	$shop_idx = $row['shop_idx'];
	$shop_name = $row['shop_name'];

	$btn = ( $t_bb_status == "Y" ) ? " disabled" : "";
	$bg = ( $t_bb_status == "N" ) ? " bgcolor='#FFDADA'" : " bgcolor='#FFFFFF'";
	$status_txt = ( $t_bb_status == "Y" ) ? "����" : "�̽���";

	$LIST .= "
		<tr $bg>
		  <td height='28' align='center' $bg class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$bb_idx'>
		  </td>
		  <td align='center' $bg class='stext'>$article_num</td>
		  <td align='center' $bg>
			<span class='stext'><font color='#006699'>$mem_id</font></span>
		  </td>
		  <td align='center'  $bg>$mem_name</td>
		  <td align='center' $bg class='stext'>$mem_mobile</td>
		  <td align='center'  $bg class='stext'>".number_format($bb_cash)."</td>
   		  <td align='center' $bg class='stext'>$status_txt</td>
		  <td align='center'  $bg class='stext'>$bb_reg_dt</td>
		  <td align='center' $bg class='stext'>
			<input type='button' value='�� ��' onClick=\"go_commit('$bb_idx');\" $btn>&nbsp; 
			<input type='button' value='�� ��' onClick=\"go_del('$bb_idx');\">&nbsp; 
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='9' ></td>
		</tr>
		";
	$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='9' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
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
function chgSearchItem() {
	var f = document.frm;
	if ( f.key.options[f.key.selectedIndex].value == "mem_jumin" ) {
		f.kwd.value = "- �����ϰ� �Է�";
	} else if ( f.key.options[f.key.selectedIndex].value == "mem_status" ) {
		f.kwd.value = "Ȱ��:Y, Ż��:N, ���:D (��ҹ��� ����) ";
	} else if ( f.key.options[f.key.selectedIndex].value == "mem_grade" ) {
		f.kwd.value = "1 ���� 10 ���� ���ڸ� �Է�";
	} else {
		f.kwd.value = "";
	}
}

function goSearch() {
	var f = document.frm;
	f.action = "<?=$_SERVER['PHP_SELF']?>";
	f.submit();
}

function selectDel() {
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("���õ� �׸��� �����ϴ�.");
		return;
	} else {
		if ( confirm("���õ� �׸��� �����ұ��?") ) {
			var f = document.frm;
			f.sel_id.value = str;
			f.mode.value = "D";
			f.action = "bankbook_ok.php";
			f.submit();
		}
	}
}

function selectCommit() {
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("���õ� �׸��� �����ϴ�.");
		return;
	} else {
		if ( confirm("���õ� �׸��� �����ұ��?") ) {
			var f = document.frm;
			f.sel_id.value = str;
			f.target = "_self";
			f.mode.value = "C";
			f.action = "bankbook_ok.php";
			f.submit();
		}
	}
}

function go_commit(idx) {
	if ( confirm("�����ұ��?") ) {
		var f = document.frm;
		f.sel_id.value = idx;
		f.target = "_self";
		f.mode.value = "C";
		f.action = "bankbook_ok.php";
		f.submit();
	}
}

function go_del(idx) {
	if ( confirm("�����ұ��?") ) {
		var f = document.frm;
		f.sel_id.value = idx;
		f.mode.value = "D";
		f.action = "bankbook_ok.php";
		f.submit();
	}	
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td width="50%" height="23"><b><font color="#333333">�� ��ü ������ �Աݸ���Ʈ</font></b>  </td>
        <td width="50%" align="right" class="tienom">�� <?=$total_record?>���� �ֽ��ϴ�.</td>
      </tr>
    </table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="sel_id" name="sel_id" value="">
<input type="hidden" id="mode" name="mode" value="">

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="80" height="28" align="center" class="join"><font color="#000000"><b>��ü</b></font></td>
					  <td width="60" align="center" class="stextbold"><font color="#000000"><b>��ȣ</b></font></td>
                      <td align="center" class="stextbold"><font color="#000000"><b>���̵�</b></font></td>
                      <td width="120" align="center" class="stextbold"><font color="#000000"><b>�̸�(��ǥ)</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>����ó</b></font></td>
                      <td width="85" align="center" class="stextbold"><font color="#000000"><b>�Ա�</b></font></td>
					  <td width="85" align="center" class="stextbold"><font color="#000000"><b>ó��</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>������</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
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
			<a href="javascript:checkAll();"><img src="../img/btn_all.gif" width="63" height="21" border="0" alt="��ü����"></a> 
			<a href="javascript:selectDel();"><img src="../img/btn_del2.gif" width="63" height="21" border="0" alt="���û���"></a> 
			<a href="javascript:checkFree();"><img src="../img/btn_ccc.gif" width="63" height="21" border="0" alt="��������"></a>
			<a href="javascript:selectCommit();">���ý���</a>
		  </td>
          <td width="190" align="right" valign="bottom">
			<a href="javascript:sendAll();"><img src="../img/btn_go_allmemo.gif" border="0" alt="�˻���� ��ü����"></a>
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
					<select id="bb_status" name="bb_status" class="goodcss">
						<option value="N" <? if ( $bb_status == "N" ) echo " selected"; ?>>�̽���</option>
						<option value="Y" <? if ( $bb_status == "Y" ) echo " selected"; ?>>����</option>
						<option value="" <? if ( $bb_status == "" ) echo " selected"; ?>>��ü</option>
					</select>
				</td>
				<td width="120" style="padding-top:1">
					<select id="key" name="key" class="goodcss" onChange="chgSearchItem();">
						<option value="">����</option>
						<option value="B.mem_name" <? if ( $key == "B.mem_name" ) echo " selected"; ?>>�̸�</option>
						<option value="A.mem_id" <? if ( $key == "A.mem_id" ) echo " selected"; ?>>���̵�</option>
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