<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//당신은 마스터 인가?
	//마스터이면 보낸 사람의 아이디만 가지고 보낸 사람의 테이블 번호를 찾는다. 
	//당신이 마스터가 아니면 마스터의 아이디 또는 "manager" 라는 공통된 이름으로 테이블 번호를 찾는다.
	if($tnum == 0) $ss = "select tbnum, count(sex) as su from Anyting_master where companyid = '".$comid."' and nickname = '".$sendman."' limit 1";
	else $ss = "select tbnum, count(sex) as su from Anyting_master where companyid = '".$comid."' and (nickname = '".$sendman."' or nickname = 'manager') limit 1";
	
	$ra = mysql_query($ss,$rs);
	$row = mysql_fetch_array($ra);
	
	
	$jsongab = '{"rs":"err"}';
	if($row[su] > 0){    //현재 테이블에 있다.
		$jsongab = '{"rs":'.$row[tbnum].'}';
	}else{
		$jsongab = '{"rs":"no"}';
	}
	
	echo($jsongab);
	
	
	mysql_close($rs);

?>