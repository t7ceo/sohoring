<?
/*======================================================================================================
⊙ 개발자		::	
⊙ 최초개발일	::	5월 27일
⊙ 수정일		::	
⊙ 사이트		::	http://chimappram.com
⊙ 수정자		::	김성식
⊙ 수정일		::	2013년 5월 27일
======================================================================================================*/
//사용하는 테이블
//soho_Anyting_gcmid

class MyMySQL extends MySQL
{
	
	
	//회원의 이름을 가져 온다.
	function getMemNicNam(){
		$rr = $this->query("select id from Anyting_Mycompany where companyid = '".$com."' and memid = '".$mem."' and project = '".$proj."'  ");
		if(mysql_num_rows($rr) < 1){
			$aa = $this->query("insert into Anyting_Mycompany (companyid, project, memid)values('".$com."', '".$proj."', '".$mem."')");
		}
		
		return "ok";	

	}
	
	//즐겨 찾기 추가 한다.
	function AddMyLInk($com, $mem, $proj){
	
		$rr = $this->query("select id from Anyting_Mycompany where companyid = '".$com."' and memid = '".$mem."' and project = '".$proj."'  ");
		if(mysql_num_rows($rr) < 1){
			$aa = $this->query("insert into Anyting_Mycompany (companyid, project, memid)values('".$com."', '".$proj."', '".$mem."')");
		}
		
		return "ok";	
	}
	
	
	
	//업체의 별점을 가져 온다.
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
	
	
	
	//udid 값 설정 오류의 경우 삭제 한다.
	function errUdidRecDelete($inf){
		$ss = "delete from soho_Anyting_gcmid where (udid = '' or udid = null or udid = 'udid error') ";
		$this->query($ss);
		

	}

	//gcm id 값에 해당 하는 레코드를 삭제 한다.
	function delGcmIdRec($did){
		$ss = "delete from AAmyGcm where id = ".$did." limit 1";
		parent::query($ss);
	}

	//gcm 와 mypo 에서 새로운 글의 정보를 동시에 레코드 삭제 한다.
	function delMyPoGcmRec($did){
		$ss = "delete from AAmyGcm where recnum = ".$did." limit 1";
		parent::query($ss);
		
		$ss = "delete from AAmyPo where messid = ".$did." limit 1";
		parent::query($ss);
	}



	
	//새로운 메시지를 확인한 것은 삭제 처리 한다.
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
	
	
	//폰의 udid 값을 가져 온다.
	function getUdid($memid, $project){
		
		$udid = parent::get_result("soho_Anyting_memberAdd", "memid =  '".$memid."' and project = '".$project."'   limit 1 ", "udid");
		
		if(!$udid || $udid == "0"){
			$udid = parent::get_result("soho_Anyting_gcmid", "memid =  '".$memid."'  and project = '".$project."' limit 1 ", "uiu");
		}
		
		return $udid;
	}

	//project 값을 가져 온다..
	function getProject1($project, $uiug, $myid){
		
		if(!$project){
			$proj = parent::get_result("soho_Anyting_gcmid", " udid = '".$uiug."' and memid = '".$myid."'   limit 1", "project");
		}else{
			$proj = $project;
		}
		
		return $proj;
	}


	
	//gcmid 를 새롭게 설정 한다.
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