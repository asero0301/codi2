var g_w_url;
var g_v_url;
var g_mem_id;
var g_kind;
var g_p_idx;
var g_pe_idx;
var g_page;
var g_giftpage;
var g_giftafterpage;
var g_mem_id;
var g_mem_kind;
var g_rurl;
var g_updown_yn;
var g_active;
var g_shop_idx;
var g_categ;
var g_term;
var g_kwd;
var g_key;
var g_f_date;
var g_keyword;
var g_s_key;

var	g_tkind;
var	g_ttkind;
var	g_tkey;
var	g_tkwd;
var	g_tpage;

var CMT_STR = new Array(
	"�α����� �ϼž� �������� �����մϴ�.", 
	"�򰡿� �̹� �����ϼ̽��ϴ�. �ϳ��� �ڵ��ǰ�� 1ȸ�� �������� �����մϴ�.",
	"����򰡸� �Է��� ��, ������ UP �Ǵ� DOWN �� Ŭ���ϸ� ����� �Ϸ�˴ϴ�.",
	"�ش� �ڵ��� �򰡱Ⱓ�� �Ϸ�Ǿ����ϴ�."
);


function createXMLHttpRequest() {
	var xmlHttp = false;

	try {
		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e2) {
			xmlHttp = false;
		}
	}

	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
		  xmlHttp = new XMLHttpRequest();
	}

	return xmlHttp;
}



// ������ ����Ʈ ����
function loadAuthShopList(kind, key, kwd, page, nul) {
	g_kind = kind;
	g_kwd = kwd;
	g_key = key;
	g_page = page;

	req_auth_rank = createXMLHttpRequest();
	req_auth_rank.onreadystatechange = getAuthShopListCallBack;

	req_auth_rank.open("GET", "/product/ajax_auth_rank_list.php?kind="+kind+"&kwd="+kwd+"&key="+key+"&page="+page, true);
	req_auth_rank.send("");
}

// callback
function getAuthShopListCallBack() {
	if (req_auth_rank.readyState == 4) {
		if (req_auth_rank.status == 200) {
			printAuthShopList();
		} else {
			alert("getAuthShopListCallBack error \n" + req_auth_rank.statusText);
		}
	}
	
}

// print
function printAuthShopList() {
	var outhtml = "";
	outhtml += req_auth_rank.responseText;
	outhtml = trim(outhtml);
	document.getElementById("AuthShopListArea").innerHTML=outhtml;
}
// ������ ����Ʈ ��


// �� ��ũ ����
function loadShopRankSub(term, f_date, key, kwd) {
	g_term = term;
	g_kwd = kwd;
	g_key = key;
	g_f_date = f_date;

	req_shop_rank = createXMLHttpRequest();
	req_shop_rank.onreadystatechange = getShopRankSubCallBack;

	req_shop_rank.open("GET", "/product/ajax_shop_rank_sub.php?term="+term+"&kwd="+kwd+"&key="+key+"&f_date="+f_date, true);
	req_shop_rank.send("");

	// ����� �Ⱓ�� ���� �ϴ��� ����Ʈ�� �޶�����.
	loadShopRankSubList(term, f_date, key, 1, kwd);
}

// callback
function getShopRankSubCallBack() {
	if (req_shop_rank.readyState == 4) {
		if (req_shop_rank.status == 200) {
			printShopRankSub();
		} else {
			alert("getShopRankSubCallBack error \n" + req_shop_rank.statusText);
		}
	}
	
}

// print
function printShopRankSub() {
	var outhtml = "";
	outhtml += req_shop_rank.responseText;
	outhtml = trim(outhtml);
	document.getElementById("ShopRankSubArea").innerHTML=outhtml;
}
// �� ��ũ ��

// �� ��ũ ����Ʈ ����
function loadShopRankSubList(term, f_date, key, page, kwd) {
	g_term = term;
	g_kwd = kwd;
	g_key = key;
	g_f_date = f_date;
	g_page = page;

	req_shop_rank_list = createXMLHttpRequest();
	req_shop_rank_list.onreadystatechange = getShopRankSubListCallBack;

	req_shop_rank_list.open("GET", "/product/ajax_shop_rank_sub_list.php?term="+term+"&kwd="+kwd+"&key="+key+"&f_date="+f_date+"&page="+page, true);
	req_shop_rank_list.send("");
}

// callback
function getShopRankSubListCallBack() {
	if (req_shop_rank_list.readyState == 4) {
		if (req_shop_rank_list.status == 200) {
			printShopRankSubList();
		} else {
			alert("getShopRankSubListCallBack error \n" + req_shop_rank_list.statusText);
		}
	}
	
}

