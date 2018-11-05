<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);

	
		//상담 내용 전체 출력
		$rrB = mysql_query("select id, message, indate, fromid, tomanid from AAmyMess where companyid = '".$comid."' and ((fromid = '".$mastid."' and tomanid = '".$memid."') or (fromid = '".$memid."' and tomanid = '".$mastid."')) order by id desc",$rs);
		if(!$rrB){
			die("AAmyMess disp messate err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$c = 0;
			while($rowB = mysql_fetch_array($rrB)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"mess":"'.$rowB[message].'", "day":"'.$rowB[indate].'", "frm":"'.$rowB[fromid].'", "to":"'.$rowB[tomanid].'", "id":'.$rowB[id].'}';
				$c++;
			}
			$jsongab .= ']}';
		}


	
	mysql_close($rs);
	
	echo($jsongab);
?>