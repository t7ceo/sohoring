<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

//업체리스트를 가져올 거리 설정을 한다.
	echo $_GET[mode];
	echo "/".$mode;

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
		
	
	switch($_GET[mode]){
	case "test":  //테스트 입니다.
	
		$keyg = "544B18D6CAAE357EB759AD34504B3A48";  
		//echo $keyg;
	 	$eng = encrypt ($keyg, "01090815738");
		echo $eng;
		//$eng = "ODAxZTc2NTY2YWNlMDE0YzFiMjY2ZmJjNWNiZThkNWY=";
		$eng = "ZTFlMzFiYzhlYmI5YzZiMWRiZWRjNjY2MDY1N2I2NmY=";
		
		$deng = decrypt ($keyg, $eng);
		echo "/".$deng."==okpp";
		
	 
	 
	break;
	case "okReading":   //새로운 글을 읽은 것으로 처리 한다.
	
		$fs2 = "select * from AAmyOnecut as a left join Anyting_company as b on(a.companyid = b.companyid) where a.id = ".$_GET[item]." and a.project = '".$_GET[proj]."'  limit 1";
		$hh = mysql_query($fs2,$rs);
		$row = mysql_fetch_array($hh);
		
		//기존에 읽기 처리내역이 있는지 확인 한다.
		$ff = "select * from Anyting_myViewInf where companyid = '".$row[companyid]."' and onecutid = ".$_GET[item]." and memid = '".$_GET[memid]."' and project = '".$_GET[proj]."' ";
		$ff1 = mysql_query($ff, $rs);
		if(mysql_num_rows($ff1) < 1){
			$cc = mysql_query("insert into Anyting_myViewInf (companyid, mgubun, gubun, onecutid, memid, project)values('".$row[companyid]."', ".$row[jygab].", ".$row[gubun].", ".$_GET[item].", '".$_GET[memid]."', '".$proj."')", $rs);		
		
		}
	
	break;
	case "sai":    //거리설정
		//거리 설정을 한다.
		$rr = mysql_query("update soho_Anyting_memberAdd set jibu = ".$_GET[sai]." where memid = '".$_GET[memid]."'  and project= '".$_GET[proj]."' limit 1 ",$rs);
		$jsongab = '{"rs":"ok"}';
	break;
	case "upg":    //업그레이드 사용 여부
		$rr = mysql_query("update soho_Anyting_gcmid set upinf = ".$_GET[gab]." where memid = '".$_GET[memid]."'  and project= '".$_GET[proj]."'  ",$rs);
		$jsongab = '{"rs":"ok"}';
	break;
	case "bell":    //푸시 알림 사용 여부
		$rr = mysql_query("update soho_Anyting_gcmid set bell = ".$_GET[gab]." where memid = '".$_GET[memid]."'  and project= '".$_GET[proj]."'  ",$rs);
		$jsongab = '{"rs":"ok"}';
	break;
	}
	

	
	$mycon->sql_close();

	echo $jsongab;

?>

