<?
include 'config.php';
include 'util.php';

	$jsongab = '{"comdisp":[{"message":"err"}]}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

//받는 사람의 테이블 번호가 바뀐 경우 처리 하라.


	//선택한 업체의 내가 있는 테이블에 새로운 메세지를 읽어서 한개씩 표시한다.
	if($managerId > 0){ //메니저 모드의 경우   받는 사람은 0(매니저) 이다. 
		$smff = "select id, recnum, wrinf from Anyting_mypo where companyid = '".$comid."' and ((tbnum = 0 and newinf = 1 and managid = ".$managerId.") or (tomemid = '".$memid."' and newinf = 1)) order by id";
	}else{              //일반 모드의 경우  rdTbnum 받는 사람의 테이블 번호 사용
		$smff = "select id, recnum, wrinf from Anyting_mypo where companyid = '".$comid."' and ((tbnum = ".$rdTbnum." and newinf = 1) or (tomemid = '".$memid."' and newinf = 1))  order by id";
	}


		
	$smfff=mysql_query($smff,$rs);
	if(!$smfff)die("dispMessage err".mysql_error());
	
	$jsongab = '{"comdisp":[';
	$c = 0;
	while($row = mysql_fetch_array($smfff)){
		if($c > 0) $jsongab .= ",";
		
		
		
		
		$recnum = $row[recnum];
		//새로운 메시지 알림은 삭제한다.
		$sm = "delete from Anyting_mypo where id = ".$row[id]." and pauseok <> 9 limit 1";
		$smf=mysql_query($sm,$rs);
		if(!$smf)die("Anyting_mypo 2 err".mysql_error());
	

		
		//새로운 메세지를 읽어서 표시한다.
		$ss = "select * from Anyting_message where id = ".$row[recnum]." limit 1";
		$aa=mysql_query($ss,$rs);
		if(!$aa)die("dispMessage2 err".mysql_error());
		$row1 = mysql_fetch_array($aa);
		
		
		
		//메시지를 보낸 사람의 테이블 번호를 가져온다.
		$ss1 = "select tbnum, count(sex) as su from Anyting_master where companyid = '".$comid."' and nickname = '".$row1[pass]."'  limit 1";
		$aa1 = mysql_query($ss1,$rs);
		if(!$aa1)die("dispMessage3 err".mysql_error());
		$row2 = mysql_fetch_array($aa1);


		//메시지를 보낸 사람의 전화번호를 가져 온다.
		$ss2 = "select tel from soho_Anyting_member where memid = '".$row1[pass]."'  limit 1";
		$aa2 = mysql_query($ss2,$rs);
		if(!$aa2)die("dispMessage4 err".mysql_error());
		$row3 = mysql_fetch_array($aa2);



		
		//메시지를 보낸 사람이 앱에서 나간 경우 오류 발생
		if($row2[su] < 1){
			$frmtnum = 9999;
		}else{
			$frmtnum = $row2[tbnum];
		}
		
		
		
		if($row3[tel] == "" or $row3[tel] == "0"){
			$ftelg = "01000000000";
		}else{
			$ftelg = $row3[tel];
		}

		
		$jsongab .= '{"id":'.$row1[id].',"fromnum":'.$row1[fromnum].', "frmid":"'.$row1[pass].'", "ftel":"'.$ftelg.'", "frmtnum":'.$frmtnum.', "recnum":'.$row[recnum].', "message":"'.$row1[message].'", "day":"'.$row1[indate].'", "wrinf":'.$row[wrinf].'}';


		
		$c++;
	}
	
	$jsongab .= ']}';

	mysql_close($rs);
	

	echo($jsongab);
?>