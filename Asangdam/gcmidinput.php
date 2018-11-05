<?
include 'config.php';
include 'util.php';

	//$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//udid 값 설정 오류의 경우 삭제 한다.
	$aa = mysql_query("delete from soho_Anyting_gcmid where gcmid = '".$regid."' and (udid = '' or udid = 'udid error') ",$rs);
	
		//$aa = mysql_query("insert into Anyting_test (t1, t2)values('project', 'udid' )",$rs); 
		//if(!$aa) die("gcmid err".mysql_error());
	if(!$project) $project = "0";
	

	$bb = mysql_query("select count(gcmid) as aa from soho_Anyting_gcmid where gcmid = '".$regid."' and udid = '".$udid."'   ",$rs);
	$row = mysql_fetch_array($bb);
	if($row[aa] > 0){      //기존에 저장된 정보가 있다.
		$rr = mysql_query("update soho_Anyting_gcmid set login='okO', project='".$project."' where gcmid = '".$regid."' limit 1",$rs);
		if(!$rr) die("edit gcmid err".mysql_error());
	}else{
		$gcmid = "okN";
		if(!$udid) $udid = "udid None";
		$aa = mysql_query("insert into soho_Anyting_gcmid (udid, gcmid, project, login)values('".$udid."', '".$regid."', '".$project."','".$gcmid."' )",$rs); 
		if(!$aa) die("gcmid err".mysql_error());
	}

	

	mysql_close($rs);
	//$ss = "{'kk':'kim seong sig'}";

	//echo $ss;
?>