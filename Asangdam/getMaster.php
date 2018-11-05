<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	//자동으로 테이블 번호를 받은 경우 설정
	if($attb > 0) $tnum = $attb;

	//일반사용자가 대화할 수 있는 방을 선택하여 열어 준다.
	//통화가능한 전화 번호를 저장한다.
	//사용자가 대화 할 수 있도록 방을 연다 중복불가, 이미 사용중인방 불가
	$rr0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' and tbnum = ".$tnum." limit 1",$rs);
	if(!$rr0){
		die("Anyting_master select err".mysql_error());
		$mastergab = '{"master":"err"}';
	}else{
       	$row0=mysql_fetch_array($rr0);
		
		$telgab = "0";
		$scenter = true;
		if($memid == "ch12205738~!"){   //상담센터아닌 곳에서 대화방 개설을 원한다.
			$scenter = false;
		}else{                          //상담센터에서 대화발 개설을 웒한다.
			$row0[pass] = $tpass;       //비밀번호 관계없이 무조건 연다.
			$telgab = $tpass;
			$nicn = $memid;		
		}
		
		
		if($row0[pass] <> $tpass){
			$mastergab = '{"master":"Pass error"}';
		}else if($row0[uiu] <> $puiu and $row0[uiu] <> 0){
			$mastergab = '{"master":"이미 사용중인 방입니다."}';
		}else{
			$rr1 = mysql_query("select count(uiu) as uu from Anyting_master where ((companyid = '".$comid."' and uiu = '".$puiu."') and tbnum <> ".$tnum.")  ",$rs);
			if(!$rr1){
				die("Anyting_master select err2".mysql_error());
				$mastergab = '{"master":"err"}';
			}else{
				$uiurow = mysql_fetch_array($rr1);
				if($uiurow[uu] > 0){
					if($scenter){       //상담센터에서 중복사용일 경우는 이전것을 지우고 새로 설정한다.
						
						//그때 나눈 모든 대화내용을 저장한다.
						$rr3 = mysql_query("select tbnum from Anyting_master where (companyid = '".$comid."' and uiu = '".$puiu."') limit 1 ",$rs);
						$tbnumrow = mysql_fetch_array($rr3);

						//이전에 사용하던 테이블을 삭제 한다.
						$rr = mysql_query("update Anyting_master set uiu = '0', roomInf = 0, nickname = '0', sex = 'm' where companyid = '".$comid."' and uiu = '".$puiu."' ",$rs);
						if(!$rr) die("Anyting_company uiu err".mysql_error());
						
						//이전 기록을 보존한다.
						$rr = mysql_query("update Anyting_message set fromnum = (fromnum + 5000), tonum = (tonum + 5000) where companyid = '".$comid."' and (fromnum = ".$tbnumrow[tbnum]." or tonum = ".$tbnumrow[tbnum].") and (pass = '".$memid."' or toman = '".$memid."')  ",$rs);
						if(!$rr) die("Anyting_message get uiu err".mysql_error());


						//새로운 테이블을 연다
						//정상처리
						$mastergab = '{"master":"ok"}';
				
						$rr = mysql_query("update Anyting_master set uiu = '".$puiu."', roomInf = 1, nickname = '".$nicn."', sex = '".$sex."' where companyid = '".$comid."' and tbnum = ".$tnum." limit 1",$rs);
						if(!$rr) die("Anyting_company select err".mysql_error());
						
						
						//전화번호 설정
						$rr = mysql_query("update soho_Anyting_member set tel = '".$telgab."' where memid = '".$nicn."' limit 1",$rs);
						if(!$rr) die("soho_Anyting_member tel set err".mysql_error());
					
						
					}else{               //상담 센터 아닌 곳에서 호출
						$mastergab = '{"master":"중복 사용은 불가능 합니다."}';
						
						//중복사용일 경우 말들어 졌던 테이블을 다시 초기화하여 만들어 졌던 테이블을 지운다.
						$rr = mysql_query("update Anyting_master set uiu = '0', roomInf = 0, nickname = '0', sex = 'm' where companyid = '".$comid."' and tbnum = ".$tnum." limit 1",$rs);
						if(!$rr) die("Anyting_company select err".mysql_error());
					
					}
					

					
				}else{
					//정상처리
					$mastergab = '{"master":"ok"}';
			
					$rr = mysql_query("update Anyting_master set uiu = '".$puiu."', roomInf = 1, nickname = '".$nicn."', sex = '".$sex."' where companyid = '".$comid."' and tbnum = ".$tnum." limit 1",$rs);
					if(!$rr) die("Anyting_company select err".mysql_error());
					
					
					
					if($scenter){     //일반사용자의 반대 상담센터에서 온것 이다. 전화번호를 설정한다.
						$rr = mysql_query("update soho_Anyting_member set tel = '".$telgab."' where memid = '".$nicn."' limit 1",$rs);
						if(!$rr) die("soho_Anyting_member tel set err".mysql_error());
					}
				}
			}
		}

	}

	mysql_close($rs);

	echo($mastergab);
?>