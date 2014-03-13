<!--


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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




function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


function ShowTable(stat) {
	var stat;
	//alert(stat);
	if(stat==1) {
		document.all['Menu'].style.visibility = 'visible';
	} else {
		document.all['Menu'].style.visibility = 'hidden';
	}
}





	var backName;
	function toggleOneFolder(code){
		for ( i = 0; i < 2; i++ ) {
			var obj = document.getElementById("opt_" + i);
			var img = document.getElementById("swf_" + i);
			
			if ( code == i ) {
				obj.style.display = "block";
				img.style.display = "block";
			}
			else {
			 	obj.style.display = "none";
			 	img.style.display = "none";
			} 
		}	
	}
	
	
	
function getNavigatorInfo() {
	if (navigator.appVersion.indexOf("MSIE")!=-1){
		temp=navigator.appVersion.split("MSIE");
		version=parseFloat(temp[1]);
		if (version>=5.5) return "IE";
	} else if (navigator.userAgent.indexOf("Firefox")!=-1){
		var versionindex=navigator.userAgent.indexOf("Firefox")+8;
		if (parseInt(navigator.userAgent.charAt(versionindex))>=1) return "FF";
	} else if(navigator.userAgent.indexOf("Opera")!=-1){
		var versionindex=navigator.userAgent.indexOf("Opera")+6;
		if (parseInt(navigator.userAgent.charAt(versionindex))>=8) return "OP";
	} else if (navigator.appName=="Netscape" && parseFloat(navigator.appVersion)>=4.7) return "NA";
}

function getOSInfoStr() {
    var ua = navigator.userAgent;

    if(ua.indexOf("NT 6.0") != -1) return "Windows Vista/Server 2008";
    else if(ua.indexOf("NT 5.2") != -1) return "Windows Server 2003";
    else if(ua.indexOf("NT 5.1") != -1) return "Windows XP";
    else if(ua.indexOf("NT 5.0") != -1) return "Windows 2000";
    else if(ua.indexOf("NT") != -1) return "Windows NT";
    else if(ua.indexOf("9x 4.90") != -1) return "Windows Me";
    else if(ua.indexOf("98") != -1) return "Windows 98";
    else if(ua.indexOf("95") != -1) return "Windows 95";
    else if(ua.indexOf("Win16") != -1) return "Windows 3.x";
    else if(ua.indexOf("Windows") != -1) return "Windows";
    else if(ua.indexOf("Linux") != -1) return "Linux";
    else if(ua.indexOf("Macintosh") != -1) return "Macintosh";
    else return "";
}

function SSN_Check(obj1,obj2) {
  ssn = obj1.value+"-"+obj2.value

  var ssn_b = ssn.substr(0, 6);
  var ssn_e = ssn.substr(7, 7);

  if ( ssn_b.length < 6 || ssn_e.length < 7) {
    alert ("주민등록번호 길이가 정확하지 않습니다." + ssn_b + ":" + ssn_e);
    obj1.focus();
    return false;
  }

  var strA, strB, strC, strD, strE, strF, strG, strH, strI, strJ, strK, strL, strM, strN, strO;
  var nCalA, nCalB, nCalC; 

  strA = ssn.substr(0, 1);
  strB = ssn.substr(1, 1);
  strC = ssn.substr(2, 1);
  strD = ssn.substr(3, 1);
  strE = ssn.substr(4, 1);
  strF = ssn.substr(5, 1);
  strG = ssn.substr(7, 1);
  strH = ssn.substr(8, 1);
  strI = ssn.substr(9, 1);
  strJ = ssn.substr(10, 1); 
  strK = ssn.substr(11, 1);
  strL = ssn.substr(12, 1);
  strM = ssn.substr(13, 1);
  
  strO = strA*2 + strB*3 + strC*4 + strD*5 + strE*6 + strF*7 + strG*8 + strH*9 + strI*2 + strJ*3 + strK*4 + strL*5;

  nCalA = eval(strO);
  nCalB = nCalA % 11;
  nCalC = 11 - nCalB;
  nCalC = nCalC % 10;
  
  strv = '19';
  strw = ssn.substr(0, 2);
  strx = ssn.substr(2, 2);
  stry = ssn.substr(4, 2);

  strz = strv + strw;
  
  if ((strz % 4 == 0) && (strz % 100 != 0) || (strz % 400 == 0)) yunyear = 29;
  else yunyear = 28;

  if ((strx <= 0) || (strx > 12)) {
    alert("생년월일이 맞지 않습니다.");
    obj1.focus();
    return false;
  }

  if ((strx == 1 || strx == 3 || strx == 5 || strx == 7 || strx == 8 || strx == 10 || strx == 12) && (stry > 31 || stry <= 0)) {
    alert("생년월일이 맞지 않습니다.");
    obj1.focus();
    return false;
  }

  if ((strx == 4 || strx == 6 || strx == 9 || strx == 11) && (stry > 30 || stry <= 0)) {
    alert("생년월일이 맞지 않습니다.");
    obj1.focus();
    return false;
  }

  if (strx == 2 && (stry > yunyear || stry <= 0)) {
    alert(strz + "생년월일이 맞지 않습니다." + yunyear);
    obj1.focus();
    return false;
  }
  
  if (!((strG == 1) || (strG == 2) || (strG == 3) || (strG ==4))) {
    alert("주민등록번호 뒷자리의 시작은 1 ~ 4 이여야 합니다.");
    obj1.focus();
    return false;
  }

  if ( nCalC != strM ) {
    alert("주민등록번호가 규칙에 어긋납니다.");
    obj1.focus();
    return false;
  } 

  return true;
}

