<?
	$no_frame = $_REQUEST["noframe"];

	if(getenv("HTTP_HOST") == "coditop.superboard.com")
	{
		$no_frame = "ok";
		setcookie("Go_URL", "", 0, "/");
	}

	if($no_frame != "ok")
	{
		$chk_ref = $_SERVER["HTTP_REFERER"];
//echo  __FILE__ . __LINE__ ; exit; 

//		if(!eregi("coditop.superboard.com", $chk_ref))
		if(!preg_match("#coditop.superboard.com#", $chk_ref))
		{
			$ThisURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//print "no_frame:" . $no_frame . "<br>" ;
//print "chk_ref:" . $chk_ref . "<br>" ;
//print "ThisURL:" . $ThisURL . "<br>" ;
//print  __FILE__ . __LINE__ ; exit; 

//			setcookie("Go_URL", $ThisURL, 0, "/");

//			echo "<script> location.replace('/'); </script>";
//			exit;
		}
	}
?>
