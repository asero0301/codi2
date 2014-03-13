<?
//SendMail( �޴»������, ��������̸�, �����������, ����, ���� )
function SendMail($toMail, $fromName, $fromMail, $subject, $content)
{
	$headers = "";
	$headers .= "From: ".$fromName." < ".$fromMail." >\n"; 
	$headers .= "X-Sender: < ".$toMail." >\n"; 
	$headers .= "X-Mailer: PHP\n";								// mailer 
	$headers .= "X-Priority: 1\n";								// Urgent message! 
	$headers .= "Return-Path: <".$fromMail.">\n";				// Return path for errors 
	$headers .= "Content-Type: text/html; charset=EUC-KR\n\n";	// Mime type 

	mail($toMail, $subject, $content, $headers);
}


//���� Ȯ���� ���ϱ�
function GetExtension($FileName)
{
	$path = pathinfo($FileName);
	return $path['extension'];
}


//�������ϸ� ����� ���ϸ�_num ���� ����
function UniqFileName($FileName, $FolderName)
{
	$FileExt   = substr(strrchr($FileName, "."), 1);
	$FileName  = substr($FileName, 0, strlen($FileName) - strlen($FileExt) - 1);
	$FileCnt   = 0;

	$ret_fname = "$FileName.$FileExt";

	while(file_exists($FolderName.$ret_fname))
	{
		$FileCnt++;
		$ret_fname = $FileName."_".$FileCnt.".".$FileExt;
	}

	return $ret_fname;
}



/*��[ �Լ����� ]��������������������������������������������������������������
�� �� �� �� : function ImageResize()                                        ��
�� ��    �� : $img_src_file�� �ش��ϴ� ȭ���� �о�鿩 ��������Ŀ�         ��
��            $img_dst_file ȭ�Ϸ� �����Ѵ�. (�������� jpg�� ����)          ��
��                                                                          ��
�� �� �� �� : $img_src_file = ���� �̹��� ȭ���̸�                          ��
��            $img_dst_file = ���������� ������ ȭ���̸�                    ��
��            $set_w        = ���������� ���� ������                        ��
��            $set_h        = ���������� ���� ������                        ��
��            $mode         = �������� ���                                 ��
��            $quility      = �������� (0: �ִ��� ����, 100: �������)      ��
��                            0: �̹��� ����, 100: �̹��� �ȱ���            ��
�� �� �� �� : �迭�� �� ����Ÿ                                              ��
����������������������������������������������������������������������������*/

