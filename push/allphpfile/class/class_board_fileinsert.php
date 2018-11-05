<?
/**************************************************************************
*
*                           class_board_fileinsert.php
*                               
*	first Write			:	2006년 11월 11일
*   directed by			:	yoon ho young
*   Coded by			:	Jun Young Shin.
*   comment				:	첨부 파일 및 이미지, 썸네일 생성 클래스
*   
*   
**************************************************************************/
class BoardFile
{
	function File_upload($dir_path="",$dir_name="",$myfile1="",$tmp_file1="",$type="file")
	{
		GLOBAL $saveDirType,$default_dir;

		$dir =explode("/",$dir_name);			//디렉토리 경로 배열로 저장
		$now_day=explode("-",$saveDirType);		//저장 폴더(년,월별) 배열로 저장
		
		$arr_length = sizeof($now_day);

		$dirname[0] = $dir_path;

		//// 기본 디렉토리 분류
		for($k=0;$k<sizeof($dir);$k++){
			$dirname[0] .= "/".$dir[$k];
		}

		//// 날짜별 분류
		for($n=0;$n<$arr_length;$n++){
			$dirname[$n+1] = $dirname[$n]."/".$now_day[$n];
		}
		
		//// 디렉토리 없으면 생성
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

		$this->Ext_chk($ext01,$type);	// 업로드 제한된 파일인지 검사("file","img")

		$fake_file01=date("YmdHis").rand(0,100).".".$ext01;	//랜덤으로 파일 이름 만들기

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
					$this->msg_back('업로드가 제한된 파일입니다.');
				break;
			case "img":
				if(!eregi("jpg|jpeg|png",$uploadfilename))
					$this->msg_back('업로드가 제한된 파일입니다.');
				break;
			case "search":
				if(eregi("jpg|jpeg|gif|png|bmp",$uploadfilename)) return "img";
				else return "file";
				break;
		}

		return;
	}


	// 날짜별로 디렉토리 생성하기 ($type=1 : 년도  / $type=2 : 년월  / $type=3 : 년월일 )
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


	//이전 파일 삭제
	function delTheFile($file,$savedir)
	{
		if ($file) {
			$dbfile_exist = file_exists("$savedir/$file");
			if( $dbfile_exist ) unlink("$savedir/$file");		
		}
	}


	//썸네일생성함수
	function thumbnail($file, $save_filename, $save_path, $max_width, $max_height) {
		// 전송받은 이미지 정보를 받는다

		$img_info = getImageSize($file);
		// 서버에 GD 버젼이 낮을경우 GIF는 그냥 저장
		if($img_info[2] == 1) {
			copy($file,$save_path.$save_filename);
			return true;
		}

		// 전송받은 이미지의 포맷값 얻기 (gif, jpg png)
		if($img_info[2] == 1) {
				$src_img = ImageCreateFromGif($file);
		} else if($img_info[2] == 2) { 
				$src_img = ImageCreateFromJPEG($file);
		} else if($img_info[2] == 3) {
				$src_img = ImageCreateFromPNG($file);
		} else {
				return 0;
		}
		

		// 전송받은 이미지의 실제 사이즈 값얻기
		$img_width = $img_info[0];
		$img_height = $img_info[1];

		//그림  비율대로 줄이기 하려면 주석해제

		if($img_width <= $max_width) {
				$max_width = $img_width;
				$max_height = $img_height;
		}
		
		if($img_width > $max_width){
				$max_height = ceil(($max_width / $img_width) * $img_height);
		}

		
		// 새로운 트루타입 이미지를 생성
		if($img_info[2] == 1) {
			$dst_img = imageCreate($max_width, $max_height);
			ImageColorAllocate($dst_img,255,255,255);
		} else if ($img_info[2] == 2) {
			//$dst_img = imageCreate("100","100");	 //색이 검어진다.
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			$col = ImageColorAllocate($dst_img,0,255,0);
			$ret_str = ImageFill($dst_img,0,0,$col);
		} else {
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			ImageColorAllocate($dst_img,255,255,255);
		}

		
		// 이미지를 비율별로 만든후 새로운 이미지 생성
		ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
		
		
		//이미지 생성
		if($img_info[2] == 1) {
				if (!function_exists("ImageGif")) { 
					echo ("gif 이미지 생성을 지원하지 않습니다.");
					exit; 
				} 
				ImageInterlace($dst_img);
				ImageGif($dst_img, $save_path.$save_filename);
		} else if($img_info[2] == 2) {
				if (!function_exists("ImageJPEG")) { 
					echo ("jpg 이미지 생성을 지원하지 않습니다.");
					exit; 
				} 	
				ImageInterlace($dst_img);

				ImageJPEG($dst_img, $save_path.$save_filename);
		} else if($img_info[2] == 3) {
				if (!function_exists("ImagePNG")) { 
					echo ("png 이미지 생성을 지원하지 않습니다.");
					exit; 
				}	
				ImagePNG($dst_img, $save_path.$save_filename);
		}
		
		// 임시 이미지 삭제
		ImageDestroy($dst_img);
		ImageDestroy($src_img);
		
	} 
}
?>