<?
//상수정의
define("MASTER",9);           		//마스터

$master_id = "master";            	//마스터의 아이디 입니다.

//$keyam = "EC655C39874E357EB759AA159FEB5AC5"; 
//$keyam = '544B18D6CAA24D218F38ED34504B3A48';



function hex2binold($h){
  
  if (!is_string($h)) return null;
  
  $r='';
  for ($a=0; $a<strlen($h); $a+=2) { 
  	$r.=chr(hexdec($h{$a}.$h{($a+1)})); 
  
  }
  return $r;
  
}

//echo "hhh=".hex2bin("48656c6c6f20576f726c6421");


function AES_Encode($plain_text)
{
    global $keyam;
    return base64_encode(openssl_encrypt($plain_text, "aes-256-cbc", $keyam, true, str_repeat(chr(0), 16)));
}
function AES_Decode($base64_text)
{
    global $keyam;
    return openssl_decrypt(base64_decode($base64_text), "aes-256-cbc", $keyam, true, str_repeat(chr(0), 16));
}


function encrypt ($key, $value)
{                
    $padSize = 16 - (strlen ($value) % 16) ;
    $value = $value . str_repeat (chr ($padSize), $padSize) ;
    $output = mcrypt_encrypt (MCRYPT_RIJNDAEL_128, $key, $value, MCRYPT_MODE_CBC, str_repeat(chr(0),16)) ;                
    
	//return $output;
	return base64_encode(bin2hex($output));        
}


function decrypt ($key, $value)        
{            	        
	$value = base64_decode ($value);                
    $output = mcrypt_decrypt (MCRYPT_RIJNDAEL_128, $key, hex2bin($value), MCRYPT_MODE_CBC, str_repeat(chr(0),16)) ;                
    
    $valueLen = strlen ($output) ;
    if ( $valueLen % 16 > 0 )
        $output = "";

    $padSize = ord ($output{$valueLen - 1}) ;
    if ( ($padSize < 1) or ($padSize > 16) )
        $output = "";                // Check padding.                

    for ($i = 0; $i < $padSize; $i++)
    {
        if ( ord ($output{$valueLen - $i - 1}) != $padSize )
            $output = "";
    }
    $output = substr ($output, 0, $valueLen - $padSize) ;

    return $output;        
} 






