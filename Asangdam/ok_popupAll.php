<?
include 'config.php';
include 'util.php';

	$jsongab = '{"popok":"err"}';
	//데이트 �이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$smff = "delete from AAmyPo where messid = ".$messid." limit 1";  
	$smfff=mysql_query($smff,$rs);

	$smff1 = "delete from AAmyGcm where recnum = ".$messid." limit 1";  
	$smfff=mysql_query($smff1,$rs);

	
	
	$jsongab = '{"popok":"ok"}';
	
	

	mysql_close($rs);

	echo($jsongab);
?>