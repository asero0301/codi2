<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/bad_shop_write_ok.php
 * date   : 2009.01.23
 * desc   : �ҷ��� �Ű� �Է�/����/����
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

// �������� üũ
auth_chk($RURL);

// ��ȸ���� ����
/*
if ( $_SESSION['mem_kind'] != "S" ) {
	echo "<script>alert('��ȸ���� �ۼ������մϴ�'); location.href='/board/bad_shop_list.php';</script>";
	exit;
}
*/

$mode			= trim($_POST['mode']);
$bad_idx		= trim($_POST['bad_idx']);
$shop_idx		= trim($_POST['shop_idx']);
$mem_id			= $_SESSION['mem_id'];
$bad_title		= addslashes(trim($_POST['bad_title']));
$bad_content	= addslashes(trim($_POST['bad_content']));

$old_file_list	= trim($_POST['old_file_list']);
$file_offset	= trim($_POST['file_offset']);		// �����ÿ��� ���ȴ�.

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();

/****************************************************
 * ���� ���� �˰��� (���� �Է��� 3����� �����Ѵ�)
 * �Է��϶� �׳� �״��...
 * �����϶��� file_offset ������ �����ؼ� 
 * ������ ���ϵ��� $del_file_list��,
 * ���� ���ϵ��� $file_list�� �����Ѵ�.
 * ���� ���μ����� ����(�ڵ� �̹������) ��İ� ����
 ****************************************************/
$file_list = "";
if ( $_FILES['upfile']['size'][0]>0 || $_FILES['upfile']['size'][1]>0 || $_FILES['upfile']['size'][2]>0 ) {	// ÷������
	$del_file_list = "";
	if ( $mode == "E" && $old_file_list ) {
		$old_arr = explode(";", $old_file_list);

		$off_arr = explode(";", $file_offset);
		$file_list = $old_file_list;
		foreach ( $off_arr as $key => $value ) {
			if ( $value == "" ) continue;
			if ( $old_arr[$value-1] ) {
				$del_file_list .= $old_arr[$value-1].";";
				$file_list = str_replace($old_arr[$value-1].";", "", $file_list);
			} else {
				$file_list = $old_file_list;
			}
		}
	}
	for ( $i=0; $i< sizeof($_FILES['upfile']['size']); $i++ ) {
		if ( !$_FILES['upfile']['size'][$i] ) continue;
		$path = $UP_DIR."/attach/";
		@mkdir($path.date("Ym"), 0777);
		$upfile = date("Ym")."/".date("His").random_code2(10).strtolower(strrchr($_FILES["upfile"]['name'][$i], "."));
		$result = MultiFileUpload("upfile", $i, $path, $upfile);
		$file_list .= $upfile.";";
	}
} else {
	$file_list = $old_file_list;
}

if ( $mode == "I" ) {
	$sql = "
		insert into tblBadShop (shop_idx,mem_id,bad_title,bad_content,bad_file,bad_ip,bad_reg_dt) values 
		('$shop_idx','$mem_id','$bad_title','$bad_content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);

} else if ( $mode == "E" ) {
	$sql = "
		update tblBadShop set 
			bad_title = '$bad_title', bad_content = '$bad_content', bad_file = '$file_list',
			bad_ip = '$_SERVER[REMOTE_ADDR]', shop_idx = '$shop_idx'
		where bad_idx = $bad_idx
		";
	$mainconn->query($sql);

	if ( $del_file_list ) {
		$arr_file = explode(";", $del_file_list);
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$t_file = trim($v);
			@unlink($UP_DIR."/attach/".$t_file);
		}
	}

} else {
	$arr = explode(";", $bad_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		// ÷�������� ������ ����
		$sql = "select mem_id,bad_file,bad_reg_dt from tblBadShop where bad_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		if ( trim($row['bad_file']) ) {
			$arr_file = explode(";", trim($row['bad_file']));
			foreach ( $arr_file as $kk => $vv ) {
				if ( trim($vv) == "" ) continue;
				$t_file = trim($vv);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}


		$sql = "delete from tblBadShop where bad_idx = $v";
		$mainconn->query($sql);
	}
}

//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

$mainconn->close();

goto_url("/board/bad_shop_list.php");

?>