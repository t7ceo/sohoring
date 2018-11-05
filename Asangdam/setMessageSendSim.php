<?
include 'config.php';
include 'util.php';

	$jsongab = '{"sim":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$mess = change_str($mess);	
		
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);


	//메시지를 테이블에 기록한다.
	$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
				   ('".$comid."', ".$frmnum.", ".$tonum.", '".$mess."', '".$frmid."', '".$toid."', '".$ad_date."')",$rs); 
	if(!$aa) die("class Anyting_message err".mysql_error());
	

	
		//Anyting_message 에 마지막으로 삽입된 글의 번호를 반환 한다.
		$rr=mysql_query("select last_insert_id() as num",$rs); 
		if(!$rr) die("class Anyting_last id err".mysql_error());
		$row = mysql_fetch_array($rr);



	//Anyting_mypo 에 새로운 메시지의 존재 여부를 기록한다.	
	//사용자가 myroomsendpg.html 에 있는 경우 새로운 메시지 내용이 지워지지 않아서 무한 기록한다.
	if($mstInf == "gn"){  //마스터가 회원에게 보낸다.(한개만 기록한다.)

		//새로운 메세지 있음을 표시
		$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum, fromnum, recnum, newinf, tomemid, wrinf, pauseok)values('".$comid."', ".$tonum.", ".$frmnum.", ".$row[num].", 1, '".$toid."', ".$wrinf.", 9)",$rs); 
		if(!$bb) die("class Anyting_mypo err".mysql_error());

	}else{               //회원이 마스터에게 보낸다.(전체 마스터에게 보낸다.)

		//해당 업체의 전체 메니저를 구한다.-메니저 수만큼 반복하면서 각 메니저의 고유 id 를 지정하여 메세지를 저장
		$rr1=mysql_query("select * from Anyting_manager where companyid = '".$comid."' and meminf = 1 ",$rs); 
		if(!$rr1) die("class Anyting_manager all err".mysql_error());
		$c = 0;
		while($row1 = mysql_fetch_array($rr1)){
			
			//새로운 메세지 있음을 표시			
			$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum,fromnum, recnum, newinf, managid, tomemid, wrinf, pauseok)values
						   ('".$comid."', ".$tonum.", ".$frmnum.", ".$row[num].", 1, ".$row1[id].", '".$toid."', ".$wrinf.", 9)",$rs); 
			if(!$bb) die("class Anyting_mypo err".mysql_error());
			
			$c++;
			
		}

	}


	$jsongab = '{"sim":"ok", "tonum":'.$tonum.', "day":"'.$ad_date.'", "lr":'.$row[num].'}';

	mysql_close($rs);

	echo($jsongab);
?>