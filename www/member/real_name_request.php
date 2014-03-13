<?
session_start();
require_once "../inc/common.inc.php";

if ( $_SESSION['mem_id'] ) {
	echo "<script>alert('이미 가입되어 있습니다'); history.go(-1);</script>";
}

//###########################################################################################
//#			실명확인서비스 TEST 소스 2	 ( For PHP )		 한국신용정보(주)				#
//#=========================================================================================#	
//# 처리순서: input.php(소스1)-->request.php(소스2)-->[NICE-SERVER]-->response.php(소스3)	#
//#-----------------------------------------------------------------------------------------#	 
//# 1. 정상적인 처리를 위해 NICE에서 제공한 업체 ID와 KEY STRING이 정확해야 합니다.			#
//# 2. 귀사의 서버일자와 NICE 서버일자가 동일해야 합니다. 즉, 서버일시를 표준일시로 셋팅.	#
//###########################################################################################

//### NICE 제공 업체ID를 넣어주세요. ########################################
$id	= "200206_SBT01" ;
//###########################################################################

//### NICE 제공 KEY STRING 을 넣어주세요.##########################################################
$KeyString = "ntYHa4dH0mrro43KZcHH3JwJ4874HM5RVtEB6t1akkTXH7Zn2PDVDMHtZvsORU0qrALz7ULKMIY1btBF";
//#################################################################################################

//$juminno = $_REQUEST["JUMINNO"];	//입력받은 주민등록번호('-'제외)
//$juminno = str_replace("-", "", $juminno);

$jumin1 = trim($_POST['jumin1']);
$jumin2 = trim($_POST['jumin2']);
$juminno = $jumin1.$jumin2;
$nm		 = $_POST["name"];		//입력받은 성명
$mem_kind = $_POST["mem_kind"];






//==========NICE Server에 전송위한 인증키인 sendkey 생성 ========================================
$PartKey1 = substr($KeyString, (date("m")*30 + date("d")) % 80 , 4);
$PartKey2 = substr($KeyString, (date("m")*30 + substr($juminno,3,3)) % 80 , 4);
$PartKey3 = substr($KeyString, (date("m")*30 + substr($juminno,10,3)) % 80 , 2);
$PartKey4 = $PartKey1.$PartKey2.$PartKey3;
$PartKey5 = substr($KeyString, 0, 10 - strlen($PartKey4) );		
$sendkey = $PartKey4.$PartKey5;		
//===============================================================================================

?>

<HTML>

<BODY>
<center>
	<FORM NAME="req_form" METHOD="POST" ACTION="https://secure.nuguya.com/nuguya/service/realname/nmcfm.do">
	<INPUT TYPE="HIDDEN" NAME="JUMINNO" VALUE="<?=$juminno?>">	<!--주민등록번호-->
	<INPUT TYPE="HIDDEN" NAME="USERNM" VALUE="<?=$nm?>">		<!--성명-->
	<INPUT TYPE="HIDDEN" NAME="ID" VALUE="<?=$id?>">			<!--업체 ID-->
	<INPUT TYPE="HIDDEN" NAME="RELKEY" VALUE="<?=$sendkey?>">	<!--송신키-->
	<!--NICE 서버로 부터 결과를 응답받을 업체전체 URL 을 지정 하세요.-->
	<INPUT TYPE="HIDDEN" NAME="RETURL" VALUE="http://www.coditop10.com/member/real_name_response.php">
	<!--옵션 항목 : 최종응답소스(response.asp)까지 동일한 이름으로 전달됨 : 불필요시 삭제해도 됨-->
	<INPUT TYPE="HIDDEN" NAME="RETPARAM" VALUE="<?=$nm?>:<?=$mem_kind?>">  <!--성명을 파라메터로 받을 수 있음-->
	</FORM>
</center>
<script language="javascript">
function go() {
	//자동으로 NICE SERVER로 이동 
	req_form.submit();		
}
go();
</script>

</BODY>
</HTML>