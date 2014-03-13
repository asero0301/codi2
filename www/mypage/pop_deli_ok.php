<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_deli_ok.php
 * date   : 2009.02.06
 * desc   : 경품수령 확인(상태값 변화 C,D -> E)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];
$gt_idx = trim($_POST['gt_idx']);
$gt_comment = addslashes(trim($_POST['gt_comment']));

$mainconn->open();

// 발송완료상태(C) 에서 7일 지난거는 자동으로 완료로 지정하기 위해 시간을 업데이트 한다.
$sql = "update tblGiftTracking set gt_ok = 'Y', gt_status = 'E', status_reg_dt = now(), gt_comment = '$gt_comment' where gt_idx = $gt_idx ";
$mainconn->query($sql);
$mainconn->close();

$btn = "<b><font color='#DD2457'>완료</font></b>";
echo "<script>opener.document.getElementById('status_area_{$gt_idx}').innerHTML = \"$btn\"; self.close();</script>";

exit;
?>
