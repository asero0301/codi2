<?
/*��[ ���α׷�  ���� ]��������������������������������������������������������
�� ���α׷� : SuperT / ��ü�� ����                                          ��
�� �� �� �� : ������ (�����¹����)                                         ��
�� �����̸� : ordernew_sheet_inc.php                                        ��
�� ��    �� : ��ü�� ���� �ֹ� ���� �Է�/���� ����                          ��
�� ����� : PHP/MYSQL                                                     ��
������������������������������������������������������������������������������

����[ �����̷� ]��������������������������������������������������������������
�� �۾��� ��  ��  �� ���泻��                                               ��
�� ------ ---------- ------------------------------------------------------ ��
�� ������ 2007.11.08 �����ۼ�                                               ��
����������������������������������������������������������������������������*/
require_once "../inc/common.inc.php";


// ���۷� üũ
referer_chk();

$filename = "/coditop/upload/attach/".$_GET["filename"];
$savename = $_GET["savename"];

if(!is_file($filename))
{
	echo "<script> alert('�ش� �����̳� ��ΰ� �������� �ʽ��ϴ�.'); </script>";
	exit;
}

if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0|MSIE 7.0)", $_SERVER["HTTP_USER_AGENT"]))
{
	Header("Content-type: application/octet-stream");
	Header("Content-Length: ".filesize($filename));
	Header("Content-Disposition: attachment; filename=$savename");
	Header("Content-Transfer-Encoding: binary");
	Header("Pragma: no-cache");
	Header("Expires: 0");
}
else
{
	Header("Content-type: file/unknown");
	Header("Content-Length: ".filesize($filename));
	Header("Content-Disposition: attachment; filename=$savename");
	Header("Content-Description: PHP3 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
}

$fp = fopen($filename, "rb");
if(!fpassthru($fp))
{
	flush($fp);
	fclose($fp);
}

?>
