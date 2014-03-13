<?
$fp = fopen("/home/gogisnim/perl/cafe/20100527", "r");
$str = "";
while ( !feof($fp) ) {
	$str = fgets($fp, 1024);
	echo $str."<br>";
}

fclose($fp);
?>