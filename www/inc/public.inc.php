<?
/*━[ 프로그램  정보 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 프로그램 : public (공통함수) Ver 1.00                                    ┃
┃ 작 성 자 : 이광철 (따식이)                                               ┃
┃ 화일이름 : public.inc.php                                                ┃
┃ 설    명 : 가장 기본적인 함수로 다양한 곳에서 활용하기 위히 제작         ┃
┃ 사용언어 : PHP                                                           ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

┏━[ 변경이력 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 작업자 작  업  일 변경내용                                               ┃
┃ ------ ---------- ------------------------------------------------------ ┃
┃ 이광철 2007.02.09 최초작성                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/



// 1970년부터 오늘에 해당하는 초로 환산된 값
$TodaySec = time(0)-(date(G)*3600)-(date(i)*60)-(date(s));

$SelfUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$SelfUri = "$_SERVER[REQUEST_URI]";

$self     = $_SERVER["SCRIPT_NAME"];
$Self     = $_SERVER["SCRIPT_NAME"];
$RemoteIP = $_SERVER["REMOTE_ADDR"];
$Month    = date("Y-m");
$Date     = date("Y-m-d");            // 오늘 날짜 (예: 2007-01-02)
$Time     = time(0);                  // 1970년부터 현재까지 초로 환산된 값 (UNIX_TIMESTAMP)

$TodayTime = strtotime($Date);

$ServerName = $_SERVER["HTTP_HOST"] ;

// 로그인했을때 퀵메뉴 정보 html을 구한다.
// 경품 확인하고 안하고 차이는 gt_reg_dt 값과 status_reg_dt 가 같느냐 그렇지 않느냐에 따라 달라지낟.
// gt_reg_dt 와 status_reg_dt 값이 같으면 아직 확인 안한것이다.
function make_quick_html( $id, $kind ) {
	global $_SESSION;

	// 받은쪽지 갯수(보관함 포함)
	$msg_cnt = $_SESSION['my_quick_msg_total'];

	// 읽지않은 쪽지 갯수
	$noread_msg_cnt = $_SESSION['my_quick_msg_noread'];

	$memo_icon = ( $noread_msg_cnt ) ? "icon_memo_ov.gif" : "icon_memo.gif";

	$chk_gift_cnt = $_SESSION['my_not_notify_gift_cnt'];	// 확인하지 않은 경품수(샵,일반회원 다 쓰이지만 쿼리는 다르다)

	if ( $kind == "U" ) {
		
		// 확인안한 당첨 내역이 있을때
		if ( $chk_gift_cnt ) {
			$str = "
			<table width='110' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='39'><img src='/images/myquick_01.gif' width='110' height='39' alt=''></td>
				</tr>
				<tr>
					<td  align='left' valign='top'>
					<table width='110' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='19' align='center' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><font color='#FFFFFF'>축하드립니다.</font></td>
								</tr>

							</table>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='120' align='center' class='textlevel'><a href='/mypage/history.php'><img src='/img_seri/quick_ol.gif' width='100' height='199' border='0'></a></td>
								</tr>
								<tr>
									<td height='5'></td>
								</tr>
							</table>
							<table width='104' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td  align='center' class='evgray'>코디상품평가로 당첨된 경품내역이 있습니다.</td>
								</tr>
								<tr>
									<td height='27' align='center' class='evgray'><a href='/mypage/history.php'><b><font color='#FF6600'>경품당첨내역확인 ></font></b></a></td>
								</tr>
							</table>
							</td>
							<td width='6' bgcolor='FF5B5C'></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td height='16'><a href='#'><img src='/images/myquick_03.gif' alt='맨위로' width='110' height='16' border='0'></a></td>
				</tr>
			</table>
			";

		} else {	// 당첨 확인내역이 없을때

			// 내가 평가한 코디 갯수
			$codi_cnt = $_SESSION['my_updown_codi_cnt'];

			// 내가 수령한 경품 갯수
			$gift_cnt = $_SESSION['my_get_gift_cnt'];

			// 7일간 당첨 등급
			$my_grade = $_SESSION['mem_grade'];

			// 당첨확률
			$my_percent = $_SESSION['mem_percent'];

			$str = "
			<table width='110' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='39'><img src='/images/myquick_01.gif' width='110' height='39' alt=''></td>
				</tr>
				<tr>
					<td  align='left' valign='top'>
					<table width='110' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/msg/msg_recv_list.php'><font color='#FFFFFF'>쪽지:<font color='#FFFF00'><b><span id='my_quick_msg_noread_area'>{$noread_msg_cnt}</span></b></font>/<span id='my_quick_msg_total_area'>{$msg_cnt}</span></font> <img id='quick_msg_icon' src='/img/{$memo_icon}' width='12' height='14' align='absmiddle' border='0' /></a></td>
								</tr>
								<tr>
									<td height='3'></td>
								</tr>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/mypage/comment.php'><font color='#FFFFFF'>참여중평가:<span id='my_updown_codi_cnt_area'>{$codi_cnt}</span></a>개</font></a> </td>
								</tr>
								<tr>
									<td height='3'></td>
								</tr>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/mypage/history.php'><font color='#FFFFFF'>경품수령:<span id='my_get_gift_cnt_area'>{$gift_cnt}</span>개 </font></a> </td>
								</tr>
							</table>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='22' align='center' valign='top' class='evgray'><b><font color='#000000'>7일간 내당첨 등급</font></b></td>
								</tr>
								<tr>
									<td><img src='/img/quick_level.gif' width='100' height='50'></td>
								</tr>
								<tr>
									<td height='33' align='center' class='textlevel'><b><span style='filter:dropshadow(color=black,offy=1,offx=1);width:100px;height:33px'><span id='my_quick_grade_area'>{$my_grade}</span>등급</span></b></td>
								</tr>
								<tr>
									<td height='5'></td>
								</tr>
							</table>
							<table width='104' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='21' align='center' valign='top' bgcolor='f2f2f2' class='evgray'>당첨확률 <span id='my_quick_percent_area'>{$my_percent}</span>% 증가 </td>
								</tr>
								<tr>
									<td height='25' align='center' class='evgray'><b><font color='#FF6600'><a href='/mypage/level.php'>당첨등급확인내역</a></font></b></td>
								</tr>
								<tr>
									<td height='1' align='center' background='/img/dot_garo_max.gif' class='evgray'></td>
								</tr>
							</table>
							
							</td>
							<td width='6' bgcolor='FF5B5C'></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td height='16'><a href='#'><img src='/images/myquick_03.gif' alt='맨위로' width='110' height='16' border='0'></a></td>
				</tr>
			</table>
			";
		}


	} else if ( $kind == "S" ) {	// 샵 회원

		// 확인안한 당첨 내역이 있을때
		if ( $chk_gift_cnt ) {
			$str = "
			<table width='110' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='39'><img src='/images/myquick_01.gif' width='110' height='39' alt=''></td>
				</tr>
				<tr>
					<td  align='left' valign='top'>
					<table width='110' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='19' align='center' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'><font color='#FFFFFF'>코디상품 경품지급</font></td>
								</tr>
							</table>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='170' align='center' class='textlevel'><a href='/mypage/Mgift.php'><img src='/img_seri/quick_eend.gif' width='100' border='0' /></a></td>
								</tr>
								<tr>
									<td height='5'></td>
								</tr>
							</table>
							<table width='104' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td  align='center' class='evgray'>평가 완료된 상품중에 경품지급조건을 <br>만족시켜서, 지급해야 할 경품이 있습니다.</td>
								</tr>
								<tr>
									<td height='27' align='center' class='evgray'><a href='/mypage/Mgift.php'><b><font color='#FF6600'>경품지급내역확인 ></font></b></a></td>
								</tr>
							</table>
							</td>
							<td width='6' bgcolor='FF5B5C'></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td height='16'><a href='#'><img src='/images/myquick_03.gif' alt='맨위로' width='110' height='16' border='0'></a></td>
				</tr>
			</table>
			";

		} else {	// 당첨 내역이 없을때
			
			$ing_codi_cnt = $_SESSION['my_ing_codi_cnt'];	// 평가중인 코디수
			$ed_codi_cnt = $_SESSION['my_ed_codi_cnt'];		// 평가완료된 코디수

			$last_rank = $_SESSION['main_shop_last_rank'];		// 지난주 순위
			$total_rank = $_SESSION['main_shop_total_rank'];	// 전체 순위

			$my_cash = $_SESSION['mem_cash'];				// 현재캐시

			$str = "
			<table width='110' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='39'><img src='/images/myquick_01.gif' width='110' height='39' alt=''></td>
				</tr>
				<tr>
					<td  align='left' valign='top'>
					<table width='110' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/msg/msg_recv_list.php'><font color='#FFFFFF'>쪽지:<font color='#FFFF00'><b><span id='my_quick_msg_noread_area'>{$noread_msg_cnt}</span></b></font>/<span id='my_quick_msg_total_area'>{$msg_cnt}</span></font> <img id='quick_msg_icon' src='/img/{$memo_icon}' width='12' height='14' align='absmiddle' border='0' /></a></td>
								</tr>
								<tr>
									<td height='3'></td>
								</tr>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/mypage/Mcodi.php'><font color='#FFFFFF'>평가중코디:<span id='my_ing_codi_cnt_area'>{$ing_codi_cnt}</span>개</font></a> </td>
								</tr>
								<tr>
									<td height='3'></td>
								</tr>
								<tr>
									<td height='19' bgcolor='FF5C5C' class='tienom'  style='PADDING-LEFT: 6px'  ><a href='/mypage/Mcodi.php'><font color='#FFFFFF'>완료코디:<span id='my_ed_codi_cnt_area'>{$ed_codi_cnt}</span>개 </font></a> </td>
								</tr>
							</table>
							<table width='100' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='22' align='center' valign='top' class='evgray'><b><font color='#000000'>지난주 코디샵 순위</font></b></td>
								</tr>
								<tr>
									<td><img src='/img/quick_level.gif' width='100' height='50'></td>
								</tr>
								<tr>
									<td height='33' align='center' class='textlevel'><b><span style='filter:dropshadow(color=black,offy=1,offx=1);width:100px;height:33px'> 			<span id='main_shop_last_rank_area'>{$last_rank}</span>위</span></b></td>
								</tr>
								<tr>
									<td height='5'></td>
								</tr>
							</table>
							<table width='104' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td height='21' align='center' valign='top' bgcolor='f2f2f2' class='evgray'>전체 순위 <b><span id='main_shop_total_rank_area'>{$total_rank}</span></b> 위 </td>
								</tr>
								<tr>
									<td height='21' align='center' class='evgray'><b><font color='#FF6600'>캐쉬 <span id='my_quick_cash_area'>".number_format($my_cash)."</span></font></b> | <b><a href='/mypage/Mcash.php'>충전</a></b></td>
								</tr>
								<tr>
									<td height='1' align='center' background='/img/dot_garo_max.gif' class='evgray'></td>
								</tr>
							</table>
							<table width='100' height='65' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td><a href='/mypage/product_in01.php'><img src='/img_seri/btn_codi_in.gif' border=0></a></td>
								</tr>
							</table>
							</td>
							<td width='6' bgcolor='FF5B5C'></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td height='16'><a href='#'><img src='/images/myquick_03.gif' alt='맨위로' width='110' height='16' border='0'></a></td>
				</tr>
			</table>
			";
		}

	}
	
	return $str;
}


function randNum($nums)
{
	$persent = 0;
	$total   = 0;
	$ran     = 0;
	$num     = 0;

	for($i=0; $i<count($nums)/2; $i++)
		$total +=  $nums[$i*2+1];

	$ran = rand(1, $total);

	for($i=0; $i<count($nums)/2; $i++)
	{
		$persent += $nums[$i*2+1];
		if($ran <= $persent)
		{
			$num = $nums[$i*2];
			break;
		}
	}
		
	return $num;
}


function DAY2SEC($day)
{
	return $day*86400;
}

function HOUR2SEC($hour)
{
	return $hour*3600;
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function MIN2SEC()                                            ┃
┃ 설    명 : 시간을 분으로 환산                                            ┃
┃ 입 력 값 : $hour = 분으로 환산할 시                                      ┃
┃ 리 턴 값 : 키값                                                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function MIN2SEC($hour)
{
	return $hour*60;
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function make_seed()                                          ┃
┃ 설    명 : 랜덤키 생성                                                   ┃
┃ 리 턴 값 : 키값                                                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function make_seed()
{
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}

// 랜덤값이 항상 다르게 나올수 있도록 초기화
srand(make_seed());
mt_srand(make_seed());



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function NoCache()                                            ┃
┃ 설    명 : 브라우져 캐시가 적용되지 않도록 설정                          ┃
┃            사용시 html보다 먼저 사용해야됨                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function NoCache()
{
	header("cache-control: no-cache,must-revalidate"); 
	header("pragma: no-cache");
	header("P3P: CP='CAO PSA CONi OTR OUR DEM ONL'");
}


function CloseMsg($msg)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	echo "window.resizeTo(1, 1);\n";
	echo "window.moveTo(2000, 2000);\n";
	echo "alert(\"$msg\");\n";
	echo "\nwindow.close();\n-->\n</script>";
	exit(0);
}


function ParentCloseMsg($msg, $preload=null)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	if($preload != null)
		echo "parent.window.opener.location.reload()\n";

	echo "window.resizeTo(1, 1);\n";
	echo "parent.moveTo(2000, 2000);\n";
	echo "alert(\"$msg\");\n";
	echo "\nparent.close();\n-->\n</script>";
	exit(0);
}

function BackMsg($msg)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	echo "alert(\"$msg\");\n";
	echo "\nhistory.back();\n-->\n</script>";
	exit(0);
}


function LocationURL($url)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	echo "location.href='$url'\n";
	echo "\n-->\n</script>";
	exit(0);
}




function LocationReplace($url)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	echo "location.replace('$url')\n";
	echo "\n-->\n</script>";
	exit(0);
}




function ExitMsg($msg)
{
	echo "<script language=javascript>\n";
	echo "<!--\n";
	echo "alert(\"$msg\");\n";
	echo "\n-->\n</script>";
	exit(0);
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function QueryHTTP()                                          ┃
┃ 설    명 : 소켓을 이용하여 URL에 해당하는 데이타 가져오기 (내부통신용)   ┃
┃ 입 력 값 : $url    = 접속할 페이지 (http://test.com:8000/index.html)     ┃
┃            $header = 헤더 사용할지 여부                                  ┃
┃ 리 턴 값 : 데이타                                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function QueryHTTP($url, $header=false)
{
	$url_stuff = parse_url($url); 

	if(strlen($url_stuff["port"]) < 2)
	{
		$url_stuff["port"] = 80;
	}

	if (!($fp = fsockopen($url_stuff["host"], $url_stuff["port"], $errorno, $errstr, 15)))
	{
		return "";
	}

	fputs($fp, "GET $url_stuff[path]?$url_stuff[query] HTTP/1.0\r\n"); 
	fputs($fp, "Host: $url_stuff[host]\r\n"); 
	fputs($fp, "Cookie: $_SERVER[HTTP_COOKIE]\r\n");;
	fputs($fp, "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n");
	fputs($fp, "Referer: $_SERVER[HTTP_REFERER]\r\n");
	fputs($fp, "Connection: close\r\n\r\n"); 

	while(!feof($fp))
	{
		$info .= fgets($fp, 1024);
	}

	fclose($fp);

	if($header == false)
	{
		$info = strstr($info, "\r\n\r\n");
	}

	return $info;
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function QueryHTTPArgs()                                      ┃
┃ 설    명 : 소켓을 이용하여 URL에 해당하는 데이타 가져오기 (내부통신용)   ┃
┃            받아온 내용중에 &와 =를 기준으로 분석하여 배열에 저장         ┃
┃                                                                          ┃
┃            $ret = QueryHTTPArgs("http://test.com:8000/index.html");      ┃
┃            $ret의 값이 &name=이광철&email=lkc7605@paran.com 라면         ┃
┃            echo $ret["name"]; 이런형태로 활용                            ┃
┃                                                                          ┃
┃ 입 력 값 : $url    = 접속할 페이지 (http://test.com:8000/index.html)     ┃
┃ 리 턴 값 : 배열로 된 데이타                                              ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function QueryHTTPArgs($url)
{
	parse_str(QueryHTTP($url), $ret);

	return $ret;
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function CutStr()                                             ┃
┃ 설    명 : 문자열 길이를 잘라준다.                                       ┃
┃            $ret = QueryHTTPArgs("http://test.com:8000/index.html");      ┃
┃            $ret의 값이 &name=이광철&email=lkc7605@paran.com 라면         ┃
┃            echo $ret["name"]; 이런형태로 활용                            ┃
┃                                                                          ┃
┃ 입 력 값 : $str  = 문자열                                                ┃
┃            $len  = 자를 문자열 길이 (영문기준)                           ┃
┃            $tail = $len보다 클시 문자열 짜르고 문자열 뒤에 추가할 문자   ┃
┃ 리 턴 값 : 가공된 문자열                                                 ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function CutStr($str, $len, $tail="...")
{
	if(strlen($str)>$len)
	{
		for($i=0; $i<$len; $i++)
		{
			if(ord($str[$i])>127)
				$i++;
		}

		$str=substr($str, 0, $i);
		$str .= $tail;
	}

	return $str;
}



function str2hash($s, $hash)
{
	$h=0;
	$g=0;

	for($i=0; $i<strlen($s); $i++)
	{
		$h = ($h << 4) + ord($s[$i]);
		if (($g = ($h & 0xF0000000)))
		{
			$h = $h ^ ($g >> 24);
			$h = $h ^ $g;
		}
	}

	return $h%$hash;
}




/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function my64encode()                                         ┃
┃ 설    명 : 문자열 base64encode & 암호화                                  ┃
┃ 입 력 값 : $str  = 암호화할 문자열                                       ┃
┃ 리 턴 값 : 암호화된 문자열                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

$ekey = "s912edgh9187272dg1297127ddfiuhzvclkzxkcvj1-09djh20eu0=pw[]l,2e12;";

function my64encode( $str )
{
	global $ekey;
	$epos = 0;

	for($i=0; $i<strlen($str); $i++)
	{
		$str[$i] = $str[$i] ^ $ekey[$epos++];
		if($ekey[$epos] == ';')
			$epos = 0;
	}

	return base64_encode($str);
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function my64decode()                                         ┃
┃ 설    명 : 문자열 base64decode & 복호화                                  ┃
┃ 입 력 값 : $str  = 암호화된 문자열                                       ┃
┃ 리 턴 값 : 복호화된 문자열                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function my64decode( $str )
{
	global $ekey;
	$epos = 0;

	$str = base64_decode($str);

	for($i=0; $i<strlen($str); $i++)
	{
		$str[$i] = $str[$i] ^ $ekey[$epos++];
		if($ekey[$epos] == ';')
			$epos = 0;
	}

	return $str;
}


function str64encode($str)
{
	return str_replace("=", "~", my64encode($str));
}

function str64decode($str)
{
	return my64decode(str_replace("~", "=", $str));
}


function Num2Hangul($num, $nclass=null, $hclass=null)
{
	if($num < 1)
	{
		$ret = 0;
		if($hclass != null)
			$com[$i] = "<font class=$hclass>0</font>";

		return $ret;
	}
	
	$ret = "";
	$len  = strlen($num);
	$div = floor($len/4);
	$per = $len % 4;
	$res = Array();
	$com = Array("", "만 ", "억 ", "조 ", "경 ", "해 ");

	for($i=0; $i<$div; $i++)
	{
		$res[$i] = substr($num, $len-($i*4+4), 4);
	}

	if($per != 0)
		$res[count($res)] = substr($num, 0, $per);

	for($i=0; $i<count($res); $i++)
	{
		if((int)($res[$i]) != 0)
		{
			if($hclass != null)
				$com[$i] = "<font class=$hclass>".$com[$i]."</font>";

			$res[$i] = (int)($res[$i]);

			if($nclass != null)
				$res[$i] = "<font class=$nclass>".$res[$i]."</font>";
			
			$res[$i] = $res[$i].$com[$i];
		}
		else
		{
			$res[$i] = "";
		}

		$ret = $res[$i].$ret;
	}

	return $ret;
}





function DelFiles($dir)
{
	if (is_dir($dir) == null)
		return;

	if(($dh = opendir($dir)) == null)
		return;

	while (($file = readdir($dh)) !== false)
	{
		if(strlen($file) < 5)
			continue;

		unlink($dir.$file);
	}

	closedir($dh);
}



/*━[ 함수설명 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 함 수 명 : function GetUniq()                                            ┃
┃ 설    명 : 중복되지 않는 코드 생성시 사용                                ┃
┃ 리 턴 값 : 중복되지 않는 코드값                                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function GetUniq()
{
	$mtime = explode(" ", microtime());
	$ret = sprintf("%x%x%x", $mtime[0], $mtime[1], mt_rand()%65535);

	return $ret;
}


function GetShortUniq()
{
	$mtime = explode(" ", microtime());
	$ret = sprintf("%x%x", $mtime[0], $mtime[1]);

	return $ret;
}



function SaveFile($file, $str)
{
	$fp = @fopen($file, "w");
	if($fp != null)
	{
		fputs($fp, $str);
		fclose($fp);
	}
}


function LoadFile($file)
{
//	if(!eregi("http://", $file))
	if(!preg_match("#http://#i", $file))
		return join ('', @file($file));
	else
	{
		return QueryHTTP($file);
	}
}


function CacheLoadFile($file, $url, $dtime)
{
	global $Time;

	$ftime = (int)(@filemtime($file));
	if($ftime >= $Time-$dtime)
	{
		echo LoadFile($file);
	}
	else
	{
		$str = LoadFile($url);
		echo $str;
		
		SaveFile($file, $str);
	}
}



function IsRandApply($percent)
{
	$rnd = mt_rand(1, 100);

	if($rnd <= $percent)
		return true;

	return false;
}



function DateDiff($dat1, $dat2)
/* Dat1 and Dat2 passed as "YYYY-MM-DD" */
{
	$tmp_dat1 = mktime(0,0,0,
		substr($dat1,5,2),substr($dat1,8,2),substr($dat1,0,4));
	$tmp_dat2 = mktime(0,0,0,
		substr($dat2,5,2),substr($dat2,8,2),substr($dat2,0,4));

	$yeardiff = date('Y',$tmp_dat1)-date('Y',$tmp_dat2);
	/* a leap year in every 4 years and the days-difference */
	$diff = date('z',$tmp_dat1)-date('z',$tmp_dat2) + 
		floor($yeardiff /4)*1461;

	/* remainder */
	for ($yeardiff = $yeardiff % 4; $yeardiff>0; $yeardiff--)
	{
		$diff += 365 + date('L',
			mktime(0,0,0,1,1,
			intval(
				substr(
					(($tmp_dat1>$tmp_dat2) ? $dat1 : $dat2),0,4))
				-$yeardiff+1));
	}

	return $diff;
}



