<?
/*━[ 프로그램  정보 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 프로그램 : SuperT / 단체복 제작                                          ┃
┃ 작 성 자 : 최진종 (날으는물고기)                                         ┃
┃ 파일이름 : ordernew_sheet_inc.php                                        ┃
┃ 설    명 : 단체복 제작 주문 견적 입력/수정 공통                          ┃
┃ 사용언어 : PHP/MYSQL                                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

┏━[ 변경이력 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 작업자 작  업  일 변경내용                                               ┃
┃ ------ ---------- ------------------------------------------------------ ┃
┃ 최진종 2007.11.08 최초작성                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/
require_once "../inc/common.inc.php";


// 리퍼러 체크
referer_chk();

$filename = "/coditop/upload/attach/".$_GET["filename"];
$savename = $_GET["savename"];

if(!is_file($filename))
{
	echo "<script> alert('해당 파일이나 경로가 존재하지 않습니다.'); </script>";
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
