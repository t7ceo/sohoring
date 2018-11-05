<?



//gcm 관려 메세지 전송
function sendMessageGCM($mess1, $mess2, $fromm, $rgid, $rs, $projec, $golink, $img='0'){
	global $host, $dbid, $dbpass, $dbname;
	

	
	//====================================================
	$rs = mysql_connect($host, $dbid, $dbpass);
	mysql_select_db($dbname, $rs);
	//====================================================
	if($img == "0"){
		$vimg = "an.jpeg";
	}else{
		$vimg = $img;
	}


	$conam = $mess1;
	$mess = $mess2;

	$auth = "AIzaSyBymoUUR3X6FQzfm2WA965idIbPm1APENg";	  //1098970225035


	$headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $auth);
	
	//새롭게 수정된 부분으로 공지사항의 고유아이디를 전달 한다.

		$aa = explode("/", $fromm);
		if($aa[0] == "Master") $mm = $conam;
		else $mm = $conam." ";
		$srnum = $aa[1];

		
		$ad_date = date("Y-m-d H:i:s");

		if($aa[0] != "Image"){
			//공지사항을 저장한다.
			$gg = "insert into soho_AAmyGongji (companyid, project, title, title2, url, gongji, fromid, gjtel, vinf, indate, webrec)values('".$projec."', '".$projec."', '".$mess1."', '".$mess2."', '".$golink."', 'text', 'Master', '1644-2366', 1, '".$ad_date."', ".$srnum.")";
			$ggq = mysql_query($gg, $rs);
	
				//echo $srnum;
	
			//마지막으로 삽입된 글의 번호를 반환 한다.
			$rrlst=mysql_query("select last_insert_id() as num",$rs); 
			if(!$rrlst) die("soho_AAmyGongji last id err".mysql_error());
			$rowlast = mysql_fetch_array($rrlst);

			$srnum = $rowlast[num];

		}else{
			$srnum = (double)$aa[1];
		}

			



	if($rgid == "All"){    //보낼 사람이 1000명 이상 이면 1000명 단위로 짤라서 보낸다.
		//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
		$allm = "select count(memid) as su  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and (udid != '' and udid != 'udid None') ";
		//echo $allm;
		$kk = mysql_query($allm, $rs);
		$c = 0;
		$allmesssu = 0;
		$row = mysql_fetch_array($kk);
		if($row[su] < 100){
			
			$arr   = array();
			$arr['data'] = array();
			$arr['data']['message'] = $mess; 
			$arr['data']['title'] = $mm;
			$arr['data']['msgcnt'] = 1;
			$arr['data']['notId'] = $srnum;
			$arr['data']['img'] = $vimg;
			$arr['data']['defaults'] = 2;   //기본 진동 모드 
			//$arr['data']['recnum'] = $srnum;
			$arr['data']['plink'] = $golink;
			$arr['registration_ids'] = array();

			$kkk = "order by udid ";

			
			$allm2 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and (udid != '' and udid != 'udid None') ".$kkk;
			$kk2 = mysql_query($allm2, $rs);
			
			$c = 0;
			//백명 이내인 경우
			while($row1 = mysql_fetch_array($kk2)){
					$arr['registration_ids'][$c++] = $row1[gcmid];
					$allmesssu++;
			}
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,  'https://fcm.googleapis.com/fcm/send'); //  'https://android.googleapis.com/gcm/send');
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
			//echo '{"rs":"ok", "su":'.$allmesssu.'}';
			
		}else{

			//백명 이상에게 보내야 한는 경우
			$endgab = 100;
			$repage = ceil($row[su] / $endgab);
			$startgab = 0;

			for($a = 0; $a < $repage; $a++){

				$arr   = array();
				$arr['data'] = array();
				$arr['data']['message'] = $mess; 
				$arr['data']['title'] = $mm;
				$arr['data']['msgcnt'] = 1;
				$arr['data']['notId'] = $srnum;
				$arr['data']['img'] = $vimg;
				$arr['data']['plink'] = $golink;
				$arr['data']['defaults'] = 2;   //기본 진동모드 
				//$arr['data']['recnum'] = $srnum;
				$arr['registration_ids'] = array();
				
			$kkk = "order by udid ";			
				
				
					$rowgo = "";
					//전체 회원에게 메시지를 보내기 위해 전체 회원의 DB를 가져 온다.
					$allm1 = "select *  from soho_Anyting_gcmid where project = '".$projec."' and  (gcmid != '' and gcmid != '0')  and (udid != '' and udid != 'udid None') ".$kkk."   limit ".$startgab.", ".$endgab."  ";
					$kk1 = mysql_query($allm1, $rs);
					
					$j = 0;
					while($rowgo = mysql_fetch_array($kk1)){
							$arr['registration_ids'][$j++] = $rowgo[gcmid];
							$allmesssu++;
					}

					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send'); //   'https://android.googleapis.com/gcm/send');
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
					

				$startgab += $endgab;
			}

		}



		//echo '{"rs":"ok", "su2":'.$startgab.'}';			
	}else{   //단독 실행

		//선택한 회원에게 메시지 발송
		$allm1 = "select gcmid  from soho_Anyting_gcmid where phonum = '".$rgid."' and project = '".$projec."' and  (gcmid != '' and gcmid != '0')  order by endtime desc limit 1 ";
		$kk4 = mysql_query($allm1, $rs);
		$kkrow = mysql_fetch_array($kk4);	


		$arr   = array();
		$arr['data'] = array();
		$arr['data']['message'] = $mess; 
		$arr['data']['title'] = $mm;
		$arr['data']['msgcnt'] = 1;
		$arr['data']['notId'] = $srnum;
		$arr['data']['img'] = $vimg;
		$arr['data']['defaults'] = 2;   //기본 진동모드 
		//$arr['data']['recnum'] = $srnum;
		$arr['data']['plink'] = $golink;
		$arr['registration_ids'] = array();

		$arr['registration_ids'][0] = $kkrow[gcmid];	
		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,  'https://fcm.googleapis.com/fcm/send'); //  'https://android.googleapis.com/gcm/send');
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
		
		$allmesssu = 1;
		
		//echo $response;
		//echo '{"rs":"ok", "su":1}';	

	}
	
	
	//메시지 발송 숫자를 저장한다.
	$nn = "update soho_AAmyGongji set allinf = ".$allmesssu." where id = ".$srnum." limit 1";
	$kk4 = mysql_query($nn, $rs);
	

}



?>
