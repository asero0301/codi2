<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/contents/kwd_categ.php
 * date   : 2008.08.25
 * desc   : Admin categ keyword list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
//referer_chk();


$mainconn->open();

$kwd_categ = trim($_REQUEST['kwd_categ']);
$kwd_kind = trim($_REQUEST['kwd_kind']);

$cond = " where 1 and kwd_status != 'N' ";

if ( $kwd_categ != "" ) {
	$cond .= " and kwd_categ = '$kwd_categ' ";
}

$orderby = " order by kwd_idx desc ";

$sql = "select kwd_idx,kwd_categ,kwd_kind,kwd,kwd_status from tblKwd $cond $orderby ";

$res = $mainconn->query($sql);

$ST = $IT = $TH = $ET = "";
//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$t_kwd_idx		= trim($row['kwd_idx']);
	$t_kwd_categ	= trim($row['kwd_categ']);
	$t_kwd_kind		= trim($row['kwd_kind']);
	$t_kwd			= trim($row['kwd']);
	$t_kwd_status	= trim($row['kwd_status']);

	switch ( $t_kwd_kind ) {
		case "S" :
			$ST .= "<a href=\"javascript:inputKwd('$t_kwd_idx','$t_kwd_categ','$t_kwd_kind','$t_kwd');\">".$t_kwd."</a> ";
			break;
		case "I" :
			$IT .= "<a href=\"javascript:inputKwd('$t_kwd_idx','$t_kwd_categ','$t_kwd_kind','$t_kwd');\">".$t_kwd."</a> ";
			break;
		case "T" :
			$TH .= "<a href=\"javascript:inputKwd('$t_kwd_idx','$t_kwd_categ','$t_kwd_kind','$t_kwd');\">".$t_kwd."</a> ";
			break;
		default :
			$ET .= "<a href=\"javascript:inputKwd('$t_kwd_idx','$t_kwd_categ','$t_kwd_kind','$t_kwd');\">".$t_kwd."</a> ";
			break;
	}
	//$article_num--;
}

$mainconn->close();

$LIST = "
	<table width='980' border='0' cellpadding='0' cellspacing='0' align='center'>
        <tr>
			<td>
		  
			<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='D4D4D4'>
				<tr>
					<td align='center' bgcolor='EFEFEF' style='padding:12 25 12 25'>
				
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td width='200' align='center' class='stextbold'><font color='#000000'><b>��Ÿ�Ϻ�</b></font></td>
							<td bgcolor='#FFFFFF'>$ST</td>
						</tr>
						<tr>
							<td width='200' align='center' class='stextbold'><font color='#000000'><b>�����ۺ�</b></font></td>
							<td bgcolor='#FFFFFF'>$IT</td>
						</tr>
						<tr>
							<td width='200' align='center' class='stextbold'><font color='#000000'><b>�׸���</b></font></td>
							<td bgcolor='#FFFFFF'>$TH</td>
						</tr>
					</table>

					</td>
				</tr>
			</table>

			</td>
		</tr>
	</table>
";

require_once "../_top.php";
?> 

<script language="javascript">
function inputKwd(arg_idx,arg_categ,arg_kind,arg_kwd) {
	var f = document.frm;
	for ( var i=0; i<f.kwd_categ.length; i++ ) {
		if ( f.kwd_categ[i].value == arg_categ ) {
			f.kwd_categ[i].checked = true;
			break;
		}
	}

	for ( var j=0; j<f.kwd_kind.length; j++ ) {
		if ( f.kwd_kind[j].value == arg_kind ) {
			f.kwd_kind[j].checked = true;
			break;
		}
	}

	f.kwd.value = arg_kwd;
	f.mode.value = "E";
	f.sel_idx.value = arg_idx;
}

function saveKwd() {
	var f = document.frm;

	var cnt = 0;
	for ( var i=0; i<f.kwd_categ.length; i++ ) {
		if ( f.kwd_categ[i].checked == true ) {
			cnt++;
			break;
		}
	}
	if ( cnt == 0 ) {
		alert("ī�װ��� �����ϼ���");
		return;
	}

	var cnt2 = 0;
	for ( var j=0; j<f.kwd_kind.length; j++ ) {
		if ( f.kwd_kind[j].checked == true ) {
			cnt2++;
			break;
		}
	}
	if ( cnt2 == 0 ) {
		alert("�з��� �����ϼ���");
		return;
	}
	if ( f.kwd.value == "" ) {
		alert("Ű���带 �Է��ϼ���");
		f.kwd.focus();
		return;
	}

	f.action = "kwd_categ_ok.php";
	f.submit();
}

function goKwdCateg(categ) {
	location.href = "kwd_categ.php?kwd_categ="+categ;
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">�� �з��� Ű���� ����</font></b> �ڵ��ǰ�� �з� Ű���带 �����մϴ�. </td>
	</tr>
</table>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23">
			<input type="button" value="��ü����Ʈ" onClick="goKwdCateg('');" <? if ( $kwd_categ == "" ) echo " disabled"; ?>>
			<input type="button" value="TOP" onClick="goKwdCateg('T');" <? if ( $kwd_categ == "T" ) echo " disabled"; ?>>
			<input type="button" value="BOTTOM" onClick="goKwdCateg('B');" <? if ( $kwd_categ == "B" ) echo " disabled"; ?>>
			<input type="button" value="OUTWEAR" onClick="goKwdCateg('O');" <? if ( $kwd_categ == "O" ) echo " disabled"; ?>>
			<input type="button" value="UNDERWEAR" onClick="goKwdCateg('U');" <? if ( $kwd_categ == "U" ) echo " disabled"; ?>>
			<input type="button" value="ACC" onClick="goKwdCateg('A');" <? if ( $kwd_categ == "A" ) echo " disabled"; ?>>
		</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">

<?=$LIST?>

<br>

<table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><h1>Ű���� ����</h1></td>
	</tr>
</table>

<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> ī�װ�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="kwd_categ" name="kwd_categ" value="T"> TOP
			<input type="radio" id="kwd_categ" name="kwd_categ" value="B"> BOTTOM
			<input type="radio" id="kwd_categ" name="kwd_categ" value="O"> OUTWEAR
			<input type="radio" id="kwd_categ" name="kwd_categ" value="U"> UNDERWEAR
			<input type="radio" id="kwd_categ" name="kwd_categ" value="A"> ACC
			</font>
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> �з�&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="radio" id="kwd_kind" name="kwd_kind" value="S"> ��Ÿ�Ϻ�
			<input type="radio" id="kwd_kind" name="kwd_kind" value="I"> �����ۺ�
			<input type="radio" id="kwd_kind" name="kwd_kind" value="T"> �׸���
		</td>
	</tr>
	<tr> 
		<td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> Ű����&nbsp; </b></font></td>
		<td bgcolor="#FFFFFF">
			<font color="#666666">
			<input type="text" id="kwd" name="kwd" value="">
			</font>
		</td>
	</tr>
</table>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center" height="23">
			<input type="button" value="��  ��" onClick="saveKwd();">
		</td>
	</tr>
</table>	

</form>


<?php 
require_once "../_bottom.php";

?> 