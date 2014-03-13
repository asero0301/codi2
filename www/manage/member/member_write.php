<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member_write.php
 * date   : 2008.08.11
 * desc   : Admin member write
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();

$mode = trim($_REQUEST['mode']);
$mem_id = trim($_REQUEST['mem_id']);

if ( $mode == "E" ) {
	$title_tail = "����";
	$mainconn->open();
	$sql = "select * from tblMember where mem_id = '$mem_id'";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$mem_pwd		= trim($row['mem_pwd']);
	$mem_kind		= trim($row['mem_kind']);
	$mem_name		= trim($row['mem_name']);
	$mem_jumin		= trim($row['mem_jumin']);
	$mem_email		= trim($row['mem_email']);
	$mem_mobile		= trim($row['mem_mobile']);
	$zipcode		= trim($row['zipcode']);
	$mem_addr1		= trim($row['mem_addr1']);
	$mem_addr2		= trim($row['mem_addr2']);
	$mem_recom_id	= trim($row['mem_recom_id']);
	$mem_status		= trim($row['mem_status']);
	$mem_mailing	= trim($row['mem_mailing']);
	$mem_grade		= trim($row['mem_grade']);
	$mem_cash		= trim($row['mem_cash']);
	$mem_reg_dt		= trim($row['mem_reg_dt']);

	if ( $mem_kind == "S" ) {
		$sql = "select * from tblShop where mem_id = '$mem_id' and shop_kind='I'";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		$shop_idx		= trim($row['shop_idx']);
		$shop_name		= trim($row['shop_name']);
		$shop_kind		= trim($row['shop_kind']);
		$shop_url		= trim($row['shop_url']);
		$shop_person	= trim($row['shop_person']);
		$shop_mobile	= trim($row['shop_mobile']);
		$shop_phone		= trim($row['shop_phone']);
		$shop_fax		= trim($row['shop_fax']);
		$shop_email		= trim($row['shop_email']);
		$shop_logo		= trim($row['shop_logo']);
		$shop_medal		= trim($row['shop_medal']);
		$shop_status	= trim($row['shop_status']);
		$shop_reg_dt	= trim($row['shop_ret_dt']);
		$shop_num		= trim($row['shop_num']);
		$shop_tax		= trim($row['shop_tax']);
		$shop_zipcode	= trim($row['zipcode']);
		$shop_addr1		= trim($row['shop_addr1']);
		$shop_addr2		= trim($row['shop_addr2']);
		$shop_etc1		= trim($row['shop_etc1']);
		$shop_etc2		= trim($row['shop_etc2']);

		$shop_logo_img	= $UP_URL."/thumb/".$shop_logo;
		$old_shop_logo	= $shop_logo;
	}
	$mainconn->close();
} else {
	$title_tail = "�߰�";
}




require_once "../_top.php";
?>


<script language="javascript">
function insertMember() {
	var f = document.mem;
	//f.mode.value = "I";
	f.encoding = "multipart/form-data";
	f.action = "member_write_ok.php";
	f.submit();
}

function chgKind() {
	var f = document.mem;
	if ( f.mem_kind[1].checked == true ) {
		document.getElementById('shop_area').style.display = "block";
	} else {
		document.getElementById('shop_area').style.display = "none";
	}
}

/*
function img_filetype_view() {
	if(document.mem.shop_logo.value.match(/(.jpg|.jpeg|.gif|.png|.bmp|.pdf)$/)) {
		document.getElementById('view_shop_logo').src = document.mem.shop_logo.value;
		document.getElementById('view_shop_logo').style.display = "block";
	} else {
		document.getElementById('view_shop_logo').style.display = "none";
	}	
}
*/
</script>



<form id="mem" name="mem" method="post">

<input type="hidden" id="mode" name="mode" value="<?=$mode?>">
<input type="hidden" id="shop_idx" name="shop_idx" value="<?=$shop_idx?>">
<input type="hidden" id="old_shop_logo" name="old_shop_logo" value="<?=$old_shop_logo?>">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">�� ȸ������ <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ȸ������&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<font color="#666666">
			<input type="radio" id="mem_kind" name="mem_kind" value="U" onClick="chgKind();" <? if ( $mem_kind == "U" ) echo " checked"; ?>> �Ϲ�ȸ��
			<input type="radio" id="mem_kind" name="mem_kind" value="S" onClick="chgKind();" <? if ( $mem_kind == "S" ) echo " checked"; ?>> ��ȸ��
			<input type="radio" id="mem_kind" name="mem_kind" value="A" onClick="chgKind();" <? if ( $mem_kind == "A" ) echo " checked"; ?>> ������
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���̵�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_id" name="mem_id" value="<?=$mem_id?>"></strong></font>
			<input type="button" value="�ߺ�Ȯ��" onClick="id_check();">
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��й�ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_pwd" name="mem_pwd" value="<?=$mem_pwd?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �̸�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_name" name="mem_name" value="<?=$mem_name?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �ֹι�ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_jumin" name="mem_jumin" value="<?=$mem_jumin?>"></strong>(- ���� �Է�)</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �����ּ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_email" name="mem_email" value="<?=$mem_email?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �޴���ȭ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_mobile" name="mem_mobile" value="<?=$mem_mobile?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �����ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<font color="#666666"><strong><input type="text" id="zipcode" name="zipcode" value="<?=$zipcode?>"></strong></font>
			<input type="button" value="�����ȣ ã��" onClick="zip_check('U');">
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �ּ�1&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_addr1" name="mem_addr1" value="<?=$mem_addr1?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �ּ�2&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_addr2" name="mem_addr2" value="<?=$mem_addr2?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���ϸ� ����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<input type="radio" id="mem_mailing" name="mem_mailing" value="Y" <? if ( $mem_mailing == "Y" ) echo " checked"; ?>> ����
			<input type="radio" id="mem_mailing" name="mem_mailing" value="N" <? if ( $mem_mailing == "N" ) echo " checked"; ?>> ���Űź�
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���°�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<input type="radio" id="mem_status" name="mem_status" value="Y" <? if ( $mem_status == "Y" ) echo " checked"; ?>> ���
			<input type="radio" id="mem_status" name="mem_status" value="N" <? if ( $mem_status == "N" ) echo " checked"; ?>> Ż��
			<input type="radio" id="mem_status" name="mem_status" value="D" <? if ( $mem_status == "D" ) echo " checked"; ?>> ���
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_grade" name="mem_grade" value="<?=$mem_grade?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��õ���̵�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="mem_recom_id" name="mem_recom_id" value="<?=$mem_recom_id?>"></strong></font>
		</td>
	</tr>
	<? if ( $mem_kind == "S" ) { ?>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ����ĳ��&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<font color="#666666"><strong><input type="text" id="mem_grade" name="mem_grade" value="<?=$mem_cash?>"></strong></font>
		</td>
	</tr>
	<? } ?>
