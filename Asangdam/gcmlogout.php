<?
include 'config.php';
include 'util.php';

	$jsongab = '{"companyid":"err"}';
	//데���� ��베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");

	$rr = mysql_query("update soho_Anyting_gcmid set login='no', bell = 1, endtime = '".$aday."' where gcmid = '".$regid."' limit 1",$rs);
	if(!$rr) die("gcm logout err".mysql_error());


	mysql_close($rs);
	$ss = "{'kk':'kim seong sig'}";

	echo $ss