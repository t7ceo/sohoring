<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//uiu 설정이 않된 경우 설정을 한다.
	$rr = mysql_query("update Anyting_manager set uiu = '".$puiu."' where memid = '".$memid."' and meminf = 1 and uiu = '0' limit 1",$rs);
	if(!$rr) die("Anyting_manager uiu set err".mysql_error());



	//매니저 여부를 파악한다. $memid
	$rr1 = mysql_query("select count(memid) as manag, id from Anyting_manager where companyid = '".$comid."' and memid = '".$memid."' and uiu = '".$puiu."' and meminf = 1  limit 1",$rs);
	if(!$rr1){
		die("Anyting_manager select err".mysql_error());
		$mastergab = '{"master":"err"}';
	}else{
		$row1 = mysql_fetch_array($rr1);
		if($row1[manag] < 1){
			$mastergab = '{"master":"Manager error"}';
		}else{
			//여러명의 메니저가 방을 연다.
			$manageid = $row1[id];  //방을 오픈한 메니저의 고유번호를 저장
			
			if($tpass == "1220738194"){    //상담센터의 매니저 모드
					$mastergab = '{"master":"ok", "managerid":'.$manageid.'}';
					
					//대화의 테이블을 설정한다.
					$rr = mysql_query("update Anyting_master set uiu = 'Manager', roomInf = 1, nickname = '".$nicn."' where companyid = '".$comid."' and tbnum = 0 limit 1",$rs);
					if(!$rr) die("Anyting_master update err".mysql_error());
				
			}else{                         //상담센터가 아닌곳의 매니저 모드
				$rr0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' and tbnum = ".$tnum." limit 1",$rs);
				if(!$rr0){
					die("Anyting_master select err".mysql_error());
					$mastergab = '{"master":"err"}';
				}else{
					$row0=mysql_fetch_array($rr0);
					if($row0[pass] <> $tpass){                    //테이불의 비밀번호가 다르다.
						$mastergab = '{"master":"Pass error"}';
					}else{
						$mastergab = '{"master":"ok", "managerid":'.$manageid.'}';
						
						//대화의 테이블을 설정한다.
						$rr = mysql_query("update Anyting_master set uiu = 'Manager', roomInf = 1, nickname = '".$nicn."' where companyid = '".$comid."' and tbnum = 0 limit 1",$rs);
						if(!$rr) die("Anyting_master update err".mysql_error());
	
					}
				
				}
			
			}

		}
	}
				

	mysql_close($rs);

	echo($mastergab);
?>