// print
function printShopRankSubList() {
	var outhtml = "";
	outhtml += req_shop_rank_list.responseText;
	outhtml = trim(outhtml);
	document.getElementById("ShopRankSubListArea").innerHTML=outhtml;
}
// �� ��ũ ����Ʈ ��



// �ڵ��� ���� ��ũ ����
function loadCodiRankSub(categ, term, f_date, key, kwd) {
	g_categ = categ;
	g_term = term;
	g_kwd = kwd;
	g_key = key;
	g_f_date = f_date;

	req_rank = createXMLHttpRequest();
	req_rank.onreadystatechange = getCodiRankSubCallBack;

	req_rank.open("GET", "/product/ajax_codi_rank_sub.php?categ="+categ+"&term="+term+"&kwd="+kwd+"&key="+key+"&f_date="+f_date, true);
	req_rank.send("");

	// ����� ī�װ�/�Ⱓ�� ���� �ϴ��� ����Ʈ�� �޶�����.
	loadCodiRankSubList(categ, term, f_date, key, kwd, 1);
}

// callback
function getCodiRankSubCallBack() {
	if (req_rank.readyState == 4) {
		if (req_rank.status == 200) {
			printCodiRankSub();
		} else {
			alert("getCodiRankSubCallBack error \n" + req_rank.statusText);
		}
	}
	
}

// print
function printCodiRankSub() {
	var outhtml = "";
	outhtml += req_rank.responseText;
	outhtml = trim(outhtml);
	document.getElementById("CodiRankSubArea").innerHTML=outhtml;
}
// �ڵ��� ���� ��ũ ��


// �ڵ��� ���� ��ũ ����Ʈ ����
function loadCodiRankSubList(categ, term, f_date, key, kwd, page) {
	g_categ = categ;
	g_term = term;
	g_kwd = kwd;
	g_key = key;
	g_f_date = f_date;
	g_page = page;

	req_rank_list = createXMLHttpRequest();
	req_rank_list.onreadystatechange = getCodiRankSubListCallBack;

	req_rank_list.open("GET", "/product/ajax_codi_rank_sub_list.php?categ="+categ+"&term="+term+"&kwd="+kwd+"&key="+key+"&f_date="+f_date+"&page="+page, true);
	req_rank_list.send("");
}

// callback
function getCodiRankSubListCallBack() {
	if (req_rank_list.readyState == 4) {
		if (req_rank_list.status == 200) {
			printCodiRankSubList();
		} else {
			alert("getCodiRankSubListCallBack error \n" + req_rank_list.statusText);
		}
	}
	
}

// print
function printCodiRankSubList() {
	var outhtml = "";
	outhtml += req_rank_list.responseText;
	outhtml = trim(outhtml);
	document.getElementById("CodiRankSubListArea").innerHTML=outhtml;
}
// �ڵ��� ���� ��ũ ����Ʈ ��


function realtime_pop_msg_read(msg_info,str,order) {
	str = trim(str);
	if ( str == "" ) {
		return;
	}
	t_px = 30 * parseInt(order);
	l_px = 30 * parseInt(order);

	// msg_info => "9:2"
	// str => "admin^64"

	arr_msg_cnt_info = msg_info.split(':');
	msg_total_cnt = arr_msg_cnt_info[0];
	msg_noread_cnt = arr_msg_cnt_info[1];
	
	arr_str = str.split('^');
	send_mem_id = arr_str[0];
	mem_idx = arr_str[1];

	// �����ڰ� ���� �����̸� �˾�ó��
	if ( send_mem_id == "admin" ) {
		var f = document.frm;

		var pop = parent.window.open("","pop_msg_read_target_"+mem_idx,"top="+t_px+",left="+l_px+",toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=500,height=365");
		f.msg_idx.value = mem_idx;
		f.action = "/msg/pop_msg_read.php";
		f.target = "pop_msg_read_target_"+mem_idx;
		f.submit();
		pop.focus();
	} else {
		// ���κ� ���� �̹��� ����
		parent.document.getElementById("head_msg_icon").src = "/img/icon_memo_11.gif";
		parent.document.getElementById("head_msg_icon").alt = "�������� ������ �ֽ��ϴ�.";

		// ���޴� �κ� ����
		parent.document.getElementById("my_quick_msg_noread_area").innerHTML = msg_noread_cnt;
		parent.document.getElementById("my_quick_msg_total_area").innerHTML = msg_total_cnt;

		// ���޴� �κ� �������� ������ ������ �������� �ٲ۴�.
		if ( msg_noread_cnt ) {
			parent.document.getElementById("quick_msg_icon").src = "/img/icon_memo_ov.gif";
		} else {
			parent.document.getElementById("quick_msg_icon").src = "/img/icon_memo.gif";
		}
	}
}

