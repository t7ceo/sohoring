<?
include 'config.php';
include 'util.php';

	//$jsongab = '{"companyid":"err"}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$mess = "kim seong sig";
	
	//$rgid = "APA91bHP2I fNzRECKQmgHa7S2nYMxtpIyZmxn7HZrxP8L1XlYo6ZC8c0AeU2SvarxajeIPaKWdakyEededMVJ1CV3YRPLFAnG0wxu4z_eNDfpnOfSbEi5nb5E-p689djkDGBPMB69jR5WrZ1xAXXj6E0SYVjEjPQ";

	sendMessageGCM($mess, "Master", "All", $rs, "deil");


	mysql_close($rs);
	//$ss = "{'kk':'kim seong sig'}";

	//echo $ss;
?>