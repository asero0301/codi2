<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/history.php
 * date   : 2009.02.04
 * desc   : ���������� ��÷����Ʈ
 *			�� �������� ������ ���� quick �޴� html�� �ٽ� �����ȴ�.
 *			gt_reg_dt �� status_reg_dt ���� ������ ��÷�ڰ� ���� Ȯ�ξ��Ѱŷ� �����ϰ�
 *			status_reg_dt �� ���� �ð����� update �Ѵ�.
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

	if ( $gt_stamp == $stamp ) {	// Ȯ������ ������ ������ Ȯ���Ѱɷ� �ٲ۴�.
		$sql2 = "update tblGiftTracking set status_reg_dt = now() where gt_idx = $gt_idx ";
		$mainconn->query($sql2);
		$modify_yn = "Y";
	}

	// ��ǰ�� ���� �߼��ߴ��� Ȯ���ϱ����� ���� �ֱ� status_reg_dt ���� ���ؼ� ����ð��� ���̸� ���Ѵ�.
	$diff_time = floor((time()-$stamp)/3600);


	$tmp_main_img = $UP_URL."/thumb/".$p_main_img;

	// ������ ��ũ
	if ( $shop_medal == "Y" ) {
		$shop_medal_mark = "<img src='/img_seri/icon_ks.gif' border='0' align='absmiddle' />";
	} else {
		$shop_medal_mark = "&nbsp;";
	}

	// ����Ʈ �ڵ� ��ũ
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

	// ���°��� ���� �ٸ���
	switch ( $gt_status ) {
		case "A" :
			$status_str = "<b><font color='#0070B7'>���</font></b><a href='#' onClick=\"go_bad_shop_write('','');\"><img src='/img/shop_bad.gif' border='0' /></a>";
			break;
		case "B" :
			$status_str = "<b><font color='#0070B7'>Ȯ��</font></b><br />(�߼��غ���)<a href='#' onClick=\"go_bad_shop_write('','');\"><img src='/img/shop_bad.gif' border='0' /></a>";
			break;
		case "E" :
			$status_str = "<b><font color='#DD2457'>�Ϸ�</font></b>";
			break;
		default :	// C,D �ϰ��
			$status_str = "
			<b><font color='#0070B7'>�߼ۿϷ�</font></b><br />
                    (".$diff_time."�ð� ��)
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

	// �� ���� ���̾�
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

// ��÷����(tblGiftTracking ����), ��ǰ���ɴ��(E ���� ������), ��ǰ���ɿϷ�(gt_status == "E" ����)
// ���ɿϷ� ������ ���Ѵ�.
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
    <td width="200" valign="top"><!-- �ְ� �ڵ� top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- ���������� ���� //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
    <!-- ���� ���̵� 5�� �Ѹ� �� //--> </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">��÷���� :</font></b> <font color="#FFFFFF">���ݱ��� ��÷�� �����Դϴ�.</font> </td>
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
                    <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� :</font> �ش� ������ ���� ��÷������ Ȯ������ �ʾҽ��ϴ�.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                    
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">Ȯ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� :</font> �ش� ������ ��÷������ Ȯ���Ͽ� ��ǰ�� �߼� �غ��߿� �ֽ��ϴ�.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                      <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">�߼ۿϷ� :</font> �ش缥���� ��ǰ�� �߼��߽��ϴ�.
                      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
					   <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">����Ȯ�� : </font>��ǰ�� �̻���� �����̴ٸ� ����Ȯ���� ���ּ���. (�߼ۿϷ� �� <font color="#DD2457"><u>7���� ������ �ڵ����� �Ϸ�</u></font> ó���˴ϴ�.) 
					   <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                         <tr>
                           <td></td>
                         </tr>
                       </table>
					    <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� : </font>��ǰ�� �̻���� �����Ͽ����ϴ�. </td>
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
          <td width="33%" height="28" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">��÷���� :<b> <?=$total_record?>�� </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">��ǰ���ɴ�� : <b><?=$total_record - $E_cnt?>�� </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">��ǰ���ɿϷ� : <b><?=$E_cnt?>�� </b></font></td>
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