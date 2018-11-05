<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	//받는 사람의 고유 등록번호를 가져 온다.
	$ss = mysql_query("select gcmid, bell, login, endtime from soho_Anyting_gcmid where memid = '".$toid."' and project = '".$project."' limit 1 ",$rs);
	$gcmid = mysql_fetch_array($ss);

	$aday = date("Y-m-d h:i:s");
	$bellgo = false;

	//가맹점의 등록자에게 메시지를 보낸다.
	if($gcmid[bell] == 1){     //메시지를 받는 상태
		$bellgo = true;
		//호출 일시를 기록한다.
		mysql_query("update soho_Anyting_gcmid set endtime = '".$aday."' where memid = '".$toid."'  and project = '".$project."' limit 1 ",$rs);
		//sendMessageGCM($mess, $from, $gcmid[gcmid]);
		//mysql_query("insert into Anyting_test (t2, t3, db2)values('".$gcmid[endtime]."','".$aday."',".$aa.")",$rs);
	}else{         //메시지를 않받는 상태
		//오류검증을 한다.
			//로그아웃상태에서 메시지를 않받게 되어 있다면 무조건 오류 - 받는 상태로 변경
			if($gcmid[login] == "no"){
				$bellgo = true;
				mysql_query("update soho_Anyting_gcmid set bell = 1, endtime = '".$aday."' where memid = '".$toid."'  and project = '".$project."' limit 1 ",$rs);
			}else{    //로그인 상태라면 최종대화 시간을 확인하여 25분 이상 대화가 없다면 대화 받는 상태로 설정
				$t1 = strtotime($gcmid[endtime]);
				$t2 = strtotime($aday);
			
				$aa = ($t2 - $t1)/60;    //시간 차이를 구하는 공식
				if($aa > 25){    //25분 이상 대화가 없다면 자동 로그아웃 한다.
					$bellgo = true;
					mysql_query("update soho_Anyting_gcmid set bell = 1, login = 'no', endtime = '".$aday."' where memid = '".$toid."'  and project = '".$project."' limit 1 ",$rs);
				}
			}
	}


	
	if($bellgo){
		//실제 메시지를 발송 한다.
		sendMessageGCM($mess, $from, $gcmid[gcmid]);
	}

	mysql_close($rs);

?>