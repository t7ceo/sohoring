<?
include 'config.php';
include 'util.php';

	$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

		//비어 있는 업체의 테이블을 찾는다.
		$aa = mysql_query("select tbnum, id from Anyting_master where companyid = '".$comid."' and roomInf = 0 order by id limit 1",$rs); 
		if(!$aa) die("Anyting_getAutoNumber.php err".mysql_error());
		$row = mysql_fetch_array($aa);
		
		//선택한 테이블을 사용상태로 설정
		$bb = mysql_query("update Anyting_master set roomInf = 1 where id = ".$row[id]." limit 1",$rs); 
		if(!$bb) die("Anyting_master_update.php err".mysql_error());


		$jsongab = '{"companyid":'.$row[tbnum].'}';

	mysql_close($rs);

	echo($jsongab);
?>