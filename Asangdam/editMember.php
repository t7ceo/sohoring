<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = "err";
	
	if($pass == "0"){
		//비밀번호 변경 않함
		$rr = mysql_query("update soho_Anyting_member set email='$email', uiu='$uiug' where memid = '$myid' limit 1",$rs);
		if(!$rr) die("edit Member err".mysql_error());
	}else{
		//비밀번호 변경함
		$rr = mysql_query("update soho_Anyting_member set pass='$pass', email='$email', uiu='$uiug' where memid = '$myid' limit 1",$rs);
		if(!$rr) die("edit Member err".mysql_error());
	}
	
	$ss = "ok";
	
	mysql_close($rs);	
		
	echo ('{"result":"'.$ss.'"}');
?>