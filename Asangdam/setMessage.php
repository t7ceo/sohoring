<?
include 'config.php';
include 'util.php';

	$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
		
		
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);
	
	$mess = change_str($mess);	
	
	/*echo "<script>alert('gcmgo')</script>";*/
	
	
	//고객이 메니저에게 보내는 메세지를 저장하는 경우
	//보내는 사람이 고객이다.
	$jsongab = '{"companyid":"no"}';
	if($from > 0){      //고객이 메니저의 방에서 메시지를 보내서 호출된 경우
		//상담 업체이면 이전에 남겨진 모든 메시지와 현재의 메시지를 모두 가져온다.
		//상담 업체여부를 파악한다.
		//받는 사람은 업체의 모든 메니저 이다.
		$ss = mysql_query("select gubun, masterid from Anyting_company where companyid = '".$comid."' limit 1 ",$rs);
		$row = mysql_fetch_array($ss);
		
		//gcm id 구한다.
		$ss = mysql_query("select gcmid from soho_Anyting_gcmid where memid = '".$row[masterid]."' limit 1 ",$rs);
		$gcmid = mysql_fetch_array($ss);
		//$jsongab = sendMessageGCM($mess, $tpass, $gcmid[gcmid]); 
		
		if($row[gubun] == 5){    
			//상담센터에서 고객이 메니저에게 메시지 전송
			//메니저의 존재 여부에 따라 메시지 전송 방법이 다르다.
			//메니저가 자리를 비웠다. 메니저가 있다.
			$ss0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' and tbnum = 0 limit 1 ",$rs);
			$rominf = mysql_fetch_array($ss0);
	
			if($rominf[roomInf] == 1){  //메니저가 방에 있다
			
				//메세지는 한개만 등록하고 새로운 메시지가 있다는 표시를 관리자 수만큼 한다.
				$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
								   ('".$comid."', ".$from.", ".$tonum.", '".$mess."', '".$tpass."', '".$row[masterid]."', '".$ad_date."')",$rs); 
				if(!$aa) die("class Anyting_message err".mysql_error());
			
			}else{                      //메니저가 없다.
				$gf = $from + 5000;
				$gt = $tonum + 5000;
				//메세지는 한개만 등록하고 새로운 메시지가 있다는 표시를 관리자 수만큼 한다.
				$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
								   ('".$comid."', ".$gf.", ".$gt.", '".$mess."', '".$tpass."', '".$row[masterid]."', '".$ad_date."')",$rs); 
				if(!$aa) die("class Anyting_message err".mysql_error());
			
			}

		}else{        //상담센터가 아닌 곳에서 고객이 메니저에게 메시지 전송

			//메세지는 한개만 등록하고 새로운 메시지가 있다는 표시를 관리자 수만큼 한다.
			$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, indate)values
							   ('".$comid."', ".$from.", ".$tonum.", '".$mess."', '".$tpass."', '".$ad_date."')",$rs); 
			if(!$aa) die("class Anyting_message err".mysql_error());
			
		}
	
		$jsongab = '{"companyid":"ok"}';	
	
		//마지막으로 삽입된 글의 번호를 반환 한다.
		$rr=mysql_query("select last_insert_id() as num",$rs); 
		if(!$rr) die("class Anyting_last id err".mysql_error());
		$row = mysql_fetch_array($rr);

		//해당 업체의 전체 메니저를 구한다.-메지저 수만큼 반복하면서 각 메니저의 고유 id 를 지정하여 메세지를 저장
		$rr1=mysql_query("select * from Anyting_manager where companyid = '$comid' and meminf = 1 ",$rs); 
		if(!$rr1) die("class Anyting_manager all err".mysql_error());
		$c = 0;
		while($row1 = mysql_fetch_array($rr1)){
			
			//새로운 메세지 있음을 표시			
			$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum,fromnum, recnum, newinf, managid)values
						   ('".$comid."', ".$tonum.", ".$from.", ".$row[num].", 1, ".$row1[id].")",$rs); 
			if(!$bb) die("class Anyting_mypo err".mysql_error());
			
			$jsongab = '{"companyid":"ok"}';
			$c++;
			
		}
		
		//업체에 등록된 메니저가 없는 경우 먼저 저장된 메시지를 삭제 한다.
		if($c < 1){
			$sm = "delete from Anyting_message where id = $row[num] limit 1";
			$smf=mysql_query($sm,$rs);
			if(!$smf)die("Anyting_message add del err".mysql_error());
		}
		
		
	}else{     //보내는 사람이 매니저 이다.  //////////고객끼리 보내는 메세지-새로운 메세지가 있음을 표시 한다.
		
		
		
		
		
		//메니저가 보낸 메시지를 등록한다.
		$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, indate)values
					   ('".$comid."', ".$from.", ".$tonum.", '".$mess."', '".$tpass."', '".$ad_date."')",$rs); 
		if(!$aa) die("class Anyting_message err".mysql_error());
		
		//마지막으로 삽입된 글의 번호를 반환 한다.
		$rr=mysql_query("select last_insert_id() as num",$rs); 
		if(!$rr) die("class Anyting_last id err".mysql_error());
		$row = mysql_fetch_array($rr);



		//새로운 메세지 있음을 표시
		$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum, fromnum, recnum, newinf)values
					   ('".$comid."', ".$tonum.", ".$from.", ".$row[num].", 1)",$rs); 
		if(!$bb) die("class Anyting_mypo err".mysql_error());
		
		$jsongab = '{"companyid":"ok"}';

	}
	

	mysql_close($rs);

	echo($jsongab);
?>