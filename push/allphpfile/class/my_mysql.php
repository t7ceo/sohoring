<?
/*======================================================================================================
⊙ 개발자		::	
⊙ 최초개발일	::	5월 27일
⊙ 수정일		::	
⊙ 사이트		::	http://mlrl2000.cafe24.com
⊙ 수정자		::	김성식
⊙ 수정일		::	2013년 5월 27일
======================================================================================================*/
//사용하는 테이블
//soho_Anyting_gcmid

class MyMySQL extends MySQL
{
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
		
		$udid = parent::get_result("Anyting_memberAdd", "memid =  '".$memid."' and project = '".$project."'   limit 1 ", "udid");
		
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
	function editGCMID($regid, $udid, $pnum, $project){
		//해당 프로젝트에 기존에 저장된 gcmid 가 있는지 확인 한다.
		$wh = " gcmid = '".$regid."' and udid = '".$udid."' ";
		if($this->get_count("soho_Anyting_gcmid", $wh) > 0){
			//$wh1 = " gcmid = '".$regid."' and udid = '".$udid."'  ";
			//$arr = Array( 'login' => 'kok', 'project' => 'autocampcc' );  //$project.'ko');
			//MySQL::sql_update("soho_Anyting_gcmid", $arr, $wh1);
			
			$rr = "update soho_Anyting_gcmid set login='rok', phonum='".$pnum."', project='".$project."' where gcmid = '".$regid."' and udid = '".$udid."'  ";
			$this->query($rr);
		}else{
			$gcmid = "okN";
			if(!$udid) $udid = "udid New";
			//$arr = Array( 'udid' => "$udid", 'gcmid' => "$regid", 'project' => "$project", 'login' => "$gcmid");
			/*
			$arr['udid'] = $udid;
			$arr['gcmid'] = $regid;
			$arr['project'] = $project;
			$arr['login'] = $gcmid;
			
			$this->sql_insert("soho_Anyting_gcmid", $arr);
			*/
			
			
			$aa = "insert into soho_Anyting_gcmid (udid, phonum, gcmid, project, login)values('".$udid."', '".$pnum."', '".$regid."', '".$project."','".$gcmid."' )";
			$this->query($aa);
		}
	}






}
?>