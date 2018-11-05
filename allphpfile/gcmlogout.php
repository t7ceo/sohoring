<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	$jsongab = '{"companyid":"err"}';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);
	$aday = date("Y-m-d h:i:s");

	$rr = mysql_query("update soho_Anyting_gcmid set login='no', bell = 1, endtime = '".$aday."' where gcmid = '".$_GET[regid]."' limit 1",$rs);
	if(!$rr) die("gcm logout err".mysql_error());




	$ss = "delete from soho_Anyting_gcmid where (udid = '' or udid = null or udid = 'udid error') ";
	$rr = mysql_query($ss, $rs);
		
		
		//중복된 내용은 삭제 한다.
		$aa = "select id, memid, udid, project,  gcmid from soho_Anyting_gcmid where udid <> 'udid None' order by udid, id desc";
		$rr1 = mysql_query($aa, $rs);
		
		$fndudid = "not";
		$gcmarray[0] = "not";
		$allarray[0] = "not";
		while($row = mysql_fetch_array($rr1)){
			if($row[udid] != $fndudid){  //새로운 폰의 정보가 전달 되었다.
				$c = 0;
				$fndudid = $row[udid];
				$gcmarray = array();
				$allarray = array();
								
				$gcmarray[$c] = $row[gcmid];
				
				$allarray[$c] = $row[memid].$row[udid].$row[project];
				
				
				//$rr = mysql_query("insert into Anyting_test (txt, t1, t2) values('".$gcmarray[$c]."', '".$fndudid."', 'new' )",$rs);

				
				
			}else{   //기존의 폰이다.
			
				if(in_array($row[gcmid], $gcmarray)){  //배열에 같은 값이 있다.
					$ss1 = "delete from soho_Anyting_gcmid where id = ".$row[id]." and udid = '".$fndudid."'   limit 1 ";
					$rr2 = mysql_query($ss1, $rs);
					
					
					//$rr = mysql_query("insert into Anyting_test (txt, t1, t2) values('".$gcmarray[$c]."', '".$fndudid."', 'del' )",$rs);
				
				
				}else{  //배열에 같은 값이 없다.
				
					$aaa = $row[memid].$row[udid].$row[project];
					
					if(in_array($aaa, $allarray)){  //아이디와 폰고유번호, 프로젝트가 같은 레코드가 있다.
						$ss1 = "delete from soho_Anyting_gcmid where id = ".$row[id]." and udid = '".$fndudid."'   limit 1 ";
						$rr2 = mysql_query($ss1, $rs);
						
						
						//$rr = mysql_query("insert into Anyting_test (txt, t1, t2) values('".$gcmarray[$c]."', '".$fndudid."', 'del' )",$rs);
					
					
					}else{
						$gcmarray[$c] = $row[gcmid];
						$allarray[$c] = $aaa;
					
						//$rr = mysql_query("insert into Anyting_test (txt, t1, t2) values('".$gcmarray[$c]."', '".$fndudid."', 'add' )",$rs);				
					}
				
				}
			}
			
			$c++;			
			
		}
		


	$mycon->sql_close();	
	
	

	$ss = "{'kk':'kim seong sig'}";

	echo $ss;
?>