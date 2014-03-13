/*=======================================
// jsCalendar
// textbox�� �����ؼ� ��¥�� �Է��Ѵ�
// �ۼ��� : 2008-02-25
// ������ : 2008-02-25 10 AM
// ������ : 2008-06-03 
// ������ : 2008-07-07 
// ���뿩�ڴ� �̻ڴٸ� ��Ÿ���߸� �� �� �ֽ��ϴ�.
// �� ������ �����ؼ� ����� �� �� �����ϴ�!
// ���� ������� ���ϵ����� ����� ����� �� �����ϴ�.
// ������ : mins,���뿩�� 
// Ȩ������  : www.mins01.com

#js_calendar �� �ٸ���
���̹� �ݽ��� �ٲ����
CSS�� 99% �������� �����մϴ�.
��ư�� ���̻� �⺻���� �������� �ʽ��ϴ�.(�������� �������ּž��մϴ�.)

#���� : 
open ��ư�� ������ �޷��� ���δ�.
��,���� ������ �� �ִ�
��¥�� �����ϸ�, �ش� textbox�� onchage �̹�Ʈ�� ��ϵ� ��ũ��Ʈ�� �����Ѵ�(������ ����~)

#���� : 
<script src="js_date.js" type="text/javascript" charset="utf-8" ></script>
<script src="jsCalendar.js" type="text/javascript" charset="utf-8" ></script>
<link rel="stylesheet" type="text/css" href="jsCalendar.css" charset="utf-8" />

var calendar = new jsCalendar([TextBox],[Button]);
[TextBox] : ���� ���޵Ǵ� �ؽ�Ʈ �ڽ� (�ʼ�)
[Button] : �޷� ���� ��ư (����)(���� ���� ��� �ؽ�Ʈ�ڽ��� ��ư��Ȱ�� ��)
#�� :
var cal0 = new jsCalendar(document.getElementById('ipt00'),document.getElementById('btn00'));

#����
var calendar = new jsCalendar([TextBox],[Button]);
calendar.cfg.startWDay:0 //0(������):�Ͽ��Ϻ��ͽ���,1:������,2:ȭ����~6:�����
calendar.cfg.useOtherMonthDay:true //true:�ش� �� �̿��� ��¥�� ǥ��, false:�ش� ���� ��¥�� ǥ��
calendar.cfg.wDayType:'kr' //���ϱ�¥: kr:�ѱ�, cn:�ѹ�, enShort:����Ǿ� , en:����
calendar.cfg.dateFormat:'Y-m-d' //��¥ǥ����
calendar.cfg.language:'kr' //�������, kr:��,��,�� , en:����, cn:�ѹ�
calendar.cfg.mLeft:0 //left ������
calendar.cfg.mTop:0 //top ������
calendar.cfg.onSelectFN:function(date){thisC.targetElement.value = date;} //��¥�� ������ �� ������ �Լ� 
   //���Ƿ� ������ �� �ֽ��ϴ�.
calendar.cfg.limitTSTMPST:null // �ּҳ�¥ ������(Date.getTime()����), ���� �������ٴ� setPeriod()�� ���
calendar.cfg.limitTSTMPED:null // �ִ볯¥ ������(Date.getTime()����) ���� �������ٴ� setPeriod()�� ���  
calendar.cfg.onSelectFN = function(date){alert(date);}
calendar.cfg.divClassName = 'divLayout' //�ֿܰ� div�� class �̸�

calendar.setPeriod([�ּҳ�¥ ������],[�ִ볯¥ ������]); 
//[�ּҳ�¥ ������] : '2008-10-21' ó�� ����, null�� �����ϸ� ������ �������.
//[�ִ볯¥ ������] : '2008-10-21' ó�� ����, null�� �����ϸ� ������ �������.

#����
.js ������ ������ �� �����ϴ�.
.css�� ���ϴ� ���·� �����ؼ� ����ϼ���.

#����
js_date.js : ��¥ ����� ���ؼ� ���
jsCalendar.css : CSS����

//=======================================*/

