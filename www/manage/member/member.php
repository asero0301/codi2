<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/member/member.php
 * date   : 2008.08.08
 * desc   : Admin member view/insert/update
 *******************************************************/
session_start();
require_once "/coditop/inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();


$mainconn->open();

$mem_id = trim($_REQUEST['mem_id']);

$cond = " where 1 ";

if ( $mem_kind != "" ) {
	$cond .= " and mem_kind = '$mem_kind' ";
}


$qry_str = "&mem_kind=$mem_kind&key=$key&kwd=$kwd";

$sql = "select *,(select log_reg_dt from tblLoginLog where tblMember.mem_id=log_id order by log_idx desc limit 1) as last_log from tblMember where mem_id = '$mem_id'";

$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

$t_mem_id = $row['mem_id'];
$t_mem_pwd = $row['mem_pwd'];
$t_mem_name = $row['mem_name'];
$t_mem_kind = $row['mem_kind'];
$t_mem_jumin = $row['mem_jumin'];
$t_mem_email = $row['mem_email'];
$t_mem_mobile = $row['mem_mobile'];

$t_zipcode = $row['zipcode'];
$t_mem_addr1 = $row['mem_addr1'];
$t_mem_addr2 = $row['mem_addr2'];
$t_mem_recom_id = $row['mem_recom_id'];
$t_mem_mailing = $row['mem_mailing'];

$t_mem_grade = $row['mem_grade'];
$t_mem_cash = $row['mem_cash'];
$t_mem_score = $row['mem_score'];
$t_last_log = $row['last_log'];
$t_mem_reg_dt = $row['mem_reg_dt'];


$t_mem_mobile = phone_disp($t_mem_mobile);

if ( $t_last_log == "" || $t_last_log == NULL ) {
	$t_last_log = "접속기록 없음";
}

switch ( $t_mem_kind ) {
	case "U" :
		$t_mem_kind_str = "일반회원";
		break;
	case "S" :
		$t_mem_kind_str = "샵회원";
		break;
	case "A" :
		$t_mem_kind_str = "관리자";
		break;
	default :
		break;
}

switch ( $t_mem_mailing ) {
	case "Y" :
		$t_mem_mailing_str = "수신";
		break;
	case "N" :
		$t_mem_mailing_str = "수신거부";
		break;
	default :
		break;
}

require_once "../_top.php";
?> 


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode">
 

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 회원정보</font></b>  </td>
  </tr>
</table>


<table width="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE" class="small">
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 아이디&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"> <font color="#666666"><strong> 
   <input type="text" id="mem_id" name="mem_id" class="goodcss" value="<?=$t_mem_id?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 비밀번호&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"> <font color="#666666"><strong> 
   <input type="text" id="mem_pwd" name="mem_pwd" class="goodcss" value="<?=$t_mem_pwd?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b>성명&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_name" name="mem_name" class="goodcss" value="<?=$t_mem_name?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 회원구분&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <select id="mem_kind" name="mem_kind" class="goodcss">
	<option value="U" <? if ( $t_mem_kind == "U" ) echo " selected"; ?>>일반회원</option>
	<option value="S" <? if ( $t_mem_kind == "S" ) echo " selected"; ?>>샵회원</option>
	<option value="A" <? if ( $t_mem_kind == "A" ) echo " selected"; ?>>관리자</option>
   </select>
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 주민등록번호&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_jumin" name="mem_jumin" class="goodcss" value="<?=$t_mem_jumin?>" size="6" maxlength="6">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 전자메일&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_email" name="mem_email" class="goodcss" value="<?=$t_mem_email?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 핸드폰&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_mobile" name="mem_mobile" class="goodcss" value="<?=$t_mem_mobile?>">
   </strong></font></td>
 </tr>

 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 우편번호&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="zipcode" name="zipcode" class="goodcss" value="<?=$t_zipcode?>">
   </strong></font></td>
 </tr>

 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 주소1&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_addr1" name="mem_addr1" class="goodcss" value="<?=$t_mem_addr1?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 주소2&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_addr2" name="mem_addr2" class="goodcss" value="<?=$t_mem_addr2?>">
   </strong></font></td>
 </tr>

 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 메일링&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <select id="mem_mailing" name="mem_mailing" class="goodcss">
	<option value="Y" <? if ( $t_mem_mailing == "Y" ) echo " selected"; ?>>수신</option>
	<option value="N" <? if ( $t_mem_mailing == "N" ) echo " selected"; ?>>수신거부</option>
   </select>
   </strong></font></td>
 </tr>

 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 상태&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <select id="mem_status" name="mem_status" class="goodcss">
	<option value="Y" <? if ( $t_mem_status == "Y" ) echo " selected"; ?>>활동</option>
	<option value="N" <? if ( $t_mem_status == "N" ) echo " selected"; ?>>탈퇴</option>
	<option value="D" <? if ( $t_mem_status == "D" ) echo " selected"; ?>>블록</option>
   </select>
   </strong></font></td>
 </tr>
 
 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666">&nbsp;&nbsp;<b> 점수</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_score" name="mem_score" class="goodcss" value="<?=$t_mem_score?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666">&nbsp;&nbsp;<b> 캐쉬</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_cash" name="mem_cash" class="goodcss" value="<?=$t_mem_cash?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 가입일&nbsp; </b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="mem_reg_dt" name="mem_reg_dt" class="goodcss" value="<?=$t_mem_reg_dt?>">
   </strong></font></td>
 </tr>
