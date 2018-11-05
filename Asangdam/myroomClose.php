<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"close":"err"}';
	//상담 업체이면 메시지를 남기고 상담업체가 아니면 모두 삭제 한다.
	//상담 업체여부를 파악한다.
	$ss = mysql_query("select gubun from Anyting_company where companyid = '".$comid."' limit 1 ",$rs);
	$row = mysql_fetch_array($ss);
	
	if($row[gubun] == 5){    //상담센터
		//모든 대화 내용을 저장하기 위해 fromnum 과 tonum 에 +5000을 한다.
		$aa = mysql_query("select * from Anyting_message where companyid = '".$comid."' and (fromnum = ".$tbnum." or tonum = ".$tbnum.") ",$rs);
		while($arow = mysql_fetch_array($aa)){
			$fnum = $arow[fromnum] + 5000;
			$tnum = $arow[tonum] + 5000;
			
			$bb = mysql_query("update Anyting_message set fromnum = ".$fnum.", tonum = ".$tnum." where id = ".$arow[id]." limit 1",$rs);
		}
	
		//대화방 초기화
		$aa1 = mysql_query("update Anyting_master set roomInf = 0, sex = 'm', uiu = '0', nickname = '0' where companyid = '".$comid."' and tbnum = ".$tbnum."  limit 1  ",$rs); 
		if(!$aa1) die("myroomClose1 ".mysql_error());	

	
	}else{                   //상담센터 아님
		//받은 메세지 모두 삭제
		$radd = mysql_query("delete from Anyting_message where  companyid = '".$comid."' and (fromnum = ".$tbnum." or tonum = ".$tbnum.") ",$rs);
	
		//신규메시지 알림 삭제
		$radd = mysql_query("delete from Anyting_mypo where  companyid = '".$comid."' and (fromnum = ".$tbnum." or tbnum = ".$tbnum.") ",$rs);
		
	
		//대화방 초기화
		$aa1 = mysql_query("update Anyting_master set roomInf = 0, sex = 'm', uiu = '0', nickname = '0' where companyid = '".$comid."' and tbnum = $tbnum  limit 1  ",$rs); 
		if(!$aa1) die("myroomClose1 ".mysql_error());	
	
	
	}

	$jsongab = '{"close":"ok"}';
	

	mysql_close($rs);

	echo($jsongab);
?>