function msgChk() {
	//alert('chk');
	msg_req = createXMLHttpRequest();
	msg_req.onreadystatechange = getMsgChkCallBack;
	msg_req.open("GET", "/msg/realtime_msg_chk.php", true);
	msg_req.send("");
	window.setTimeout("msgChk()",20000);
}

// callback
function getMsgChkCallBack() {
	if (msg_req.readyState == 4) {
		if (msg_req.status == 200) {
			printMsgChk();
		} else {
			//alert("getMsgChkCallBack error \n" + msg_req.statusText);
		}
	}
	
}

// print
function printMsgChk() {
	var outhtml = "";
	outhtml += msg_req.responseText;
	outhtml = trim(outhtml);
	//alert(outhtml);
	if ( outhtml != "" ) {		
		arr_s = outhtml.split('@');
		msg_cnt = arr_s[0];
		arr_msg_idx = arr_s[1].split('|');
		for ( var i=0; i<arr_msg_idx.length; i++ ) {
			realtime_pop_msg_read(msg_cnt, arr_msg_idx[i],i+1);
		}
	}
}

///////////////////////////////// �򰡴���� �ڵ� ////////////////////////////////////////
function loadCategKwdList(kwd_categ,kwd_kind,kwd,page,order,s_key,keyword) {
	g_kwd_categ = kwd_categ;
	g_kwd_kind = kwd_kind;
	g_kwd = kwd;
	g_page = page;
	g_order = order;
	g_s_key = s_key;
	g_keyword = keyword;

	req_categ = createXMLHttpRequest();
	req_categ.onreadystatechange = getCategKwdListCallBack;

	req_categ.open("GET", "/product/ajax_categ_kwd_list.php?kwd_categ="+kwd_categ+"&kwd_kind="+kwd_kind+"&kwd="+kwd+"&page="+page+"&order="+order+"&s_key="+s_key+"&keyword="+keyword, true);
	req_categ.send("");
}

// callback
function getCategKwdListCallBack() {
	
	if (req_categ.readyState == 4) {
		if (req_categ.status == 200) {
			printCategKwdList();
		} else {
			alert("codi comment:getCategKwdListCallBack \n" + req_categ.statusText);
		}
	}
	
}

// print
function printCategKwdList() {
	var outhtml = "";
	outhtml += req_categ.responseText;
	document.getElementById("CategKwdListArea").innerHTML=outhtml;
}
///////////////////////////////// �򰡴���� �ڵ� ////////////////////////////////////////


///////////////////////////////// �ڵ��� ��÷�ı� ���� ////////////////////////////////////////
function loadProductGiftAfter(p_idx,pe_idx,tmp,giftafterpage) {
	g_p_idx = p_idx;
	g_pe_idx = pe_idx;
	g_giftafterpage = giftafterpage;
	
	req_gift_after = createXMLHttpRequest();//req 
	req_gift_after.onreadystatechange = getProductGiftAfterCallBack;

	req_gift_after.open("GET", "/product/ajax_product_gift_after.php?p_idx="+p_idx+"&pe_idx="+pe_idx+"&giftafterpage="+giftafterpage, true);
	req_gift_after.send("");
}

// callback
function getProductGiftAfterCallBack() {
	
	if (req_gift_after.readyState == 4) {
		if (req_gift_after.status == 200) {
			printProductGiftAfter();
		} else {
			alert("codi comment:getProductGiftAfterCallBack \n" + req_gift_after.statusText);
		}
	}
	
}

// print
function printProductGiftAfter() {
	var outhtml = "";
	outhtml += req_gift_after.responseText;
	document.getElementById("ProductGiftAfterArea").innerHTML=outhtml;
}
///////////////////////////////// �ڵ��� ��÷�ı� �� ////////////////////////////////////////



///////////////////////////////// �ڵ��� ��ǰ���� ���� ////////////////////////////////////////
function loadProductGiftTracking(p_idx,pe_idx,shop_idx,giftpage) {
	g_p_idx = p_idx;
	g_pe_idx = pe_idx;
	g_giftpage = giftpage;
	g_shop_idx = shop_idx;
	
	req_gift = createXMLHttpRequest();//req 
	req_gift.onreadystatechange = getProductGiftTrackingCallBack;

	req_gift.open("GET", "/product/ajax_product_gift_tracking.php?p_idx="+p_idx+"&pe_idx="+pe_idx+"&shop_idx="+shop_idx+"&giftpage="+giftpage, true);
	req_gift.send("");
}

