<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//메니져가 보낸 메세지
	$rr = mysql_query("select count(fromnum) as frm from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$rdTbnum." and fromnum = 0 and newinf = 1 ",$rs);
	if(!$rr){
		die("Anyting_mypo select err".mysql_error());
		$jsongab = '{"manager":"err"}';
	}else{
		$jsongab = '{"manager":"err",';
       	$row=mysql_fetch_array($rr);
		if($row[frm] > 0) $jsongab = '{"manager":"ok",';
	}



	//일반회원이 보낸 메세지
	$rr1 = mysql_query("select * from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$rdTbnum." and newinf = 1 ",$rs);
	if(!$rr1){
		die("Anyting_mypo select err".mysql_error());
		$jsongab .= '"genpep":"err"}';
	}else{
		$jsongab .= '"genpep":[';
		$c = 0;
       	while($row1=mysql_fetch_array($rr1)){
			if($c > 0) $jsongab .= ',';
			$jsongab .= '{"recnum":'.$row1[recnum].',"fromnum":'.$row1[fromnum].',"tbnum":'.$row1[tbnum].'}';	
			$c++;
		}
		$jsongab .= ']}';
	}


	mysql_close($rs);

	echo($jsongab);
?>