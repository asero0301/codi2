<?
/*��[ ���α׷�  ���� ]��������������������������������������������������������
�� ���α׷� : CSocket (MySQL class) Ver 1.00                                 ��
�� �� �� �� : �̱�ö (������)                                               ��
�� ȭ���̸� : CSocket.inc.php                                                ��
�� ��    �� : MySQL Ŭ����                                                  ��
�� ����� : GNU C/C++                                                     ��
������������������������������������������������������������������������������

����[ �����̷� ]��������������������������������������������������������������
�� �۾��� ��  ��  �� ���泻��                                               ��
�� ������ ���������� ������������������������������������������������������ ��
�� �̱�ö 2004.5.21 �����ۼ�                                                ��
����������������������������������������������������������������������������*/

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

	// ���� ������ ������
	function send($str)
	{
		if($this->fp == null)
			return;

		fputs($this->fp, $str."\0");
		fflush($this->fp);
	}

	// ���� ������ ������
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