// 나이체크하는 함수..
// My function for returning an age. e.g. 23 and 129 days
function GetAge($DOB) // YYYY-MM-DD
{
	// Split $DOB
	$DOBArray = explode("-", $DOB);
	$DobYear = $DOBArray[0];
	$DobMonth = $DOBArray[1];
	$DobDay = $DOBArray[2];
	
	// Get today's year, month and day
	$TodayDay = date('d');
	$TodayMonth = date('m');
	$TodayYear = date('Y');

	// Work out Age in Years
	if (($TodayMonth > $DOBArray[1]) || (($TodayMonth == $DOBArray[1]) && ($TodayDay >= $DOBArray[2])))
	{
		$AgeYear = $TodayYear - $DOBArray[0];
	}
	else
	{
		$AgeYear = $TodayYear - $DOBArray[0] - 1;
	}
	
	return $AgeYear;
}

function ChkHtml($str)
{
	if ($str == "")
		return;

//	$str = stripslashes($str) ;
//	$str = htmlspecialchars($str) ;
	$str = str_replace("<", "&lt;", $str);
	$str = str_replace("\\", "", $str);
	$str = nl2br($str) ;

	return $str;
}




/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * date   : 2008.08.07
 * desc   : Public Function
 *******************************************************/
function goto_url($url, $alert = 0 ) {
	/*
	echo "<script>alert('처리되었습니다');</script>";
	echo "<meta http-equiv='refresh' content='0; URL=$url'>";
	*/
	if ( $alert ) {
		//echo "<script>alert('$alert');</script>";
		//echo "<meta http-equiv='refresh' content='0; URL=$url'>";
		echo "
		<form name='refresh_f' method='post' action='$url'>
		<span id='blahlayer'><input type='text' name='blahblah' id='blahblah' /></span>
		</form>
		<script language='javascript'>
			alert('$alert');
			document.getElementById('blahlayer').style.display = 'none';
			document.refresh_f.submit();
		</script>
		";
	} else {
		//echo "<meta http-equiv='refresh' content='0; URL=$url'>";
		echo "
		<form name='refresh_f' method='post' action='$url'>
		<span id='blahlayer'><input type='text' name='blahblah' id='blahblah' /></span>
		</form>
		<script language='javascript'>
			document.getElementById('blahlayer').style.display = 'none';
			document.refresh_f.submit();
		</script>
		";
	}
}

