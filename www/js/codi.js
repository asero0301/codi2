<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}



function checkAll() {
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == false) {
				document.getElementById('frm').elements[i].checked = true;
			}
		}
	}
}


function checkFree() {
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				document.getElementById('frm').elements[i].checked = false;
			}
		}
	}
}


function flashToJS(objectWidth,objectHeight,objSrc,objOption) {
	var docWrite = "";
	var tmpobjOption,objCount,i;
	if(objOption)
	{
		tmpobjOption 	= objOption.split("|");
		objCount			=	(tmpobjOption.length - 1);
		for(i=0;i<objCount;i++)
		{
			psi = (i+1);
			docWrite	= docWrite + "<PARAM name='"+tmpobjOption[i]+"' value='"+tmpobjOption[psi]+"'>\n";
			i +=1;
		}
	}	
	document.write("<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ");
	document.write("codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' ");
	document.write("width='"+objectWidth+"' height='"+objectHeight+"'>\n");
	document.write("<PARAM name='quality' value='high'>\n");
	document.write("<PARAM name='movie' value='"+objSrc+"'>\n");
	document.write("<PARAM name='wmode' value='transparent'>\n");
	document.write(docWrite);
	document.write("<EMBED src='"+objSrc+"' quality='high' ");
	document.write("pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' ");
	document.write("type='application/x-shockwave-flash' wmode='transparent' width='"+objectWidth+"' height='"+objectHeight+"'>\n");
	document.write("</EMBED>\n");
	document.write("</OBJECT>\n");
}




function NewWindow(mypage, myname, w, h, scroll) {
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
	win = window.open(mypage, myname, winprops)
	if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}


// main ajax search
function newXMLHttpRequest() {
	try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {}     //IE6  
	try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}  //IE5.5
	try { return new XMLHttpRequest(  ); } catch(e) {}                          //IE7, Firefox  
	alert("ajax error !!");
	return null;
}

function searchRequest() {
	var f = document.MainSearchFrm;

	//if(f.keyword.value == "") layer_show("");
	//else layer_show("show");
	
	searchHttp=newXMLHttpRequest();
	searchHttp.onreadystatechange = searchCallBack;
	/*
	searchHttp.open("GET", "/search/search_process.php?keyword="+encodeURIComponent(f.keyword.value), true);
	searchHttp.send("");
	*/

	var s_key_val = "";
	for ( i=0; i<f.s_key.length; i++ ) {
		if ( f.s_key[i].checked == true ) {
			s_key_val = f.s_key[i].value;
			break;
		}
	}

	var postString = "";
	postString += "s_key=" + escape(s_key_val);
	postString += "&keyword=" + encodeURIComponent(f.keyword.value);
	searchHttp.open("POST", "/search/search_auto_complete_process.php", true);
	searchHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	searchHttp.send(postString);

}

function searchCallBack() {	
	if (searchHttp.readyState == 4) {
		//layer_show("");
		if (searchHttp.status == 200) {
			if (searchHttp.responseText.length != 0 ) layer_show("show");
			//alert(searchHttp.responseText);
			document.getElementById("SearchResultArea").innerHTML = searchHttp.responseText;
			
		
		} else {
			alert(searchHttp.status);
		}
	}
}

function layer_show(kind) {
	if ( kind == "show" ) {
		SearchResultArea.style.display = "block";
		//MM_showHideLayers('SearchResultArea','','show');
	} else {
		SearchResultArea.style.display = "none";
		//MM_showHideLayers('SearchResultArea','','hide');
	}
}

function insertRequest() {
	var f = document.MainSearchFrm;
	  
	searchHttp=newXMLHttpRequest();
	searchHttp.onreadystatechange = searchCallBack;

	var s_key_val = "";
	for ( i=0; i<f.s_key.length; i++ ) {
		if ( f.s_key[i].checked == true ) {
			s_key_val = f.s_key[i].value;
			break;
		}
	}

	var postString = "";
	postString += "s_key=" + escape(s_key_val);
	postString += "&keyword=" + encodeURIComponent(f.keyword.value);
	searchHttp.open("POST", "/search/search_insert.php", true);
	searchHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	searchHttp.send(postString);
}

