<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if(!$project) $project = "0";

	$jsongab = '{"ns":"e"}';
	//로그인한 회원에게 온 모든 메시지를 출력한다.
	if($chartin == "out"){
		$ss = "select b.companyid, b.message, b.fromid, b.indate, a.newinf from AAmyGcm as a left join AAmyMess as b on(a.recnum = b.id) where a.tomemid =  '".$memid."' and b.companyid in (select companyid from Anyting_company where project = '".$project."')  order by a.recnum desc ";
		
		$newinf = true;
	}else{
		
		$ss = "select a.companyid, a.message, a.fromid, a.indate from AAmyMess as a left join Anyting_company as b  on(a.companyid = b.companyid) where a.tomanid =  '".$memid."'  and b.project = '".$project."' and a.id in (select recnum from AAmyGcm where newinf = 1 union select messid from AAmyPo where newinf = 1) order by a.indate desc ";
		$newinf = false;

/*
		$ss = "select * from ( select b.companyid, b.message, b.fromid, b.indate, a.newinf from AAmyGcm as a left join AAmyMess as b on(a.recnum = b.id) where a.tomemid =  '".$memid."' and a.newinf = 1  Union  select d.companyid, d.message, d.fromid, d.indate, c.newinf from AAmyPo as c left join AAmyMess as d on(c.messid = d.id) where c.tomemid =  '".$memid."' and c.newinf = 1) order by indate desc  ";
*/
	}
	
	$rr = mysql_query($ss,$rs);
	
	if(!$rr){
		die("Anyting_myNewMessage err".mysql_error());
	}else{
       	$c = 0;
		$comid = "";
		$shgab = "";
		$jsongab = '{"ns":[';
		while($row=mysql_fetch_array($rr)){
			if($c > 0) $jsongab .= ',';
			
			if($comid != $row[companyid]){    //업체가 바뀔때 마다 새로운 상호를 불러 온다.
				$rr1 = mysql_query("select sangho from Anyting_company where companyid =  '".$row[companyid]."' limit 1 ",$rs);
				$shrow = mysql_fetch_array($rr1);
				$shgab = $shrow[sangho];
				
				$comid = $row[companyid];
			}
			
			if($newinf) $nw = $row[newinf];
			else $nw = 1;
				//$aa .= $row[indate]."/".$comid."/".$shgab."/".$row[message];
			
			$jsongab .= '{"cd":"'.$comid.'", "sh":"'.$shgab.'", "me":"'.$row[message].'", "fm":"'.$row[fromid].'", "nw":'.$nw.', "dy":"'.$row[indate].'"}'; 
			$c++;
		}
		$jsongab .= ']}';
		
	}
	mysql_close($rs);

	echo($jsongab);
?>