// authentication check
function auth_chk($base64url) {
	global $_SESSION;
	
	if ( !$_SESSION['mem_id'] or $_SESSION['mem_id'] == null ) {
		echo "<script>alert('로그인하셔야 합니다.'); location.href='/member/login.php?rurl=$base64url';</script>";
		exit;
	}
}

// join check
function join_chk() {
	global $_SESSION;
	
	if ( strlen($_SESSION['mem_id']) > 3 ) {
		echo "<script>alert('이미 가입되어 있습니다.'); history.back();</script>";
		exit;
	}
}

// popup authentication check
function pop_auth_chk() {
	global $_SESSION;
	
	if ( !$_SESSION['mem_id'] or $_SESSION['mem_id'] == null ) {
		echo "<script>alert('로그인 하셔야 합니다.'); opener.location.href='/member/login.php'; self.close();</script>";
		exit;
	}
}

// admin authentication check
function admin_auth_chk() {
	global $_SESSION;
	global $ADMIN_AUTH;

	if ( !$_SESSION['admin_id'] or $_SESSION['admin_id'] == null ) {
		echo "<script>alert('관리자 인증이 되지 않았습니다.'); location.href='$ADMIN_AUTH';</script>";
		exit;
	}
}

// referer check
function referer_chk() {
	/*
	global $_SERVER;

	if ( strpos($_SERVER['HTTP_REFERER'], "http://".$_SERVER['HTTP_HOST']) === false ) {
		echo "<script>alert('잘못된 경로접근 입니다'); history.go(-1);</script>";
		exit;
	}
	*/
}

