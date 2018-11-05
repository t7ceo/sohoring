<?
//상수정의
define("MASTER",9);           		//마스터

$master_id = "master";            	//마스터의 아이디 입니다.


$homepage   = "index.php";
$_base_url  = "http://".$urlPath."/";
$_sbase_url = "http://".$urlPath."/";




//gcm 관려 메세지 전송
function sendMessageGCMTest($mess, $fromm, $rgid, $rs, $projec){

	switch($projec){
	case "chungage":
		$conam = "천가게";
		$auth = "AIzaSyA4RGPBhsisxJjRiq7beQe0gK3nEBTVjZc";	  //825296947339
	break;
	}




	//$auth = "AIzaSyD0cJxemD_qVgL_4vpyoeThj3Xc2hkXAEY";
	//$headers = array('Content-Type:application/json', $auth);
	$headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $auth);
	

	$mm = "회원의 메시지";
	if($fromm == "Master ") $mm = "의 공지사항";

	
	$ad_date = date("Y-m-d H:i:s");
	
	
	if($rgid == "All"){    //보낼 사람이 1000명 이상 이면 1000명 단위로 짤라서 보낸다.
		//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
		$allm = "select count(udid) as su  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  ";
		$kk = mysql_query($allm, $rs);
		$c = 0;
		
		$row = mysql_fetch_array($kk);
		
		
		if($row[su] < 1000){
			
			$arr   = array();
			$arr['data'] = array();
			$arr['data']['msg'] = $mess; 
			$arr['data']['name'] = $conam.$fromm.$mm;
			$arr['data']['time'] = $ad_date;
			$arr['registration_ids'] = array();
			
			//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
			$allm2 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and (udid != '' or udid != 'udid None') ";
			$kk2 = mysql_query($allm2, $rs);
			
			//천명 이내인 경우
			while($row1 = mysql_fetch_array($kk2)){
				$arr['registration_ids'][$c] = $row1[gcmid];
					
							//전송 기록을 저장 한다.
				$qss = "insert into soho_AAmyGcmSendList (memid, udid, gcmrecid, project, sendday)values('".$row1[memid]."', '".$row1[udid]."', ".$row1[id].", '".$projec."', '".$ad_date."')"; 
				$qssqr = mysql_query($qss,$rs);

						
				$c++;
			}
			
			
		}else{

			//천명 이상에게 보내야 한는 경우
			$endgab = 1000;
			$repage = ceil($row[su] / $endgab);
			$startgab = 0;

			for($a = 0; $a < $repage; $a++){
				
				$arr   = array();
				$arr['data'] = array();
				$arr['data']['msg'] = $mess; 
				$arr['data']['name'] = $conam.$fromm.$mm;
				$arr['data']['time'] = $ad_date;
				$arr['registration_ids'] = array();
				
					$rowgo = "";
					//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
					$allm1 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0') and (udid != '' or udid != 'udid None')   limit ".$startgab.", ".$endgab."  ";
					$kk1 = mysql_query($allm1, $rs);
					
					$j = 0;
					while($rowgo = mysql_fetch_array($kk1)){
						$arr['registration_ids'][$j] = $rowgo[gcmid];
						
						//전송 기록을 저장 한다.
						$qss = "insert into soho_AAmyGcmSendList (memid, udid, gcmrecid, project, sendday)values('".$rowgo[memid]."', '".$rowgo[udid]."', ".$rowgo[id].", '".$projec."', '".$ad_date."')"; 
						$qssqr = mysql_query($qss,$rs);
							
							
						$j++;							
					}


				$startgab += $endgab;


			
			}


		}
	
	}else{      //단독 발송
		
		$arr   = array();
		$arr['data'] = array();
		$arr['data']['msg'] = $mess; 
		$arr['data']['name'] = $conam.$fromm.$mm;
		$arr['data']['time'] = $ad_date;
		$arr['registration_ids'] = array();

		
		$arr['registration_ids'][0] = "APA91bG5ZObi-yNBY2WPkl_E-C_5WtsmcoEbYUvZT8TvsJBg8tCrg-C9E0of-vRzEJh3RKJ9SpqjFbiPOOG7D4agxIvYfLJfEA779wYlr18upJliEVrpl6Nq598qy07_sziGkp_wUxtZ";   //$rgid;	
		
		//function sendMessageGCMTest($mess, $fromm, $rgid, $rs, $projec){
		
		//전송 기록을 저장 한다.
		$qss = "insert into soho_AAmyGcmSendList (memid, udid, gcmrecid, project, sendday)values('t7ceo', '3ae7085a8b805c68', 0, 'jci', '".$ad_date."')"; 
		$qssqr = mysql_query($qss,$rs);

		
		
		
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
		
		echo $response;

		
	}

}





