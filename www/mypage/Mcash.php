<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/Mcash.php
 * date   : 2009.02.06
 * desc   : ���������� ĳ�ð���
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];

// �ڵ�/ĳ�� ���� ���Ѵ�.
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

$page = trim($_REQUEST['page']);
$passnum = my64decode(trim($_REQUEST['passnum']));
$in_sum = my64decode(trim($_REQUEST['in_sum']));
$out_sum = my64decode(trim($_REQUEST['out_sum']));

if ( $page == "" ) $page = 1;

// �Ǹ����� ĳ����ȭ���� �˱����� GET���� �ѱ�� ����
// $in_sum �� $out_sum �� ������ ���̴�.
// $passnum�� 1������������ �����̰� �������� ������/������ �������� ����ȴ�.
if ( !$passnum && !$in_sum && !$out_sum ) {
	// ���� cash �� ������ ���Ѵ�.
	$sql = "select cash_io,sum(cash) as tot from tblCash where mem_id='$mem_id' group by cash_io ";
	$res = $mainconn->query($sql);
	$in_sum = $out_sum = 0;
	while ($row = $mainconn->fetch($res)) {
		$io = $row['cash_io'];
		$tot = $row['tot'];
		if ( $io == "I" ) {
			$in_sum = $tot;
		} else if ( $io == "O" ) {
			$out_sum = $tot;
		}
	}
	$passnum = $in_sum - $out_sum;
}



$cond = " and mem_id = '$mem_id' ";
$sql = "select count(*) from tblCash where 1 $cond ";
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
$orderby = " order by cash_idx desc ";

$sql = "select cc_cid, cash_io, cash, cash_reg_dt from tblCash where 1 $cond $orderby limit $first, $PAGE_SIZE ";
//echo $sql;
$res = $mainconn->query($sql);

$LIST = "";
$sum = $income = $outcome = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cc_cid		= trim($row['cc_cid']);
	$cash_io	= trim($row['cash_io']);
	$cash		= trim($row['cash']);
	$cash_reg_dt	= trim($row['cash_reg_dt']);

	if ( $cash_io == "I" ) {
		$income += $cash;
		$prt_income = $cash;
		$prt_outcome = 0;
	} else {
		$outcome += $cash;
		$prt_income = 0;
		$prt_outcome = $cash;
	}

	$sum += $income - $outcome;

	$LIST .= "
	<tr>
	  <td height='28' align='center'>$cash_reg_dt</td>
	  <td width='103' align='center' class='evfont'> <font color='FF5B5C'>".number_format($prt_income)."</font> </td>
	  <td width='102' align='center' class='evfont'> <font color='CC3300'>".number_format($prt_outcome)."</font> </td>
	  <td width='103' align='center'>".$CASHCODE[$cc_cid][0]."</td>
	  <td width='100' align='center'>".number_format($passnum)."</td>
	</tr>
	<tr>
	  <td height='1' colspan='5' bgcolor='E9E9E9'></td>
	</tr>
	";

	if ( $cash_io == "I" ) {
		$passnum = $passnum - $cash;
	} else {
		$passnum = $passnum + $cash;
	}
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

<script language="javascript">
function go_Charge() {
	var f = document.cash_frm;

	money = method = 0;

	for ( i=0; i<f.paymethod.length; ++i ) {
		if ( f.paymethod[i].checked == true ) {
			method++;
			break;
		}
	}

	for ( j=0; j<f.paymoney.length; ++j ) {
		if ( f.paymoney[j].checked == true ) {
			money++;
			break;
		}
	}

	if ( money < 1 ) {
		alert("�����ݾ��� �����ϼ���.");
		return;
	}

	if ( method < 1 ) {
		alert("��������� �����ϼ���.");
		return;
	}

	window.open("", "cash_payment_target", "width=50 height=0");
	f.target = "cash_payment_target";
	f.action = "/mypage/pay_charge_proc.php";
	f.submit();
}

function chg_paymethod(val) {
	document.getElementById('payment_info_area').style.display = "none";
	if ( val == "paper" ) {
		document.getElementById('payment_info_area').innerHTML = "<br>�Ա����� : <font color='red'><?=$BANKINFO[0]?></font><br>������ : <font color='red'><?=$BANKINFO[1]?></font><br>���¹�ȣ : <font color='red'><?=$BANKINFO[2]?></font>";
	}
	document.getElementById('payment_info_area').style.display = "block";
}
</script>

