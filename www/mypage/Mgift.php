<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/Mgift.php
 * date   : 2009.02.04
 * desc   : ���������� ��ǰ���� ����Ʈ
 *
 * ============ �߿� : gt_status ���� ��ȭ���� ==========
 *
 * A (Ȯ��)		: ó�� ��ǰ�� ��÷�Ǿ������� ��
 * B (�߼۴��) : ��ȸ���� Ȯ�ι����� ������ �˾��� �����
 * C (�߼ۿϷ�) : ��ȸ���� ������ �߼��ϰ� ������.
 * D (����Ȯ����) : �ѻ���̶� �޾�����(���� �� ������ ���� ����) - gt_ok == "Y"
 * E (�Ϸ�)		: ��� ������, �Ǵ� �߼ۿϷ���� 7���� ������
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);


if ( $page == "" ) $page = 1;

// ���º� ������ ���Ѵ�.
$A_cnt = $B_cnt = $C_cnt = $D_cnt = $E_cnt = 0;
$sql = "select gt_status, count(*) as cnt from tblGiftTracking where shop_mem_id = '$mem_id' group by gt_status ";
$res = $mainconn->query($sql);
while ( $row = $mainconn->fetch($res) ) {
	$gt_status = trim($row['gt_status']);
	$gt_cnt = $row['cnt'];

	switch ( $gt_status ) {
		case "A" :
			$A_cnt = $gt_cnt;
			break;
		case "B" :
			$B_cnt = $gt_cnt;
			break;
		case "C" :
			$C_cnt = $gt_cnt;
			break;
		case "D" :
			$D_cnt = $gt_cnt;
			break;
		case "E" :
			$E_cnt = $gt_cnt;
			break;
	}
}


//$cond = " where 1 and A.shop_mem_id = '$mem_id' ";
$sql = "
SELECT count(*)
FROM tblProduct A, tblProductEach B, tblGiftTracking C
WHERE 1
AND A.p_idx = B.p_idx
AND B.p_e_idx = C.p_e_idx
AND C.shop_mem_id = '$mem_id'
GROUP BY C.p_e_idx
";
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
$orderby = " order by C.gt_idx desc ";

$sql = "
SELECT A.p_idx, A.p_title, A.p_main_img, A.p_gift, A.p_gift_cnt, B.p_e_idx, B.end_dt
FROM tblProduct A, tblProductEach B, tblGiftTracking C
WHERE 1
AND A.p_idx = B.p_idx
AND B.p_e_idx = C.p_e_idx
AND C.shop_mem_id = '$mem_id'
GROUP BY C.p_e_idx
$orderby limit $first, $PAGE_SIZE 
";
//echo "sql:".$sql."<br>";
$res = $mainconn->query($sql);

$p_e_cnt = 0;
$old_p_e_idx = 0;
$lotto_list = "";
$row_again = array();


