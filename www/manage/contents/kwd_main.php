<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/contents/kwd_main.php
 * date   : 2008.08.26
 * desc   : Admin main keyword list
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
//referer_chk();


$mainconn->open();

$cond = " where 1 and kwd_status != 'N' ";

$orderby = " order by kwd_idx desc ";

$sql = "select kwd_idx,kwd_categ,kwd_kind,kwd,kwd_status from tblKwd $cond $orderby ";

$res = $mainconn->query($sql);

//$ST = $IT = $TH = $ET = "";
$k = $sel_all = $sel_main = $data = "";
//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$t_kwd_idx		= trim($row['kwd_idx']);
	$t_kwd_categ	= trim($row['kwd_categ']);
	$t_kwd_kind		= trim($row['kwd_kind']);
	$t_kwd			= trim($row['kwd']);
	$t_kwd_status	= trim($row['kwd_status']);

	$k .= $t_kwd." ";

	$sel_all .= "<option value='${t_kwd_idx}:${t_kwd}'>".strip_tags($t_kwd)."</option>";
	if ( $t_kwd_status == "M" ) {
		$sel_main .= "<option value='${t_kwd_idx}:${t_kwd}'>".strip_tags($t_kwd)."</option>";
		$data .= $t_kwd_idx.":".$t_kwd.";";
	}
}

$mainconn->close();

$LIST = "
	<table width='980' border='0' cellpadding='0' cellspacing='0' align='center'>
        <tr>
			<td>
		  
			<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='D4D4D4'>
				<tr>
					<td align='left' bgcolor='EFEFEF' style='padding:12 25 12 25'>
				
					$k

					</td>
				</tr>
			</table>

			</td>
		</tr>
	</table>
";

require_once "../_top.php";
?> 

<script language="javascript">
function inputKwd(arg_idx,arg_categ,arg_kind,arg_kwd) {
	var f = document.frm;
	for ( var i=0; i<f.kwd_categ.length; i++ ) {
		if ( f.kwd_categ[i].value == arg_categ ) {
			f.kwd_categ[i].checked = true;
			break;
		}
	}

	for ( var j=0; j<f.kwd_kind.length; j++ ) {
		if ( f.kwd_kind[j].value == arg_kind ) {
			f.kwd_kind[j].checked = true;
			break;
		}
	}

	f.kwd.value = arg_kwd;
	f.mode.value = "E";
	f.sel_idx.value = arg_idx;
}

function saveKwd() {
	var f = document.frm;

	var cnt = 0;
	for ( var i=0; i<f.kwd_categ.length; i++ ) {
		if ( f.kwd_categ[i].checked == true ) {
			cnt++;
			break;
		}
	}
	if ( cnt == 0 ) {
		alert("카테고리를 선택하세요");
		return;
	}

	var cnt2 = 0;
	for ( var j=0; j<f.kwd_kind.length; j++ ) {
		if ( f.kwd_kind[j].checked == true ) {
			cnt2++;
			break;
		}
	}
	if ( cnt2 == 0 ) {
		alert("분류를 선택하세요");
		return;
	}
	if ( f.kwd.value == "" ) {
		alert("키워드를 입력하세요");
		f.kwd.focus();
		return;
	}

	f.action = "kwd_categ_ok.php";
	f.submit();
}

function goKwdCateg(categ) {
	location.href = "kwd_categ.php?kwd_categ="+categ;
}
</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ 메인 키워드 관리</font></b> 코디탑텐 메인키워드를 설정합니다. </td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="data" name="data" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">

<?=$LIST?>

<br>
<!--
<table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><h1>키워드 생성</h1></td>
	</tr>
</table>
-->
<table width="980" border="0" cellpadding="3" cellspacing="0" bgcolor="#CECECE">
	<tr> 
		
		<td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">전체 키워드</td>
				</tr>
				<tr>
					<td align="center">
						<select id="s_all" name="s_all" size="30" multiple>
							<?=$sel_all?>
						</select>
					</td>
				</tr>
			</table>
		</td>

<script>
var data = "<?=$data?>";
function save_item() {
	var f = document.frm;
	f.mode.value = "E";
	f.action = "kwd_main_ok.php";
	f.data.value = data;
	f.submit();
	//alert(data);
}

function add_item() {
	var f = document.frm;
	if ( f.s_all.length < 1 ) {
		alert("메인에 추가할 키워드를 선택하세요");
		return;
	}
	for ( var i=0; i<f.s_all.length; i++ ) {
		if ( f.s_all.options[i].selected == true ) {
			var opt_obj = document.createElement("OPTION");
			opt_obj.value = f.s_all.options[i].value;
			opt_obj.text = f.s_all.options[i].text;

			data += f.s_all.options[i].value + ";";
			
			if ( getNavigatorInfo() == "IE" ) {
				f.s_main.add(opt_obj);
			} else {
				f.s_main.appendChild(opt_obj);
			}
		}
	}
	// 선택된거 해제
	f.s_all.selectedIndex = -1;
}

