<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_codi_view.php
 * date   : 2008.10.13
 * desc   : 마이페이지에서 코디 정보를 보는 팝업창
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$p_idx = trim($_POST['p_idx']);

// 코드/캐시 값을 구한다.
$inc_sql = "select * from tblCashConfig ";
$inc_res = $mainconn->query($inc_sql);
$CASHCODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_cc_cid = trim($inc_row['cc_cid']);
	$inc_cc_cval = trim($inc_row['cc_cval']);
	$inc_etc_conf = trim($inc_row['etc_conf']);
	$inc_cash = trim($inc_row['cash']);

	//$CASHCODE[$inc_cc_cid] = $inc_cash;
	$CASHCODE[$inc_cc_cid] = array($inc_cc_cval, $inc_cash, $inc_etc_conf);
}

$sql = "
	select *,
	(select start_dt from tblProductEach where p_idx = tblProduct.p_idx order by p_e_idx asc limit 1) as start_dt,
	(select end_dt from tblProductEach where p_idx = tblProduct.p_idx order by p_e_idx desc limit 1) as end_dt,
	(select count(*) from tblProductUpDown where p_idx = tblProduct.p_idx and p_u_val = 1) as up,
	(select count(*) from tblProductUpDown where p_idx = tblProduct.p_idx and p_u_val = -1) as down,
	(select count(*) from tblProductComment where p_idx = tblProduct.p_idx) as comment_cnt,
	(select count(*) from tblProductVisit where p_idx = tblProduct.p_idx) as visit
	from tblProduct
	where p_idx = $p_idx
	";

$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$shop_idx = trim($row['shop_idx']);
$p_title = trim($row['p_title']);
$p_gift = trim($row['p_gift']);
$p_auto_extend = trim($row['p_auto_extend']);
$p_judgment = trim($row['p_judgment']);
$p_view = trim($row['p_view']);
$p_reg_dt = trim($row['p_reg_dt']);
$up = trim($row['up']);
$down = trim($row['down']);
$comment_cnt = trim($row['comment_cnt']);
$visit = trim($row['visit']);
$start_dt = trim($row['start_dt']);
$end_dt = trim($row['end_dt']);


// 샵방문 로그를 구한다.
if ( $page == "" ) $page = 1;

$cond = " where 1 and p_idx = $p_idx ";

// record count
$sql = "select count(DISTINCT(p_v_ip)) from tblProductVisit $cond ";
$total_record = $mainconn->count($sql);

$total_page = ceil($total_record/$PAGE_SIZE);
if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$orderby = " order by p_v_idx desc ";

$sql = "SELECT p_v_ip, min(p_v_reg_dt) as first, max(p_v_reg_dt) as last, count(*) AS cnt FROM tblProductVisit $cond GROUP BY p_v_ip limit $first, $PAGE_SIZE";
$res = $mainconn->query($sql);

$LIST = "";
//$article_num = $total_record - $PAGE_SIZE*($page-1);
$click_count = 0;
$cash_sum = 0;
while ( $row = $mainconn->fetch($res) ) {
	$p_v_ip = trim($row['p_v_ip']);
	$first = substr(trim($row['first']),0,10);
	$last = substr(trim($row['last']),0,10);
	$cnt = trim($row['cnt']);
	$click_count += $cnt;
	
	if ( $cnt > 10 ) {
		$cash_sum += ($cnt - 10) * $CASHCODE['CC53'][1];
	}
	
	$LIST .= "
	<tr>
		<td width='152' height='28' align='center' bgcolor='F9F9F9'>$p_v_ip</td>
		<td width='134' align='center' bgcolor='F9F9F9' class='date'>$first</td>
		<td width='130' align='center' bgcolor='F9F9F9' class='date' >$last</td>
		<td align='center' bgcolor='F9F9F9' class='evfont'><font color='#009933'>$cnt</font></td>
	</tr>
	<tr>
		<td height='1' colspan='4' bgcolor='#E0E0E0'></td>
	</tr>
		";
}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$mainconn->close();

?>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100">&nbsp;</td>
        <td align="center" class="intitle"><font color="#FFFFFF"><b>코디상품 평가상황 상세보기</b></font></td>
        <td width="100" align="right"><span class="intitle" style="padding-bottom:10"><a href="javascript:self.close()"><img src="/img/btn_close02.gif" border="0"  align="absmiddle"/></a></span></td>
      </tr>
    </table>      
    </td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td height="570" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="18" valign="top"><img src="/img/icon_list.gif" width="10" height="11"  align="absmiddle" /></td>
        <td><font color="DD2457"><?=$p_title?> </font></td>
      </tr>
    </table>
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
        <tr>
          <td style="padding:15 15 15 15" class="intext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="22"><img src="/img/icon_aa.gif"  align="absmiddle"> <font color="#333333">등록일 : </font><span class="date" ><?=substr($start_dt,0,10)?> (<?=substr($start_dt,11,5)?>)</span> </td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle">  <font color="#333333">마감일 :</font> <span class="date" ><?=substr($end_dt,0,10)?> (<?=substr($end_dt,11,5)?>)</span></td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">조회수 :</font><span class="evfont"> <font color="DD2457"><?=$p_view?></font></span></td>
            </tr>
            <tr>
              <td height="22"><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">코디업 :</font><span class="evfont"> <b><font color="#CC3300"><?=$up?></font></b></span> </td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">코디다운 :</font><span class="evfont"> <font color="FF5B5C"><?=$down?></font></span> </td>
              <td><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">댓글평가 : </font><span class="evfont"><?=$comment_cnt?></span> </td>
            </tr>
			  <tr>
              <td height="22"><img src="/img/icon_aa.gif"  align="absmiddle" /> <font color="#333333">샵방문 :</font> <span class="evfont"><?=$visit?> </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
			  </tr>
          </table>
            </td>
        </tr>
      </table>
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="DD2457">
        <tr>
          <td width="130" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><b><font color="CC0000">샵 방문 상세로그 </font></b></td>
          <td align="center" bgcolor="#FFFFFF" ><table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="110" align="center"><img src="/img/icon00.gif" align="absmiddle"> 클릭한 IP : <?=$total_record?> </td>
              <td width="110" align="center"><img src="/img/icon00.gif" align="absmiddle"> 총 클릭수 : <?=$click_count?> </td>
              <td align="center"><img src="/img/icon00.gif" align="absmiddle"> <font color="FF0078">소요된 캐쉬 :</font> <span class="evgray"><font color="FF0078"><b><?=$cash_sum?> cash</b></font></span> </td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" colspan="4" bgcolor="E0295A"></td>
        </tr>
        <tr>
          <td width="152" height="26" align="center" class="intitle">IP</td>
          <td width="134" align="center" class="intitle">최초클릭일</td>
          <td width="130" align="center" class="intitle">최근클릭일</td>
          <td align="center" class="intitle">클릭수</td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="E0295A"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <?=$LIST?>
      
      </table>
      <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center">
		  <? 
			echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str);
		  ?>
		  </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
        <tr>
          <td align="center"><img src="/img/btn_close.gif" width="70" height="20" border="0" onClick="self.close();" style="cursor:hand;" /></td>
        </tr>
      </table>
      </td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>
</table>
