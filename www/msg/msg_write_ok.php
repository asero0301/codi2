<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/msg_write_ok.php
 * date   : 2008.10.25
 * desc   : 쪽지 보내기
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

$mem_id	= $_SESSION['mem_id'];
$tgt	= trim($_POST['tgt']);
$mode	= trim($_POST['mode']);
$msg_type	= trim($_POST['msg_type']);
$msg_idx	= trim($_POST['msg_idx']);

if ( $mode == "" ) $mode = "I";

if ( $tgt == "self" ) {
	auth_chk($RURL);
} else {
	pop_auth_chk();
}

$mainconn->open();

// 리퍼러 체크
referer_chk();

if ( $mode == "I" ) {
	$sel_id			= trim($_POST['sel_id']);	// 사용자 id
	$msg_comment	= addslashes(trim($_POST['msg_comment']));
	$idlist = explode(";", $sel_id);

	foreach ( $idlist as $k => $v ) {
		$recv_mem_id = trim($v);
		if ( $recv_mem_id == "" ) continue;
		$sql = "
		insert into tblMsg (send_mem_id, recv_mem_id, msg_comment, msg_send_dt)
			values
		('$mem_id','$recv_mem_id','$msg_comment',now())
		";
		$mainconn->query($sql);
	}
} else if ( $mode == "F" ) {
	$idlist = explode(";", $msg_idx);
	$column = ( $msg_type == "R" ) ? "msg_recv_forever" : "msg_send_forever";
	foreach ( $idlist as $k => $v ) {
		$t_msg_id = trim($v);
		if ( $t_msg_id == "" ) continue;
		// 쪽지보관함에 100개 이상있으면 종료
		$sql = "select count(*) from tblMsg where ( send_mem_id = '$mem_id' and msg_send_forever = 'F' ) or ( recv_mem_id = '$mem_id' and msg_recv_forever = 'F' ) ";
		$forever_cnt = $mainconn->count($sql);
		if ( $forever_cnt >= $MSG_FOREVER_LIMIT ) {
			echo "<script>alert('보관함의 용량초과입니다.'); parent.location.href='/msg/msg_forever_list.php';</script>";
			exit;
		}
		$sql = "update tblMsg set $column = 'F' where msg_idx = $t_msg_id ";
		$mainconn->query($sql);
	}
} else if ( $mode == "D" ) {
	$idlist = explode(";", $msg_idx);
	$column = ( $msg_type == "R" ) ? "msg_recv_status" : "msg_send_status";
	if ( $msg_type == "R" ) {
		$column = "msg_recv_status";
	} else if ( $msg_type == "S" ) {
		$column = "msg_send_status";
	}
	foreach ( $idlist as $k => $v ) {
		$t_msg_id = trim($v);
		if ( $t_msg_id == "" ) continue;
		if ( $msg_type == "F" ) {
			$sql = "select recv_mem_id from tblMsg where msg_idx = $t_msg_id ";
			$sr = $mainconn->count($sql);
			$column = ( $sr == $mem_id ) ? "msg_recv_status" : "msg_send_status";
		}
		$sql = "update tblMsg set $column = 'N' where msg_idx = $t_msg_id ";
		$mainconn->query($sql);
	}
}

$mainconn->close();


if ( $mode == "I" ) {
	if ( $tgt == "admin" ) {
		echo "<script>alert('쪽지가 발송되었습니다'); self.close();</script>";	// 관리자모드에서 보내는거
	} else {
		echo "<script>alert('쪽지가 발송되었습니다'); parent.location.href='/msg/msg_send_list.php';</script>";
	}
} else if ( $mode == "F" ) {
	echo "<script>alert('보관함으로 이동했습니다.'); parent.location.href='/msg/msg_forever_list.php';</script>";
} else if ( $mode == "D" ) {
	if ( $msg_type == "R" ) {
		echo "<script>alert('쪽지가 삭제되었습니다.'); parent.location.href='/msg/msg_recv_list.php';</script>";
	} else if ( $msg_type == "S" ) {
		echo "<script>alert('쪽지가 삭제되었습니다.'); parent.location.href='/msg/msg_send_list.php';</script>";
	} else {
		echo "<script>alert('쪽지가 삭제되었습니다.'); parent.location.href='/msg/msg_forever_list.php';</script>";
	}
}


exit;
?>