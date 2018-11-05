<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//나에게 새로운 메세지가 있는지 확인한다.
	$rr = mysql_query("select recnum, id, pauseok from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$rdTbnum." and newinf = 1 and pauseok < 3 limit 1",$rs);
	if(!$rr){
		die("Anyting_mypo select err".mysql_error());
		$jsongab = '{"newmess":"err"}';
	}else{
		$jsongab = '{"newmess":"err"}';
       	$row=mysql_fetch_array($rr);

		//새로운 메세지가 있는 경우
		if($row[recnum] > 0){
			$row[pauseok]++;   //pause 상태에서 세번 울리는 울림을 종료하게 만든다.
			$rr = mysql_query("update Anyting_mypo set pauseok = ".$row[pauseok]." where id = ".$row[id]." limit 1",$rs);


			//새로운 매시지를 돌려준다.
			$rr1 = mysql_query("select * from Anyting_message where id = ".$row[recnum]." limit 1",$rs);
			if(!$rr1){
				die("Anyting_message sget error".mysql_error());
				$jsongab = '{"newmess":"Message View Click."}';
			}else{
				$row1=mysql_fetch_array($rr1);
				$jsongab = '{"newmess":"'.$row1[message].'"}';
			}
		}
	}


	mysql_close($rs);

	echo($jsongab);
?>