// callback
function getProductGiftTrackingCallBack() {
	
	if (req_gift.readyState == 4) {
		if (req_gift.status == 200) {
			printProductGiftTracking();
		} else {
			alert("codi comment:getProductGiftTrackingCallBack \n" + req_gift.statusText);
		}
	}
	
}

// print
function printProductGiftTracking() {
	var outhtml = "";
	outhtml += req_gift.responseText;
	document.getElementById("ProductGiftTrackingArea").innerHTML=outhtml;
}
///////////////////////////////// �ڵ��� ��ǰ���� �� ////////////////////////////////////////

///////////////////////////////// �ڵ��� ��� ���� ////////////////////////////////////////
// �ڵ��� ��� �ڸ�Ʈ ó��
function loadProductComment(mem_id,mem_kind,rurl,p_idx,pe_idx,page,v_url,w_url,updown_yn,active) {
	g_mem_id = mem_id;
	g_mem_kind = mem_kind;
	g_rurl = rurl;
	g_p_idx = p_idx;
	g_pe_idx = pe_idx;
	g_page = page;
	g_v_url = v_url;
	g_w_url = w_url;
	g_updown_yn = updown_yn;
	g_active = active;

	req_cc = createXMLHttpRequest();//req 
	req_cc.onreadystatechange = getProductCommentCallBack;

	req_cc.open("GET", "/product/ajax_product_comment.php?p_idx="+p_idx+"&pe_idx="+pe_idx+"&page="+page+"&rurl="+rurl+"&updown_yn="+updown_yn+"&active="+active, true);
	req_cc.send("");
}

// callback
function getProductCommentCallBack() {
	
	if (req_cc.readyState == 4) {
		if (req_cc.status == 200) {
			printProductComment();
		} else {
			alert("codi comment:getProductCommentCallBack \n" + req_cc.statusText);
		}
	}
	
}


