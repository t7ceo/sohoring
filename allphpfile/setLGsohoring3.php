<?
include 'config.php';
include 'util.php';
//include_once $_my_path.'class/class_mysql.php';   //부모 클래스
//include_once $_my_path.'class/my_mysql.php';      //자식 클래스



		//TXExc0I2c1VmQmNieHJwYTNGa3hqdz09
		//$CTNe = "ZmE0YTMxYzJkZDQ2YTJjYTM2YjZiZmE1YmU4YWQ0YTk=";   //변환 정답
	

	//echo $_SERVER["REMOTE_ADDR"];  //클라이언트 아이피 주소 확인 
	//echo $_SERVER["SERVER_ADDR"];  //서버의 아이피 주소
	//echo $_SERVER["SERVER_PORT"];
	//$mycon = new MyMySQL;
	//$rs = $mycon->connect($host,$dbid,$dbpass);
	//$mycon->select($dbname);
	
	//$ad_date = date("Y-m-d H:i:s");



				$xmlg = '<?xml version="1.0" encoding="euc-kr"?><restFeelring>';
				//$xmlg .= '<restFeelring>';
				
				//$xmlg .= '<API_ID>'.$API_ID.'</API_ID><TELECOM_CODE>'.$TELECOM_CODE.'</TELECOM_CODE><SERVICE_CODE>'.$SERVICE_CODE.'</SERVICE_CODE><CTN>'.$CTNe.'</CTN>';
				//$xmlg .= '</restFeelring>';
				

	//echo "김성식";
	//$CTNe = encrypt($keyam, "김성식");
	//echo $CTNe;
	//echo decrypt($keyam, $CTNe); 


	//$hostG = "sohoring.com:41020";


	$tel_code = "LGU";
	$ser_code = "SOHO001";

	$API_ID = trim($_GET[mode]);
	switch($API_ID){
	case "GetStream":   //미리듣기 가져온다 
		$path = "/restapi/telecom/";
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<PID>'.$_POST[PID].'</PID>';	
	break;
	case "SohoRegStatus":    //소호링 가입여부 확인
$path = "/restapi/telecom/";
//$path = "/sohoring/allphpfile/testXml.php";
$CTNe = trim(encrypt($keyam, $_GET[CTN]));
$xmlg .= '<API_ID>'.$API_ID.'</API_ID><TELECOM_CODE>'.$tel_code.'</TELECOM_CODE><SERVICE_CODE>'.$ser_code.'</SERVICE_CODE><CTN>'.$CTNe.'</CTN>';
/*
$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
$xmlg .= '<TELECOM_CODE>'.$_POST[TELECOM_CODE].'</TELECOM_CODE>';
$xmlg .= '<SERVICE_CODE>'.$_POST[SERVICE_CODE].'</SERVICE_CODE>';
$xmlg .= '<CTN>'.$CTNe.'</CTN>';
*/

	break;
	case "SetRingBackTone":   //링을 설정한다 조회 
		$path = "/restapi/telecom/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<MAIN_TYPE>'.$_POST[MAIN_TYPE].'</MAIN_TYPE>';
				$xmlg .= '<SVC_TYPE>'.$_POST[SVC_TYPE].'</SVC_TYPE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';
				$xmlg .= '<NUMDATE>'.$_POST[NUMDATE].'</NUMDATE>';
				$xmlg .= '<PID>'.$_POST[PID].'</PID>';
				$xmlg .= '<REQ_COMP_CODE>'.$_POST[REQ_COMP_CODE].'</REQ_COMP_CODE>';
				
	break;
	case "BoxChk":   //통화연결음 설정정보 조회 
		$path = "/restapi/telecom/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';
				$xmlg .= '<BOX_GUBUN>'.$_POST[BOX_GUBUN].'</BOX_GUBUN>';
	break;
	case "RegistMember":   //소호링 가입 
		$path = "/restapi/telecom/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';
				$xmlg .= '<VAS_KIND>'.$_POST[VAS_KIND].'</VAS_KIND>';
				$xmlg .= '<SOC_CODE>'.$_POST[SOC_CODE].'</SOC_CODE>';
				$xmlg .= '<PROGRAM_ID></PROGRAM_ID>';
				$xmlg .= '<IS_MENT></IS_MENT>';
	break;
	case "CertifyCustomer":   //본인 인증 요청
		$path = "/rest/ringjk/CertifyCustomer/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
		$CERTIFY_INFOe = encrypt($keyam, $_POST[CERTIFY_INFO]);

				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';
				$xmlg .= '<CERTIFY_INFO>'.$CERTIFY_INFOe.'</CERTIFY_INFO>';
	break;	
	case "SyncMusicDaily":   //곡 동기화 정보
		$path = "/restapi/telecom/";
	
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SYNC_REG_DATE>'.$_POST[SYNC_REG_DATE].'</SYNC_REG_DATE>';

	break;
	case "CheckMusic":   //음원 유효성 체크  
		$path = "/restapi/telecom/";
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<CMID>'.$_POST[CMID].'</CMID>';
				$xmlg .= '<SECTION>'.$_POST[SECTION].'</SECTION>';

	break;	
	case "InquirySetInfo":   //통화연결음 설정정보 조회 
		$path = "/restapi/telecom/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
		
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';

	break;
	case "InquiryMember":   //가입자조회 
		$path = "/restapi/telecom/";
		$CTNe = encrypt($keyam, $_POST[CTN]);
		
				$xmlg .= '<API_ID>'.$API_ID.'</API_ID>';
				$xmlg .= '<TELECOM_CODE>'.$tel_code.'</TELECOM_CODE>';
				$xmlg .= '<SERVICE_CODE>'.$ser_code.'</SERVICE_CODE>';
				$xmlg .= '<CTN>'.$CTNe.'</CTN>';
	break;	
	}

			$xmlg .= '</restFeelring>';
	
			$xmlg = trim($xmlg);

			
			//echo $hostG.$path;
			
			//$st0 = mktime(); //***************
			$fp = fsockopen($hostG,80,$errno,$errstr,20);
			if(!$fp){
				echo "error".$errstr($errno);
			}else{
				// ***********************************************
				// POST 방식
				// ***********************************************
				$xmlg = iconv("UTF-8", "EUC-KR", $xmlg);
				$contentlength = strlen($xmlg);
				
				
				$outt = "POST ".$path." HTTP/1.1\r\n";
				$outt .= "Host: ".$hostG."\r\n";
				$outt .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']." \r\n";
				//$outt .= "Connection: Keep-Alive\r\n";
				$outt .= "Content-Type: application/xml\r\n";
				$outt .= "Content-Length: ".$contentlength."\r\n\r\n";
				$outt .= $xmlg."\r\n";
				//$outt .= "Connection: Close\r\n\r\n";
				fputs($fp, $outt);
				//$st = mktime();  //***************


						$contents = ''; 
						$header = '';
						
						while(trim($buf = fgets($fp, 1024)) != "") { //응답 헤드를 읽어 옵니다.
							$header .= $buf; 
						}
					 

						//$ed = mktime();  //*******************
					 	$su = 0;
						//$contents = fpassthru($fp);
						///*
						//echo $fp;
						echo "start=".date("H:i:s",mktime())."<br/>";  //******************
						while($su == 0){ //!feof($fp)) { //내용을 읽어 옵니다. 
							$tt = fread($fp, 8*1024); //fgets($fp, 5120); 
							$contents .=  $tt;
							echo "<br/>".$su.") ".date("H:i:s",mktime())." | ".$tt."<br/>";  //******************
							$su++;
						} 
						echo "end=".date("H:i:s",mktime())." su=".$su."<br/>";  //******************
						//*/

		
						/*
						$xmlp = xml_parser_create() or die("XML error");
						$contents = xml_parse($xmlp, $contents);
						//echo $contents;
						if(!$contents){
							die("XML error");
						}
						//echo "cont=".$contents;
						//$qbarray = explode("|",$contents);
						//if($qbarray[0] == 0 or $qbarray[0] == 00 or $qbarray[0] == 10){  //성공한 경우*****************
						
						//}else{   //실패한 경우*********************************************
							
						//}   //***************************************************
						*/
	

	
		}
	
	
	//$rtCnt = iconv("UTF-8", "EUC-KR", $contents);
	$rtCnt = iconv("EUC-KR", "UTF-8", $contents);
	
	//$ed2 = mktime(); //*******************


	fclose($fp);

	
	
	//$rtCnt = "Ok"; //$contents;
	echo($rtCnt); //."st0='".date("Y-m-d H:i:s",$st0)."'/st='".date("Y-m-d H:i:s",$st)."'/ed='".date("Y-m-d H:i:s",$ed)."'/ed2='".date("Y-m-d H:i:s",$ed2)."'/aa0='".date("Y-m-d H:i:s",$aa[0])."'/aa1='".date("Y-m-d H:i:s",$aa[1])."'/aa2='".date("Y-m-d H:i:s",$aa[$su-1])."'/su=".$su);

?>