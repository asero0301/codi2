<?
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

$mainconn->open();

$mode = trim($_POST['mode']);

if ( $mode == "S" ) {
	$mem_id = trim($_REQUEST["mem_id"]);
	$sql = "SELECT mem_id, mem_name, mem_pwd, mem_email FROM tblMember WHERE mem_id='$mem_id'";
	$res2 = $mainconn->query($sql);
	$srow = $mainconn->fetch($res2);

	if($srow == null) {
		echo "<script> alert('ȸ�������� ����Ȯ�մϴ�.'); self.close(); </script>";
		exit;
	} else {
		//��й�ȣ ���� ������
		$message = implode("",file("/coditop/member/txt/find_idpwd.inc"));
		$message = str_replace("#name#", "$srow[mem_name]", $message) ;
		$message = str_replace("#id#", "$srow[mem_id]", $message) ;
		$message = str_replace("#pw#", "$srow[mem_pwd]", $message) ;

		SendMail($srow['mem_email'], "�ڵ�ž10", "gogisnim@superboard.com", "�ڵ�ž10 ȸ�������Դϴ�.", $message);

		echo "<script> alert('������ �߼��Ͽ����ϴ�.'); self.close(); </script>";
		exit;
	}
} else if ( $mode == "P" ) {
	$mem_name = trim($_POST['mem_name']);
	$mem_jumin = trim($_POST['mem_jumin1']).trim($_POST['mem_jumin2']);

	
	$sql = "SELECT mem_id, mem_email, mem_name FROM tblMember WHERE mem_jumin='$mem_jumin' AND mem_name='$mem_name'";
	//echo $sql;
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row != null ) {
		$mem_id = trim($row['mem_id']);
		$mem_email = trim($row['mem_email']);

		$ment = "
		���̵� ã�ҽ��ϴ�.<br>
		���̵�� <u><font color='DD2457'>$mem_id</font></u> �Դϴ�.<br>
		Ȯ�ι�ư�� �����ø� ��ϵ� �����ּ��� <font color='DD2457'>$mem_email</font> ���� ��й�ȣ�� �߼۵˴ϴ�.<br>
		";
		$btn = "<img src='/img/btn_ok3_0311.gif' border='0' onClick='goSendMail();' style='cursor:hand;' />";
	} else {
		$ment = "
		���̵� �������� �ʽ��ϴ�.<p>
		";
	}

}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>���ϰ� ��ǰ�޴� CODI TOP10 - �ڵ�ž��</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function yuni_jumin() {
	value = document.frm.mem_jumin1.value;
	if (value.length >= 6)
	{
		document.frm.mem_jumin2.focus();
		return;
	}
}

function goNameJuminChk() {
	var f = document.frm;
	f.submit();
}

function goSendMail() {
	var f = document.frm;
	f.mode.value = "S";
	f.submit();
}
</script>
</head>

<body>

<form name="frm" id="frm" method="post">
<input type="hidden" id="mode" name="mode" value="P" />
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>" />

<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle" style="padding-bottom:10"><font color="#FFFFFF"><b>ȸ�����̵� / ��й�ȣ ã��</b></font></td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
      <tr>
        <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_oh.gif" width="27" height="16"  align="absmiddle" /><font color="#333333"> ���̵�� ��й�ȣ�� �����̳���?<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; ȸ�����Խ� �Է��Ͻ� �̸��� �ֹι�ȣ�� �Է��� �ּ���.</font></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>

      <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:12 12 12 12">
				<? if ( $mode == "" ) { ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> ��&nbsp;&nbsp;&nbsp;&nbsp;�� </td>
                      <td><input type="text" name="mem_name" id="mem_name" class="logbox"  style="width:100" /></td>
                      <td rowspan="2" valign=bottom><img src="/img/btn_ok_0311.gif" border="0" onClick="goNameJuminChk();" style="cursor:hand;" /></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �ֹι�ȣ </td>
                      <td><input type="text" name="mem_jumin1" id="mem_jumin1" maxlength="6" class="logbox" style="width:100" onKeyUp="yuni_jumin();" />
                        -
                        <input type="password" name="mem_jumin2" id="mem_jumin2" maxlength="7" class="logbox" style="width:100" onKeyPress="javascript:if(event.keyCode==13) goNameJuminChk();" /></td>
                    </tr>
                  </table>
				  <? } else { ?>
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><?=$ment?></td>
						</tr>
					</table>

				  <? } ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="1" background="/img/dot00.gif"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  class="intext">
						
						�� Ȯ���� �����ø� ȸ������ �� <font color="#000000">����Ͻ� �̸��Ϸ� ID�� �ӽú�й�ȣ�� �߼�</font>��<br>&nbsp;&nbsp;&nbsp;&nbsp;�帳�ϴ�.<br />
						�� ��ϵ� �̸��Ϸ� ���� �� ���� ��쿡�� <u><font color="DD2457"><b>02 - 2234 - 1777</b></font></u> �� �����ּ���. </td>
                      </tr>
                    </table>
					</td>
              </tr>
          </table>
		  </td>
        </tr>
      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td width="32">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">
			<? if ( $mode == "P" ) { ?>
			
			<?=$btn?>
			<? } ?>
			<img src="/img/btn_close.gif" width="70" height="20" border="0"  onClick="self.close();" style="cursor:hand;" />
		  </td>
        </tr>
      </table></td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>
</table>
</form>

<? if ( $mode == "" ) echo "<script>document.frm.mem_name.focus();</script>"; ?>

</body>
</html>

<?
$mainconn->close();
?>