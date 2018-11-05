<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();

	$jsongab = '{"memsu":"err"}';
	
	//아이디 체크
	$rr = mysql_query("select count(memid) as su, memid, adpass from soho_Anyting_memberAdd where udid = '".$_GET[uiug]."' and project = '".$project."' limit 1 ",$rs);
	if(!$rr) die("loginCheckUuid check err".mysql_error());
	$row=mysql_fetch_array($rr);
	if($row[su] > 0){  //아이디가 존재 하는 경우 정상 로그인

		if(!$project) $project = "0";

		//gcm에 아이디 저장
		$rr = mysql_query("update soho_Anyting_gcmid set memid='".$row[memid]."' where udid = '".$_GET[uiug]."' and project= '".$project."' limit 1",$rs);
		if(!$rr) die("gcm memid up date err".mysql_error());
		

		//잘못된 레코드 모두 삭제 하기 위해 잘된 것에서 gcmid 를 가져 온다.
		$ss = "select gcmid, count(memid) as su from soho_Anyting_gcmid where memid = '".$row[memid]."' and udid = '".$_GET[uiug]."' and project= '".$project."' limit 1";
		$kk = mysql_query($ss, $rs);
		$row1 = mysql_fetch_array($kk);
	
		if($row1[su] > 0) mysql_query("delete from soho_Anyting_gcmid where gcmid = '".$row1[gcmid]."' and (memid = '0' or udid = '') and project= '".$project."' ",$rs);


		$rr3 = mysql_query("select email, tel from soho_Anyting_member where memid = '".$row[memid]."' and project = '".$project."'  limit 1 ",$rs);
		$row3 = mysql_fetch_array($rr3);
		
		
		$jsongab = '{"memsu":"ok", "memid":"'.$row[memid].'", "email":"'.$row3[email].'", "pass":"'.$row[pass].'", "tel":"'.$row3[tel].'"}';	
		
	}else{
		 $jsongab = '{"memsu":"err"}';   //회원이 없다.   	
	}

	$mycon->sql_close();

	echo($jsongab);
?>