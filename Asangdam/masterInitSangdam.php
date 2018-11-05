<?
include 'config.php';
include 'util.php';

//마스터가 초기화 설정을 한다.

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//"tbnum="+tbn+"&pass="+gab+"&comId="+comIdgab

	$jsongab = '{"companyid":"err"}';
	//테이블의 자료를 초기화 한다.
	$rr0 = mysql_query("update Anyting_master set pass='0', uiu='0', roomInf = 0, nickname='0' where companyid = '".$comId."' and tbnum = ".$tbnum." limit 1",$rs);
	if(!$rr0){
		die("Anyting_master err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '{"companyid":"ok"}';
	}


	mysql_close($rs);

	echo($jsongab);
?>