</table>


<!-- �� �߰� -->
<div id="shop_area" style="display:<? if ( $mem_kind == "S" ) echo "block"; else echo "none"; ?>;">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">�� ������ <?=$title_tail?></font></b></td>
  </tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���̸�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_name" name="shop_name" value="<?=$shop_name?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ����ڵ�Ϲ�ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_num" name="shop_num" value="<?=$shop_num?>"></strong>(- ���� �Է�)</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ������&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="shop_kind" name="shop_kind" value="I" <? if ( $shop_kind == "I" ) echo " checked"; ?>> ��ǥ��
			<input type="radio" id="shop_kind" name="shop_kind" value="D" <? if ( $shop_kind == "D" ) echo " checked"; ?>> �߰���
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��url&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_url" name="shop_url" value="<?=$shop_url?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_etc1" name="shop_etc1" value="<?=$shop_etc1?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_etc2" name="shop_etc2" value="<?=$shop_etc2?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��ǥ��&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_person" name="shop_person" value="<?=$shop_person?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��ȭ��ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_phone" name="shop_phone" value="<?=$shop_phone?>"></strong>(- ���� �Է�)</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �޴���ȭ��ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_mobile" name="shop_mobile" value="<?=$shop_mobile?>"></strong>(- ���� �Է�)</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> fax��ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_fax" name="shop_fax" value="<?=$shop_fax?>"></strong>(- ���� �Է�)</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �����ּ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_email" name="shop_email" value="<?=$shop_email?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ���ݰ�꼭&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="shop_tax" name="shop_tax" value="Y" <? if ( $shop_tax == "Y" ) echo " checked"; ?>> ����
			<input type="radio" id="shop_tax" name="shop_tax" value="N" <? if ( $shop_tax == "N" ) echo " checked"; ?>> �������
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �����ȣ&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<font color="#666666"><strong><input type="text" id="shop_zipcode" name="shop_zipcode" value="<?=$shop_zipcode?>"></strong></font>
			<input type="button" value="�����ȣ ã��" onClick="zip_check('S');">
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �ּ�1&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_addr1" name="shop_addr1" value="<?=$shop_addr1?>"></strong></font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �ּ�2&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666"><strong><input type="text" id="shop_addr2" name="shop_addr2" value="<?=$shop_addr2?>"></strong></font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ������ ����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="shop_medal" name="shop_medal" value="Y" <? if ( $shop_medal == "Y" ) echo " checked"; ?>> ������
			<input type="radio" id="shop_medal" name="shop_medal" value="N" <? if ( $shop_medal == "N" ) echo " checked"; ?>> ��������
			</font>
		</td>
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ��� ����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="shop_status" name="shop_status" value="Y" <? if ( $shop_status == "Y" ) echo " checked"; ?>> ���
			<input type="radio" id="shop_status" name="shop_status" value="N" <? if ( $shop_status == "N" ) echo " checked"; ?>> Ż��
			<input type="radio" id="shop_status" name="shop_status" value="B" <? if ( $shop_status == "B" ) echo " checked"; ?>> ���
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF" height="100"><font color="#666666"><b> �ΰ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF" colspan="3">
			<!--
			<font color="#666666"><strong><input type="file" id="shop_logo" name="shop_logo" onChange="img_filetype_view()"></strong></font>
			<img id='view_shop_logo' height='100' style="display:none;">
			-->
			<font color="#666666"><strong><input type="file" id="shop_logo" name="shop_logo"></strong></font>
			<? if ( $shop_logo ) { ?>
				<img src="<?=$shop_logo_img?>" border="0">
			<? } ?>
		</td>
	</tr>

</table>

</div>
<!-- �� �߰� �� -->


<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td align="center" height="23">
		<input type="button" value="��  ��" onClick="insertMember();">
	</td>
  </tr>
</table>



</form>



<?php 
require_once "../_bottom.php";

?> 