<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스


	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	switch($_GET[mode]){
	case "upjDon":
	
		$uu = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[mtel]."' and gubun = 3 and sub = ".$_GET[sub]." and sub2 = 1 and bgid = ".$_GET[bgid]." ");
		$gb1 = mysql_num_rows($uu);
	
		$uu2 = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[mtel]."' and gubun = 3 and sub = ".$_GET[sub]." and sub2 = 2 and bgid = ".$_GET[bgid]." ");
		$gb2 = mysql_num_rows($uu2);
	
		$uu3 = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[mtel]."' and gubun = 3 and sub = ".$_GET[sub]." and sub2 = 3 and bgid = ".$_GET[bgid]." ");
		$gb3 = mysql_num_rows($uu3);
	
		$uu4 = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[mtel]."' and gubun = 3 and sub = ".$_GET[sub]." and sub2 = 4 and bgid = ".$_GET[bgid]." ");
		$gb4 = mysql_num_rows($uu4);
	
		$jsongab = '{"rs":"ok", "s1":'.$gb1.', "s2":'.$gb2.', "s3":'.$gb3.', "s4":'.$gb4.'}';
	
	break;
	case "fileDown":
	
		$recfileDir = "../Asangdam/onecut/";
		$filnam = str_replace("/", "", $_GET[fnam]);
		
		//echo "kkkkk";
		
		//파일의 존재 여부 확인
		if(file_exists($recfileDir.$filnam)){
		
		//echo $recfileDir.$filnam;
		
			header("Content-Type:application/octet-stream");
			header("Content-Disposition:attachment;;filename=".$filnam);
			header("Content-Transfer-Encoding:binary");
			header("Content-Length:".(string)(filesize($recfileDir.$filnam)));
			header("Cache-Control:cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires:0");
			$fp = fopen($recfileDir.$filnam, "rb"); //읽기 전용으로 연다.
			
			while(!feof($fp)){
				echo fread($fp, 100*1024);
			}
		
			fclose($fp);
			flush();

			
		
			$jsongab = '{"rs":"ok"}';
		}else{
			//해당 파일이 없다.
			$jsongab = '{"rs":"no'.$recfileDir.$filnam.'"}';
		}
	
	break;	
	case "setLog":   //로그 설정
	
		$ip = $_SERVER['REMOTE_ADDR'];
		$day = date("Y-m-d H:i:s");
		$uu = $mycon->query("insert into soho_app_log (tel, ip, uid, menu, day, bigo)values('".$_GET['mtel']."', '".$ip."', '".$_GET['uid']."', '".rawurldecode($_GET['menu'])."', '".$day."', '".rawurldecode($_GET['bigo'])."')");
		
		$jsongab = '{"rs":"ok"}';		
	
	break;
	case "getFirst":   //첫번째 여부 확인
	
		$uu = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[mtel]."' ");
		$su = mysql_num_rows($uu);
		
		$uu2 = $mycon->query("select * from soho_oldmem where tel = '".$_GET[mtel]."' ");
		$su2 = mysql_num_rows($uu2);
		
		$adsu = $su + $su2;
		
		if($adsu > 0){
			
			$jsongab = '{"rs":"no", "su":'.$adsu.'}';
		}else{
			
			$jsongab = '{"rs":"ok", "su":'.$adsu.'}';
		}
	
	break;
	case "appbas":  //앱의 기본 정보와 상태를 가져 온다.
		$uu = $mycon->query("select * from soho_AAmyAppinf limit 1 ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			
			$jsongab = '{"rs":"ok", "mess":"'.$row[endmess].'", "inf":'.$row[endinf].'}';
		}else{
			
			$jsongab = '{"rs":"err"}';
		}
		
	break;
	case "getMusicUrl":  //멘트링크 가져오기
	
		$uu = $mycon->query("select url from soho_AllMusic where pid = '".$_GET[pid]."' limit 1 ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			
			$jsongab = '{"rs":"ok", "url":"'.$row[url].'"}';
		}else{
			
			$jsongab = '{"rs":"not"}';
		}
	
	break;		
	case "getMainBn":   //메인 베너를 가져온다.
	
			$kk = mysql_query("select * from soho_Anyting_banner  where oninf = 1 order by indx  ", $rs);
			$su = mysql_num_rows($kk);
			if($su > 0){
				
				$jsongab = '{"rs":[';
				$i = 0;
				while($row = mysql_fetch_array($kk)){
					if($i > 0) $jsongab .= ",";
				
					$jsongab .= '{"id":'.$row[id].', "img":"'.$row[companyid].'", "music":"'.$row[music].'"}';
						
					$i++;
			
				}
				$jsongab .= ']}';
			}
		
	break;	
	case "boxCheck":    //재설정함에서 정보를 호출 한다.
	
				$uu = $mycon->query("select mname, url, tit, id from soho_AllMusic where pid = '".$_GET[pid]."' limit 1 ");
				if(mysql_num_rows($uu) > 0){
					$row2 = mysql_fetch_array($uu);
					if($row2[mname] and $row2[mname] != "mmm"){
						$rid = $row2[id];
						$purl = "https://sohoring.com:41020/sohoring/Asangdam/onecut/".$row2[mname];
						$ptit = $row2[tit];
						
					}else{
						$rid = 0;
						$ptit = "No Title";
						$purl = "no";
					}
				}else{
					$rid = 0;
					$purl = "no";
					$ptit = "No Title";
				}	
	
	
	
		if(!$_GET[inx]) $_GET[inx] = 0;
	
			//주문기록이 있는 경우 주문정보도 같이 가져온다.
			$kk = mysql_query("select * from soho_AllJumun where pid = '".$_GET[pid]."'  limit 1  ", $rs);
			$su = mysql_num_rows($kk);
			if($su > 0){
				$row = mysql_fetch_array($kk);
	
				$jsongab = '{"id":'.$row[id].', "rid":'.$rid.', "purl":"'.$purl.'", "mess":"'.$row[mess].'", "tit":"'.$ptit.'", "gb":'.$row[gubun].', "sub":'.$row[sub].', "sub2":'.$row[sub2].', "ton":'.$row[tone].', "st":"'.$row[stGab].'", "ed":"'.$row[edGab].'", "sp":"'.$row[spGab].'", "pid":"'.$row[pid].'", "indx":'.$_GET[inx].'}';			
				
			}else{
				$jsongab = '{"id":0, "rid":'.$rid.', "purl":"'.$purl.'", "mess":"0", "tit":"'.$ptit.'", "gb":0, "sub":0, "sub2":0, "ton":0, "st":"0", "ed":"0", "sp":"0", "pid":"'.$_GET[pid].'", "indx":'.$_GET[inx].'}';		
			}

		
	break;	
	case "bestMs":   // 베스트 음악을 가져온다.
	
			$kk = mysql_query("select * from soho_AVBest_Music where gubun  = ".$_GET[md]." limit 1  ", $rs);
			$row = mysql_fetch_array($kk);
			
			$jsongab = '{"id":'.$row[id].', "ment":"'.$row[ment].'", "msic":"'.$row[music].'"}';
						

	
	break;
	case "delVoiceRecMu":
	
		$ss = "delete from soho_AllMusic where id = ".$_GET[did]." limit 1"; 
		//echo $ss;
		$dd = mysql_query($ss, $rs);
		
		//$dd = $mycon->bas_delete("soho_AllMusic", " id = ".$did." limit 1");
		
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "dispVoice":
	
			$kk = mysql_query("select * from soho_AllMusic where memid  = '".$_GET[memid]."' and gubun = 13 order by id desc  ", $rs);
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($kk)){
				if($i > 0) $jsongab .= ",";
				
				//녹음 파일의 등록 여부를 확인 한다.
				if(file_exists("../Asangdam/onecut/".$row[tit])){
					$dirg = "y";
					
					if($row[fileInf] == 0){
						$row[fileInf] = 1;
						//파일이 실제로 등록된 것을 설정 한다.
						$kk = mysql_query("update soho_AllMusic set fileInf = 1 where id = ".$row[id]." limit 1",$rs); 
					}
					  
				}else{
					$dirg = "n";
				 	
					if($row[fileInf] == 1){
						$row[fileInf] = 0;
						//파일이 실제로 존재 하지 않는 것으로 설정한다.
						$kk = mysql_query("update soho_AllMusic set fileInf = 0 where id = ".$row[id]." limit 1",$rs); 
					}
				 
				}
				
				$mday = date("Y-m-d H:i:s", $row[onday]);
				
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[tit].'", "msic":"'.$row[mname].'", "day":"'.$mday.'", "finf":'.$row[fileInf].', "dirg":"'.$dirg.'"}';
					
				$i++;
			
			}
			$jsongab .= ']}';
	
	
	break;	
	case "myMusicBack":    //업종베스트 예제 멘트들을 가져온다.
	
			$gb = $_GET[gb];
			$sub = $_GET[sub];
			if($sub > 0){
				$subt = " and sub = ".$sub." ";
			}else{
				$subt = "";
				if($gb == 4) $subt = " and sex = '".$_GET[sex]."' ";
			}
	
			$kk = mysql_query("select * from soho_AllMusic where gubun = ".$gb." ".$subt." and fileInf = 1 order by indx  ", $rs);
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($kk)){
				if($i > 0) $jsongab .= ",";
				
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[tit].'", "msic":"'.$row[mname].'", "sex":"'.$row[sex].'", "pid":"'.$row[pid].'"}';
				//$jsongab .= '{"id":'.$row[id].', "tit":"hh", "msic":"'.$row[mname].'", "sex":"'.$row[sex].'", "pid":"'.$row[pid].'"}';
						
				$i++;
			
			}
			$jsongab .= ']}';
	
	
	break;
	case "myMusic":    //나의 소호링을 가져온다.
	
			$kk = mysql_query("select * from soho_AllMusic where memid  = '".$_GET[memid]."' order by id desc  ", $rs);
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($kk)){
				if($i > 0) $jsongab .= ",";
				
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[tit].'", "msic":"'.$row[mname].'"}';
						
				$i++;
			
			}
			$jsongab .= ']}';
	
	
	break;
	case "myCall":  //나의 신청 내역
	
			//같은 번호의 주문 내역을 확인 한다.
			$aa = $mycon->query("select * from soho_AllJumun where tel = '".$_GET[memid]."' order by onday desc");
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($aa)){
				if($i > 0) $jsongab .= ",";
				
				$day = date("Y-m-d H:i:s",$row[onday]);
			
				$jsongab .= '{"id":'.$row[id].', "gb":'.$row[gubun].', "ring":'.$row[sub2].', "day":"'.$day.'", "call":"my", "tsu":'.$row[txtsu].'}';
						
				$i++;
			
			}
			$jsongab .= ']}';
	
	break;
	case "myCallSS":  //나의 신청 내역 상세
	
			//같은 번호의 주문 내역을 확인 한다.
			$aa = $mycon->query("select * from soho_AllJumun where id = ".$_GET[cid]." ");
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($aa)){
				if($i > 0) $jsongab .= ",";
				
				$day = date("Y-m-d H:i:s",$row[onday]);
				
				//톤에 대한 정보를 가져온다.
				$tone = "N";
				$toneF = "N";
				if($row[tone] > 0){
					$kk = $mycon->query("select * from soho_AllMusic where id = ".$row[tone]." limit 1");
					$kkrow = mysql_fetch_array($kk);
					$tone = $kkrow[tit];
					$toneF = $kkrow[mname];
				}
				//배경음악에 대한 정보를 가져온다.
				$bg = "배경음악 없음";
				$bgF = "N";
				if($row[bgid] > 0){
					$kk2 = $mycon->query("select * from soho_AllMusic where id = ".$row[bgid]." limit 1");
					$kkrow2 = mysql_fetch_array($kk2);
					$bg = $kkrow2[tit];
					$bgF = $kkrow2[mname];
				}
				//녹음파일에 대한 정보를 가져온다.
				$vrec = "N";
				$vrecF = "N";
				if($row[voiceid] > 0){
					$kk3 = $mycon->query("select * from soho_AllMusic where id = ".$row[voiceid]." limit 1");
					$kkrow3 = mysql_fetch_array($kk3);
					$vrec = $kkrow3[tit];
					$vrecF = $kkrow3[mname];
				}
				
				if(!$row[stGab]){
					$stG = "0";
					$edG = "0";				
				}else{
					$stG = $row[stGab];
					$edG = $row[edGab];							
				}
				
				
				
					
				if(!$row[spGab]){
					$spG = ".";
				}else{
					$spG = rawurldecode($row[spGab]);
				}
				
				
				$mess = rawurldecode($row[mess]);
				$messsu = strlen($mess); 
				
				
			
				$jsongab .= '{"id":'.$row[id].', "gb":'.$row[gubun].', "day":"'.$day.'", "sub":'.$row[sub].', "ring":'.$row[sub2].', "toneid":'.$row[tone].', "tone":"'.rawurldecode($tone).'", "toneF":"'.$toneF.'", "bgid":'.$row[bgid].', "bg":"'.$bg.'", "bgF":"'.$bgF.'", "vrecid":'.$row[voiceid].', "vrec":"'.$vrec.'", "vrecF":"'.$vrecF.'", "sex":"'.$row[sex].'", "tsu":'.$messsu.', "spG":"'.$spG.'", "mess":"'.$mess.'", "stG":"'.$stG.'", "edG":"'.$edG.'"}';
						
				$i++;
			
			}
			$jsongab .= ']}';
	
	break;	
	}

	echo($jsongab);

	$mycon->sql_close();


?>