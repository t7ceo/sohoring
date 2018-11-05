<?
include_once 'xmlrpc.inc'; 
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ss = "no";
	$pp = explode("/",$_POST[writer]);
	$param = (double)$pp[0]; //녹음된 음성레코드 아이디 
	$regBg = (double)$pp[1];  //녹음 BG 파일
	$wrter = $_POST[subject]; //작성자의 아이디
	
	$uploaddir = "../Asangdam/onecut/";
	$maxsize = 3000000;

	//파일의 이름을 가져 온다.
	$kk = mysql_query("select * from soho_AllMusic where id = ".$param." limit 1 ", $rs);
	$krow = mysql_fetch_array($kk);




	// uploads디렉토리에 파일을 업로드합니다. 
	 $uploadfile = $uploaddir . basename($_FILES[upfile]['name']); 
	
	 if($maxsize < $_FILES[upfile]['size']){ 
		  echo "업로드 파일이 지정된 파일크기보다 큽니다.\n"; 
	 } else { 
		 if(($_FILES[upfile]['error'] > 0) || ($_FILES[upfile]['size'] <= 0)){ 
			  echo "파일 업로드에 실패하였습니다."; 
		 } else { 
			  // HTTP post로 전송된 것인지 체크합니다. 
			  if(!is_uploaded_file($_FILES[upfile]['tmp_name'])) { 
					echo "HTTP로 전송된 파일이 아닙니다."; 
			  } else { 
					// move_uploaded_file은 임시 저장되어 있는 파일을 ./uploads 디렉토리로 이동합니다. 
					if (move_uploaded_file($_FILES[upfile]['tmp_name'], $uploadfile)) { 
					
						//파일 업로드 정보를 저장 한다.  sohoring.com:41020/sohoring/Asangdam/onecut
						$murl = $_base_url."Asangdam/onecut/".$krow[tit];
						$uu = mysql_query("update soho_AllMusic set fileInf = 1, bgid = ".$regBg.", mname = '".$murl."' where id=".$param." limit 1", $rs);
						
					
						
						echo "성공적으로 업로드 되었습니다.\n"; 
					} else { 
						echo "파일 업로드 실패입니다.\n"; 
					} 
			  } 
		 } 
	 } 



			
			//그림파일 업로드
	    /*=============================================================================
	      파일 업로드
	
	      사용방법 :
	        첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
	        두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
	        세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
	        네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
			*/
			
	/*		
	$max_width = 600;
	//썸네일 이미지 생성 업로드
	$ss = file_upload($_FILES[upfile],$img_path,'gif,jpg',$img_id);




	//$newsId = (int)$param[1];
	//이미지 테이블 기록
	$rr = mysql_query("insert into AAmyOnecutimg (id, imgname)values(".$param.", '".$ss."')",$rs);
	if(!$rr)die("company Update err".mysql_error());



	//블로그에 자료를 저장하는 파일은 아래의 3개 이다.
	//blogOnTextAllPa.php == 모든 파라미터를 받아서 저장한다.
	//blogOnText.php == 글의 아이디만 있으면 블로그에 저장한다.
	//newsUpdataFileOnecut.php == 원컷 리뷰 저장하면서 이미지 파일을 저장하고 블로그에 저장한다.

	//원컷의 제목과 내용을 가져와서 블로그로 보낸다.
	$rr2 = mysql_query("select bloginf, title, memo, project, fromid, url from AAmyOnecut where id = ".$param." limit 1 ",$rs);
	if(!$rr2){
		die("AAmyOnecut err".mysql_error());
	}else{
		$blrow = mysql_fetch_array($rr2);
		
		
		if($blrow[bloginf] == 1){
			
			$rr4 = mysql_query("select blogid, apikey from AAmyOneBlog where project = '".$blrow[project]."' and memid = '".$blrow[fromid]."' limit 1 ",$rs);
			$rr4row = mysql_fetch_array($rr4);
			
			
			$memo = rawurldecode($blrow[memo]);
			$memo = str_replace("\n", "<br />",$memo);
			$tit =  rawurldecode($blrow[title]);

			$url = str_replace("http://", "",trim($blrow[url]));

			if(trim($url) == "0" or !$url or trim($url) == ""){
				$memo .= "<br /><br /><img src='".$img_onecut.$ss."'>";	
			}else{
				$memo .= "<br /><br /><a href='http://".$url."'>http://".$url."</a><br /><br /><img src='".$img_onecut.$ss."'>";	
			}
		
					
			//블로그로 내용을 보낸다.
			$blogimggab = $memo."<br /><br /><a href='https://play.google.com/store/apps/details?id=com.twin7.autocamp'><img src='http://ch1220.cdn2.cafe24.com/camp/baner1.png'></a><br />Date : ".$ad_date;

			newPost($tit, $blogimggab, $rr4row[blogid], $rr4row[apikey]);		
		}
	
	
	}
	*/
	

	mysql_close($rs);



echo('{"rs":"'.$krow[tit].'"}');




?>