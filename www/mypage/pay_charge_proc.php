<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pay_charge_proc.php
 * date   : 2009.02.06
 * desc   : ĳ�� ���� ��� (/Sell_Admin/sellercash_proc.php �����Ѵ�)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];

$mainconn->open();

$paymethod	= trim($_POST['paymethod']);
$paymoney	= trim($_POST['paymoney']);

if ( !$paymethod || !$paymoney || !$mem_id ) {
	echo "<script language='javascript'>alert('ĳ�������� ������ �߻��߽��ϴ�.'); self.close();</script>";
	exit;
}

if ( $paymethod == "paper" ) {	// ������ �Ա��̸�..
	$sql = "insert into tblChargeBankBook (mem_id, bb_code, bb_cash, bb_reg_dt) values ('$mem_id', '$paymoney', ".$CASHMONEY[$paymoney][0]." ,now()) ";
	$res = $mainconn->query($sql);

	if ( $res ) {
		echo "
		<script language='javascript'>
		alert('�ش� ���·� �����ݾ��� �Ա��Ͻø� Ȯ���� ó���� �帳�ϴ�.');
		opener.location.href = '/mypage/Mcash.php';
		self.close();
		</script>
		";
	}
} else if ( $paymethod == "card" ) {	// ī���̸� ...

} else if ( $paymethod == "mobile" ) {	// �޴����̸� ...

}

$mainconn->close();
exit;
?>