// popup referer check
function pop_referer_chk() {
	global $_SERVER;

	if ( strpos($_SERVER['HTTP_REFERER'], "http://".$_SERVER['HTTP_HOST']) === false ) {
		echo "<script>alert('잘못된 경로접근 입니다'); self.close();</script>";
		exit;
	}
}


// sql injection check
function sql_injection_chk($id,$pw) {
	if ( ereg("['\"]", $id) or ereg("['\"]", $pw) ) {
		echo "<script>alert('잘못된 문자열 입니다.'); history.go(-1);</script>";
		exit;
	}
}

// mobile,hp print
// 0196122632
// 01095876520
function phone_disp($str) {
	/*
	$ret = "";
	if ( strlen($str) == 12 ) {
		$ret = substr($str, 0, 3)."-".substr($str, 3, 3)."-".substr($str, 6, 4);
	} else {
		$ret = substr($str, 0, 3)."-".substr($str, 3, 4)."-".substr($str, 7, 4);
	}
	*/
	return $ret;
	
}

// admin page navigation
function admin_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$list_url,$qry_str) {
	global $ADMIN_DIR;
	$navi = "<table border='0' cellspacing='0' cellpadding='0'><tr>";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<td width='7'><a href='$list_url?page=$my_page$qry_str'><img src='board_img/btn_pre.gif' width='7' height='7' border='0'></a></td>";
	} else {
		$navi .= "<td width='7'><img src='{$ADMIN_DIR}board_img/btn_pre.gif' width='7' height='7' border='0'></td>";
	}

	$navi .= "<td align='center' style='padding-left:10;padding-right:10;padding-bottom:2'>";
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
	    if ( $page == $direct_page ) {
	        $navi .= "<font color='#FF6600'><b><span class='date'>$direct_page</span></b></font>&nbsp;";
	    } else {
	        $navi .= "<a href='$list_url?page=$direct_page$qry_str' class='page'>$direct_page</a>&nbsp;";
	    }
	}
	$navi .= "</td>";

	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<td width='7' align='right'><a href='$list_url?page=$my_page$qry_str'><img src='board_img/btn_next.gif' width='7' height='7' border='0'></a></td>";
	} else {
		$navi .= "<td width='7' align='right'><img src='{$ADMIN_DIR}board_img/btn_next.gif' width='7' height='7' border='0'></td>";
	}

	$navi .= "</tr></table>";

	return $navi;
}