while ( $row = $mainconn->fetch($res) ) {
	$p_idx		= trim($row['p_idx']);
	$p_title	= strip_str(trim($row['p_title']));
	$p_main_img	= trim($row['p_main_img']);
	$p_gift		= strip_str(trim($row['p_gift']));
	$p_e_idx	= trim($row['p_e_idx']);
	$p_gift_cnt	= trim($row['p_gift_cnt']);
	$end_dt		= trim($row['end_dt']);
	
	$p_main_img = $UP_URL."/thumb/".$p_main_img;
	
	$end_dt = substr($end_dt, 0, 10);
	$end_dt = str_replace("-",".",$end_dt);

	$TXT .= "
	<table width='645' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='100'>
			<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
				<tr>
					<td bgcolor='#3D3D3D'><a href='#' onClick=\"codi_view('$p_idx');\"><img src='$p_main_img' width='95' height='95' border='0' /></a></td>
				</tr>
			</table>
			</td>
			<td  style='padding-left:5;padding-right:8'><a href='#' onClick=\"codi_view('$p_idx');\">$p_title</a><img src='/img/btn_best.gif' width='32' height='15' align='absmiddle' /></td>
			<td width='123' align='center'>$p_gift </td>
			<td width='92' align='center' class='date' >$end_dt</td>
			<td width='113' align='center'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	";

	$sql2 = "
	select gt_status, user_mem_id, 
	(select mem_name from tblMember where mem_id=tblGiftTracking.user_mem_id) as user_mem_name 
	from tblGiftTracking
	where p_e_idx = $p_e_idx
	";
	//echo "sql2:".$sql2."<br>";
	$res2 = $mainconn->query($sql2);

	$status_list = "";
	$gift_cnt = 0;
	while ( $row2 = $mainconn->fetch($res2) ) {
		$gt_status = trim($row2['gt_status']);
		$user_mem_id = trim($row2['user_mem_id']);
		$user_mem_name = trim($row2['user_mem_name']);
		$gt_status_str = $TRACKCODE[$gt_status];

		$status_list .= $gt_status;

		if ( $gt_status == "E" ) {
			$gt_font_1 = "<font color='#DD2457'>"; $gt_font_2 = "</font>";
		} else {
			$gt_font_1 = $gt_font_2 = "";
		}

		$TXT .= "
		<tr>
			<td width='100%'>
			<table width='100%' border='0' cellspacing='0' cellpadding='2'>
				<tr>
					<td><a href='#' onclick=\"gift_result_view('$p_e_idx');\">$gt_font_1 $user_mem_id ($user_mem_name)$gt_font_2</a></td>
				</tr>
			</table>
			</td>
		</tr>
		";
		
		$gift_cnt++;
	}

	// ���¿� ���� ���ϸ���� �ٲ��.
	$status_chg_btn = "";
	if ( preg_match("#A#", $status_list) ) {
		$status_chg_btn = "<a href='#' onClick=\"gift_result_view('$p_e_idx');\"><img src='/img/btn_ok04.gif' border='0' /></a>";
	} else if ( preg_match("#B#", $status_list) ) {
		$status_chg_btn = "<a href='#' onClick=\"chg_tracking('$p_e_idx','C','".strlen($status_list)."');\"><img src='/img/btn_deli_ok02.gif' border='0' /></a>";
	} else if ( chkAllStr($status_list, "E") ) {
		$status_chg_btn = "<b><font color='#DD2457'>�Ϸ�</font></b>";
	} else {
		$ok_cnt = getGiftOk($status_list, "E");
		$status_chg_btn = "����Ȯ����<br>({$ok_cnt}/".strlen($status_list).")";
	}

	$TXT .= "
			</table>
			</td>
			<td width='80' align='center'><span id='btn_chg_area_{$p_e_idx}'>$status_chg_btn</span></td>
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

$mainconn->close();
?>

<? include "../include/_head.php"; ?>

<iframe name="__blank__" width="0" height="0"></iframe>

<script language="javascript">
function chg_tracking(idx, code, len) {
	var f = document.gift_frm;
	f.p_e_idx.value = idx;
	f.code.value = code;
	f.len.value = len;
	f.target = "__blank__";
	f.action = "/mypage/gift_status_ok.php";
	f.submit();
}
</script>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- ���������� ���� //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- ���������� ���� //-->
			</td>
          </tr>
        </table>
       
      </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">��ǰ���ް��� :</font></b> <font color="#FFFFFF">��ǰ���������� ������Ų �ڵ��ǰ�� ������ �� �ֽ��ϴ�.</font> </td>
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
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">Ȯ �� : ��÷������ Ȯ���Ͽ��ٸ� Ȯ���� Ŭ�����ּ���.(��÷�ڸ� Ŭ�� - ��÷ȸ�� ������ Ȯ��) 
					  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
					  <img src="/img/icon_book.gif"  align="absmiddle" /> �߼۴�� : ��÷������ Ȯ���Ͽ� ��ǰ�� �߼� �غ��߿� �ֽ��ϴ�. 
					  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
					  <img src="/img/icon_book.gif"  align="absmiddle" />
					  �߼ۿϷ� : ��ǰ�� �̻���� �߼��ߴٸ� <u><font color=DD2457>�߼ۿϷḦ Ŭ��</font></u>���ּ���.<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(��÷ȸ���� ����Ȯ���� �ϰų�, �߼ۿϷ� �� 7���� ������ �ڵ����� �Ϸ� ó���˴ϴ�.) 
					  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
					  <img src="/img/icon_book.gif"  align="absmiddle" /> ����Ȯ���� : �߼��� ��ǰ�� ��÷ȸ������ ���ɵ� ��Ȳ�� �� �� �ֽ��ϴ�. 
					  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
					  <img src="/img/icon_book.gif"  align="absmiddle" />
					  �� �� : <u><font color=DD2457>�߼��� ��ǰ�� ��÷ȸ���� �̻���� ����</font></u>�Ͽ����ϴ�. 
                      </font></td>
                    </tr>
                </table></td>
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
          <td width="20%" height="28" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">Ȯ�� :<b> <?=$A_cnt?>�� </b></font></td>
          <td width="20%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">�߼۴�� : <b><?=$B_cnt?>�� </b></font></td>
		  <td width="20%" height="28" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">�߼ۿϷ� :<b> <?=$C_cnt?>�� </b></font></td>
          <td width="20%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">����Ȯ���� : <b><?=$D_cnt?>�� </b></font></td>
          <td width="20%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">���޿Ϸ� : <b><?=$E_cnt?>�� </b></font></td>
          <!--<td width="20%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">��ǰ���� ��ü : <b>202��</b></font> </td>-->
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
                      <td width="90" align="center"><img src="/img/title15.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="110" align="center"><img src="/img/title29.gif" width="70" height="20" /></td>
                      <td width="80" align="center"><img src="/img/title30.gif" width="70" height="20" /></td>
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


<?=$TXT?>


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
            </table>
			
			</td>
        </tr>
      </table>
    </td>
  </tr>
</table>



<form id="gift_frm" name="gift_frm" method="post">
<input type="hidden" name="p_e_idx" value="" />
<input type="hidden" name="code" value="" />
<input type="hidden" name="len" value="" />
</form>

<? include "../include/_foot.php"; ?>