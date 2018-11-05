<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();

	$ad_date = date("Y-m-d");

	$ss = '{"result":"err"}';
	

	$rr1 = mysql_query("select count(memid) as memsu from soho_Anyting_member where email = '".$_POST[mtel]."' and project = '".$project."'  limit 1",$rs);
	if(!$rr1) die("add Member Update select".mysql_error());
	
	$row = mysql_fetch_array($rr1);
	if($row[memsu] < 1){  //동일한 이메일의 회원이 없다.=========================
		
		
			$memid = substr($_POST[mtel],-4).substr(md5($ad_date),0,6);
			
		
			//회원가입 처리
			$rr = mysql_query("insert into soho_Anyting_member (memid, email, bday, tel, indate, uiu, project)values('$memid', '$_POST[mtel]', '$_POST[bday]', '$_POST[mtel]', '$ad_date', '$_POST[uiu]', '$project')",$rs);
			if(!$rr) die("add Member Update err".mysql_error());
			
			//추가 정보 기초자료 등록
			//$rr1 = mysql_query("insert into soho_Anyting_memberAdd (memid, name, adpass, project, udid, susin)values('$memid', '$nam', '$pass', '$project', '$uiu', '$susin')",$rs);
			//if(!$rr1) die("soho_Anyting_memberAdd Update err".mysql_error());
		
			$ss = '{"result":"ok"}';		
		
		
	}else{   //아이디가 중복 된다.===============================
	
		//
	
	
	
		$ss = '{"result":"two"}';		
	}
	
	$mycon->sql_close();
	
		
	echo($ss);
?>