// print
function printProductComment() {
	var outhtml = "";
	outhtml += req_cc.responseText;
	document.getElementById("ProductCommentArea").innerHTML=outhtml;

	var cmt_str = "";
	if ( g_active == "Y" ) {
		if ( g_mem_id == "" ) {
			cmt_str = CMT_STR[0];
		} else {
			if ( g_updown_yn == "Y" ) {
				cmt_str = CMT_STR[1];
			} else {
				cmt_str = CMT_STR[2];
			}
		}
	} else {
		cmt_str = CMT_STR[3];
	}

	// �и��Ѵ�.
	outhtml = "";
	outhtml += "<table width='860' border='0' cellpadding='8' cellspacing='1' bgcolor='#E8E8E8'>";
	outhtml += "<form name='f'>";
	outhtml += "	<tr>";
	outhtml += "		<td bgcolor='#FFFFFF'>";
	outhtml += "		<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	outhtml += "			<tr>";
	outhtml += "				<td>";
	outhtml += "					<textarea id='p_comment' name='p_comment' onFocus=\"comment_auth_chk(); check_msg(this.form.p_comment);\" onBlur=\"check_msg(this.form.p_comment)\" class='memobox' style='width:98%;'>"+cmt_str+"</textarea>";
	outhtml += "				</td>";
	outhtml += "				<td width='215'>";
	outhtml += "				<span id='updown_btn_area_2'>";

	if ( g_updown_yn == "N" ) {	
		outhtml += "				<table border='0' cellspacing='0' cellpadding='0'>";
		outhtml += "					<tr>";
		outhtml += "						<td width='106'>";
		outhtml += "							<a href='#' onClick=\"return ProductComment('I','U',document.f.p_comment);\" onMouseOut=\"MM_swapImgRestore();\" onMouseOver=\"MM_swapImage('Image1158','','/img/btn_up_ov.gif',1);\"><img src='/img/btn_up.gif' alt='�ڵ� �� ��' name='Image1158' width='102' height='68' border='0' /></a>";
		outhtml += "						</td>";
		outhtml += "						<td>";
		outhtml += "							<a href='#' onClick=\"return ProductComment('I','D',document.f.p_comment);\" onMouseOut=\"MM_swapImgRestore();\" onMouseOver=\"MM_swapImage('Image1159','','/img/btn_down_ov.gif',1);\"><img src='/img/btn_down.gif' alt='�ڵ� �ٿ� ��' name='Image1159' width='102' height='68' border='0' /></a>";
		outhtml += "						</td>";
		outhtml += "					</tr>";
		outhtml += "				</table>";
	} else {
		outhtml += "				<table border='0' cellspacing='0' cellpadding='0'>";
		outhtml += "					<tr>";
		outhtml += "						<td>";
		outhtml += "							<a href='#' onClick=\"return ProductComment('I','E',document.f.p_comment);\"><img src='/img/btn_comment_ok.gif' alt='��۾���' height='68' border='0' /></a>";
		outhtml += "						</td>";
		outhtml += "					</tr>";
		outhtml += "				</table>";
	}
	
	outhtml += "				</span>";
	outhtml += "				</td>";
	outhtml += "			</tr>";
	outhtml += "		</table>";
	outhtml += "		</td>";
	outhtml += "	</tr>";
	outhtml += "</form>";
	outhtml += "</table>";
	

	document.getElementById("ProductComment2Area").innerHTML=outhtml;



	// ù��° ���â
	f_btn_area = "";
	f_btn_area += "<table width='860' border='0' cellpadding='8' cellspacing='1' bgcolor='#E8E8E8'>";
	f_btn_area += "<form name='tmp_f'>";
	f_btn_area += "  <tr>";
	f_btn_area += "	<td bgcolor='#FFFFFF'>";
	f_btn_area += "	<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	f_btn_area += "	  <tr>";
	f_btn_area += "		<td><textarea name='p_comment_trick' id='p_comment_trick' onFocus=\"comment_auth_chk(); check_msg(this.form.p_comment_trick);\" onBlur=\"check_msg(this.form.p_comment_trick)\" class='memobox' style='width:98%;'>"+cmt_str+"</textarea></td>";
	f_btn_area += "		<td width='215'>";
	if ( g_updown_yn == "N" ) {	
		f_btn_area += "				<table border='0' cellspacing='0' cellpadding='0'>";
		f_btn_area += "					<tr>";
		f_btn_area += "						<td width='106'>";
		f_btn_area += "							<a href='#' onClick=\"return ProductComment('I','U',document.tmp_f.p_comment_trick);\" onMouseOut=\"MM_swapImgRestore();\" onMouseOver=\"MM_swapImage('Image1158','','/img/btn_up_ov.gif',1);\"><img src='/img/btn_up.gif' alt='�ڵ� �� ��' name='Image1158' width='102' height='68' border='0' /></a>";
		f_btn_area += "						</td>";
		f_btn_area += "						<td>";
		f_btn_area += "							<a href='#' onClick=\"return ProductComment('I','D',document.tmp_f.p_comment_trick);\" onMouseOut=\"MM_swapImgRestore();\" onMouseOver=\"MM_swapImage('Image1159','','/img/btn_down_ov.gif',1);\"><img src='/img/btn_down.gif' alt='�ڵ� �ٿ� ��' name='Image1159' width='102' height='68' border='0' /></a>";
		f_btn_area += "						</td>";
		f_btn_area += "					</tr>";
		f_btn_area += "				</table>";
	} else {
		f_btn_area += "				<table border='0' cellspacing='0' cellpadding='0'>";
		f_btn_area += "					<tr>";
		f_btn_area += "						<td>";
		f_btn_area += "							<a href='#' onClick=\"return ProductComment('I','E',document.tmp_f.p_comment_trick);\"><img src='/img/btn_comment_ok.gif' alt='��۾���' height='68' border='0' /></a>";
		f_btn_area += "						</td>";
		f_btn_area += "					</tr>";
		f_btn_area += "				</table>";
	}

	f_btn_area += "			</td>";
	f_btn_area += "	  </tr>";
	f_btn_area += "	</table>";
	f_btn_area += "	</td>";
	f_btn_area += "  </tr>";
	f_btn_area += "</form>";
	f_btn_area += "</table>";

	document.getElementById("updown_btn_area_1").innerHTML=f_btn_area;
}

function ProductComment(mode,updown,cmt) {
	submitProductComment(mode,updown,'');
	return false;
}

