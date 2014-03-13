<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/level.php
 * date   : 2009.01.30
 * desc   : 마이페이지 당첨등급
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];

// 일주일전
$day_7 = date("Y.m.d", time()-7*86400);

// 현재의 등급,당첨확율,남은점수를 구한다.
$sql = "
select A.lg_score,A.lg_percent,B.mem_grade,B.mem_score,B.mem_reg_dt
from tblLottoGrade A, tblMember B
where B.mem_id='$mem_id' and A.lg_grade = B.mem_grade 
";

$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$lg_score = $row['lg_score'];
$lg_percent = $row['lg_percent'];
$mem_grade = $row['mem_grade'];
$mem_score = $row['mem_score'];
$mem_reg_dt = str_replace("-",".",substr($row['mem_reg_dt'],0,10));

if ( $mem_grade != "1" ) {
	$get_score = $lg_score + 10 - $mem_score;
} else {
	$get_score = 0;
}

// 점수/코드 값을 구한다.
$inc_sql = "select * from tblScoreConfig ";
$inc_res = $mainconn->query($inc_sql);
$SCORECODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_sc_cid = trim($inc_row['sc_cid']);
	$inc_sc_cval = trim($inc_row['sc_cval']);
	$inc_score = trim($inc_row['score']);

	// 점수 접근할땐 $SCORECODE['SC09'][1] = -1
	$SCORECODE[$inc_sc_cid] = array($inc_sc_cval, $inc_score);
}


// 항목별 점수를 구한다.
$sql = "select sc_cid, count(*) as cnt from tblScore where mem_id = '$mem_id' and unix_timestamp(s_reg_dt) > unix_timestamp() - 7*86400 group by sc_cid ";
$res = $mainconn->query($sql);

$sc_01_cnt = $sc_02_cnt = $sc_03_cnt = $sc_04_cnt = $sc_05_cnt = $sc_06_cnt = 0;
$sc_01_sum = $sc_02_sum = $sc_03_sum = $sc_04_sum = $sc_05_sum = $sc_06_sum = 0;
while ( $row = $mainconn->fetch($res) ) {
	$sc_cid = $row['sc_cid'];
	$cnt = $row['cnt'];

	if ( $sc_cid == "SC01" || $sc_cid == "SC09" ) {	// 코디평가 참여(UP, DOWN 포함)
		$sc_01_cnt += $cnt; 
		$sc_01_sum += $cnt * abs($SCORECODE['SC01'][1]);
	} else if ( $sc_cid == "SC02" ) {
		$sc_02_cnt = $cnt;
		$sc_02_sum = $cnt * abs($SCORECODE['SC02'][1]);
	} else if ( $sc_cid == "SC03" ) {
		$sc_03_cnt = $cnt;
		$sc_03_sum = $cnt * abs($SCORECODE['SC03'][1]);
	} else if ( $sc_cid == "SC04" ) {
		$sc_04_cnt = $cnt;
		$sc_04_sum = $cnt * abs($SCORECODE['SC04'][1]);
	} else if ( $sc_cid == "SC05" ) {
		$sc_05_cnt = $cnt;
		$sc_05_sum = $cnt * abs($SCORECODE['SC05'][1]);
	} else if ( $sc_cid == "SC06" ) {
		$sc_06_cnt = $cnt;
		$sc_06_sum = $cnt * abs($SCORECODE['SC06'][1]);
	}
}

$total_score = $sc_01_sum + $sc_02_sum + $sc_03_sum + $sc_04_sum + $sc_05_sum + $sc_06_sum;

$mainconn->close();

?>

<? include "../include/_head.php"; ?>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><!-- 주간 코디 top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
    <!-- 좌측 가이드 5개 롤링 끝 //--> </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">당첨등급 :</font></b> <font color="#FFFFFF">현재 당첨등급을 확인할 수 있습니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15">
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:15 15 15 15" class="intext">
					
					<img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">당첨등급 :</font> 응모한 코디상품에서 제공되는 경품의 당첨 확률을 높이는 등급입니다.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                    
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">등급구성 :</font> 10등급부터 최고 1등급까지 올라갈 수 있으며, 10점단위로 1등급씩 올라갑니다. 
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">당첨확률 :</font> 1등급씩 올라갈 때 마다 <font color="#DD2457"><u>5%씩 당첨확률</u></font>이 올라갑니다. 
<!--
					  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>

					  <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="red">한주간 아무런 활동이 없으면 -10점이 감점됩니다. 따라서 총점수와 합계접수는 차이가 있을 수 있습니다.</font>
