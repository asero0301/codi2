<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/pop_msg_read.php
 * date   : 2008.10.26
 * desc   : 메시지 읽기
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// 리퍼러 체크
pop_referer_chk();

// 인증여부 체크
pop_auth_chk();


$msg_idx = $_POST['msg_idx'];
$msg_type = $_POST['msg_type'];
$mem_id = $_SESSION['mem_id'];

if ( $msg_type == "" ) $msg_type = "R";

if ( $msg_idx == "" || $mem_id == "" ) {
	echo "<script>self.close();</script>";
	exit;
}
//echo "msg_type : $msg_type<br>";
$mainconn->open();

if ( $msg_type == "R" ) {
	$sql = "select *,(select mem_name from tblMember where mem_id=tblMsg.send_mem_id) as send_mem_name,(select mem_name from tblMember where mem_id=tblMsg.recv_mem_id) as recv_mem_name from tblMsg where msg_idx = $msg_idx and recv_mem_id = '$mem_id' ";
} else if ( $msg_type == "S" ) {
	$sql = "select *,(select mem_name from tblMember where mem_id=tblMsg.send_mem_id) as send_mem_name,(select mem_name from tblMember where mem_id=tblMsg.recv_mem_id) as recv_mem_name from tblMsg where msg_idx = $msg_idx and send_mem_id = '$mem_id' ";
} else {
	$sql = "select *,(select mem_name from tblMember where mem_id=tblMsg.send_mem_id) as send_mem_name,(select mem_name from tblMember where mem_id=tblMsg.recv_mem_id) as recv_mem_name from tblMsg where msg_idx = $msg_idx and (recv_mem_id = '$mem_id' or send_mem_id = '$mem_id') ";
}
//echo $sql;
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$send_mem_id = trim($row['send_mem_id']);
$send_mem_name = trim($row['send_mem_name']);
$recv_mem_id = trim($row['recv_mem_id']);
$recv_mem_name = trim($row['recv_mem_name']);
$msg_comment = trim($row['msg_comment']);
$msg_send_dt = trim($row['msg_send_dt']);
$msg_recv_dt = trim($row['msg_recv_dt']);
$msg_recv_ok = trim($row['msg_recv_ok']);

//$msg_comment = strip_str($msg_comment,"V");
$msg_comment = stripslashes($msg_comment);
$prt_send_time = substr($msg_send_dt,0,10)." (".substr($msg_send_dt,11,5).")";

