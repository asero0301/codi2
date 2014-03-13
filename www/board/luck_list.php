<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/luck_list.php
 * date   : 2009.01.22
 * desc   : 당첨자 리스트
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

// 가장 최근 당첨 모듈 실행시각(이번주 일요일 0시 50분)
//$cur = date("Y-m-d H:i:s", time());
$arr = getWeekDay( "current", time() );
$this_sunday = $arr[0]." 00:50:00";


//$groupby = " group by D.p_e_idx ";
$cond = " where 1 and A.p_idx = B.p_idx and A.shop_idx = C.shop_idx and B.end_dt < '$this_sunday' ";

/*
SELECT A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.p_gift, B.p_e_idx, B.end_dt, C.mem_id, C.shop_name, C.shop_url, ifnull( (
SELECT rs_total_rank
FROM tblRankShop
WHERE shop_idx = C.shop_idx
ORDER BY rs_idx DESC
LIMIT 1
), 0 ) AS rs_total_rank
FROM tblProduct A, tblProductEach B, tblShop C
WHERE 1
AND A.p_idx = B.p_idx
AND A.shop_idx = C.shop_idx
AND B.end_dt < '2009-02-13 12:12:12'
ORDER BY B.end_dt DESC
*/

// 검색: 샵(S),제목(T),샵+제목(ST),키워드(K)
if ( $key != "" && $kwd != "" ) {
	if ( $key == "S" ) {
		$cond .= " and C.shop_name like '%$kwd%' ";
	} else if ( $key == "T" ) {
		$cond .= " and A.p_title like '%$kwd%' ";
	} else if ( $key == "K" ) {
		$cond .= " and ( A.p_style_kwd like '%$kwd%' or A.p_item_kwd like '%$kwd%' or A.p_theme_kwd like '%$kwd%' ) ";
	} else {	// 샵+제목
		$cond .= " and ( A.p_title like '%$kwd%' or C.shop_name like '%$kwd%' ) ";
	}
}

// record count
$sql = "select count(*) from tblProduct A, tblProductEach B, tblShop C $cond ";
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

$qry_str = "&key=$key&kwd=$kwd";
$orderby = " order by B.end_dt desc ";

$sql = "
select A.p_idx, A.p_title, A.p_main_img, A.p_top10_num, A.p_gift,
B.p_e_idx, B.end_dt, C.mem_id, C.shop_name, C.shop_url,
ifnull((select rs_total_rank from tblRankShop where shop_idx=C.shop_idx order by rs_idx desc limit 1),0) as rs_total_rank
from tblProduct A, tblProductEach B, tblShop C
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cnt++;
	$p_idx			= trim($row['p_idx']);
	$p_title		= strip_str(trim($row['p_title']));
	$p_main_img		= trim($row['p_main_img']);
	$p_top10_num	= trim($row['p_top10_num']);
	$p_gift			= strip_str(trim($row['p_gift']));
	$p_e_idx		= trim($row['p_e_idx']);
	$end_dt			= trim($row['end_dt']);
	$shop_mem_id	= trim($row['mem_id']);
	$s_shop_name		= trim($row['shop_name']);
	$shop_url		= trim($row['shop_url']);
	$rs_total_rank	= trim($row['rs_total_rank']);

	$p_main_img = $UP_URL."/thumb/".$p_main_img;
	
	$end_dt = str_replace("-",".",$end_dt);
	$end_dt = str_replace(" ","<br>",$end_dt);

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

	$sql2 = "
	select user_mem_id, 
	(select mem_name from tblMember where mem_id=tblGiftTracking.user_mem_id) as user_mem_name 
	from tblGiftTracking
	where p_e_idx = $p_e_idx
	";
	//echo $sql2."<p><p>";
	$res2 = $mainconn->query($sql2);

	$mem_list = "";
	while ( $row2 = $mainconn->fetch($res2) ) {
		
		$user_mem_id	= trim($row2['user_mem_id']);
		$user_mem_name	= trim($row2['user_mem_name']);

		$mem_list .= "<tr><td width='100%'>".substr($user_mem_id, 0, -2)."** (".substr($user_mem_name,0,2)."*".substr($user_mem_name,4).")</td></tr>";
	}

	if ( $mem_list == "" ) {
		$mem_list .= "<tr><td width='100%'>당첨자 없음</td></tr>";
	}

	$LIST .= "
            <table width='645' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='100'>
				  <table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
                      <tr>
                        <td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='95' height='95' border='0' /></a></td>
                      </tr>
                  </table>
				  </td>
                  <td  style='padding-left:5;padding-right:8'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a>$codi_mark</td>
                  <td width='123' align='center'>$p_gift </td>
                  <td width='92' align='center'  class='shopname'>
					<a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$s_shop_name</a>
	";

	// 샵 정보 레이어
	$LIST .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $rs_total_rank, $shop_url, $s_shop_name, $shop_mem_id, $param_hide);

	$LIST .= "
				  </td>
                  <td width='83' align='center' class='date' >$end_dt</td>
                  <td width='110' align='center'>
                    <table width='90%' border='0' cellspacing='0' cellpadding='0'>
                      $mem_list
                    </table>
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

if ( $cnt < $PAGE_SIZE ) {
	for ( $i=$cnt+1; $i<=$PAGE_SIZE; $i++ ) {
		$LIST .= "<div id='shopview_list_{$i}'  style='position:relative; z-index:2; left:445px; top: -122px;visibility: hidden;'></div>";
	}
}

$mainconn->close();
?>

<? require_once "../include/_head.php"; ?>


<table border="0" cellspacing="0" cellpadding="0">
<form id="board_frm" name="board_frm" method="post">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			 <!-- 게시판 메뉴 시작 //-->
			
			<? include "../include/left_board.php" ?>
			
			 <!-- 게시판 메뉴 끝 //-->
			 
			 </td>
          </tr>
        </table>
      
              </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">당첨자 확인 :</font></b> <font color="#FFFFFF">평가기간이 완료되어 당첨자가 확정된 코디상품입니다. 당첨자를 확인할 수 있습니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
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
                      <td width="90" align="center"><img src="/img/title42.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="80" align="center"><img src="/img/title17.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="110" align="center"><img src="/img/title29.gif" width="70" height="20" /></td>
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
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/board/luck_list.php",$qry_str);
?>
				  </td>
                </tr>
            </table></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
        <tr>
          <td height="30" bgcolor="F6F5F5" style="padding-top:3">&nbsp;
              <input name="key" type="radio" value="S" <?if ($key=="S") echo " checked";?> />샵
              <input name="key" type="radio" value="T" <?if ($key=="T") echo " checked";?> />제목
              <input name="key" type="radio" value="ST" <?if ($key=="ST" || $key=="") echo " checked";?> />샵+제목
              <input name="key" type="radio" value="K" <?if ($key=="K") echo " checked";?> />키워드 
		  </td>
          <td align="right" bgcolor="F6F5F5" style="padding-right:5"><input type="text" name="kwd" class="logbox"  style="width:300" value="<?=$kwd?>" />
            <a href="#" onClick="go_board_search();"><img src="/img/btn_search.gif" align="absmiddle" border="0" /></a></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>

<? include "../include/_foot.php"; ?>