function ImageResize($img_src_file, $img_dst_file, $set_w, $set_h, $mode="s", $quility=80)
{ 
	$ret = array();
	
	list ($src_w, $src_h, $src_t, $src_a) = getimagesize( $img_src_file );
	$set_tangent = $set_h / $set_w;  //������ �̹����� ���μ��� ���� 
	$src_tangent = $src_h / $src_w;  //�ҽ��̹����� ���μ��� ���� 

	switch($src_t)
	{
		case 1 : $img_src = @imagecreatefromgif($img_src_file);  break;   // gif
		case 2 : $img_src = @imagecreatefromjpeg($img_src_file); break;   // jpg
		case 3 : $img_src = @imagecreatefrompng($img_src_file);  break;   // png
	} 

	if($mode != "r")
	{
		$img_dst = @imagecreatetruecolor($set_w, $set_h); 
		$white   = @imagecolorallocate($img_dst,255,255,255); 
		@imagefilltoborder($img_dst, 0, 0, $white, $white);
	}


	switch($mode)
	{
		case "c" :
			// ���ú����� �µ��� ���� �Ǵ� �¿츦 ��Ʈ��. 
			$cut_x=($src_tangent>$set_tangent)?0:($src_w-($src_h/$set_tangent))/2; 
			$cut_y=($src_tangent>$set_tangent)?($src_h-($src_w*$set_tangent))/2:0; 
			@imagecopyresampled($img_dst,$img_src,0,0,$cut_x,$cut_y,$set_w,$set_h,$src_w-$cut_x*2,$src_h-$cut_y*2); 
		break;

		case "s" :
			// ���� ũ��� �״�� �ε�, ���� �̹����� ������ Ȯ��/����� ���� ���� 
			$span_x=($src_tangent>$set_tangent)?$set_h/$src_tangent:$set_w; 
			$span_y=($src_tangent>$set_tangent)?$set_h:$set_w*$src_tangent; 
			$padding_x = (int) (( $set_w - $span_x ) / 2); 
			$padding_y = (int) (( $set_h - $span_y ) / 2); 
			@imagecopyresampled($img_dst, $img_src, $padding_x, $padding_y, 0, 0, $span_x, $span_y, $src_w, $src_h);
		break;

		case "s2" :
			@imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $set_w, $set_h, $src_w, $src_h);
		break;

		case "r" :
			if($set_tangent > $src_tangent)
			{
				$set_h = ($set_w / $src_w) * $src_h;
			}
			else
			{
				$set_w = ($set_h / $src_h) * $src_w;
			}

			$img_dst = @imagecreatetruecolor($set_w, $set_h); 
			$white   = @imagecolorallocate($img_dst,255,255,255); 
			@imagefilltoborder($img_dst, 0, 0, $white, $white);

		
			@imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $set_w, $set_h, $src_w, $src_h);
		break;
	}
	
	$ret["src_width"]   = $src_w;
	$ret["src_height"]  = $src_h;

	$ret["dest_width"]  = $set_w;
	$ret["dest_height"] = $set_h;

	imagejpeg($img_dst, $img_dst_file, $quility);

	return $ret; 
} 



function ImageWaterMark($img_src_file, $img_dst_file, $img_watermark_file, $alpha, $offx, $offy, $quility=80)
{ 
	$ret = array();
	
	list ($src_w, $src_h, $src_t, $src_a) = getimagesize( $img_src_file );

	switch($src_t)
	{
		case 1 : $img_src = @imagecreatefromgif($img_src_file);  break;   // gif
		case 2 : $img_src = @imagecreatefromjpeg($img_src_file); break;   // jpg
		case 3 : $img_src = @imagecreatefrompng($img_src_file);  break;   // png
	} 

	$img_dst = @imagecreatetruecolor($src_w, $src_h); 
	$white   = @imagecolorallocate($img_dst,255,255,255); 
	@imagefilltoborder($img_dst, 0, 0, $white, $white);

	list ($wm_src_w, $wm_src_h, $wm_src_t, $wm_src_a) = getimagesize( $img_watermark_file );

	switch($wm_src_t)
	{
		case 1 : $wm_img_src = @imagecreatefromgif($img_watermark_file);  break;   // gif
		case 2 : $wm_img_src = @imagecreatefromjpeg($img_watermark_file); break;   // jpg
		case 3 : $wm_img_src = @imagecreatefrompng($img_watermark_file);  break;   // png
	} 


	@imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $src_w, $src_h, $src_w, $src_h);
	@imagecopymerge($img_dst, $wm_img_src, $offx, $offy, 0, 0, $wm_src_w, $wm_src_h, $alpha);

	imagejpeg($img_dst, $img_dst_file, $quility);

	return $ret; 
} 



