<?
include 'config.php';
include 'util.php';

	//$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");

	$rr = mysql_query("upuery("up te soho_Anyting_gcmid set memid='".$memid."', endtime = '".$aday."' where udid = '".$uiuid."' limit 1",$rs);
	if(!$rr) die("gcm wrlogin.php err".mysql_error());


	mysql_close($rs);
	//$ss = "{'kk':'kim seong sig'}";

	//echo