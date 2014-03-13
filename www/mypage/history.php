<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/history.php
 * date   : 2009.02.04
 * desc   : 마이페이지 당첨리스트
 *			이 페이지를 읽으면 우측 quick 메뉴 html이 다시 생성된다.
 *			gt_reg_dt 와 status_reg_dt 값이 같으면 당첨자가 아직 확인안한거로 간주하고
 *			status_reg_dt 를 현재 시간으로 update 한다.
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$page = $_REQUEST['page'];

if ( $page == "" ) $page = 1;

$cond = " and A.p_idx = B.p_idx and A.shop_idx = C.shop_idx and B.p_e_idx = D.p_e_idx and D.user_mem_id = '$mem_id' ";

// tblProduct, tblProductEach, tblShop, tblGiftTracking
$sql = "select count(*) from tblProduct A, tblProductEach B, tblShop C, tblGiftTracking D where 1 $cond ";
$total_record = $mainconn->count($sql);

$total_page = ceil($total_record/$PAGE_SIZE);
if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}


$qry_str = "";
$orderby = " order by B.end_dt desc ";

$sql = "select A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.p_gift, C.shop_idx, C.shop_medal, C.mem_id, C.shop_name, C.shop_url, C.shop_mobile, C.shop_phone, D.gt_idx, D.gt_reg_dt, D.gt_status, unix_timestamp(D.gt_reg_dt) as gt_stamp, unix_timestamp(D.status_reg_dt) as stamp, ifnull((select rs_total_rank from tblRankShop where shop_idx=C.shop_idx order by rs_idx desc limit 1),0) as rs_total_rank from tblProduct A, tblProductEach B, tblShop C, tblGiftTracking D where 1 $cond $orderby limit $first, $PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = $tmp_main_img = $shop_medal_mark = $codi_mark = $status_str = "";
$modify_yn = "N";
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cnt++;

	$p_idx			= trim($row['p_idx']);
	$p_title		= strip_str(trim($row['p_title']));
	$p_main_img		= trim($row['p_main_img']);
	$p_top10_num	= trim($row['p_top10_num']);
	$p_gift			= trim($row['p_gift']);
	$shop_idx		= trim($row['shop_idx']);
	$shop_name		= trim($row['shop_name']);
	$shop_mem_id	= trim($row['mem_id']);
	$shop_url		= trim($row['shop_url']);
	$shop_mobile	= trim($row['shop_mobile']);
	$shop_phone		= trim($row['shop_phone']);
	$shop_medal		= trim($row['shop_medal']);
	$rs_total_rank	= trim($row['rs_total_rank']);
	$gt_idx			= trim($row['gt_idx']);
	$gt_reg_dt		= str_replace("-",".",substr(trim($row['gt_reg_dt']),0,10));
	$gt_status		= trim($row['gt_status']);
	$gt_stamp		= trim($row['gt_stamp']);
	$stamp			= trim($row['stamp']);

	if ( $gt_stamp == $stamp ) {	// 확인하지 않은게 있으면 확인한걸로 바꾼다.
		$sql2 = "update tblGiftTracking set status_reg_dt = now() where gt_idx = $gt_idx ";
		$mainconn->query($sql2);
		$modify_yn = "Y";
	}

	// 경품을 언제 발송했는지 확인하기위해 가장 최근 status_reg_dt 값을 구해서 현재시간과 차이를 구한다.
	$diff_time = floor((time()-$stamp)/3600);


	$tmp_main_img = $UP_URL."/thumb/".$p_main_img;

	// 인증샵 마크
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0' align='absmiddle' />";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	// 베스트 코디 마크
	if ( $p_top10_num > 0 ) {
		$codi_mark = "<img src='/img/btn_best.gif' width='32' height='15' align='absmiddle' />";
	} else {
		$codi_mark = "&nbsp;";
	}


	$param_show = $param_hide = "";
	for ( $j=1; $j<=$PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_list_$j','','$sh',";
		$param_hide .= "'shopview_list_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);	

	// 상태값에 따라 다른값
	switch ( $gt_status ) {
		case "A" :
			$status_str = "<b><font color='#0070B7'>대기</font></b><a href='#' onClick=\"go_bad_shop_write('','');\"><img src='/img/shop_bad.gif' border='0' /></a>";
			break;
		case "B" :
			$status_str = "<b><font color='#0070B7'>확인</font></b><br />(발송준비중)<a href='#' onClick=\"go_bad_shop_write('','');\"><img src='/img/shop_bad.gif' border='0' /></a>";
			break;
		case "E" :
			$status_str = "<b><font color='#DD2457'>완료</font></b>";
			break;
		default :	// C,D 일경우
			$status_str = "
			<b><font color='#0070B7'>발송완료</font></b><br />
                    (".$diff_time."시간 전)
                      <table width='80' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td><a href='#' onclick=\"pop_deli_ok('$gt_idx');\"><img src='/img/shop_ok.gif' width='84' height='18' border='0' /></a></td>
                        </tr>
                        <tr>
                          <td height='2'></td>
                        </tr>
                        <tr>
                          <td><a href='#' onClick=\"go_bad_shop_write('','');\"><img src='/img/shop_bad.gif' width='84' height='18' border='0' /></a></td>
                        </tr>
                      </table>
			";
			break;
	}



	$LIST .= "
	  <table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		  <td width='100'><table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
			  <tr>
				<td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$tmp_main_img' width='95' height='95' border='0' /></a></td>
			  </tr>
		  </table></td>
		  <td  style='padding-left:5;padding-right:8'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a>$codi_mark</td>
		  <td width='123' align='center'>$p_gift </td>
		  <td width='102' align='center' class='shopname'>$shop_medal_mark <a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$shop_name</a><br />($shop_mobile/$shop_phone)
	";

	// 샵 정보 레이어
	$LIST .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 45, -115, $rs_total_rank, $shop_url, $shop_name, $shop_mem_id, $param_hide);

	$LIST .= "
		  </td>
		  <td width='103' align='center' class='date'>$gt_reg_dt</td>
		  <td width='91' align='center'>
		

			<span id='status_area_".$gt_idx."'>$status_str</span>
			
		  
		  </td>
		</tr>
	  </table>
	  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td height='1' bgcolor='E9E9E9'></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
	  </table>
	";
}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

