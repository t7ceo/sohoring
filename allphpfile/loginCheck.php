<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/member_admin.php';      //회원 관련

	//var param = "memid="+myId.value+"&passwd="+hidnpass+"&uiug="+deviceUiu+"&proj="+proje;
	if($webmd){

						
			session_unregister('id_session');
		 	session_unregister('myposition');
			
			$jsongab = '{"meminf":0}';		
		
	}
	
	
	
	if($webmd != "logout" or !$webmd){
		
	

		$mymem = new Member;
		$rs = $mymem->connect($host,$dbid,$dbpass);
		$mymem->select($dbname);
	
	
		$jsongab = '{"memsu":"err"}';
		
		//이메일 체크-memid 반환
		$memid = $mymem->find_memid($_GET[email], $_GET[proj]);
		if($memid != "no"){
			//비밀번호의 오류 여부를 체크한다.
			//soho_Anyting_memberAdd 에 회원 정보가 없는 경우 추가 한다.
			if($mymem->find_pass($memid, $_GET[passwd], $_GET[proj], $_GET[uiug])){
				//회원의 이메일, uiu, 자격 값을 출력한다.
				$row0 = $mymem->getMemberInf($memid, $_GET[passwd], $_GET[proj]);
				if($row0){
					$aa = 0;
					while($row1 = mysql_fetch_array($row0)){
						//첫번째 자료를 처리 하고 같은게 또 있다면 삭제 한다.
						if($aa == 0){  //==============================
							if($row1[mempo] == 9){      //총괄대표의 자격 확인
								if($row1[udid] == $_GET[uiug]){   //총괄 대표   
									$meminf = 9;
									$jsongab = '{"memsu":"go", "meminf":9,  "monly":'.$row1[id].', "memid":"'.$memid.'"}';
								}else{
									$meminf = 1;         //총괄 대표 아님
									$jsongab = '{"memsu":"go", "meminf":1, "uiugab":"'.$_GET[uiug].'",  "monly":'.$row1[id].', "memid":"'.$memid.'"}';
								}
							}else{                       //일반회원의 자격확인
								//일반회원의 경우 soho_Anyting_memberAdd 의 값이 0이면 soho_Anyting_member 테이블에서 자격값을 가져 와서 셋팅한다.
								$meminf = $row1[mempo];
								//자격값 셋팅 않된 경우 셋팅 한다.
								if($meminf == 0){
									$row2 = $mymem->getMemberInfUnd($memid, $_GET[passwd], $_GET[proj]);
									$row3 = mysql_fetch_array($row2);	
									
									$meminf = $row3[meminf];
									
									//회원 자격값을 수정한다.
									$mymem->query("update soho_Anyting_memberAdd set mempo = ".$meminf." where id = ".$row1[id]."  limit 1");
	
								}
	
								$jsongab = '{"memsu":"go", "meminf":'.$meminf.',  "monly":'.$row1[id].', "memid":"'.$memid.'"}';
							}
				
							//project 수정
							$mymem->query("update soho_Anyting_memberAdd set udid = '".$_GET[uiug]."' where id = ".$row1[id]."  limit 1");
							
							
							//gcmid에 아이디 저장
							$mymem->query("update soho_Anyting_gcmid set memid='".$memid."' where udid = '".$_GET[uiug]."' and project= '".$_GET[proj]."' limit 1");

							//$cc = mysql_query("delete from soho_Anyting_gcmid where memid = '".$memid."' and (udid = 'web' or udid != '".$_GET[uiug]."')", $rs);							
							
							//웹에서 실행한 경우 세션을 처리 한다.
							if($webmd == "ok"){
							
							
								$id_session = trim($memid);
								$myposition =  $meminf; 
								session_register('id_session');
								session_register('myposition');
							
							}
							
							
							
						
						}else{    //============================================
							//중복된 자료는 삭제 한다.
							$cc = mysql_query("delete from soho_Anyting_memberAdd where id = ".$row1[id]." limit 1", $rs);
					
						}         //end=========================================
						$aa++;
					}
					
	
				}else{
					$jsongab = '{"memsu":"Geterr", "meminf":0}';			
				}
			}else{
				$jsongab = '{"memsu":"passerr", "meminf":0}';			
			}
		}else{
			$jsongab = '{"memsu":"iderr", "meminf":0}';	
		}

		$mymem->sql_close();
	
	
	}
	
		echo($jsongab);	
	

?>