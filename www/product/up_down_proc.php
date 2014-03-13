<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/up_down_proc.php
 * date   : 2008.10.22
 * desc   : ���ٿ� ó��
 *			���� ���� �����ӿ��� ó���ǰ� �ִ�.
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];

$mainconn->open();

$mode		= trim($_POST['mode']);
$p_idx		= trim($_POST['p_idx']);
$p_e_idx	= trim($_POST['p_e_idx']);
$updown		= trim($_POST['updown']);
$rurl		= trim($_POST['rurl']);

$sc_code = ( $updown == "U" ) ? "SC01" : "SC09";

$go_url = my64decode($rurl);

$sql = "select count(*) from tblProductUpDown where p_e_idx = $p_e_idx and mem_id = '$mem_id'";
$cnt = $mainconn->count($sql);

if ( $cnt > 0 ) {
	echo "<script>alert('�򰡿� �̹� �����ϼ̽��ϴ�.\\n�ϳ��� �ڵ��ǰ�� 1ȸ�� �������� �����մϴ�.');</script>";
	exit;
}

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



if ( $mode == "I" ) {

	// tblProductUpDown insert
	$result = InsertUpDown( $p_idx, $p_e_idx, $mem_id, $SCORECODE[$sc_code][1] );
	
	// tblScore insert
	$result = InsertScore( $mem_id, $p_e_idx, $sc_code);
	
	// tblMember ������Ʈ
	$result = UpdateMyScore( $mem_id, abs($SCORECODE[$sc_code][1]), 1 );

	// parent�� �ִ� ������ ������Ʈ �Ѵ�.(������,up/down ����, ������..)
	$sql = "select ifnull(sum(A.score),0) from tblScoreConfig A, tblScore B where A.sc_cid = B.sc_cid and B.p_e_idx = $p_e_idx ";
	$score = $mainconn->count($sql);
	echo "<script>parent.document.getElementById('sp_current_total_score').innerHTML = $score;</script>";

	$sql = "select p_u_val, count(*) as updown_cnt from tblProductUpDown where p_e_idx = $p_e_idx group by p_u_val ";
	$res = $mainconn->query($sql);
	$sum = 0;
	while ( $row = $mainconn->fetch($res) ) {
		$t_p_u_val = $row['p_u_val'];
		$updown_cnt = $row['updown_cnt'];
		$sum += $updown_cnt;

		if ( $t_p_u_val > 0 ) {
			echo "<script>parent.document.getElementById('sp_up_1').innerHTML = $updown_cnt;</script>";
			echo "<script>parent.document.getElementById('sp_up_2').innerHTML = $updown_cnt;</script>";
			echo "<script>parent.document.getElementById('sp_up_3').innerHTML = $updown_cnt;</script>";
		} else {
			echo "<script>parent.document.getElementById('sp_down_1').innerHTML = $updown_cnt;</script>";
			echo "<script>parent.document.getElementById('sp_down_2').innerHTML = $updown_cnt;</script>";
			echo "<script>parent.document.getElementById('sp_down_3').innerHTML = $updown_cnt;</script>";
		}
	}
	echo "<script>parent.document.getElementById('sp_updown_2').innerHTML = $sum;</script>";
	echo "<script>parent.document.getElementById('sp_updown_3').innerHTML = $sum;</script>";

	// ���޴�
	echo "
	<script language='javascript'>
	if ( parent.document.getElementById('my_updown_codi_cnt_area') ) {
		parent.document.getElementById('my_updown_codi_cnt_area').innerHTML = '$_SESSION[my_updown_codi_cnt]';
	}
	if ( parent.document.getElementById('my_quick_grade_area') ) {
		parent.document.getElementById('my_quick_grade_area').innerHTML = '$_SESSION[mem_grade]';
	}
	if ( parent.document.getElementById('my_quick_percent_area') ) {
		parent.document.getElementById('my_quick_percent_area').innerHTML = '$_SESSION[mem_percent]';
	}
	</script>
	";

	// ���� ���̾ �ٲ۴�.
	$btn1 = "<table width='860' border='0' cellpadding='8' cellspacing='1' bgcolor='#E8E8E8'><form name='tmp_f'><tr><td bgcolor='#FFFFFF'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><textarea name='p_comment_trick' id='p_comment_trick' onKeyUp='updateChar(1000,this.form.p_comment_trick,&#039;textlimit&#039;);' onFocus='return comment_auth_chk(); check_msg(this.form.p_comment_trick);' onBlur='check_msg(this.form.p_comment_trick)' class='memobox' style='width:98%;'></textarea></td><td width='215'><table border='0' cellspacing='0' cellpadding='0'><tr><td><a href='#' onClick='return ProductComment(&#039;I&#039;,&#039;E&#039;,document.tmp_f.p_comment_trick);'><img src='/img/btn_comment_ok.gif' alt='��۾���' height='68' border='0' /></a></td></tr></table></td></tr></table></td></tr></form></table>";
	echo "<script>parent.document.getElementById('updown_btn_area_1').innerHTML = \"$btn1\";</script>";

	$btn2 = "<table border='0' cellspacing='0' cellpadding='0'><tr><td><a href='#reply_anc' onClick='return ProductComment(&#039;I&#039;,&#039;E&#039;,document.f.p_comment);'><img src='/img/btn_comment_ok.gif' alt='��۾���' height='68' border='0' /></a></td></tr></table>";
	echo "<script>parent.document.getElementById('updown_btn_area_2').innerHTML = \"$btn2\";</script>";
	

	echo "<script>alert('�ڵ��򰡸� �ϼ̽��ϴ�');</script>";
	$mainconn->close();
	exit;
}
?>
