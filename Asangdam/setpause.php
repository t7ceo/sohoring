<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");
	
	
	//gcm 벨 설정을 한다.
	$rr = mysql_query update AAonSangdamTb set pauseinf = ".$pinf." where memid = '".$memid."' limit 1 ",$rs);
	mysql_close($rs);

?>