<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/Mshop.php
 * date   : 2008.10.08
 * desc   : 샵관리
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

?>

<? include "../include/_head.php"; ?>

<script language="javascript">
g_layer = 0;
shop_max_cnt = parseInt('<?=$SHOP_MAX_COUNT?>');
function add_shop() {
	var f = document.mem;
	// 이전 입력한 샵의 필수항목이 입력되지 않으면 추가할 수 없다.
	for ( var i=0; i<shop_max_cnt; i++ ) {
		shop_name = eval("f.shop_name_"+i);
		shop_kind = eval("f.shop_kind_"+i);
		shop_url = eval("f.shop_url_"+i);
		shop_num = eval("f.shop_num_"+i);
		shop_tax = eval("f.shop_tax_"+i);
		shop_person = eval("f.shop_person_"+i);
		shop_mail_id = eval("f.shop_mail_id_"+i);
		shop_mail_host = eval("f.shop_mail_host_"+i);
		smobile_1 = eval("f.smobile_1_"+i);
		smobile_2 = eval("f.smobile_2_"+i);
		smobile_3 = eval("f.smobile_3_"+i);
		sphone_1 = eval("f.sphone_1_"+i);
		sphone_2 = eval("f.sphone_2_"+i);
		sphone_3 = eval("f.sphone_3_"+i);
		shop_zipcode = eval("f.shop_zipcode_"+i);
		shop_addr1 = eval("f.shop_addr1_"+i);
		shop_addr2 = eval("f.shop_addr2_"+i);
		
		var chk_obj = document.getElementById("shop_info_area_"+i);
		if ( chk_obj.style.display == "block" ) {
			if ( trim(shop_name.value) == "" ) {
				alert("샵 이름을 입력하세요.");
				shop_name.focus();
				return;
			}
			if ( trim(shop_url.value) == "" ) {
				alert("샵 URL을 입력하세요.");
				shop_url.focus();
				return;
			}
			if ( trim(shop_num.value) == "" ) {
				alert("사업자 등록번호를 입력하세요.");
				shop_num.focus();
				return;
			}
			if ( trim(shop_person.value) == "" ) {
				alert("샵 책임자를 입력하세요.");
				shop_person.focus();
				return;
			}
			if ( trim(shop_mail_id.value) == "" ) {
				alert("메일주소를 입력하세요.");
				shop_mail_id.focus();
				return;
			}
			if ( trim(shop_mail_host.value) == "" ) {
				alert("메일주소를 입력하세요.");
				shop_mail_host.focus();
				return;
			}
			if ( trim(smobile_2.value) == "" ) {
				alert("휴대전화 번호를 입력하세요.");
				smobile_2.focus();
				return;
			}
			if ( trim(smobile_3.value) == "" ) {
				alert("휴대전화 번호를 입력하세요.");
				smobile_3.focus();
				return;
			}
			if ( trim(sphone_1.value) == "" ) {
				alert("전화번호를 입력하세요.");
				sphone_1.focus();
				return;
			}
			if ( trim(sphone_2.value) == "" ) {
				alert("전화번호를 입력하세요.");
				sphone_2.focus();
				return;
			}
			if ( trim(sphone_3.value) == "" ) {
				alert("전화번호를 입력하세요.");
				sphone_3.focus();
				return;
			}
			if ( trim(shop_zipcode.value) == "" ) {
				alert("우편번호를 입력하세요.");
				shop_zipcode.focus();
				return;
			}
			if ( trim(shop_addr1.value) == "" ) {
				alert("주소를 입력하세요.");
				shop_addr1.focus();
				return;
			}
			if ( trim(shop_addr2.value) == "" ) {
				alert("주소를 입력하세요.");
				shop_addr2.focus();
				return;
			}
		}
	}

	if ( g_layer == shop_max_cnt ) {
		alert("등록가능한 샵은 최대 "+shop_max_cnt+"개 입니다.");
		return;
	}
	var obj = document.getElementById("shop_info_area_"+g_layer);
	obj.style.display = "block";
	g_layer++;
}
function hide_shop(idx) {
	if ( idx == (g_layer-1) ) g_layer--;
	var obj = document.getElementById("shop_info_area_"+idx);
	obj.style.display = "none";

	var f = document.mem;
	eval("f.shop_name_"+idx).value = "";
	eval("f.shop_kind_"+idx).value = "D";
	eval("f.shop_url_"+idx).value = "";
	eval("f.shop_num_"+idx).value = "";
	eval("f.shop_tax_"+idx).value = "N";
	eval("f.shop_person_"+idx).value = "";
	eval("f.shop_mail_id_"+idx).value = "";
	eval("f.shop_mail_host_"+idx).value = "";
	eval("f.shop_txt_host_"+idx).value = "";
	eval("f.smobile_1_"+idx).value = "010";
	eval("f.smobile_2_"+idx).value = "";
	eval("f.smobile_3_"+idx).value = "";
	eval("f.sphone_1_"+idx).value = "";
	eval("f.sphone_2_"+idx).value = "";
	eval("f.sphone_3_"+idx).value = "";
	eval("f.sfax_1_"+idx).value = "";
	eval("f.sfax_2_"+idx).value = "";
	eval("f.sfax_3_"+idx).value = "";
	eval("f.shop_etc1_"+idx).value = "";
	eval("f.shop_etc2_"+idx).value = "";
	eval("f.shop_zipcode_"+idx).value = "";
	eval("f.shop_addr1_"+idx).value = "";
	eval("f.shop_addr2_"+idx).value = "";
}
function goMainShop(s_idx) {
	var f = document.mem;

	f.mode.value = "K";
	f.shop_idx.value = s_idx;
	
	if ( confirm("메인샵으로 수정할까요?") ) {
		var pop = window.open("", "mobile_auth_pop", "toolbar=no,location=no,status=no,menubar=no,width=300,height=100,top=300,left=400");
		f.pmode.value = "mobile";
		f.action = "/member/pop_mobile_auth.php";
		f.target = "mobile_auth_pop";
		f.submit();
		pop.focus();
	}
}
function del_shop(s_idx) {
	var f = document.mem;

	f.mode.value = "D";
	f.shop_idx.value = s_idx;
	
	if ( confirm("샵을 삭제할까요?") ) {
		var pop = window.open("", "mobile_auth_pop", "toolbar=no,location=no,status=no,menubar=no,width=300,height=100,top=300,left=400");
		f.pmode.value = "mobile";
		f.action = "/member/pop_mobile_auth.php";
		f.target = "mobile_auth_pop";
		f.submit();
		pop.focus();
	}
}
function pick_shop(s_idx) {
	var f = document.mem;
	real_var = eval("js_shop_arr_"+s_idx);

	f.shop_idx.value = real_var['shop_idx'];
	f.shop_medal.value = real_var['shop_medal'];
	f.old_shop_logo.value = real_var['shop_logo'];
	f.shop_name.value = real_var['shop_name'];
	if ( real_var['shop_kind'] == "I" ) {
		f.shop_kind.selectedIndex = 0;
	} else {
		f.shop_kind.selectedIndex = 1;
	}
	f.shop_url.value = real_var['shop_url'];
	f.shop_num.value = real_var['shop_num'];
	f.shop_tax.value = real_var['shop_tax'];
	f.shop_person.value = real_var['shop_person'];
	f.shop_mail_id.value = real_var['shop_mail_id'];
	f.shop_mail_host.value = real_var['shop_mail_host'];
	f.shop_zipcode.value = real_var['zipcode'];
	f.shop_addr1.value = real_var['shop_addr1'];
	f.shop_addr2.value = real_var['shop_addr2'];
	f.shop_etc1.value = real_var['shop_etc1'];
	f.shop_etc2.value = real_var['shop_etc2'];

	for (i=0; i<f.smobile_1.length; i++ ) {
		if ( f.smobile_1.options[i].value == real_var['smobile_1'] ) {
			f.smobile_1.options[i].selected = true;
		}
		break;
	}

	f.smobile_2.value = real_var['smobile_2'];
	f.smobile_3.value = real_var['smobile_3'];
	f.sphone_1.value = real_var['sphone_1'];
	f.sphone_2.value = real_var['sphone_2'];
	f.sphone_3.value = real_var['sphone_3'];
	f.sfax_1.value = real_var['sfax_1'];
	f.sfax_2.value = real_var['sfax_2'];
	f.sfax_3.value = real_var['sfax_3'];

	document.getElementById('shop_logo_img').src = "<?=$UP_URL.'/thumb/'?>"+real_var['shop_logo'];
	shop_logo_area.style.display = 'block';
}
function goSubmit() {
	var f = document.mem;
	if ( f.mode.value == "I" ) {
		str = "샵을 추가할까요?";
	} else if ( f.mode.value == "D" ) {
		str = "샵을 삭제할까요?";
	} else {
		str = "샵정보를 수정할까요?";
		f.mode.value = "E";
	}
	
	if ( confirm(str) ) {
		// 체크
		for ( var i=0; i<shop_max_cnt; i++ ) {
			shop_name = eval("f.shop_name_"+i);
			shop_kind = eval("f.shop_kind_"+i);
			shop_url = eval("f.shop_url_"+i);
			shop_num = eval("f.shop_num_"+i);
			shop_tax = eval("f.shop_tax_"+i);
			shop_person = eval("f.shop_person_"+i);
			shop_mail_id = eval("f.shop_mail_id_"+i);
			shop_mail_host = eval("f.shop_mail_host_"+i);
			smobile_1 = eval("f.smobile_1_"+i);
			smobile_2 = eval("f.smobile_2_"+i);
			smobile_3 = eval("f.smobile_3_"+i);
			sphone_1 = eval("f.sphone_1_"+i);
			sphone_2 = eval("f.sphone_2_"+i);
			sphone_3 = eval("f.sphone_3_"+i);
			shop_zipcode = eval("f.shop_zipcode_"+i);
			shop_addr1 = eval("f.shop_addr1_"+i);
			shop_addr2 = eval("f.shop_addr2_"+i);
			
			var chk_obj = document.getElementById("shop_info_area_"+i);
			if ( chk_obj.style.display == "block" ) {
				if ( trim(shop_name.value) == "" ) {
					alert("샵 이름을 입력하세요.");
					shop_name.focus();
					return;
				}
				if ( trim(shop_url.value) == "" ) {
					alert("샵 URL을 입력하세요.");
					shop_url.focus();
					return;
				}
				if ( trim(shop_num.value) == "" ) {
					alert("사업자 등록번호를 입력하세요.");
					shop_num.focus();
					return;
				}
				if ( !isNumber(shop_num) ) {
					alert("사업자등록번호는 숫자여야 합니다.");
					shop_num.value = "";
					shop_num.focus();
					return;
				}
				if ( trim(shop_person.value) == "" ) {
					alert("샵 책임자를 입력하세요.");
					shop_person.focus();
					return;
				}
				if ( trim(shop_mail_id.value) == "" ) {
					alert("메일주소를 입력하세요.");
					shop_mail_id.focus();
					return;
				}
				if ( trim(shop_mail_host.value) == "" ) {
					alert("메일주소를 입력하세요.");
					shop_mail_host.focus();
					return;
				}
				if ( !isEmail(trim(shop_mail_id.value)+"@"+trim(shop_mail_host.value)) ) {
					alert("메일주소가 입력되지 않았거나 올바른 형식의 메일주소가 아닙니다");
					shop_mail_id.value = "";
					shop_mail_id.focus();
					return;
				}
				if ( trim(smobile_2.value) == "" ) {
					alert("휴대전화 번호를 입력하세요.");
					smobile_2.focus();
					return;
				}
				if ( trim(smobile_3.value) == "" ) {
					alert("휴대전화 번호를 입력하세요.");
					smobile_3.focus();
					return;
				}
				if ( !isNumber(smobile_2) ) {
					alert("휴대전화번호는 숫자여야 합니다.");
					smobile_2.value = "";
					smobile_2.focus();
					return;
				}
				if ( !isNumber(smobile_3) ) {
					alert("휴대전화번호는 숫자여야 합니다.");
					smobile_3.value = "";
					smobile_3.focus();
					return;
				}
				if ( trim(sphone_1.value) == "" ) {
					alert("전화번호를 입력하세요.");
					sphone_1.focus();
					return;
				}
				if ( trim(sphone_2.value) == "" ) {
					alert("전화번호를 입력하세요.");
					sphone_2.focus();
					return;
				}
				if ( trim(sphone_3.value) == "" ) {
					alert("전화번호를 입력하세요.");
					sphone_3.focus();
					return;
				}
				if ( !isNumber(sphone_1) ) {
					alert("전화번호는 숫자여야 합니다.");
					sphone_1.value = "";
					sphone_1.focus();
					return;
				}
				if ( !isNumber(sphone_2) ) {
					alert("전화번호는 숫자여야 합니다.");
					sphone_2.value = "";
					sphone_2.focus();
					return;
				}
				if ( !isNumber(sphone_3) ) {
					alert("전화번호는 숫자여야 합니다.");
					sphone_3.value = "";
					sphone_3.focus();
					return;
				}
				if ( trim(shop_zipcode.value) == "" ) {
					alert("우편번호를 입력하세요.");
					shop_zipcode.focus();
					return;
				}
				if ( trim(shop_addr1.value) == "" ) {
					alert("주소를 입력하세요.");
					shop_addr1.focus();
					return;
				}
				if ( trim(shop_addr2.value) == "" ) {
					alert("주소를 입력하세요.");
					shop_addr2.focus();
					return;
				}
			}
		}	// for

		var pop = window.open("", "mobile_auth_pop", "toolbar=no,location=no,status=no,menubar=no,width=300,height=100,top=300,left=400");
		f.pmode.value = "mobile";
		f.action = "/member/pop_mobile_auth.php";
		f.target = "mobile_auth_pop";
		f.submit();
		pop.focus();
	}
}

