<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//$bb = sendMessageGCM($auth, $registration_idPhone);

	//가맹점의 점주가 보는페이지 이다.
	//상담자아이디, 전화번호와 최종 매시지 일시를 표시
	//내가 보낸 메시지를 받은 사람을 그룹으로 묶어서 명단을 파악한다.
	

//나의 메시지를 받은 사람의 리스트는 이것으로 구할 수 있다. 나에게 보낸 사람은?
	$rrA = mysql_query("select memid, tel from soho_Anyting_member where memid in(select fromid from AAmyMess  where companyid = '".trim($comid)."' and  tomanid = '".trim($memid)."' union  select tomanid from AAmyMess  where companyid = '".trim($comid)."' and  fromid = '".trim($memid)."' group by tomanid)  order by memid ",$rs);
	if(!$rrA){
		$jsongab = '{"rs":"err"}';
	}else{

			$jsongab = '{"rs":[';
			$c = 0;
			while($row=mysql_fetch_array($rrA)){
				if($c > 0) $jsongab .= ",";
				$jsongab .= '{"to":"'.$row[memid].'", "tel":"'.$row[tel].'"}';
				
				$c++;
			}
			$jsongab .= ']}';



	}
	
	mysql_close($rs);
	
	echo($jsongab);
?>