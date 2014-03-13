<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member_list.php
 * date   : 2008.08.07
 * desc   : Admin member list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();


$mainconn->open();

$mem_kind = trim($_REQUEST['mem_kind']);
$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

$arr_chk = trim($_POST['chk']);
if ( is_array($arr_chk) ) {
	foreach ( $arr_chk as $k => $v ) {
		echo "\$arr_chk[$k] : $v <br>";
	}
}

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

if ( $mem_kind != "" ) {
	$cond .= " and mem_kind = '$mem_kind' ";
}

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblMember $cond ";
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

$qry_str = "&mem_kind=$mem_kind&key=$key&kwd=$kwd";

$orderby = " order by mem_reg_dt desc ";
$sql = "select *, (select log_reg_dt from tblLoginLog where tblMember.mem_id = log_id order by log_idx desc limit 1) as last_log from tblMember $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";
//$sql = "select A.*,B.org_name from tblOrgMember as A,tblOrg as B where 1 $cond $orderby limit $first,$admin_page_size";
//$rows = $db->q($sql);

$res = $mainconn->query($sql);

$LIST = "";



$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$t_mem_id = $row['mem_id'];
	$t_mem_kind = $row['mem_kind'];
	$t_mem_status = $row['mem_status'];
	$t_mem_name = $row['mem_name'];
	$t_mem_mobile = $row['mem_mobile'];
	$t_mem_reg_dt = substr($row['mem_reg_dt'],0,10);
	$t_last_log = $row['last_log'];

	//$t_mem_mobile = phone_disp($t_mem_mobile);

	if ( $t_last_log == "" || $t_last_log == NULL ) {
		$t_last_log = "���ӱ�� ����";
	}
	
	switch ( $t_mem_kind ) {
		case "U" :
			$t_mem_kind_str = "�Ϲ�ȸ��";
			break;
		case "S" :
			$t_mem_kind_str = "��ȸ��";
			break;
		case "A" :
			$t_mem_kind_str = "������";
			break;
		default :
			break;
	}

	switch ( $t_mem_status ) {
		case "Y" :
			$t_mem_status_str = "<font color='blue'>Ȱ��</font>";
			break;
		case "N" :
			$t_mem_status_str = "<font color='red'>Ż��</font>";
			break;
		case "D" :
			$t_mem_status_str = "<font color='yellow'>����</font>";
			break;
		default :
			break;
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$t_mem_id'>
		  </td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>$article_num</td>
		  <td align='center' bgcolor='#FFFFFF'>
			<span class='stext'><a href='member_write.php?mem_id=$t_mem_id&mode=E'><font color='#006699'>$t_mem_id</font></a></span>
		  </td>
		  <td align='center'  bgcolor='#FFFFFF'>$t_mem_name</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>$t_mem_mobile</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><font color='ff6600'>$t_mem_kind_str</font></td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>$t_mem_status_str</td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$t_mem_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF' class='stext'>$t_last_log</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<a href=\"javascript:pop_msg('$t_mem_id');\"><img src='../img/icon_memo_tran.gif' width='17' height='14' border='0' align='absmiddle'></a>&nbsp; 
			<a href='member_write.php?mem_id=$t_mem_id&mode=E'><img src='../img/icon_modify.gif' width='16' height='16' border='0' align='absmiddle'></a>
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='10' ></td>
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

function addMember() {
	location.href="/manage/member/member_write.php";
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
		var f = document.frm;
		f.sel_id.value = str;
		f.action = "member_del_ok.php";
		f.submit();
	}
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td width="50%" height="23"><b><font color="#333333">�� ��ü ȸ������Ʈ</font></b>  </td>
        <td width="50%" align="right" class="tienom">�� <?=$total_record?>���� ȸ���� �ֽ��ϴ�.</td>
      </tr>
    </table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="sel_id" name="sel_id" value="">

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
                      <td width="85" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
					  <td width="70" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>������</b></font></td>
                      <td width="110" align="center" class="stextbold"><font color="#000000"><b>����������</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">����/����</font></b></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="10" align="center" bgcolor="#D4D4D4" ></td>
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
		  </td>
          <td width="190" align="right" valign="bottom">
			<a href="javascript:addMember();"><img src="../img/btn_in.gif" border="0" alt="ȸ���߰�"></a>
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
					<select id="mem_kind" name="mem_kind" class="goodcss">
						<option value="">ȸ������(��ü)</option>
						<option value="U" <? if ( $mem_kind == "U" ) echo " selected"; ?>>�Ϲ�ȸ��</option>
						<option value="S" <? if ( $mem_kind == "S" ) echo " selected"; ?>>��ȸ��</option>
						<option value="A">������</option>
					</select>
				</td>
				<td width="120" style="padding-top:1">
					<select id="key" name="key" class="goodcss" onChange="chgSearchItem();">
						<option value="">����</option>
						<option value="mem_name" <? if ( $key == "mem_name" ) echo " selected"; ?>>�̸�</option>
						<option value="mem_id" <? if ( $key == "mem_id" ) echo " selected"; ?>>���̵�</option>
						<option value="mem_email" <? if ( $key == "mem_email" ) echo " selected"; ?>>�����ּ�</option>
						<option value="mem_jumin" <? if ( $key == "mem_jumin" ) echo " selected"; ?>>�ֹι�ȣ</option>
						<option value="mem_status" <? if ( $key == "mem_status" ) echo " selected"; ?>>ȸ������</option>
						<option value="mem_grade" <? if ( $key == "mem_grade" ) echo " selected"; ?>>���</option>
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