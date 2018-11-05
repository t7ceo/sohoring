<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	$ad_date = date("Y-m-d H:i:s");


	switch($_POST[mode]){
	case "appGogo":  //앱을 재작동 한다.
		$kk = $mycon->query("update soho_AAmyAppinf set endmess = '작동중', endinf = 0 where id = 1 limit 1  ");
		$jsongab = '{"rs":"ok"}';
	break;
	case "appQuit":   //앱을 강제 종료 한다.
		$kk = $mycon->query("update soho_AAmyAppinf set endmess = '".$_POST[mess]."', endinf = 1 where id = 1 limit 1  ");
		$jsongab = '{"rs":"ok"}';	
	break;
	case "musicUrl":   //소호링 링크를 저장한다.
	
		$ss = "select * from soho_AllMusic where pid = '".$_POST[pid]."'  ";
		$ss2 = mysql_query($ss, $rs);
		if(mysql_num_rows($ss2) > 0){
			$kk = $mycon->query("update soho_AllMusic set url = '".$_POST[url]."', tit = '".$_POST[tit]."' where pid = '".$_POST[pid]."'  ");
		}else{
			$kk = $mycon->query("insert into soho_AllMusic (tit, mname, gubun, sub, memid, pid, url)values('".$_POST[tit]."', 'mmm', 99, 99, 'admin', '".$_POST[pid]."', '".$_POST[url]."')");
		}
	
		$jsongab = '{"rs":"ok"}';
	break;
	case "editReSet":   //관리자 페이지에 주문내용을 변경 한다.
		//var param = "mode=editReSet&pid="+pid+"&tel="+tel+"&sub2="+sub2+"&gab="+gab;
	
		//구분값과 전화번호가 같은 경우 수정 모드 아니면 등록모드
		$uu = $mycon->query("select id from soho_AllJumun where tel = '".$_POST[tel]."' and pid = '".$_POST[pid]."' limit 1 ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			
			switch($_POST[sub2]){
			case 1:  //기본링
				$stGab = "";
				$edGab = "";
				$spGab = "";
			break;
			case 2:  //시간대별
			
				$oo = explode("/",$_POST[gab]);
			
				$stGab = $oo[0];
				$edGab = $oo[1];
				$spGab = "";
				
			break;
			case 3:  //요일별 
				$stGab = "";
				$edGab = "";
				$spGab = $_POST[gab];
				
			
			break;
			case 4:  //특정일
				$stGab = "";
				$edGab = "";
				$spGab = $_POST[gab];
				
			break;
			}
			
			$ii = $mycon->query("update soho_AllJumun set sub2 = ".$_POST[sub2].", stGab = '".$stGab."', edGab = '".$edGab."', spGab = '".$spGab."' where id = ".$row[id]." limit 1");
			$jsongab = '{"rs":"ok"}';
		}else{
			$jsongab = '{"rs":"no"}';
		}

	break;
	case "saveJumun11":   //주문 내용을 확인한다.
		//jumun.gubun:메인메뉴, jumun.sub :음식/쇼핑,의료/서비스 등...,  upjBg.timeinf : 서버메뉴(시간대,요일,특정일),80자,100자,100자 이
		
		//구분값과 전화번호가 같은 경우 재설정 여부를 회원에게 물어 보고 회원이 원하면 case "saveJumun2" 에서 재설정 한다.
		$uu = $mycon->query("select id from soho_AllJumun where gubun = ".$_POST[md]." and sub2 = ".$_POST[sub2]." and tel = '".$_POST[mtel]."' ");
		$row = mysql_fetch_array($uu);
		if($row[id] > 0){
			$ii = $mycon->query("update soho_AllJumun set tone = ".$_POST[tone].", sub = ".$_POST[sub].", sub2 = ".$_POST[sub2].", stGab = '".$_POST[stGab]."', edGab = '".$_POST[edGab]."', spGab = '".$_POST[spGab]."', bgid = ".$_POST[bgid].", voiceid = ".$_POST[voiceid].", sex = '".$_POST[sex]."', txtsu = ".$_POST[tsu].", mess = '".$_POST[mess]."', chnday = ".mktime().", onday = ".mktime()." where id = ".$row[id]." limit 1");
			$jsongab = '{"rs":"ok", "lid":'.$row[id].'}';
		}else{
			$ii = $mycon->query("insert into soho_AllJumun (gubun, tone, memid, sub, sub2, stGab, edGab, spGab, tel, bgid, voiceid, sex, txtsu, mess, onday, pid, stinf)values(".$_POST[md].", ".$_POST[tone].", '".$_POST[mtel]."', ".$_POST[sub].", ".$_POST[sub2].", '".$_POST[stGab]."', '".$_POST[edGab]."', '".$_POST[spGab]."', '".$_POST[mtel]."', ".$_POST[bgid].", ".$_POST[voiceid].", '".$_POST[sex]."', ".$_POST[tsu].", '".$_POST[mess]."', ".mktime().", ".$_POST[pid].", 1)");
			
			
			//마지막으로 삽입된 글의 번호를 반환 한다.
			$rr=mysql_query("select last_insert_id() as num",$rs); 
			if(!$rr) die("soho_AllJumun last id err".mysql_error());
			$rowL = mysql_fetch_array($rr);
			
			$jsongab = '{"rs":"ok", "lid":'.$rowL[num].'}';
			
		}
		
	
	break;	
	case "saveJumun12":   //주문 내용을 재설정 한다.
	
		//구분값과 전화번호가 같은 경우 수정 모드 아니면 등록모드
		$uu = $mycon->query("select id from soho_AllJumun where gubun = ".$_POST[md]." and sub2 = ".$_POST[sub2]." and tel = '".$_POST[mtel]."' ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			$ii = $mycon->query("update soho_AllJumun set tone = ".$_POST[tone].", sub = ".$_POST[sub].", sub2 = ".$_POST[sub2].", stGab = '".$_POST[stGab]."', edGab = '".$_POST[edGab]."', spGab = '".$_POST[spGab]."', bgid = ".$_POST[bgid].", voiceid = ".$_POST[voiceid].", sex = '".$_POST[sex]."', txtsu = ".$_POST[tsu].", mess = '".$_POST[mess]."', chnday = ".mktime()." pid = '".$_POST[pid]."' where id = ".$row[id]." limit 1");
			$jsongab = '{"rs":"two"}';
		}else{
			$jsongab = '{"rs":"not"}';
		}
	
	break;
	case "saveJumun":   //기본링에서 주문 내용을 저장하는 코드 인데 필요 없다..
	
		//구분값과 전화번호가 같은 경우 수정 모드 아니면 등록모드
		$uu = $mycon->query("select id from soho_AllJumun where gubun = ".$_POST[md]." and tel = '".$_POST[mtel]."' ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			$ii = $mycon->query("update soho_AllJumun set tone = ".$_POST[tone].", sub = ".$_POST[sub].", sub2 = ".$_POST[sub2].", stGab = '".$_POST[stGab]."', edGab = '".$_POST[edGab]."', spGab = '".$_POST[spGab]."', bgid = ".$_POST[bgid].", voiceid = ".$_POST[voiceid].", sex = '".$_POST[sex]."', txtsu = ".$_POST[tsu].", mess = '".$_POST[mess]."', chnday = ".mktime()." where id = ".$row[id]." limit 1");
			$jsongab = '{"rs":"ok"}';
		}else{
			$ii = $mycon->query("insert into soho_AllJumun (gubun, tone, memid, sub, sub2, stGab, edGab, spGab, tel, bgid, voiceid, sex, txtsu, mess, onday)values(".$_POST[md].", ".$_POST[tone].", '".$_POST[mtel]."', ".$_POST[sub].", ".$_POST[sub2].", '".$_POST[stGab]."', '".$_POST[edGab]."', '".$_POST[spGab]."', '".$_POST[mtel]."', ".$_POST[bgid].", ".$_POST[voiceid].", '".$_POST[sex]."', ".$_POST[tsu].", '".$_POST[mess]."', ".mktime().")");
			$jsongab = '{"rs":"ok"}';
			
		}
	
	break;	
	case "saveJumun2":   //기본링에서 호출 하는 것이므로 필요 없다. 주문 내용을 재설정 한다.
	
		//구분값과 전화번호가 같은 경우 수정 모드 아니면 등록모드
		$uu = $mycon->query("select id from soho_AllJumun where gubun = ".$_POST[md]." and tel = '".$_POST[mtel]."' ");
		if(mysql_num_rows($uu) > 0){
			$row = mysql_fetch_array($uu);
			$ii = $mycon->query("update soho_AllJumun set tone = ".$_POST[tone].", sub = ".$_POST[sub].", sub2 = ".$_POST[sub2].", stGab = '".$_POST[stGab]."', edGab = '".$_POST[edGab]."', spGab = '".$_POST[spGab]."', bgid = ".$_POST[bgid].", voiceid = ".$_POST[voiceid].", sex = '".$_POST[sex]."', txtsu = ".$_POST[tsu].", mess = '".$_POST[mess]."', chnday = ".mktime()." where id = ".$row[id]." limit 1");
			$jsongab = '{"rs":"two"}';
		}else{
			$jsongab = '{"rs":"not"}';
		}
	
	break;	
	case "InquiryMember":
		
		
	
	
	break;
	case "saveRecFil":   //파일을 저정한다.
		
	
	
	
	break;
	case "delRecFil":   //녹음 파일을 삭제 한다.
		
		$kk = mysql_query("select * from soho_AllMusic where id  = ".$_POST[rid]." limit 1", $rs);
		$row = mysql_fetch_array($kk);
		if($row[fileInf] == 1){
			//파일을 삭제 한다.
			$del_img = "../Asangdam/onecut/".$row[tit];
			//파일을 삭제 한다.
			unlink($del_img);
		}

		//테이블을 삭제한다.
		$kk = $mycon->bas_delete("soho_AllMusic"," id = ".$_POST[rid]." limit 1");

		
		$jsongab = '{"rs":"ok"}';
	break;
	case "recVoice":  //음성녹음
		
		//$img_id = substr(md5($ad_date),0,10);
		
		//주문 내역이 없다 추가 모드
		//실제 파일이 등록된 것이 아니므로 파일 fileInf 값을 0으로 설정  
		$ii = $mycon->query("insert into soho_AllMusic (tit, mname, gubun, memid, fileInf, onday)values('".$_POST[fnam]."', '".$_POST[voice]."', 13, '".$_POST[memid]."', 0, ".mktime().")");
		
		
			$kk = mysql_query("select * from soho_AllMusic where memid  = '".$_POST[memid]."' and gubun = 13 order by id desc  ", $rs);
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($kk)){
				if($i > 0) $jsongab .= ",";
				
				//녹음 파일의 등록 여부를 확인 한다.
				 //if(file_exists("../Asangdam/onecut/".$row[tit])) $dirg = "y";
				 //else $dirg = "n";
				
				$dirg = "aa";
				
				
				
				
				$mday = date("Y-m-d H:i:s", $row[onday]);
				
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[tit].'", "msic":"'.$row[mname].'", "day":"'.$mday.'", "finf":'.$row[fileInf].', "dirg":"'.$dirg.'"}';
						
				$i++;
			
			}
			$jsongab .= ']}';

	break;
	}

	echo($jsongab);

	$mycon->sql_close();


?>