function AutoInput(idx) {
	document.MainSearchFrm.keyword.value = document.getElementById("r"+idx).innerText;
	document.MainSearchFrm.submit();
	insertRequest();	
}

function AjaxSearch() {
	insertRequest();
	//document.MainSearchFrm.submit();
}

function hiddenArea(){
	layer_show('hide'); 
}

function showArea(){
	if(document.MainSearchFrm.keyword.value !="") layer_show('show'); 
}

function cash_change(cash,flag) {
	var f = document.frm;
	if ( flag != 0 ) {
		f.p_current_cash.value = parseInt(f.p_current_cash.value) + ( parseInt(cash) * flag );
		document.getElementById("p_current_cash_area").innerHTML = f.p_current_cash.value;
	} else {
		f.p_current_cash.value = parseInt(f.p_current_cash.value) - parseInt(cash);
		document.getElementById("p_current_cash_area").innerHTML = f.p_current_cash.value;
	}
}

function id_check() { 
	window.open("/member/pop_id_check.php", "pop_id_check", "toolbar=no,location=no,status=no,menubar=no,width=300,height=146");
}

function zip_check(kind) { 
	window.open("/member/pop_zip_check.php?mem_kind="+kind, "pop_zip_check", "toolbar=no,location=no,status=no,menubar=no,width=300,height=180");
}

function zip_check_shop(kind,ob) { 
	window.open("/member/pop_zip_check.php?mem_kind="+kind+"&ob="+ob, "pop_zip_check_shop", "toolbar=no,location=no,status=no,menubar=no,width=300,height=180");
}

function find_IDPWD() {
	window.open("/member/pop_find_idpwd.php", "pop_find_idpwd", "toolbar=no,location=no,status=no,menubar=no,width=500,height=325");
}

function pop_codi_view(idx) {
	if ( !idx ) return;
	var f = document.frm;
	var pop = window.open("", "pop_codi_view", "toolbar=no,location=no,status=no,menubar=no,width=600,height=640,top=100,left=100");
	f.p_idx.value = idx;
	f.action = "/mypage/pop_codi_view.php";
	f.target = "pop_codi_view";
	f.submit();
	pop.focus();
}

// 코디 상세보기
function codi_view(idx) {
	if ( !idx ) return;
	location.href = "/product/product_view.php?p_idx="+idx;
	//alert(idx);
}

// 해당샵의 등록코디 보기
function shop_view(idx) {
	//location.href = "/product/shop_view.php?shop_idx="+idx;
	alert("해당 샵의 등록코디 리스트로...공사중");
}

function chg_main_categ(categ) {
	document.getElementById("categ_T_area").style.display = "none";
	document.getElementById("categ_B_area").style.display = "none";
	document.getElementById("categ_O_area").style.display = "none";
	document.getElementById("categ_U_area").style.display = "none";
	document.getElementById("categ_A_area").style.display = "none";
	document.getElementById("categ__area").style.display = "none";

	o_obj = document.getElementById("categ_"+categ+"_area");
	o_obj.style.display = "block";
}


function goMyCodi(kind) {
	if ( kind == "U" ) {
		location.href = "/mypage/comment.php";
	} else {
		location.href = "/mypage/Mcodi.php";
	}
}


function sendAll() {
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		pop_msg(str);
	}
}

function pop_member_info(mem_id) {
	alert(mem_id);
}

// 사용자가 경품받았는지 확인하는 팝업
function pop_deli_ok(idx) {
	var f = document.mem;

	var pop=window.open("","pop_deli_ok_target","top=10,left=10,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=500,height=485");

	f.gt_idx.value = idx;
	f.action = "/mypage/pop_deli_check.php";
	f.target = "pop_deli_ok_target";
	f.submit();
	pop.focus();
}

