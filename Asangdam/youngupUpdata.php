<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = y_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");


	//영업자 등록
	$rr = mysql_query("insert into Anyting_youngup (memid, name, tel, addr, yupcoid, bank, bname, bnumber, indate) values('$memid', '$yname', '$tel', '$addr', '$coid', '$ybank', '$ybname', '$bnum', '$ad_date')",$rs);
	if(!$rr){
		die("newsMemo Update err".mysql_error());
		$ss = "err";
	}else{
		$ss = "ok";
	}

	mysql_close($rs);



echo('{"result":"'.$ss.'"}');




?>