-->                      
					  
					 </td>
                  </tr>
                </table>
                  <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="200"><table width="200" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="/img/rank01.gif" width="200" height="19" /></td>
                        </tr>
                        <tr>
                          <td height="171" align="center" valign="top" background="/img/rank03.gif"><table width="170" border="0" cellspacing="0" cellpadding="0">
						  <tr>
                              <td align="center"><img src="/img/rank_img.gif" /></td>
                            </tr>
                            <tr>
                              <td height="25" align="center" class="rank">현재 당첨등급</td>
                            </tr>
                            <tr>
                              <td align="center" class="textlevel"><span style="filter:dropshadow(color=black,offy=1,offx=1);width:100px;height:33px"><?=$mem_grade?>등급</span></font></td>
                            </tr>
                            <tr>
                              <td height="6"></td>
                            </tr>
                            <tr>
                              <td height="1" background="/img/dot00.gif"></td>
                            </tr>
                           <tr>
                              <td height="4"></td>
                            </tr>
                            <tr>
                              <td align="center" class="bigtext">추가당첨확률 <font color="FE6867"><?=$lg_percent?>%증가</font></td>
                            </tr>
                           
                            <tr>
                              <td align="center"><b><font color="#333333">다음 등급까지 남은점수<br /><?=$get_score?>점</font></b></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td><img src="/img/rank02.gif" width="200" height="22" /></td>
                        </tr>
                      </table></td>
                      <td width="10">&nbsp;</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="400"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="DD2457">
                            <tr>
                              <td width="152" align="center" bgcolor="FEB7B7" style="padding:7 5 5 5"><b><font color="CC0000">최근 7일간 등급활동내역</font></b></td>
                              <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5"><?=$day_7?> ~ 현재까지 총 <?=$total_score?>점 <a href="#"></a></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="1" colspan="4" bgcolor="E0295A"></td>
                              </tr>
                              <tr>
                                <td height="28" align="center" class="intitle">항목(1회당)</td>
                                <td width="80" align="center" class="intitle">횟수</td>
                             
                                <td width="80" align="center" class="intitle">점수</td>
                              </tr>
                              <tr>
                                <td height="1" colspan="4" bgcolor="E0295A"></td>
                              </tr>
                            </table>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="28" bgcolor="F9F9F9" style="padding-left:13"><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC01'][0]?> (<?=abs($SCORECODE['SC01'][1])?>점) </td>
                                  <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$sc_01_cnt?></td>
                                  <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><?=$sc_01_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
                                <tr>
                                  <td height="28" style="padding-left:13"><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC02'][0]?> (<?=abs($SCORECODE['SC02'][1])?>점) </td>
                                  <td align="center" class="evfont"><?=$sc_02_cnt?></td>
                                  <td align="center" class="evfont"><b><font color="#009933"><?=$sc_02_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
                                <tr>
                                  <td height="28"  bgcolor="F9F9F9" style="padding-left:13"><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC03'][0]?> (<?=abs($SCORECODE['SC03'][1])?>점) </td>
                                  <td align="center" bgcolor="F9F9F9" class="evfont" ><?=$sc_03_cnt?></td>
                                  <td align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><?=$sc_03_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
                                <tr>
                                  <td height="28" style="padding-left:13" ><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC04'][0]?> (<?=abs($SCORECODE['SC04'][1])?>점) </td>
                                  <td align="center" class="evfont" ><?=$sc_04_cnt?></td>
                                  <td align="center" class="evfont"><b><font color="#009933"><?=$sc_04_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
                                <tr>
                                  <td height="28" bgcolor="F9F9F9" style="padding-left:13"><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC05'][0]?> (<?=abs($SCORECODE['SC05'][1])?>점) </td>
                                  <td align="center" bgcolor="F9F9F9" class="evfont" ><?=$sc_05_cnt?></td>
                                  <td align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><?=$sc_05_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
								 <tr>
                                  <td height="28" style="padding-left:13"><img src="/img/icon00.gif" align=absmiddle> <?=$SCORECODE['SC06'][0]?> (<?=abs($SCORECODE['SC06'][1])?>점) </td>
                                  <td align="center" class="evfont" ><?=$sc_06_cnt?></td>
                                  <td align="center" class="evfont"><b><font color="#009933"><?=$sc_06_sum?></font></b></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="3" bgcolor="#E0E0E0"></td>
                                </tr>
                              </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="2"></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<? include "../include/_foot.php"; ?>