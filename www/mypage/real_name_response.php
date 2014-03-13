<?
require_once "../inc/common.inc.php";

//###########################################################################################
//#      실명확인서비스 TEST 소스 3   ( For PHP )     한국신용정보(주)						#
//#=========================================================================================#  
//# 처리순서: input.php(소스1)-->request.php(소스2)-->[NICE-SERVER]-->response.php(소스3)	#
//#-----------------------------------------------------------------------------------------#  
//# 1.NICE Server에선 주민등록번호("JUMINNO"),나이스생성키("RELKEY"),응답코드("RETCD")		#
//#   3개의 값만 전송합니다. 각 업체는 응답코드를 통해서 실명확인을 하실 수 있습니다.		#
//# 2.보안을 위해 NICE에서  제공한 업체 ID와 KEY STRING이 정확해야 합니다.					#
//# 3.NICE 로부터 받은 응답코드(RETCD)값이 업체에서 생성한 키(mykey)와						#
//#   다를 경우 에러 표시 후 종료됩니다.													#
//# 4.보안상 이름(nm)은 NICE Server에서 전송하지 않습니다.									#
//#   각 업체에서 쿠키(cookie)나 세션(session)을 사용하셔야합니다.							#
//###########################################################################################

		
//================= 업체키(mykey) 생성 시작 =================================================		
 $mem_jumin	= $_REQUEST[JUMINNO];	//주민등록번호
 $recvkey	= $_REQUEST[RELKEY];	//나이스에서 생성한 키
 $retcd		= $_REQUEST[RETCD];		//응답코드
 $etc_param = $_REQUEST[RETPARAM];	//성명:mem_kind

 $tmp_arr = explode(":", $etc_param);
 $mem_name = $tmp_arr[0];
 $mem_kind = $tmp_arr[1];

// $d=$MINOR;    //성인인증 1:성인 2:미성년자

//### NICE 제공 KEY STRING 을 넣어 주세요. ##################################################
 $KeyString = "ntYHa4dH0mrro43KZcHH3JwJ4874HM5RVtEB6t1akkTXH7Zn2PDVDMHtZvsORU0qrALz7ULKMIY1btBF";
//###########################################################################################
			 		
						
 $PartKey1 = substr($KeyString, (date("m")*30 + date("d")) % 80 , 4);
 $PartKey2 = substr($KeyString, (date("m")*30 + substr($mem_jumin,3,3)) % 80 , 2);
 $PartKey3 = substr($KeyString, (date("m")*30 + $retcd*$retcd) % 80 , 2);
 $PartKey4 = substr($KeyString, (date("m")*30 + substr($mem_jumin,10,3)) % 80 , 2);
 $PartKey5 = $PartKey1.$PartKey2.$PartKey3.$PartKey4;
 $PartKey6 = substr($KeyString, 0, 10-strlen($PartKey5));	
 $mykey = $PartKey5.$PartKey6;
//===================== End ============================================================
/*
$jumin1		= substr($mem_jumin,0,6);
$jumin2		= substr($mem_jumin,6,7);
$jumin		= $jumin1 ."-". $jumin2;
*/
$mem_key	= md5("*^___^*" . $mem_jumin . $mem_name);

//========= 각 응답코드번호 설명(RETCD COMMENT)=========================================
// 각 응답코드번호에 대한 안내메세지는 수정하셔서 사용하셔도 됩니다. 
// RETCD  1= 정상                  -  성명과 주민등록번호가 정상인 경우  
//        2= 성명미일치            -  성명과 주민등록번호가 일치하지 않는 경우
//        3= 성명미보유            -  한국신용정보에 성명이 존재하지 않는 경우
//        4= 나이스성명불완전       -  한국신용정보 보유 성명이 불완전한 경우(ex:박밝호)  
//		  8= 입력값오류(2004.02 추가 ERR_MSG 참고)
//        9= 통신장애              -  일시적인 통신장애인 경우
// ERR_MSG - 기타 장애일 경우 장애 메세지
//=====================================================================================

/*
echo "mem_jumin : $mem_jumin <br>";
echo "recvkey : $recvkey <br>";
echo "retcd : $retcd <br>";
echo "mem_name:ju : $mem_name <br>";
*/


if ($mykey != $recvkey)
{
	echo "<script> alert('☞ 정상응답이 아닙니다.\\n\\n올바른 접속경로로 접근해주세요.'); location.href='/main.php'; </script>";
	exit;
}

else if ($retcd == "1")
{
	$mainconn->open();

	$sql = "select count(*) from tblMember where mem_jumin = '$mem_jumin' and mem_status='Y'";
	$cnt = $mainconn->count($sql);

	if ( $cnt != "0" ) {
		echo "<script>alert('가입된 주민등록번호 입니다.'); location.href='/member/real_chk.php';</script>";
		exit;
	} else {
		if ( $mem_kind == "U" ) {
			echo "<script> location.href = '/member/user_join.php?mem_jumin=".$mem_jumin."&mem_key=".$mem_key."&mem_name=".$mem_name."'; </script>";
		} else if ( $mem_kind == "S" ) {
			echo "<script> location.href = '/member/tmp.php?mem_jumin=".$mem_jumin."&mem_key=".$mem_key."&mem_name=".$mem_name."'; </script>";
		}
		exit;
	}
	$mainconn->close();
}
else if ($retcd == "2" || $retcd == "6" || $retcd == "7")
{
	echo "<script> alert('☞ 성명이 미일치합니다.\\n\\n\\n금융거래가 없었거나 오래된 경우 한국신용정보에 데이타가 없을 수 있습니다.\\n\\n아래의 연락처로 문의하신후 가입해주시기 바랍니다.\\n\\n한국신용정보 Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "3")
{
	echo "<script> alert('☞ 성명 미보유.\\n\\n\\n금융거래가 없었거나 오래된 경우 한국신용정보에 데이타가 없을 수 있습니다.\\n\\n아래의 연락처로 문의하신후 가입해주시기 바랍니다.\\n\\n한국신용정보 Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "4")
{
	echo "<script> alert('☞ 나이스 성명 불완전.\\n\\n\\n금융거래가 없었거나 오래된 경우 한국신용정보에 데이타가 없을 수 있습니다.\\n\\n아래의 연락처로 문의하신후 가입해주시기 바랍니다.\\n\\n한국신용정보 Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "9")
{
	echo "<script> alert('☞ 일시적인 통신장애입니다.\\n\\n잠시 후 다시 시도하세요'); location.href='/main.php'; </script>";
	exit;
}
else
{
	$ERR_MSG = $_REQUEST[ERR_MSG];
	echo "<script> alert('". $ERR_MSG ."'); location.href='/main.php'; </script>";
	exit;
}

?>