function del_item() {
	var f = document.frm;
	if ( f.s_main.length < 1 ) {
		alert("메인에서 제거할 키워드를 선택하세요");
		return;
	}
	for ( var i=0; i<f.s_main.length; i++ ) {
		if ( f.s_main.options[i].selected == true ) {
			data.replace(f.s_main.options[i].value+";","");
			f.s_main.options[i] = null;
		}
	}
}

// 19:키워드
// 19:<font size=+1>키워드</font>
// 19:<font size=+3><b>키워드</b></font>
// 19:<font size=+5><b>키워드</b></font>
function chg_main_item() {
	var f = document.frm;
	var tmp_arr = new Array();
	tmp_arr = f.s_main.options[f.s_main.selectedIndex].value.split(":");

	f.sel_idx.value = tmp_arr[0];
	f.kwd.value = f.s_main.options[f.s_main.selectedIndex].text;

	if ( tmp_arr[1].substring(0,8) == "<strong>" ) {
		f.font[1].checked = true;
	} else if ( tmp_arr[1].substring(0,23) == "<b><font color=#3366CC>" ) {
		f.font[2].checked = true;
	} else if ( tmp_arr[1].substring(0,23) == "<b><font color=#FF3300>" ) {
		f.font[3].checked = true;
	} else {
		f.font[0].checked = true;
	}
}

function chg_font(num) {
	var f = document.frm;
	tmp_data = data;
	s = f.s_main.options[f.s_main.selectedIndex].value+";";
	if ( num == 1 ) {
		new_s = f.sel_idx.value+":"+f.kwd.value;
	} else if ( num == 2 ) {
		new_s = f.sel_idx.value+":"+"<strong>"+f.kwd.value+"</strong>";
	} else if ( num == 3 ) {
		new_s = f.sel_idx.value+":"+"<b><font color=#3366CC>"+f.kwd.value+"</font></b>";
	} else if ( num == 4 ) {
		new_s = f.sel_idx.value+":"+"<b><font color=#FF3300>"+f.kwd.value+"</font></b>";
	}
	
	f.s_main.options[f.s_main.selectedIndex].value = new_s;
	data = tmp_data.replace(s, new_s+";");
	//alert(s+"\n"+new_s+"\n"+data);
}
</script>

		<td bgcolor="#FFFFFF" align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center"><input type="button" value="추가>>" onClick="add_item();" /></td>
				</tr>
				<tr><td height="10">&nbsp;</td></tr>
				<tr>
					<td align="center"><input type="button" value="<<삭제" onClick="del_item();" /></td>
				</tr>
			</table>
		</td>

		<td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">메인 키워드</td>
				</tr>
				<tr>
					<td align="center">
						<select id="s_main" name="s_main" size="30" multiple onChange="chg_main_item();;">
							<!--<option value="3">가디건</option>-->
							<?=$sel_main?>
						</select>
					</td>
				</tr>
			</table>
		</td>

		<td bgcolor="#FFFFFF" width="10" align="center">
			&nbsp;
		</td>

		<td bgcolor="#FFFFFF" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right">키워드 : </td>
					<td> <input type="text" id="kwd" name="kwd" value="" /></td>
				</tr>
				<tr><td height="10">&nbsp;</td></tr>
				<tr>
					<td align="right">형태 : </td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td height="20"><input type="radio" id="font" name="font" value="1" onClick="chg_font(1);" /> 일반</td></tr>
							<tr><td height="20"><input type="radio" id="font" name="font" value="2" onClick="chg_font(2);" /> <b>약간강조</b></td></tr>
							<tr><td height="20"><input type="radio" id="font" name="font" value="3" onClick="chg_font(3);" /> <b><font color="#3366CC">강조</font></b></td></tr>
							<tr><td height="20"><input type="radio" id="font" name="font" value="3" onClick="chg_font(4);" /> <b><font color="#FF3300">매우강조</font></b></td></tr>
						</table>
					</td>
				</tr>
				<tr><td height="10">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="center">
						<input type="button" value="적 용" onClick="save_item();" />
						<input type="button" value="취 소" onClick="document.frm.reset();" />
					</td>
				</tr>
			</table>
		</td>



		

		
	</tr>
</table>

</form>




<?php 
require_once "../_bottom.php";

?> 