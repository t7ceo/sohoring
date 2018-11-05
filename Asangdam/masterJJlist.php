<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"mg":"err"}';
	//매니저 모두 출력
	$rr0 = mysql_query("select * from Anyting_manager where companyid = '".$comid."' order by meminf desc, indate desc ",$rs);
	if(!$rr0){
		die("Anyting_master err".mysql_error());
		$jsongab = '{"mg":"err"}';
	}else{
		$c = 0;
		$jsongab = '{"mg":[';
       	while($row=mysql_fetch_array($rr0)){
			if($c > 0) $jsongab .= ",";

			$jsongab .= '{"mid":"'.$row[memid].'", "na":"'.$row[name].'", "minf":'.$row[meminf].', "day":"'.$row[indate].'", "id":"'.$row[id].'"}';
			$c++;
		}
		$jsongab .= ']}';
		
	}


	mysql_close($rs);

	echo($jsongab);
?>