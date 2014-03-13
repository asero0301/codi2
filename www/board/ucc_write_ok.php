<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/ucc_write_ok.php
 * date   : 2009.01.19
 * desc   : UCC �Խ��� �Է�/����/����
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

// �������� üũ
auth_chk($RURL);

// �Ϲ�ȸ���� ����
if ( $_SESSION['mem_kind'] == "S" ) {
	echo "<script>alert('�Ϲ�ȸ���� �ۼ������մϴ�');</script>";
	exit;
}

$mode			= trim($_POST['mode']);
$ucc_idx		= trim($_POST['ucc_idx']);
$ucc_categ		= trim($_POST['ucc_categ']);
$mem_id			= $_SESSION['mem_id'];
$ucc_title		= addslashes(trim($_POST['ucc_title']));
$ucc_content	= addslashes(trim($_POST['ucc_content']));

$old_file_list	= trim($_POST['old_file_list']);
$file_offset	= trim($_POST['file_offset']);		// �����ÿ��� ���ȴ�.

$sc_code = "SC04";

if ( $mode == "" ) {
	$mode = "I";
}
/*
echo "
mode : $mode <br>
ucc_idx : $ucc_idx <br>
ucc_categ : $ucc_categ <br>
mem_id : $mem_id <br>
ucc_title : $ucc_title <br>
old_file_list : $old_file_list <br>
ucc_content : $ucc_content <br>
";
exit;
*/

$mainconn->open();

// ����/�ڵ� ���� ���Ѵ�.
$inc_sql = "select * from tblScoreConfig ";
$inc_res = $mainconn->query($inc_sql);
$SCORECODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_sc_cid = trim($inc_row['sc_cid']);
	$inc_sc_cval = trim($inc_row['sc_cval']);
	$inc_score = trim($inc_row['score']);

	// ���� �����Ҷ� $SCORECODE['SC09'][1] = -1
	$SCORECODE[$inc_sc_cid] = array($inc_sc_cval, $inc_score);
}


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
		insert into tblUcc (ucc_categ,mem_id,ucc_title,ucc_content,ucc_file,ucc_ip,ucc_reg_dt) values 
		('$ucc_categ','$mem_id','$ucc_title','$ucc_content','$file_list','$_SERVER[REMOTE_ADDR]',now())
		";
	$mainconn->query($sql);

	// tblScore
	$result = InsertScore( $mem_id, 0, $sc_code);

	// tblMember ������Ʈ
	$result = UpdateMyScore( $mem_id, abs($SCORECODE[$sc_code][1]), 1 );


} else if ( $mode == "E" ) {
	$sql = "
		update tblUcc set 
			ucc_title = '$ucc_title', ucc_content = '$ucc_content', ucc_file = '$file_list',
			ucc_ip = '$_SERVER[REMOTE_ADDR]', ucc_categ = '$ucc_categ'
		where ucc_idx = $ucc_idx
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
	$arr = explode(";", $ucc_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		// ÷�������� ������ ����
		$sql = "select mem_id,ucc_file,ucc_reg_dt from tblUcc where ucc_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		if ( trim($row['ucc_file']) ) {
			$arr_file = explode(";", trim($row['ucc_file']));
			foreach ( $arr_file as $kk => $vv ) {
				if ( trim($vv) == "" ) continue;
				$t_file = trim($vv);
				@unlink($UP_DIR."/attach/".$t_file);
			}
		}


		$sql = "delete from tblUcc where ucc_idx = $v";
		$mainconn->query($sql);

		// tblScore ����, tblMember ������Ʈ
		$sql2 = "select s_idx from tblScore where mem_id = '".trim($row['mem_id'])."' and s_reg_dt = '".trim($row['ucc_reg_dt'])."' ";
		$res2 = $mainconn->query($sql2);
		$row2 = $mainconn->fetch($res2);

		if ( $row2['s_idx'] ) {
			// tblShop ����
			$result = DeleteScore($row2['s_idx']);

			// tblMember ������Ʈ
			$result = UpdateMyScore( trim($row['mem_id']), -abs($SCORECODE[$sc_code][1]), 0 );
		}
	}
}

//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

$mainconn->close();

goto_url("/board/ucc_list.php");

?>