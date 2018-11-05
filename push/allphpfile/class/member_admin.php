<?
/*======================================================================================================
⊙ 개발자		::	멤버 관련 테이블
⊙ 최초개발일	::	5월 27일
⊙ 수정일		::	
⊙ 사이트		::	http://mlrl2000.cafe24.com
⊙ 수정자		::	김성식
⊙ 수정일		::	2013년 5월 27일
======================================================================================================*/
//사용하는 테이블
//soho_Anyting_gcmid

class Member extends MySQL
{
	
	//project 값을 가져 온다..
	function getProject($project, $uiug, $myid){
		
		if(!$project){
			$proj = parent::get_result("soho_Anyting_gcmid", " udid = '".$uiug."' and memid = '".$myid."'   limit 1", "project");
		}else{
			$proj = $project;
		}
		
		return $proj;
	}

	
	
	//이메일 발송
	function sendEmail($email, $title, $message, $header){

		mail($email,$title,$message, $header);	
		//mail($email,iconv("UTF-8","EUC-KR",$title),$message, $header);
	
		return "ok";
	}
	
	
	//비밀번호를 초기화 한다.
	function passWdInit($myid, $email, $coname, $proj, $uiug, $allpath){
		$basPass = "MTIzNA==";   //1234;
	
		$ad_date = date("Y-m-d H:i:s");
		$zip_gab = substr(md5($ad_date),20,32);

		//비번 초기화를 위한 자료를 만든다.	
		$ss = "insert into AAmyPasschn (memid, passinf, indate)values('".$myid."','".$zip_gab."','".$ad_date."')";
		$rr = mysql_query($ss, $this->CONN);

		$rr1=mysql_query("select last_insert_id() as num",$this->CONN); //마지막으로 삽입된 글의 번호를 반환 한다.
		$row = mysql_fetch_array($rr1);




		//타이틀 부분==================================
		if(!$coname) $coname = "Member ";
		$title = $coname." 비밀번호 찾기";
		
		//메시지 부분==================================
		$message = $coname."의 회원 비밀번호를 분실 하셨나요?<br />";
		$message .= "<font color=green size=2><b>'개인 정보의 안전한 보호를 위해 아래 절차에 따라 초기화 하세요.'</b></font><br />";
		$message .= "아래 링크를 클릭하시면 1234로 비밀번호가 초기화 됩니다.<br />";
		$message .= "초기화 이 후에 꼭 로그인 하셔서 비밀번호 수정을 하여 주시기 바랍니다.<br />";
		
		//project 값을 구한다.
		$proj = $this->getProject($proj, $uiug, $myid);
		
		$linkgab = $allpath."mailinf.php?uiug=".$uiug."&frm=".$coname."&num=".$row[num]."&id=".$myid."&zip=".$zip_gab."&project=".$proj;
		$message .= "링크(클릭): <a href='".$linkgab."'><font color=red size=3>".$zip_gab."</font></a>"; 

		//헤드부분================================================
		$header = "Content-Type: text/html; charset=utf-8\n";
		$header .= "Return-Path: <t7ceo@naver.com>\n";
		$header .= "From: ".$coname." <t7ceo@naver.com> \n";
		$header .= "Reply-To: <t7ceo@naver.com>\n";
		$header .= "MIME-Version: 1.0\n";

		$rt = "no";
		//발송===================================================
		$rt = $this->sendEmail($email, $title, $message, $header);
		//=====================================================

		return $rt;
	}
	
	
	
	
	
	
	//아이디의 존재 여부를 확인한다.
	function find_memid($memid, $proj){
		$su = parent::get_count("Anyting_member", " memid = '".$memid."'  "); 
		
		//if($proj == "mu") $su = parent::get_count("Anyting_member", " memid = '".$memid."'  "); 
		//else $su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."'  "); 
		
		if($su > 0){
			$rt = true;
		}else{
			$rt = false;
		}
		
		return $rt;		
	}

	//아이디의 존재 여부를 확인한다.
	function find_memidAdd($memid, $proj){
		$su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."'   "); 
		
		//if($proj == "mu") $su = parent::get_count("Anyting_member", " memid = '".$memid."'  "); 
		//else $su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."'  "); 
		
		if($su > 0){
			$rt = true;
		}else{
			$rt = false;
		}
		
		return $rt;		
	}



	//비밀번호의 오류여부를 체크한다.
	//아이디는 일치한다는 전제하에 체크
	function find_pass($memid, $pass, $proj, $uiug){
		
		$su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and adpass = '".$pass."' and project = '".$proj."'  limit 1");
		if($su > 0){    //회원정보가 존재 한다.
			$rt = true;
		}else{
			$su = parent::get_count("Anyting_member", " memid = '".$memid."' and pass = '".$pass."'  limit 1");
			if($su > 0){   //기본 정보는 있다.
				//Anyting_memberAdd 정보를 추가 한다.
				parent::query("insert into Anyting_memberAdd (memid, adpass, project, mempo, udid)values('".$memid."', '".$pass."', '".$proj."', 1, '".$uiug."')");

				$rt = true;
			}else{
			
				$rt = false;			
			}

		}
		return $rt;		
	}

	//Anyting_memberAdd 회원의 이메일, 자격, uiu코드를 가져 온다.
	function getMemberInf($memid, $pass, $proj){
		
		//Anyting_memberAdd 테이블에서 중복 자료를 삭제 한다.
		//$su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."' and adpass = '".$pass."' ");

		
		$ss = "select memid, id, udid, mempo from Anyting_memberAdd where memid = '".$memid."' and adpass = '".$pass."'  and project = '".$proj."'  order by id desc"; 
		$rs = parent::query($ss);
		
		return $rs;
	}
	//Anyting_member 회원의 이메일, 자격, uiu코드를 가져 온다.
	function getMemberInfUnd($memid, $pass, $proj){
		$ss = "select id, uiu, meminf from Anyting_member where memid = '".$memid."' and pass = '".$pass."'  order by id desc limit 1"; 
		$rs = parent::query($ss);
		
		return $rs;
	}



	//회원아이디와 project 로 추가 정보의 존재 여부를 파악하고 있다면 가져 온다.
	function getMemberAddInf($memid, $proje){
		$ss = "select * from Anyting_memberAdd where memid = '".$memid."' and project = '".$proje."' limit 1"; 
		$rs = parent::query($ss);
		
		return $rs;
	}

	//중복된 회원정보를 삭제 한다.
	function dblMemIdDel($memid, $proje){
		//gcmid 테이블에서 중복 자료를 삭제 한다.
		$su = parent::get_count("soho_Anyting_gcmid", " memid = '".$memid."' and project = '".$proje."' ");
		if($su > 1){
			$rs = parent::query("select * from soho_Anyting_gcmid where memid = '".$memid."' and project = '".$proje."' order by endtime desc");
			$c = 0;
			while($row = mysql_fetch_array($rs)){
				if($c > 0){
					parent::bas_delete("soho_Anyting_gcmid", " id = ".$row[id]." limit 1");
				}
	
				$c++;
			}
		}
		
		//Anyting_memberAdd 테이블에서 중복 자료를 삭제 한다.
		$su = parent::get_count("Anyting_memberAdd", " memid = '".$memid."' and project = '".$proje."' ");
		if($su > 1){
			$rs = parent::query("select * from Anyting_memberAdd where memid = '".$memid."' and project = '".$proje."' order by indate desc");
			$c = 0;
			while($row = mysql_fetch_array($rs)){
				if($c > 0){
					parent::bas_delete("Anyting_memberAdd", " id = ".$row[id]." limit 1");
				}
	
				$c++;
			}
		}
	}



}
?>