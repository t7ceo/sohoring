<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = y_connect($host,$dbid,$dbpass,$dbname);


//나에게온 새로운 메시지의 갯수를 구한다.


	$rr = mysql_query("select count(messid) as su from AAmyPo where companyid = '".$comid."' and  tomemid = '".$tomemid."' and  newinf = 1 order by id",$rs);
	if(!$rr){
		$kk = '{"rs":"err"}';
	}else{
       	$kk = '{"rs":"err"}';   
		$row=mysql_fetch_array($rr);
		if($row[su] > 0) $kk = '{"rs":"ok"}';   
	}


	mysql_close($rs);

	echo($kk);
?>