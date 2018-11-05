<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	//테이블의 상태를 가져온다.
	$rr1 = mysql_query("select roomInf from Anyting_master where companyid = '".$comid."' and (tbnum >= ".$lstS." and tbnum <= ".$lstE.") order by tbnum ",$rs);
	if(!$rr1){
		$jsongab = '{"roomInf":"err"}';
		die("Anyting_getTableState.php err".mysql_error());
	}else{
		
		$jsongab = '{"roomInf":[';
		$c = 0;
		while($row1=mysql_fetch_array($rr1)){
			if($c > 0) $jsongab .= ",";
			$jsongab .= '{"r":'.$row1[roomInf].'}';
			$c++;
		}
		$jsongab .= ']}';
	}

	mysql_close($rs);

	echo($jsongab);
?>