function submitProductComment(mode,updown,pc_idx) {
	if ( g_mem_kind == "S" ) {
		alert("��ȸ���� �������� �� �� �����ϴ�.");
		return false;
	}
	if ( mode == "D" ) {
		if ( !confirm('����� �����ұ��?') ) {
			return;
		}
	}
	req_ccc = createXMLHttpRequest();
	req_ccc.onreadystatechange = getProductCommentWriteCallBack;
	var postString = "";

	// encodeURIComponent
	real_str = "";

	var str_1 = trim(document.getElementById("p_comment_trick").value);
	var str_2 = trim(document.getElementById("p_comment").value);

	if ( str_2 != "" && str_2 != CMT_STR[0] && str_2 != CMT_STR[1] && str_2 != CMT_STR[2] && str_2 != CMT_STR[3] ) {
		real_str = encodeURIComponent(str_2);
	} else if ( str_1 != "" && str_1 != CMT_STR[0] && str_1 != CMT_STR[1] && str_1 != CMT_STR[2] && str_1 != CMT_STR[3] ) {
		real_str = encodeURIComponent(str_1);
	} else {
		alert("���� �Է��ϼ���");
		return false;
	}

	postString = "pc_comment=" + real_str;
	postString += "&p_idx=" + escape(g_p_idx);
	postString += "&pe_idx=" + escape(g_pe_idx);
	postString += "&page=" + escape(g_page);
	postString += "&pc_idx=" + escape(pc_idx);
	postString += "&mode=" + escape(mode);
	postString += "&updown=" + escape(updown);
	
	//alert(postString);

	req_ccc.open("POST", g_w_url, true);
	req_ccc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	req_ccc.send(postString);
}

function getProductCommentWriteCallBack() {
	if (req_ccc.readyState == 4) {
		if (req_ccc.status == 200) {
			// ���������� �ٲٱ����� g_updown_yn ����
			g_updown_yn = "Y";
			// �ڵ� ������Ʈ�� ������ ����
			resetProductInfo();
			loadProductComment(g_mem_id, g_mem_kind, g_rurl, g_p_idx, g_pe_idx, g_page, g_v_url, g_w_url, g_updown_yn, g_active);
		} else {
			alert("getProductCommentWriteCallBack fail\n" + req_ccc.statusText);
		}
	}
}

function resetProductInfo() {
	// �����-��������-������-�ٿ��-��������-��۰���-���������ڵ𰹼�-������-��÷Ȯ��
	var res = req_ccc.responseText;
	res_arr = res.split("-");
	document.getElementById("sp_current_total_score").innerHTML = res_arr[1];
	document.getElementById("sp_up_1").innerHTML = res_arr[2];
	document.getElementById("sp_up_2").innerHTML = res_arr[2];
	document.getElementById("sp_up_3").innerHTML = res_arr[2];
	document.getElementById("sp_down_1").innerHTML = res_arr[3];
	document.getElementById("sp_down_2").innerHTML = res_arr[3];
	document.getElementById("sp_down_3").innerHTML = res_arr[3];
	document.getElementById("sp_updown_2").innerHTML = res_arr[4];
	document.getElementById("sp_updown_3").innerHTML = res_arr[4];
	document.getElementById("sp_comment_1").innerHTML = res_arr[5];
	document.getElementById("sp_comment_2").innerHTML = res_arr[5];
	document.getElementById("sp_comment_3").innerHTML = res_arr[5];

	if ( document.getElementById("my_updown_codi_cnt_area") ) {
		document.getElementById('my_updown_codi_cnt_area').innerHTML = res_arr[6];
	}
	if ( document.getElementById("my_quick_grade_area") ) {
		document.getElementById('my_quick_grade_area').innerHTML = res_arr[7];
	}
	if ( document.getElementById("my_quick_percent_area") ) {
		document.getElementById('my_quick_percent_area').innerHTML = res_arr[8];
	}
}
///////////////////////////////// �ڵ��� ��� �� ////////////////////////////////////////

// ���̾� ajax �˾�(���ο�)
function popLayer(pop_idx) {
	req_pop = createXMLHttpRequest();//req 
	req_pop.onreadystatechange = getPopLayerCallBack;

	req_pop.open("GET", "/common/ajax_pop.php?pop_idx="+pop_idx, true);
	req_pop.send("");
}

// ���̾� ajax �˾�(���ο�) �ݹ�
function getPopLayerCallBack() {
	if (req_pop.readyState == 4) {
		if (req_pop.status == 200) {
			printPopLayer();
		} else {
			alert("fail: getPopLayerCallBack \n" + req_pop.statusText);
		}
	}
}

