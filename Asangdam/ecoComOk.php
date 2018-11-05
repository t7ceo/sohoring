<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$to_day = date("Y-m-d H:i:s");


	$jsongab = '{"companyid":"err"}';
	$aa1 = mysql_query("update Anyting_company set oninf = ".$oninf.", ondate = '".$to_day."' where companyid = '".$comid."'  limit 1",$rs); 
	if(!$aa1) die("company oninf ".mysql_error());	

	$ss = "select masterid from Anyting_company where companyid = '".$comid."'  limit 1";
	$bb = mysql_query($ss, $rs);
	$row = mysql_fetch_array($bb);


	//업주의 자격을 부여 한다.
	$aa2 = mysql_query("update soho_Anyting_member set meminf = 2, indate = '".$to_day."' where companyid = '".$comid."' and masterid = '".$row[masterid]."'  limit 1",$rs); 
	//if(!$aae) die("company oninf ".mysql_error());	


				
				
	//매니저 승인 처리를 한다.
	$aa3 = mysql_query("update Anyting_manager set name = 'master', meminf = 1 where companyid = '".$comid."' and name = 'none' and meminf = 11  limit 1",$rs); 
	if(!$aa3) die("manager set  ".mysql_error());
	
	
		
	$jsongab = '{"companyid":"ok"}';



/*

	//업체의 현재 마지막 테이블 번호를 구한다.
	$rr0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' order by tbnum desc limit 1",$rs);
	if(!$rr0){
		die("Anyting_ecoComOk0 err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$row = mysql_fetch_array($rr0);
		if($row[tbnum] < 1) $endtbnum = 0;   //테이블이 하나도 없는 경우
		else $endtbnum = $row[tbnum];
		
		
		
		$addtbsu = $tbsu - $endtbnum;
		//업체를 표시하게 한다.
		$to_day = date("Y-m-d H:i:s");

		
		
		
		if($addtbsu > 0){        //테이블 추가 되는 경우
			if($endtbnum > 0){   //기존에 테이블이 있기 때문에 추가 모드
				$igab = $row[tbnum]+1;
				//레코드를 추가 한다.
				$jsongab = '{"companyid":"err"}';				
				for($i = $igab; $i <= $tbsu; $i++){
					$radd = mysql_query("insert into Anyting_master (companyid, tbnum)values('".$comid."', ".$i." ) ",$rs);

					if(!$radd) die("ecoComOkADD add".mysql_error());
				}
			}else{     //기존에 테이블이 하나도 없어서 새로 생성모드
				//레코드를 추가 한다.
				//0번 레코드의 존재 여부를 파악하라.
				$rr1 = mysql_query("select count(tbnum) as tbc from Anyting_master where companyid = '".$comid."' and tbnum = 0  limit 1",$rs);
				if(!$rr1) die("ecoComOk0find add".mysql_error());
				$tbcrow = mysql_fetch_array($rr1);
				if($tbcrow[tbc] > 0) $foc = 1;   //0번 테이블이 있다.
				else $foc = 0;         //0번 테이블이 없다.
				
				$jsongab = '{"companyid":"err"}';				
				for($i = $foc; $i <= $tbsu; $i++){
					$radd = mysql_query("insert into Anyting_master (companyid, tbnum)values('".$comid."', ".$i." ) ",$rs);

					if(!$radd) die("ecoComOkNew add".mysql_error());
				}
				
				
				
				
				
				
				$aa1 = mysql_query("update Anyting_company set oninf = 1, ondate = '".$to_day."' where companyid = '".$comid."'  limit 1",$rs); 
				if(!$aa1) die("company oninf ".mysql_error());	
				
				//입금 처리를 한다.
				
				
				//매니저 승인 처리를 한다.
				$aa1 = mysql_query("update Anyting_manager set name = 'master', meminf = 1 where companyid = '".$comid."' and name = 'none' and meminf = 11  limit 1",$rs); 
				if(!$aa1) die("manager set  ".mysql_error());	
				
				//0번 테이블 open 으로 설정
				$aa1 = mysql_query("update Anyting_master set roomInf = 1 where companyid = '".$comid."' and tbnum = 0  limit 1",$rs); 
				if(!$aa1) die("company roomInf set ".mysql_error());	


				
			}
		
			$raddday = mysql_query("insert into Anyting_tablesu (companyid, tablesu,indate)values('".$comid."', ".$tbsu.", '".$to_day."' ) ",$rs);
			if(!$raddday) die("ecoComOkADD add".mysql_error());

		
			$jsongab = '{"companyid":"ok"}';
		
		}else if($addtbsu < 0){  //테이블 감소하는 경우
			$addtbsu = ($addtbsu * (-1));
			//기존의 테이블에서 오버된 수만 큼 레코드를 삭제 한다.
			for($i = 0; $i < $addtbsu; $i++){
				$ii = mysql_query("select id, tbnum from Anyting_master where companyid = '$comid' order by tbnum desc limit 1 ",$rs);
				if(!$ii) die("ecoComOk.php error".mysql_error());
				$delrow = mysql_fetch_array($ii);

				//삭제 테이블에 보내고 받은 모든 메세지를 삭제 한다.
				$radd = mysql_query("delete from Anyting_message where companyid = '$comid' and (fromnum = $delrow[tbnum] or tonum = $delrow[tbnum]) ",$rs);				

				//마스터 레코드 삭제
				$radd = mysql_query("delete from Anyting_master where id = $delrow[id]  limit 1 ",$rs);

				
				
				
				
				$jsongab = '{"companyid":"err"}';				
				if(!$radd) die("ecoComOk add".mysql_error());
				
			}
			
			$raddday = mysql_query("insert into Anyting_tablesu (companyid, tablesu, indate)values('".$comid."', ".$tbsu.", '".$to_day."' ) ",$rs);
			if(!$raddday) die("ecoComOkADD add".mysql_error());

			
			$jsongab = '{"companyid":"ok"}';
		}else{                                //레코드 변화 없음
			$jsongab = '{"companyid":"ok"}';
		}
		
		
		
	}
*/	
	
	

	mysql_close($rs);

	echo($jsongab);
?>