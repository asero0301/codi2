<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/member/login_ok.php
 * date   : 2008.09.18
 * desc   : Authentication Process
 *******************************************************/
session_start();

// require
require_once "../inc/common.inc.php";

// referer check
referer_chk();

$s_id = trim($_POST['id']);
$s_pwd = trim($_POST['pwd']);
$idsave = trim($_POST['idsave']);
$rurl = trim($_POST['rurl']);

//echo "login_ok : $rurl <br>";

if ( $rurl != "" ) {
	$rurl = my64decode($rurl);
} else {
	$rurl = "/main.php";
}

// sql injection check
sql_injection_chk($id, $pwd);


// authentication process
$mainconn->open();

$sql = "select count(*) from tblMember where mem_id = '$s_id' and mem_pwd = '$s_pwd' and mem_status = 'Y' ";

$cnt = $mainconn->count($sql);


if ( $cnt == "0" ) {
	echo "<script>alert('로그인에 실패했습니다.'); location.href='/member/login.php?rurl=".my64encode($rurl)."';</script>";
	exit;
} else {
	$sql = "select mem_id,mem_name,mem_kind,mem_jumin,mem_email,mem_mobile from tblMember where mem_id = '$s_id' and mem_pwd = '$s_pwd' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$mem_id = $row['mem_id'];
	$mem_name = $row['mem_name'];
	$mem_kind = $row['mem_kind'];
	$mem_jumin = $row['mem_jumin'];
	$mem_email = $row['mem_email'];
	$mem_mobile = $row['mem_mobile'];
	$mem_grade = $row['mem_grade'];
	$mem_cash = $row['mem_cash'];
	$mem_score = $row['mem_score'];
	$mem_percent = $row['lg_percent'];

	$_SESSION['mem_id'] = $mem_id;
	$_SESSION['mem_name'] = $mem_name;
	$_SESSION['mem_kind'] = $mem_kind;
	$_SESSION['mem_jumin'] = $mem_jumin;
	$_SESSION['mem_email'] = $mem_email;
	$_SESSION['mem_mobile'] = $mem_mobile;

	// 샵,일반회원 공통세션
	//session_register("mem_id","mem_name","mem_kind","mem_jumin","mem_email","mem_mobile");
	
	if ( $mem_kind == "U" ) {	// 일반회원용

		// 일반회원 : 받은쪽지, 읽지않은쪽지, 확인안한경품수, 참가코디수, 당첨경품수, 점수, 등급, 당첨확율
		$arr_user_info = getMyUserInfo($mem_id);

		$_SESSION['my_quick_msg_noread'] = $arr_user_info[1];		// 읽지않은 쪽지수
		$_SESSION['my_quick_msg_total'] = $arr_user_info[0];		// 전체 받은 쪽지수(보관함 포함)
		$_SESSION['my_not_notify_gift_cnt'] = $arr_user_info[2];	// 확인하지 않은 경품수(샵,일반회원에 따라 다르다)
		$_SESSION['mem_grade'] = $arr_user_info[6];
		$_SESSION['mem_percent'] = $arr_user_info[7];
		$_SESSION['my_updown_codi_cnt'] = $arr_user_info[3];	// 내가 참여한 코디수
		$_SESSION['my_get_gift_cnt'] = $arr_user_info[4];		// 내가 수령한 경품수

		//session_register("my_quick_msg_noread","my_quick_msg_total","my_not_notify_gift_cnt","mem_grade","mem_percent","my_updown_codi_cnt","my_get_gift_cnt");

	} else {					// 샵회원용

		// 샵회원   : 받은쪽지, 읽지않은쪽지, 확인안한경품수, 평가중코디수, 완료코디수, 대표샵지난주순위, 대표샵전체순위, 현재캐쉬
		$arr_shop_info = getMyShopInfo($mem_id);

		$_SESSION['my_quick_msg_noread'] = $arr_shop_info[1];		// 읽지않은 쪽지수
		$_SESSION['my_quick_msg_total'] = $arr_shop_info[0];		// 전체 받은 쪽지수(보관함 포함)
		$_SESSION['my_not_notify_gift_cnt'] = $arr_shop_info[2];	// 확인하지 않은 경품수(샵,일반회원에 따라 다르다)
		$_SESSION['my_ing_codi_cnt'] = $arr_shop_info[3];		// 평가중인 코디수
		$_SESSION['my_ed_codi_cnt'] = $arr_shop_info[4];		// 평가완료된 코디수
		$_SESSION['main_shop_last_rank'] = $arr_shop_info[5];		// 대표샵의 지난주 순위
		$_SESSION['main_shop_total_rank'] = $arr_shop_info[6];		// 대표샵의 전체 순위
		$_SESSION['mem_cash'] = $arr_shop_info[7];					// 현재 캐쉬

		// 대표샵 이름을 구한다.
		$sql = "select shop_name from tblShop where mem_id = '$s_id' and shop_kind = 'I' ";
		$mypage_shop_name = $mainconn->count($sql);

		$_SESSION['shop_name'] = $$mypage_shop_name;
		//session_register("my_quick_msg_noread","my_quick_msg_total","my_not_notify_gift_cnt","my_ing_codi_cnt","my_ed_codi_cnt","main_shop_last_rank","main_shop_total_rank","mem_cash","shop_name");
	}

	
	

	if ( $idsave == "Y" ) {
		setCookie("idsave", $mem_id, time()+86400*30, "/", "coditop10.com");
	}

	// 최근 로그인 기록을 추가한다.
	$sql = "insert into tblLoginLog (log_id,log_reg_dt,log_ip) values ('$mem_id',now(),'$_SERVER[REMOTE_ADDR]')";
	$mainconn->query($sql);

	// 퀵메뉴 html 생성
	//make_quick_html($mem_id, $_SESSION['mem_kind']);

	// redirect
	goto_url($rurl);
}

// resource free

$mainconn->close();
?>
