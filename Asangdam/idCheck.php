<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//챠트기록 가져옴
	$rr = mysql_query("select count(memid) as su from Anyting_membe where memid = '".$memid."' ",$rs);
	if(!$rr){
		die("member check err".mysql_error());
		$jsongab = '{"memsu":"err"}';
	}else{
		$row=mysql_fetch_array($rr);
		if($row[su] == 0) $jsongab = '{"memsu":"go"}';
		else $jsongab = '{"memsu":"no"}';
	}

	mysql_close($rs);

	echo($jsongab);
?>