<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"companyid":"err"}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select companyid, sangho from Anyting_company where masterid = '".$memid."' and oninf = 1 order by id desc ",$rs);
	if(!$rr0){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$c = 0;
		$jsongab = '{"companyid":[';
       	while($row=mysql_fetch_array($rr0)){
			if($c > 0) $jsongab .= ",";
			$jsongab .= '{"comid":"'.$row[companyid].'", "sangho":"'.$row[sangho].'"}';
			$c++;
		}
		$jsongab .= ']}';
		
	}


	mysql_close($rs);

	echo($jsongab);
?>