<?
include 'config.php';
include 'util.php';

	$kk = '{"rs":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//나에게온 새로운 메시지를 찾아서 출력한다.
	$rr = mysql_query("select id, messid, fromid from AAmyPo where companyid = '".$comid."' and  tomemid = '".$tomemid."' and  newinf = 1 and popinf = 0 order by id",$rs);
	if(!$rr){
		die("AAmyPo select err".mysql_error());
		$kk = '{"rs":"err"}';
	}else{
       	
		$c = 0;
		$kk = '{"rs":[';
		while($row=mysql_fetch_array($rr)){
			if($c > 0)  $kk .= ",";
			

			//새로운 메세지를 읽어서 표시한다.
			$ss = "select * from AAmyMess where id = ".$row[messid]." limit 1";
			$aa=mysql_query($ss,$rs);
			if(!$aa)die("dispMessage2 err".mysql_error());
			$row1 = mysql_fetch_array($aa);

			//메시지를 보낸 사람의 전화번호를 가져 온다.
			$ss2 = "select tel from soho_Anyting_member where memid = '".$tomemid."'  limit 1";
			$aa2 = mysql_query($ss2,$rs);
			if(!$aa2)die("dispMessage4 err".mysql_error());
			$row3 = mysql_fetch_array($aa2);



			//$recnum = $row[id];
			//새로운 메시지 알림은 삭제한다.
			//$sm = "delete from AAmyPo where id = ".$recnum."  limit 1";
			//$smf=mysql_query($sm,$rs);
			
			
			$kk .= '{"frmid":"'.$row1[fromid].'", "ftel":"'.$row3[tel].'", "toman":"'.$row1[tomanid].'", "message":"'.$row1[message].'", "mypoid":'.$row[id].', "day":"'.$row1[indate].'" }';

			
			
			$c++;
		}
		$kk .= ']}';
	
	}

	mysql_close($rs);
	

	echo($kk);
?>