</table>

<? if ( $t_mem_kind == "S" ) { ?>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
	<td width="50%" height="23"><b><font color="#333333">■ 샵 회원정보</font></b>  </td>
  </tr>
</table>

<table width="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE" class="small">
 
<?

	$cond = " where 1 ";
	$cond .= " and mem_id = '$t_mem_id' ";
	$orderby = " order by shop_idx desc ";

	$sql = "select * from tblShop $cond $orderby";

	$res = $mainconn->query($sql);

	while ( $row = $mainconn->fetch($res) ) {

		$t_shop_idx = $row['shop_idx'];
		$t_shop_name = $row['shop_name'];
		$t_shop_kind = $row['shop_kind'];
		$t_shop_url = $row['shop_url'];
		$t_shop_person = $row['shop_person'];
		$t_shop_mobile = $row['shop_mobile'];
		$t_shop_phone = $row['shop_phone'];
		$t_shop_fax = $row['shop_fax'];
		$t_shop_email = $row['shop_email'];
		$t_shop_logo = $row['shop_logo'];
		$t_shop_medal = $row['shop_medal'];
		$t_shop_status = $row['shop_status'];
		$t_shop_reg_dt = $row['shop_reg_dt'];

		$t_shop_num = $row['shop_num'];
		$t_shop_tax = $row['shop_tax'];
		$t_shop_zipcode = $row['zipcode'];
		$t_shop_addr1 = $row['shop_addr1'];
		$t_shop_addr2 = $row['shop_addr2'];
		$t_shop_etc1 = $row['shop_etc1'];
		$t_shop_etc2 = $row['shop_etc2'];
		
?>


 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666">&nbsp;&nbsp;<b> 샵이름</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_name_<?=$t_shop_idx?>" name="shop_name_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_name?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666"><b>샵종류</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_kind_<?=$t_shop_idx?>" name="shop_kind_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_kind?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵url</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_url_<?=$t_shop_idx?>" name="shop_url_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_url?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 대표자이름</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_person_<?=$t_shop_idx?>" name="shop_person_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_person?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 휴대전화</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_mobile_<?=$t_shop_idx?>" name="shop_mobile_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_mobile?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 일반전화</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_phone_<?=$t_shop_idx?>" name="shop_phone_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_phone?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 팩스</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_fax_<?=$t_shop_idx?>" name="shop_fax_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_fax?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 전자메일</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_email_<?=$t_shop_idx?>" name="shop_email_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_email?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵로고</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_logo_<?=$t_shop_idx?>" name="shop_logo_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_logo?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 인증샵여부</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_medal_<?=$t_shop_idx?>" name="shop_medal_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_medal?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 상태</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_status_<?=$t_shop_idx?>" name="shop_status_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_status?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 사업자번호</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_num_<?=$t_shop_idx?>" name="shop_num_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_num?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 세금계산서</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_tax_<?=$t_shop_idx?>" name="shop_tax_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_tax?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 우편번호</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_zipcode_<?=$t_shop_idx?>" name="shop_zipcode_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_zipcode?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵주소1</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_addr1_<?=$t_shop_idx?>" name="shop_addr1_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_addr1?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 샵주소2</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_addr2_<?=$t_shop_idx?>" name="shop_addr2_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_addr2?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 업태</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_etc1_<?=$t_shop_idx?>" name="shop_etc1_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_etc1?>">
   </strong></font></td>
 </tr>
 <tr> 
  <td width="100" align="right" bgcolor="#EFEFEF"><font color="#666666"><b> 종목</b></font></td>
  <td bgcolor="#FFFFFF"><font color="#666666"><strong> 
   <input type="text" id="shop_etc2_<?=$t_shop_idx?>" name="shop_etc2_<?=$t_shop_idx?>" class="goodcss" value="<?=$t_shop_etc2?>">
   </strong></font></td>
 </tr>

<? 
	} 
	echo "</table>";
} 



$mainconn->close();

?>

<table>
	<tr>
		<td align="center"><input type="button" value="수정하기" onClick="goMemberEdit();">
			<input type="button" value="뒤로가기" onClick="history.go(-1);">
		</td>
	</tr>
</table>





</form>


<script language="javascript">
function goMemberEdit() {
	var f = document.frm;
	f.mode.value = "E";
	f.action = "member_ok.php";
	f.encoding = "x-www-form-urlencoded";
	f.submit();
}
</script>


<?php 
require_once "../_bottom.php";

?> 