<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//가맹점 정보 가져옴
	$rr = mysql_query("delete from Anyting_message where companyid = '".$comid."' and (tonum = ".$tnum." or fromnum = ".$tnum.") ",$rs);
	if(!$rr){
		die("Anyting_message delete err".mysql_error());
		$jsongab = '{"genRtn":"err"}';
	}else{
		$rr1 = mysql_query("delete from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$tnum." ",$rs);
		if(!$rr1){
			die("Anyting_mypo delete err".mysql_error());
			$jsongab = '{"genRtn":"err"}';
		}else{
			$jsongab = '{"genRtn":"ok"}';
		}
	}

	mysql_close($rs);

	echo($jsongab);
?>