function jsCalendar(targetElement,buttonElement){
	var thisC = this;
	this.targetElement = null; //��� textbox
	this.buttonElement = null; //��ư ������Ʈ	
	this.selectedValue = null; //���õ� ��, textbox�� ��
	this.selectedDate = null; //���õ� ���� Date��
	this.todayValue = null; //������ ��

	this.calendar = null; //Į����

	this.upDownTimer = null; //��¥ ����,���� Ÿ�̸�

	this.aClose = null; //�޴� : �ݱ�
	this.autoCloseTimer = null; //�ڵ��ݱ� Ÿ�̸�
	this.over = null; //���콺 ���� ����

	this.cfg = {
		 startWDay:0 //0(������):�Ͽ��Ϻ��ͽ���,1:������,2:ȭ����~6:�����
		,useOtherMonthDay:true //true:�ش� �� �̿��� ��¥�� ǥ��, false:�ش� ���� ��¥�� ǥ��
		,wDayType:'kr' //���ϱ�¥: kr:�ѱ�, cn:�ѹ�, enShort:����Ǿ� , en:����
		,dateFormat:'Y-m-d' //��¥ǥ����
		,language:'kr' //�������, kr:��,��,�� , en:����, cn:�ѹ�
		,mLeft:0 //left ������
		,mTop:0 //top ������
		,autoClose:true //�ڵ� �ݱ� ����, ��Ŀ���� ������ �ڵ����� �������.
		,autoCloseTimeout:200 //�ڵ� �ݱ⿡ �ɸ��� �ð�, 1000�� 1�� ������ �ð��� ������� ������ ����� onChange �Լ��� ���� ���� �� �ִ�.
		,upDownTimeout:300 //��¥ ����,���� �ݺ�������
		,limitTSTMPST:null // �ּҳ�¥ ������(Date.getTime()����), ���� �������ٴ� setPeriod()�� ���
		,limitTSTMPED:null // �ִ볯¥ ������(Date.getTime()����) ���� �������ٴ� setPeriod()�� ���
		,onSelectFN:function(date){thisC.targetElement.value = date;}
		,divClassName:'divLayout' //�ֿܰ� div�� class �̸�
	};
	this.wDays ={
		 enShort:['SUN','MON','TUE','WED','THU','FRI','SAT'] //���� ����� 
		,en:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] //���� Ǯ����
		,kr:['��','��','ȭ','��','��','��','��'] //�ѱ�
		,cn:['��','��','��','�','��','��','��'] //�ѹ�
	}
	this.dateWord ={
		 kr:{year:'��',month:'��',date:'��',today:'����',close:'�ݱ�'}
		,en:{year:'year',month:'month',date:'date',today:'Today',close:'close'}
		,cn:{year:'Ҵ',month:'��',date:'��',today:'����',close:'close'}
	}	
	this.jsCalendar(targetElement,buttonElement); //������
}
jsCalendar.prototype.jsCalendar = function(targetElement,buttonElement){ //������
	var thisC = this;
	this.targetElement = targetElement;
	if(!this.targetElement){
		alert("������ ����� �����ϴ�");
		return false;
	}	
	this.selectedDate = new Date();
	if(this.targetElement.value)	this.selectedDate.setTime(this.selectedDate.str_setTime(this.targetElement.value));
	this.selectedValue = this.selectedDate.date(this.cfg.dateFormat);
	
	//=== ��ưó��
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
	//===��ġ �缳��
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

	//===== �ݱ� ��ư�� ��Ŀ��
	if(this.cfg.autoClose){ //�ڵ� �ݱ⸦ ����� ��
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
jsCalendar.prototype.onSelectDate = function(date){ //�޷��� �����.
	this.cfg.onSelectFN(date);
	if(this.targetElement.onchange){this.targetElement.onchange();}
	this.hideCalendar();
}
jsCalendar.prototype.createCalendar = function(year,month){ //�޷��� �����.
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
jsCalendar.prototype.changeCalendar = function(year,month){ //�޷��� �����.
	var d = new Date(year,(month-1),1);
	var y = d.getFullYear();
	var m = (d.getMonth()+1);
	this.taFrame.taFrameTrBodyTdBody.removeChild(this.taBody);
	this.taBody = this.createCalendarBody(y,m);
	this.taFrame.taFrameTrBodyTdBody.appendChild(this.taBody );
	this.iptYear.value=y;
	this.iptMonth.value=m;
}
jsCalendar.prototype.onBTNOpen = function(){ //�޷��� �����.
	this.toggleCalendar();
}
jsCalendar.prototype.onBTNToday = function(){ //�޷��� �����.
	var d = new Date();
	var y = d.getFullYear();
	var m = (d.getMonth()+1);
	if(isNaN(y) || isNaN(m) ){
		alert("�߸��� ��¥�Դϴ�.");
		return false;
	}
	this.changeCalendar(y,m);
}
jsCalendar.prototype.onBTNYearDown = function(year,month){ //�޷��� �����.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("�߸��� ��¥�Դϴ�.");
		return false;
	}
	this.changeCalendar((y-1),m);
}
jsCalendar.prototype.onBTNYearUp = function(year,month){ //�޷��� �����.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("�߸��� ��¥�Դϴ�.");
		return false;
	}
	this.changeCalendar((y+1),m);
}
jsCalendar.prototype.onBTNMonthDown = function(year,month){ //�޷��� �����.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("�߸��� ��¥�Դϴ�.");
		return false;
	}
	this.changeCalendar(y,(m-1));
}
jsCalendar.prototype.onBTNMonthUp = function(year,month){ //�޷��� �����.
	var y = parseInt(year);
	var m = parseInt(month);
	if(isNaN(y) || isNaN(m) ){
		alert("�߸��� ��¥�Դϴ�.");
		return false;
	}
	this.changeCalendar(y,(m+1));
}
jsCalendar.prototype.createCalendarLayout = function(){ //�޷��� DIV ���̾ƿ� �κ�
	var divLayout = document.createElement('div');
	divLayout.className = this.cfg.divClassName || 'divLayout';
	return divLayout;
}
jsCalendar.prototype.createCalendarFrame = function(year,month){ //�޷��� ������ �κ�
	//========== ������ ���̺� ����
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
	//taFrameTrHeadTdHead.innerHTML = "�ش��κ�";
	
	return taFrame;
	
}
jsCalendar.prototype.createCalendarHead = function(year,month){ //�޷��� �Ӹ�, �޴��κ�
	var thisC = this;
	//========== �޴� ���̺� ����
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
	//=== ����ֱ�
	//=���÷�
	var aToday = document.createElement('a');
	aToday.className = "aToday";	
	aToday.href='javascript:void(0);';
	aToday.onmousedown=function(){thisC.over++;}
	aToday.onmouseup=function(){thisC.onBTNToday();thisC.aClose.focus(); }	
	aToday.innerHTML = this.dateWord[this.cfg.language].today;
	aToday.title = this.dateWord[this.cfg.language].today;
	taHeadTr0Td0.appendChild(aToday);
	//=�ݱ�	
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
	//=��
	var iptYear = document.createElement('input');
	iptYear.size=4;
	iptYear.className = "iptYear";
	iptYear.value = year;
	iptYear.readOnly = true;
	taHeadTr1Td0.appendChild(iptYear);	
	this.iptYear = iptYear;
	//=a��ũ �⺻��
	var aSTD = document.createElement('a');
	aSTD.className = "aButton";	
	aSTD.href='javascript:void(0);';
	//=�⵵ ���,����
	var aYearDown = aSTD.cloneNode(true);
	aYearDown.innerHTML = '��';
	var aYearUp = aSTD.cloneNode(true);
	aYearUp.innerHTML = '��';	
	taHeadTr1Td0.appendChild(aYearDown);	
	taHeadTr1Td0.appendChild(aYearUp);	
	taHeadTr1Td0.appendChild(document.createTextNode(this.dateWord[this.cfg.language].year+' '));	
	//=��
	var iptMonth = document.createElement('input');
	iptMonth.size=2;
	iptMonth.className = "iptMonth";
	iptMonth.value = month;
	iptMonth.readOnly = true;
	taHeadTr1Td0.appendChild(iptMonth);	
	this.iptMonth = iptMonth;	
	//=�� ���,����
	var aMonthDown = aSTD.cloneNode(true);
	aMonthDown.innerHTML = '��';
	var aMonthUp = aSTD.cloneNode(true);
	aMonthUp.innerHTML = '��';	
	taHeadTr1Td0.appendChild(aMonthDown);	
	taHeadTr1Td0.appendChild(aMonthUp);		
	taHeadTr1Td0.appendChild(document.createTextNode(this.dateWord[this.cfg.language].month));	
	//=== �̹�Ʈ

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
jsCalendar.prototype.createCalendarFoot = function(year,month){ //�޷��� �ٴڱ�
//���� ���� ����!, Don't Remove! AND Don't Modify
	//========== �޴� ���̺� ����
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
	//=== ����ֱ�
	//=��ũ
	var aLink = document.createElement('a');
	aLink.className = "aLink";	
	aLink.href='http://www.mins01.com';
	aLink.target='_blank';
	aLink.onclick=function(){alert("���뿩��(������) Ȩ������ :");}
	aLink.innerHTML = "minsHompage";
	aLink.title = "������ Ȩ������";
	taFootTr0Td0.appendChild(aLink);	
	
	
	return taFoot;
}
jsCalendar.prototype.createCalendarBody = function(year,month){ //�޷��� �����
	var thisC = this;
	//==========���� ����
	var wDay = this.wDays[this.cfg.wDayType]; //��������
	//========== �ٵ� ���̺� ����
	var taBody = document.createElement('table');
	taBody.border="0" ;
	taBody.cellSpacing="0" ;
	taBody.cellPadding="0";
	taBody.className='taBody';
	//=== tr
	//=���Ϻκ�
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
	//=��¥�κ�
	var dST = new Date(year,(month-1),1);
	var temp = dST.getTime();
	var dED = new Date(year,month,1,0,0,-1);
	dST.setDate(dST.getDate()-1*(dST.getDay())%14+this.cfg.startWDay); //�����Ϸ� ����
	var dSTTSTMP = dST.getTime();
	if(dSTTSTMP > temp){
		dSTTSTMP -= 7*86400000;
	}	
	var dEDTSTMP = dED.getTime();
	var dTMP = new Date(); //�ӽ� ��¥ ó����
	var dTMPSTR ='' ;//��-��-��
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
jsCalendar.prototype.setPeriod = function(dateST,dateED) //�Է� ���ѱⰣ ����.
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
jsCalendar.prototype.getBounds = function(obj) //����� ��ġ ���ϱ�
{ 
    var ret = new Object(); 
	var bodyElement = document.documentElement.scrollLeft?document.documentElement:document.body;
	if(obj.getBoundingClientRect){  //IE8,FF3 ��
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
    }else{ //OPERA,SAFARI ��(�׿ܴ� ����
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