<?
include 'config.php';
include 'util.php';

	$jsongab = '{"popok":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$rr = "select count(fromid) as su from AAmyPo wher id = ".$recnum." limit 1";
	$rr1 = mysql_query($rr,$rs);
	$row = mysql_fetch_array($rr1);


	$smff = "delete from AAmyPo where id = ".$recnum." limit 1";  
	$smfff=mysql_query($smff,$rs);
	
	
	
	$jsongab = '{"popok":"ok", "su":'.$row[su].'}';
	
	

	mysql_close($rs);

	echo($jsongab);
?>