<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/product/wait_write_ok.php
 * date   : 2008.08.18
 * desc   : Admin product judgment insert/update
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode			= trim($_POST['mode']);
$kind			= trim($_POST['kind']);
$sel_idx		= trim($_POST['sel_idx']);

//echo "mode : $mode \t kind : $kind \t sel_idx : $sel_idx \t";

if ( $mode == "" ) {
	$mode = "I";
}

$mainconn->open();


if ( $mode == "R" ) {	// 추천대기
	$arr = explode(";", $sel_idx);
	foreach ( $arr as $k => $v ) {
		if ( trim($v) == "" ) continue;

		$sql = "update tblProduct set p_judgment = '$kind' where p_idx = $v";
		$mainconn->query($sql);
		//echo $sql;

		// tblProductTodayRecom insert
		$sql = "select p_e_idx, start_dt, end_dt from tblProductEach where p_idx = $v ";
		$res = $mainconn->query($sql);
		$p_e_idx_list = "";
		while ( $row = $mainconn->fetch($res) ) {
			$p_e_idx_list .= $row['p_e_idx']."^".$row['start_dt']."^".$row['end_dt'].",";
		}
		$tmp_arr = explode(",", $p_e_idx_list);
		foreach ( $tmp_arr as $kk => $vv ) {
			if ( trim($vv) == "" ) continue;
			$vv_arr = explode("^", $vv);
			$t_p_e_idx = $vv_arr[0];
			
			$f_arr = getAllDate(substr($vv_arr[1], 0, 10), 7);
			foreach ( $f_arr as $kkk => $vvv ) {
				$sql = "insert into tblProductTodayRecom (p_idx, p_e_idx, p_tr_today, p_tr_reg_dt) values ($v, $t_p_e_idx, '$vvv', now()) ";
				$mainconn->query($sql);
			}
		}

		$sql = "select mem_id,p_title from tblProduct where p_idx = $v";
		$res = $mainconn->query($sql);
		$row = $mainconn->fetch($res);
		$p_title		= trim($row['p_title']);
		$recv_mem_id	= trim($row['mem_id']);

		if ( $kind == "Y" ) {
			$str = "오늘의 추천코디에 심사신청하신 '$p_title' 코디가 심사기준을 통과하여 오늘의 추천코디로 등록되었습니다.\n\n감사합니다.^^";
		} else {
			$str = "오늘의 추천코디에 심사신청하신 '$p_title' 코디는 심사기준에 맞지 않아, 일반등록으로 처리되었습니다.\n\n양해를 바랍니다.^^";
		}
		send_msg($_SESSION['admin_id'],$recv_mem_id,$str);	
	}
}


$mainconn->close();

goto_url("wait_list.php");
?>