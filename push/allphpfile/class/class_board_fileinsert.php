<?
/**************************************************************************
*
*                           class_board_fileinsert.php
*                               
*	first Write			:	2006�� 11�� 11��
*   directed by			:	yoon ho young
*   Coded by			:	Jun Young Shin.
*   comment				:	÷�� ���� �� �̹���, ����� ���� Ŭ����
*   
*   
**************************************************************************/
class BoardFile
{
	function File_upload($dir_path="",$dir_name="",$myfile1="",$tmp_file1="",$type="file")
	{
		GLOBAL $saveDirType,$default_dir;

		$dir =explode("/",$dir_name);			//���丮 ��� �迭�� ����
		$now_day=explode("-",$saveDirType);		//���� ����(��,����) �迭�� ����
		
		$arr_length = sizeof($now_day);

		$dirname[0] = $dir_path;

		//// �⺻ ���丮 �з�
		for($k=0;$k<sizeof($dir);$k++){
			$dirname[0] .= "/".$dir[$k];
		}

		//// ��¥�� �з�
		for($n=0;$n<$arr_length;$n++){
			$dirname[$n+1] = $dirname[$n]."/".$now_day[$n];
		}
		
		//// ���丮 ������ ����
		if(!(is_dir($dirname[$arr_length+1]))) 
		{
			for($m=0;$m<$arr_length+1;$m++){
				if(!(is_dir($default_dir.$dirname[$m]))) @mkdir($default_dir.$dirname[$m],0777);
			}

		} 

		$directory  = $dirname[$arr_length]."/";

		$file01		= $tmp_file1;
		$filename01 = $myfile1;
		$ext01 = substr(strrchr($filename01,"."),1);

		$this->Ext_chk($ext01,$type);	// ���ε� ���ѵ� �������� �˻�("file","img")

		$fake_file01=date("YmdHis").rand(0,100).".".$ext01;	//�������� ���� �̸� �����

		$oldmask = umask(002); 
		@move_uploaded_file($file01, $default_dir.$directory.$fake_file01);
		umask($oldmask);

		return $fake_file01;
	}

	function Ext_chk($uploadfilename, $type){
		$uploadfilename = strtolower($uploadfilename);
		switch($type){
			case "file":
				if(eregi("php|php3|html|htm|phtml|com|bat|exe|inc|js|ph|asp|jsp|cgi|pl",$uploadfilename))
					$this->msg_back('���ε尡 ���ѵ� �����Դϴ�.');
				break;
			case "img":
				if(!eregi("jpg|jpeg|png",$uploadfilename))
					$this->msg_back('���ε尡 ���ѵ� �����Դϴ�.');
				break;
			case "search":
				if(eregi("jpg|jpeg|gif|png|bmp",$uploadfilename)) return "img";
				else return "file";
				break;
		}

		return;
	}


	// ��¥���� ���丮 �����ϱ� ($type=1 : �⵵  / $type=2 : ���  / $type=3 : ����� )
	function MakeDir($fake, $type=2){

		switch($type){
			case 1:
				$now_day=date("Y");
				break;
			case 2:
				$now_day=explode("-",date("Y-m"));
				break;
			case 3:
				$now_day=explode("-",date("Y-m-d"));
				break;
		}

		if (is_array($now_day)){
			
			for($i=0;$i<=sizeof($now_day);$i++){
				$tmpfake .= $now_day[$i]."/";
			}
			$fake = $tmpfake.$fake;
		}else{
			$fake = $now_day."/".$fake;
		}
		return $fake;
	}

	function msg_back($msg){
		echo "<script language=javascript>alert('$msg');history.back();</script>";
		exit;
	}


	//���� ���� ����
	function delTheFile($file,$savedir)
	{
		if ($file) {
			$dbfile_exist = file_exists("$savedir/$file");
			if( $dbfile_exist ) unlink("$savedir/$file");		
		}
	}


	//����ϻ����Լ�
	function thumbnail($file, $save_filename, $save_path, $max_width, $max_height) {
		// ���۹��� �̹��� ������ �޴´�

		$img_info = getImageSize($file);
		// ������ GD ������ ������� GIF�� �׳� ����
		if($img_info[2] == 1) {
			copy($file,$save_path.$save_filename);
			return true;
		}

		// ���۹��� �̹����� ���˰� ��� (gif, jpg png)
		if($img_info[2] == 1) {
				$src_img = ImageCreateFromGif($file);
		} else if($img_info[2] == 2) { 
				$src_img = ImageCreateFromJPEG($file);
		} else if($img_info[2] == 3) {
				$src_img = ImageCreateFromPNG($file);
		} else {
				return 0;
		}
		

		// ���۹��� �̹����� ���� ������ �����
		$img_width = $img_info[0];
		$img_height = $img_info[1];

		//�׸�  ������� ���̱� �Ϸ��� �ּ�����

		if($img_width <= $max_width) {
				$max_width = $img_width;
				$max_height = $img_height;
		}
		
		if($img_width > $max_width){
				$max_height = ceil(($max_width / $img_width) * $img_height);
		}

		
		// ���ο� Ʈ��Ÿ�� �̹����� ����
		if($img_info[2] == 1) {
			$dst_img = imageCreate($max_width, $max_height);
			ImageColorAllocate($dst_img,255,255,255);
		} else if ($img_info[2] == 2) {
			//$dst_img = imageCreate("100","100");	 //���� �˾�����.
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			$col = ImageColorAllocate($dst_img,0,255,0);
			$ret_str = ImageFill($dst_img,0,0,$col);
		} else {
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			ImageColorAllocate($dst_img,255,255,255);
		}

		
		// �̹����� �������� ������ ���ο� �̹��� ����
		ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
		
		
		//�̹��� ����
		if($img_info[2] == 1) {
				if (!function_exists("ImageGif")) { 
					echo ("gif �̹��� ������ �������� �ʽ��ϴ�.");
					exit; 
				} 
				ImageInterlace($dst_img);
				ImageGif($dst_img, $save_path.$save_filename);
		} else if($img_info[2] == 2) {
				if (!function_exists("ImageJPEG")) { 
					echo ("jpg �̹��� ������ �������� �ʽ��ϴ�.");
					exit; 
				} 	
				ImageInterlace($dst_img);

				ImageJPEG($dst_img, $save_path.$save_filename);
		} else if($img_info[2] == 3) {
				if (!function_exists("ImagePNG")) { 
					echo ("png �̹��� ������ �������� �ʽ��ϴ�.");
					exit; 
				}	
				ImagePNG($dst_img, $save_path.$save_filename);
		}
		
		// �ӽ� �̹��� ����
		ImageDestroy($dst_img);
		ImageDestroy($src_img);
		
	} 
}
?>