<?
session_start();
require_once "../inc/common.inc.php";

if ( $_SESSION['mem_id'] ) {
	echo "<script>alert('�̹� ���ԵǾ� �ֽ��ϴ�'); history.go(-1);</script>";
}

//###########################################################################################
//#			�Ǹ�Ȯ�μ��� TEST �ҽ� 2	 ( For PHP )		 �ѱ��ſ�����(��)				#
//#=========================================================================================#	
//# ó������: input.php(�ҽ�1)-->request.php(�ҽ�2)-->[NICE-SERVER]-->response.php(�ҽ�3)	#
//#-----------------------------------------------------------------------------------------#	 
//# 1. �������� ó���� ���� NICE���� ������ ��ü ID�� KEY STRING�� ��Ȯ�ؾ� �մϴ�.			#
//# 2. �ͻ��� �������ڿ� NICE �������ڰ� �����ؾ� �մϴ�. ��, �����Ͻø� ǥ���Ͻ÷� ����.	#
//###########################################################################################

//### NICE ���� ��üID�� �־��ּ���. ########################################
$id	= "200206_SBT01" ;
//###########################################################################

//### NICE ���� KEY STRING �� �־��ּ���.##########################################################
$KeyString = "ntYHa4dH0mrro43KZcHH3JwJ4874HM5RVtEB6t1akkTXH7Zn2PDVDMHtZvsORU0qrALz7ULKMIY1btBF";
//#################################################################################################

//$juminno = $_REQUEST["JUMINNO"];	//�Է¹��� �ֹε�Ϲ�ȣ('-'����)
//$juminno = str_replace("-", "", $juminno);

$jumin1 = trim($_POST['jumin1']);
$jumin2 = trim($_POST['jumin2']);
$juminno = $jumin1.$jumin2;
$nm		 = $_POST["name"];		//�Է¹��� ����
$mem_kind = $_POST["mem_kind"];






//==========NICE Server�� �������� ����Ű�� sendkey ���� ========================================
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
	<INPUT TYPE="HIDDEN" NAME="JUMINNO" VALUE="<?=$juminno?>">	<!--�ֹε�Ϲ�ȣ-->
	<INPUT TYPE="HIDDEN" NAME="USERNM" VALUE="<?=$nm?>">		<!--����-->
	<INPUT TYPE="HIDDEN" NAME="ID" VALUE="<?=$id?>">			<!--��ü ID-->
	<INPUT TYPE="HIDDEN" NAME="RELKEY" VALUE="<?=$sendkey?>">	<!--�۽�Ű-->
	<!--NICE ������ ���� ����� ������� ��ü��ü URL �� ���� �ϼ���.-->
	<INPUT TYPE="HIDDEN" NAME="RETURL" VALUE="http://www.coditop10.com/member/real_name_response.php">
	<!--�ɼ� �׸� : ��������ҽ�(response.asp)���� ������ �̸����� ���޵� : ���ʿ�� �����ص� ��-->
	<INPUT TYPE="HIDDEN" NAME="RETPARAM" VALUE="<?=$nm?>:<?=$mem_kind?>">  <!--������ �Ķ���ͷ� ���� �� ����-->
	</FORM>
</center>
<script language="javascript">
function go() {
	//�ڵ����� NICE SERVER�� �̵� 
	req_form.submit();		
}
go();
</script>

</BODY>
</HTML>