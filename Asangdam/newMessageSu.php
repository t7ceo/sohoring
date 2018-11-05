<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if(!$project) $project = "0";

	//나에게 온 새로운 Gcm 메세지 숫자를 구한다.
	$rr = mysql_query("select count(b.companyid) as comsu from AAmyGcm as a left join AAmyMess as b on(a.recnum = b.id)  where b.tomanid =  '".$memid."'  and a.newinf = 1   and  b.companyid in ( select companyid from Anyting_company where project = '".$project."')   ",$rs);
	if(!$rr){
		$jsongab = '{"ns":"e"}';
	}else{
       	$row=mysql_fetch_array($rr);
		$gcmsu = $row[comsu];
		
		//나에게 온 새로운 메세지 숫자를 구한다.
		$rr1 = mysql_query("select count(b.companyid) as comsu from AAmyPo as a left join AAmyMess as b on(a.messid = b.id)  where b.tomanid =  '".$memid."'  and a.newinf = 1 and  b.companyid in ( select companyid from Anyting_company where project = '".$project."')  ",$rs);
		if(!$rr1){
			$jsongab = '{"ns":"e"}';
		}else{
			$row1=mysql_fetch_array($rr1);
			$posu = $row1[comsu];

			//새로운 메세지가 있는 경우
			if(($gcmsu + $posu) > 0) $jsongab = '{"ns":'.($gcmsu + $posu).'}';
			else $jsongab = '{"ns":"None"}';
		}
	}


	mysql_close($rs);

	echo($jsongab);
?>