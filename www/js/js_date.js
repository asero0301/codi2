/*========================================================
js_date
--------------------------------=-------
Date ���� �Լ�,������Ÿ�� ����

���� "���뿩�ڴ� ���ڴ�"�� ��Ÿ���ž��մϴ�.

���糯 : 2007-08-13
������ : 2008-02-25
������ : mins01,mins,���뿩��
Ȩ������ : http://www.mins01.com 
NateOn&MSN : mins01(at)lycos.co.kr
========================================================*/




/*======================================================
date(str,time)
date([ǥ������],[���ð�])
[���ð�]: �������ϸ� Date�� ������ �ð�(ms)
PHP�� date()�� ���� ���� �Լ�


format ���� ���� ��ȯ�� �� 
a : ������ ����, �ҹ��� am, pm 
A : ������ ����, �빮�� AM, PM 
B : ����ġ ���ͳ� �ð� 000���� 999  //��������
c : ISO 8601 ��¥ (PHP 5���� �߰�) 2004-02-12T15:19:21+00:00 //��������
d : ��, �տ� 0�� �ٴ� 2�ڸ� 01���� 31 
D : ����, 3���� ���� Mon���� Sun 
F : ��, January, March ���� ������ ���� ǥ�� January���� December 
g : ��, 0�� ���� �ʴ� 12�ð� ���� 1���� 12 
G : ��, 0�� ���� �ʴ� 24�ð� ���� 0���� 23 
h : ��, 0�� �ٴ� 12�ð� ���� 01���� 12 
H : ��, 0�� �ٴ� 24�ð� ���� 00���� 23 
i : ��, 0�� �ٴ� ���� 00���� 59 
I : (�빮�� i) �ϱ� ���� �ð� ���� �ϱ� ���� �ð��̸� 1, �ƴϸ� 0 //��������
j : ��, 0�� ���� �ʴ� ���� 1���� 31 
l : (�ҹ��� 'L') ����, ������ ���� ǥ�� Sunday���� Saturday 
L : �������� ���� �����̸� 1, �ƴϸ� 0 
m : ��, ���� ǥ��, 0�� �ٴ� ���� 01���� 12 
M : ��, ª�� ���� ǥ��, 3���� Jan���� Dec 
n : ��, ���� ǥ��, 0�� ���� �ʴ� ���� 1���� 12 
O : �׸���ġ �ð�(GMT)���� ���� ��: +0200 
r : RFC 2822 ���� ��¥ ��: Thu, 21 Dec 2000 16:01:07 +0200 
s : ��, 0�� �ٴ� ���� 00 ���� 59 
S : �� ǥ���� ���� ���� ���� ���̾�, 2���� st, nd, rd�� th. j�� �� �۵��մϴ�.  
t : �־��� ���� �ϼ� 28���� 31 
T : �� ����� ǥ�� �ð��� ���� ��: EST, MDT ... //��������
U : ���н� Epoch(January 1 1970 00:00:00 GMT)�κ����� �� time() ���� 
w : ����, ������ 0(�Ͽ���)���� 6(�����) 
W : ISO-8601 ������ ����, �ִ� �����Ͽ� ���� (PHP 4.1.0���� �߰�) ��: 42 (������ 42��° ��) 
Y : ����, 4 �ڸ��� ǥ�� ��: 1999, 2003 
y : ����, 2 �ڸ��� ǥ�� ��: 99, 03 
z : ������ ���� (0���� ����) 0���� 365 
Z : ǥ�� �ð����� ������ ��. UTC�κ��� ������ �������� �׻� �����̰�, UTC�κ��� ������ �������� �׻� ���. -43200���� 43200 


��뿹 
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
//	var w_arr_l = Array('��','��','ȭ','��','��','��','��'); // ���ϴ� ������ ���û��
//	var w_arr_l = Array('��','��','��','�','��','��','��'); // ���ϴ� ������ ���û��
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
	//	date_obj['B']=//����ġ ���ͳ� �ð� 000���� 999 //��������
	//	date_obj['c']=//�ؿ��� ó��//ISO 8601 ��¥ (PHP 5���� �߰�) 2004-02-12T15:19:21+00:00 
		date_obj['d']=d<10?'0'+d:d;
		date_obj['D']=w_arr[w];
		date_obj['F']=m_arr_l[m];
		date_obj['g']=h%12;
		date_obj['G']=h.toString();;
		date_obj['h']=date_obj['g']<10?'0'+date_obj['g']:date_obj['g'];
		date_obj['H']=date_obj['G']<10?'0'+date_obj['G']:date_obj['G'];
		date_obj['i']=i<10?'0'+i:i;
	//	date_obj['I']=; //�ϱ� ���� �ð� ���� : ��������
		date_obj['j']=d.toString();;
		date_obj['l']=w_arr_l[w]; //�ҹ��� L
		date_obj['L']=(y%400==0)?1:(y%100==0)?0:(y%4==0)?1:0;	//1 �̸� ����, �ƴϸ� 0
		date_obj['m']=(m+1)<10?'0'+(m+1):(m+1);
		date_obj['M']=m_arr[m];
		date_obj['n']=(m+1);
		var tx = this.getTimezoneOffset()*-1,tx1 = Math.floor(tx/60),tx2 = Math.floor(tx1/60);
		date_obj['O']=(tx<0?'-':'+')+(tx1<10?'0'+tx1:tx1)+(tx2<10?'0'+tx2:tx2); tx=tx1=tx2=null;
		//date_obj['r'] //�ؿ��� ó��//RFC 2822 ���� ��¥ ��: Thu, 21 Dec 2000 16:01:07 +0200 	
		date_obj['s']=s<10?'0'+s:s;
		date_obj['S']=(d==1)?'st':(d==2)?'nd':(d==3)?'rd':'th';
		date_obj['t']=(new Date(y,(m+1),1,0,0,-1)).getDate()
	//	date_obj['T']=; //�� ����� ǥ�� �ð��� ���� ��: EST, MDT ...  ��������
		date_obj['U']=Math.floor(t/1000);
		date_obj['w']=w.toString();
		var tx = Math.floor((t-date_y.getTime())/86400000);
		date_obj['W']=Math.ceil((tx+date_y.getDay())/7);//ISO-8601 ������ ����, �ִ� �����Ͽ� ���� (PHP 4.1.0���� �߰�) ��: 42 (������ 42��° ��) 
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
str_setTime([���ڿ��� ǥ���� �ð�])
��Ģ�� �´� ���ڿ��� �ð����� �ٲ㼭 Date�� setTime ��Ų��.

��뿹 
var t = new Date(); 
alert(t.str_setTime('2007-09-24 13:22:32.1234')); //���� : msŸ��
alert(t.str_setTime('yyymmmddd')); // ���� -1
========================================================*/
Date.prototype.str_setTime = function(str){
	//���Ŀ� ���缭 ����� �μ��Ͽ� Date������ �����Ѵ�
	//===��¥����
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
	//19720924 #�����߰�
	//720924 #�����߰�	
	//2007��01��01��  #�����߰�	
	//=== �ð�����
	//20:02:00.000000
	//20:02
	//8:02pm
	//20:02-0500      # In EST (U.S. Eastern Standard Time). //��������
	var bool_d = true,bool_t = true;
	var arr_d = new Array(null,null,null);//y,m,d
	var arr_t = new Array(null,null,null,null);//H,i,s,ms
	var m_arr = {'january':1,'february':2,'march':3,'april':4,'may':5,'june':6,'july':7,'august':8,'september':9,'october':10,'november':11,'december':12
	,'jan':1,'feb':2,'mar':3,'apr':4,'may':5,'jun':6,'jul':7,'aug':8,'sep':9,'oct':10,'nov':11,'dec':12
	,'sept':9};
	var regexp = null,reg_result =null
	//=== ��¥��
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
		regexp = new RegExp(/(\d{2,4})��(\d{1,2})��(\d{1,2})��/);	reg_result = regexp.exec(str);
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
	//=== �ð���
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