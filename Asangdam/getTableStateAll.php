<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//현재 업체에 대화 대기중인 모든 사람의 리스트를 AAonSangdamTb 에서 가져 온다.
	//리스트에서 사람을 선택하면 그사람이 파트너가 되고 그와 대화를 하게 된다.
	//리스트에서 사람의 아이디를 선택 할 수 있어야 한다.
	//리스트는 수시로 갱신 한다.
	
	//상담대기자를 최근에 들어온 순으로 출력한다.
	//상담센터의 사장은 제외 한다.
	$rr1 = mysql_query("select id, memid from AAonSangdamTb where companyid = '".$comid."' and memid != '".$mastid."' order by indate desc ",$rs);
	if(!$rr1){
		$jsongab = '{"rs":"err"}';
	}else{
		$jsongab = '{"rs":[';
		$c = 0;
		while($row=mysql_fetch_array($rr1)){

			if($c > 0) $jsongab .= ",";
			$jsongab .= '{"id":'.$row[id].', "memid":"'.$row[memid].'"}';
			$c++;

		}
		$jsongab .= ']}';
	}

	mysql_close($rs);

	echo($jsongab);
?>