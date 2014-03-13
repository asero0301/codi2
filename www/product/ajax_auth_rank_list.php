<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/ajax_auth_rank_list.php
 * date   : 2009.01.15
 * desc   : 인증샵 리스트 ajax 처리
 *
 * 이 페이지는 페이지의 DB로딩을 줄이기 위한 /proc/make_auth_rank_list.php와 로직이 동일하다.
 * /proc/make_auth_rank_list.php 파일은 DB부하를 줄이기위한 html파일(/tpl/sub/cache_auth_rank_list.tpl)을 생성한다.
 *******************************************************/
session_start();
ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 인증여부 체크
//auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$kind	= trim($_REQUEST['kind']);	// default : 최근순서, stat : 오래된 순서
$key	= trim($_REQUEST['key']);
$kwd	= trim($_REQUEST['kwd']);
$page	= trim($_REQUEST['page']);

if ( !$page ) $page = 1;
if ( !$kind ) $kind = "default";

if ( $kind == "default" ) {
	$tab_img_1 = "tap_shop_ov_01.gif";
	$tab_img_2 = "tap_shop_02.gif";
} else {	// stat
	$tab_img_1 = "tap_shop_01.gif";
	$tab_img_2 = "tap_shop_ov_02.gif";
}

$str = "
      <table width='645' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td width='129'><a href='#' onClick=\"loadAuthShopList('default','$key','$kwd','1','');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image23','','/img/tap_shop_ov_01.gif',1);\"><img src='/img/{$tab_img_1}' width='190' name='Image23' height='30' border='0' id='Image23' /></a></td>
		  <td width='130'><a href='#' onClick=\"loadAuthShopList('stat','$key','$kwd','1','');\" onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('Image24','','/img/tap_shop_ov_02.gif',1);\"><img src='/img/{$tab_img_2}' name='Image24' width='190' height='30' border='0' id='Image24' /></a></td>
          <td align='right' background='/img/tap_04.gif'>&nbsp;</td>
        </tr>
      </table>

      <table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td></td>
        </tr>
      </table>

      <table width='645' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td><table width='645' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td height='6' bgcolor='FF5B5C'></td>
            </tr>
            <tr>
              <td height='27'><table width='645' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td align='center'><img src='/img/title10.gif' width='70' height='20'></td>
                  <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9'></td>
                  <td width='100' align='center'><img src='/img/title43.gif' width='70' height='20'></td>
                  <td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
                  <td width='130' align='center'><img src='/img/title11.gif' width='70' height='20'></td>
                  <td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
                  <td width='70' align='center'><img src='/img/title12.gif' width='70' height='20'></td>
                  <td width='3'><img src='/img/title_line.gif' width='3' height='9'></td>
                  <td width='70' align='center'><img src='/img/title08.gif' width='70' height='20'></td>
                  <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9'></td>
                  <td width='70' align='center'><img src='/img/title09.gif' width='70' height='20'></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height='1' bgcolor='FF5B5C'></td>
            </tr>
          </table>
            <table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
              <tr>
                <td></td>
              </tr>
            </table>
";

// tblRankShop의 가장 최근 시작/종료일을 구한다.
$sql = "select rs_start_dt, rs_end_dt from tblRankShop order by rs_idx desc limit 1 ";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);
$rs_start_dt = trim($row['rs_start_dt']);
$rs_end_dt = trim($row['rs_end_dt']);

if ( !$rs_start_dt && !$rs_end_dt ) {
	$str .= "</td></tr></table>";
	echo $str;
	exit;
}

$cond = " and A.shop_idx = B.shop_idx and A.shop_status = 'Y' and A.shop_medal = 'Y' ";
$cond .= " and B.rs_start_dt = '$rs_start_dt' and B.rs_end_dt = '$rs_end_dt' ";

if ( $kind == "default" ) {
	$orderby = " order by A.shop_reg_dt desc ";
} else {
	$orderby = " order by A.shop_reg_dt asc ";
}

$sql = "select count(*) from tblShop A, tblRankShop B where 1 $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$sql = "
select
A.shop_idx, A.mem_id, A.shop_name, A.shop_url, A.shop_person, A.shop_mobile, A.shop_phone, A.shop_logo, A.shop_medal,
(select count(*) from tblProduct where shop_idx = A.shop_idx and p_judgment != 'R') as codi_cnt,
B.rs_score, B.rs_rank, B.rs_total_score, B.rs_total_rank 
from tblShop A, tblRankShop B
where 1 $cond $orderby limit $first, $PAGE_SIZE
";

//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$cnt = 1;
while ( $row = $mainconn->fetch($res) ) {
	$shop_idx = trim($row['shop_idx']);
	$s_shop_mem_id = trim($row['mem_id']);
	$shop_person = trim($row['shop_person']);
	$shop_url = trim($row['shop_url']);
	$s_shop_name = trim($row['shop_name']);
	$shop_medal = trim($row['shop_medal']);
	$shop_mobile = trim($row['shop_mobile']);
	$shop_phone = trim($row['shop_phone']);
	$shop_logo = trim($row['shop_logo']);
	$codi_cnt = trim($row['codi_cnt']);
	$rs_score = trim($row['rs_score']);
	$rs_rank = trim($row['rs_rank']);
	$rs_total_score = trim($row['rs_total_score']);
	$rs_total_rank = trim($row['rs_total_rank']);

	$shop_logo = $UP_URL."/thumb/".$shop_logo;

	// 인증샵 마크
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0'>";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	$prt_rank = $rs_total_rank;
	$prt_score = $rs_total_score;

	$param_show = $param_hide = "";
	for ( $j=1; $j<=10; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_list_$j','','$sh',";
		$param_hide .= "'shopview_list_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);

	$str .= "
            <table width='645' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td width='100'>
				<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
                    <tr>
                      <td bgcolor='#3D3D3D'><<a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'><img src='$shop_logo' width='95' height='95' border='0'></a></td>
                    </tr>
                </table>
				</td>
                <td  style='padding-left:5;padding-right:8'class='shopname'><a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$s_shop_name</a>
	";

	// 샵 정보 레이어
	$str .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $prt_rank, $shop_url, $s_shop_name, $s_shop_mem_id, $param_hide);
	
	$str .= "
					$shop_medal_mark
				</td>
                <td width='102' align='center'>$shop_mobile<br>$shop_phone</td>
                <td width='133' align='center'>$shop_person</td>
                <td width='74' align='center' >$codi_cnt</td>
                <td width='72' align='center'><font color='FF5D5E'>$rs_total_score</font></td>
                <td width='72' align='center'><font color='9E6ED1'><b>$prt_rank</b></font></td>
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

	$cnt++;
}	// while


$str .= "
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td height='6' bgcolor='FF5B5C'></td>
					</tr>
				</table>
				<table width='100' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width='100%' height='45' border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td align='center'>
";

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}



// 페이징(term, f_date, key, page, kwd)
$str .= ajax_general_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"loadShopRankSubList", $kind, $key, $kwd, $page);

$str .= "
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
";

$mainconn->close();

echo $str;
?>