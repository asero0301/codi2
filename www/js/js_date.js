/*========================================================
js_date
--------------------------------=-------
Date 관련 함수,프로토타입 모음

사용시 "공대여자는 예쁘다"를 나타내셔야합니다.

만든날 : 2007-08-13
수정일 : 2008-02-25
만든이 : mins01,mins,공대여자
홈페이지 : http://www.mins01.com 
NateOn&MSN : mins01(at)lycos.co.kr
========================================================*/




/*======================================================
date(str,time)
date([표현형식],[대상시간])
[대상시간]: 지정안하면 Date에 지정된 시간(ms)
PHP의 date()와 거의 같은 함수


format 문자 설명 반환값 예 
a : 오전과 오후, 소문자 am, pm 
A : 오전과 오후, 대문자 AM, PM 
B : 스왓치 인터넷 시간 000부터 999  //지원안함
c : ISO 8601 날짜 (PHP 5에서 추가) 2004-02-12T15:19:21+00:00 //지원안함
d : 일, 앞에 0이 붙는 2자리 01부터 31 
D : 요일, 3글자 문자 Mon부터 Sun 
F : 월, January, March 등의 완전한 문자 표현 January부터 December 
g : 시, 0이 붙지 않는 12시간 형식 1부터 12 
G : 시, 0이 붙지 않는 24시간 형식 0부터 23 
h : 시, 0이 붙는 12시간 형식 01부터 12 
H : 시, 0이 붙는 24시간 형식 00부터 23 
i : 분, 0이 붙는 형식 00부터 59 
I : (대문자 i) 일광 절약 시간 여부 일광 절약 시간이면 1, 아니면 0 //지원안함
j : 일, 0이 붙지 않는 형식 1부터 31 
l : (소문자 'L') 요일, 완전한 문자 표현 Sunday부터 Saturday 
L : 윤년인지 여부 윤년이면 1, 아니면 0 
m : 월, 숫자 표현, 0이 붙는 형식 01부터 12 
M : 월, 짧은 문자 표현, 3문자 Jan부터 Dec 
n : 월, 숫자 표현, 0이 붙지 않는 형식 1부터 12 
O : 그리니치 시간(GMT)과의 차이 예: +0200 
r : RFC 2822 형식 날짜 예: Thu, 21 Dec 2000 16:01:07 +0200 
s : 초, 0이 붙는 형식 00 부터 59 
S : 일 표현을 위한 영어 서수 접미어, 2문자 st, nd, rd나 th. j와 잘 작동합니다.  
t : 주어진 월의 일수 28부터 31 
T : 이 기계의 표준 시간대 설정 예: EST, MDT ... //지원안함
U : 유닉스 Epoch(January 1 1970 00:00:00 GMT)로부터의 초 time() 참고 
w : 요일, 숫자형 0(일요일)부터 6(토요일) 
W : ISO-8601 연도의 주차, 주는 월요일에 시작 (PHP 4.1.0에서 추가) 예: 42 (연도의 42번째 주) 
Y : 연도, 4 자리수 표현 예: 1999, 2003 
y : 연도, 2 자리수 표현 예: 99, 03 
z : 연도의 일차 (0부터 시작) 0부터 365 
Z : 표준 시간대의 오프셋 초. UTC로부터 서쪽의 오프셋은 항상 음수이고, UTC로부터 동쪽의 오프셋은 항상 양수. -43200부터 43200 


사용예 
var t = new Date(); 
alert(t.date('Y-m-d H:i:s')); 
alert(t.date('Y-m-d H:i:s',1111111111)); 


========================================================*/
function date(str,time){
	if(time!=null)	
	var t = (time!=null)?new Date(time):new Date();
	return t.date(str);
}
Date.prototype.date = function(str,time){
	if(time!=null){this.setTime(time);}
	
	var w_arr = Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	var w_arr_l = Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
//	var w_arr_l = Array('일','월','화','수','목','금','토'); // 원하는 것으로 선택사용
//	var w_arr_l = Array('日','月','火','水','木','金','土'); // 원하는 것으로 선택사용
	var m_arr_l = Array('January','February','March','April','May','June','July','August','September','October','November','December');
	var m_arr = Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')

	if(!this.date_obj){this.date_obj=new Object();}	
	var date_obj = this.date_obj;
	if(this.date_obj['U']==undefined || this.date_obj['U']!=Math.floor(t/1000)){
		var y = this.getFullYear();
		var m = this.getMonth();
		var d = this.getDate();
		var h = this.getHours();
		var i = this.getMinutes();
		var s = this.getSeconds();
		var w = this.getDay();
		var t = this.getTime();
		var date_y = new Date(y,0,1,0,0,0);
		
		date_obj['a']=h>12?'pm':'am';
		date_obj['A']=h>12?'PM':'AM';
	//	date_obj['B']=//스왓치 인터넷 시간 000부터 999 //지원안함
	//	date_obj['c']=//밑에서 처리//ISO 8601 날짜 (PHP 5에서 추가) 2004-02-12T15:19:21+00:00 
		date_obj['d']=d<10?'0'+d:d;
		date_obj['D']=w_arr[w];
		date_obj['F']=m_arr_l[m];
		date_obj['g']=h%12;
		date_obj['G']=h.toString();;
		date_obj['h']=date_obj['g']<10?'0'+date_obj['g']:date_obj['g'];
		date_obj['H']=date_obj['G']<10?'0'+date_obj['G']:date_obj['G'];
		date_obj['i']=i<10?'0'+i:i;
	//	date_obj['I']=; //일광 절약 시간 여부 : 지원안함
		date_obj['j']=d.toString();;
		date_obj['l']=w_arr_l[w]; //소문자 L
		date_obj['L']=(y%400==0)?1:(y%100==0)?0:(y%4==0)?1:0;	//1 이면 윤년, 아니면 0
		date_obj['m']=(m+1)<10?'0'+(m+1):(m+1);
		date_obj['M']=m_arr[m];
		date_obj['n']=(m+1);
		var tx = this.getTimezoneOffset()*-1,tx1 = Math.floor(tx/60),tx2 = Math.floor(tx1/60);
		date_obj['O']=(tx<0?'-':'+')+(tx1<10?'0'+tx1:tx1)+(tx2<10?'0'+tx2:tx2); tx=tx1=tx2=null;
		//date_obj['r'] //밑에서 처리//RFC 2822 형식 날짜 예: Thu, 21 Dec 2000 16:01:07 +0200 	
		date_obj['s']=s<10?'0'+s:s;
		date_obj['S']=(d==1)?'st':(d==2)?'nd':(d==3)?'rd':'th';
		date_obj['t']=(new Date(y,(m+1),1,0,0,-1)).getDate()
	//	date_obj['T']=; //이 기계의 표준 시간대 설정 예: EST, MDT ...  지원안함
		date_obj['U']=Math.floor(t/1000);
		date_obj['w']=w.toString();
		var tx = Math.floor((t-date_y.getTime())/86400000);
		date_obj['W']=Math.ceil((tx+date_y.getDay())/7);//ISO-8601 연도의 주차, 주는 월요일에 시작 (PHP 4.1.0에서 추가) 예: 42 (연도의 42번째 주) 
		date_obj['Y']=y.toString();;
		date_obj['y']=y.toString().substr(2,2);
		date_obj['z']=tx; tx=null;
		date_obj['Z']=this.getTimezoneOffset()*60;
		date_obj['c']=date_obj['Y']+'-'+date_obj['m']+'-'+date_obj['d']+'T'+date_obj['H']+':'+date_obj['i']+':'+date_obj['s']+date_obj['O'].substr(0,3)+':'+date_obj['O'].substr(3,2)
		date_obj['r']=date_obj['D']+', '+date_obj['d']+' '+date_obj['M']+' '+date_obj['Y']+' '+date_obj['H']+':'+date_obj['i']+':'+date_obj['s']+' '+date_obj['O'];
	}
	var m=str.length;
	var arr = Array(m);
	var t = '';
	for(var i=0;i<m;i++){
		t=str.charAt(i);
		if(date_obj[t]) arr[i] = date_obj[t];
		else arr[i] = t;
	}
	str = arr.join('');
	return str;

}
/*======================================================
str_setTime(str)
str_setTime([문자열로 표현된 시간])
규칙에 맞는 문자열을 시간으로 바꿔서 Date에 setTime 시킨다.

사용예 
var t = new Date(); 
alert(t.str_setTime('2007-09-24 13:22:32.1234')); //리턴 : ms타임
alert(t.str_setTime('yyymmmddd')); // 리턴 -1
========================================================*/
Date.prototype.str_setTime = function(str){
	//형식에 맞춰서 대상을 부석하여 Date형으로 설정한다
	//===날짜형식
	//1972-09-24     # ISO 8601.
	//72-9-24        # Assume 19xx for 69 through 99,
	//			     # 20xx for 00 through 68.
	//72-09-24       # Leading zeros are ignored.
	//9/24/72        # Common U.S. writing.
	//24 September 1972
	//24 Sept 72     # September has a special abbreviation.
	//24 Sep 72      # Three-letter abbreviations always allowed.
	//Sep 24, 1972
	//24-sep-72
	//24sep72
	//19720924 #임의추가
	//720924 #임의추가	
	//2007년01월01일  #임의추가	
	//=== 시간형식
	//20:02:00.000000
	//20:02
	//8:02pm
	//20:02-0500      # In EST (U.S. Eastern Standard Time). //지원안함
	var bool_d = true,bool_t = true;
	var arr_d = new Array(null,null,null);//y,m,d
	var arr_t = new Array(null,null,null,null);//H,i,s,ms
	var m_arr = {'january':1,'february':2,'march':3,'april':4,'may':5,'june':6,'july':7,'august':8,'september':9,'october':10,'november':11,'december':12
	,'jan':1,'feb':2,'mar':3,'apr':4,'may':5,'jun':6,'jul':7,'aug':8,'sep':9,'oct':10,'nov':11,'dec':12
	,'sept':9};
	var regexp = null,reg_result =null
	//=== 날짜비교
	if(arr_d[0]==null){
		var str2=str.replace(/[^\d]/g,'')
		if(str2.length!=str.length){
		}else if(str2.length==8){
			arr_d[0]=str2.substr(0,4);
			arr_d[1]=str2.substr(4,2);
			arr_d[2]=str2.substr(6,2);
		}else if(str2.length==6){
			arr_d[0]=str2.substr(0,2);
			arr_d[1]=str2.substr(2,2);
			arr_d[2]=str2.substr(4,2);
		}
		str2 = null;
	}	
	if(arr_d[0]==null){
		regexp = new RegExp(/(\d{2,4})(?:-|\.|\/|\s)(\d{1,2})(?:-|\.|\/|\s)(\d{1,2})/);reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[1];arr_d[1]=reg_result[2];arr_d[2]=reg_result[3];
		}
	}
	if(arr_d[0]==null){
		regexp = new RegExp(/(\d{1,2})\/(\d{1,2})\/(\d{2,4})/);	reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[3];arr_d[1]=reg_result[1];arr_d[2]=reg_result[2];}
	}
	if(arr_d[0]==null){
		regexp = new RegExp(/(\d{2,4})년(\d{1,2})월(\d{1,2})일/);	reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[1];arr_d[1]=reg_result[2];arr_d[2]=reg_result[3];}
	}		
	if(arr_d[0]==null){
		regexp = new RegExp(/(\d{1,2}) ([a-zA-Z]{3,9}) (\d{2,4})/);	reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[3];arr_d[1]=m_arr[reg_result[2].toLowerCase()];arr_d[2]=reg_result[1];}
	}
	if(arr_d[0]==null){
		regexp = new RegExp(/([a-zA-Z]{3,9}) (\d{1,2}), (\d{2,4})/);	reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[3];arr_d[1]=m_arr[reg_result[1].toLowerCase()];arr_d[2]=reg_result[2];}
	}
	if(arr_d[0]==null){
		regexp = new RegExp(/(\d{1,2})[^\w]?([a-zA-Z]{3,9})[^\w]?(\d{2,4})/);	reg_result = regexp.exec(str);
		if(reg_result!=null){arr_d[0]=reg_result[3];arr_d[1]=m_arr[reg_result[2].toLowerCase()];arr_d[2]=reg_result[1];}
	}
	if(arr_d[0]==null){
		bool_d = false;
	}
