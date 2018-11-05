<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//"tbnum="+tbn+"&pass="+gab+"&comId="+comIdgab

	$jsongab = '{"com":"err"}';
	//전달받은 아이디로 매니저 여부를 파악한다.
	$rr0 = mysql_query("select count(memid) as msu from Anyting_manager where memid = '".$memid."' and meminf = 1 and companyid = '".$comid."' limit 1",$rs);
	if(!$rr0){
		die("Anyting_master err".mysql_error());
		$jsongab = '{"com":"err"}';
	}else{
		$row = mysql_fetch_array($rr0);
		
		if($row[msu] > 0) $jsongab = '{"companyid":"ok"}';
		else $jsongab = '{"com":"err"}';
	}


	mysql_close($rs);

	echo($jsongab);
?>