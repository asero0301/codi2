<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_main_kwd.php
 * date   : 2009.01.05
 * desc   : 메인 키워드 html 파일 생성
 *			주의 -  파일생성시간을 체크하는게 아니고 어드민에서
 *					입력/수정/삭제시 파일을 다시 생성한다.
 *			/manage/contents/kwd_main_ok.php에 삽입되어 있다.
 *******************************************************/
$kwd_str = "
<table width='200' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td height='48'><img src='/images/keyword_01.gif' width='200' height='48' alt='인기키워드'></td>
	</tr>
	<tr>
		<td align='center' background='/images/keyword_02.gif'>
		<table width='170' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td class=left_height>
	";


$cond = " where 1 and kwd_status = 'M' ";
$orderby = " order by kwd_reg_dt desc ";
$sql = "select kwd from tblKwd $cond $orderby ";

$res = $mainconn->query($sql);

$cnt = 0;
while ( $rows = $mainconn->fetch($res) ) {
	$cnt++;

	$notag_kwd = strip_tags($rows['kwd']);
	$kwd = strip_str(trim($rows['kwd']));
	
	$kwd_str .= "<a href='#' onClick=\"go_kwd_info('$notag_kwd');\">$kwd</a> &nbsp;";

}	// while


$kwd_str .= "
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='14'><img src='/images/keyword_03.gif' width='200' height='14' alt=''></td>
	</tr>
</table>
	";

$fp = fopen($TPL_DIR."/main/main_kwd.tpl", "w");
fwrite($fp, $kwd_str);

?> 