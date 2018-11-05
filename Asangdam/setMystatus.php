<?
include 'config.php';
include 'util.php';

//마스터가 초기화 설정을 한다.

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"genRtn":"err"}';
	//나의 테이블의 상태값을 설정한다.
	$rr0 = mysql_query("update Anyting_master set roomInf=".$myinf." where companyid = '".$comid."' and tbnum = ".$tbnum." limit 1",$rs);
	if(!$rr0){
		die("Anyting_master set mystatus err".mysql_error());
		$jsongab = '{"genRtn":"err"}';
	}else{
		//변화의 내용을 저장
		$rr1 = mysql_query("insert into Anyting_newSt (companyid, tbnum, roomInf)values('".$comid."', ".$tbnum.", ".$myinf." ) ",$rs);
		if(!$rr1) die("Anyting_newSt insert err".mysql_error());
		
		$jsongab = '{"genRtn":"ok'.$myinf.'  '.$comId.'  '.$tbnum.'"}';
	}

	mysql_close($rs);

	echo($jsongab);
?>