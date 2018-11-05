<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = '{"result":"err"}';
	
	$rr1 = mysql_query("select count(memid) as memsu from soho_Anyting_member where memid = '".$memid."' limit 1",$rs);
	if(!$rr1) die("add Member Update select".mysql_error());
	
	$row = mysql_fetch_array($rr1);
	if($row[memsu] < 1){
		//회원가입 처리
		$rr = mysql_query("insert into soho_Anyting_member (memid, pass, email, indate, uiu)values('$memid', '$pass', '$email', '$ad_date', '$uiu')",$rs);
		if(!$rr) die("add Member Update err".mysql_error());
	}


	
	$ss = '{"result":"ok"}';
	
	
	mysql_close($rs);	
	
		
	echo($ss);
?>