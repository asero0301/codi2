<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/bankbook_ok.php
 * date   : 2009.02.09
 * desc   : Admin 무통장입금 승인/삭제
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode	= trim($_POST['mode']);
$sel_id	= trim($_POST['sel_id']);

if ( !$mode ) {
	echo "<script>alert('잘못된 접근입니다.');history.back();</script>";
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

// 실제로 캐쉬를 충전하는 프로세스
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
		$str = "오늘의 추천코디에 심사신청하신 '$p_title' 코디는 심사기준에 맞지 않아, 일반등록으로 처리되었습니다.\n\n양해를 바랍니다.^^";
		send_msg($_SESSION['admin_id'],$mem_id,$str);	
		*/
	}
} else if ( $mode == "D" ) {
	$arr = explode(";", $sel_id);
	foreach ( $arr as $k => $v ) {
		$bb_idx = trim($v);
		if ( $bb_idx == "" ) continue;
		
		// tblChargeBankBook 삭제
		$result = DeleteChargeBankBook( $bb_idx );
	}
}

$mainconn->close();

goto_url("bankbook_list.php");
?>
