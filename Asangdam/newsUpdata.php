<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");

	$company_id = substr($memid,0,4).substr(md5($ad_date),0,6);

	$indongab = $tbsu * 40000;


	//뉴스 기록
	$rr = mysql_query("insert into Anyting_company (companyid, masterid, sangho, memo, tel, juso, url, indon, indate) values('$company_id', '$memid', '$sangho', '$memo', '$tel', '$addr', '$url', $indongab, '$ad_date')",$rs);
	if(!$rr){
		die("newsMemo Update err".mysql_error());
		$ss = "err";
		$newsId = 0;	
	}else{
		//$rr=mysql_query("select last_insert_id() as num",$rs); //마지막으로 삽입된 글의 번호를 반환 한다.
		//$row = mysql_fetch_array($rr);

		$rr1 = mysql_query("insert into Anyting_tablesu (companyid, tablesu, indate) values('$company_id', $tbsu, '$ad_date')",$rs);
		if(!$rr1) die("newsMemo Update err".mysql_error());


		$rr2 = mysql_query("insert into Anyting_comgps (companyid, latpo, longpo) values('$company_id', $latpo, $longpo)",$rs);
		if(!$rr2) die("newsGps Update err".mysql_error());

		
		$ss = "ok";
		
		
		//$newsId = $row[num];
	}









	mysql_close($rs);



echo('{"result":"'.$ss.'", "companyId":"'.$company_id.'"}');




?>