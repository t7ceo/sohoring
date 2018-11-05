<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//$phpsessionid = "kkk";
	//$ipgab = gethostbyname("chimappram.com");

	//$bb = sendMessageGCM($auth, $registration_idPhone);


	//마지막 가맹점 번호 가져온다.
	$rr = mysql_query("select id from Anyting_company order by id desc limit 1 ",$rs);
	if(!$rr){
		die("Anyting_company laste id err".mysql_error());
		$jsongab = '{"cid":"err"}';
	}else{
       	$row=mysql_fetch_array($rr);
		$jsongab = '{"cid":'.$row[id].'}';
	}
	

	mysql_close($rs);

	echo($jsongab);
?>