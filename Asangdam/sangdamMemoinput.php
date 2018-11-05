<?
include 'config.php';
include 'util.php';


	//선택한 회원과 관련한 메모를 출력한다.
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);
	//tomem="+sdmemid+"&comid="+comid+"&memid="+memid
	
	$ad_date = date("Y-m-d H:i:s");

	$jsongab = '{"rs":"err"}';
	$rr = mysql_query("insert into AAmyMemo (tomem, companyid, wrt, mmo,indate) values('".$tomem."', '".$comid."', '".$memid."', '".$memo."', '".$ad_date."')",$rs);
	if(!$rr){
		die("Memo input err".mysql_error());
	}else{
		$jsongab = '{"rs":"ok"}';
	}


	
	mysql_close($rs);
	
	echo($jsongab);
?>