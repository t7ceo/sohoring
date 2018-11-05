<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = "err";
	if($inf == 1){
		//메니저 등록처리
		$result=mysql_query("update Anyting_manager set meminf = 1, indate = '".$ad_date."' where id = ".$id." limit 1",$rs);
		if(!$result) die("onManagerOk up err".mysql_error());
		$ss = "ok";
	}else{
		//메니저 삭제
	    $aa = mysql_query("delete from Anyting_manager where id = ".$id." limit 1 ",$rs);
		if(!$aa) die("onManagerOk del err1".mysql_error());
		
		//메세지 중에서 해당메니저에게 온것 모두 삭제
		$bb = mysql_query("select recnum from Anyting_mypo where managid = ".$id." order by recnum ", $rs);
		if(!$bb) die("onManagerOk mypo del err".mysql_error());
		while($delrow = mysql_fetch_array($bb)){
			//메시지 삭제
			$aa = mysql_query("delete from Anyting_message where id = ".$delrow[recnum]." limit 1 ",$rs);
			if(!$aa) die("onManagerOk message err1".mysql_error());
		}
		
		$ss = "ok";
	}

	mysql_close($rs);

echo('{"result":"'.$ss.'"}');

?>