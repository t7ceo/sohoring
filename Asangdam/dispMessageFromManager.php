<?
include 'config.php';
include 'util.php';

	$jsongab = '{"comdisp":[{"message":"err"}]}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//새로운 메세지를 읽어서 표시한다.
	$smff = "select id, recnum from Anyting_mypo where companyid = '".$comid."' and tbnum = ".$rdTbnum." and fromnum = 0 and newinf = 1 order by id";
	$smfff=mysql_query($smff,$rs);
	if(!$smfff)die("dispMessage err".mysql_error());
	
	$jsongab = '{"comdisp":[';
	$c = 0;
	while($row = mysql_fetch_array($smfff)){
		if($c > 0) $jsongab .= ",";
		
		$sm = "delete from Anyting_mypo where id = ".$row[id]." limit 1";
		$smf=mysql_query($sm,$rs);
		if(!$smf)die("Anyting_mypo 2 err".mysql_error());

		
		//새로운 메세지를 읽어서 표시한다.
		$ss = "select * from Anyting_message where id = ".$row[recnum]." limit 1";
		$aa=mysql_query($ss,$rs);
		if(!$aa)die("dispMessage2 err".mysql_error());
		$row1 = mysql_fetch_array($aa);
		
		$jsongab .= '{"id":'.$row1[id].',"fromnum":'.$row1[fromnum].', "message":"'.$row1[message].'", "day":"'.$row1[indate].'"}';
		$c++;
	}
	
	$jsongab .= ']}';

	mysql_close($rs);

	echo($jsongab);
?>