<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");
	$sday = date("Y-m-d");
	
	$company_id = substr($memid,0,4).substr(md5($ad_date),0,6);

	$indongab = 1;


	if(!$project) $project = "none";

	$stargab = 0;  //무료 등록
	if($oninf == 1) $stargab = 1;   //유료등록


	//상담센터 입주
	$rr = mysql_query("insert into Anyting_company (companyid, project, jygab, gubun, masterid, sangho, coname, memo, tel, juso, url, indon, indate, star) values('".$company_id."', '".$project."', ".$mgubun.", ".$gubun.", '".$memid."', '".$sangho."', '".$coname."', '".$memo."', '".$tel."', '".$addr."', '".$url."', ".$indongab.", '".$ad_date."', ".$stargab.")",$rs);
	
	if(!$rr){
		die("newsMemo Update err".mysql_error());
		$ss = "err";
		$newsId = 0;	
	}else{
		//$rr=mysql_query("select last_insert_id() as num",$rs); //마지막으로 삽입된 글의 번호를 반환 한다.
		//$row = mysql_fetch_array($rr);
		
		//상담센터 테이블 수 설정
		//$rr1 = mysql_query("insert into Anyting_tablesu (companyid, tablesu, indate) values('".$company_id."', 5, '".$ad_date."')",$rs);
		//if(!$rr1) die("newsMemo Update err".mysql_error());

		//상담센터 GPS 설정
		$rr2 = mysql_query("insert into Anyting_comgps (companyid, latpo, longpo) values('".$company_id."', ".$latpo.", ".$longpo.")",$rs);
		if(!$rr2) die("newsGps Update err".mysql_error());

		//등록자 매니저 설정
		$rr3 = mysql_query("insert into Anyting_manager (memid, name, companyid, meminf, uiu, indate) values('".$memid."', 'none', '".$company_id."', 11, '0', '".$sday."')",$rs);
		if(!$rr2) die("newsGps Update err".mysql_error());
		

		
		$ss = "ok";
		
		
		//$newsId = $row[num];
	}









	mysql_close($rs);



echo('{"result":"'.$ss.'", "companyId":"'.$company_id.'"}');




?>