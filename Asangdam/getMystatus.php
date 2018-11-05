<?
include 'config.php';
include 'util.php';

//마스터가 초기화 설정을 한다.

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"genRtn":"err"}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select roomInf from Anyting_master where companyid = '".$comid."' and tbnum = ".$tbnum." limit 1",$rs);
	if(!$rr0){
		die("Anyting_master set mystatus err".mysql_error());
		$jsongab = '{"genRtn":"err"}';
	}else{
		$row = mysql_fetch_array($rr0);
		$jsongab = '{"genRtn":'.$row[roomInf].'}';
	}


	mysql_close($rs);

	echo($jsongab);
?>