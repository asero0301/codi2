<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pay_charge_proc.php
 * date   : 2009.02.06
 * desc   : 캐쉬 충전 모듈 (/Sell_Admin/sellercash_proc.php 참조한다)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];

$mainconn->open();

$paymethod	= trim($_POST['paymethod']);
$paymoney	= trim($_POST['paymoney']);

if ( !$paymethod || !$paymoney || !$mem_id ) {
	echo "<script language='javascript'>alert('캐쉬충전중 오류가 발생했습니다.'); self.close();</script>";
	exit;
}

if ( $paymethod == "paper" ) {	// 무통장 입금이면..
	$sql = "insert into tblChargeBankBook (mem_id, bb_code, bb_cash, bb_reg_dt) values ('$mem_id', '$paymoney', ".$CASHMONEY[$paymoney][0]." ,now()) ";
	$res = $mainconn->query($sql);

	if ( $res ) {
		echo "
		<script language='javascript'>
		alert('해당 계좌로 충전금액을 입금하시면 확인후 처리해 드립니다.');
		opener.location.href = '/mypage/Mcash.php';
		self.close();
		</script>
		";
	}
} else if ( $paymethod == "card" ) {	// 카드이면 ...

} else if ( $paymethod == "mobile" ) {	// 휴대폰이면 ...

}

$mainconn->close();
exit;
?>
