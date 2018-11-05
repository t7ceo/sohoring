<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if($oninf == 0) $qq = " order by a.id ";
	else  $qq = " order by a.id desc ";

	$jsongab = '{"companyid":"err"}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select * from Anyting_company as a left join Anyting_comimg as b on(a.companyid = b.companyid) where a.oninf = ".$oninf.$qq." ",$rs);
	if(!$rr0){
		die("Anyting_company control err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$c = 0;
		$jsongab = '{"companyid":[';

		if($oninf == 0){   //신규업체 선택
			while($row=mysql_fetch_array($rr0)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$row[imgname].'", "sangho":"'.$row[sangho].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "inday":"'.$row[inday].'", "inname":"'.$row[inname].'", "indon":'.$row[indon].', "indate":"'.$row[indate].'"}';
				$c++;
			}
			$jsongab .= ']}';
		
		}else{   //기존 업체 선택
			while($row=mysql_fetch_array($rr0)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$row[imgname].'", "sangho":"'.$row[sangho].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "inday":"'.$row[inday].'", "inname":"'.$row[inname].'", "indon":'.$row[indon].', "indate":"'.$row[indate].'"}';

				$c++;
			}
			$jsongab .= ']}';
		
		}
	
	}


	mysql_close($rs);

	echo($jsongab);
?>