<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


//나에게온 새로운 메시지를 찾아서 출력한다.


	$rr = mysql_query("select messid, fromid from AAmyPo where companyid = '".$comid."' and  tomemid = '".$tomemid."' and  newinf = 1 order by id",$rs);
	if(!$rr){
		die("AAmyPo select err".mysql_error());
		$kk = '{"rs":"err"}';
	}else{
       	
		$c = 0;
		$kk = '{"rs":[';
		while($row=mysql_fetch_array($rr)){
			if($c > 0)  $kk .= ",";
			//새로운 메세지가 있는 경우
			$kk .= '{"mesid":'.$row[messid].', "frm":"'.$row[fromid].'"}';
			$c++;
		}
		$kk .= ']}';
	
	}


	mysql_close($rs);

	echo($kk);
?>