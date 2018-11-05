<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//$phpsessionid = "kkk";
	//$ipgab = gethostbyname("chimappram.com");

	$bb = sendMessageGCM($auth, $registration_idPhone);


	//갑맹점 정보 가져옴
	$rr = mysql_query("select * from Anyting_company where oninf = 1 and gubun = ".$maingubun."  order by id desc",$rs);
	if(!$rr){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '{"companyid":[';
		$i = 1;
       	while($row=mysql_fetch_array($rr)){
			if($i > 1) $jsongab .= ",";
			$rr1 = mysql_query("select * from Anyting_comimg as a left join Anyting_tablesu as b on(a.companyid=b.companyid) where a.companyid = '".$row[companyid]."' order by a.id desc,b.id desc limit 1",$rs);
			if(!$rr1) die("Anyting_comimg select err".mysql_error());
			$imgrow = mysql_fetch_array($rr1);

			$oprr = mysql_query("select count(companyid) as comid from Anyting_master where companyid = '".$row[companyid]."' and roomInf = 1",$rs);			if(!$oprr){
				die("Anyting_master roomopen err".mysql_error());
				$jsongab = '{"companyid":"err"}';
			}else{
				$roomsu = mysql_fetch_array($oprr);
			}


			$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$imgrow[imgname].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "sangho":"'.$row[sangho].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'", "tbsu":'.$imgrow[tablesu].', "rsu":'.$roomsu[comid].' }';
			
			$i++;

		}
		$jsongab .= ']}';
	}
	
	
	//$jsongab = '{"companyid":'.$bb.'}';
	mysql_close($rs);

	echo($jsongab);
?>