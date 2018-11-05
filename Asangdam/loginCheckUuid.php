<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"memsu":"err"}';
	//아이디 체크
	$rr = mysql_query("select count(memid) as su, memid, email, pass, tel from soho_Anyting_member where uiu = '".$uiug."' limit 1 ",$rs);
	if(!$rr) die("loginCheckUuid check err".mysql_error());
	$row=mysql_fetch_array($rr);
	if($row[su] > 0){  //아이디가 존재 하는 경우 정상 로그인

		if(!$project) $project = "0";

		//gcm에 아이디 저장
		$rr = mysql_query("update soho_Anyting_gcmid set memid='".$row[memid]."' where udid = '".$uiug."' and project= '".$project."' limit 1",$rs);
		if(!$rr) die("gcm memid up date err".mysql_error());
		
		//gcm에 중복된 자료는 삭제 한다.
		//$rr = mysql_query("delete from soho_Anyting_gcmid where memid='' and udid = '".$uiug."' ",$rs);
		//if(!$rr) die("gcm memid up date err".mysql_error());


		//잘못된 레코드 모두 삭제 하기 위해 잘된 것에서 gcmid 를 가져 온다.
		$ss = "select gcmid, count(memid) as su from soho_Anyting_gcmid where memid = '".$row[memid]."' and udid = '".$uiug."' and project= '".$project."' limit 1";
		$kk = mysql_query($ss, $rs);
		$row1 = mysql_fetch_array($kk);
	
		if($row1[su] > 0) mysql_query("delete from soho_Anyting_gcmid where gcmid = '".$row1[gcmid]."' and (memid = '0' or udid = '') and project= '".$project."' ",$rs);






		
		
		$jsongab = '{"memsu":"ok", "memid":"'.$row[memid].'", "email":"'.$row[email].'", "pass":"'.$row[pass].'", "tel":"'.$row[tel].'"}';	
		
	}else{
		 $jsongab = '{"memsu":"err"}';   //회원이 없다.   	
	}

	mysql_close($rs);

	echo($jsongab);
?>