function FileUpload($file, $path, $filename="", $imgfile=true, $size_x=0, $size_y=0, $filesize=1)
{
	if($_FILES[$file])
	{
		$file_name = $_FILES[$file][name];
		$file_type = $_FILES[$file][type];
		$file_size = $_FILES[$file][size];
		$file = $_FILES[$file][tmp_name];
	}

	if($file_name)
	{
		if(!is_uploaded_file($file))
			return array(false, "���������� ���ε� ���� �ʾҽ��ϴ�.");
		if(filesize($file) > $filesize*1024000)
		{
			echo "<script> alert('÷������ �뷮�� ".$filesize."M ���ϸ� �����մϴ�.'); history.go(-1);</script>";
			exit;
		}
		if($imgfile)
		{
			if(filesize($file) > 1024000)
			{
				echo "<script> alert('�̹����� �뷮�� 1M ���ϸ� �����մϴ�.'); history.go(-1);</script>";
				exit;
			}
			$image = getimagesize($file);
			if(!eregi("\.(gif|jpg|png)$", $file_name) || !$image[2])
				return array(false, "�̹����� gif,jpg,png ���ϸ� �����մϴ�.");
			if($size_x && $image[0] > $size_x)
				return array(false, "�̹����� ����ũ��� ".$size_x."px �̳��� �����մϴ�.");
			if($size_y && $image[1] > $size_y)
				return array(false, "�̹����� ����ũ��� ".$size_y."px �̳��� �����մϴ�.");
		}
		if(!move_uploaded_file($file, $path."/".($filename?$filename:$file_name)))
			return array(false, "���ε� ������ �̵����� �ʾҽ��ϴ�.");
		else
		{
			@chmod($path."/".($filename?$filename:$file_name), 0666);
			return array(true, "���������� ���ε尡 �Ϸ�Ǿ����ϴ�.", $image[0], $image[1]);
		}
	}
	return array(true);
}

function MultiFileUpload($file, $idx, $path, $filename="", $imgfile=false, $size_x=0, $size_y=0, $filesize=2)
{
	if($_FILES[$file])
	{
		$file_name = $_FILES[$file][name][$idx];
		$file_type = $_FILES[$file][type][$idx];
		$file_size = $_FILES[$file][size][$idx];
		$file = $_FILES[$file][tmp_name][$idx];
	}

	if($file_name)
	{
		if (!is_uploaded_file($file))
			return array(false, "���������� ���ε� ���� �ʾҽ��ϴ�.");

		if ( filesize($file) > $filesize*1024000 ) {
			echo "<script> alert('÷������ �뷮�� ".$filesize."M ���ϸ� �����մϴ�.'); history.go(-1);</script>";
			exit;
		}
		if ($imgfile) {
			if(filesize($file) > 2*1024000)
			{
				echo "<script> alert('�̹����� �뷮�� 2M ���ϸ� �����մϴ�.'); </script>";
				exit;
			}
			/*
			$image = getimagesize($file);
			if(!eregi("\.(gif|jpg|png)$", $file_name) || !$image[2])
				return array(false, "�̹����� gif,jpg,png ���ϸ� �����մϴ�.");
			if($size_x && $image[0] > $size_x)
				return array(false, "�̹����� ����ũ��� ".$size_x."px �̳��� �����մϴ�.");
			if($size_y && $image[1] > $size_y)
				return array(false, "�̹����� ����ũ��� ".$size_y."px �̳��� �����մϴ�.");
			*/
		}
		if(!move_uploaded_file($file, $path."/".($filename?$filename:$file_name)))
			return array(false, "���ε� ������ �̵����� �ʾҽ��ϴ�.");
		else
		{
			@chmod($path."/".($filename?$filename:$file_name), 0666);
			return array(true, "���������� ���ε尡 �Ϸ�Ǿ����ϴ�.", $image[0], $image[1]);
		}
	}
	return array(true);
}



function CleanOldFile($dirname, $term, $sec)
{
	$tempfile = $dirname."/cache.tmp";

	// 10�и��� 1�ð��� ���� ȭ�� ����
	$ftime = (int)(@filemtime($tempfile));
	if($ftime+$term < time(0))
	{
		$dh = opendir($dirname);

		while (($file = readdir($dh)) !== false)
		{
			if(strlen($file) < 5)
				continue;

			$file = $dirname."/".$file;

			$ftime = (int)(@filemtime($file));
			
			// 1�ð��� ������ �ʾ����� �н�...
			if($ftime+$sec > time(0))
				continue;

			unlink($file);
		}

		closedir($dh);


		// �ӽ�ȭ�� ����...
		$fp = fopen($tempfile, "w");
		fclose($fp);

		chmod($tempfile, 0777);
	}
}
?>