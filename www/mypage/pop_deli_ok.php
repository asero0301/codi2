<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_deli_ok.php
 * date   : 2009.02.06
 * desc   : ��ǰ���� Ȯ��(���°� ��ȭ C,D -> E)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];
$gt_idx = trim($_POST['gt_idx']);
$gt_comment = addslashes(trim($_POST['gt_comment']));

$mainconn->open();

// �߼ۿϷ����(C) ���� 7�� �����Ŵ� �ڵ����� �Ϸ�� �����ϱ� ���� �ð��� ������Ʈ �Ѵ�.
$sql = "update tblGiftTracking set gt_ok = 'Y', gt_status = 'E', status_reg_dt = now(), gt_comment = '$gt_comment' where gt_idx = $gt_idx ";
$mainconn->query($sql);
$mainconn->close();

$btn = "<b><font color='#DD2457'>�Ϸ�</font></b>";
echo "<script>opener.document.getElementById('status_area_{$gt_idx}').innerHTML = \"$btn\"; self.close();</script>";

exit;
?>
