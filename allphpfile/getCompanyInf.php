<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"result":"err"}';
	//업체의 모든 정보를 출력한다.
	$rr0 = mysql_query("select * from Anyting_company where companyid = '".$comid."'  limit 1 ",$rs);
	if(!$rr0){
		die("Anyting_companyinf err".mysql_error());
		$jsongab = '{"result":"err"}';
	}else{
		
		//메인 로고를 가져 온다.
		$ll = mysql_query("select imgname from Anyting_comimg where companyid = '".$comid."' and gubun = 1 limit 1", $rs);
		$rowimg = mysql_fetch_array($ll);
		if($rowimg[imgname] == ""){
			$logimg = "sangseBas.png";
		}else{
			$logimg = $rowimg[imgname];
		}

		
		$rr1 = mysql_query("select latpo, longpo from Anyting_comgps where companyid = '".$comid."' order by id desc  limit 1 ",$rs);
		if(!$rr1){
			die("Anyting_companyinf err".mysql_error());
			$jsongab = '{"result":"err"}';
		}else{
			$row = mysql_fetch_array($rr0);
			$row1 = mysql_fetch_array($rr1);
		
		
			$jsongab = '{"result":';
			$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$logimg.'", "sangho":"'.$row[sangho].'", "coname":"'.$row[coname].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "mgubun":'.$row[jygab].', "gubun":'.$row[gubun].',"addr":"'.$row[juso].'", "latpo":'.$row1[latpo].', "longpo":'.$row1[longpo].',  "memo":"'.$row[memo].'"}';
	
			$jsongab .= '}';
		}
		
	}


	mysql_close($rs);

	echo($jsongab);
?>