// 당첨개수(tblGiftTracking 갯수), 경품수령대기(E 빼고 나머지), 경품수령완료(gt_status == "E" 갯수)
// 수령완료 갯수를 구한다.
$sql = "select count(*) from tblProduct A, tblProductEach B, tblShop C, tblGiftTracking D where 1 $cond and D.gt_status = 'E' ";
$E_cnt = $mainconn->count($sql);

if ( $cnt < $PAGE_SIZE ) {
	for ( $i=$cnt+1; $i<=$PAGE_SIZE; $i++ ) {
		$LIST .= "<div id='shopview_list_{$i}' style='position:relative; z-index:2; left:445px; top: -122px;visibility: hidden;'></div>";
	}
}

$mainconn->close();

?>

<? include "../include/_head.php"; ?>

<table border="0" cellspacing="0" cellpadding="0">

<form id="mem" name="mem" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>" />
<input type="hidden" id="gt_idx" name="gt_idx" value="" />

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
        <td background="/img/bar03.gif"><b><font color="FFFC11">당첨내역 :</font></b> <font color="#FFFFFF">지금까지 당첨된 내용입니다.</font> </td>
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
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">대&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;기 :</font> 해당 샵에서 아직 당첨내용을 확인하지 않았습니다.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                    
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">확&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;인 :</font> 해당 샵에서 당첨내용을 확인하여 경품을 발송 준비중에 있습니다.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">발송완료 :</font> 해당샵에서 경품을 발송했습니다.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
					   <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">수령확인 : </font>경품을 이상없이 받으셨다면 수령확인을 해주세요. (발송완료 후 <font color="#DD2457"><u>7일이 지나면 자동으로 완료</u></font> 처리됩니다.) 
					   <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                         <tr>
                           <td></td>
                         </tr>
                       </table>
					    <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">완&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;료 : </font>경품을 이상없이 수령하였습니다. </td>
                  </tr>
                </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="1" bgcolor="FF5B5C">
        <tr>
          <td width="33%" height="28" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">당첨개수 :<b> <?=$total_record?>개 </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">경품수령대기 : <b><?=$total_record - $E_cnt?>개 </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">경품수령완료 : <b><?=$E_cnt?>개 </b></font></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="645" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="5" bgcolor="FF5B5C"></td>
              </tr>
              <tr>
                <td height="27"><table width="645" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center"><img src="/img/title13.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="120" align="center"><img src="/img/title14.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title10.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title15.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="90" align="center"><img src="/img/title16.gif" width="70" height="20" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="FF5B5C"></td>
              </tr>
            </table>
              <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td></td>
                </tr>
              </table>

<?=$LIST?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="6" bgcolor="FF5B5C"></td>
                </tr>
              </table>
            <table width="100" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
				  <? 
					echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str);
					?>
				  </td>
                </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>

<? include "../include/_foot.php"; ?>