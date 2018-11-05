<?
include 'config.php';
include 'util.php';

	//선택한 가맹점의 테이블수, 가맹점 정보, 가맹점 이미지, 가맹점의 gps값을 가져 온다.
	//선택한 가맹점의 테이블 수를 가져 온다.
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

/*
	$tbsu = 0;
	$rr0 = mysql_query("select * from Anyting_tablesu where companyid = '".$comid."' order by id desc limit 1",$rs);
	if(!$rr0){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
       	$row0=mysql_fetch_array($rr0);
		$tbsu = $row0[tablesu];
	}
*/


	//가맹점의 정보와 이미지를 가져 온다.
	$rr = mysql_query("select * from Anyting_company as a left join Anyting_comimg as b on(a.companyid = b.companyid) where a.companyid = '".$comid."' order by a.id desc limit 1",$rs);
	if(!$rr){
		die("Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '{"companyid":';
       	$row=mysql_fetch_array($rr);
		
		//가맹점의 Gps 값을 가져 온다.
		$aa = mysql_query("select latpo, longpo from Anyting_comgps where companyid = '".$comid."' limit 1", $rs);
		$row1 = mysql_fetch_array($aa);
		
		
		$jsongab .= '{"comid":"'.$row[companyid].'","masterid":"'.$row[masterid].'","comimg":"'.$row[imgname].'","memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "sangho":"'.$row[sangho].'", "coname":"'.$row[coname].'", "tablesu":0, "url":"'.$row[url].'", "latpo":'.$row1[latpo].', "longpo":'.$row1[longpo].' }}';

	}



	mysql_close($rs);

	echo($jsongab);
?>