// page navigation
function page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$list_url,$qry_str) {
	$navi = "";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a href='$list_url?page=$my_page$qry_str'><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a href='$list_url?page=$prev_page$qry_str'><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />";
	}

	$navi .= "&nbsp;";

	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b> $bar";
	    } else {
	        $navi .= "<a href='$list_url?page=$direct_page$qry_str'>$direct_page</a> $bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a href='$list_url?page=$next_page$qry_str'><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}

	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a href='$list_url?page=$my_page$qry_str'><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	return $navi;
}

function ajax_gift_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$func,$p_idx, $p_e_idx,$shop_idx) {
	$navi = "
	<table width='860' height='45' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='center'>	
	";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p_idx','$p_e_idx','$shop_idx','$my_page');\"><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p_idx','$p_e_idx','$shop_idx','$prev_page');\"><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>&nbsp;";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />&nbsp;";
	}


	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b>$bar";
	    } else {
	        $navi .= "<a style='cursor:hand;' onClick=\"$func('$p_idx','$p_e_idx','$shop_idx','$direct_page');\">$direct_page</a>$bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p_idx','$p_e_idx','$shop_idx','$next_pag');\"><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}


	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a style='cursor:hand;' onClick=\"$func('$p_idx','$p_e_idx','$shop_idx','$my_page');\"><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	$navi .= "
			</td>
		</tr>
	</table>	
	";

	return $navi;
}

function ajax_general_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$func,$p1,$p2,$p3,$p4) {
	$navi = "";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$my_page','$p4');\"><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$prev_page','$p4');\"><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>&nbsp;";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />&nbsp;";
	}


	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b>$bar";
	    } else {
	        $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$direct_page','$p4');\">$direct_page</a>$bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$next_page','$p4');\"><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}


	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$my_page','$p4');\"><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	return $navi;
}

function ajax_board_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$func,$p1,$p2,$p3,$p4,$p5,$p6) {
	$navi = "";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$my_page','$p4','$p5','$p6');\"><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$prev_page','$p4','$p5','$p6');\"><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>&nbsp;";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />&nbsp;";
	}


	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b>$bar";
	    } else {
	        $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$direct_page','$p4','$p5','$p6');\">$direct_page</a>$bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$next_page','$p4','$p5','$p6');\"><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}


	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$my_page','$p4','$p5','$p6');\"><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	return $navi;
}

// 코디평가순위(/product/codi_list.php) 페이징
function ajax_codi_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$func,$p1,$p2,$p3,$p4,$p5) {
	$navi = "";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$p4','$p5','$my_page');\"><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$p4','$p5','$prev_page');\"><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>&nbsp;";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />&nbsp;";
	}


	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b>$bar";
	    } else {
	        $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$p4','$p5','$direct_page');\">$direct_page</a>$bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$p4','$p5','$next_page');\"><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}


	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a style='cursor:hand;' onClick=\"$func('$p1','$p2','$p3','$p4','$p5','$my_page');\"><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	return $navi;
}

function ajax_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$func,$mem_id,$mem_kind,$rurl,$v_url,$w_url,$etc1,$etc2,$etc3,$updown_yn,$active) {
	$navi = "
	<table width='860' height='45' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='center'>	
	";

	if ( $block > 1 ) {
		$my_page = $first_page;
		$navi .= "<a href='#{$etc3}' onClick=\"$func('$mem_id','$mem_kind','$rurl','$etc1','$etc2','$my_page','$v_url','$w_url','$updown_yn','$active');\"><img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_first_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	if ( $page > 1 ) {
		$prev_page = $page - 1;
		$navi .= "<a href='#{$etc3}' onClick=\"$func('$mem_id','$mem_kind','$rurl','$etc1','$etc2','$prev_page','$v_url','$w_url','$updown_yn','$active');\"><img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' /></a>&nbsp;";
	} else {
		$navi .= "<img src='/img/btn_prev6.gif' width='44' height='16' border='0' align='absmiddle' />&nbsp;";
	}


	$cnt = 0;
	for ( $direct_page = $first_page+1; $direct_page<=$last_page; $direct_page++ ) {
		$cnt++;
		$bar = ( $cnt != 10 && $direct_page != $last_page ) ? " | " : "";
	    if ( $page == $direct_page ) {
	        $navi .= "<b><font color='#333333'>$direct_page</font></b>$bar";
	    } else {
	        $navi .= "<a href='#{$etc3}' onClick=\"$func('$mem_id','$mem_kind','$rurl','$etc1','$etc2','$direct_page','$v_url','$w_url','$updown_yn','$active');\">$direct_page</a>$bar";
	    }
	}

	$navi .= "&nbsp;";

	if ( $page != $total_page ) {
		$next_page = $page + 1;
		$navi .= "<a href='#{$etc3}' onClick=\"$func('$mem_id','$mem_kind','$rurl','$etc1','$etc2','$next_page','$v_url','$w_url','$updown_yn','$active');\"><img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' /></a>";
	} else {
		$navi .= "<img src='/img/btn_next6.gif' width='44' height='16' border='0' align='absbottom' />";
	}


	if ( $block < $total_block ) {
	    $my_page = $last_page + 1;
	    $navi .= "<a href='#{$etc3}' onClick=\"$func('$mem_id','$mem_kind','$rurl','$etc1','$etc2','$my_page','$v_url','$w_url','$updown_yn','$active');\"><img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' /></a>";
	} else {
		$navi .= "<img src='/img/btn_end_go2.gif' width='20' height='16' border='0' align='absmiddle' />";
	}

	$navi .= "
			</td>
		</tr>
	</table>	
	";

	return $navi;
}

// 샵정보 레이어
function getLayerShopInfo($obj, $cnt, $zidx1, $zidx2, $left, $top, $rp_total_rank, $shop_url, $s_shop_name, $s_shop_mem_id, $param_hide) {
	$html = "
	<div id='{$obj}_{$cnt}'  style='position:relative; z-index:{$zidx1}; left:{$left}px; top:{$top}px;visibility: hidden;' > 
	<div STYLE='position: absolute; z-index: {$zidx2};'>
	<table width='100' border='0' cellpadding='0' cellspacing='0' >
		<tr>
			<td width='6' align='right'><img src='/img/arr_orage.gif'></td>
			<td bgcolor='#FFFFFF'>
			<table width='100' border='0' cellpadding='1' cellspacing='1' bgcolor='#FF7533'>
				<tr>
					<td bgcolor='#FFFFFF'>
					<table width='150' height='150' border='0' cellpadding='7' cellspacing='4' bgcolor='#FF9966'>
						<tr>
							<td valign='top' bgcolor='#FFFFFF'>
							<table width='100%' border='0' cellpadding='2' cellspacing='3' bgcolor='#FF9966'>
								<tr>
									<td align='center' class='evgray' style='PADDING-top: 4px;'><b><font color='#FFFFFF'>전체순위 <font color='#000000'>$rp_total_rank</font> 위 </font></b></td>
								</tr>
							</table>
							<table width='100' height='8' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td></td>
								</tr>
							</table>
							<table width='90%' border='0' cellspacing='0' cellpadding='0' align=center>
								<tr>
									<td height='22' class=evmem><img src='/img/icon_homepage.gif' width='16' height='12' align='absmiddle'> <a href='$shop_url' target='_blank'>홈페이지 바로가기</a></td>
								</tr>
								<tr>
									<td height='1' background='/img/dot_garo_max.gif'></td>
								</tr>
								<tr>
									<td height='22' class=evmem><img src='/img/icon_allcodi.gif' width='17' height='15' align='absmiddle'> <a href='#' onClick=\"go_shop_info('$s_shop_name');\">등록코디 전체보기</a></td>
								</tr>
								<tr>
									<td height='1' background='/img/dot_garo_max.gif'></td>
								</tr>
								<tr>
									<td  height='22' class=evmem><img src='/img/icon_memo_tran.gif' width='17' height='14' align='absmiddle'> <a href='#' height='22' class=evmem onClick=\"pop_msg('$s_shop_mem_id');\">쪽지보내기</a></td>
								</tr>
								<tr>
									<td height='1' background='/img/dot_garo_max.gif'></td>
								</tr>
							</table>
							<table width='100%' height='20' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td align='right' valign='bottom'><a  onClick=\"MM_showHideLayers($param_hide);\" style='cursor:hand;'><img src='/img/btn_pop_close.gif' width='13' height='13' border=0></a></td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</div>
	</div>
	";
	return $html;
}


