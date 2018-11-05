<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//파트너가 현재 있는 업체의 아이디와 상호를 구한다.
	$rr1 = mysql_query("select a.companyid, b.sangho, count(a.memid) as su from AAonSangdamTb as a left join Anyting_company as b on(a.companyid = b.companyid) where  a.memid = '".$toman."' limit 1 ",$rs);
	if(!$rr1){
		$jsongab = '{"rs":"err"}';
	}else{
		$row = mysql_fetch_array($rr1);
		if($row[su] > 0){
			$jsongab = '{"rs":"ok", "comid":"'.$row[companyid].'", "sh":"'.$row[sangho].'"}';				
		}else{
			$jsongab = '{"rs":"no"}';		
		}
	}

	mysql_close($rs);

	echo($jsongab);
?>