<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//메니져에게 새로운 메세지가 있는지 확인한다.
	$rr = mysql_query("select * from Anyting_mypo where companyid = '".$comid."' and tbnum = 0 and newinf = 1 limit 1",$rs);
	if(!$rr){
		die("Anyting_mypo select err".mysql_error());
		$jsongab = '{"companyid":"err"';
	}else{
		$jsongab = '{"companyid":"err"';
       	$row=mysql_fetch_array($rr);
		
		//새로운 메세지가 있는 경우
		if($row[recnum] > 0) $jsongab = '{"companyid":"ok"';
	}

	//테이블의 상태를 가져온다.
	$rr1 = mysql_query("select tbnum, roomInf, nickname from Anyting_master where companyid = '".$comid."' order by tbnum",$rs);
	if(!$rr1){
		die("Anyting_master select err".mysql_error());
		$jsongab .= ',"tbstat":"err"}';
	}else{
       	$jsongab .= ',"tbstat":[';
		$c = 0;
		while($row1=mysql_fetch_array($rr1)){
			if($c > 0) $jsongab .= ',';
			$jsongab .= '{"tbnum":'.$row1[tbnum].',"rominf":'.$row1[roomInf].',"ncname":"'.$row1[nickname].'"}';
			$c++;
		}
		$jsongab .= ']}';
	}

	mysql_close($rs);

	echo($jsongab);
?>