<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결 	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	//출력하는 메세지 삭제
	$sm = "delete from Anyting_newSt where id = ".$delid." limit 1";
	$smf=mysql_query($sm,$rs);
	$jsongab = '{"genRtn":"err"}';
	if(!$smf)die("Anyting_newSt del 2 err".mysql_error());
	$jsongab = '{"genRtn":"ok"}';

	mysql_close($rs);

	echo($jsongab);
?>