//gcm 관려 메세지 전송
function sendMessageGCM($mess, $fromm, $rgid, $rs, $projec){
		//echo $rs."/".$projec;
	

		$conam = "우리마을 ";
		$auth = "AIzaSyAkBJ_uqGT2Hm1GAl-uBuYDaZOb-U2t_fQ";	  //796396514954


		$headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $auth);
	
		$aa = explode("/",$fromm);
		$mm = $conam;
		if($aa[0] == "Master") $mm = $conam;
	
		$srnum = $aa[1];
		$ad_date = date("Y-m-d H:i:s");
		
	
	
	if($rgid == "All"){    
	
		//보낼 사람이 1000명 이상 이면 1000명 단위로 짤라서 보낸다.
			//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
			$allm = "select count(udid) as su  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and bell = 1  ";
			//echo $allm;
			$kk = mysql_query($allm, $rs);
	
			$row = mysql_fetch_array($kk);
			
			$susinsu = $row[su];
		
		
		if($susinsu < 1000){  //*******************************************
			
			$arr   = array();
			$arr['data'] = array();
			$arr['data']['msg'] = $mess; 
			$arr['data']['name'] = $mm;
			$arr['data']['time'] = $ad_date;
			$arr['data']['recnum'] = $srnum;
			$arr['registration_ids'] = array();

			
				$kkk = "";			
				//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
				
				$allm2 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and (udid != '' and udid != 'udid None') and bell = 1 ".$kkk;
				$kk2 = mysql_query($allm2, $rs);
				
				$c = 0;    //아주 중요
				//천명 이내인 경우
				while($row1 = mysql_fetch_array($kk2)){
					//같은 사람에게 같은 내용으로 발송한 것이 있는지 확인한다.
					$allm3 = "select count(memid) as su  from AAmyGcmSendList where project = '".$projec."' and udid = '".$row1[udid]."'  ";
					$kk3 = mysql_query($allm3, $rs);
					
					
					$kkrow = mysql_fetch_array($kk3);
					//echo $row1[gcmid]." / ".$kkrow[su];

					if($kkrow[su] < 1){
						$arr['registration_ids'][$c] = $row1[gcmid];
							
						//전송 기록을 저장 한다.
						$qss = "insert into AAmyGcmSendList (memid, udid, gcmrecid, project, sendday)values('".$row1[memid]."', '".$row1[udid]."', ".$row1[id].", '".$projec."', '".$ad_date."')"; 
						$qssqr = mysql_query($qss,$rs);
						
						$c++;					
					}
				}

			
			




			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,    'https://android.googleapis.com/gcm/send');
			curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
			curl_setopt($ch, CURLOPT_POST,    true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
			$response = curl_exec($ch);
			
			if ($response === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}else{
				
			
			}
			
			curl_close($ch);
			
			//echo $response;
			//전송 기록을 삭제 한다.
			$dd = mysql_query("delete from AAmyGcmSendList where id > 0", $rs);


			
		}else{    //천명이상에게 발송*************************************************

			//천명 이상에게 보내야 한는 경우
			$endgab = 1000;
			$repage = ceil($row[su] / $endgab);
			$startgab = 0;
			
			$allgcmgab = 0;

			for($a = 0; $a < $repage; $a++){

				$arr   = array();
				$arr['data'] = array();
				$arr['data']['msg'] = $mess; 
				$arr['data']['name'] = $mm;
				$arr['data']['time'] = $ad_date;
				$arr['data']['recnum'] = $srnum;
				$arr['registration_ids'] = array();
				
				
				
					$kkk = "";			
				
					$rowgo = "";
					//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
					$allm1 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0') and (udid != '' and  udid != 'udid None') and bell = 1 ".$kkk."   limit ".$startgab.", ".$endgab."  ";
					$kk1 = mysql_query($allm1, $rs);
					
					$j = 0;
					while($rowgo = mysql_fetch_array($kk1)){
						//같은 사람에게 같은 내용으로 발송한 것이 있는지 확인한다.
						$allm3 = "select count(memid) as su  from AAmyGcmSendList where project = '".$projec."' and udid = '".$rowgo[udid]."'  ";
						$kk3 = mysql_query($allm3, $rs);
						
						$kkrow = mysql_fetch_array($kk3);
						if($kkrow[su] < 1){
																			
							$arr['registration_ids'][$j] = $rowgo[gcmid];
							
							//전송 기록을 저장 한다.
							$qss = "insert into AAmyGcmSendList (memid, udid, gcmrecid, project, sendday)values('".$rowgo[memid]."', '".$rowgo[udid]."', ".$rowgo[id].", '".$projec."', '".$ad_date."')"; 
							$qssqr = mysql_query($qss,$rs);
								
								
							$j++;							
						}
					}
				

					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL,    'https://android.googleapis.com/gcm/send');
					curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
					curl_setopt($ch, CURLOPT_POST,    true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
					$response = curl_exec($ch);
					
					if ($response === FALSE) {
						die('Curl failed: ' . curl_error($ch));
					}else{
						
					
					}
					
					curl_close($ch);
					
					//echo $response;

				$startgab += $endgab;
			}
			
			//전송 기록을 삭제 한다.
			$dd = mysql_query("delete from AAmyGcmSendList where id > 0", $rs);

			
		}
	
	
	}else{   //단독 실행*******************************************************

		$arr   = array();
		$arr['data'] = array();
		$arr['data']['msg'] = $mess; 
		$arr['data']['name'] = $mm."님";
		$arr['data']['time'] = $ad_date;
		$arr['data']['recnum'] = $srnum;
		$arr['registration_ids'] = array();

		$arr['registration_ids'][0] = $rgid;	
		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,    'https://android.googleapis.com/gcm/send');
		curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
		curl_setopt($ch, CURLOPT_POST,    true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
		$response = curl_exec($ch);
		
		if ($response === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}else{
			
		
		}
		
		curl_close($ch);
		
		//echo $response;

	
	}

}

























