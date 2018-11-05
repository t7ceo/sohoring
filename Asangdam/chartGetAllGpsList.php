<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);




	if($maingubun == 7) $evntss = "a.oninf = ".$eventOpt;   //현재 이벤트와 지난 이벤트를 구분(0: 지난 이벤트, 1:현재 이벤트)
	else $evntss = "a.oninf = 1";     //현재 등록된 가맹점   

	//$latpo = 0;
	//$longpo = 0;

	//가맹점 정보 가져옴
	$rr = mysql_query("select * from Anyting_company as a left join Anyting_comgps as b on(a.companyid = b.companyid) where ".$evntss." and a.gubun = ".$maingubun." and $sai > (select ROUND(6371 * acos(cos(radians(".$latpo.")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$longpo.")) + sin(radians(".$latpo.")) * sin(radians(b.latpo))) ,2)) order by a.id desc",$rs);
	if(!$rr){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '{"companyid":[';
		$i = 1;
       	while($row=mysql_fetch_array($rr)){
			if($i > 1) $jsongab .= ",";
			
			$rr1 = mysql_query("select count(companyid) as comid from AAonSangdamTb where companyid = '".$row[companyid]."'  ",$rs);
			if(!$rr1) die("Anyting_master room su err".mysql_error());
			$rsurow = mysql_fetch_array($rr1);


			$rr2 = mysql_query("select imgname from Anyting_comimg where companyid = '".$row[companyid]."' limit 1",$rs);
			if(!$rr2) die("Anyting_comimg select err".mysql_error());
			$imgrow = mysql_fetch_array($rr2);


			
			//위도 경도를 가져온다. 
/*
			$oprr = mysql_query("select latpo, longpo from Anyting_comgps  where companyid = '".$row[companyid]."' ",$rs);			
			if(!$oprr){
				die("Anyting_master roomopen err".mysql_error());
				$jsongab = '{"companyid":"err"}';
			}else{
				$rgps = mysql_fetch_array($oprr);
				$latpo = $rgps[latpo];
				$longpo = $rgps[longpo];
			}
*/


			$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$imgrow[imgname].'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'" , "url":"'.$row[url].'",  "rsu":'.$rsurow[comid].'}';
			
			$i++;

		}
		$jsongab .= ']}';
	}
	

	mysql_close($rs);

	echo($jsongab);
?>