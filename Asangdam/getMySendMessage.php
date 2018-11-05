<?
include 'config.php';
include 'util.php';
	//myroomsendpg 에서 호출 합니다.-대화방

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//대화방에서 상담 업체이면 이전에 남겨진 모든 메시지와 현재의 메시지를 모두 가져온다.
	//상담 업체여부를 파악한다.
	//$mgid - 보낸 사람 아이디
	//$nicn - 받는 사람 아이디
	$ss = mysql_query("select gubun from Anyting_company where companyid = '".$comid."' limit 1 ",$rs);
	$row = mysql_fetch_array($ss);
	
	if($row[gubun] == 5){    //상담센터

		//이전에 저장된 모든 메시지도 가져 온다.
		$rr1 = mysql_query("select * from Anyting_message where companyid = '".$comid."' and (((pass = '".$mgid."' and toman = '".$nicn."') or (pass = '".$nicn."' and toman = '".$mgid."')) or ((tonum = ".$tonum." and fromnum = ".$fromnum.") or (tonum = ".$fromnum." and fromnum = ".$tonum."))) order by id ",$rs);
		if(!$rr1){
			$jsongab = '{"smess":"err"}';
			die("Anyting_message getMySendMessage.php err".mysql_error());
		}else{
			$jsongab = '{"smess":[';
			$c = 0;
			while($row1=mysql_fetch_array($rr1)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"fm":'.$row1[fromnum].',"to":'.$row1[tonum].', "me":"'.$row1[message].'", "rd":'.$row1[reading].', "dy":"'.$row1[indate].'"}';
				
				$c++;
			}
			$jsongab .= ']}';
		}

	}else{

		//테이블의 메시지를 모두 가져온다.
		$rr1 = mysql_query("select * from Anyting_message where companyid = '".$comid."' and (tonum = $tonum and fromnum = $fromnum) or (tonum = $fromnum and fromnum = $tonum) order by id ",$rs);
		if(!$rr1){
			$jsongab = '{"smess":"err"}';
			die("Anyting_message getMySendMessage.php err".mysql_error());
		}else{
			$jsongab = '{"smess":[';
			$c = 0;
			while($row1=mysql_fetch_array($rr1)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"fm":'.$row1[fromnum].',"to":'.$row1[tonum].', "me":"'.$row1[message].'", "rd":'.$row1[reading].', "dy":"'.$row1[indate].'"}';
				
				$c++;
			}
			$jsongab .= ']}';
		}

	}


/*
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
*/





	mysql_close($rs);

	echo($jsongab);
?>