//참고 : http://simulz.kr/zbxe/1868799
function newPost($title, $description, $blid, $blpass){ 
	//네이버는 카테고리, 태그값을 아예 받질 않는다..그리고 공란이면 에러나는듯함.
	//네이버는 제목, 내용을 string타입으로 보내야 한다. 남들은 base64인데 이유 모름..
	$g_blog_url = "https://api.blog.naver.com/xmlrpc"; 
	$user_id = $blid; 
	$password = $blpass;
	$blogid = $blid;

	$publish = true;//:공개할거냐 안할거냐인데, 네이버의 블로그 설정에 따라 이므로 이건 상관없음(아무렇게나 해도 됨)

	$client = new xmlrpc_client($g_blog_url); // $client변수에 블로그주소를 저장 

	$struct = array( // body (struct변수에 제목, 내용 카테고리, 테그를 배열화해서 넣음) 
					'title'			=> new xmlrpcval($title, "string"), 
					'description'   => new xmlrpcval($description, "string") 
					);
					

	$f = new xmlrpcmsg("metaWeblog.newPost", 
					   array( 
							  new xmlrpcval($blogid, "string"), // blogid.(블로그아이디) 
							  new xmlrpcval($user_id, "string"), // user ID. (아이디) 
							  new xmlrpcval($password, "string"), // password (비밀번호) 
							  new xmlrpcval($struct , "struct"), 
							  new xmlrpcval($publish, "boolean") //publish... true는 공개, false는 비공개가 된다.
							) 
						); 

	$f->request_charset_encoding = 'UTF-8'; 

	return $response = $client->send($f); // $response에 실행명령삽입($client변수로 블로그 로그인 후 send($f) 글 전달함 
} 

























/*
$wrgo_add  = $_base_url.$homepage."?t7mod=43&fndid=";     //마스터의 경우로 회원 상세정보로 간다.
$wrgo_addn = $_base_url.$homepage."?t7mod=11&to_mem=";    //쪽지 보내기 페이지로 간다.


//모든 이미지를 저장하고 있는 폴더
//$holdimg_path = $_mb_url."image/";
$holdimg_path    = $_cdn2_url."mimage/";
$page_img        = '/t7/image/';

//blank 파일의 이미지
$blank_img = "";

//마스터 아이디 배열
$master_arry = array("master","luck");

//트렌드앨범 삭제가능 아이디
$moamoadel = array("iceruvi");
//와우앨범 삭제가능
switch($alsql){
case 0:   //와우무료의 경우
	$waudel = array("iceruvi","fkdfkd222","s2misun");
break;
case 3:   //이벤트 홍보의 경우
	$waudel = array("iceruvi");
break;
}




//세션값 설정
//선택한 도시의 도시값을 설정
if(!isset($dosi)){
	if(session_is_registered("dosi_gab")) $dosi = $dosi_gab;
	else $dosi = 0;
}else{
	//선택된 도시 쿠키에 저장
	$dosi_gab = $dosi;
	session_register("dosi_gab");
}

//현재의 도시값
$now_dosi = $jyarray[$dosi];


//모드값 설정
if(!isset($t7mod)){
	if(session_is_registered("t7mod_gab")) $t7mod = $t7mod_gab;
	else $t7mod = 107;
}else{
	//선택된 모드 쿠키에 저장
	$t7mod_gab = $t7mod;
	session_register("t7mod_gab");
}

if(($dosi == 18 || $dosi == 17) && $t7mod == 772){
	$dosi = 0;
}





//선택한 도시의 업체를 선택하는 번호
if(!isset($co)){
	if(session_is_registered("co_gab")) $co = $co_gab;
	else $co = 0;
}else{
	//선택된 모드 쿠키에 저장
	$co_gab = $co;
	session_register("co_gab");
}
*/




//칼라설정----------------------
//전체 배경색
$list_sebg      = "#fdedc7";    //선택된 리스트의 배경
$all_bg_color   = "#dbd9d2";
$bas_line1      = "#bab8b1";
$head_bg_color  = "#312f24";
$head_mnu_bg    = "#000000";
$under_bg_color = "#9a98c6";
//소메뉴 배경
$so_menu_bg     = "#9b9b9c";
//가운데 내용출력부분 배경색
$mid_back_color = "#ffffff";
//소제목 색상
$so_tit_color   = "#555555";
//리스트 타이틀 배경색
$list_tit_bg = "#89c5f4";
$list_tit_bg1 = "#dbeffc";
//가운데 타이틀 배경색
$midbox_bgcolor = "#252525";
$midbox_bgcolor2 = "#ffffff";
//강제 출력업체의 대표이미지 배경색 설정
if(!isset($vco)) $midbox_bgcolor = "#252525";

//칼라설정 끝--------------------

//경품당첨정보가 있는 업체 리스트
//$colst_arry = array("");

$seximg   = array("manface.png","girlface.png");
$mgsexgab = array("남","여","미설정");
$tools = array("","망치","삽");
$tools_point = array(5,8,10);  //도구의 가격-망치,삽,열쇠
$naras = array("???","물의 나라","밀의 나라","허니랜드","정보나라","쿠키랜드");



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

	if(!$ext || !$check) exit('<script type="text/javascript">alert(\''.$ext.' 파일은 업로드 하실수 없습니다!-nofile\'); history.go(-1);</script>');
	
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
   		exit('<script type="text/javascript">alert(\'업로드에 실패하였습니다!-up_err\'); history.go(-1);</script>');
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
 
                    
      GD2_make_thumb(60,60,'thumb/s_',$upload_file);  //썸네일 생성
                    
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