//문자열 변환
function change_str($otxt){
	$ss = nl2br($otxt);
	//$ss = str_replace("%0A", "<br />", $ss);
	$ss = str_replace("?", "\?", $ss);
	$ss = str_replace("\n", "", $ss);
	$ss = str_replace("\r", "", $ss);
	
	return $ss;
}


//난수발생 초기값
function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}


function disp_array(&$se_jy,&$aa,&$bb){
					global $rs,$ej_group,$ildan;
					
					sort($se_jy);
					for(reset($se_jy);$ss=current($se_jy);next($se_jy)){
							$rs_pro = mysql_query("select * from promember where ej_group = '$ej_group' and ildan = '$ildan' and idan = '$ss'",$rs);
							$idan_tit=mysql_num_rows($rs_pro);
							
							$bb[] = $idan_tit;
							$aa[] = $ss;
					}
}









$jysubmnu = array('전국 (AllCity)','서울 (SeoUl)','인천 (InCheon)','경기 (GyeongGi)','강원 (GangWon)','충북 (ChungBuk)','충남 (ChungNam)','대전 (DaeJeon)','경북 (GyeongBuk)','경남 (GyeongNam)','대구 (DaeGu)','울산 (UlSan)','부산 (BuSan)','전북 (JeonBuk)','전남 (JeonNam)','광주 (GwangJu)','제주 (JeJu)');




function set_jynum($jnum){ //지역번호를 받아 한글로 된 지역이름 반환
	global $jyarray;
	
	return $jyarray[$jnum]; 
}


// MYSQL 연결
function my_connect($host,$id,$pass,$db)
{
	$connect=mysql_connect($host,$id,$pass);
	mysql_select_db($db);
	return $connect;
}



/* 날짜데이터 형식 변환 : 20020512 --> 2002-05-12 */

function shortdate($strvalue) {
	$date_str = substr($strvalue, 0, 4) . "-" . substr($strvalue, 4, 2) . "-" . substr($strvalue, 6, 2);
	return $date_str;
}


//날짜 정상형태로 변환
function covtDate($gStartDay){
	
	$daf = substr($gStartDay,0,5);
	$ff = str_replace($daf, "",$gStartDay);
	$ff = "0".$ff;
	
	if(substr($ff, -3, 1) == "-"){
		$imsi = substr($ff, -5,5);
		
		$gStartDay = $daf.$imsi;
	}else{
		$imsi = substr($ff, -1, 1);
		$imsi = "-0".$imsi;
		$imsi2 = substr($ff, -4, 2);
		
		$gStartDay = $daf.$imsi2.$imsi;
	}
	
	return $gStartDay;
}

//공지 시간을 기본 형태로 변환 한다.
function covtTime($gsTime, $gsBun, $tsinf){
	$gsTime  = "0".$gsTime;
	$gsBun = "0".$gsBun;
	
	$gsTime = substr($gsTime, -2);
	$gsBun = substr($gsBun, -2);

	return $gsTime.":".$gsBun." ".$tsinf;
}







/* 한글 문자열 자르기 함수 */
function shortenStr($str, $maxlen) { 

  if ( strlen($str) <= $maxlen ) 
	return $str; 

  $effective_max = $maxlen - 3; 
  $remained_byte = $effective_max; 
  $retStr=""; 

  $hanStart=0; 

  for ( $i=0; $i < $effective_max; $i++ ) { 
	$char=substr($str,$i,1); 

	if ( ord($char) <= 127 ) { 
		$retStr .= $char; 
		$remained_byte--; 
		continue; 
	} 

	if ( !$hanStart && $remained_byte > 1 ) { 
		$hanStart = true; 
		$retStr .= $char; 
		$remained_byte--; 
		continue; 
	} 

	if ( $hanStart ) { 
		$hanStart = false; 
		$retStr .= $char; 
		$remained_byte--; 
	} 
  } 
  return $retStr .= "..."; 
} 


















//파일관련 함수===============================================================================
function dir_file_list($dpath){
	if($dh = opendir($dpath)){
		while(($filename = readdir($dh)) !== FALSE){
            if ($filename == '.' || $filename == '..') continue;
			$aa[] = $filename;
		}
	}else{
		die("not dir");
	}
	
	return $aa;
}








