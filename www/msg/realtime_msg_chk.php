<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/realtime_msg_chk.php
 * date   : 2008.11.21
 * desc   : 실시간 메시지 확인
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$TXT = "";

$mainconn->open();

$mem_id = $_SESSION['mem_id'];



$sql = "select msg_idx, send_mem_id from tblMsg where recv_mem_id = '$mem_id' and msg_recv_ok = 'N' and (unix_timestamp(now()) - unix_timestamp(msg_send_dt) < $MSG_USAGE_DAY * 86400) order by msg_idx desc ";
$res = $mainconn->query($sql);

while ( $row = $mainconn->fetch($res) ) {
	$msg_idx		= trim($row['msg_idx']);
	$send_mem_id	= trim($row['send_mem_id']);
	$TXT .= $send_mem_id."^".$msg_idx."|";
}

if ( $TXT ) {
	$msg_cnt_arr = getMsgCount($mem_id);
	$_SESSION['my_quick_msg_noread'] = $msg_cnt_arr[1];		// 읽지않은 쪽지수
	$_SESSION['my_quick_msg_total'] = $msg_cnt_arr[0];		// 전체 받은 쪽지수(보관함 포함)

	$MSG_TXT = $msg_cnt_arr[0].":".$msg_cnt_arr[1]."@";

	$TXT = $MSG_TXT.substr($TXT, 0, strlen($TXT)-1);
}
$mainconn->close();
echo $TXT;
?>


