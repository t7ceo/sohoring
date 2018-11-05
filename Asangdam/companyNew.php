<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"companyid":"err"}';
	//전달받은 아이디로 운영중인 가게를 모두 출력한다.
	$rr0 = mysql_query("select * from Anyting_company as a left join Anyting_comimg as b on(a.companyid = b.companyid) where a.companyid = '".$comid."' and  a.oninf = ".$oninf."  limit 1 ",$rs);
	if(!$rr0){
		die("Anyting_company company sangse err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$c = 0;
		$jsongab = '{"companyid":';

		if($oninf == 0){   //신규업체 선택
			while($row=mysql_fetch_array($rr0)){
				
				//$rr = mysql_query("select tablesu from Anyting_tablesu where companyid = '".$comid."' order by indate desc limit 1",$rs);
				//if(!$rr) die("Anyting_tablesu error".mysql_error());
				//$rowt = mysql_fetch_array($rr);
				
				$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$row[imgname].'", "tbsu":0, "sangho":"'.$row[sangho].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "memo":"'.$row[memo].'", "juso":"'.$row[juso].'", "inday":"'.$row[inday].'", "inname":"'.$row[inname].'", "indon":'.$row[indon].', "ondon":'.$row[ondon].', "indate":"'.$row[indate].'", "ondate":"'.$row[ondate].'"}';
			}
			
			$jsongab .= '}';

		
		}else{   //기존 업체 선택
			while($row=mysql_fetch_array($rr0)){
				$rr = mysql_query("select * from Anyting_tablesu where companyid = '".$comid."' order by indate desc limit 1",$rs);
				if(!$rr) die("Anyting_tablesu error".mysql_error());
				$rowt = mysql_fetch_array($rr);
				
				$jsongab .= '{"comid":"'.$row[companyid].'", "comimg":"'.$row[imgname].'", "tbsu":'.$rowt[tablesu].', "sangho":"'.$row[sangho].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "memo":"'.$row[memo].'", "juso":"'.$row[juso].'", "inday":"'.$row[inday].'", "inname":"'.$row[inname].'", "indon":'.$row[indon].', "ondon":'.$row[ondon].', "indate":"'.$row[indate].'", "ondate":"'.$row[ondate].'"}';
			}
			
			$jsongab .= '}';
		
		}
	
	}


	mysql_close($rs);

	echo($jsongab);
?>