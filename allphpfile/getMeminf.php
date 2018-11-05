<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();

	//"tbnum="+tbn+"&pass="+gab+"&comId="+comIdgab

	$ad_date = date("Y-m-d H:i:s");

	$jsongab = '{"companyid":0}';
	
	switch($_GET[mode]){
	case "escMem":   //회원 탈퇴 처리를 한다.
		//
	
	
	break;
	case "onpsna":   //수정 내용을 설정 한다.
	
		$aa = $mycon->query("update soho_Anyting_memberAdd set perimg = '".$_GET[img]."' where project = '".$_GET[proj]."' and memid = '".$_GET[memid]."'  limit 1 ");
	
		$jsongab = '{"companyid":"ok"}';
	
	break;
	case "info":    //회원의 정보를 출력
	
		//회원의 마스터 여부를 출력한다.===================================================
		$rr0 = mysql_query("select count(companyid) as su, companyid, masterid from soho_Anyting_company where masterid = '".$_GET[memid]."' and project = '".$_GET[proj]."' limit 1",$rs);
		if(!$rr0){
			die("soho_Anyting_company err".mysql_error());
		}else{
			$row0 = mysql_fetch_array($rr0);
			if($row0[su] > 0){
				$comid = $row0[companyid];
				$mastid = $row0[masterid];
			}else{
				$comid = "no";
				$mastid = "no";
			}
		}//==================================================================================
		
		
		
		
		$vv7 = mysql_query("select id from soho_Anyting_gcmid where udid = '".$_GET[udid]."'  and project= '".$_GET[proj]."' ",$rs);
		if(mysql_num_rows($vv7) > 0){     
			//gcmid 에 회원 아이디를 설정 한다.
			$rr = mysql_query("update soho_Anyting_gcmid set memid = '".$_GET[memid]."' where udid = '".$_GET[udid]."'  and project= '".$_GET[proj]."'  ",$rs);
			//다른 회원 정보를 삭제한다.
			//$dd = $mycon->bas_delete("soho_Anyting_gcmid"," (memid = '".$_GET[memid]."' and project= '".$_GET[proj]."') and udid != '".$_GET[udid]."' ");
		}
		

		//푸시 알리 설정 상태를 가져 온다.
		//회원 정보가 등록않된 경우 회원 정보를 등록 한다.
		$vv2 = mysql_query("select bell, upinf from soho_Anyting_gcmid where memid = '".$_GET[memid]."' and project = '".$_GET[proj]."' limit 1",$rs);
		if(mysql_num_rows($vv2) < 1){
			$rr1 = mysql_query("insert into soho_Anyting_gcmid (memid, udid, gcmid, project, endtime, login, ver_num) values('$_GET[memid]', 'web', 'web', '".$_GET[proj]."', '$ad_date', 'wok', 'ok')",$rs);
			if(!$rr1) die("soho_Anyting_gcmid err".mysql_error());
			$belg = 1;
			$upinfg = 1;
		}else{
			if($udid){
				$oo = mysql_query("update soho_Anyting_gcmid set memid = '".$_GET[memid]."' where udid = '".$_GET[udid]."'  and project= '".$_GET[proj]."'  ",$rs);
			}
			
			
			$vrow = mysql_fetch_array($vv2);
			$belg = $vrow[bell];
			$upinfg = $vrow[upinf];
		}


		
		//앱의 버젼을 확인하고 변경 한다.
		$vv = mysql_query("select ver_num from soho_Anyting_appinf where id = 1 and project = '".$_GET[proj]."' limit 1",$rs);
		$vrow = mysql_fetch_array($vv);
		if($_GET[ver] >= $vrow[ver_num]){   //최신 버젼
			//gcmid 에 회원 아이디를 설정 한다.
			$rr = mysql_query("update soho_Anyting_appinf set ver_num = ".$_GET[ver]." where id = 1 and project = '".$_GET[proj]."' limit 1 ",$rs);
			//gcmid 에 회원 아이디를 설정 한다.
			$rr = mysql_query("update soho_Anyting_gcmid set ver_num = 'ok' where memid = '".$_GET[memid]."'  and project= '".$_GET[proj]."'  ",$rs);
			$upg = "no";    //업그레이드 필요 없다.
		}else{    //업그레이드가 필요하다.
			//업그레드 필요한 것으로 설정
			$rr = mysql_query("update soho_Anyting_gcmid set ver_num = 'no' where memid = '".$_GET[memid]."'  and project= '".$_GET[proj]."'  ",$rs);
			$upg = "ok";    //업그레이드 필요 하다.
		}
		
		
		
		//회원의 자격값을 출력한다.
		$rr0 = mysql_query("select mempo, perimg, name, jibu from soho_Anyting_memberAdd where memid = '".$_GET[memid]."' and project = '".$_GET[proj]."' limit 1",$rs);
		if(!$rr0){
			die("soho_Anyting_masterAdd err".mysql_error());
			$jsongab = '{"companyid":0}';
		}else{
			
			$su = mysql_num_rows($rr0);
			if($su > 0){
				$row = mysql_fetch_array($rr0);
				if($row[name] == "0") $row[name] = "...";
				$mp = $row[mempo];
				$pimg = $row[perimg];
				$nam = $row[name];
			}else{
				if($row[name] == "0") $row[name] = "...";
				$mp = 0;
				$pimg = "noperimg.jpg";
				$nam = "no";
			}
			
			$jsongab = '{"companyid":'.$mp.', "pimg":"'.$pimg.'", "nam":"'.$nam.'", "comid":"'.$comid.'", "mstid":"'.$mastid.'", "sai":'.$row[jibu].', "upg":"'.$upg.'", "bell":'.$belg.', "upi":'.$upinfg.'}';
		}
	
	break;
	case "psna":   //퍼스나콘 출력

		$psna = array("psna2.png","psna3.png","psna4.png","psna5.png","psna6.png");
	
		//나의 퍼스나콘을 가져 온다.
		$rr0 = mysql_query("select coname from soho_Anyting_memberAdd where memid = '".$_GET[memid]."' and project = '".$_GET[proj]."' limit 1",$rs);
		$row = mysql_fetch_array($rr0);
	
		$jsongab = '{"companyid":['; 
	
		for($c=0; $c < count($psna); $c++){
			if($c > 0) $jsongab .= ",";
			
			$jsongab .= '{"pnam":"'.$psna[$c].'"}';
		}

		$myimg = $row[coname];
		if($row[coname] == "0" or $row[coname] == "") $myimg = "noperimg.jpg";
		

		$jsongab .= '], "mpnam":"'.$myimg.'"}'; 
	
	break;
	}

	$mycon->sql_close();

	echo($jsongab);
?>