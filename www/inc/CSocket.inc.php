<?
/*━[ 프로그램  정보 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 프로그램 : CSocket (MySQL class) Ver 1.00                                 ┃
┃ 작 성 자 : 이광철 (따식이)                                               ┃
┃ 화일이름 : CSocket.inc.php                                                ┃
┃ 설    명 : MySQL 클래스                                                  ┃
┃ 사용언어 : GNU C/C++                                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

┏━[ 변경이력 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 작업자 작  업  일 변경내용                                               ┃
┃ ━━━ ━━━━━ ━━━━━━━━━━━━━━━━━━━━━━━━━━━ ┃
┃ 이광철 2004.5.21 최초작성                                                ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

class CSocket
{
	var $fp;
	var $host;
	var $port;
	var $oldhost;

	function CSocket()
	{
		$this->fp      = null;
	}



	function close()
	{
		if($this->fp == null)
			return;

		fclose($this->fp);
		$this->fp = null;
	}



	function set($host, $port)
	{
		if($host == $this->oldhost)
			return;
	
		$this->close();
	
		$this->host   = $host;
		$this->port   = $port;

		$this->oldhost = $host;
	}



	function open()
	{
		if($this->fp != null)
			return;

		if (!($this->fp = fsockopen($this->host, $this->port, &$errorno, &$errstr, 15)))
		{
			$this->fp = null;
			return;
		}

//		socket_set_blocking($this->fp, 0);
	}

	// 실제 쿼리를 날린다
	function send($str)
	{
		if($this->fp == null)
			return;

		fputs($this->fp, $str."\0");
		fflush($this->fp);
	}

	// 실제 쿼리를 날린다
	function recv()
	{
/*
		$ret="";
		
		if($this->fp == null)
			return "";

		stream_set_timeout($this->fp, 7);

//		while (!feof($this->conn))
		{
			$str = fread($this->fp, 32000);
			if($str == FALSE)
				return null;
			
			$ret .= $str;
		}
		
		return $ret;
		*/

		$ret="";
		
		if($this->fp == null)
			return "";

		while (!feof($this->fp))
		{
			$ret .= fgets($this->fp, 128);
		}
		
		return $ret;
	}
}

?>