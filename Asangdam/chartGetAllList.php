<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//$phpsessionid = "kkk";
	//$ipgab = gethostbyname("chimappram.com");



	
	if($maingubun == 7) $evntss = "oninf = ".$eventOpt;   //현재 이벤트와 지난 이벤트를 구분
	else $evntss = "oninf = 1";     //현재 등록된 가맹점   


	//갑맹점 정보 가져옴
	$rr = mysql_query("select * from Anyting_company where ".$evntss." and gubun = ".$maingubun."  order by id desc",$rs);
	if(!$rr){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '{"companyid":[';
		$i = 1;
       	while($row=mysql_fetch_array($rr)){
			if($i > 1) $jsongab .= ",";
			//업체의 이미지를 가져온다.
			$rr1 = mysql_query("select * from Anyting_comimg where companyid = '".$row[companyid]."' limit 1",$rs);
			if(!$rr1) die("Anyting_comimg select err".mysql_error());
			$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
			
			//열려 있는 방의 갯수를 계산한다.
			$oprr = mysql_query("select count(companyid) as comid from AAonSangdamTb where companyid = '".$row[companyid]."' ",$rs);			
			if(!$oprr){
				die("Anyting_master roomopen err".mysql_error());
				$jsongab = '{"companyid":"err"}';
			}else{
				$roomsu = mysql_fetch_array($oprr);
			}


			$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$imgrow[imgname].'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "url":"'.$row[url].'",  "rsu":'.$roomsu[comid].' }';
			
			$i++;

		}
		$jsongab .= ']}';
	}
	
	
	//$jsongab = '{"companyid":'.$bb.'}';
	mysql_close($rs);

	echo($jsongab);
?>