function pop_msg(idlist) {
	var f = document.popmsgfrm;

	var pop=window.open("","pop_msg_write_target","top=10,left=10,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=500,height=315");

	f.sel_id.value = idlist;
	f.action = "/msg/pop_msg_write.php";
	f.target = "pop_msg_write_target";
	f.submit();
	pop.focus();
	//alert(idlist + "에게 메시지를 보냅니다. 작업중 ~~");
}

function pop_msg_read(idx) {
	var f = document.frm;
	var pop = window.open("","pop_msg_read_target_"+idx,"top=10,left=10,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=500,height=365");
	f.msg_idx.value = idx;
	f.action = "/msg/pop_msg_read.php";
	f.target = "pop_msg_read_target_"+idx;
	f.submit();
	pop.focus();
}

function msg_all_del() {
	if ( !confirm("선택된 메시지를 삭제할까요?" ) ) {
		return;
	}
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		var f = document.frm;
		f.msg_idx.value = str;
		f.mode.value = "D";
		f.action = "/msg/msg_write_ok.php";
		f.target = "msg_frame";
		f.submit();
	}
}

function msg_all_forever() {
	if ( !confirm("선택된 메시지를 보관함으로 이동할까요?" ) ) {
		return;
	}
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		var f = document.frm;
		f.msg_idx.value = str;
		f.mode.value = "F";
		f.action = "/msg/msg_write_ok.php";
		f.target = "msg_frame";
		f.submit();
	}
}

function msg_del() {
	var f = document.frm;
	f.mode.value = "D";
	f.action = "/msg/msg_write_ok.php";
	f.target = "msg_frame";
	f.submit();
	self.close();
}

function msg_forever() {
	var f = document.frm;
	f.mode.value = "F";
	f.action = "/msg/msg_write_ok.php";
	f.target = "msg_frame";
	f.submit();
	self.close();
}

function msg_send() {
	var f = document.frm;
	if ( f.sel_id.value == "" ) {
		alert("수신자 ID가 없습니다");
		return;
	}
	if ( trim(f.msg_comment.value) == "" ) {
		alert("내용을 입력하세요.");
		f.msg_comment.focus();
		return;
	}
	f.action = "/msg/msg_write_ok.php";
	f.target = "msg_frame";
	f.submit();
	self.close();
}

function msg_reply(id) {
	var f = document.frm;
	f.sel_id.value = id;
	f.action = "/msg/pop_msg_write.php";
	f.target = "_self";
	f.submit();
}

function go_recv_msg() {
	location.href="/msg/msg_recv_list.php";
}

function go_send_msg() {
	location.href="/msg/msg_send_list.php";
}

function go_forever_msg() {
	location.href="/msg/msg_forever_list.php";
}

function go_write_msg() {
	location.href="/msg/msg_write.php";
}

function go_search_pos(kwd) {
	document.MainSearchFrm.keyword.value = kwd;
	AjaxSearch();
}

// 샵으로 검색한 결과
function go_shop_info(val) {
	location.href="/product/product_list.php?s_key=S&keyword="+val;
}

// 키워드로 검색한 결과
function go_kwd_info(val) {
	location.href="/product/product_list.php?s_key=K&keyword="+val;
}

// 카테고리로 검색한 결과
function go_categ_info(val) {
	location.href="/product/product_list.php?s_key=C&keyword="+val;
}


// 공지사항 리스트
function go_notice() {
	location.href="/board/notice_list.php";
}

// 공지사항 읽기
function go_notice_view(idx) {
	location.href="/board/notice_view.php?notice_idx="+idx;
}

// 샵 PR 리스트
function go_shop_pr() {
	location.href="/board/shop_pr_list.php";
}

// 샵 PR 읽기
function go_shop_pr_view(idx) {
	location.href="/board/shop_pr_view.php?pr_idx="+idx;
}

// 샵 PR 작성(전체)
function go_shop_pr_write(mode,idx) {
	location.href="/board/shop_pr_write.php?pr_idx="+idx+"&mode="+mode;
}

