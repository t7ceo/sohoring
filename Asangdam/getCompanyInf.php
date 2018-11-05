<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"result":"err"}';
	//업체의 모든 정보를 출력한다.
	$rr0 = mysql_query("select * from Anyting_company as a left join Anyting_comimg as b on(a.companyid = b.companyid) where a.companyid = '".$comid."'  limit 1 ",$rs);
	if(!$rr0){
		die("Anyting_companyinf err".mysql_error());
		$jsongab = '{"result":"err"}';
	}else{
		$rr1 = mysql_query("select latpo, longpo from Anyting_comgps where companyid = '".$comid."' order by id desc  limit 1 ",$rs);
		if(!$rr1){
			die("Anyting_companyinf err".mysql_error());
			$jsongab = '{"result":"err"}';
		}else{
			$row = mysql_fetch_array($rr0);
			$row1 = mysql_fetch_array($rr1);
		
		
			$jsongab = '{"result":';
			$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$row[imgname].'", "sangho":"'.$row[sangho].'", "coname":"'.$row[coname].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "gubun":'.$row[gubun].',"addr":"'.$row[juso].'", "latpo":'.$row1[latpo].', "longpo":'.$row1[longpo].',  "memo":"'.$row[memo].'"}';
	
			$jsongab .= '}';
		}
		
	}


	mysql_close($rs);

	echo($jsongab);
?>