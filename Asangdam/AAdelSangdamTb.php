<?
include 'config.php';
include 'util.php';




	//데이트베이스 연결
 rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$rr1 = mysql_query("delete from AAonSangdamTb where memid = '".$memid."' ",$rs);
	if(!$rr1){
		$jsongab = '{"rs":"err"}';
	}else{
		$jsongab = '{"rs":"ok"}';
	}
	

	mysql_close($rs);

	echo($jsongab);
?>