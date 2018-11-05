<?
include 'config.php';
include 'util.php';

	//$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	if(!$project) $project = 0;
	$rr = mysql_query("update soho_Anyting_gcmid set memid='".$memid."' where udid = '".$uiug."' and project = '".$project."'  ",$rs);

	//잘못된 레코드 모두 삭제 하기 위해 잘된 것에서 gcmid 를 가져 온다.
	$ss = "select gcmid, count(memid) as su from soho_Anyting_gcmid where memid = '".$memid."' and udid = '".$uiug."' and  project = '".$project."'  ";
	$kk = mysql_query($ss, $rs);
	$row = mysql_fetch_array($kk);
	
	//위에서 정상적인 gcm 레코드가 있는 경우 나머지 비정 상적인 것은 삭제 한다.
	if($row[su] > 0) mysql_query("delete from soho_Anyting_gcmid where gcmid = '".$row[gcmid]."' and (memid = '0' or udid = '') and  project = '".$project."' ",$rs);


	mysql_close($rs);
	//$ss = "{'kk':'kim seong sig'}";

	//echo $ss;
?>