<?
include 'config.php';
include 'util.php';
	
	//체크된 모든 테이블에 메시지 전송
	//$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
		
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);
	
	$gab = explode(",",$chkroom);
	$tomanA = explode(",",$toman);
	$mess = change_str($mess);	
	
	
		//상담 업체이면 이전에 남겨진 모든 메시지와 현재의 메시지를 모두 가져온다.
		//상담 업체여부를 파악한다.
		//받는 사람은 업체의 모든 메니저 이다.
		$ss = mysql_query("select gubun, masterid from Anyting_company where companyid = '".$comid."' limit 1 ",$rs);
		$row = mysql_fetch_array($ss);
		
		$sangdam = false;
		if($row[gubun] == 5){    //상담센터
			$sangdam = true;
		}
	

	//체크된 모든 테이블에 메세지 전송
	for($c = 0; $c < count($gab); $c++){
		if($sangdam){      //상담센터 입니다.
			//상담자가 고객에게 메시지를 전송한다. pass 에는 상담자의 아이디 저장
			//메세지를 등록합니다.
			$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
						   ('".$comid."', ".$from.", ".$gab[$c].", '".$mess."', '".$tpass."', '".$tomanA[$c]."', '".$ad_date."')",$rs); 
			if(!$aa) die("class Anyting_message err".mysql_error());
		
		}else{
			//메세지를 등록합니다.
			$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, indate)values
						   ('".$comid."', ".$from.", ".$gab[$c].", '".$mess."', '".$tpass."', '".$ad_date."')",$rs); 
			if(!$aa) die("class Anyting_message err".mysql_error());
		
		}
		
		
		//마지막으로 삽입된 글의 번호를 반환 한다.
		$rr=mysql_query("select last_insert_id() as num",$rs); 
		if(!$rr) die("class Anyting_last id err".mysql_error());
		$row = mysql_fetch_array($rr);


		//새로운 메세지 있음을 표시
		$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum, fromnum, recnum, newinf)values
					   ('".$comid."', ".$gab[$c].", ".$from.", ".$row[num].", 1)",$rs); 
		if(!$bb) die("class Anyting_mypo err".mysql_error());
	}

		$jsongab = '{"companyid":"ok"}';



	mysql_close($rs);

	echo($jsongab);
?>