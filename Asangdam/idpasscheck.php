<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$basPass = "MTIzNA==";   //1234;

	switch($gubun){
	case 1:  //아이디 찾기
		$rr = mysql_query("select memid from soho_Anyting_member where email = '".$email."' limit 1",$rs);
		if(!$rr){
			die("member check err".mysql_error());
			$jsongab = '{"find":"err"}';
		}else{
			$row=mysql_fetch_array($rr);
			if($row[memid] != "") $jsongab = '{"find":"'.$row[memid].'"}';
			else $jsongab = '{"find":"er1"}';
		}
	break;
	case 2:  //비밀번호 초기화
		$rr = mysql_query("select count(memid) as su, id from soho_Anyting_member where (email = '".$email."' and memid = '".$myid."')  limit 1",$rs);
		if(!$rr){
			die("password check err".mysql_error());
			$jsongab = '{"find":"err"}';
		}else{
			$row=mysql_fetch_array($rr);
			if($row[su] > 0){  //
				$jsongab = '{"find":"당신의 비밀번호를 1234로 초기화 했습니다."}';			
	
				//비밀번호 1234로 초기화
				$result=mysql_query("update soho_Anyting_member set pass = '".$basPass."' where id = ".$row[id]." limit 1",$rs);
				if(!$result) die("passwd update err".mysql_error());
			}else{
				$jsongab = '{"find":"Id 또는 Email 오류 입니다."}';			
			}
		}
	break;
	}


	mysql_close($rs);

	echo($jsongab);
?>