function shop_mail_host_chk(id) {
	var f = document.mem;
	var txt_obj = eval("document.mem.shop_txt_host_"+id);
	var mail_obj = eval("document.mem.shop_mail_host_"+id);

	if ( txt_obj.options[txt_obj.selectedIndex].value == "other" ) {
		mail_obj.value = "";
		mail_obj.focus();
	} else {
		mail_obj.value = txt_obj.options[txt_obj.selectedIndex].value;
	}
}
</script>



<table border="0" cellspacing="0" cellpadding="0">

<form id="mem" name="mem" method="post">


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
      
           </td>
    <td width="15"></td>
    <td valign="top">
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">샵관리 :</font></b> <font color="#FFFFFF">등록한 샵의 정보를 관리할 수 있습니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>


<?
$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$pno = $_SESSION['mem_mobile'];
$pno_arr = explode("-", $pno);
$pno_1 = $pno_arr[0];
$pno_2 = $pno_arr[1];
$pno_3 = $pno_arr[2];

$sql = "select * from tblShop where mem_id = '$mem_id' and shop_status = 'Y' order by shop_kind, shop_idx desc ";
$res = $mainconn->query($sql);

$cnt = 0;
$LIST = "";

for ( $cnt=0; $cnt<$SHOP_MAX_COUNT; $cnt++ ) {
	$row = $mainconn->fetch($res);

	$shop_idx = trim($row['shop_idx']);
	$shop_name = trim($row['shop_name']);
	$shop_url = trim($row['shop_url']);
	$shop_kind = trim($row['shop_kind']);
	$shop_person = trim($row['shop_person']);
	$shop_mobile = trim($row['shop_mobile']);
	$shop_phone = trim($row['shop_phone']);
	$shop_fax = trim($row['shop_fax']);
	$shop_email = trim($row['shop_email']);
	$shop_logo = trim($row['shop_logo']);
	$shop_medal = trim($row['shop_medal']);
	$shop_reg_dt = trim($row['shop_reg_dt']);
	$shop_num = trim($row['shop_num']);
	$shop_tax = trim($row['shop_tax']);
	$zipcode = trim($row['zipcode']);
	$shop_addr1 = trim($row['shop_addr1']);
	$shop_addr2 = trim($row['shop_addr2']);
	$shop_etc1 = trim($row['shop_etc1']);
	$shop_etc2 = trim($row['shop_etc2']);

	$t_mail_arr = explode("@", $shop_email);
	$t_mobile_arr = explode("-", $shop_mobile);
	$t_phone_arr = explode("-", $shop_phone);
	$t_fax_arr = explode("-", $shop_fax);

	if ( $shop_name && $shop_num && $zipcode ) {
		echo "<script>g_layer++;</script>";
		$display = "display:block;";

		// 하단 샵리스트
		if ( $shop_kind == "I" ) {
			$shop_kind_str = "<img src='/img/btn_main_shop.gif' width='67' height='18' border='0' />";
		} else {
			$shop_kind_str = "<img src='/img/btn_main_shop_select.gif' width='84' height='18' border='0' onClick=\"goMainShop('$shop_idx');\" style='cursor:hand;' />&nbsp;<img src='/img/btn_shop_delete.gif' width='67' height='18' border='0' onClick=\"del_shop('$shop_idx');\" style='cursor:hand;' />";
		}

		if ( $shop_medal == "Y" ) {
			$shop_medal_str = "<img src='/img_seri/icon_ks_mini.gif' border='0' valign='absmiddle' />";
		} else {
			$shop_medal_str = "";
		}

		$LIST .= "
		<tr>
		  <td height='28'  class='shopname' style='padding-left:12'>$shop_name $shop_medal_str</td>
		  <td width='172' style='padding-left:12'><a href='$shop_url' target='_blank'>$shop_url</a></td>
		  <td width='113' align='center' class='date'>$shop_reg_dt</td>
		  <td width='182' align='center'>$shop_kind_str</td>
		</tr>
		
		<tr>
		  <td height='1' colspan='4'  bgcolor='E9E9E9' ></td>
		</tr>
		";
	} else {
		$display = "display:none;";
	}




?>

<input type="hidden" id="shop_medal_<?=$cnt?>" name="shop_medal_<?=$cnt?>" value="<?=$shop_medal?>" />
<input type="hidden" id="shop_idx_<?=$cnt?>" name="shop_idx_<?=$cnt?>" value="<?=$shop_idx?>" />
<input type="hidden" id="old_shop_logo_<?=$cnt?>" name="old_shop_logo_<?=$cnt?>" value="<?=$shop_logo?>" />

<div id="shop_info_area_<?=$cnt?>" style="<?=$display?>">
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 이 름 <span class="num8">*</span></td>
                    <td class="infont"><input type="text" name="shop_name_<?=$cnt?>" id="shop_name_<?=$cnt?>" value="<?=$shop_name?>" class="logbox"  style="width:150" />
                      ＊ 사이트 이름 또는 미니샵 이름 </td>
                  </tr>
				  <tr>
					  <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 형태 <span class="num8">*</span></td>
					  <td>
					  <select name="shop_kind_<?=$cnt?>" id="shop_kind_<?=$cnt?>" class="logbox" style="width:150">
						<option value="I" <?if ($shop_kind=="I") echo " selected";?>>대표샵</option>
						<option value="D" <?if ($shop_kind!="I") echo " selected";?>>추가샵</option>
					  </select>
					  </td>
					</tr>
				  <tr>
					  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 URL <span class="num8">*</span></td>
					  <td><input name="shop_url_<?=$cnt?>" id="shop_url_<?=$cnt?>" type="text" class="logbox"  style="width:400" value="<?=$shop_url?>" /></td>
					</tr>
					<tr>
					  <td height="24" class="intitle"  >&nbsp;</td>
					  <td><span class="infont">＊오픈마켓 내의 미니샵인 경우 미니샵으로 이동할 수 있는 전체 주소를 입력하세요 </span></td>
					</tr>
				  <tr>
					  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 사업자등록번호 <span class="num8">*</span></td>
					  <td><input name="shop_num_<?=$cnt?>" id="shop_num_<?=$cnt?>" type="text" class="logbox"  style="width:150" value="<?=$shop_num?>" /><span class="infont">＊"-" 빼고 입력 </span></td>
					</tr>
					<tr>
					  <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 세금계산서 <span class="num8">*</span></td>
					  <td>
					  <select name="shop_tax_<?=$cnt?>" id="shop_tax_<?=$cnt?>" class="logbox" style="width:150">
						<option value="N" <?if ($shop_tax=="N") echo " selected";?>>미발급</option>
						<option value="Y" <?if ($shop_tax=="Y") echo " selected";?>>발급</option>
					  </select>
					  </td>
					</tr>
                  <tr>
					  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 책임자 <span class="num8">*</span> </td>
					  <td><input type="text" name="shop_person_<?=$cnt?>" id="shop_person_<?=$cnt?>" class="logbox" value="<?=$shop_person?>" style="width:150" />
						<span class="infont">＊샵 운영 책임자 이름 </span></td>
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
				  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 이 메 일 <span class="num8">*</span></td>
				  <td><input type="text" name="shop_mail_id_<?=$cnt?>" id="shop_mail_id_<?=$cnt?>" value="<?=$t_mail_arr[0]?>" class="logbox"  style="width:150" />
					＠
					<input type="text" name="shop_mail_host_<?=$cnt?>" id="shop_meil_host_<?=$cnt?>" value="<?=$t_mail_arr[1]?>" class="logbox"  style="width:150" />
					<select name="shop_txt_host_<?=$cnt?>" id="shop_txt_host_<?=$cnt?>" class="logbox"  style="width:150" onChange="shop_mail_host_chk('<?=$cnt?>');">
						<option value="">::: 선택하세요 :::</option>
						<?
						
						$fp = fopen("../member/txt/mail_host.inc", "r");
						while ( !feof($fp) ) {
							$line = trim(fgets($fp, 100));
							$mail_arr = explode(",", $line);
							if ( $t_mail_arr[1] == $mail_arr[1] ) {
								echo "<option value='".$mail_arr[1]."' selected>".$mail_arr[0]."</option>";
							} else {
								echo "<option value='".$mail_arr[1]."'>".$mail_arr[0]."</option>";
							}
						}
						fclose($fp);
						
						?>
						<option value="other">직접입력</option>
					</select></td>
				</tr>
					 <tr>
					  <td width="110" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 휴 대 폰 <span class="num8">*</span></td>
					  <td>
					  <select name="smobile_1_<?=$cnt?>" class="logbox"  style="width:50">
						<option value="010" <?if ($t_mobile_arr[0]=="010") echo " selected";?>>010</option>
						<option value="011" <?if ($t_mobile_arr[0]=="011") echo " selected";?>>011</option>
						<option value="016" <?if ($t_mobile_arr[0]=="016") echo " selected";?>>016</option>
						<option value="017" <?if ($t_mobile_arr[0]=="017") echo " selected";?>>017</option>
						<option value="018" <?if ($t_mobile_arr[0]=="018") echo " selected";?>>018</option>
						<option value="019" <?if ($t_mobile_arr[0]=="019") echo " selected";?>>019</option>
					  </select>
					  -
					  <input type="text" name="smobile_2_<?=$cnt?>" id="smobile_2_<?=$cnt?>" value="<?=$t_mobile_arr[1]?>" maxlength="4" class="logbox"  style="width:60" />
					  -
					<input type="text" name="smobile_3_<?=$cnt?>" id="smobile_3_<?=$cnt?>" value="<?=$t_mobile_arr[2]?>" maxlength="4" class="logbox"  style="width:60" />
					  </td>
					</tr>

					<tr>
					  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 전 화 <span class="num8">*</span></td>
					  <td><input type="text" name="sphone_1_<?=$cnt?>" id="sphone_1_<?=$cnt?>" value="<?=$t_phone_arr[0]?>" maxlength="4" class="logbox"  style="width:50" />
						-
						<input type="text" name="sphone_2_<?=$cnt?>" id="sphone_2_<?=$cnt?>" value="<?=$t_phone_arr[1]?>" maxlength="4" class="logbox"  style="width:60" />
						-
						<input type="text" name="sphone_3_<?=$cnt?>" id="sphone_3_<?=$cnt?>" value="<?=$t_phone_arr[2]?>" maxlength="4" class="logbox"  style="width:60" /></td>
					</tr>
					  <tr>
					  <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> 팩 스 </td>
					  <td><input type="text" name="sfax_1_<?=$cnt?>" id="sfax_1_<?=$cnt?>" value="<?=$t_fax_arr[0]?>" maxlength="4" class="logbox"  style="width:50" />
-
<input type="text" name="sfax_2_<?=$cnt?>" id="sfax_2_<?=$cnt?>" value="<?=$t_fax_arr[1]?>" maxlength="4" class="logbox"  style="width:60" />
-
<input type="text" name="sfax_3_<?=$cnt?>" id="sfax_3_<?=$cnt?>" value="<?=$t_fax_arr[2]?>" maxlength="4" class="logbox"  style="width:60" /></td>
					</tr>

					<tr>
					  <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 업태 </td>
					  <td><input type="text" name="shop_etc1_<?=$cnt?>" id="shop_etc1_<?=$cnt?>" value="<?=$shop_etc1?>" class="logbox"  style="width:150" />  
						</td>
					</tr>

					<tr>
					  <td width="110" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 종목 </td>
					  <td><input type="text" name="shop_etc2_<?=$cnt?>" id="shop_etc2_<?=$cnt?>" value="<?=$shop_etc2?>" class="logbox"  style="width:150" />  
						</td>
					</tr>

					<tr>
					  <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 사업장 주소 <span class="num8">*</span></td>
					  <td class="infont"><input type="text" name="shop_zipcode_<?=$cnt?>" id="shop_zipcode_<?=$cnt?>" value="<?=$zipcode?>" class="logbox"  style="width:100" readOnly />
						  <a href="javascript:zip_check_shop('S','<?=$cnt?>');"><img src="/img/btn_home.gif" border="0"  align="absmiddle" /></a></td>
					</tr>
					<tr>
					  <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
					  <td><input type="text" name="shop_addr1_<?=$cnt?>" id="shop_addr1_<?=$cnt?>" value="<?=$shop_addr1?>" class="logbox"  style="width:400" /></td>
					</tr>
					<tr>
					  <td height="20" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
					  <td><input type="text" name="shop_addr2_<?=$cnt?>" id="shop_addr2_<?=$cnt?>" value="<?=$shop_addr2?>" class="logbox"  style="width:400" /></td>
					</tr>
					

					<tr>
					  <td height="24" class="intitle" style="LETTER-SPACING: 1px" valign="top"><img src="/img/pop_icon.gif"  align="absmiddle" /> 샵 로고 </td>
					  <td class="infont"><input type="file" name="shop_logo_<?=$cnt?>" id="shop_logo_<?=$cnt?>" class="logbox"  style="width:474" />
					  <br>＊가로 64픽셀, 세로 64픽셀 권장
					  <? if ( $shop_idx ) { ?>
					  <div id="shop_logo_area_<?=$cnt?>"><img id="shop_logo_img_<?=$cnt?>" src="<?=$UP_URL."/thumb/".$shop_logo?>" border="0" width="64" height="64" /></div>
					  <? } ?>
					  </td>
					</tr>

<? if ( !$shop_idx ) { ?>
					<tr>
					  <td class="infont" align="right" colspan="2"><a href="javascript:hide_shop('<?=$cnt?>');">삭제</a></td>
					</tr>
<? } ?>

                  </table>

                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
</div>

<?

}

