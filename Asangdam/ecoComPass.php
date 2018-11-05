<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"companyid":"err"}';
	//모든 테이블의 비번 초기화
	if($gubun == "pass"){
		$aa1 = mysql_query("update Anyting_master set pass = '$pass' where companyid = '".$comid."'  ",$rs); 
		if(!$aa1) die("ecoCompass ok ".mysql_error());	

	}else if($gubun == "all"){
		$aa1 = mysql_query("update Anyting_master set pass = '$pass', roomInf = 0, sex = 'm', uiu = '0', nickname = '0' where companyid = '".$comid."'  ",$rs); 
		if(!$aa1) die("ecoComAll ok ".mysql_error());	
	}
	
	$jsongab = '{"companyid":"ok"}';
	

	mysql_close($rs);

	echo($jsongab);
?>