<table border="0" cellspacing="0" cellpadding="0">
<form id="cash_frm" name="cash_frm" method="post">
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
        <td background="/img/bar03.gif"><b><font color="FFFC11">ĳ������ :</font></b> <font color="#FFFFFF">ĳ�� ��� ���� Ȯ�� �� ������ �� �� �ֽ��ϴ�.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="1" bgcolor="FF5B5C">
        <tr>
          <td width="33%" height="28" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">��������ĳ�� :<b> <?=number_format($in_sum)?> ĳ�� </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">�������ĳ�� : <b> <?=number_format($out_sum)?> ĳ�� </b></font></td>
          <td width="33%" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><font color="CC0000">����ĳ���ܾ� : <b> <?=number_format($in_sum-$out_sum)?> ĳ�� </b></font></td>
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
                      <td align="center"><img src="/img/title31.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title32.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title33.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title34.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title35.gif" width="70" height="20" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="FF5B5C"></td>
              </tr>
            </table>
            
            <table width="645" border="0" cellspacing="0" cellpadding="0">
                
				<?=$LIST?>

                <tr>
                  <td height="6" colspan="5" bgcolor="FF5B5C"></td>
                </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
				  <? 
					$qry_str .= "&passnum=".my64encode("$passnum");
					$qry_str .= "&in_sum=".my64encode("$in_sum");
					$qry_str .= "&out_sum=".my64encode("$out_sum");
					echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str);
					?>
				  </td>
                </tr>
            </table>
            <table width="100" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
              <tr>
                <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="32" valign="top"><img src="/img/icon_oh.gif" width="27" height="16"  align="absmiddle" /></td>
                          <td> ĳ������ : ������ ĳ���� ��������� �����Ͻ� �� �����ϱ⸦ Ŭ�����ּ���.</td>
                        </tr>
                        <tr>
                          <td colspan="2" valign="top">&nbsp;</td>
                          </tr>
                      </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="2" colspan="4" bgcolor="E0295A"></td>
                                </tr>
                                <tr>
                                  <td width="50" height="26" align="center" class="intitle">����</td>
                                  <td width="110" align="center" class="intitle">�ݾ�</td>
                                  <td width="100" align="center" class="intitle">����ĳ��</td>
                                  <td align="center" class="intitle">&nbsp;&nbsp;���</td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="4" bgcolor="E0295A"></td>
                                </tr>
                              </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

								<?
								$option_list = "";
								$line_cnt = 1;
								foreach ( $CASHMONEY as $k => $v ) {
									$bg = ( $line_cnt % 2 ) ? "#F9F9F9" : "#FFFFFF";
									$line_cnt++;
									$option_list .= "
									  <tr>
										<td width='50' height='24' align='center' bgcolor='$bg'>
										<input name='paymoney' type='radio' value='$k' /></td>
										<td width='80' align='right' bgcolor='$bg' style='padding-right:5'><font color='#333333'>".number_format($CASHMONEY[$k][0])."��</font></td>
										<td width='100' align='right' bgcolor='$bg'  style='padding-right:5'>".number_format($CASHMONEY[$k][1])."ĳ��</td>
										<td align='right' style='padding-right:12' bgcolor='$bg'>+ ���ʽ� ".number_format($CASHMONEY[$k][2])."ĳ��</td>
									  </tr>
									  <tr>
										<td height='1' colspan='4' bgcolor='#E0E0E0'></td>
									  </tr>
									";
								}
								echo $option_list;
								?>
								
                                </table>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="2"></td>
                                  </tr>
                              </table>
							  <?
							  // paymethod
							  // P : ������, C : ī��
							  ?>
                              <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="DD2457">
                                  <tr>
                                    <td width="152" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><b><font color="CC0000">����������� </font></b></td>
                                    <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5">
									<input name="paymethod" id="paymethod" type="radio" value="paper" onClick="chg_paymethod(this.value);" checked /> ������ �Ա�
									<input name="paymethod" id="paymethod" type="radio" value="card" onClick="chg_paymethod(this.value);" disabled /> �ſ�ī��
									</td>
                                  </tr>
                              </table>

							  <div id="payment_info_area" style="display:none;">
							  </div>
							  
							  </td>
                            <td width="20">&nbsp;</td>
                            <td width="200" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                                <tr>
                                  <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_aa.gif"  align="absmiddle" />1. �̹� �����Ͻ� ��Ŷ�� ȯ�� �� ��� �Ͻ� �� �����ϴ�.
								  
								  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>

								  <img src="/img/icon_aa.gif"  align="absmiddle" />2. �����ݾ׿��� VAT(�ΰ���) 10%�� ������ û���˴ϴ�. </td>
                                </tr>
                            </table>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="6"></td>
                                </tr>
                                <tr>
                                  <td><a href="#" onClick="go_Charge();"><img src="/img/btn_charge.gif" border="0" /></a></td>
                                </tr>
                              </table></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</form>
</table>

<script>
// �������Ա� �⺻����
chg_paymethod("paper");
</script>

<? include "../include/_foot.php"; ?>