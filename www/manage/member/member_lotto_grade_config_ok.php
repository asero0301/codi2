<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member_lotto_grade_config_ok.php
 * date   : 2008.08.11
 * desc   : Admin member lotto/grade config process
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();

$mode = trim($_POST['mode']);
$kind = trim($_POST['kind']);
$idx = trim($_POST['idx']);

$mainconn->open();

if ( $mode == "E" ) {
	if ( $idx != "" ) {		// 개별 수정
		
		if ( $kind == "score" ) {

			$sql = "update tblScoreConfig set score = ".$_POST['score_'.$idx]." where sc_cid = '$idx'";
			$mainconn->query($sql);
			goto_url("member_lotto_grade_config.php");
			
		} else {
			$sql = "update tblLottoGrade set lg_score = ".$_POST['lg_score_'.$idx].", lg_percent = ".$_POST['lg_percent_'.$idx]." where lg_idx = $idx";
			$mainconn->query($sql);
			goto_url("member_lotto_grade_config.php");
		}

	} else {		// 전체 수정
		foreach ( $_POST as $k => $v ) {
			//echo "$k ==> $v <br>";
			if ( substr($k, 0, 5) == "score" ) {
				$sql = "update tblScoreConfig set score = $v where sc_cid = '".substr($k, 6)."'";
				$mainconn->query($sql);
			} else if ( substr($k, 0, 8) == "lg_score" ) {
				$sql = "update tblLottoGrade set lg_score = $v where lg_idx = ".substr($k, 9);
				$mainconn->query($sql);
			} else if ( substr($k, 0, 10) == "lg_percent" ) {
				$sql = "update tblLottoGrade set lg_percent = $v where lg_idx = ".substr($k, 11);
				$mainconn->query($sql);
			}
			goto_url("member_lotto_grade_config.php");
		}
	}
}


//require_once "../_bottom.php";