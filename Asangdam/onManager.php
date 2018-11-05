<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = "err";
	//메니저 신청자의 중복여부 검사
	$aa = mysql_query("select count(memid) as memsu from Anyting_manager where companyid = '$comid' and uiu = '$uiu' and (memid = '$memid' or name = '$name')",$rs);
	if(!$aa) die("onManager select err".mysql_error());
	
	$row = mysql_fetch_array($aa);
	if($row[memsu] > 0){
		$ss = "jb";	
	}else{
		//영업자 등록
		$rr = mysql_query("insert into Anyting_manager (memid, name, companyid, meminf, uiu, indate) values('$memid', '$name', '$comid', 11, '$uiu', '$ad_date')",$rs);
		if(!$rr){
			die("onManager err".mysql_error());
			$ss = "err";
		}else{
			$ss = "ok";
		}
	}

	mysql_close($rs);

echo('{"result":"'.$ss.'"}');

?>