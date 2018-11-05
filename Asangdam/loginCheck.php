<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"memsu":"err"}';
	//아이디 체크
	$rr = mysql_query("select count(memid) as su, email, id from soho_Anyting_member where memid = '".$memid."' limit 1 ",$rs);
	if(!$rr) die("member check err".mysql_error());
	$row=mysql_fetch_array($rr);
	if($row[su] > 0){  //아이디가 존재 하는 경우 정상 로그인
		$rr1 = mysql_query("select count(a.memid) as su, a.meminf, a.uiu from soho_Anyting_member as a left join Anyting_manager as b on(a.memid = b.memid) where a.pass = '".$passwd."' limit 1 ",$rs);
		if(!$rr1) die("member check err".mysql_error());
		$row1=mysql_fetch_array($rr1);
		if($row1[su] > 0){    //아이디가 정상적으로 존재하는 경우
			if($row1[meminf] == 9){      //총괄대표의 자격 확인
				if($row1[uiu] == $uiug){    
					$jsongab = '{"memsu":"go", "meminf":9, "email":"'.$row[email].'", "monly":'.$row[id].'}';
				}else{
					$jsongab = '{"memsu":"go", "meminf":0, "uiugab":"'.$uiug.'", "email":"'.$row[email].'", "monly":'.$row[id].'}';
				}
			}else{                       //일반회원의 자격확인
				$jsongab = '{"memsu":"go", "meminf":'.$row1[meminf].', "email":"'.$row[email].'", "monly":'.$row[id].'}';
			}
			
			
			if(!$project) $project = "0";
			
			//gcm에 아이디 저장
			$rr = mysql_query("update soho_Anyting_gcmid set memid='".$memid."' where udid = '".$uiug."' and project= '".$project."' limit 1",$rs);
			if(!$rr) die("gcm memid up date err".mysql_error());
			//gcm에 중복된 자료는 삭제 한다.
			$rr = mysql_query("delete from soho_Anyting_gcmid where memid='' and udid = '".$uiug."' and project= '".$project."' ",$rs);
			if(!$rr) die("gcm memid up date err".mysql_error());
			
			
			
		}else{
		 	$jsongab = '{"memsu":"passerr", "meminf":0}';			
		}
	}else{
		 $jsongab = '{"memsu":"iderr", "meminf":0}';	
	}

	mysql_close($rs);

	echo($jsongab);
?>