//	alert(arr_d);
	if(arr_d[0]!=null){
		arr_d[0]=Number(arr_d[0],10);
		arr_d[1]=Number(arr_d[1],10);
		arr_d[2]=Number(arr_d[2],10);
		if(arr_d[0]<69){arr_d[0]+=2000;}
	}
	//=== 시간비교
	if(arr_t[0]==null){ //20:02:00.000000
		regexp = new RegExp(/(\d{1,2}):(\d{1,2}):(\d{1,2})(\.\d{1,6})?/);reg_result = regexp.exec(str);
		if(reg_result!=null){arr_t[0]=reg_result[1];arr_t[1]=reg_result[2];arr_t[2]=reg_result[3];
		arr_t[3]=reg_result[4]!=null?reg_result[4].substr(1):null;
		}
	}
	if(arr_t[0]==null){ //8:02am
		regexp = new RegExp(/(\d{1,2}):(\d{1,2})(am|pm)?/);reg_result = regexp.exec(str);
		if(reg_result!=null){arr_t[0]=reg_result[1];arr_t[1]=reg_result[2];
		if(reg_result[3]=='pm')arr_t[0]=parseInt(arr_t[0],10)+12;
		}
	}		
	if(arr_t[0]==null){ //8:02
		regexp = new RegExp(/(\d{1,2}):(\d{1,2})(:\d{1,2})?/);reg_result = regexp.exec(str);
		if(reg_result!=null){arr_t[0]=reg_result[1];arr_t[1]=reg_result[2];arr_t[2]=reg_result[3].substr(1)}
	}
	if(arr_t[0]==null){
		bool_t = false;
	}	
	if(arr_t[0]!=null){
		arr_t[0]=Number(arr_t[0],10);
		arr_t[1]=Number(arr_t[1],10);	
		arr_t[2]=Number(arr_t[2],10);
		arr_t[3]=Number(arr_t[3],10);	
	}
	if(!(bool_d||bool_t)){
		return -1;
	}else{
		var t = new Date(arr_d[0],(arr_d[1]-1),arr_d[2],arr_t[0],arr_t[1],arr_t[2],arr_t[3]);
		this.setTime(t.getTime());
		return t.getTime();
	}
}