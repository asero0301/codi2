<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/ucc_score_proc.php
 * date   : 2009.01.19
 * desc   : �ڵ� UCC�� ������ �ű��.
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);
$mem_id = $_SESSION['mem_id'];

$mainconn->open();

$ucc_idx	= trim($_POST['ucc_idx']);
$ucc_s_score= trim($_POST['ucc_s_score']);

$sql = "select count(*) from tblUccScore where ucc_idx = $ucc_idx and mem_id = '$mem_id'";
$cnt = $mainconn->count($sql);

if ( $cnt > 0 ) {
	echo "<script>alert('�򰡿� �̹� �����ϼ̽��ϴ�.\\n�ϳ��� UCC�� 1ȸ �������� �����մϴ�.');</script>";
	exit;
}

$sql = "select mem_id from tblUcc where ucc_idx = $ucc_idx ";
$owner = $mainconn->count($sql);
if ( $owner == $mem_id ) {
	echo "<script>alert('�ڽ��� UCC�� ������ �ű�� �����ϴ�.');</script>";
	exit;
}

// tblUccScore insert
$sql = "
insert into tblUccScore (ucc_idx, ucc_s_score, mem_id, ucc_s_reg_dt)
	values
($ucc_idx, $ucc_s_score, '$mem_id', now())
";
$mainconn->query($sql);

echo "
<script language='javascript'>
prev_score = parseInt(parent.document.getElementById('label_ucc_score').innerHTML);
parent.document.getElementById('label_ucc_score').innerHTML = prev_score + parseInt('$ucc_s_score');
alert('UCC �򰡸� �ϼ̽��ϴ�.');
</script>
";

$mainconn->close();
exit;
?>