//파일 업로드 ===============================================================
	function up_img1($url,$bmod,$ext,$txtnum,$tb){
     /*=============================================================================
      파일 업로드

      사용방법 :
        첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
        두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
        세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
        네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
     */

     //입력부분에서 선택한 그림의 수 만큼 반복하면서 그림을 업한다.
	 
     	for($a = 1; $a <= 9; $a++){
       		$s="f_d".$a;
       		if($_FILES[$s]['name']){
          		$upload_return = file_upload($_FILES[$s], $url, $ext, $txtnum.'-'.$a);
       				$pic_name[$a]=$upload_return;
							
							//그림 현황 테이블에 저장===============================================================
							$b_mod_gab = $bmod;
							$img_id_gab = $txtnum;
							$ext_gab = substr($upload_return,-4);
							$img_name_gab = '-'.$a.$ext_gab;
							$img_path_gab = $url;
							
							mysql_query("insert into $tb(b_mode,img_id,img_name,img_path)values('$b_mod_gab','$img_id_gab','$img_name_gab','$img_path_gab')",$rs);
					}
			}
		  //////=====================================================================
		
			return $pic_name;
	}



//썸네일의 생성이 없는 업로드(이미지의 가로크기가 최대이미지 크기보다 크면 그림 크기를 줄인다.)
function file_upload_thumbmu($file, $folder, $allowExt, $file_name) {
	global $max_width;
	
	$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
	if($ext) {
		$allow = explode(',', $allowExt);
		
		if(is_array($allow)) {
			$check = in_array($ext, $allow);
		} else {
			$check = ($ext == $allow) ? true : false;
		}
	}

	if(!$ext || !$check) exit('<script type="text/javascript">alert(\''.$ext.' No file\'); history.go(-1);</script>');
	
	$upload_file = $folder.$file_name.".".strtolower($ext);
	if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
  		@chmod($upload_file, 0707);
		$return = '<script type="text/javascript">function copy(str) { clipboardData.setData("Text", str); alert("경로가 복사 되였습니다."); }</script>';
		$return.= '업로드 된 파일 경로 : <a href="#" onclick="copy(\''.$upload_file.'\'); return false;">'.$upload_file.'</a>';

		//화일의 크기 검사
		$img_info=@getimagesize($upload_file);
		if($img_info[0] > $max_width){
			//이미지 크기줄이기 위해 원본의 이름변경.
			rename($upload_file,$folder."bak-".$file_name.".".strtolower($ext));
				  
			//이미지 크기를 줄여서 생성한다
			GD2_resize_imgX($max_width,"",$folder."bak-".$file_name.".".strtolower($ext));
			unlink($folder."bak-".$file_name.".".strtolower($ext));
		}	

		return $file_name.".".$ext;
	} else {
   		exit('<script type="text/javascript">alert(\'Up_err\'); history.go(-1);</script>');
	}
}


//파일 업로드 함수
function file_upload_showping($file, $folder, $allowExt, $file_name) {
	global $max_width;

	$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
	if($ext) {
		$allow = explode(',', $allowExt);
		if(is_array($allow)) {
		    $check = in_array($ext, $allow);
		} else {
			$check = ($ext == $allow) ? true : false;
		}
	}

	if(!$ext || !$check) exit('<script type="text/javascript">alert(\''.$ext.' 파일은 업로드 하실수 없습니다!\'); history.go(-1);</script>');
	
	$upload_file = $folder.$file_name.".".strtolower($ext);
	$upload_file1 = $upload_file;

	if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
  		@chmod($upload_file, 0707);
		$return = '<script type="text/javascript">function copy(str) { clipboardData.setData("Text", str); alert("경로가 복사 되였습니다."); }</script>';
		$return.= '업로드 된 파일 경로 : <a href="#" onclick="copy(\''.$upload_file.'\'); return false;">'.$upload_file.'</a>';

		//화일의 크기 검사
		$img_info=@getimagesize($upload_file);
		if($img_info[0] > $max_width){
			//이미지 크기줄이기 위해 원본의 이름변경.
			rename($upload_file,$folder."bak-".$file_name.".".strtolower($ext));
				  
			//이미지 크기를 줄여서 생성한다
			GD2_resize_imgX($max_width,"",$folder."bak-".$file_name.".".strtolower($ext));
			unlink($folder."bak-".$file_name.".".strtolower($ext));
		}


		GD2_make_thumb(140,140,'thumb/s_',$upload_file1);  //썸네일 생성
                    
		return $file_name.".".$ext;
	} else {
   		exit('<script type="text/javascript">alert(\'업로드에 실패하였습니다!\'); history.go(-1);</script>');
	}
}



