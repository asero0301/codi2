<?

$str = "<h1><font color='red' style='display:block'>trust</font></h1>";
echo "str : $str <br>";
echo "strip : ".strip_tags($str)."<br>";
?>

<script>
function getNavigatorInfo() {
	if (navigator.appVersion.indexOf("MSIE")!=-1){
		temp=navigator.appVersion.split("MSIE");
		version=parseFloat(temp[1]);
		if (version>=5.5) return "I";
	} else if (navigator.userAgent.indexOf("Firefox")!=-1){
		var versionindex=navigator.userAgent.indexOf("Firefox")+8;
		if (parseInt(navigator.userAgent.charAt(versionindex))>=1) return "F";
	} else if(navigator.userAgent.indexOf("Opera")!=-1){
		var versionindex=navigator.userAgent.indexOf("Opera")+6;
		if (parseInt(navigator.userAgent.charAt(versionindex))>=8) return "O";
	} else if (navigator.appName=="Netscape" && parseFloat(navigator.appVersion)>=4.7) return "N";
}
str = getNavigatorInfo();
document.write(str+"<br>");

str2 = "<font size=+3>Å°¿öµå</b></font>";
//alert(str2.substring(1,14));

str3 = "heal´ëÇÑ¹Î±¹the world";
document.write("lenght : "+str3.length+"<br>");

document.write("replace : ["+str3.replace("´ëÇÑ¹Î","")+"]<br>");
document.write("indexOf : ["+str3.lastIndexOf("wor")+"]<br>");

document.write("<br>=========================<br>");

s = "W:^640:^480:^10:^100:^<html><head><title>Á¦¸ñ::Å×½ºÆ®»ï¤»¤»¤»</title></head><body>¿ì¸®´Â <b>¹ÎÁ·ÁßÈï</b>ÀÇ ...</body></html>";
document.write("first : [" + s.charAt(0) + "]<br>");
tmp_arr = s.split(":^");
document.write("width : [" + tmp_arr[1] + "]<br>");
document.write("height : [" + tmp_arr[2] + "]<br>");
document.write("top : [" + tmp_arr[3] + "]<br>");
document.write("left : [" + tmp_arr[4] + "]<br>");

cont = "";
for ( var i=5; i<tmp_arr.length; i++ ) {
	cont += tmp_arr[i];
}

document.write("cont : [" + cont + "]<br>");


ss = "abcde";
tmp_a = ss.split(":");
document.write("ss : " + tmp_a[0] + "==== length : "+tmp_a.length+"<br>");
</script>

<?
$fp = fopen("/coditop/tpl/pop_4.txt","r");
$str = fread($fp, 10000);
fclose($fp);

?>