<?
include 'config.php';
include 'util.php';

	$jsongab = '{"rs":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$mess = change_str($mess);	
	
	$jsongab = '{"rs":"err"}';
	
	//새로운 메시지를 등록한다.
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);
	
	if($comid != "" && $mess != "" && $from != "" && $toman != ""){
	
		//메세지를 등록합니다.
		$aa = mysql_query("insert into AAmyMess (companyid, message, fromid, tomanid, indate)values
					   ('".$comid."', '".$mess."', '".$from."', '".$toman."', '".$ad_date."')",$rs); 
		if($aa){
		
				//마지막으로 삽입된 글의 id를 반환 한다.
				$rr=mysql_query("select last_insert_id() as num",$rs); 
				if(!$rr) die("class Anyting_last id err".mysql_error());
				$row = mysql_fetch_array($rr);
				$num = $row[num];
		
				//나의 파트너가 대화방에 있는 여부를 확인하고 대화방에 있다면 AAmyPo 에 없다면 AAmyGcm 에 새메시지 여부를 기록한다.
				$ss = "select count(memid) as su, pauseinf from AAonSangdamTb where memid = '".$toman."' and companyid = '".$comid."' limit 1";
				$rr1 = mysql_query($ss, $rs);
				if($rr1){    //
						$row2 = mysql_fetch_array($rr1);
						if($row2[su] > 0){   //파트너가 대화방에 있다.
							$aa1 = mysql_query("insert into AAmyPo (companyid, messid, newinf, fromid, tomemid, wrinf)values('".$comid."', ".$num.", 1, '".$from."', '".$toman."', ".$wrinf.")", $rs);
							
							$gcm = "no";
							//폰화면이 꺼져 있는 경우
							if($row2[pauseinf] == 1) $gcm = "ok";
					
						}else{              //파트너가 대화방에 없다. GCM 발송
							$aa1 = mysql_query("insert into AAmyGcm (recnum, newinf, tomemid, wrinf)values(".$num.", 1, '".$toman."', ".$wrinf.")", $rs); 
					
							$gcm = "ok";
						}
			
						$jsongab = '{"rs":"ok", "day":"'.$ad_date.'", "lr":'.$num.', "gcm":"'.$gcm.'"}';					
				}
		
		}
	
	}
	
	
	echo($jsongab);		


	mysql_close($rs);

	
?>