function isNumber(obj) {
  var str = obj.value;

  if(str.length == 0) {
    //alert("숫자로 적어 주세요");
    //obj.focus();
    return false; 
  }

  for(var i=0; i < str.length; i++) {
    if(!('0' <= str.charAt(i) && str.charAt(i) <= '9')) {
      //alert("숫자로 적어 주세요");
      //obj.focus(); 
      return false;
    } //if
  }// for 
  
  return true;
}

function isSame(obj1, obj2) {
  var str1 = obj1.value;
  var str2 = obj2.value;

  if(str1.length == 0) {
    //alert("비밀번호를 적어 주세요");
    //obj1.focus(); 
    return false; 
  }

  if(str2.length == 0) {
    //alert("비밀번호를 적어 주세요");
    //obj2.focus(); 
    return false; 
  }

  if(str1 != str2) {
    //alert("비밀번호가 일치하지 않습니다.");
    //obj1.focus();
    return false; 
  }

  if(str1 == str2) return true; 

  return false;
}

function isEmail(email) {
  //email = obj.value;

  if(!checkEmail(email)) {
    //alert("올바른 email주소가 아닙니다.");
    //obj.focus();
    return false;
  } 
  
  return true;
}

function checkEmail(emailStr) {
  if (emailStr.length == 0) return true;

  var emailPat     = /^(.+)@(.+)$/;
  var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
  var validChars   = "\[^\\s" + specialChars + "\]";
  var quotedUser   = "(\"[^\"]*\")";
  var ipDomainPat  = /^(\d{1,3})[.](\d{1,3})[.](\d{1,3})[.](\d{1,3})$/;
  var atom         = validChars + '+';
  var word         = "(" + atom + "|" + quotedUser + ")";
  var userPat      = new RegExp("^" + word + "(\\." + word + ")*$");
  var domainPat    = new RegExp("^" + atom + "(\\." + atom + ")*$");
  var matchArray   = emailStr.match(emailPat);

  if (matchArray == null) return false;

  var user   = matchArray[1];
  var domain = matchArray[2];
  if (user.match(userPat) == null) return false;

  var IPArray = domain.match(ipDomainPat);
  if (IPArray != null) {
    for (var i = 1; i <= 4; i++) {
      if (IPArray > 255) return false;
    }

    return true;
  }

  var domainArray = domain.match(domainPat);
  if (domainArray == null) return false;

  var atomPat = new RegExp(atom,"g");
  var domArr  = domain.match(atomPat);
  var len     = domArr.length;

  if ((domArr[domArr.length-1].length < 2) || (domArr[domArr.length-1].length > 3)) return false;

  if (len < 2) return false;

  return true;
}

function isID(obj) {
  var str = obj.value ;

  if(str.length == 0) {
    //alert("아이디를 입력해 주세요.");
    //obj.focus();
    return false;
  }

  str = str.toUpperCase();
  if(!('A' <= str.charAt(i) && str.charAt(i) <= 'Z')) {
    //alert("영문(대/소문자), 숫자외에는 넣을수 없고\n\n숫자로된 아이디도 사용할수 없습니다.");
    //obj.focus();
    return false; 
  }

  if(str.length < 4) {
    //alert("아이디를 4자리 이상 입력해야 합니다.");
    //obj.focus();
    return false;
  }

  for(var i=1; i < str.length; i++) {
    if(!(('A' <= str.charAt(i) && str.charAt(i) <= 'Z') || ('0' <= str.charAt(i) && str.charAt(i) <= '9') || (str.charAt(i) == '_'))) {
      //alert("영문(소문자)/숫자 이외에 넣을수 없습니다.");
      //obj.focus();
      return false; 
    }
  }

  return true;
}

