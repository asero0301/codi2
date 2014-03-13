<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/comment.php
 * date   : 2009.01.30
 * desc   : 마이페이지 평가한 코디
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$page = $_REQUEST['page'];

if ( $page == "" ) $page = 1;

$cond = " and A.p_idx = B.p_idx and A.p_idx = C.p_idx and B.p_e_idx = C.p_e_idx and A.shop_idx = D.shop_idx and C.mem_id = '$mem_id' ";

// record count
$sql = "select count(*) from tblProduct A, tblProductEach B, tblProductUpDown C, tblShop D where 1 $cond ";
//echo "cnt : $sql <br>";
$total_record = $mainconn->count($sql);

$total_page = ceil($total_record/$PAGE_SIZE);
if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$orderby = " order by B.end_dt desc ";


// tblProduct, tblProductEach, tblProductUpDown, tblShop
$sql = "
select A.p_idx, B.p_e_idx, A.p_title, A.p_main_img, A.p_top10_num, A.p_gift, D.shop_name, D.shop_url, D.mem_id, D.shop_mobile, D.shop_phone, D.shop_medal, B.end_dt,
(select count(*) from tblGiftTracking where p_e_idx = B.p_e_idx) as all_cnt,
(select count(*) from tblGiftTracking where p_e_idx = B.p_e_idx and user_mem_id = '$mem_id') as my_cnt,
ifnull((select rs_total_rank from tblRankShop where shop_idx=D.shop_idx order by rs_idx desc limit 1),0) as rs_total_rank
from tblProduct A, tblProductEach B, tblProductUpDown C, tblShop D
where 1
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);
$LIST = "";
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cnt++;

	$p_idx = trim($row['p_idx']);
	$p_e_idx = trim($row['p_e_idx']);
	$p_title = strip_str(trim($row['p_title']));
	$p_main_img = trim($row['p_main_img']);
	$p_top10_num = trim($row['p_top10_num']);
	$p_gift = trim($row['p_gift']);
	$shop_name = trim($row['shop_name']);
	$shop_mem_id = trim($row['mem_id']);
	$shop_url = trim($row['shop_url']);
	$shop_mobile = trim($row['shop_mobile']);
	$shop_phone = trim($row['shop_phone']);
	$shop_medal = trim($row['shop_medal']);
	$rs_total_rank = trim($row['rs_total_rank']);
	$end_dt = trim($row['end_dt']);
	$all_cnt = trim($row['all_cnt']);
	$my_cnt = trim($row['my_cnt']);

	$end_dt = str_replace("-",".",substr($end_dt,0,10)	);
	$p_main_img = $UP_URL."/thumb/".$p_main_img;

	// 인증샵 마크
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0'>";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	// 베스트 코디 마크
	if ( $p_top10_num >= 4 ) {
		$codi_mark = "<img src='/img/btn_best.gif' width='32' height='15' align='absmiddle' />";
	} else {
		$codi_mark = "&nbsp;";
	}

	$status_str = "";
	if ( $my_cnt > 0 ) {	// 당첨
		$status_str = "<img src='/img/btn_luck02.gif' border='0'>";
	} else if ( $all_cnt > 0 ) {	// 실패
		$status_str = "<img src='/img/btn_fail.gif' border='0'>";
	} else {	// 진행중
		$status_str = "<img src='/img/btn_ing.gif' border='0'>";
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=$PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_list_$j','','$sh',";
		$param_hide .= "'shopview_list_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);	


	$LIST .= "
	  <table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		  <td width='100'><table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
			  <tr>
				<td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='95' height='95' border='0' /></a></td>
			  </tr>
		  </table></td>
		  <td  style='padding-left:5;padding-right:8'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a>$codi_mark</td>
		  <td width='123' align='center'>$p_gift </td>
		  <td width='102' align='center' class='shopname'>
			<a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$shop_name</a><br />
			($shop_mobile/$shop_phone)
	";

	// 샵 정보 레이어
	$LIST .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 30, -85, $rs_total_rank, $shop_url, $shop_name, $shop_mem_id, $param_hide);

	$LIST .= "
		  </td>
		  <td width='103' align='center' class='date'>$end_dt</td>
		  <td width='91' align='center'>$status_str</td>
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

if ( $total_record == 0 ) {
	$LIST .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		  <td width='100%'>평가참여한 코디가 없습니다.</td>
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

if ( $cnt < $PAGE_SIZE ) {
	for ( $i=$cnt+1; $i<=$PAGE_SIZE; $i++ ) {
		$LIST .= "<div id='shopview_list_{$i}' style='position:relative; z-index:2; left:445px; top: -122px;visibility: hidden;'></div>";
	}
}

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
        <td background="/img/bar03.gif"><b><font color="FFFC11">평가한 코디 :</font></b> <font color="#FFFFFF">지금까지 평가참여하신 코디상품들입니다.</font> </td>
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
                    <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">평가참여한 코디가 <b><font color="FF0078">총 <?=$total_record?>개</font></b> 있습니다. </font></td>
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
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="645" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="6" bgcolor="FF5B5C"></td>
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
                      <td width="100" align="center"><img src="/img/title17.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="90" align="center"><img src="/img/title18.gif" width="70" height="20" /></td>
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
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/mypage/comment.php",$qry_str);
?>				  
				  </td>
                </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>

<? include "../include/_foot.php"; ?>