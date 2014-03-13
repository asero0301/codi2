<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_gift_list.php
 * date   : 2009.01.05
 * desc   : 메인페이지 당첨자 리스트 proc 파일
 *			주의 -  파일생성시간을 체크하는게 아니고 
 *					perl 스크립트 생성시 마지막 부분에 자동생성
 *			/www/sites/coditop_cron/weekly_lotto.pl에 삽입되어 있다.
 *			현재는 사용하지 않음.....
 *******************************************************/
require_once "/coditop/inc/common.inc.php";
$mainconn->open();


$sql = "select user_mem_id from tblGiftTracking order by gt_idx desc limit 10";
$res = $mainconn->query($sql);

$ids = array();
$cnt= 0;

while ( $rows = $mainconn->fetch($res) ) {

	$user_mem_id = trim($rows['user_mem_id']);
	$user_mem_id = substr($user_mem_id, 0, -2)."**";
	$ids[$cnt] = $user_mem_id;
	$cnt++;
}

$mainconn->close();


	$str = "
	<table width='200' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td height='53'><a href='#'><img src='/images/goodpan_01.gif' alt='당첨자확인하기' width='200' height='53' border='0'></a></td>
		</tr>
		<tr>
			<td height='23'><a href='#'><img src='/images/goodpan_02.gif' alt='최근당첨자확인' width='200' height='23' border='0'></a></td>
		</tr>
		<tr>
			<td height='4'><img src='/images/goodpan_03.gif' width='200' height='4' alt=''></td>
		</tr>
		<tr>
			<td height='90' align='center' valign='top' background='/images/goodpan_04.gif'>
			<table width='198' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='99' height='18'  style='PADDING-LEFT: 10px' class='date' >$ids[0] </td>
					<td width='1' background='img/dot_sero_mini.gif'></td>
					<td width='99'  class='date' style='PADDING-LEFT: 10px'>$ids[1]</td>
				</tr>
				<tr>
					<td height='1' colspan='3' background='img/dot_garo_mini.gif'></td>
				</tr>
				<tr>
					<td width='99' height='18'  style='PADDING-LEFT: 10px' class='date' >$ids[2]</td>
					<td width='1' background='img/dot_sero_mini.gif'></td>
					<td style='PADDING-LEFT: 10px'  class='date'>$ids[3]</td>
				</tr>
				<tr>
					<td height='1' colspan='3' background='img/dot_garo_mini.gif'></td>
				</tr>
				<tr>
					<td width='99' height='18'  style='PADDING-LEFT: 10px' class='date' >$ids[4]</td>
					<td width='1' background='img/dot_sero_mini.gif'></td>
					<td style='PADDING-LEFT: 10px'  class='date'>$ids[5]</td>
				</tr>
				<tr>
					<td height='1' colspan='3' background='img/dot_garo_mini.gif'></td>
				</tr>
				<tr>
					<td width='99' height='18'  style='PADDING-LEFT: 10px' class='date' >$ids[6]</td>
					<td width='1' background='img/dot_sero_mini.gif'></td>
					<td style='PADDING-LEFT: 10px'  class='date'>$ids[7]</td>
				</tr>
				<tr>
					<td height='1' colspan='3' background='img/dot_garo_mini.gif'></td>
				</tr>
				<tr>
					<td width='99' height='18'  style='PADDING-LEFT: 10px' class='date' >$ids[8]</td>
					<td width='1' background='img/dot_sero_mini.gif'></td>
					<td style='PADDING-LEFT: 10px'  class='date'>$ids[9]</td>
				</tr>

			</table>
			</td>
		</tr>
		<tr>
			<td height='4'><img src='/images/goodpan_05.gif' width='200' height='4' alt=''></td>
		</tr>
	</table>
	";


echo $str;
?>