// random string
function random_code2($length) {
	$pattern = "0123456789abcdefghijklmnopqrstuvwxyz";
	$key = $pattern{rand(0,36)};

	for($i=1; $i<$length; $i++)
		$key .= $pattern{rand(0,36)};

	return $key;
}

// send msg
function send_msg($s,$r,$str) {
	global $mainconn;

	$mainconn->open();
	$str = addslashes($str);
	$sql = "insert into tblMsg (send_mem_id,recv_mem_id,msg_comment,msg_send_dt,msg_recv_ok) values ('$s','$r','$str',now(),'N')";
	$mainconn->query($sql);
}

// cut string
// http://phpschool.com/gnuboard4/bbs/board.php?bo_table=tipntech&wr_id=15047&sop=and&page=3
function cutStringHan($str, $len, $tail="..") {
	if (strlen($str)>$len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i);
	}
	return $str.$tail;
}

// L : list/write, V : view
function strip_str($str, $flag="L") {
	$str = ( $flag == "L" ) ? stripslashes($str) : nl2br(stripslashes($str));
	return $str;
}

// iconv
/* TODO
* function iconv($f, $t, $str) {
	global $UP_DIR;

	$tmp_file = $UP_DIR."/tmp/".random_code2(10);
	$tmp_file_new = $tmp_file."_new";

	$fp = fopen($tmp_file, "w+");
	fwrite($fp, $str);
	$flag = system("/usr/local/bin/iconv -f $f -t $t ".$tmp_file." > ".$tmp_file_new);

	$fp = fopen($tmp_file_new, "r");
	$str = fread($fp,10000);

	$str = addslashes($str);

	fclose($fp);
	@unlink($tmp_file);
	@unlink($tmp_file_new);

	return $str;
}
*/

// 해당 달의 첫날과 마지막날
function getMonthDay( $kind, $timestamp, $flag = "D" ) {
	$arr = array();
	if ( $kind == "last" ) {
		$t_flag = "-1";
	} else if ( $kind == "current" ) {
		$t_flag = "0";
	} else {
		$t_flag = "+1";
	}
	$stamp = strtotime("$t_flag month", $timestamp);
	
	if ( $flag == "D" ) {
		$arr[0] = date("Y-m-01", $stamp);
		$arr[1] = date("Y-m-t", $stamp);
	} else {
		$arr[0] = date("Y-m-01 H:i:s", $stamp);
		$arr[1] = date("Y-m-t H:i:s", $stamp);
	}
	return $arr;
}

// 해당 주의 첫날과 마지막날
function getWeekDay( $kind, $timestamp, $flag = "D" ) {
	$arr = array();

	$cur_dt = date("w",$timestamp);

	if ( $kind == "last" ) {
		$first_timestamp = $timestamp - ($cur_dt + 7)*86400;
		$last_timestamp = $timestamp - ($cur_dt + 1)*86400;
	} else if ( $kind == "current" ) {
		$first_timestamp = $timestamp - ($cur_dt)*86400;
		$last_timestamp = $timestamp - ($cur_dt - 6)*86400;
	} else {
		$first_timestamp = $timestamp + (7 - $cur_dt)*86400;
		$last_timestamp = $timestamp + (7 - $cur_dt + 6)*86400;
	}

	$date_format = ( $flag == "D" ) ? "Y-m-d" : "Y-m-d H:i:s";

	$arr[0] = date($date_format, $first_timestamp);
	$arr[1] = date($date_format, $last_timestamp);
	
	return $arr;
}

// $arr[갯수][시작/종료]
function getWeekStartEnd( $num ) {
	$arr = array();
	$t = time();
	for ( $i=0; $i<$num; $i++ ) {
		$arr[$i][0] = date( "Y-m-d H:i:s", $t + (($i*7) * 86400) );
		$arr[$i][1] = date( "Y-m-d H:i:s", $t + (($i*7+7) * 86400) - 1 );
	}
	return $arr;
}

// 첫번째 인자의 날짜로부터 두번째 인자의 수만큼의 모든 날짜를 배열로 리턴
function getAllDate( $d, $n ) {
	$ret = array();
	$arr = explode("-", $d);
	$stamp = mktime(1,0,0,$arr[1],$arr[2],$arr[0]);
	if ( $n < 1 ) return $ret;
	for ( $i=1; $i<=$n; $i++ ) {
		array_push($ret, date("Y-m-d", $stamp + ( $i-1 ) * 86400));
	}
	return $ret;
}

// 첫날에 해당하는 마지막 날을 구한다.
function getLastDay( $f, $flag = "W" /* W:weekly, M:monthly */ ) {
	$arr = explode("-", $f);
	$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
	if ( $flag == "W" ) {
		$l_stamp = $stamp + 86400 * 6;
		return date("Y-m-d", $l_stamp);
	} else if ( $flag == "M" ) {
		$last_day = date("t", $stamp);
		return substr($f, 0, 8).$last_day;
	}
}

// 문자열에 특정한 문자로만 이뤄지면 참, 그렇지 않으면 거짓
function chkAllStr( $str, $ch ) {
	$len = strlen($str);
	for ( $i=0; $i<$len; $i++ ) {
		if ( substr($str, $i, 1) != $ch ) return 0;
	}
	return 1;
}

// 경품수령한 갯수를 구한다.
function getGiftOk( $str, $ch ) {
	$len = strlen($str);
	$cnt = 0;
	for ( $i=0; $i<$len; $i++ ) {
		if ( substr($str, $i, 1) == $ch ) $cnt++;
	}
	return $cnt;
}


########################## 코디탑10 DB 처리 함수들 #######################