// 샵 PR 삭제
function go_shop_pr_del() {
	if ( !confirm("샵 PR을 삭제할까요?") ) return;
	var f = document.board_frm;
	f.mode.value = "D";
	f.target = "_self";
	f.action = "/board/shop_pr_write_ok.php";
	f.submit();
}

// 불량샵 신고 리스트
function go_bad_shop() {
	location.href="/board/bad_shop_list.php";
}

// 불량샵 신고 읽기
function go_bad_shop_view(idx) {
	location.href="/board/bad_shop_view.php?bad_idx="+idx;
}

// 불량샵 신고 작성(전체)
function go_bad_shop_write(mode,idx) {
	location.href="/board/bad_shop_write.php?bad_idx="+idx+"&mode="+mode;
}

// 불량샵 신고 삭제
function go_bad_shop_del() {
	if ( !confirm("삭제할까요?") ) return;
	var f = document.board_frm;
	f.mode.value = "D";
	f.target = "_self";
	f.action = "/board/bad_shop_write_ok.php";
	f.submit();
}

// 당첨자 확인 리스트
function go_lucky_list() {
	location.href="/board/luck_list.php";
}

// ucc 리스트(전체)
function go_ucc(categ) {
	location.href="/board/ucc_list.php?ucc_categ="+categ;
}

// ucc 읽기(전체)
function go_ucc_view(idx) {
	location.href="/board/ucc_view.php?ucc_idx="+idx;
}

// ucc 작성(전체)
function go_ucc_write(mode,categ,idx) {
	location.href="/board/ucc_write.php?ucc_idx="+idx+"&mode="+mode+"&categ="+categ;
}

// ucc 삭제
function go_ucc_del() {
	if ( !confirm("UCC를 삭제할까요?\n삭제하면 얻은점수는 반환됩니다.") ) return;
	var f = document.board_frm;
	f.mode.value = "D";
	f.target = "_self";
	f.action = "/board/ucc_write_ok.php";
	f.submit();
}

// 게시판에서 검색
function go_board_search() {
	document.board_frm.submit();
}


// 전체랭킹, 코디평가 순위
function total_codi_ranking() {
	location.href = "/product/codi_list.php";
}

// 베스트샵 - more
function go_best_shop() {
	location.href = "/product/best_shop_list.php";
}

// 인증샵 리스트
function go_auth_shop() {
	location.href = "/product/auth_shop_list.php";
}


// 이용자 안내
function go_user_guide() {
	location.href = "/info/user_guide.php";
}

// 샵 이용자 안내
function go_shop_guide() {
	location.href = "/info/shop_guide.php";
}

// FAQ
function go_faq() {
	location.href = "/info/faq.php";
}


// 오늘의 추천코디 레이어 보이기/숨기기
function main_today_recom_page_view(t, p) {
	if ( p < 1 || p > t ) return;
	for ( var i=1; i<=t; i++ ) {
		obj = document.getElementById("main_today_recom_"+i);
		obj.style.display = "none";
	}

	document.getElementById("main_today_recom_"+p).style.display = "block";
}

// (서브)오늘의 추천코디 레이어 보이기/숨기기
function sub_today_recom_page_view(t, p) {
	if ( p < 1 || p > t ) return;
	for ( var i=1; i<=t; i++ ) {
		obj = document.getElementById("sub_codi_of_today_area_"+i);
		obj.style.display = "none";
	}

	document.getElementById("sub_codi_of_today_area_"+p).style.display = "block";
}

// 샵회원이 당첨자를 확인하는 팝업을 띄운다.
function gift_result_view(idx) {
	//window.open("/mypage/pop_gift_view.php?p_e_idx="+idx,"pop_gift_result_target","top=10,left=10,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=600,height=500");

	if ( !idx ) return;
	var f = document.gift_frm;
	var pop = window.open("", "pop_gift_result_target", "toolbar=no,location=no,status=no,menubar=no,width=600,height=432,top=100,left=100");
	f.p_e_idx.value = idx;
	f.action = "/mypage/pop_gift_view.php";
	f.target = "pop_gift_result_target";
	f.submit();
	pop.focus();
}
//-->