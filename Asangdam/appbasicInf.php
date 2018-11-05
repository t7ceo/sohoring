<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");
	
	if(!$vernum) $vernum = "1.0";
	
	$ss = "select * from Anyting_appinf ";
	$ra = mysql_query($ss,$rs);
	$row = mysql_fetch_array($ra);
	
	
	$jsongab = '{"rs":"err"}';
	if($row[ver_num] != $vernum){
		//현재 앱의 버젼을 설정한다.
		$rr = mysql_query("update soho_Anyting_gcmid set ver_num = '".$vernum."' where udid = '".$uiu."' limit 1 ",$rs);
		$jsongab = '{"rs":"up", "ver":"'.$row[ver_num].'"}';
	}else{
		$jsongab = '{"rs":"no","ver":"'.$row[ver_num].'"}';
	}
	
	echo($jsongab);
	
	
	mysql_close($rs);

?>