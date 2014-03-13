<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/product/product_write_ok.php
 * date   : 2008.08.20
 * desc   : �����ڰ� ��ǰ�� �Է�/����/����

 ������ ����޴� ���̺�
 - tblProduct, tblProductEach, tblGiftTracking
 - tblProductComment, tblMemberScore

 ������ ������� �ʴ� ���̺�
 - tblCash (�����ڿ� ���Ѱ�� ĳ�����̺��� ������� ����)
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";
require_once "../../inc/util.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();

$mode			= trim($_POST['mode']);
$kind			= trim($_POST['kind']);
$sel_idx		= trim($_POST['sel_idx']);

//echo "mode : $mode \t kind : $kind \t sel_idx : $sel_idx \t";

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

if ( $mode == "D" ) {
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		// tblProduct ���̺� ����
		$sql = "delete from tblProduct where p_idx = $v";
		$mainconn->query($sql);

		// tblProductEach�� p_e_idx ���� ���Ѵ�.
		$sql = "select p_e_idx from tblProductEach where p_idx = $v";
		$res = $mainconn->query($sql);
		$p_e_idx_list = "";
		while ( $row = $mainconn->fetch($res) ) {
			$p_e_idx_list .= trim($row['p_e_idx']).",";
		}
		$p_e_idx_list = substr($p_e_idx_list,0,strlen($p_e_idx_list)-1);

		// tblProductEach ���̺� ����
		$sql = "delete from tblProductEach where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblGiftTracking ���̺� ����
		$sql = "delete from tblGiftTracking where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblMemberScore ���̺� ����
		$sql = "delete from tblMemberScore where p_e_idx in ( $p_e_idx_list ) ";
		$mainconn->query($sql);

		// tblProductComment ���̺� ����
		$sql = "delete from tblProductComment where p_idx = $v ";
		$mainconn->query($sql);

	}
}


//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////





$mainconn->close();

goto_url("wait_list.php");
//require_once "../_bottom.php";
?>