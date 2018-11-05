<?
include 'config.php';
include 'util.php';

	$jsongab = '{"receivedisp":[{"message":"err"}]}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//$today = date("Y-m-d");

	//처음 메니저에게 온 전체 메세지를 출력한다.
	$smff = "select * from Anyting_message where companyid = '".$comid."' and tonum = 0 order by id desc";
	$smfff=mysql_query($smff,$rs);
	if(!$smfff)die("receiveMessage err".mysql_error());
	
	$jsongab = '{"receivedisp":[';
	$c = 0;
	while($row = mysql_fetch_array($smfff)){
		if($c > 0) $jsongab .= ",";
		$jsongab .= '{"id":'.$row[id].',"fromnum":'.$row[fromnum].', "message":"'.$row[message].'", "day":"'.$row[indate].'"}';

		$c++;
	}
	$jsongab .= ']}';


		//전체 메세지를 출력하고 새메세지 표시는 지운다.
		$sm = "delete from Anyting_mypo where companyid = '".$comid."' and tbnum = 0 and managid = ".$managerId." ";
		$smf=mysql_query($sm, $rs);
		if(!$smf)die("Anyting_mypo del err".mysql_error());



	mysql_close($rs);

	echo($jsongab);
?>