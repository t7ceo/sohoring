<?
include 'config.php';
include 'util.php';

	$jsongab = '{"popok":"err"}';
	//데이트 �이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$smff = "update AAmyPo set popinf = 1 where id = ".$recnum." limit 1";  
	$smfff=mysql_query($smff,$rs);
	
	
	$jsongab = '{"popok":"ok"}';
	
	

	mysql_close($rs);

	echo($jsongab);
?>