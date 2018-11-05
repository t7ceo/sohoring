<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();

	switch($_GET[mode]){
	case "mem":    //이메일 중복 확인
		//챠트기록 가져옴
		$su = 0;
		$rr = mysql_query("select count(memid) as su from soho_Anyting_member where email = '".$_GET[memid]."' and project = '".$project."' ",$rs);
		if(!$rr){
			die("soho_Anyting_member check err".mysql_error());
			$jsongab = '{"memsu":"err"}';
		}else{

			$row1 = mysql_fetch_array($rr);
			if($row1[su] == 0) $jsongab = '{"memsu":"go"}';
			else $jsongab = '{"memsu":"no"}';
		}
		

	break;
	case "nam":    //닉네임 중복 확인
		//챠트기록 가져옴
		$rr = mysql_query("select count(memid) as su from soho_Anyting_memberAdd where name = '".$_GET[nicnam]."' and project = '".$project."' ",$rs);
		if(!$rr){
			die("soho_Anyting_member check err".mysql_error());
			$jsongab = '{"memsu":"err"}';
		}else{
			$row=mysql_fetch_array($rr);
			if($row[su] == 0) $jsongab = '{"memsu":"go"}';
			else $jsongab = '{"memsu":"no"}';
		}
	
	break;
	}

	echo($jsongab);

	$mycon->sql_close();


?>