<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = y_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"delr":"err"}';
	
	
   		//세메시지 삭제
    	$q = "delete from Anyting_mypo where recnum = ".$delrecnum."  limit 1";
    	$result=mysql_query($q,$rs);
	

	
	$jsongab = '{"delr":"ok"}';
	

	mysql_close($rs);

	echo($jsongab);
?>