<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	//퍼스트콘 등록
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = "no";

	$wrterInf = $_POST[subject]; //저장 구분 (이전에 저장된 이미지 파일의 이름);	
	$wra = explode("/",$wrterInf);


	$comid = $_POST[writer]; //회원의 아이디 또는 업체의 아이디 또는 원컷 아이디

	if($wra[1] == "event"){   //업체 이벤트에서 이미지 등록===========

		$ad_date = date("Y-m-d H:i:s");
		$img_id = substr(md5($ad_date),0,10);
		
		$max_width = 1000;
		$img_path = "../Asangdam/onecut/";

		//기존 이미지를 삭제 한다.
		//이미지의 이름을 가져 온다.
		$aa = mysql_query("select * from AAmyOnecutimg where id= ".$comid." and project = '".$wra[2]."'  ",$rs);
		while($row2=mysql_fetch_array($aa)){
			$del_img = $img_path.$row2[imgname];
			unlink($del_img);
							
			$del_img = $img_path."thumb/s_".$row2[imgname];
			unlink($del_img);  	
		}
		$gg = mysql_query("delete from AAmyOnecutimg where id = ".$comid." ", $rs);		

	
	}else{   //기타 이미지 등록===========

		$ad_date = date("Y-m-d H:i:s");
		$img_id = substr($comid,0,4).substr(md5($ad_date),0,6);

		if($wra[1] == "mem"){  //퍼스나콘 등록
			$max_width = 300;
			$img_path = "../mempsna/";		
		}else{   //업체이미지 등록
			$max_width = 1000;
			$img_path = "../Asangdam/images/";
		}
		
		if($wra[0] != "n"){   //수정 모드
				$del_img = $img_path.$wra[0];
				unlink($del_img);
							
				$del_img = $img_path."thumb/s_".$wra[0];
				unlink($del_img);  	
		}

	}  //====================


	



			
			//그림파일 업로드
	    /*=============================================================================
	      파일 업로드
	
	      사용방법 :
	        첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
	        두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
	        세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
	        네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
			*/

	//echo $img_path."/".$img_id;

	if($_POST[webinf] == "ok"){
		$s="fd1";
		//썸네일 이미지 생성 업로드
		$ss = file_upload($_FILES[$s],$img_path,'gif,jpg',$img_id);
	}else{
		//썸네일 이미지 생성 업로드
		$ss = file_upload($_FILES[upfile],$img_path,'gif,jpg',$img_id);
	}





	if($wra[1] == "mem"){
		//이미지 테이블 기록
		$rr = mysql_query("update soho_Anyting_memberAdd set perimg = '".$ss."', coname = '".$ss."'  where memid = '".$comid."' and project = '".$wra[2]."'  limit 1 ",$rs);
		if(!$rr)die("soho_Anyting_memberAdd Update err".mysql_error());
	
	}else if($wra[1] == "comimg"){   //업체 이미지 등록
		
		$rr = mysql_query("insert into Anyting_comimg (companyid, imgname)values('".$comid."', '".$ss."') ",$rs);
		if(!$rr)die("Anyting_comimg Update err".mysql_error());
		
	}else if($wra[1] == "event"){
		
		$rr = mysql_query("insert into AAmyOnecutimg (id, imgname, project)values(".$comid.", '".$ss."', '".$wra[2]."') ",$rs);
		if(!$rr)die("AAmyOnecutimg Update err".mysql_error());

	}else{
		//이미지 테이블 기록
		$rr = mysql_query("update Anyting_comimg set manphoto = '".$ss."'  where companyid = '".$comid."' limit 1 ",$rs);
		if(!$rr)die("Anyting_comimg Update err".mysql_error());
	
	}

	mysql_close($rs);

	echo('{"rs":"'.$ss.'"}');




?>