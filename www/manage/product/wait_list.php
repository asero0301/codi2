<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/product/wait_list.php
 * date   : 2008.08.14
 * desc   : Admin product wait list

 * join ���̺� : tblProduct, tblShop, tblProductEach
 * R : ��õ���, N : �Ϲݵ��, Y : ��õ���
 * ��õ�ڵ� �ɻ��� ���� : p_judgment='R', now() between start_dt and end_dt
 * ����� ��õ�ڵ� ���� : p_judgment='Y', now() between start_dt and end_dt
 * �Ϲݵ�ϵ� ������ ������� �ʴ´�.
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();


$mainconn->open();

$judge = trim($_REQUEST['judge']);

if ( $judge == "" ) {
	$judge = "R";
}

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

$cond = " where 1 and A.shop_idx = B.shop_idx and A.p_idx=C.p_idx and A.p_judgment = '$judge' and now() between C.start_dt and C.end_dt ";


if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}
/*
if ( $key == "p_title" ) {
	$cond .= " and A.p_title like '%$kwd%' ";
} else if ( $key == "shop_name" ) {
	$cond .= " and B.shop_name like '%$kwd%' ";
}
*/
// record count
$sql = "select count(*) from tblProduct A,tblShop B,tblProductEach C $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&judge=$judge&key=$key&kwd=$kwd";
$orderby = " order by A.p_reg_dt desc ";

$sql = "select A.*,B.shop_name from tblProduct A,tblShop B,tblProductEach C $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";
//echo $sql;
//$sql = "select A.*,B.org_name from tblOrgMember as A,tblOrg as B where 1 $cond $orderby limit $first,$admin_page_size";
//$rows = $db->q($sql);

$res = $mainconn->query($sql);

$LIST = "";



//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$p_idx			= $row['p_idx'];
	$mem_id			= $row['mem_id'];
	$shop_idx		= $row['shop_idx'];
	$shop_name		= $row['shop_name'];
	$p_categ		= $row['p_categ'];
	$p_title		= $row['p_title'];
	$p_info			= $row['p_info'];
	$p_desc			= $row['p_desc'];
	$p_price		= $row['p_price'];
	$p_url			= $row['p_url'];
	$p_style_kwd	= $row['p_style_kwd'];
	$p_item_kwd		= $row['p_item_kwd'];
	$p_theme_kwd	= $row['p_theme_kwd'];
	$p_etc_kwd		= $row['p_etc_kwd'];
	$p_gift			= $row['p_gift'];
	$p_gift_cond	= $row['p_gift_cond'];
	$p_gift_cnt		= $row['p_gift_cnt'];
	$p_main_img		= $row['p_main_img'];
	$p_base_img		= $row['p_base_img'];
	$p_etc_img		= $row['p_etc_img'];
	$p_desc_img		= $row['p_desc_img'];
	$p_auto_extend	= $row['p_auto_extend'];
	$p_judgment		= $row['p_judgment'];
	$p_reg_dt		= $row['p_reg_dt'];

	$p_main_img_disp	= $UP_URL."/thumb/".$p_main_img;

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$p_idx'>
		  </td>
		  <td align='center' bgcolor='#FFFFFF' width='100'>
			<img src='$p_main_img_disp' boarder='0' height='100' width='100'>
		  </td>
		  <td align='center' bgcolor='#FFFFFF'>
			<span class='stext'>
				<a href='product_view.php?p_idx=$p_idx'><font color='#006699'>$p_title</font></a>
			</span>
		  </td>
		  <td align='center'  bgcolor='#FFFFFF'>$p_gift</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='#'>$shop_name</a></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$p_reg_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='�Ϲݵ��' onClick='chgJudge(\"N\",\"$p_idx\");'>
			";
	if ( $judge != "Y" ) {
			$LIST .= "<input type='button' value='��õ���' onClick='chgJudge(\"Y\",\"$p_idx\");'>";
	}

	$LIST .= "
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='7' ></td>
		</tr>
		";
	$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='7' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
}

$total_block = ceil($total_page/$ADMIN_PAGE_BLOCK);
$block = ceil($page/$ADMIN_PAGE_BLOCK);
$first_page = ($block-1)*$ADMIN_PAGE_BLOCK;
$last_page = $block*$ADMIN_PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$mainconn->close();

if ( $judge == "R" ) {
	// ��Ͻ�û
	$b_title = "������ ��õ�ڵ� ��Ͻɻ�";
	$b2_title = "�ɻ��û �ڵ� �ֽ��ϴ�.";
	$b3_title = "���� ����� ��õ�ڵ�";
} else if ( $judge == "Y" ) {
	// ��õ���� ��ϵ�
	$b_title = "���� ������� ��õ�ڵ�";
	$b2_title = "��õ�ڵ� �ֽ��ϴ�.";
	$b3_title = "���� ��û�� �ɻ��ڵ�";
}


require_once "../_top.php";
?> 

<script language="javascript">
function chgJudge(kind,idx) {
	var str = ( kind == "Y" ) ? "��õ" : "�Ϲ�";
	if ( confirm(str + "��� �Ͻðڽ��ϱ�?") ) {
		var f = document.frm;
		f.mode.value = "R";
		f.kind.value = kind;

		if ( idx == "" ) {
			for (i = 0; document.getElementById('frm').elements[i]; i++) {
				if (document.getElementById('frm').elements[i].name == "itemchk") {
					if (document.getElementById('frm').elements[i].checked == true) {
						idx += document.getElementById('frm').elements[i].value+";";
					}
				}
			}

		}
		f.sel_idx.value = idx;

		f.action = "wait_write_ok.php";
		f.submit();
	}
}

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

function goR() {
	location.href = "wait_list.php?judge=R";
}

function goY() {
	location.href = "wait_list.php?judge=Y";
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">�� <?=$b_title?></font></b>  </td>
		<td width="50%" align="right" class="tienom">�� <?=$total_record?>���� <?=$b2_title?> | <?=$b3_title?> : <?=$total_record?>��</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="kind" name="kind" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">
<input type="hidden" id="judge" name="judge" value="<?=$judge?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23">
			<input type="button" value="��õ�ڵ� �ɻ���" onClick="goR();" <? if ( $judge == "R" ) echo " disabled"; ?>>
			<input type="button" value="����� ��õ�ڵ�" onClick="goY();" <? if ( $judge == "Y" ) echo " disabled"; ?>>
		</td>
	</tr>
</table>


      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="28" align="center" class="join"><font color="#000000"><b>��ü</b></font></td>
					  <td width="100">&nbsp;</td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>�ɻ��û�ڵ�</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>��ǰ</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>��û��</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>��û��</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">ó��</font></b></td>
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
			<input type="button" value="��ü����" onClick="checkAll();">
			<input type="button" value="��ü����" onClick="checkFree();">
			<input type="button" value="���� �Ϲݵ��" onClick="chgJudge('N','');">
			<input type="button" value="���� ��õ���" onClick="chgJudge('Y','');">
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
						<option value="A.p_title" <? if ( $key == "A.p_title" ) echo " selected"; ?>>����</option>
						<option value="B.shop_name" <? if ( $key == "B.shop_name" ) echo " selected"; ?>>���̸�</option>
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