<?
include 'config.php';
include 'util.php';

	$jsongab = '{"comdisp":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//고객이 매니저의 방에서 매니저에게 매시지를 보낸다.
	//전체 메세지를 읽어서 표시한다.
	if($memid == "No"){   //일반 모드
	
		$smff = "select * from Anyting_message where companyid = '".$comid."' and ((tonum = ".$rdTbnum." and fromnum = 0) or (tonum = 0 and fromnum = ".$rdTbnum."))  order by id";
		$smfff=mysql_query($smff,$rs);
		if(!$smfff)die("dispMessage err".mysql_error());

	
	}else{                //상담센터

		$smff = "select * from Anyting_message where companyid = '".$comid."' and (((pass = '".$memid."' and toman = '".$mstid."') or (pass = '".$mstid."' and toman = '".$memid."')) or ((tonum = ".$rdTbnum." and fromnum = 0) or (tonum = 0 and fromnum = ".$rdTbnum."))) order by id";
		$smfff=mysql_query($smff,$rs);
		if(!$smfff)die("dispMessage err".mysql_error());
	
	}
	
	
	
	$jsongab = '{"comdisp":[';
	$c = 0;
	while($row = mysql_fetch_array($smfff)){
			if($c > 0) $jsongab .= ",";

			
			$jsongab .= '{"id":'.$row[id].',"fromnum":'.$row[fromnum].', "message":"'.$row[message].'", "day":"'.$row[indate].'"}';
			
			
			$c++;	
	}
	
	$jsongab .= ']}';

	if($c > 0){

		//$rdTbnum == 0 이면 메니저가 보는 것이다.
		if($rdTbnum == 0){   //메니저가 자신에게 온 메시지를 보는 경우
			//전체 메세지를 출력하고 전체메니저에게 온새메세지 중에서 자기것을 지운다.
			$sm = "delete from Anyting_mypo where companyid = '".$comid."' and (tbnum = 0 and managid = ".$manageId.")";
			$smf=mysql_query($sm,$rs);
			if(!$smf)die("Anyting_mypo all del err".mysql_error());
		}else{               //고객이 보는 경우
			//고객이 메니저에게서 온것을 보는 경우
			$sm = "delete from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$rdTbnum." and fromnum = 0";
			$smf=mysql_query($sm,$rs);
			if(!$smf)die("Anyting_mypo all del err".mysql_error());
		}
	
	}else{    //자료가 없다.
	
		$jsongab = '{"comdisp":"no"}';
	}
		



	mysql_close($rs);

	echo($jsongab);
?>