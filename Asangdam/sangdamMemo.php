<?
include 'config.php';
include 'util.php';


	//선택한 회원과 관련한 메모를 출력한다.
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);

	
	
		//메모 내용을 모두 출력한다.
		//$ss = "select * from Anyting_memo where companyid = '".$comid."' and wrt = '".$rowA[masterid]."' and tomem = '".$tomem."' order by id ";

		$ss = "select * from AAmyMemo where companyid = '".$comid."' and wrt = '".$mastid."' and tomem = '".$tomem."' order by id desc";
		
		$rr = mysql_query($ss,$rs);
		if(!$rr){
			$jsongab = '{"rs":"err"}';
			die("Anyting_company master id err".mysql_error());

		}else{
			$jsongab = '{"rs":[';
			$c = 0;
			$aa = "";
			while($rowB = mysql_fetch_array($rr)){
				if($c > 0) $jsongab .= ",";
				
				$jsongab .= '{"mmo":"'.$rowB[mmo].'", "day":"'.$rowB[indate].'", "to":"'.$rowB[tomem].'", "id":'.$rowB[id].'}';
				//$aa .= $rowB[mmo]."/".$rowB[indate]."/".$rowB[tomem];
				
				$c++;
			}
			$jsongab .= ']}';
			
			//$jsongab = '{"rs":'.$c.'}';
		}

	//$jsongab = '{"rs":10}';
	
	mysql_close($rs);
	
	echo($jsongab);
?>