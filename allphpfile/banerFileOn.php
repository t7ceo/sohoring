<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	$uploaddir = "../Asangdam/baner/";
	$maxsize = 30000000;


	$s="fd1";



		//그림파일 업로드
	    /*=============================================================================
	      파일 업로드
	
	      사용방법 :
	        첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
	        두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
	        세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
	        네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
			*/
			
	$ad_date = date("Y-m-d H:i:s");
	$img_id = "soho".$_POST['id'];
	if($maxsize < $_FILES[$s]['size'] and $_FILES[$s]['size'] < 1){ 
		  //echo "업로드 파일이 지정된 파일크기보다 큽니다.Big\n"; 
	 } else { 
		$ss = file_upload_thumbmu($_FILES[$s], $uploaddir, 'gif,jpg', $img_id);

	
		//이미지 테이블 기록
		$rr = mysql_query("update soho_Anyting_banner set companyid = '$ss', stday = '$ad_date', oninf = 1 where id = ".$_POST['id']." limit 1",$rs);
		if(!$rr)die("company Update err".mysql_error());
	}





	$uploaddir = "../Asangdam/onecut/";
	$maxsize = 30000000;


	$s="fd2";



	$ad_date = date("Y-m-d H:i:s");
	$img_id = substr(md5($ad_date),-5);

	$allLen = basename($_FILES[$s]['name']);
	$extp = stripos(basename($_FILES[$s]['name']),".");
	$ext = substr(basename($_FILES[$s]['name']),-($allLen - $extp));
	$fnam = substr(basename($_FILES[$s]['name']), 0, $extp);
	$fnam = substr(md5($fnam), -7).$img_id;
	

	// uploads디렉토리에 파일을 업로드합니다. 
	 $uploadfile = $uploaddir.$fnam.$ext;	 
	 


	 if($maxsize < $_FILES[$s]['size'] and $_FILES[$s]['size'] < 1){ 
		  //echo "업로드 파일이 지정된 파일크기보다 큽니다.Big\n"; 
	 } else { 
		 if(($_FILES[$s]['error'] > 0) || ($_FILES[$s]['size'] <= 0)){ 
		 		//echo $_FILES[$s]['size'];
			  //echo "파일 업로드에 실패하였습니다.Err"; 
		 } else { 
			  // HTTP post로 전송된 것인지 체크합니다. 
			  if(!is_uploaded_file($_FILES[$s]['tmp_name'])) { 
					//echo "HTTP로 전송된 파일이 아닙니다.Http"; 
			  } else { 
					// move_uploaded_file은 임시 저장되어 있는 파일을 ./uploads 디렉토리로 이동합니다. 
					if (move_uploaded_file($_FILES[$s]['tmp_name'], $uploadfile)) { 
					
	//파일의 이름을 가져 온다.
	$kk = mysql_query("update soho_Anyting_banner set music = '".$fnam.$ext."' where id = ".$_POST['id']." limit 1", $rs);
					
						//echo "성공적으로 업로드 되었습니다.Ok\n"; 
					} else { 
						//echo "파일 업로드 실패입니다.No\n"; 
					} 
			  } 
		 } 
	 } 


$jsongab = '<script>history.go(-1)</script>'; //{"rs":"ok"}';
echo $jsongab;



?>