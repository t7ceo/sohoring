<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = y_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");
	
	
	//gcm 벨 설정을 한다.
	$rr = mysql_query("insert into Anyting_test (t1,t2)values('".$t1."', '".$t2."') ",$rs);
	mysql_close($rs);

?>