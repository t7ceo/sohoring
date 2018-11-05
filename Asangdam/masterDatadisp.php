<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"companyid":"err"}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' order by tbnum ",$rs);
	if(!$rr0){
		die("Anyting_master err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$c = 0;
		$jsongab = '{"companyid":[';
       	while($row=mysql_fetch_array($rr0)){
			if($c > 0) $jsongab .= ",";
			$jsongab .= '{"tbnum":"'.$row[tbnum].'", "pass":"'.$row[pass].'"}';
			$c++;
		}
		$jsongab .= ']}';
		
	}


	mysql_close($rs);

	echo($jsongab);
?>