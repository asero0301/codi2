/*=======================================
// jsCalendar
// textbox에 연계해서 날짜를 입력한다
// 작성일 : 2008-02-25
// 수정일 : 2008-02-25 10 AM
// 수정일 : 2008-06-03 
// 수정일 : 2008-07-07 
// 공대여자는 이쁘다를 나타내야만 쓸 수 있습니다.
// 이 파일은 수정해서 재배포 할 수 없습니다!
// 내가 사용하지 못하도록한 사람은 사용할 수 없습니다.
// 만든이 : mins,공대여자 
// 홈페이지  : www.mins01.com

#js_calendar 와 다른점
네이밍 반식이 바뀌었고
CSS로 99% 디자인이 가능합니다.
버튼은 더이상 기본으로 생성되지 않습니다.(수동으로 지정해주셔야합니다.)

#동작 : 
open 버튼을 누르면 달력이 보인다.
년,월을 변경할 수 있다
날짜를 선택하면, 해당 textbox의 onchage 이밴트에 등록된 스크립트를 실행한다(없으면 무시~)

#사용법 : 
<script src="js_date.js" type="text/javascript" charset="utf-8" ></script>
<script src="jsCalendar.js" type="text/javascript" charset="utf-8" ></script>
<link rel="stylesheet" type="text/css" href="jsCalendar.css" charset="utf-8" />

var calendar = new jsCalendar([TextBox],[Button]);
[TextBox] : 값이 전달되는 텍스트 박스 (필수)
[Button] : 달력 오픈 버튼 (선택)(지정 안할 경우 텍스트박스가 버튼역활도 함)
#예 :
var cal0 = new jsCalendar(document.getElementById('ipt00'),document.getElementById('btn00'));

#설정
var calendar = new jsCalendar([TextBox],[Button]);
calendar.cfg.startWDay:0 //0(기존값):일요일부터시작,1:월요일,2:화요일~6:토요일
calendar.cfg.useOtherMonthDay:true //true:해당 월 이외의 날짜도 표시, false:해당 월의 날짜만 표시
calendar.cfg.wDayType:'kr' //요일글짜: kr:한글, cn:한문, enShort:영어악어 , en:영어
calendar.cfg.dateFormat:'Y-m-d' //날짜표현식
calendar.cfg.language:'kr' //언어형식, kr:년,월,일 , en:영어, cn:한문
calendar.cfg.mLeft:0 //left 수정값
calendar.cfg.mTop:0 //top 수정값
calendar.cfg.onSelectFN:function(date){thisC.targetElement.value = date;} //날짜를 선택할 때 동작할 함수 
   //임의로 지정할 수 있습니다.
calendar.cfg.limitTSTMPST:null // 최소날짜 제한일(Date.getTime()형식), 직접 지정보다는 setPeriod()를 사용
calendar.cfg.limitTSTMPED:null // 최대날짜 제한일(Date.getTime()형식) 직접 지정보다는 setPeriod()를 사용  
calendar.cfg.onSelectFN = function(date){alert(date);}
calendar.cfg.divClassName = 'divLayout' //최외각 div의 class 이름

calendar.setPeriod([최소날짜 제한일],[최대날짜 제한일]); 
//[최소날짜 제한일] : '2008-10-21' 처럼 지정, null로 지정하면 제한이 사라진다.
//[최대날짜 제한일] : '2008-10-21' 처럼 지정, null로 지정하면 제한이 사라진다.

#제한
.js 파일은 수정할 수 없습니다.
.css는 원하는 형태로 수정해서 사용하세요.

#연계
js_date.js : 날짜 계산을 위해서 사용
jsCalendar.css : CSS파일

//=======================================*/

