<?
require_once "../inc/common.inc.php";

//###########################################################################################
//#      �Ǹ�Ȯ�μ��� TEST �ҽ� 3   ( For PHP )     �ѱ��ſ�����(��)						#
//#=========================================================================================#  
//# ó������: input.php(�ҽ�1)-->request.php(�ҽ�2)-->[NICE-SERVER]-->response.php(�ҽ�3)	#
//#-----------------------------------------------------------------------------------------#  
//# 1.NICE Server���� �ֹε�Ϲ�ȣ("JUMINNO"),���̽�����Ű("RELKEY"),�����ڵ�("RETCD")		#
//#   3���� ���� �����մϴ�. �� ��ü�� �����ڵ带 ���ؼ� �Ǹ�Ȯ���� �Ͻ� �� �ֽ��ϴ�.		#
//# 2.������ ���� NICE����  ������ ��ü ID�� KEY STRING�� ��Ȯ�ؾ� �մϴ�.					#
//# 3.NICE �κ��� ���� �����ڵ�(RETCD)���� ��ü���� ������ Ű(mykey)��						#
//#   �ٸ� ��� ���� ǥ�� �� ����˴ϴ�.													#
//# 4.���Ȼ� �̸�(nm)�� NICE Server���� �������� �ʽ��ϴ�.									#
//#   �� ��ü���� ��Ű(cookie)�� ����(session)�� ����ϼž��մϴ�.							#
//###########################################################################################

		
//================= ��üŰ(mykey) ���� ���� =================================================		
 $mem_jumin	= $_REQUEST[JUMINNO];	//�ֹε�Ϲ�ȣ
 $recvkey	= $_REQUEST[RELKEY];	//���̽����� ������ Ű
 $retcd		= $_REQUEST[RETCD];		//�����ڵ�
 $etc_param = $_REQUEST[RETPARAM];	//����:mem_kind

 $tmp_arr = explode(":", $etc_param);
 $mem_name = $tmp_arr[0];
 $mem_kind = $tmp_arr[1];

// $d=$MINOR;    //�������� 1:���� 2:�̼�����

//### NICE ���� KEY STRING �� �־� �ּ���. ##################################################
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

//========= �� �����ڵ��ȣ ����(RETCD COMMENT)=========================================
// �� �����ڵ��ȣ�� ���� �ȳ��޼����� �����ϼż� ����ϼŵ� �˴ϴ�. 
// RETCD  1= ����                  -  ����� �ֹε�Ϲ�ȣ�� ������ ���  
//        2= �������ġ            -  ����� �ֹε�Ϲ�ȣ�� ��ġ���� �ʴ� ���
//        3= ����̺���            -  �ѱ��ſ������� ������ �������� �ʴ� ���
//        4= ���̽�����ҿ���       -  �ѱ��ſ����� ���� ������ �ҿ����� ���(ex:�ڹ�ȣ)  
//		  8= �Է°�����(2004.02 �߰� ERR_MSG ����)
//        9= ������              -  �Ͻ����� �������� ���
// ERR_MSG - ��Ÿ ����� ��� ��� �޼���
//=====================================================================================

/*
echo "mem_jumin : $mem_jumin <br>";
echo "recvkey : $recvkey <br>";
echo "retcd : $retcd <br>";
echo "mem_name:ju : $mem_name <br>";
*/


if ($mykey != $recvkey)
{
	echo "<script> alert('�� ���������� �ƴմϴ�.\\n\\n�ùٸ� ���Ӱ�η� �������ּ���.'); location.href='/main.php'; </script>";
	exit;
}

else if ($retcd == "1")
{
	$mainconn->open();

	$sql = "select count(*) from tblMember where mem_jumin = '$mem_jumin' and mem_status='Y'";
	$cnt = $mainconn->count($sql);

	if ( $cnt != "0" ) {
		echo "<script>alert('���Ե� �ֹε�Ϲ�ȣ �Դϴ�.'); location.href='/member/real_chk.php';</script>";
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
	echo "<script> alert('�� ������ ����ġ�մϴ�.\\n\\n\\n�����ŷ��� �����ų� ������ ��� �ѱ��ſ������� ����Ÿ�� ���� �� �ֽ��ϴ�.\\n\\n�Ʒ��� ����ó�� �����Ͻ��� �������ֽñ� �ٶ��ϴ�.\\n\\n�ѱ��ſ����� Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "3")
{
	echo "<script> alert('�� ���� �̺���.\\n\\n\\n�����ŷ��� �����ų� ������ ��� �ѱ��ſ������� ����Ÿ�� ���� �� �ֽ��ϴ�.\\n\\n�Ʒ��� ����ó�� �����Ͻ��� �������ֽñ� �ٶ��ϴ�.\\n\\n�ѱ��ſ����� Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "4")
{
	echo "<script> alert('�� ���̽� ���� �ҿ���.\\n\\n\\n�����ŷ��� �����ų� ������ ��� �ѱ��ſ������� ����Ÿ�� ���� �� �ֽ��ϴ�.\\n\\n�Ʒ��� ����ó�� �����Ͻ��� �������ֽñ� �ٶ��ϴ�.\\n\\n�ѱ��ſ����� Tel. 1588-2486 Fax. 02-2122-4599'); location.href='/main.php'; </script>";
	exit;
}
else if ($retcd == "9")
{
	echo "<script> alert('�� �Ͻ����� �������Դϴ�.\\n\\n��� �� �ٽ� �õ��ϼ���'); location.href='/main.php'; </script>";
	exit;
}
else
{
	$ERR_MSG = $_REQUEST[ERR_MSG];
	echo "<script> alert('". $ERR_MSG ."'); location.href='/main.php'; </script>";
	exit;
}

?>