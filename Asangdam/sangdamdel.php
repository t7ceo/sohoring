<?
include 'config.php';
include 'util.php';


	//선택한 회원과 관련한 메모를 출력한다.
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);
	//tomem="+sdmemid+"&comid="+comid+"&memid="+memid
	
	$jsongab = '{"rs":"err"}';
    $aa = mysql_query("delete from AAmyMess where id = ".$delid." limit 1",$rs);
	if(!$aa) die("Anyting_sangdam delete".mysql_error());

	//뉴메시지 부분도 삭제 한다.
    $aa = mysql_query("delete from AAmyPo where messid = ".$delid." limit 1",$rs);
	if(!$aa) die("Anyting_mypo delete".mysql_error());

	//Gcm 부분도 삭제 한다.
    $aa = mysql_query("delete from AAmyGcm where recnum = ".$delid." limit 1",$rs);
	if(!$aa) die("Anyting_mypo delete".mysql_error());



	$jsongab = '{"rs":"ok"}';
	
	mysql_close($rs);
	
	echo($jsongab);
?>