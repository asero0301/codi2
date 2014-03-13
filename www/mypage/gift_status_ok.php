<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/gift_status_ok.php
 * date   : 2009.02.04
 * desc   : 경품수령 상태값 변화(B->C)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];

$mainconn->open();

$p_e_idx	= trim($_POST['p_e_idx']);
$code		= trim($_POST['code']);
$len		= trim($_POST['len']);

// 발송완료상태(C) 에서 7일 지난거는 자동으로 완료로 지정하기 위해 시간을 업데이트 한다.
$sql = "update tblGiftTracking set gt_status = '$code',status_reg_dt = now() where p_e_idx = $p_e_idx ";
$mainconn->query($sql);

$ok_cnt = getGiftOk($status_list, "E");
$btn = "수령확인중<br>({$ok_cnt}/{$len})";
echo "<script>parent.document.getElementById('btn_chg_area_{$p_e_idx}').innerHTML = \"$btn\";</script>";


$mainconn->close();
exit;
?>
