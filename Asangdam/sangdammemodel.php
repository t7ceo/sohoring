<?
include 'config.php';
include 'util.php';


	//선택한 회원과 관련한 � 모를 출력한다.
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);
	//tomem="+sdmemid+"&comid="+comid+"&memid="+memid
	
	$jsongab = '{"rs":"err"}';
    $aa = mysql_query("delete from AAmyMemo where id = ".$delid." limit 1 ",$rs);
	if(!$aa) die("Anyting_memo delete".mysql_error());
	$jsongab = '{"rs":"ok"}';
	
	mysql_close($rs);
	
	echo($jsongab);
?>