// ���̾� ajax �˾�(���ο�) �Ѹ���
function printPopLayer() {
	var ret_str = "";

	ret_str += req_pop.responseText;
	//alert(ret_str);

	tmp_arr = ret_str.split("^|");
	for ( var i=0; i<tmp_arr.length; i++ ) {
		if ( tmp_arr[i] == "" ) {
			continue;
		}

		if ( tmp_arr[i].charAt(0) == "L" ) {
			pop_kind = "L";
		} else {
			pop_kind = "W";
		}
		item_arr = tmp_arr[i].split("$^!");

		if ( pop_kind == "L" ) {
			pop_layer = item_arr[1];
			document.getElementById("PopLayerArea").innerHTML = pop_layer;
			theLayer.style.display = "none";
			theLayer.style.display = "block";
		} else {
			
			t_width = item_arr[1];
			t_height = item_arr[2];
			t_top = item_arr[3];
			t_left = item_arr[4];
			pop_idx = item_arr[5];
			window.open("/tpl/pop_"+pop_idx+".htm", "pop_target_"+pop_idx, "width="+t_width+", height="+t_height+", top="+t_top+", left="+t_left+", status=no");
		}
	}
}




// �ϴ� �Խ��� ó�� ����
function loadTailBoard(tkind,tkey,tkwd,tpage,ttkind) {
	g_tkind = tkind;
	g_ttkind = ttkind;
	g_tkey = tkey;
	g_tkwd = tkwd;
	g_tpage = tpage;

	req4 = createXMLHttpRequest();//req 
	req4.onreadystatechange = getTailBoardCallBack;
	
	req4.open("GET", "/common/ajax_tail_board.php?tkind="+tkind+"&ttkind="+ttkind+"&tkey="+tkey+"&tpage="+tpage+"&tkwd="+tkwd, true);
	req4.send("");
}

// callback
function getTailBoardCallBack() {
	if (req4.readyState == 4) {
		if (req4.status == 200) {
			printTailBoard();
		} else {
			alert("fail2.:getTailBoardCallBack \n" + req4.statusText);
		}
	}
}

// print
function printTailBoard() {
	var outhtml = "";
	outhtml += req4.responseText;
	outhtml = trim(outhtml);
	document.getElementById("TailBoardArea").innerHTML=outhtml;
}

function goSearchTail() {
	req4 = createXMLHttpRequest();
	req4.onreadystatechange = getTailBoardCallBack;
	
	var f = document.ajax_search_frm;
	var postString = "";
	postString += "tkind=" + escape(f.tkind.value);
	postString += "&ttkind=" + escape(f.ttkind.value);
	postString += "&tpage=" + escape(f.tpage.value);
	postString += "&tkey=A";
	postString += "&tkwd=" + encodeURIComponent(f.tkwd.value);
	req4.open("POST", "/common/ajax_tail_board.php", true);
	req4.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	req4.send(postString);
}



// �Խ��� ��� �ڸ�Ʈ ó��
function loadBoardComment(kind,p_idx,v_url,page,w_url,mem_id,rurl) {
	g_kind = kind;
	g_p_idx = p_idx;
	g_v_url = v_url;
	g_w_url = w_url;
	g_page = page;
	g_mem_id = mem_id;
	g_rurl = rurl;

	req2 = createXMLHttpRequest();//req 
	req2.onreadystatechange = getBoardCommentCallBack;
	
	req2.open("GET", "/common/ajax_comment.php?kind="+kind+"&p_idx="+p_idx+"&page="+page+"&v_url="+v_url+"&w_url="+w_url, true);
	req2.send("");
}

// 
function getBoardCommentCallBack() {
	if (req2.readyState == 4) {
		if (req2.status == 200) {
			printBoardComment();
		} else {
			alert("fail2.:getBoardCommentCallBack \n" + req2.statusText);
		}
	}
}

// 63,138
function printBoardComment() {
	var outhtml = "";
	outhtml += req2.responseText;
	
	outhtml += "<form name='f'>";

	outhtml += "<table width='645' height='25' border='0' cellpadding='0' cellspacing='0' background='/img/bbg.jpg'>";
	outhtml += "	<tr>";
	outhtml += "		<td width='310' bgcolor='CC0000' style='padding-top:3'>&nbsp;&nbsp;<a href='#'><font color='#FFCC66'> �� ��� �Է� ���ڼ� ���� 1000�ڱ���</font></a></td>";
	outhtml += "		<td width='25'><img src='/img/bbg5.gif' width='25' height='25' /></td>";
	outhtml += "		<td align='right' class='evgray'><font color='#FFFFFF'><b class=textchk><span id='textlimit'>0</span></b>/1000</font>&nbsp;&nbsp;</td>";
	outhtml += "	</tr>";
	outhtml += "</table>";
	outhtml += "<table width='645' border='0' cellpadding='8' cellspacing='1' bgcolor='#E8E8E8'>";
	outhtml += "	<tr>";
	outhtml += "		<td bgcolor='#FFFFFF'>";	
	outhtml += "		<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	outhtml += "			<tr>";
	outhtml += "				<td><textarea name='p_comment' id='p_comment' class='memobox' onKeyUp=\"updateChar(1000,this.form.p_comment,'textlimit')\" onFocus=\"comment_auth_chk(); check_msg(this.form.p_comment)\" onBlur=\"check_msg(this.form.p_comment)\" style='width:98%; '></textarea></td>";
	outhtml += "				<td width='51'><a href='#' onClick=\"return BoardComment('I',document.f.p_comment);\"><img src='/img/btn_ok05.gif' border='0' /></a></td>";
	outhtml += "			</tr>";
	outhtml += "		</table>";		
	outhtml += "		</td>";
	outhtml += "	</tr>";
	outhtml += "</table>";

	outhtml += "</form>";

	document.getElementById("BoardCommentArea").innerHTML=outhtml;
}

