<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/visit_proc.php
 * date   : 2008.10.23
 * desc   : 방문 DB 처리
 *			현재 숨김 프레임에서 처리되고 있다.
 *
 * flow	  :
 * ip, p_e_idx 같은것중 최근 1시간 이내 레코드가 있으면 종료
 * cpc 적용 ok	--	외상가능 cash 확인 --	ok --	tblCash 추가(shop_mem_id)
 *													tblMember 수정(shop_mem_id)
 *											no --	shop_mem_id에 sms/쪽지 발송
 * 로그인 ok --	tblScore 추가(mem_id)
 *				tblMember 수정(mem_id)
 * tblProductVisit 추가
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

//auth_chk( my64encode($_SERVER['REQUEST_URI']) );
$mem_id = $_SESSION['mem_id'];

$sc_code = "SC03";
$cc_code = "CC53";
$cc_free_limit = "CC54";

$mainconn->open();

$ip = $_SERVER['REMOTE_ADDR'];
$mode		= trim($_POST['mode']);
$p_idx		= trim($_POST['p_idx']);
$p_e_idx	= trim($_POST['p_e_idx']);
$shop_mem_id= trim($_POST['shop_mem_id']);

if ( $mem_id == "" ) $mem_id = "anonymous";

// 최근 한시간 이전에 클릭한게 있나 확인해서 있으면 바로 종료한다.
$sql = "select count(*) from tblProductVisit where p_e_idx = $p_e_idx and p_v_ip = '$ip' and unix_timestamp() - unix_timestamp(p_v_reg_dt) < 3600 ";
$flag = $mainconn->count($sql);
if ( $flag > 0 ) exit;


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

// 코드/캐시 값을 구한다.
$inc_sql = "select * from tblCashConfig ";
$inc_res = $mainconn->query($inc_sql);
$CASHCODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_cc_cid = trim($inc_row['cc_cid']);
	$inc_cc_cval = trim($inc_row['cc_cval']);
	$inc_etc_conf = trim($inc_row['etc_conf']);
	$inc_cash = trim($inc_row['cash']);
	$CASHCODE[$inc_cc_cid] = array($inc_cc_cval, $inc_cash, $inc_etc_conf);
}

// cpc 초과 클릭인지 확인한다.
$sql = "select count(*) from tblProductVisit where p_e_idx = $p_e_idx ";
$click_cnt = $mainconn->count($sql);

if ( $click_cnt >= $CASHCODE[$cc_code][2] ) {	// cpc 적용, 캐시차감
	$cpc = 1;
} else {
	$cpc = 0;
}


// cpc 초과된 경우
if ( $cpc ) {
	$sql = "select mem_cash from tblMember where mem_id = '$shop_mem_id'";
	$cur_cash = $mainconn->count($sql);

	// tblCash 추가
	$result = InsertCash( $mem_id, 'CC90', 'O', $CASHCODE[$cc_code][1] );

	// tblMember
	$result = UpdateMyCash( $mem_id, -$CASHCODE[$cc_code][1] );


	// 한도 캐시가 존재하는지 확인
	$sql = "select mem_cash, mem_name from tblMember where mem_id = '$shop_mem_id'";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);
	$mem_cash = $row['mem_cash'];
	$mem_name = $row['mem_name'];

	if ( $mem_cash < -10000 ) {
	//if ( $mem_cash < -{$CASHCODE[$cc_free_limit][2]} ) {
		// sms/쪽지 발송
		$msg = str_replace("RECV_MEM_ID", $send_mem_id, $CASH_SUPPLY_MSG);
		$msg = str_replace("RECV_MEM_NAME", $mem_name, $CASH_SUPPLY_MSG);
		send_msg($ADMIN_ID, $send_mem_id, $msg);
	}
}

// 클릭한 사람의 DB정보 수정
if ( $mem_id != "anonymous" ) {
	
	// tblScore inserr
	$result = InsertScore( $mem_id, $p_e_idx, $sc_code);
	
	// tblMember 수정
	$result = UpdateMyScore( $mem_id, $SCORECODE[$sc_code][1], 1 );

	$sql = "select ifnull(sum(A.score),0) from tblScoreConfig A, tblScore B where A.sc_cid = B.sc_cid and B.p_e_idx = $p_e_idx ";
	$score = $mainconn->count($sql);
	echo "<script>parent.document.getElementById('sp_current_total_score').innerHTML = $score;</script>";
}

// tblProductVisit 추가
$result = InsertVisit( $mem_id, $p_idx, $p_e_idx, $ip);

// 퀵메뉴
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

$mainconn->close();
exit;
?>