function isPWD(obj) {
  var str = obj.value;

  if(str.length == 0) {
    //alert("비밀번호를 입력해 주세요.");
    //obj.focus();
    return false;
  }

  str = str.toUpperCase();
  if(str.length < 6) {
    //alert("비밀번호는 8자리 이상 입력해야 합니다.");
    //obj.focus();
    return false;
  }
/*
  for(var i=1; i < str.length; i++) {
    if(!(('A' <= str.charAt(i) && str.charAt(i) <= 'Z') || ('0' <= str.charAt(i) && str.charAt(i) <= '9') || (str.charAt(i) == '_'))) {
      alert("영문/숫자 이외에 넣을수 없습니다.");
      obj.focus();
      return false; 
    }
  }
*/
  return true;
}

function isHangul(obj, msg) {
  var str   = obj.value;
  str = str.toUpperCase();

  for(i=0; i<str.length; i++) {
    if(!((str.charCodeAt(i) > 0x3130 && str.charCodeAt(i) < 0x318F) || (str.charCodeAt(i) >= 0xAC00 && str.charCodeAt(i) <= 0xD7A3))) {
      //alert(msg + "은(는) 한글로 입력하셔야 됩니다.");
      //obj.focus();
      return false;
    }
  }

  return true;
}

function updateChar2(maxlength,cmt,spid){
	var strCount = 0;
	var tempStr, tempStr2;

	for(i = 0;i < cmt.value.length;i++) {
		tempStr = cmt.value.charAt(i);

		if(escape(tempStr).length > 4) strCount += 2;
		else strCount += 1 ;
	}

	if (strCount > maxlength) {
		alert("글자수 " + maxlength + "byte를 넘을수 없습니다.");
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

function trimSpecialchar() {
	var f = document.MainSearchFrm;
	var str = f.keyword.value;
	f.keyword.value = str.replace(/[<>\'\"]/g, '');
}

function han_length(str) {
	strCount = 0;
	for(i = 0;i < str.length;i++) {
		tempStr = str.charAt(i);

		if(escape(tempStr).length > 4) strCount += 2;
		else strCount += 1 ;
	}
	return strCount;
}

function addItem(obj, val, text) {
	obj.options[obj.length] = new Option(text, val);
}

function delItem(obj) {
	obj.length = 1;
}

function trim(s) {
	s += ''; // 숫자라도 문자열로 변환
	return s.replace(/^\s*|\s*$/g, '');
}

// 이미지 리사이즈
function img_resize(wid){
	for ( var i=0; i<document.images.length; i++ ) {
		//document.write(i+":"+document.images[i].id+"<br>");
		var obj = document.images[i].id;
		if ( obj.substr(0,7) == "big_pic" ) {
			pic = document.getElementById(obj);
			if ( pic.width > wid ) {
				var ratio;
				ratio = wid / pic.width;
				pic.height = pic.height * ratio;
				pic.width = wid;
			}
		}
	}
}

function img_resize_ratio(is) {
	//return { Width : is.Width, Height : is.Height };
	w = is.Width;
	h = is.Height;
	new_w = 0;
	new_h = 0;
	conwid = 350;
	conhei = 308;

	if ( w > conwid || h > conhei ) {	// width, height 다 큰경우
		w1 = conwid;
		h1 = h*conwid/w;
		w2 = w*conhei/h;
		h2 = conhei;
		if ( w1 <= conwid && h1 <= conhei ) {
			if ( w1 > w2 && h1 > h2 ) {
				new_w = w1; new_h = h1;
			} else {
				if ( w2 <= conwid && h2 <= conwid ) {
					new_w = w2; new_h = h2;
				} else {
					new_w = w1; new_h = h1;
				}
			}
		} else {
			new_w = w2; new_h = h2;
		}
	} else {	// width, height 다 작은 경우
		new_w = w; new_h = h;
	}
	return { Width : new_w, Height : new_h };
}

function GetImageSize(ElemId) {
	with ( TmpImg = document.body.appendChild(document.createElement('img')) ) {
		src = ElemId.src;
		var Width = offsetWidth;
		var Height = offsetHeight;
	}

	document.body.removeChild(TmpImg);
	return { Width : Width, Height : Height };
}
-->