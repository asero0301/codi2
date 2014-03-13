<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/msg_write_ok.php
 * date   : 2008.10.25
 * desc   : ���� ������
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

// ���۷� üũ
referer_chk();

if ( $mode == "I" ) {
	$sel_id			= trim($_POST['sel_id']);	// ����� id
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
		// ���������Կ� 100�� �̻������� ����
		$sql = "select count(*) from tblMsg where ( send_mem_id = '$mem_id' and msg_send_forever = 'F' ) or ( recv_mem_id = '$mem_id' and msg_recv_forever = 'F' ) ";
		$forever_cnt = $mainconn->count($sql);
		if ( $forever_cnt >= $MSG_FOREVER_LIMIT ) {
			echo "<script>alert('�������� �뷮�ʰ��Դϴ�.'); parent.location.href='/msg/msg_forever_list.php';</script>";
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
		echo "<script>alert('������ �߼۵Ǿ����ϴ�'); self.close();</script>";	// �����ڸ�忡�� �����°�
	} else {
		echo "<script>alert('������ �߼۵Ǿ����ϴ�'); parent.location.href='/msg/msg_send_list.php';</script>";
	}
} else if ( $mode == "F" ) {
	echo "<script>alert('���������� �̵��߽��ϴ�.'); parent.location.href='/msg/msg_forever_list.php';</script>";
} else if ( $mode == "D" ) {
	if ( $msg_type == "R" ) {
		echo "<script>alert('������ �����Ǿ����ϴ�.'); parent.location.href='/msg/msg_recv_list.php';</script>";
	} else if ( $msg_type == "S" ) {
		echo "<script>alert('������ �����Ǿ����ϴ�.'); parent.location.href='/msg/msg_send_list.php';</script>";
	} else {
		echo "<script>alert('������ �����Ǿ����ϴ�.'); parent.location.href='/msg/msg_forever_list.php';</script>";
	}
}


exit;
?>