// 자신의 점수와 last_reg_dt 를 업데이트 한다.
// $mem_id : 아이디
// $score : 스코어(-가 될 수있음)
// $flag : last_reg_dt 변화 주는지 여부(1이면 현재시간으로)
function UpdateMyScore( $mem_id, $score, $flag ) {
	global $mainconn, $_SESSION;
	
	// 현재 점수를 구한다.
	$sql = "select mem_score, mem_grade from tblMember where mem_id = '$mem_id' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);
	
	$mem_score = $row['mem_score'];
	$mem_grade = $row['mem_grade'];

	// 바뀔 점수를 구한다.
	$new_mem_score = $mem_score + $score;

	// 모든 등급을 구한다.
	$sql = "select lg_grade, lg_score from tblLottoGrade order by lg_grade asc ";
	$res = $mainconn->query($sql);
	
	$upper_score = 1000000;
	$new_mem_grade = 0;
	while ( $row = $mainconn->fetch($res) ) {
		$lg_grade = $row['lg_grade'];
		$lg_score = $row['lg_score'];

		if ( $new_mem_score >= $lg_score && $new_mem_score < $upper_score ) {
			$new_mem_grade = $lg_grade;
			break;
		}
		$upper_score = $lg_score;
	}

	// 등급이 바뀌었으면
	if ( $mem_grade != $new_mem_grade ) {
		// 새로운 당첨 확율을 구한다.
		$sql = "select lg_percent from tblLottoGrade where lg_grade = $new_mem_grade ";
		$new_mem_percent = $mainconn->count($sql);

		// 세션 재생성
		$_SESSION['mem_grade'] = $new_mem_grade;
		$_SESSION['mem_percent'] = $new_mem_percent;
		session_register("mem_grade","mem_percent");
	}

	$dt_str = ( $flag ) ? " , last_reg_dt = now() " : "";
	$sql = "update tblMember set mem_score = $new_mem_score, mem_grade = $new_mem_grade $dt_str where mem_id = '$mem_id' ";
	return $mainconn->query($sql);
}

// tblProductUpDown insert
function InsertUpDown( $p_idx, $p_e_idx, $mem_id, $val ) {
	global $mainconn, $_SESSION;

	$sql = "insert into tblProductUpDown (p_idx, p_e_idx, mem_id, p_u_val, p_u_reg_dt) values ($p_idx, $p_e_idx, '$mem_id', $val, now())";
	$res = $mainconn->query($sql);
	if ( $res ) {
		// 참여한 코디 갯수를 구해서 세션 재생성
		$_SESSION['my_updown_codi_cnt'] = getUserCodiCount($mem_id);
	}
	return $res;
}

// tblProductComment
function InsertProductComment( $p_idx, $p_e_idx, $mem_id, $p_c_comment, $ip, $status ) {
	global $mainconn;

	$sql = "insert into tblProductComment (p_idx, p_e_idx, mem_id, p_c_comment, p_c_ip, p_c_status, p_c_reg_dt) values  ($p_idx, $p_e_idx, '$mem_id', '$p_c_comment', '$ip', '$status', now() )";
	return $mainconn->query($sql);
}

// tblShop 테이블에 insert 한다.
function InsertScore( $mem_id, $p_e_idx, $sc_code ) {
	global $mainconn;

	$sql = "insert into tblScore (mem_id, p_e_idx, sc_cid, s_reg_dt) values ('$mem_id', $p_e_idx, '$sc_code', now()) ";
	return $mainconn->query($sql);
}

// tblShop 테이블을 delete 한다.
function DeleteScore( $s_idx ) {
	global $mainconn;

	$sql = "delete from tblScore where s_idx = $s_idx ";
	return $mainconn->query($sql);
}

// tblProductVisit 테이블에 insert 한다.
function InsertVisit( $mem_id, $p_idx, $p_e_idx, $ip ) {
	global $mainconn;

	$sql = "insert into tblProductVisit (p_idx, p_e_idx, mem_id, p_v_ip, p_v_reg_dt) values ($p_idx, $p_e_idx, '$mem_id', '$ip', now()) ";
	return $mainconn->query($sql);
}

// 자신의 캐쉬를 업데이트 한다.
// $mem_id : 아이디
// $cash : 캐쉬
function UpdateMyCash( $mem_id, $cash ) {
	global $mainconn, $_SESSION;

	$sql = "update tblMember set mem_cash = mem_cash + $cash where mem_id = '$mem_id' ";
	$res = $mainconn->query($sql);

	// 세션 재생성
	$new_cash = getCash($mem_id);
	$_SESSION['mem_cash'] = $new_cash;
	return $res;
}

// tblCash 테이블에 insert 한다.
function InsertCash( $mem_id, $code, $io, $cash ) {
	global $mainconn;

	$sql = "insert into tblCash (mem_id, cc_cid, cash_io, cash, cash_reg_dt) values ('$mem_id', '$code', '$io', $cash, now() ) ";
	return $mainconn->query($sql);
}

// 무통장 입금 승인처리(tblChargeBankBook 업데이트)
function UpdateChargeBankBook( $bb_idx, $status ) {
	global $mainconn;

	$sql = "update tblChargeBankBook set bb_status = '$status', bb_ok_dt = now() where bb_idx = $bb_idx ";
	return $mainconn->query($sql);
}

// 무통장 입금내역 삭제
function DeleteChargeBankBook( $bb_idx ) {
	global $mainconn;

	$sql = "delete from tblChargeBankBook where bb_idx = $bb_idx ";
	return $mainconn->query($sql);
}
		
// 임시 코디테이블 삭제
function DeleteProductTmp ( $p_idx ) {
	global $mainconn;

	$sql = "delete from tblProductTmp where p_idx=$p_idx";
	return $mainconn->query($sql);
}



// 퀵메뉴에 나올 나의 정보를 구한다. (샵회원용)
// 샵회원   : 받은쪽지, 읽지않은쪽지, 확인안한경품수, 평가중코디수, 완료코디수, 대표샵지난주순위, 대표샵전체순위, 현재캐쉬
function getMyShopInfo( $mem_id ) {
	global $mainconn;
	$ret_arr = array();

	// 받은쪽지 갯수(보관함 포함)
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' ";
	$msg_cnt = $mainconn->count($sql);
	// 읽지않은 쪽지 갯수
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' and msg_recv_ok = 'N' ";
	$noread_msg_cnt = $mainconn->count($sql);
	
	// 확인안한 경품수(쿼리가 다름)
	$sql = "select count(*) from tblGiftTracking where shop_mem_id = '$id' and gt_status = 'A' ";
	$chk_gift_cnt = $mainconn->count($sql);

	// 평가중 코디
	$sql = "select count(*) from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.mem_id='$mem_id' and B.start_dt < '$now_dt' and B.end_dt > '$now_dt' ";
	$ing_codi_cnt = $mainconn->count($sql);
	
	// 완료 코디
	$sql = "select count(*) from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.mem_id='$mem_id' and B.end_dt < '$now_dt' ";
	$ed_codi_cnt = $mainconn->count($sql);

	// shop_idx - 대표샵의 지난주/전체 순위
	$sql = "select shop_idx from tblShop where mem_id='$mem_id' and shop_kind='I' ";
	$shop_idx = $mainconn->count($sql);

	$arr_week = getWeekDay( "last", time() );
	$sql = "select rs_rank, rs_total_rank from tblRankShop where shop_idx = $shop_idx and rs_start_dt = '".$arr_week[0]."' and rs_end_dt = '".$arr_week[1]."' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row ) {
		$last_rank = $row['rs_rank'];
		$total_rank = $row['rs_total_rank'];
	} else {
		$total_rank = $last_rank = 0;
	}

	// 현재 캐쉬
	$sql = "select mem_cash from tblMember where mem_id = '$mem_id' ";
	$my_cash = $mainconn->count($sql);

	array_push($ret_arr, $msg_cnt, $noread_msg_cnt, $chk_gift_cnt, $ing_codi_cnt, $ed_codi_cnt, $last_rank, $total_rank, $my_cash);
	return $ret_arr;
}


