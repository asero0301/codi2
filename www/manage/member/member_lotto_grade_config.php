<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member_lotto_grade_config.php
 * date   : 2008.08.11
 * desc   : Admin member lotto/grade config
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();


$mainconn->open();

$cond = " where 1 ";
$orderby = " order by sc_cid ";

$sql = "select * from tblScoreConfig $cond $orderby";
$res = $mainconn->query($sql);

$LIST = "";

while ( $row = $mainconn->fetch($res) ) {

	$t_sc_cid = $row['sc_cid'];
	$t_sc_cval = $row['sc_cval'];
	$t_score = $row['score'];
	
	$LIST .= "
		<tr>
		  
		  <td align='left' bgcolor='#FFFFFF'class='stext'><font color='ff6600'>$t_sc_cval</font></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'><input type='text' id='score_$t_sc_cid' name='score_$t_sc_cid' value='$t_score'></td>
		  <td align='center' bgcolor='#FFFFFF' class='stext'><input type='button' value='�����ϱ�' onClick=\"editEachItem('$t_sc_cid');\"></td>
		  
		</tr>
		<tr>
		  <td height='1' colspan='3' ></td>
		</tr>
		";
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='3' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
}

$mainconn->freeResult($res);

$cond = " where 1 ";
$orderby = " order by lg_idx desc";

$sql = "select * from tblLottoGrade $cond $orderby";
$res = $mainconn->query($sql);

$LLIST = "";

while ( $row = $mainconn->fetch($res) ) {

	$t_lg_idx = $row['lg_idx'];
	$t_lg_grade = $row['lg_grade'];
	$t_lg_score = $row['lg_score'];
	$t_lg_percent = $row['lg_percent'];

	$LLIST .= "
		<tr>
		  <td align='left' bgcolor='#FFFFFF'class='stext'><font color='ff6600'>$t_lg_grade ���</font></td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><input type='text' id='lg_score_$t_lg_idx' name='lg_score_$t_lg_idx' value='$t_lg_score'></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'><input type='text' id='lg_percent_$t_lg_idx' name='lg_percent_$t_lg_idx' value='$t_lg_percent'></td>
		  <td align='center' bgcolor='#FFFFFF' class='stext'><input type='button' value='�����ϱ�' onClick=\"editEachGrade('$t_lg_idx');\"></td>
		  
		</tr>
		<tr>
		  <td height='1' colspan='4' ></td>
		</tr>
		";
}

if ( $LLIST == "" ) {
	$LLIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='4' align='center' bgcolor='#FFFFFF'>����� �����ϴ�.</td></tr>";
}

$mainconn->close();

require_once "../_top.php";
?> 

<script language="javascript">
function editEachItem(sc_cid) {
	var f = document.frm;
	f.idx.value = sc_cid;
	f.kind.value = "score";
	f.mode.value = "E";
	f.action = "member_lotto_grade_config_ok.php";
	f.submit();
}

function editEachGrade(lg_idx) {
	var f = document.frm;
	f.idx.value = lg_idx;
	f.kind.value = "grade";
	f.mode.value = "E";
	f.action = "member_lotto_grade_config_ok.php";
	f.submit();
}

function editAll() {
	if ( !confirm("������ ���� �ϰ����� �Ͻðڽ��ϱ�?") ) {
		return;
	}
	var f = document.frm;

	f.mode.value = "E";
	f.action = "member_lotto_grade_config_ok.php";
	f.submit();
}
</script>



<form id="frm" name="frm" method="post">
<input type="hidden" id="idx" name="idx">
<input type="hidden" id="kind" name="kind">
<input type="hidden" id="mode" name="mode">

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">�� ��÷��� �׸���</font></b> �Ϲ�ȸ���� Ȱ���� ���� ��÷����� �����մϴ�. </td>
  </tr>
</table>

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="220" align="center" class="stextbold"><font color="#000000"><b>��÷��� �׸�</b></font></td>
                      <td width="80" align="center" class="stextbold"><font color="#000000"><b>�⺻����</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
                  
                    </tr>
                    <tr>
                      <td height="1" colspan="3" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      
      <br>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">�� ��÷��� �׸���</font></b> �Ϲ�ȸ���� Ȱ���� ���� ��÷����� �����մϴ�. </td>
  </tr>
</table>

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>��÷���</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>�±�����</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>��÷Ȯ��</b></font></td>
					  <td width="100" align="center" class="stextbold"><font color="#000000"><b>����</b></font></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="4" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LLIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>

      <br>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td align="center" height="23"><input type="button" value="��ü����" onClick="editAll();"></td>
  </tr>
</table>

</form>


<?php 
require_once "../_bottom.php";

?> 