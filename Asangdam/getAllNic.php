<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	//테이블의 상태를 가져온다.
	$rr1 = mysql_query("select nickname, tbnum from Anyting_master where companyid = '".$comid."' order by tbnum",$rs);
	if(!$rr1){
		$jsongab = '{"allnic":"err"}';
		die("Anyting_getAllNic err".mysql_error());
	}else{
		
       	$jsongab = '{"allnic":[';
		$c = 0;
		while($row1=mysql_fetch_array($rr1)){
			if($c > 0) $jsongab .= ',';
			$jsongab .= '{"tbnum":'.$row1[tbnum].', "nickname":"'.$row1[nickname].'"}';
			
			$c++;
		}
		$jsongab .= ']}';
	}



	mysql_close($rs);

	echo($jsongab);
?>