// 퀵메뉴에 나올 나의 정보를 구한다. (일반회원용)
// 일반회원 : 받은쪽지, 읽지않은쪽지, 확인안한경품수, 참가코디수, 당첨경품수, 점수, 등급, 당첨확율
function getMyUserInfo( $mem_id ) {
	global $mainconn;
	$ret_arr = array();

	// 받은쪽지 갯수(보관함 포함)
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' ";
	$msg_cnt = $mainconn->count($sql);

	// 읽지않은 쪽지 갯수
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' and msg_recv_ok = 'N' ";
	$noread_msg_cnt = $mainconn->count($sql);
	
	// 확인안한 경품수(쿼리가 다름)
	$sql = "select count(*) from tblGiftTracking where user_mem_id = '$id' and gt_reg_dt = status_reg_dt ";
	$chk_gift_cnt = $mainconn->count($sql);
		
	// 참여중인 평가
	$codi_cnt = 0;
	$now_dt = date("Y-m-d H:i:s", time());
	$sql = "select p_e_idx from tblProductEach where start_dt < '$now_dt' and end_dt > '$now_dt' ";
	$res = $mainconn->query($sql);
	
	$p_e_idxs = "";
	while ( $row = $mainconn->fetch($res) ) {
		$p_e_idxs .= $row['p_e_idx'].",";
	}
	if ( $p_e_idxs ) {
		$p_e_idxs = substr($p_e_idxs, 0, strlen($p_e_idxs)-1);
		$sql = "select count(*) from tblProductUpDown where mem_id = '$mem_id' and p_e_idx in ( $p_e_idxs ) ";
		$codi_cnt = $mainconn->count($sql);
	}

	// 경품수령 갯수(지금까지 당첨확인 된거 전부다)
	$sql = "select count(*) from tblGiftTracking where user_mem_id = '$mem_id' ";
	$gift_cnt = $mainconn->count($sql);

	// 점수, 등급, 당첨확률
	$sql = "select A.mem_grade,A.mem_score,B.lg_percent from tblMember A, tblLottoGrade B where A.mem_grade = B.lg_grade and A.mem_id = '$mem_id' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);
	$my_score = $row['mem_score'];
	$mem_grade = $row['mem_grade'];
	$my_percent = $row['lg_percent'];

	array_push($ret_arr, $msg_cnt, $noread_msg_cnt, $chk_gift_cnt, $codi_cnt, $gift_cnt, $my_score, $mem_grade, $my_percent);
	return $ret_arr;
}


// 읽지않은 쪽지/전체쪽지를 구한다.
function getMsgCount( $mem_id ) {
	global $mainconn;

	$arr_msg = array();

	// 받은쪽지 갯수(보관함 포함)
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' ";
	$msg_cnt = $mainconn->count($sql);

	// 읽지않은 쪽지 갯수
	$sql = "select count(*) from tblMsg where recv_mem_id = '$mem_id' and msg_recv_status = 'Y' and msg_recv_ok = 'N' ";
	$noread_msg_cnt = $mainconn->count($sql);

	array_push($arr_msg, $msg_cnt, $noread_msg_cnt);
	return $arr_msg;
}

// 평가중 코디의 갯수를 구한다(샵 회원용)
function getShopIngCodiCount( $mem_id ) {
	global $mainconn;

	$now_dt = date("Y-m-d H:i:s", time());

	// 평가중 코디
	$sql = "select count(*) from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.mem_id='$mem_id' and B.start_dt < '$now_dt' and B.end_dt > '$now_dt' ";
	return $mainconn->count($sql);
}

// 완료 코디의 갯수를 구한다(샵 회원용)
function getShopEdCodiCount( $mem_id ) {
	global $mainconn;

	$now_dt = date("Y-m-d H:i:s", time());

	// 완료 코디
	$sql = "select count(*) from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.mem_id='$mem_id' and B.end_dt < '$now_dt' ";
	return $mainconn->count($sql);
}

// 평가한 코디 갯수를 구한다(일반 회원용)
function getUserCodiCount( $mem_id ) {
	global $mainconn;

	// 참여중인 평가
	$codi_cnt = 0;
	$now_dt = date("Y-m-d H:i:s", time());
	$sql = "select p_e_idx from tblProductEach where start_dt < '$now_dt' and end_dt > '$now_dt' ";
	$res = $mainconn->query($sql);
	
	$p_e_idxs = "";
	while ( $row = $mainconn->fetch($res) ) {
		$p_e_idxs .= $row['p_e_idx'].",";
	}
	if ( $p_e_idxs ) {
		$p_e_idxs = substr($p_e_idxs, 0, strlen($p_e_idxs)-1);
		$sql = "select count(*) from tblProductUpDown where mem_id = '$mem_id' and p_e_idx in ( $p_e_idxs ) ";
		$codi_cnt = $mainconn->count($sql);
	}

	return $codi_cnt;
}

// 경품수령 갯수를 구한다(일반 회원용)
function getUserGiftCount( $mem_id ) {
	global $mainconn;

	// 경품수령 갯수(지금까지 당첨확인 된거 전부다)
	$sql = "select count(*) from tblGiftTracking where user_mem_id = '$mem_id' ";
	return $mainconn->count($sql);
}

// 경품수령 갯수(확인안한거) - 샵, 일반 회원에 따라 달라진다.
function getNotNotifyGiftCount( $kind, $mem_id ) {
	global $mainconn;

	if ( $kind == "U" ) {
		$sql = "select count(*) from tblGiftTracking where user_mem_id = '$id' and gt_reg_dt = status_reg_dt ";
	} else {
		$sql = "select count(*) from tblGiftTracking where shop_mem_id = '$id' and gt_status = 'A' ";
	}
	return $mainconn->count($sql);
}


// 대표샵의 지난주순위, 전체순위를 구한다.
function getMainShopRank( $mem_id ) {
	global $mainconn;
	$arr_rank = array();

	// 대표샵의 shop_idx 를 구한다.
	$sql = "select shop_idx from tblShop where mem_id='$mem_id' and shop_kind='I' ";
	$shop_idx = $mainconn->count($sql);

	$arr_week = getWeekDay( "last", time() );
	$sql = "select rs_rank, rs_total_rank from tblRankShop where shop_idx = $shop_idx and rs_start_dt = '".$arr_week[0]."' and rs_end_dt = '".$arr_week[1]."' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	if ( $row ) {
		$last_rank = $row['rs_rank'];
		$total_rank = $row['rs_total_rank'];
	} else {
		$total_rank = $last_rank = 0;
	}

	array_push($arr_rank, $last_rank, $total_rank);
	return $arr_rank;
}

// 나의 캐쉬를 구한다.
function getCash( $mem_id ) {
	global $mainconn;

	$sql = "select mem_cash from tblMember where mem_id = '$mem_id' ";
	return $mainconn->count($sql);
}

// 나의 점수,등급,당첨확율을 구한다.
function getLottoInfo( $mem_id ) {
	global $mainconn;
	$arr = array();

	$sql = "select A.mem_grade,A.mem_score,B.lg_percent from tblMember A, tblLottoGrade B where A.mem_grade = B.lg_grade and A.mem_id = '$mem_id' ";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);
	$my_score = $row['mem_score'];
	$my_grade = $row['mem_grade'];
	$my_percent = $row['lg_percent'];

	array_push($arr, $my_score, $my_grade, $my_percent);
	return $arr;
}

// 현재 자신의 url을 저장한다.
$RURL = my64encode($_SERVER['REQUEST_URI']);
?>
