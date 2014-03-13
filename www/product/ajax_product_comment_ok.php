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

// 인증여부 체크
auth_chk($RURL);

// 리퍼러 체크
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
	$sc_code = "";	// $updown 이 "E" 인 경우
}

$cmt_sc_code = "SC02";

// iconv - define public.inc.php
$p_c_comment = iconv("utf-8", "euc-kr", $p_c_comment);


$mem_id		= trim($_SESSION['mem_id']);
if ( !$mem_id ) $mem_id = trim($_SESSION['admin_id']);

$mainconn->open();


// 점수/코드 값을 구한다.
$inc_sql = "select * from tblScoreConfig ";
$inc_res = $mainconn->query($inc_sql);
$SCORECODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_sc_cid = trim($inc_row['sc_cid']);
	$inc_sc_cval = trim($inc_row['sc_cval']);
	$inc_score = trim($inc_row['score']);

	// 점수 접근할땐 $SCORECODE['SC09'][1] = -1
	$SCORECODE[$inc_sc_cid] = array($inc_sc_cval, $inc_score);
}

//echo "kind:[$kind]==mode:[$mode]==p_idx:[$p_idx]==pc_comment:[$pc_comment]";

$ip = $_SERVER['REMOTE_ADDR'];
if ( $mode == "I" ) {

	// 업/다운 + 댓글 (한번만 가능)
	if ( $sc_code ) {

		// 이전에 참여한 적이 있는지 체크
		$sql = "select count(*) from tblProductUpDown where p_e_idx = $p_e_idx and mem_id = '$mem_id'";
		$cnt = $mainconn->count($sql);
		if ( $cnt > 0 ) {
			echo "<script>alert('이미 코디평가를 하셨습니다.');</script>";
			exit;
		}

		// tblProductUpDown insert
		$result = InsertUpDown( $p_idx, $p_e_idx, $mem_id, $SCORECODE[$sc_code][1] );

		// tblScore insert (업/다운)
		$result = InsertScore( $mem_id, $p_e_idx, $sc_code);
		

		
		// 댓글 쿼리 처리
		$result = InsertProductComment( $p_idx, $p_e_idx, $mem_id, $p_c_comment, $ip, "Y" );
		
		// tblScore insert (댓글)
		$result = InsertScore( $mem_id, $p_e_idx, $cmt_sc_code);


		// tblMember 업데이트(댓글꺼 까지 더해서)
		$new_mem_score = abs($SCORECODE[$sc_code][1]) + $SCORECODE[$cmt_sc_code][1];
		$result = UpdateMyScore( $mem_id, $new_mem_score, 1 );

	} else {	// 댓글만 다는 경우
		// 댓글 쿼리 처리
		$result = InsertProductComment( $p_idx, $p_e_idx, $mem_id, $p_c_comment, $ip, "Y" );
	}

} else if ( $mode == "E" ) {	// 댓글 수정(점수변화 없고, 댓글만 수정)
	$sql = "update tblProductComment set p_c_comment = '$p_c_comment' where p_c_idx = $p_c_idx";
	$mainconn->query($sql);

} else if ( $mode == "D" ) {	// 댓글 삭제(댓글상태값 변하고 해당 점수 차감, 멤버스코어 차감)
	// 댓글삭제
	$sql = "update tblProductComment set p_c_status = 'N' where p_c_idx = $p_c_idx";
	$mainconn->query($sql);

	// 점수 테이블의 idx을 구한다.
	$sql = "select s_idx from tblScore where mem_id = '$mem_id' and p_e_idx = $p_e_idx and sc_cid = 'SC02'";
	$del_s_idx = $mainconn->count($sql);

	$sql = "delete from tblScore where s_idx = $del_s_idx";
	$mainconn->query($sql);

	// tblMember 업데이트
	$result = UpdateMyScore( $mem_id, -abs($SCORECODE[$cmt_sc_code][1]), 0 );
	
}
	

	
// 정보를 업데이트 한다.(총점수,up/down 갯수, 참여수, 댓글수..)
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

// 결과값-현재총점-업갯수-다운갯수-참여갯수-댓글갯수-내가평가한코디갯수-현재등급-당첨확율
echo "1-".$score."-".$u_cnt."-".$d_cnt."-".$sum."-".$comment_cnt."-".$my_codi_cnt."-".$my_grade."-".$my_percent;
?>
