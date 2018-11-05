<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


//테이블 번호가 달라도 회원 아이디로 메시지를 찾아야 한다.

	//나에게 새로운 메세지가 있는지 확인한다.
	$rr = mysql_query("select * from Anyting_mypo where companyid = '".$comid."' and  ((tbnum = ".$rdTbnum." and newinf = 1)  or (tomemid = '".$memid."' and newinf = 1)) limit 1",$rs);
	if(!$rr){
		die("Anyting_mypo select err".mysql_error());
		$jsongab = '{"newmess":"err"}';
	}else{
		$jsongab = '{"newmess":"err"}';
       	$row=mysql_fetch_array($rr);
		
		//새로운 메세지가 있는 경우
		if($row[recnum] > 0) $jsongab = '{"newmess":"ok"}';
	}


	mysql_close($rs);

	echo($jsongab);
?>