//파일 업로드 함수
function file_upload_moa($file, $folder, $allowExt, $file_name) {
	global $max_width;

	$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
	if($ext) {
		$allow = explode(',', $allowExt);
		if(is_array($allow)) {
		    $check = in_array($ext, $allow);
		} else {
			$check = ($ext == $allow) ? true : false;
		}
	}

	if(!$ext || !$check) exit('<script type="text/javascript">alert(\''.$ext.' 파일은 업로드 하실수 없습니다!\'); history.go(-1);</script>');
	
	$upload_file = $folder.$file_name.".".strtolower($ext);
	$upload_file1 = $upload_file;

	if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
  		@chmod($upload_file, 0707);
		$return = '<script type="text/javascript">function copy(str) { clipboardData.setData("Text", str); alert("경로가 복사 되였습니다."); }</script>';
		$return.= '업로드 된 파일 경로 : <a href="#" onclick="copy(\''.$upload_file.'\'); return false;">'.$upload_file.'</a>';

		//화일의 크기 검사
		$img_info=@getimagesize($upload_file);
		if($img_info[0] > $max_width){
			//이미지 크기줄이기 위해 원본의 이름변경.
			rename($upload_file,$folder."bak-".$file_name.".".strtolower($ext));
				  
			//이미지 크기를 줄여서 생성한다
			GD2_resize_imgX($max_width,"",$folder."bak-".$file_name.".".strtolower($ext));
			unlink($folder."bak-".$file_name.".".strtolower($ext));
		}


		GD2_make_thumb(70,70,'thumb/s_',$upload_file1);  //썸네일 생성
                    
		return $file_name.".".$ext;
	} else {
   		exit('<script type="text/javascript">alert(\'업로드에 실패하였습니다!\'); history.go(-1);</script>');
	}
}




//파일 업로드 함수
function file_upload($file, $folder, $allowExt, $file_name) {
	global $max_width;
	
	$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
  
  if($ext) {
			$allow = explode(',', $allowExt);
      if(is_array($allow)) {
		      $check = in_array($ext, $allow);
      } else {
          $check = ($ext == $allow) ? true : false;
      }
	}

  if(!$ext || !$check) exit($ext.'<script type="text/javascript">alert(\''.$ext.'-ext1 파일은 업로드 하실수 없습니다!\'); history.go(-1);</script>');
	
	$upload_file = $folder.$file_name.".".strtolower($ext);

  if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
  		@chmod($upload_file, 0707);
      $return = '<script type="text/javascript">function copy(str) { clipboardData.setData("Text", str); alert("경로가 복사 되였습니다."); }</script>';
      $return.= '업로드 된 파일 경로 : <a href="#" onclick="copy(\''.$upload_file.'\'); return false;">'.$upload_file.'</a>';
 
 		//화일의 크기 검사
		$img_info=@getimagesize($upload_file);
		if($img_info[0] > $max_width){
			//이미지 크기줄이기 위해 원본의 이름변경.
			rename($upload_file,$folder."bak-".$file_name.".".strtolower($ext));
				  
			//이미지 크기를 줄여서 생성한다
			GD2_resize_imgX($max_width,"",$folder."bak-".$file_name.".".strtolower($ext));
			unlink($folder."bak-".$file_name.".".strtolower($ext));
		}
 
                    
      GD2_make_thumb(120,120,'thumb/s_',$upload_file);  //썸네일 생성
                    
      return $file_name.".".$ext;
  } else {
   		exit('<script type="text/javascript">alert('.$ext.'-ext2 \'123업로드에 실패하였습니다!\'); history.go(-1);</script>');
  }
}



//이미지 가로크기 변경여 줍니다.

