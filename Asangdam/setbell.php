<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");
	
	if(!$project) $project = "0";
	
	//gcm 벨 설정을 한��을 한 �.
	$rr = mysql_query("update soho_Anyting_gcmid set bell = ".$bellinf.", endtime = '".$aday."', login = 'ok' where memid = '".$memid."'  and project= '".$project."' limit 1 ",$rs);
	mysql_close($