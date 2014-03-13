<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/bankbook_ok.php
 * date   : 2009.02.09
 * desc   : Admin �������Ա� ����/����
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();

$mode	= trim($_POST['mode']);
$sel_id	= trim($_POST['sel_id']);

if ( !$mode ) {
	echo "<script>alert('�߸��� �����Դϴ�.');history.back();</script>";
	exit;
}
/*
echo "
mode : $mode <br>
sel_id : $sel_id <br>
";
exit;
*/
$mainconn->open();

// ������ ĳ���� �����ϴ� ���μ���
// tblCash insert
// tblMember update
// tblChargeBankBook update
if ( $mode == "C" ) {
	$arr = explode(";", $sel_id);
	foreach ( $arr as $k => $v ) {
		$bb_idx = trim($v);
		if ( $bb_idx == "" ) continue;

		$sql = "select * from tblChargeBankBook where bb_idx = $bb_idx ";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);

		$mem_id = trim($row['mem_id']);
		$bb_code = trim($row['bb_code']);
		$bb_cash = trim($row['bb_cash']);

		$new_cash = $CASHMONEY[$bb_code][1] + $CASHMONEY[$bb_code][2];

		// tblCash
		$result = InsertCash($mem_id, 'CC80', 'I', $new_cash);

		// tblMember
		$result = UpdateMyCash( $mem_id, $new_cash );

		// tblChargeBankBook
		$result = UpdateChargeBankBook( $bb_idx, "Y" );

		/*
		$str = "������ ��õ�ڵ� �ɻ��û�Ͻ� '$p_title' �ڵ�� �ɻ���ؿ� ���� �ʾ�, �Ϲݵ������ ó���Ǿ����ϴ�.\n\n���ظ� �ٶ��ϴ�.^^";
		send_msg($_SESSION['admin_id'],$mem_id,$str);	
		*/
	}
} else if ( $mode == "D" ) {
	$arr = explode(";", $sel_id);
	foreach ( $arr as $k => $v ) {
		$bb_idx = trim($v);
		if ( $bb_idx == "" ) continue;
		
		// tblChargeBankBook ����
		$result = DeleteChargeBankBook( $bb_idx );
	}
}

$mainconn->close();

goto_url("bankbook_list.php");
?>
