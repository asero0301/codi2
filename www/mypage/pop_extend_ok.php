<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_extend_ok.php
 * date   : 2008.11.26
 * desc   : �ڵ� �Ⱓ���� ó�� ������
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

// �ʿ��� ĳ�ð� ������ Ȯ��
// ���� ����� cash�� �ִ��� Ȯ���� �Ѵ�.
// tblProduct�� p_auto_extend, p_pay_cash ���� �����Ѵ�.
// tblCash insert
// tblMember �� mem_cash ���� �����Ѵ�.
// tblProductEach insert
// ����, p_judgment ���� "Y" �̸� tblProductTodayRecom insert

if ( $p_extend == "0" || !$p_extend ) {
	echo "<script>alert('�Ⱓ�� �����ϼ���'); history.back();</script>";
	exit;
}

if ( !$p_idx ) {
	echo "<script>alert('�߸��� �����Դϴ�.'); history.back();</script>";
	exit;
}

// 1. �ʿ��� cash�� ������ Ȯ��
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

// 2. ����� cash�� �ִ��� Ȯ���Ѵ�.
//$sql = "select mem_cash from tblMember where mem_id = '$mem_id' ";
//$current_mem_cash = $mainconn->count($sql);
$current_mem_cash = $_SESSION['mem_cash'];

/*
if ( $current_mem_cash < $need_cash ) {
	echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');opener.location.href='/mypage/Mcash.php'; self.close();</script>";
	exit;
}
*/

if ( $current_mem_cash - $need_cash < -$limit_cash ) {
	echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');opener.location.href='/mypage/Mcash.php'; self.close();</script>";
	exit;
}

// �ܻ����� ó��
if ( $current_mem_cash - $need_cash <= 0 && $current_mem_cash - $need_cash > -$limit_cash ) {
	$prt_cash = abs($current_mem_cash-$need_cash);
	echo "<script language='javascript'>alert('���� ĳ���� $prt_cash �� �����մϴ�.\\n�ܻ����� ó���˴ϴ�.');</script>";
}

// 3. tblProduct�� p_auto_extend, p_pay_cash ���� �����Ѵ�.
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


//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

$mainconn->close();

echo "<script>alert('�Ⱓ������ �Ǿ����ϴ�.'); opener.location.href='/mypage/Mcodi.php'; self.close();</script>";

?>