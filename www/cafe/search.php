<?
$q = $_POST['q'];
$d = "/home/gogisnim/perl/cafe";

if ( $q ) {
	$cnt = 0;
	$tmp_arr = array();
	if ( is_dir($d) ) {
		if ( $dh = opendir($d)) {
			while ( ($ff = readdir($dh)) != false ) {
				if ( $ff == "." or $ff == ".." ) continue;
				$tmp_arr[] = $ff;
			}

			rsort($tmp_arr);

			foreach ( $tmp_arr as $f ) {
				$fp = fopen("$d/$f", "r");
				if ( $fp ) {
					while ( !feof($fp) ) {
						$line = fgets($fp, 512);
						if ( strpos($line, $q) != false ) {
							$str .= $f." : ".$line."<br>";
							$cnt++;
						}
					}
				}
				fclose($fp);
			}
		}
	}
} else {
	$dt = date("Ymd");
	$fp = fopen("/home/gogisnim/perl/cafe/".$dt, "r");
	$str = "<b>".date("Y³â n¿ù jÀÏ")."</b><br>";
	while ( !feof($fp) ) {
		$str .= fgets($fp, 1024)."<br>";
	}

	fclose($fp);
}
?>
<form name='frm' method='post'>
<input type='text' name='q' id='q' value='<?=$q?>' onKeyDown='if (event.keyCode==13) document.frm.submit();'>
<input type='button' value='search' onClick='document.frm.submit();'>
</form>
<?
$str = "count : $cnt <p>".$str;
echo $str;
?>
