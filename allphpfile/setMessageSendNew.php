<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();



	$mess = change_str($mess);	
	
	$jsongab = '{"rs":"err"}';
	
	//새로운 메시지를 등록한다.
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);
	
	switch($_POST[mode]){
	case "onedtGud":    //이용 가이드 수정
	
		//메세지를 등록합니다.
		$aa = mysql_query("update soho_AAmyOnecut set memo = '".$mess."', title = '".$tit."', fromid = '".$from."' where id = ".$rvid." limit 1 ",$rs); 
		if($aa){
			$jsongab = '{"rs":"ok"}';
		}

		
	break;	
	case "oninputGud":   //이용 가이드 등록
		//메세지를 등록합니다.
		$aa = mysql_query("insert into soho_AAmyOnecut (companyid, title, memo, fromid, gubun, project, indate)values
					   ('".$comid."', '".$tit."', '".$mess."', '".$from."', 'gud', '".$proj."', '".$ad_date."')",$rs); 
			
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "onedtJh":    //제휴 문의 수정

		$aa = mysql_query("update soho_AAmyOnecut set memo = '".$mess."', title = '".$tit."', tel = '".$tel."', url = '".$url."' where id = ".$rvid." limit 1 ",$rs); 
		if($aa){
			$jsongab = '{"rs":"ok"}';
		}

	break;	
	case "oninputJh":   //제휴 문의 등록
		//메세지를 등록합니다.
		$aa = mysql_query("insert into soho_AAmyOnecut (companyid, title, memo, tel, url, fromid, gubun, project, indate)values
					   ('".$comid."', '".$tit."', '".$mess."', '".$tel."', '".$url."', '".$from."', 'jhy', '".$proj."', '".$ad_date."')",$rs); 
			
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "onedtFAQ":    //FAQ 수정ƒ
	
		$aa = mysql_query("update soho_AAmyOnecut set memo = '".$_POST[mess]."', title = '".$_POST[tit]."'  where id = ".$_POST[rvid]." limit 1 ",$rs); 
		if($aa){
			$jsongab = '{"rs":"ok"}';
		}

	
	break;
	case "oninputFAQ":   //FAQ 등록
	
		//메세지를 등록합니다.
		$aa = mysql_query("insert into soho_AAmyOnecut (companyid, title, memo, fromid, gubun, project, indate)values
					   ('".$_POST[comid]."', '".$_POST[tit]."', '".$_POST[mess]."', '".$_POST[from]."', 'faq', '".$_POST[proj]."', '".$ad_date."')",$rs); 
			
		$jsongab = '{"rs":"ok"}';
		
	break;
	case "onedtGj":   //공지 수정
	
		//메세지를 등록합니다.
		$aa = mysql_query("update soho_AAmyGongji set title = '".$tit."', title2 = '".$tit2."', gongji = '".$mess."' where id = ".$rvid." limit 1 ",$rs); 
		if($aa){
			
			if($psh == 1){  //푸시 발송 한다.
	
				//푸시 발송 한다.
				sendMessageGCM($tit2, "Master/".$rvid, "All", $rs, $proj);
			
			}

			
			$jsongab = '{"rs":"ok"}';
		}
	
	break;
	case "shoppingPush":   //쇼핑몰 정보를 푸시 발송한다.
	
		//상품 정보를 가져온다.
		$ss = "select * from soho_Anyting_company where id = ".$tit." limit 1"; 
		$ss2 = mysql_query($ss, $rs);
		$ttrow = mysql_fetch_array($ss2);
	
		$allMainMenu = array("","쇼핑몰", "금주의 행사", "이벤트 공지", "쿠폰", "신규/제휴매장", "장바구니", "마트소개");
		//$tit = rawurlencode($allMainMenu[$mess]);
		$titg = $gb;
	
		//메세지를 등록합니다.
		$aa = mysql_query("insert into soho_AAmyGongji (companyid, title, title2, gongji, fromid, project, indate, jiyeog, webrec)values
					   ('".$comid."', '".$titg."', '".$ttrow[sangho]."', '".$ttrow[memo]."', '".$from."', '".$project."', '".$ad_date."', ".$mess.", ".$tit.")",$rs); 
		
		$tit2 = $ttrow[sangho];
		
		

			//마지막으로 삽입된 글의 번호를 반환 한다.
			$rr=mysql_query("select last_insert_id() as num",$rs); 
			if(!$rr) die("soho_AAmyGongji last id err".mysql_error());
			$row = mysql_fetch_array($rr);
			
			//푸시 발송 한다.
			sendMessageGCM($tit2, "Master/".$row[num], "All", $rs, $proj);
		
			
		$jsongab = '{"rs":"ok"}';

	
	
	break;
	case "oninputGj":   //공지사항 등록
	
		//메세지를 등록합니다. allinf == 3  전에 공지사항이다. 
		$aa = mysql_query("insert into soho_AAmyGongji (companyid, title, title2, gongji, fromid, project, indate, allinf)values
					   ('".$comid."', '".$tit."', '".$tit2."', '".$mess."', '".$from."', '".$proj."', '".$ad_date."', 3)",$rs); 
			
		if($psh == 1){  //푸시 발송 한다.

			//마지막으로 삽입된 글의 번호를 반환 한다.
			$rr=mysql_query("select last_insert_id() as num",$rs); 
			if(!$rr) die("soho_AAmyGongji last id err".mysql_error());
			$row = mysql_fetch_array($rr);
			
			//푸시 발송 한다.
			sendMessageGCM($tit2, "Master/".$row[num], "All", $rs, $proj);
		
		}
			
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "oninput":   //리뷰 등록
	
		//메세지를 등록합니다.
		$aa = mysql_query("insert into soho_AAmyMess (companyid, message, fromid, project, star, indate)values
					   ('".$comid."', '".$mess."', '".$from."', '".$proj."', ".$star.", '".$ad_date."')",$rs); 
		if($aa){
			$jsongab = '{"rs":"ok"}';
		}
	
	break;
	case "onedt":    //리뷰 수정 모드
	
		//메세지를 등록합니다.
		$aa = mysql_query("update soho_AAmyMess set message = '".$mess."', star = ".$star." where id = ".$rvid." limit 1 ",$rs); 
		if($aa){
			$jsongab = '{"rs":"ok"}';
		}
	
	break;
	}
	
	
	
	
	
	echo($jsongab);		


	$mycon->sql_close();

	
?>