function jsCalendar(targetElement,buttonElement){
	var thisC = this;
	this.targetElement = null; //대상 textbox
	this.buttonElement = null; //버튼 엘레맨트	
	this.selectedValue = null; //선택된 값, textbox의 값
	this.selectedDate = null; //선택된 값의 Date형
	this.todayValue = null; //오늘의 값

	this.calendar = null; //칼렌더

	this.upDownTimer = null; //날짜 증가,감소 타이머

	this.aClose = null; //메뉴 : 닫기
	this.autoCloseTimer = null; //자동닫기 타이머
	this.over = null; //마우스 오버 감지

	this.cfg = {
		 startWDay:0 //0(기존값):일요일부터시작,1:월요일,2:화요일~6:토요일
		,useOtherMonthDay:true //true:해당 월 이외의 날짜도 표시, false:해당 월의 날짜만 표시
		,wDayType:'kr' //요일글짜: kr:한글, cn:한문, enShort:영어악어 , en:영어
		,dateFormat:'Y-m-d' //날짜표현식
		,language:'kr' //언어형식, kr:년,월,일 , en:영어, cn:한문
		,mLeft:0 //left 조정값
		,mTop:0 //top 조정값
		,autoClose:true //자동 닫기 설정, 포커스를 잃으면 자동으로 사라진다.
		,autoCloseTimeout:200 //자동 닫기에 걸리는 시간, 1000가 1초 지정된 시간이 충분하지 않으면 연결된 onChange 함수가 동작 못할 수 있다.
		,upDownTimeout:300 //날짜 증가,감소 반복딜레이
		,limitTSTMPST:null // 최소날짜 제한일(Date.getTime()형식), 직접 지정보다는 setPeriod()를 사용
		,limitTSTMPED:null // 최대날짜 제한일(Date.getTime()형식) 직접 지정보다는 setPeriod()를 사용
		,onSelectFN:function(date){thisC.targetElement.value = date;}
		,divClassName:'divLayout' //최외각 div의 class 이름
	};
	this.wDays ={
		 enShort:['SUN','MON','TUE','WED','THU','FRI','SAT'] //영어 약어형 
		,en:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] //영어 풀네임
		,kr:['일','월','화','수','목','금','토'] //한글
		,cn:['日','月','火','水','木','金','土'] //한문
	}
	this.dateWord ={
		 kr:{year:'년',month:'월',date:'일',today:'오늘',close:'닫기'}
		,en:{year:'year',month:'month',date:'date',today:'Today',close:'close'}
		,cn:{year:'年',month:'月',date:'日',today:'今日',close:'close'}
	}	
	this.jsCalendar(targetElement,buttonElement); //생성자
}
jsCalendar.prototype.jsCalendar = function(targetElement,buttonElement){ //생성자
	var thisC = this;
	this.targetElement = targetElement;
	if(!this.targetElement){
		alert("지정된 대상이 없습니다");
		return false;
	}	
	this.selectedDate = new Date();
	if(this.targetElement.value)	this.selectedDate.setTime(this.selectedDate.str_setTime(this.targetElement.value));
	this.selectedValue = this.selectedDate.date(this.cfg.dateFormat);
	
	//=== 버튼처리
	if(!buttonElement)	this.buttonElement = this.targetElement
	else 	this.buttonElement = buttonElement;
	this.buttonElement.onclick = function(){thisC.toggleCalendar()}
}
jsCalendar.prototype.showCalendar = function(){
	if(this.targetElement.value)	this.selectedDate.str_setTime(this.targetElement.value);
	this.selectedValue = this.selectedDate.date(this.cfg.dateFormat);	
	var dTMP = new Date(); 
	this.todayValue = dTMP.date(this.cfg.dateFormat);	
	
	var scrollHeight = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight); 
	var scrollWidth = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth); 

	var targetRect = this.getBounds(this.targetElement)
//	if(!this.calendar ){
		this.calendar = this.createCalendar(this.selectedDate.getFullYear(),(this.selectedDate.getMonth()+1));
		document.body.appendChild(this.calendar);
		this.calendar.style.left = targetRect.left+this.cfg.mLeft+'px';
		this.calendar.style.top = targetRect.top+this.cfg.mTop+targetRect.height+'px';