function BoardComment(mode,cmt) {

	if(cmt.value == "" || cmt.value == "���ڼ�..fail") {
		alert("���ڼ� fail");
		cmt.focus();
		return false;
	}

	submitComment(mode,'');
	return false;
}

function submitComment(mode,pc_idx) {
	if ( mode == "D" ) {
		if ( !confirm('����� �����ұ��?') ) {
			return;
		}
	}
	req3 = createXMLHttpRequest();
	req3.onreadystatechange = getBoardCommentWriteCallBack;
	var postString = "";

	// encodeURIComponent
	postString = "pc_comment=" + encodeURIComponent(document.getElementById("p_comment").value);
	postString += "&p_idx=" + escape(g_p_idx);
	postString += "&pc_idx=" + escape(pc_idx);
	postString += "&mode=" + escape(mode);
	postString += "&kind=" + escape(g_kind);

	req3.open("POST", g_w_url, true);
	req3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	req3.send(postString);
}

function getBoardCommentWriteCallBack() {
	if (req3.readyState == 4) {
		if (req3.status == 200) {
			loadBoardComment(g_kind, g_p_idx, g_v_url, g_page, g_w_url, g_mem_id, g_rurl);
		} else {
			alert("fail3.\n" + req3.statusText);
		}
	}
}

function check_msg(cmt) {
	if (cmt.value == CMT_STR[0] || cmt.value == CMT_STR[1] || cmt.value == CMT_STR[2] || cmt.value == CMT_STR[3]) {
		cmt.value = "";
	} else if (cmt.value == "") {
		cmt.value = "";
		return false;
	}
}

function updateChar(maxlength,cmt,spid){
	var strCount = 0;
	var tempStr, tempStr2;

	for(i = 0;i < cmt.value.length;i++) {
		tempStr = cmt.value.charAt(i);

		if(escape(tempStr).length > 4) strCount += 2;
		else strCount += 1 ;
	}

	if (strCount > maxlength) {
		alert("���ڼ� " + maxlength + "byte�� ������ �����ϴ�.");
		strCount = 0;
		tempStr2 = "";

		for(i = 0; i < cmt.value.length; i++) {
			tempStr = cmt.value.charAt(i);

			if(escape(tempStr).length > 4) strCount += 2;
			else strCount += 1 ;

			if (strCount > maxlength) {
				if(escape(tempStr).length > 4) strCount -= 2;
				else strCount -= 1;
				break;
			} else tempStr2 += tempStr;
		}

		cmt.value = tempStr2;
	}
	document.getElementById(spid).innerHTML = strCount;
}

function comment_auth_chk() {
	if ( g_mem_id == "" ) {
		alert("�α����� �ּ���");
		location.href = "/member/login.php?rurl="+g_rurl;
		return false;
	}
}

function left_trim(str) {
    i = 0;
    // ���ʺ��� space �� ������ ���������� trace
    while (i<=str.length && (str.substring(i,i+1) == ' ' || str.substring(i,i+1) == '\n') ) {
        i = i + 1;
    }
    return str.substring(i);
}

/**
  * ���ڿ��� ������ ������ ����
  */
function right_trim(str) {
    i = str.length - 1;
    // �����ʺ��� space �� ������ ���������� trace
    while (i >= 0 && (str.substring(i,i+1) == ' ' || str.substring(i,i+1) == '\n') ) {
        i = i - 1;
    }
    return str.substring(0,i+1);
}

/**
  * ���ڿ��� ��/�� ������ ����
  */
function trim(str) {
    return left_trim(right_trim(str));
}