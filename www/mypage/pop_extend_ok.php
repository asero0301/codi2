<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_extend_ok.php
 * date   : 2008.11.26
 * desc   : 코디 기간연장 처리 페이지
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

pop_auth_chk();
$mainconn->open();

$mem_id		= $_SESSION['mem_id'];
$mem_name	= $_SESSION['mem_name'];
$mem_date	= date("Ymd", time());

$p_idx			= trim($_POST['p_idx']);
$p_judgment		= trim($_POST['p_judgment']);
$p_extend		= trim($_POST['p_extend']);

// 필요한 캐시가 얼마인지 확인
// 먼저 충분한 cash가 있는지 확인을 한다.
// tblProduct의 p_auto_extend, p_pay_cash 값을 수정한다.
// tblCash insert
// tblMember 의 mem_cash 값을 수정한다.
// tblProductEach insert
// 만약, p_judgment 값이 "Y" 이면 tblProductTodayRecom insert

if ( $p_extend == "0" || !$p_extend ) {
	echo "<script>alert('기간을 선택하세요'); history.back();</script>";
	exit;
}

if ( !$p_idx ) {
	echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
	exit;
}

// 1. 필요한 cash가 얼마인지 확인
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
$need_cash = $p_extend * $CASHCODE[CC55][1];
$limit_cash = $CASHCODE[CC54][2];

// 2. 충분한 cash가 있는지 확인한다.
//$sql = "select mem_cash from tblMember where mem_id = '$mem_id' ";
//$current_mem_cash = $mainconn->count($sql);
$current_mem_cash = $_SESSION['mem_cash'];

/*
if ( $current_mem_cash < $need_cash ) {
	echo "<script language='javascript'>alert('캐시가 부족합니다.');opener.location.href='/mypage/Mcash.php'; self.close();</script>";
	exit;
}
*/

if ( $current_mem_cash - $need_cash < -$limit_cash ) {
	echo "<script language='javascript'>alert('캐시가 부족합니다.');opener.location.href='/mypage/Mcash.php'; self.close();</script>";
	exit;
}

// 외상으로 처리
if ( $current_mem_cash - $need_cash <= 0 && $current_mem_cash - $need_cash > -$limit_cash ) {
	$prt_cash = abs($current_mem_cash-$need_cash);
	echo "<script language='javascript'>alert('현재 캐쉬가 $prt_cash 원 부족합니다.\\n외상으로 처리됩니다.');</script>";
}

// 3. tblProduct의 p_auto_extend, p_pay_cash 값을 수정한다.
$sql = "update tblProduct set p_auto_extend = p_auto_extend + $p_extend , p_pay_cash = p_pay_cash + $need_cash where p_idx = $p_idx ";
$mainconn->query($sql);


// 4. tblCash insert
$result = InsertCash($mem_id, 'CC90', 'O', $need_cash);

// tblMember
$result = UpdateMyCash( $mem_id, -$need_cash );

// 6. tblProductEach insert
$se_arr = getWeekStartEnd($p_extend);
for ( $i=0; $i<$p_extend; $i++ ) {
	$sql_each = "insert into tblProductEach (p_idx, start_dt, end_dt) values ($p_idx, '".$se_arr[$i][0]."', '".$se_arr[$i][1]."')";
	$mainconn->query($sql_each);

	$new_p_e_idx = mysql_insert_id();

	if ( $p_judgment == "Y" ) {
		$f_day = substr($se_arr[$i][0], 0, 10);
		$f_arr = getAllDate($f_day, 7);
		foreach ( $f_arr as $kkk => $vvv ) {
			$sql = "insert into tblProductTodayRecom (p_idx, p_e_idx, p_tr_today, p_tr_reg_dt) values ($p_idx, $new_p_e_idx, '$vvv', now()) ";
			$mainconn->query($sql);
		}
	}
}


//////////////////////// 체크루틴 나중에 추가해야 됨 - -;; /////////////////////

$mainconn->close();

echo "<script>alert('기간연장이 되었습니다.'); opener.location.href='/mypage/Mcodi.php'; self.close();</script>";

?>