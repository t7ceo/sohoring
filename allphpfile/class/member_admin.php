<?
/*======================================================================================================
�� ������		::	��� ���� ���̺�
�� ���ʰ�����	::	5�� 27��
�� ������		::	
�� ����Ʈ		::	http://chimappram.com
�� ������		::	�輺��
�� ������		::	2013�� 5�� 27��
======================================================================================================*/
//����ϴ� ���̺�
//soho_Anyting_gcmid

class Member extends MySQL
{
	
	//project ���� ���� �´�..
	function getProject($project, $uiug, $myid){
		
		if(!$project){
			$proj = parent::get_result("soho_Anyting_gcmid", " udid = '".$uiug."' and memid = '".$myid."'   limit 1", "project");
		}else{
			$proj = $project;
		}
		
		return $proj;
	}

	
	
	//�̸��� �߼�
	function sendEmail($email, $title, $message, $header){

		mail($email,$title,$message, $header);	
		//mail($email,iconv("UTF-8","EUC-KR",$title),$message, $header);
	
		return "ok";
	}
	
	
	//��й�ȣ�� �ʱ�ȭ �Ѵ�.
	function passWdInit($myid, $email, $coname, $proj, $uiug, $allpath){
		$basPass = "MTIzNA==";   //1234;
	
		$ad_date = date("Y-m-d H:i:s");
		$zip_gab = substr(md5($ad_date),20,32);

		//��� �ʱ�ȭ�� ���� �ڷḦ �����.	
		$ss = "insert into AAmyPasschn (memid, passinf, indate)values('".$myid."','".$zip_gab."','".$ad_date."')";
		$rr = mysql_query($ss, $this->CONN);

		$rr1=mysql_query("select last_insert_id() as num",$this->CONN); //���������� ���Ե� ���� ��ȣ�� ��ȯ �Ѵ�.
		$row = mysql_fetch_array($rr1);




		//Ÿ��Ʋ �κ�==================================
		if(!$coname) $coname = "Member ";
		$title = $coname." ��й�ȣ ã��";
		
		//�޽��� �κ�==================================
		$message = $coname."�� ȸ�� ��й�ȣ�� �н� �ϼ̳���?<br />";
		$message .= "<font color=green size=2><b>'���� ������ ������ ��ȣ�� ���� �Ʒ� ������ ���� �ʱ�ȭ �ϼ���.'</b></font><br />";
		$message .= "�Ʒ� ��ũ�� Ŭ���Ͻø� 1234�� ��й�ȣ�� �ʱ�ȭ �˴ϴ�.<br />";
		$message .= "�ʱ�ȭ �� �Ŀ� �� �α��� �ϼż� ��й�ȣ ������ �Ͽ� �ֽñ� �ٶ��ϴ�.<br />";
		
		//project ���� ���Ѵ�.
		$proj = $this->getProject($proj, $uiug, $myid);
		
		$linkgab = $allpath."mailinf.php?uiug=".$uiug."&frm=".$coname."&num=".$row[num]."&id=".$myid."&zip=".$zip_gab."&project=".$proj;
		$message .= "��ũ(Ŭ��): <a href='".$linkgab."'><font color=red size=3>".$zip_gab."</font></a>"; 

		//���κ�================================================
		$header = "Content-Type: text/html; charset=utf-8\n";
		$header .= "Return-Path: <ldiweb@naver.com>\n";
		$header .= "From: ".$coname." <ldiweb@naver.com> \n";
		$header .= "Reply-To: <ldiweb@naver.com>\n";
		$header .= "MIME-Version: 1.0\n";

		$rt = "no";
		//�߼�===================================================
		$rt = $this->sendEmail($email, $title, $message, $header);
		//=====================================================

		return $rt;
	}
	
	
	
	
	
	
	//���̵��� ���� ���θ� Ȯ���Ѵ�.
	function find_memid($email, $proj){
		
		$ss = parent::query("select memid from soho_Anyting_member where email = '".$email."' and project = '".$proj."' limit 1 "); 
		if(mysql_num_rows($ss) > 0){
			$row = mysql_fetch_array($ss);
			$rt = $row[memid];
		}else{
			$rt = "no";
		}
		
		
		return $rt;		
	}

	//���̵��� ���� ���θ� Ȯ���Ѵ�.
	function find_memidAdd($memid, $proj){
		$su = parent::get_count("soho_Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."'   "); 
		
		//if($proj == "mu") $su = parent::get_count("soho_Anyting_member ", " memid = '".$memid."'  "); 
		//else $su = parent::get_count("soho_Anyting_memberAdd", " memid = '".$memid."' and project = '".$proj."'  "); 
		
		if($su > 0){
			$rt = true;
		}else{
			$rt = false;
		}
		
		return $rt;		
	}



	//��й�ȣ�� �������θ� üũ�Ѵ�.
	//���̵�� ��ġ�Ѵٴ� �����Ͽ� üũ
	function find_pass($memid, $pass, $proj, $uiug){
		
		$su = parent::get_count("soho_Anyting_memberAdd", " memid = '".$memid."' and adpass = '".$pass."' and project = '".$proj."'  limit 1");
		if($su > 0){    //ȸ�������� ���� �Ѵ�.
			$rt = true;
		}else{
			$rt = false;			
		}
		return $rt;		
	}

	//soho_Anyting_memberAdd ȸ���� �̸���, �ڰ�, uiu�ڵ带 ���� �´�.
	function getMemberInf($memid, $pass, $proj){
		$ss = "select count(memid) as su, id, udid, mempo from soho_Anyting_memberAdd where memid = '".$memid."' and adpass = '".$pass."'  and project = '".$proj."' order by id desc"; 
		$rs = parent::query($ss);
		
		return $rs;
	}
	//soho_Anyting_member ȸ���� �̸���, �ڰ�, uiu�ڵ带 ���� �´�.
	function getMemberInfUnd($memid, $pass, $proj){
		$ss = "select id, uiu, meminf from soho_Anyting_member where memid = '".$memid."' and pass = '".$pass."' and project = '".$proj."'  order by id desc limit 1"; 
		$rs = parent::query($ss);
		
		return $rs;
	}



	//ȸ�����̵�� project �� �߰� ������ ���� ���θ� �ľ��ϰ� �ִٸ� ���� �´�.
	function getMemberAddInf($memid, $proje){
		$ss = "select * from soho_Anyting_memberAdd where memid = '".$memid."' and project = '".$proje."' limit 1"; 
		$rs = parent::query($ss);
		
		return $rs;
	}

	//�ߺ��� ȸ�������� ���� �Ѵ�.
	function dblMemIdDel($memid, $proje){
		//gcmid ���̺��� �ߺ� �ڷḦ ���� �Ѵ�.
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
		
		//soho_Anyting_memberAdd ���̺��� �ߺ� �ڷḦ ���� �Ѵ�.
		$su = parent::get_count("soho_Anyting_memberAdd", " memid = '".$memid."' and project = '".$proje."' ");
		if($su > 1){
			$rs = parent::query("select * from soho_Anyting_memberAdd where memid = '".$memid."' and project = '".$proje."' order by indate desc");
			$c = 0;
			while($row = mysql_fetch_array($rs)){
				if($c > 0){
					parent::bas_delete("soho_Anyting_memberAdd", " id = ".$row[id]." limit 1");
				}
	
				$c++;
			}
		}
	}



}
?>