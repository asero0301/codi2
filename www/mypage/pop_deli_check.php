<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/pop_deli_check.php
 * date   : 2009.02.06
 * desc   : 마이페이지 경품을 잘받았는지 체크하는 팝업
 *			이 페이지를 열고 코멘트달고 수령확인을 클릭하면 C,D -> E 로 바뀐다.(완료)
 *
 * ============ 중요 : gt_status 값의 변화추이 ==========
 *
 * A (확인)		: 처음 경품에 당첨되었을때의 값
 * B (발송대기) : 샵회원이 확인버턴을 누르고 팝업이 뜬상태
 * C (발송완료) : 샵회원이 물건을 발송하고 누른다.
 * D (수령확인중) : 한사람이라도 받았을때(전부 다 받지는 않은 상태) - gt_ok == "Y"
 * E (완료)		: 모두 받으면, 또는 발송완료부터 7일이 지나면
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// 인증여부 체크
pop_auth_chk();

// 리퍼러 체크
pop_referer_chk();

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$gt_idx = $_POST['gt_idx'];

if ( !$gt_idx ) {
	echo "<script>alert('잘못된 접속입니다.'); self.close();</script>";
	exit;
}


// 해당 상품의 정보를 구한다.
$sql = "
select A.p_title, C.p_u_reg_dt, B.end_dt, A.p_gift, D.shop_name
from tblProduct A, tblProductEach B, tblProductUpDown C, tblShop D, tblGiftTracking E
where 1 
and A.p_idx = B.p_idx
and B.p_e_idx = C.p_e_idx
and A.shop_idx = D.shop_idx
and B.p_e_idx = E.p_e_idx
and E.gt_idx = $gt_idx
and C.mem_id = '$mem_id'
";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$p_title = strip_str(trim($row['p_title']));
$p_gift = strip_str(trim($row['p_gift']));
$shop_name = trim($row['shop_name']);
$p_u_reg_dt = trim($row['p_u_reg_dt']);
$end_dt = trim($row['end_dt']);



$mainconn->close();
?>

<SCRIPT LANGUAGE="JavaScript" SRC="/js/ajax.js"></SCRIPT>
<script language="javascript">
function go_deli_submit() {
	var f = document.deli_frm;
	f.target = "_self";
	f.action = "/mypage/pop_deli_ok.php";
	f.submit();
}
</script>

<link href="/css/style.css" rel="stylesheet" type="text/css">
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form id="deli_frm" name="deli_frm" method="post">
<input type="hidden" id="gt_idx" name="gt_idx" value="<?=$gt_idx?>" />

  <tr>
    <td height="53" ><img src="/img/pop_title01.gif" width="35" height="53" /></td>
    <td height="53" background="/img/pop_title03.gif" align="center" class="intitle"  style="padding-bottom:10"><font color="#FFFFFF"><b>경품수령 확인</b></font></td>
    <td height="53" ><img src="/img/pop_title02.gif" width="35" height="53" /></td>
  </tr>
  <tr>
    <td align="center" background="/img/pop_title07.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
      <tr>
        <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_oh.gif" width="27" height="16"  align="absmiddle" /> <font color="#333333">이상없이 경품을 받으셨나요? <font color="FF5B5C"><u>그렇다면 수령확인을 해주세요.</u></font>
		<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
		
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;경품을 제공한 샵회원에게 보내는 한마디는 큰 기쁨이 됩니다. </font></td>
      </tr>
    </table>
      <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="14" valign="top"><img src="/img/icon_list.gif" align="absmiddle" /></td>
        <td><font color="DD2457"><?=$p_title?></font></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:12 12 12 12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵&nbsp;&nbsp;이&nbsp;&nbsp;름 </td>
                      <td><b><font color="#333333"><?=$shop_name?></font></b></td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle" style="LETTER-SPACING: 1px" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 응&nbsp;&nbsp;모&nbsp;&nbsp;일 </td>
                      <td><?=$p_u_reg_dt?> </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 평가마감일 </td>
                      <td><?=$end_dt?> </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 당 첨 경 품 </td>
                      <td><?=$p_gift?> </td>
                    </tr>
                  </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="1" background="/img/dot00.gif"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 수령확인 한마디 <span class="evgray">(경품을 발송한 샵회원에게 한마디 해주세요.)</span></td>
                        <td align="right" class="evgray" style="LETTER-SPACING: 1px"><font color="FF0078"><span id='textlimit'>0</span>/500</font></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="2" ><textarea id="gt_comment" name="gt_comment" class="memobox" onKeyUp="updateChar(500,this.form.gt_comment,'textlimit');" onFocus="check_msg(this.form.gt_comment);" onBlur="check_msg(this.form.gt_comment);" style="width:100%; height:80;"></textarea></td>
                      </tr>
                    </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td width="32">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><a href="#" onClick="go_deli_submit();"><img src="/img/btn_deli_ok.gif" width="70" height="20" border="0" /></a>&nbsp;<a href="#" onClick="self.close()"><img src="/img/btn_close.gif" width="70" height="20" border="0" /></a></td>
        </tr>
      </table></td>
    <td align="center" background="/img/pop_title08.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"><img src="/img/pop_title04.gif" width="35" height="16" /></td>
    <td background="/img/pop_title06.gif">&nbsp;</td>
    <td width="35"><img src="/img/pop_title05.gif" width="35" height="16" /></td>
  </tr>
</form>
</table>
