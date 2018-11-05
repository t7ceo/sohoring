<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");

	if(!$project) $project = "none";

	//가맹점 수정
	$rr = mysql_query("update Anyting_company set sangho = '$sangho', coname = '$coname', project = '$project', memo = '$memo', tel = '$tel', gubun = $gubun, juso = '$addr', url = '$url' where companyid = '$comid' limit 1",$rs);
	if(!$rr){
		die("newsMemo Edit err".mysql_error());
		$ss = "err";
	}else{
		$rr1 = mysql_query("select count(latpo) as su from Anyting_comgps where companyid = '$comid' ",$rs);
		if(!$rr1){
			die("newsGps Edit err".mysql_error());
			$ss = "err";	
		}else{
			$row = mysql_fetch_array($rr1);
			if($row[su] > 0){
				//수정모드
				//가맹점 위치 수정
				$rr2 = mysql_query("update Anyting_comgps set latpo= $latpo, longpo= $longpo where companyid = '$comid' limit 1",$rs);
				if(!$rr2){
					die("newsGps Edit err".mysql_error());
					$ss = "err";
				}else{
					$ss = "ok";
				}
			}else{
				//추가모드
				//가맹점 위치 추가
				$rr2 = mysql_query("insert into Anyting_comgps (companyid, latpo, longpo) values('$comid', $latpo, $longpo)",$rs);
				if(!$rr2){
					die("newsGps into err".mysql_error());
					$ss = "err";
				}else{
					$ss = "ok";
				}
			
			}
		
		}
	}



	mysql_close($rs);

	echo('{"result":"'.$ss.'"}');


?>