function GD2_resize_imgX($max_x,$dst_name/*생성될 이미지파일이름*/,$src_file/*원본 파일이름*/) {


        $img_info=@getimagesize($src_file);
        $sx = $img_info[0];
        $sy = $img_info[1];
        //썸네일 보다 큰가?
        if ($sx > $max_x) {
                $nanum = $max_x / $sx;
                $thumb_y = $sy * $nanum;
                $thumb_x = $max_x;
        } else {
                $thumb_y=$sy; //이미지의 세로 크기 설정
                $thumb_x=$sx; //이미지의 가로 크기 설정
        }


                $_dq_tempFile=basename($src_file);                          //파일명 추출
                $_dq_tempDir=str_replace($_dq_tempFile,"",$src_file);       //경로 추출
                $ss = substr($_dq_tempFile,4);                              //'bak-' 뻰 순수 파일 이름 구함
                $_dq_tempFile=$_dq_tempDir.$dst_name.$ss;                   //경로 + 새 파일명 생성





                $_create_thumb_file = true;
                if (file_exists($_dq_tempFile)) { //섬네일 파일이 이미 존제한다면 이미지의 사이즈 비교
                        $oldjy_img=@getimagesize($_dq_tempFile);
                        if($oldjy_img[0] != $thumb_x) $_create_thumb_file = true; else $_create_thumb_file = false;
                } 
                
                
                if ($_create_thumb_file) {
                        // 복제
                  	if ($img_info[2]=="2") {
                        $src_img=ImageCreateFromjpeg($src_file);
                    }elseif($img_info[2]=="1"){
                        $src_img=ImageCreateFromgif($src_file);
                    }

                        
                    $dst_img=ImageCreateTrueColor($thumb_x, $thumb_y);
                    ImageCopyResampled($dst_img,$src_img,0,0,0,0,$thumb_x,$thumb_y,$sx,$sy);
                    Imagejpeg($dst_img,$_dq_tempFile,100);
                    // 메모리 초기화
                    ImageDestroy($dst_img);
                }
}


//작은 썸네일 이미지 생성
function GD2_make_thumb($max_x,$max_y/*줄여줄 이미지의 가로세로 크기*/,$dst_name/*생성될 이미지파일이름*/,$src_file/*원본 파일이름*/) {

        $img_info=@getimagesize($src_file);
        $sx = $img_info[0];
        $sy = $img_info[1];
        //썸네일 보다 큰가?
        if ($sx>$max_x || $sy>$max_y) {
                if ($sx>$sy) {
                                $thumb_y=ceil(($sy*$max_x)/$sx);
                                $thumb_x=$max_x;
                } else {
                                $thumb_x=ceil(($sx*$max_y)/$sy);
                                $thumb_y=$max_y;
                }
        } else {
                $thumb_y=$sy;
                $thumb_x=$sx;
        }

                $_dq_tempFile=basename($src_file);                                //파일명 추출
                $_dq_tempDir=str_replace($_dq_tempFile,"",$src_file);        //경로 추출
                $_dq_tempFile=$_dq_tempDir.$dst_name.$_dq_tempFile;        //경로 + 새 파일명 생성

                $_create_thumb_file = true;
                if (file_exists($_dq_tempFile)) { //섬네일 파일이 이미 존제한다면 이미지의 사이즈 비교
                        $oldjy_img=@getimagesize($_dq_tempFile);
                        if($oldjy_img[0] != $thumb_x) $_create_thumb_file = true; else $_create_thumb_file = false;
                        if($oldjy_img[1] != $thumb_y) $_create_thumb_file = true; else $_create_thumb_file = false;
                } 
                if ($_create_thumb_file) {
                        // 복제
                  	if ($img_info[2]=="2") {
                        $src_img=ImageCreateFromjpeg($src_file);
                    }elseif($img_info[2]=="1"){
                        $src_img=ImageCreateFromgif($src_file);
                    }
                        $dst_img=ImageCreateTrueColor($thumb_x, $thumb_y);
                        ImageCopyResampled($dst_img,$src_img,0,0,0,0,$thumb_x,$thumb_y,$sx,$sy);
                        Imagejpeg($dst_img,$_dq_tempFile,100);
                        // 메모리 초기화
                        ImageDestroy($dst_img);
                }
}






?>
