<?
include 'config.php';
include 'util.php';

	$jsongab = '{"companyid":"err","tonum":0}';
	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$mess = change_str($mess);	
		
	$ad_date = date("Y-m-d H:i:s");
	//$mess = rawurldecode($mess);
	
	if($toman == "No"){    //일반 모드(솔로탈출)
		$tonum = $to;
		//메세지를 등록합니다.
		$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, indate)values
					   ('".$comid."', ".$from.", ".$to.", '".$mess."', '".$tpass."', '".$ad_date."')",$rs); 
		if(!$aa) die("class Anyting_message err".mysql_error());
	
	}else{                 //상담센터 모드
		//등록자의 아이디는 $mstid 이다.
		if($mstid == $toman){    //고객이 마스터에게 보낸다.
			//마스터가 대화방에 있다.- 일반적으로 메시지 전송
			//마스터가 대화방에 없다.- 메시지의 테이블 번호에 5000을 더한다.
			
			//마스터의 존재 여부를 파악한다.
			$ss0 = mysql_query("select * from Anyting_master where companyid = '".$comid."' and tbnum = 0 limit 1 ",$rs);
			$rominf = mysql_fetch_array($ss0);
			if($rominf[roomInf] == 1){    //마스터가 있다.
				//메세지를 등록합니다.
				$tonum = $to;
				$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
							   ('".$comid."', ".$from.", ".$to.", '".$mess."', '".$tpass."', '".$toman."', '".$ad_date."')",$rs); 
				if(!$aa) die("class Anyting_message err".mysql_error());
			}else{                        //마스터가 없다.
				$fg = $from + 5000;
				$tg = $to + 5000;
				$tonum = $to;
				//메세지를 등록합니다.
				$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
							   ('".$comid."', ".$fg.", ".$tg.", '".$mess."', '".$tpass."', '".$toman."', '".$ad_date."')",$rs); 
				if(!$aa) die("class Anyting_message err".mysql_error());
			}
		
		}else{                   //마스터가 고객에게 보낸다.
			//고객의 아이디로 고객의 존재 여부를 파악한다.
			$ss0 = mysql_query("select tbnum, roomInf from Anyting_master where companyid = '".$comid."' and nickname = '".$toman."' limit 1 ",$rs);
			$rominf = mysql_fetch_array($ss0);
			
			if($rominf[roomInf] == 1){      //고객이 대화방에 있다.
				if($rominf[tbnum] == $to){	//고객이 처음방에 그대로 있다. - 일반적인 메시지 전송
					$tonum = $to;
					//메세지를 등록합니다.
					$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
								   ('".$comid."', ".$from.", ".$to.", '".$mess."', '".$tpass."', '".$toman."', '".$ad_date."')",$rs); 
					if(!$aa) die("class Anyting_message err".mysql_error());
				}else{                      //고객이 다른 방으로 갔다.     - 고객을 찾아서 처리 한다.
					$tonum = $rominf[tbnum];
					$fg = $from + 5000;
					$tg = $to + 5000;
					
					//이전에 다른 테이블에서 나눈 모든 대화는 지난 자료로 처리
					mysql_query("update into Anyting_message set fromnum = ".$fg.", tonum = ".$tg." where companyid = '".$comid."' and tonum = ".$to." ",$rs);
					
					//받는 사람의 테이블 번호를 바뀐 번호로 수정한다.
					$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
								   ('".$comid."', ".$from.", ".$rominf[tbnum].", '".$mess."', '".$tpass."', '".$toman."', '".$ad_date."')",$rs); 
					if(!$aa) die("class Anyting_message err".mysql_error());
				}
			}else{                        //고객이 대화방에 없다.
				$fg = $from + 5000;
				$tg = $to + 5000;
				$tonum = $to;     //고객이 대화방에 없다. 
				
				//이전에 다른 테이블에서 나눈 모든 대화는 지난 자료로 처리
				mysql_query("update into Anyting_message set fromnum = ".$fg.", tonum = ".$tg." where companyid = '".$comid."' and tonum = ".$to." ",$rs);
				
				//메세지를 등록합니다.
				$aa = mysql_query("insert into Anyting_message (companyid, fromnum, tonum, message, pass, toman, indate)values
							   ('".$comid."', ".$fg.", ".$tg.", '".$mess."', '".$tpass."', '".$toman."', '".$ad_date."')",$rs); 
				if(!$aa) die("class Anyting_message err".mysql_error());
			}
		
		}


		
	}

		
		//마지막으로 삽입된 글의 번호를 반환 한다.
		$rr=mysql_query("select last_insert_id() as num",$rs); 
		if(!$rr) die("class Anyting_last id err".mysql_error());
		$row = mysql_fetch_array($rr);




		$tst = "insert into Anyting_test (t1,db1,db2)values('".$toman."',".$to.",77)";
		$tst1 = mysql_query($tst);



	
	if($toman == "No" or $to > 0){  //일반(솔로탈출) 모드 또는 상담센터에서 매니저가 회원에게 보낸다.

		//새로운 메세지 있음을 표시
		$bb = mysql_query("insert into Anyting_mypo (companyid, tbnum, fromnum, recnum, newinf, tomemid, wrinf)values('".$comid."', ".$tonum.", ".$from.", ".$row[num].", 1, '".$toman."', ".$wrinf.")",$rs); 
		if(!$bb) die("class Anyting_mypo err".mysql_error());

	}else{               //회원이 매니저에게 보낸다.

		//해당 업체의 전체 메니저를 구한다.-메니저 수만큼 반복하면서 각 메니저의 고유 id 를 지정하여 메세지를 저장
		$rr1=mysql_query("select * from Anyting_manager where companyid = '".$comid."' and meminf = 1 ",$rs); 
		if(!$rr1) die("class Anyting_manager all err".mysql_error());
		$c = 0;
		while($row1 = mysql_fetch_array($rr1)){
			

			$ss = "insert into Anyting_mypo (companyid, tbnum, fromnum, recnum, newinf, managid, tomemid, wrinf)values('".$comid."', ".$tonum.", ".$from.", ".$row[num].", 1, ".$row1[id].", '".$toman."', ".$wrinf.")";
			//새로운 메세지 있음을 표시			
			$bb = mysql_query($ss, $rs); 
			if(!$bb) die("class Anyting_mypo err".mysql_error());

			
			
		
			//$tst = "insert into Anyting_test (t1,db1,db2,txt)values('".$toman."',".$tonum.", 107, '".$ss."')";
			//$tst1 = mysql_query($tst, $rs);


			
			$c++;
		}

	}
	
	
	

		$jsongab = '{"companyid":"ok", "tonum":'.$tonum.', "day":"'.$ad_date.'", "lr":'.$row[num].'}';



	mysql_close($rs);

	echo($jsongab);
?>