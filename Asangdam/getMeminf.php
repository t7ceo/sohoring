<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//"tbnum="+tbn+"&pass="+gab+"&comId="+comIdgab

	$jsongab = '{"companyid":0}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select meminf from soho_Anyting_member where memid = '".$memid."' limit 1",$rs);
	if(!$rr0){
		die("Anyting_master err".mysql_error());
		$jsongab = '{"companyid":0}';
	}else{
		$row = mysql_fetch_array($rr0);
		$jsongab = '{"companyid":'.$row[meminf].'}';
	}


	mysql_close($rs);

	echo($jsongab);
?>