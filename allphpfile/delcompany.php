<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$jsongab = '{"companyid":"err"}';
	

		//로그 삭제
		$log_path = "../Asangdam/images/";
		//업체의 이미지를 삭제한다.
    	$result1=mysql_query("select * from Anyting_comimg where companyid = '$comid' ",$rs);
		while($row1=mysql_fetch_array($result1)){
			$del_img = $log_path.$row1[imgname];
			unlink($del_img);
					
			$del_img = $log_path."thumb/s_".$row1[imgname];
			unlink($del_img);  	
		}

		

    	//그림 테이블의 관련 정보를 지운다.
    	$q = "delete from Anyting_comimg where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);


    	//Gps 정보 삭제
    	$q = "delete from Anyting_comgps where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);

    	//매니저 삭제
    	$q = "delete from Anyting_manager where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);

		//리뷰를 삭제한다.
    	$q = "delete from AAmyMess where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);
		
		//즐겨찾기 삭제
    	$q = "delete from Anyting_Mycompany where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);
		
   		//회사정보 삭제
    	$q = "delete from Anyting_company where companyid = '$comid' ";
    	$result=mysql_query($q,$rs);

		
		

    	//대화방 모두 삭제
    	//$q = "delete from Anyting_master where companyid = '$comid' ";
    	//$result=mysql_query($q,$rs);
	
   		//메시지 삭제
    	//$q = "delete from Anyting_message where companyid = '$comid' ";
    	//$result=mysql_query($q,$rs);
	
   		//세메시지 삭제
    	//$q = "delete from Anyting_mypo where companyid = '$comid' ";
    	//$result=mysql_query($q,$rs);
	
   		//방의 상태 삭제
    	//$q = "delete from Anyting_newSt where companyid = '$comid' ";
    	//$result=mysql_query($q,$rs);



	
	$jsongab = '{"companyid":"ok"}';
	

	mysql_close($rs);

	echo($jsongab);
?>