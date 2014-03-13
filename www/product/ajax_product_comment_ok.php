<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_product_comment_ok.php
 * date   : 2008.10.22
 * desc   : ajax product comment process
 *******************************************************/
session_start();
ini_set("default_charset", "utf-8");

require_once "../inc/common.inc.php";

$mem_id = $_SESSION['mem_id'];

// �������� üũ
auth_chk($RURL);

// ���۷� üũ
referer_chk();

$updown		= trim($_REQUEST['updown']);
$mode		= trim($_REQUEST['mode']);
$p_idx		= trim($_REQUEST['p_idx']);
$p_e_idx	= trim($_REQUEST['pe_idx']);
$p_c_idx		= trim($_REQUEST['pc_idx']);
$p_c_comment	= trim($_REQUEST['pc_comment']);
$page		= trim($_REQUEST['page']);

$sc_code = ( $updown == "U" ) ? "SC01" : "SC09";

if ( $updown == "U" ) {
	$sc_code = "SC01";
} else if ( $updown == "D" ) {
	$sc_code = "SC09";
} else {
	$sc_code = "";	// $updown �� "E" �� ���
}

$cmt_sc_code = "SC02";

// iconv - define public.inc.php
$p_c_comment = iconv("utf-8", "euc-kr", $p_c_comment);


$mem_id		= trim($_SESSION['mem_id']);
if ( !$mem_id ) $mem_id = trim($_SESSION['admin_id']);

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

//echo "kind:[$kind]==mode:[$mode]==p_idx:[$p_idx]==pc_comment:[$pc_comment]";

$ip = $_SERVER['REMOTE_ADDR'];
if ( $mode == "I" ) {

	// ��/�ٿ� + ��� (�ѹ��� ����)
	if ( $sc_code ) {

		// ������ ������ ���� �ִ��� üũ
		$sql = "select count(*) from tblProductUpDown where p_e_idx = $p_e_idx and mem_id = '$mem_id'";
		$cnt = $mainconn->count($sql);
		if ( $cnt > 0 ) {
			echo "<script>alert('�̹� �ڵ��򰡸� �ϼ̽��ϴ�.');</script>";
			exit;
		}

		// tblProductUpDown insert
		$result = InsertUpDown( $p_idx, $p_e_idx, $mem_id, $SCORECODE[$sc_code][1] );

		// tblScore insert (��/�ٿ�)
		$result = InsertScore( $mem_id, $p_e_idx, $sc_code);
		

		
		// ��� ���� ó��
		$result = InsertProductComment( $p_idx, $p_e_idx, $mem_id, $p_c_comment, $ip, "Y" );
		
		// tblScore insert (���)
		$result = InsertScore( $mem_id, $p_e_idx, $cmt_sc_code);


		// tblMember ������Ʈ(��۲� ���� ���ؼ�)
		$new_mem_score = abs($SCORECODE[$sc_code][1]) + $SCORECODE[$cmt_sc_code][1];
		$result = UpdateMyScore( $mem_id, $new_mem_score, 1 );

	} else {	// ��۸� �ٴ� ���
		// ��� ���� ó��
		$result = InsertProductComment( $p_idx, $p_e_idx, $mem_id, $p_c_comment, $ip, "Y" );
	}

} else if ( $mode == "E" ) {	// ��� ����(������ȭ ����, ��۸� ����)
	$sql = "update tblProductComment set p_c_comment = '$p_c_comment' where p_c_idx = $p_c_idx";
	$mainconn->query($sql);

} else if ( $mode == "D" ) {	// ��� ����(��ۻ��°� ���ϰ� �ش� ���� ����, ������ھ� ����)
	// ��ۻ���
	$sql = "update tblProductComment set p_c_status = 'N' where p_c_idx = $p_c_idx";
	$mainconn->query($sql);

	// ���� ���̺��� idx�� ���Ѵ�.
	$sql = "select s_idx from tblScore where mem_id = '$mem_id' and p_e_idx = $p_e_idx and sc_cid = 'SC02'";
	$del_s_idx = $mainconn->count($sql);

	$sql = "delete from tblScore where s_idx = $del_s_idx";
	$mainconn->query($sql);

	// tblMember ������Ʈ
	$result = UpdateMyScore( $mem_id, -abs($SCORECODE[$cmt_sc_code][1]), 0 );
	
}
	

	
// ������ ������Ʈ �Ѵ�.(������,up/down ����, ������, ��ۼ�..)
$sql = "select ifnull(sum(A.score),0) from tblScoreConfig A, tblScore B where A.sc_cid = B.sc_cid and B.p_e_idx = $p_e_idx ";
$score = $mainconn->count($sql);

$sql = "select count(*) from tblProductComment where p_idx=$p_idx and p_e_idx=$p_e_idx and p_c_status='Y'";
$comment_cnt = $mainconn->count($sql);

$sql = "select p_u_val, count(*) as updown_cnt from tblProductUpDown where p_e_idx = $p_e_idx group by p_u_val ";
$res = $mainconn->query($sql);
$sum = 0;
while ( $row = $mainconn->fetch($res) ) {
	$t_p_u_val = $row['p_u_val'];
	$updown_cnt = $row['updown_cnt'];
	$sum += $updown_cnt;

	if ( $t_p_u_val > 0 ) {
		$u_cnt = $updown_cnt;
	} else {
		$d_cnt = $updown_cnt;
	}
}

$my_codi_cnt = $_SESSION[my_updown_codi_cnt];
$my_grade = $_SESSION[mem_grade];
$my_percent = $_SESSION[mem_percent];

if ( !$u_cnt ) $u_cnt = 0;
if ( !$d_cnt ) $d_cnt = 0;
if ( !$sum ) $sum = 0;
if ( !$my_codi_cnt ) $my_codi_cnt = 0;
if ( !$my_grade ) $my_grade = 0;
if ( !$my_percent ) $my_percent = 0;

$mainconn->close();

// �����-��������-������-�ٿ��-��������-��۰���-���������ڵ𰹼�-������-��÷Ȯ��
echo "1-".$score."-".$u_cnt."-".$d_cnt."-".$sum."-".$comment_cnt."-".$my_codi_cnt."-".$my_grade."-".$my_percent;
?>
