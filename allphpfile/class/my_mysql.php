<?
/*======================================================================================================
�� ������		::	
�� ���ʰ�����	::	5�� 27��
�� ������		::	
�� ����Ʈ		::	http://chimappram.com
�� ������		::	�輺��
�� ������		::	2013�� 5�� 27��
======================================================================================================*/
//����ϴ� ���̺�
//soho_Anyting_gcmid

class MyMySQL extends MySQL
{
	
	
	//ȸ���� �̸��� ���� �´�.
	function getMemNicNam(){
		$rr = $this->query("select id from Anyting_Mycompany where companyid = '".$com."' and memid = '".$mem."' and project = '".$proj."'  ");
		if(mysql_num_rows($rr) < 1){
			$aa = $this->query("insert into Anyting_Mycompany (companyid, project, memid)values('".$com."', '".$proj."', '".$mem."')");
		}
		
		return "ok";	

	}
	
	//��� ã�� �߰� �Ѵ�.
	function AddMyLInk($com, $mem, $proj){
	
		$rr = $this->query("select id from Anyting_Mycompany where companyid = '".$com."' and memid = '".$mem."' and project = '".$proj."'  ");
		if(mysql_num_rows($rr) < 1){
			$aa = $this->query("insert into Anyting_Mycompany (companyid, project, memid)values('".$com."', '".$proj."', '".$mem."')");
		}
		
		return "ok";	
	}
	
	
	
	//��ü�� ������ ���� �´�.
	function comStar($cid){
	
		$rr = $this->query("select sum(star) as stargab, count(id) as num from AAmyMess where companyid = '".$cid."'  ");
		if(mysql_num_rows($rr) > 0){
			$row = mysql_fetch_array($rr);
			$allgab = $row[stargab];
			
			if($row[num] == 0){
				$rg[0] = 0;
				$rg[1] = 0;
			}else{
				$rg[0] = $allgab;
				$rg[1] = $row[num];
			}
			
			
			return $rg;
		
		}else{
				$rg[0] = 0;
				$rg[1] = 0;

			return $rg;
		
		}
		
	}
	
	
	
	//udid �� ���� ������ ��� ���� �Ѵ�.
	function errUdidRecDelete($inf){
		$ss = "delete from soho_Anyting_gcmid where (udid = '' or udid = null or udid = 'udid error') ";
		$this->query($ss);
		

	}

	//gcm id ���� �ش� �ϴ� ���ڵ带 ���� �Ѵ�.
	function delGcmIdRec($did){
		$ss = "delete from AAmyGcm where id = ".$did." limit 1";
		parent::query($ss);
	}

	//gcm �� mypo ���� ���ο� ���� ������ ���ÿ� ���ڵ� ���� �Ѵ�.
	function delMyPoGcmRec($did){
		$ss = "delete from AAmyGcm where recnum = ".$did." limit 1";
		parent::query($ss);
		
		$ss = "delete from AAmyPo where messid = ".$did." limit 1";
		parent::query($ss);
	}



	
	//���ο� �޽����� Ȯ���� ���� ���� ó�� �Ѵ�.
	function newmessDel($memid, $udid, $messcom){
		$rt = "ok";
		$smff = "delete from AAmyPo where companyid = '".$messcom."' and tomemid = '".$memid."'  ";  
		if(parent::query($smff)){
			$smff1 = "delete from AAmyGcm  where  (tomemid = '".$memid."' or tomemid = 'All')  and  companyid  = '".$messcom."' and  udid = '".$udid."' ";  		
			if(parent::query($smff1)){
				$rt = "ok";		
			}else{
				$rt = "err";
			}
		}else{
			$rt = "err";
		}
		return $rt;
	}
	
	
	//���� udid ���� ���� �´�.
	function getUdid($memid, $project){
		
		$udid = parent::get_result("soho_Anyting_memberAdd", "memid =  '".$memid."' and project = '".$project."'   limit 1 ", "udid");
		
		if(!$udid || $udid == "0"){
			$udid = parent::get_result("soho_Anyting_gcmid", "memid =  '".$memid."'  and project = '".$project."' limit 1 ", "uiu");
		}
		
		return $udid;
	}

	//project ���� ���� �´�..
	function getProject1($project, $uiug, $myid){
		
		if(!$project){
			$proj = parent::get_result("soho_Anyting_gcmid", " udid = '".$uiug."' and memid = '".$myid."'   limit 1", "project");
		}else{
			$proj = $project;
		}
		
		return $proj;
	}


	
	//gcmid �� ���Ӱ� ���� �Ѵ�.
	function editGCMID($regid, $udid, $pnum, $project, $memid){
		
		$ss = "select udid from soho_Anyting_gcmid where udid = '".$udid."' ";
		$rr = $this->query($ss);
		if(mysql_num_rows($rr) > 1){
			$smff1 = "delete from soho_Anyting_gcmid  where (gcmid = '".$regid."' or udid = '".$udid."') and project = '".$project."'  ";  		
			parent::query($smff1);
			
			$aa = "insert into soho_Anyting_gcmid (memid, udid, phonum, gcmid, project, login)values('".$memid."', '".$udid."', '".$pnum."', '".$regid."', '".$project."','ok' )";
			$this->query($aa);
			
		}else{
		
			if(mysql_num_rows($rr) == 1){
				$bb = "update soho_Anyting_gcmid set memid = '".$memid."', udid = '".$udid."', phonum = '".$pnum."', gcmid = '".$regid."', login = 'ok' where udid = '".$udid."' ";
				$this->query($bb);
			}else{
				$aa = "insert into soho_Anyting_gcmid (memid, udid, phonum, gcmid, project, login)values('".$memid."', '".$udid."', '".$pnum."', '".$regid."', '".$project."','ok' )";
				$this->query($aa);
			}
	
		}
		
		return "ok";
	
	}




}
?>