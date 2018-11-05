<?
include 'config.php';
include 'util.php';
	//myroomsendpg 에서 호출 합니다.-대화방

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//대화방에서 상담 업체이면 이전에 남겨진 모든 메시지와 현재의 메시지를 모두 가져온다.
	$ss = mysql_query("select * from AAmyMess where companyid = '".$comid."' and  ((fromid = '".$from."' and tomanid = '".$toman."') or (fromid = '".$toman."' and tomanid = '".$from."')) order by indate ",$rs);


		if(!$ss){
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$c = 0;
			while($row=mysql_fetch_array($ss)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"fm":"'.$row[fromid].'", "to":"'.$row[tomanid].'", "me":"'.$row[message].'", "id":'.$row[id].', "dy":"'.$row[indate].'"}';
				
				$c++;
			}
			$jsongab .= ']}';
		}




	mysql_close($rs);

	echo($jsongab);
?>