if ( $msg_type == "R" ) {
	if ( $mem_id != $recv_mem_id ) {
		echo "<script>self.close();</script>";
		exit;
	}
	if ( ($msg_recv_ok == "N") && ($mem_id == $recv_mem_id) ) {
		$sql = "update tblMsg set msg_recv_dt = now(), msg_recv_ok = 'Y' where msg_idx = $msg_idx ";
		$mainconn->query($sql);

		$msg_cnt_arr = getMsgCount( $mem_id );
		$_SESSION['my_quick_msg_noread'] = $msg_cnt_arr[1];		// 읽지않은 쪽지수
		$_SESSION['my_quick_msg_total'] = $msg_cnt_arr[0];		// 전체 받은 쪽지수(보관함 포함)
	
		// 세션을 다시 생성한다.

		// 헤드부분과 퀵메뉴 쪽지관련 수정
		echo "
		<script language='javascript'>
		if ( opener.document.getElementById('my_quick_msg_noread_area') ) {
			opener.document.getElementById('my_quick_msg_noread_area').innerHTML = '".$msg_cnt_arr[1]."';
			opener.document.getElementById('my_quick_msg_total_area').innerHTML = '".$msg_cnt_arr[0]."';
		}
		";

		if ( $msg_cnt_arr[1] ) {	// 읽지않은 쪽지가 또 있으면
			echo "
			opener.document.getElementById('head_msg_icon').src = '/img/icon_memo_11.gif';
			opener.document.getElementById('head_msg_icon').alt = '읽지않은 쪽지가 있습니다.';
			";
		} else {
			echo "
			opener.document.getElementById('head_msg_icon').src = '/img/icon_memo_10.gif';
			opener.document.getElementById('head_msg_icon').alt = '새 쪽지가 없습니다.';
			";
		}

		echo "</script>";
	}
} else if ( $msg_type == "S" ) {
	if ( $mem_id != $send_mem_id ) {
		//echo "<script>self.close();</script>";
		exit;
	}
} else {
	if ( ($mem_id != $send_mem_id) && ($mem_id != $recv_mem_id) ) {
		echo "<script>self.close();</script>";
		exit;
	}
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>코디탑텐 쪽지읽기</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/common.js"></script>
<script language="javascript" src="/js/codi.js"></script>
</head>

<body>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form id="frm" name="frm" method="post">
<input type="hidden" name="msg_idx" id="msg_idx" value="<?=$msg_idx?>" />
<input type="hidden" name="mode" id="mode" value="" />
<input type="hidden" name="msg_type" id="msg_type" value="<?=$msg_type?>" />
<input type="hidden" name="sel_id" id="sel_id" value="" />

  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100">&nbsp;</td>
        <td align="center" class="intitle"><font color="#FFFFFF"><b>코디탑텐 쪽지읽기</b></font></td>
        <td width="100" align="right"><span class="intitle" style="padding-bottom:10"><a href="javascript:self.close()"><img src="/img/btn_close02.gif" border="0"  align="absmiddle"/></a></span></td>
      </tr>
    </table>      
    </td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
      <tr>
        <td style="padding:5 5 5 5">
			<img src="/img/icon_aa.gif"  align="absmiddle">보 낸 이 ID : <?=$send_mem_id?>(<?=$send_mem_name?>)
		</td>
        <td style="padding:5 5 5 5" rowspan="2" valign="top">
			<img src="/img/icon_aa.gif"  align="absmiddle">보낸시간 : <?=$prt_send_time?> 
		</td>
      </tr>
	  <tr>
        <td style="padding:5 5 5 5">
			<img src="/img/icon_aa.gif"  align="absmiddle">받 은 이 ID : <?=$recv_mem_id?>(<?=$recv_mem_name?>)
		</td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:12 12 12 12">
                    <textarea name="textarea" class="textbox"  style="width:100%;height:130"  readOnly><?=$msg_comment?></textarea>
                   
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="1" bgcolor="DADADA"></td>
                    </tr>
                    <tr>
                      <td height="25" bgcolor="F6F5F5" style="padding-top:3"  class="intext">&nbsp;※ 보관하지 않은 쪽지는 <?=$MSG_USAGE_DAY?>일 후에 삭제됩니다. </td>
                    </tr>
                    <tr>
                      <td height="1" bgcolor="DADADA"></td>
                    </tr>
                  </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
		<!--
          <td width="50"><a href="#"><img src="/img/btn_prev3.gif" width="47" height="14" border="0" /></a></td>
          <td><a href="#"><img src="/img/btn_next3.gif" width="47" height="14" border="0" /></a></td>
		-->
		  <td width="50">&nbsp;</td>
          <td>&nbsp;</td>
			
		  <? if ( ($msg_type == "R") || ($msg_type == "F" && $mem_id != $send_mem_id) ) { ?>
          <td width="62" valign="absmiddle">
		  <a href="#" onclick="msg_reply('<?=$send_mem_id?>');"><img src="/img/btn_reply.gif" width="60" height="20" border="0" /></a>
		  </td>
		  <? } ?>

		  <? if ( $msg_type != "F" ) { ?>
          <td width="62" valign="absmiddle"><a href="#" onClick="msg_forever();"><img src="/img/btn_save03.gif" width="60" height="20" border="0" /></a></td>
		  <? } ?>

          <td width="62" valign="absmiddle"><a href="#" onclick="msg_del();"><img src="/img/btn_delete.gif" width="60" height="20" border="0" /></a></td>
        </tr> 
      </table>
	  </td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>

</form>
</table>
</body>
</html>