$mainconn->close();

?>




      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
        <tr>
          <td height="25" bgcolor="F6F5F5" style="padding-top:3">&nbsp;
 ▶ 등록된 샵              </td>
          <td width="80" align="right" bgcolor="F6F5F5" ><img src="/img/btn_shop_add.gif" width="80" height="20" border="0" onClick="add_shop();" style="cursor:hand;" /></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
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
                      <td align="center"><img src="/img/title10.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="170" align="center"><img src="/img/title25.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="110" align="center"><img src="/img/title06.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="180" align="center"><img src="/img/title26.gif" width="70" height="20" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="FF5B5C"></td>
              </tr>
            </table>


              <table width="645" border="0" cellspacing="0" cellpadding="0">
<?
echo $LIST;
?>

				<tr>
                  <td height="6" colspan="4"  bgcolor="FF5B5C" ></td>
                </tr>
              </table>

              <table width="100" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>

				<?php
				//echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str); 
				?>
<!--
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center"><a href="#"><img src="/img/btn_first_go2.gif" width="20" height="16" border="0" align="absmiddle" /></a><a href="#"><img src="/img/btn_prev6.gif" width="44" height="16" border="0" align="absmiddle" /></a>&nbsp;<a href="#"> 1</a> | <a href="#"><b><font color="#333333">2</font></b></a> | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>&nbsp; <a href="#"><img src="/img/btn_next6.gif" width="44" height="16" border="0" align="absbottom" /></a><a href="#"><img src="/img/btn_end_go2.gif" width="20" height="16" border="0" align="absmiddle" /></a></td>
                </tr>
            </table>
-->		
			</td>
        </tr>
      </table>
      <table border="0" align="center" cellpadding="0" cellspacing="0">
       
        <tr>
          <td><img src="/img/btn_phone02.gif" width="180" height="30" border="0" onClick="goSubmit();" style="cursor:hand;" /></td>
        </tr>
      </table></td>
  </tr>

<input type="hidden" id="pmode" name="pmode" value="" />
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="pno_1" name="pno_1" value="<?=$pno_1?>" />
<input type="hidden" id="pno_2" name="pno_2" value="<?=$pno_2?>" />
<input type="hidden" id="pno_3" name="pno_3" value="<?=$pno_3?>" />
</form>

</table>

<a href="javascript:alert(g_layer);">aaaaaaaaaa</a>

<? include "../include/_foot.php"; ?>