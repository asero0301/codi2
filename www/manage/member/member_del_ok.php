<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member_del_ok.php
 * date   : 2008.08.08
 * desc   : admin del process
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// ������ �������� üũ
admin_auth_chk();

// ���۷� üũ
referer_chk();

$sel_id = $_POST['sel_id'];
//echo "Ż���ų ���̵� sel_id : $sel_id <br>";

$arr_ids = explode(";", $sel_id);

$mainconn->open();

// �������� ù��(������) ���Ѵ�.
// end_dt ���� ù���� ������ ���� �Ұ���(���� ��÷�� ���߱⶧��)
$arr_this_sun = getWeekDay("current", time());
$this_sun = $arr_this_sun[0];
echo "this_sun : $this_sun<br><br>";
foreach ( $arr_ids as $k=>$v ) {
	$mem_id = trim($v);
	if ( $mem_id == "" ) continue;
	$sql = "select mem_kind from tblMember where mem_id = '$mem_id' ";
	$mem_kind = $mainconn->count($sql);

	if ( $mem_kind == "A" ) {
		$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
		$mainconn->query($sql);
		$sql = "delete from tblAdmin where admin_id = '$mem_id'";
		$mainconn->query($sql);
	} else if ( $mem_kind == "U" ) {
		$sql = "select C.end_dt from tblMember A, tblProductUpDown B, tblProductEach C 
		where A.mem_id = B.mem_id and B.p_e_idx = C.p_e_idx
		and A.mem_id = '$mem_id'
		order by B.p_u_idx desc 
		limit 1";
		$end_dt = $mainconn->count($sql);
		$that_stamp = mktime(substr($end_dt,11,2),substr($end_dt,14,2),substr($end_dt,17,2),substr($end_dt,5,2),substr($end_dt,8,2),substr($end_dt,0,4));
		$tmp_arr = getWeekDay("current", $that_stamp);
		echo "mem_id:$mem_id, fir:".$tmp_arr[0]."<br>";
		if ( $this_sun <= $tmp_arr[0] ) continue;

		$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
		$mainconn->query($sql);

	} else if ( $mem_kind == "S" ) {
		$sql = "select C.end_dt from tblMember A, tblProduct B, tblProductEach C 
		where A.mem_id = B.mem_id and B.p_idx = C.p_idx
		and A.mem_id = '$mem_id'
		order by C.p_e_idx desc 
		limit 1";
		$end_dt = $mainconn->count($sql);
		$that_stamp = mktime(substr($end_dt,11,2),substr($end_dt,14,2),substr($end_dt,17,2),substr($end_dt,5,2),substr($end_dt,8,2),substr($end_dt,0,4));
		$tmp_arr = getWeekDay("current", $that_stamp);
		echo "mem_id:$mem_id, fir:".$tmp_arr[0]."<br>";
		if ( $this_sun <= $tmp_arr[0] ) continue;

		$sql = "update tblMember set mem_status = 'N' where mem_id='$mem_id'";
		$mainconn->query($sql);
		$sql = "update tblShop set shop_status = 'N' where mem_id='$mem_id'";
		$mainconn->query($sql);

	}
}

$mainconn->close();
goto_url($ADMIN_MAIN_URL);
?>