//	}else{
		this.changeCalendar(this.selectedDate.getFullYear(),(this.selectedDate.getMonth()+1));
//	}
	//===위치 재설정
	/*
	var calendarRect = this.getBounds(this.calendar);
	if(scrollHeight < (calendarRect.top +calendarRect.height)){
		this.calendar.style.top = this.cfg.mLeft+(calendarRect.top - calendarRect.height - targetRect.height)+'px';
	}
	if(scrollWidth < (calendarRect.left +calendarRect.width)){
		this.calendar.style.left = this.cfg.mTop+(scrollWidth-calendarRect.width)+'px';
	}	
*/
	this.calendar.style.display='';

	//===== 닫기 버튼에 포커스
	if(this.cfg.autoClose){ //자동 닫기를 사용할 때
		this.aClose.focus();	
	}
}
jsCalendar.prototype.autoCloseStopCalendar = function(){
	this.over = 0;
	if(this.autoCloseTimer != null){
		clearTimeout(this.autoCloseTimer);
	}
}
jsCalendar.prototype.autoCloseStartCalendar = function(){
	var thisC = this;
	var fn = function(){ if(thisC.over <=0 ) thisC.hideCalendar(); }
	this.autoCloseTimer = setTimeout(fn,this.cfg.autoCloseTimeout);
}
jsCalendar.prototype.hideCalendar = function(){
	if(this.calendar){
		this.calendar.style.display='none';
		clearTimeout(this.autoCloseTimer);
		clearInterval(this.upDownTimer);
	}
}
jsCalendar.prototype.toggleCalendar = function(){
	if(this.calendar){
		if(this.calendar.style.display=='none')	this.showCalendar();
		else	this.hideCalendar();
	}else{
		this.showCalendar();
	}
}
jsCalendar.prototype.onSelectDate = function(date){ //달력을 만든다.
	this.cfg.onSelectFN(date);
	if(this.targetElement.onchange){this.targetElement.onchange();}
	this.hideCalendar();
}
jsCalendar.prototype.createCalendar = function(year,month){ //달력을 만든다.
	this.divLayout = this.createCalendarLayout();
	this.taFrame = this.createCalendarFrame(year,month);
	var taHead = this.createCalendarHead(year,month);
	this.taBody = this.createCalendarBody(year,month);		
	var taFoot = this.createCalendarFoot(year,month);
	
	this.taFrame.taFrameTrHeadTdHead.appendChild(taHead);
	this.taFrame.taFrameTrBodyTdBody.appendChild(this.taBody);
	this.taFrame.taFrameTrFootTdFoot.appendChild(taFoot);
	
	this.divLayout.appendChild(this.taFrame);
	
	return this.divLayout;
}
jsCalendar.prototype.changeCalendar = function(year,month){ //달력을 만든다.
	var d = new Date(year,(month-1),1);
	var y = d.getFullYear();
	var m = (d.getMonth()+1);
	this.taFrame.taFrameTrBodyTdBody.removeChild(this.taBody);
	this.taBody = this.createCalendarBody(y,m);
	this.taFrame.taFrameTrBodyTdBody.appendChild(this.taBody );
	this.iptYear.value=y;
	this.iptMonth.value=m;
}
jsCalendar.prototype.onBTNOpen = function(){ //달력을 만든다.
	this.toggleCalendar();
}
jsCalendar.prototype.onBTNToday = function(){ //달력을 만든다.
	var d = new Date();
	var y = d.getFullYear();
	var m = (d.getMonth()+1);
	if(isNaN(y) || isNaN(m) ){
		alert("잘못된 날짜입니다.");
		return false;
	}
	this.changeCalendar(y,m);
}
jsCalendar.prototype.onBTNYearDown = function(year,month){ //달력을 만든다.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("잘못된 날짜입니다.");
		return false;
	}
	this.changeCalendar((y-1),m);
}
jsCalendar.prototype.onBTNYearUp = function(year,month){ //달력을 만든다.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("잘못된 날짜입니다.");
		return false;
	}
	this.changeCalendar((y+1),m);
}
jsCalendar.prototype.onBTNMonthDown = function(year,month){ //달력을 만든다.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("잘못된 날짜입니다.");
		return false;
	}
	this.changeCalendar(y,(m-1));
}
jsCalendar.prototype.onBTNMonthUp = function(year,month){ //달력을 만든다.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("잘못된 날짜입니다.");
		return false;
	}
	this.changeCalendar(y,(m+1));
}
jsCalendar.prototype.createCalendarLayout = function(){ //달력의 DIV 레이아웃 부분
	var divLayout = document.createElement('div');
	divLayout.className = this.cfg.divClassName || 'divLayout';
	return divLayout;
}
jsCalendar.prototype.createCalendarFrame = function(year,month){ //달력의 프레임 부분
	//========== 프레임 테이블 생성
	var taFrame = document.createElement('table');
	taFrame.border="0" ;
	taFrame.cellSpacing="0" ;
	taFrame.cellPadding="0";
	taFrame.className='taFrame';
	//=== tr
	var taFrameTrHead = taFrame.insertRow(-1);
	taFrameTrHead.className='taFrameTrHead';
	var taFrameTrBody = taFrame.insertRow(-1);
	taFrameTrBody.className='taFrameTrBody';
	var taFrameTrFoot = taFrame.insertRow(-1);
	taFrameTrFoot.className='taFrameTrFoot';
	taFrame.taFrameTrHead = taFrameTrHead;
	taFrame.taFrameTrBody = taFrameTrBody;
	taFrame.taFrameTrFoot = taFrameTrFoot;
	//===td
	var taFrameTrHeadTdHead = taFrameTrHead.insertCell(0);
	taFrameTrHeadTdHead.className='taFrameTrHeadTdHead';
	var taFrameTrBodyTdBody = taFrameTrBody.insertCell(0);
	taFrameTrBodyTdBody.className='taFrameTrBodyTdBody';
	var taFrameTrFootTdFoot = taFrameTrFoot.insertCell(0);
	taFrameTrFootTdFoot.className='taFrameTrFootTdFoot';
	taFrame.taFrameTrHeadTdHead = taFrameTrHeadTdHead;
	taFrame.taFrameTrBodyTdBody = taFrameTrBodyTdBody;
	taFrame.taFrameTrFootTdFoot = taFrameTrFootTdFoot;	
	//=== for test
	//taFrameTrHeadTdHead.innerHTML = "해더부분";
	
	return taFrame;
	
}
jsCalendar.prototype.createCalendarHead = function(year,month){ //달력의 머리, 메뉴부분
	var thisC = this;
	//========== 메뉴 테이블 생성
	var taHead = document.createElement('table');
	taHead.border="0" ;
	taHead.cellSpacing="0" ;
	taHead.cellPadding="0";
	taHead.className='taHead';
	//=== tr
	var taHeadTr0 = taHead.insertRow(-1);
	taHeadTr0.className='taHeadTr0';
	var taHeadTr1 = taHead.insertRow(-1);
	taHeadTr1.className='taHeadTr1';
	//===td
	var taHeadTr0Td0 = taHeadTr0.insertCell(0);
	taHeadTr0Td0.className='taHeadTr0Td0';
	var taHeadTr1Td0 = taHeadTr1.insertCell(0);
	taHeadTr1Td0.className='taHeadTr1Td0';
	//=== 내용넣기
	//=오늘로
	var aToday = document.createElement('a');
	aToday.className = "aToday";	
	aToday.href='javascript:void(0);';
	aToday.onmousedown=function(){thisC.over++;}
	aToday.onmouseup=function(){thisC.onBTNToday();thisC.aClose.focus(); }	
	aToday.innerHTML = this.dateWord[this.cfg.language].today;
	aToday.title = this.dateWord[this.cfg.language].today;
	taHeadTr0Td0.appendChild(aToday);
	//=닫기	
	var aClose = document.createElement('a');
	aClose.className = "aClose";
	aClose.href='javascript:void(0);';
	aClose.onclick=function(){thisC.hideCalendar();}
	aClose.innerHTML = "X";
	aClose.title = this.dateWord[this.cfg.language].close;
	taHeadTr0Td0.appendChild(aClose);	
	if(this.cfg.autoClose){
		aClose.onfocus=function(){thisC.autoCloseStopCalendar();}
		aClose.onblur=function(){thisC.autoCloseStartCalendar();}	
	}
	this.aClose = aClose;
	//=년
	var iptYear = document.createElement('input');
	iptYear.size=4;
	iptYear.className = "iptYear";
	iptYear.value = year;
	iptYear.readOnly = true;
	taHeadTr1Td0.appendChild(iptYear);	
	this.iptYear = iptYear;
	//=a링크 기본형
	var aSTD = document.createElement('a');
	aSTD.className = "aButton";	
	aSTD.href='javascript:void(0);';
	//=년도 잠소,증가
	var aYearDown = aSTD.cloneNode(true);
	aYearDown.innerHTML = '▼';
	var aYearUp = aSTD.cloneNode(true);
	aYearUp.innerHTML = '▲';	
	taHeadTr1Td0.appendChild(aYearDown);	
	taHeadTr1Td0.appendChild(aYearUp);	
	taHeadTr1Td0.appendChild(document.createTextNode(this.dateWord[this.cfg.language].year+' '));	
	//=월
	var iptMonth = document.createElement('input');
	iptMonth.size=2;
	iptMonth.className = "iptMonth";
	iptMonth.value = month;
	iptMonth.readOnly = true;
	taHeadTr1Td0.appendChild(iptMonth);	
	this.iptMonth = iptMonth;	
	//=월 잠소,증가
	var aMonthDown = aSTD.cloneNode(true);
	aMonthDown.innerHTML = '▼';
	var aMonthUp = aSTD.cloneNode(true);
	aMonthUp.innerHTML = '▲';	
	taHeadTr1Td0.appendChild(aMonthDown);	
	taHeadTr1Td0.appendChild(aMonthUp);		
	taHeadTr1Td0.appendChild(document.createTextNode(this.dateWord[this.cfg.language].month));	
	//=== 이밴트

		aYearDown.onmousedown = function(){
			thisC.over++;
			thisC.onBTNYearDown(iptYear.value,iptMonth.value); 
			var fn = function(){ thisC.onBTNYearDown(iptYear.value,iptMonth.value); }
			thisC.upDownTimer = setInterval(fn,thisC.cfg.upDownTimeout);
			thisC.aClose.focus();
		}
		aYearUp.onmousedown = function(){
			thisC.over++;
			thisC.onBTNYearUp(iptYear.value,iptMonth.value); 
			var fn = function(){ thisC.onBTNYearUp(iptYear.value,iptMonth.value); }
			thisC.upDownTimer = setInterval(fn,thisC.cfg.upDownTimeout);
			thisC.aClose.focus();
		}
		aMonthDown.onmousedown = function(){
			thisC.over++;
			thisC.onBTNMonthDown(iptYear.value,iptMonth.value); 
			var fn = function(){ thisC.onBTNMonthDown(iptYear.value,iptMonth.value); }
			thisC.upDownTimer = setInterval(fn,thisC.cfg.upDownTimeout);
			thisC.aClose.focus();
		}	
		aMonthUp.onmousedown = function(){
			thisC.over++;
			thisC.onBTNMonthUp(iptYear.value,iptMonth.value); 
			var fn = function(){ thisC.onBTNMonthUp(iptYear.value,iptMonth.value); }
			thisC.upDownTimer = setInterval(fn,thisC.cfg.upDownTimeout);
			thisC.aClose.focus();
		}			
		var eventMouseUp = function(){clearInterval(thisC.upDownTimer);	thisC.aClose.focus();}

	aYearDown.onmouseup = eventMouseUp;
	aYearUp.onmouseup =eventMouseUp;
	aMonthDown.onmouseup = eventMouseUp;
	aMonthUp.onmouseup = eventMouseUp;
	aYearDown.onmouseout = eventMouseUp;
	aYearUp.onmouseout =eventMouseUp;
	aMonthDown.onmouseout = eventMouseUp;
	aMonthUp.onmouseout = eventMouseUp;	
	

	return taHead;
}
jsCalendar.prototype.createCalendarFoot = function(year,month){ //달력의 바닥글
//제거 수정 금지!, Don't Remove! AND Don't Modify
	//========== 메뉴 테이블 생성
	var taFoot = document.createElement('table');
	taFoot.border="0" ;
	taFoot.cellSpacing="0" ;
	taFoot.cellPadding="0";
	taFoot.className='taFoot';
	//=== tr
	var taFootTr0 = taFoot.insertRow(-1);
	taFootTr0.className='taFootTr0';
	//===td
	var taFootTr0Td0 = taFootTr0.insertCell(0);
	taFootTr0Td0.className='taFootTr0Td0';
	//=== 내용넣기
	//=링크
	var aLink = document.createElement('a');
	aLink.className = "aLink";	
	aLink.href='http://www.mins01.com';
	aLink.target='_blank';
	aLink.onclick=function(){alert("공대여자(만든이) 홈페이지 :");}
	aLink.innerHTML = "minsHompage";
	aLink.title = "만든이 홈페이지";
	taFootTr0Td0.appendChild(aLink);	
	
	
	return taFoot;
}
jsCalendar.prototype.createCalendarBody = function(year,month){ //달력의 몸통글
	var thisC = this;
	//==========기초 설정
	var wDay = this.wDays[this.cfg.wDayType]; //요일형식
	//========== 바디 테이블 생성
	var taBody = document.createElement('table');
	taBody.border="0" ;
	taBody.cellSpacing="0" ;
	taBody.cellPadding="0";
	taBody.className='taBody';
	//=== tr
	//=요일부분
	var taBodyTrHead = taBody.insertRow(-1);
	taBodyTrHead.className='taBodyTrHead';
	var wi = 0 ;
	var td = null;
	for(var i = 0;i<7;i++){
		wi = (i + this.cfg.startWDay)%7;
		td = taBodyTrHead.insertCell(i);
		td.innerHTML = wDay[wi];
		if(wi==0) td.className='tdSUN';
		else if(wi==6) td.className='tdSAT';

	}
	//=날짜부분
	var dST = new Date(year,(month-1),1);
	var temp = dST.getTime();
	var dED = new Date(year,month,1,0,0,-1);
	dST.setDate(dST.getDate()-1*(dST.getDay())%14+this.cfg.startWDay); //시작일로 설정
	var dSTTSTMP = dST.getTime();
	if(dSTTSTMP > temp){
		dSTTSTMP -= 7*86400000;
	}	
	var dEDTSTMP = dED.getTime();
	var dTMP = new Date(); //임시 날짜 처리용
	var dTMPSTR ='' ;//년-월-일
	var taBodyTrDate = null;
	var t = new Date();
	while(dSTTSTMP<=dEDTSTMP){
		
		taBodyTrDate = taBody.insertRow(-1);
		taBodyTrDate.className='taBodyTrDate';
		for(var i = 0; i < 7 ; i ++){
			td = taBodyTrDate.insertCell(i);
			dTMP.setTime(dSTTSTMP);
			dTMPSTR = dTMP.date(this.cfg.dateFormat);
			wi = dTMP.getDay();
			
			if((this.cfg.limitTSTMPST!= null && this.cfg.limitTSTMPST > dSTTSTMP) || 
			   (this.cfg.limitTSTMPED!= null && this.cfg.limitTSTMPED < dSTTSTMP))
			{
				var aDate = document.createElement('span');
				aDate.className = "aDate";	
				aDate.innerHTML = dTMP.getDate();
				aDate.title=dTMPSTR;			
			}else{
				var aDate = document.createElement('a');
				aDate.className = "aDate";	
				aDate.href='javascript:void(0);';
				aDate.onclick=function(){thisC.onSelectDate(this.title);}
				aDate.innerHTML = dTMP.getDate();
				aDate.title=dTMPSTR;			
			}
			if((dTMP.getMonth()+1) != month){
				
				if(wi==0) td.className='tdOrderDateSUN';
				else if(wi==6) td.className='tdOrderDateSAT';
				else td.className = 'tdOrderDate';
				if(this.cfg.useOtherMonthDay)	td.appendChild(aDate);
				else td.innerHTML = ' '; 
			}else{
				td.appendChild(aDate);
				if(this.targetElement.value && this.selectedValue == dTMPSTR){
					td.className='tdSelectedDay';
				}else if(this.todayValue == dTMPSTR){
					td.className='tdToday';
				}else {
					if(wi==0) td.className='tdSUN';
					else if(wi==6) td.className='tdSAT';
					else if((this.cfg.limitTSTMPST!= null && this.cfg.limitTSTMPST > dSTTSTMP) || 
						(this.cfg.limitTSTMPED!= null && this.cfg.limitTSTMPED < dSTTSTMP)){
						td.className = 'tdOrderDate';
					}
				}
			}
			dSTTSTMP+=86400000;
		}
	}
	var t = new Date(dSTTSTMP);
	
	return taBody;

}
jsCalendar.prototype.setPeriod = function(dateST,dateED) //입력 제한기간 설정.
{
	var d = new Date();
	if(dateST != null){
		if(d.str_setTime(dateST)!= -1)
			this.cfg.limitTSTMPST = d.getTime();
	}else{
		this.cfg.limitTSTMPST = null;
	}
	if(dateED != null){
		if(d.str_setTime(dateED)!= -1)
			this.cfg.limitTSTMPED = d.getTime();
	}else{
		this.cfg.limitTSTMPED = null;
	}
}
jsCalendar.prototype.getBounds = function(obj) //대상의 위치 구하기
{ 
    var ret = new Object(); 
	var bodyElement = document.documentElement.scrollLeft?document.documentElement:document.body;
	if(obj.getBoundingClientRect){  //IE8,FF3 용
        var rect = obj.getBoundingClientRect(); 
        ret.left = rect.left + bodyElement.scrollLeft;
        ret.top = rect.top + bodyElement.scrollTop;
        ret.width = rect.right - rect.left; 
        ret.height = rect.bottom - rect.top; 
	}else if(document.getBoxObjectFor){ //FF2 
        var box = document.getBoxObjectFor(obj); 
        ret.left = box.x; 
        ret.top = box.y; 
        ret.width = box.width; 
        ret.height = box.height; 
    }else if(document.all && obj.getBoundingClientRect) {  //IE
        var rect = obj.getBoundingClientRect(); 
        ret.left = rect.left + bodyElement.scrollLeft;
        ret.top = rect.top + bodyElement.scrollTop;
        ret.width = rect.right - rect.left; 
        ret.height = rect.bottom - rect.top; 
    }else{ //OPERA,SAFARI 용(그외는 무시
		var rect = new Object();
		ret.left = obj.offsetLeft;
		ret.top = obj.offsetTop;
		var parent = obj.offsetParent;
		while(parent != bodyElement && parent){
			ret.left += parent.offsetLeft;
			ret.top += parent.offsetTop;
			parent = parent.offsetParent;
		}
//		ret.top -= bodyElement.scrollTop;
		ret.width = obj.offsetWidth;
		ret.height = obj.offsetHeight;		
	}
    return ret; 
} 