<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d");

	$ss = "no";
	$param = $_POST[writer]; // 업체아이디



	$img_path = "../Asangdam/images/";

		//이전 이미지 삭제
    	//삭제할 글에 포함된 그림 정보를 가져 온다.
    	$result=mysql_query("select * from Anyting_comimg where companyid = '$param' ",$rs);
        while($row=mysql_fetch_array($result)){
			
          	$del_img = $img_path.$row[imgname];
            unlink($del_img);
            	
            $del_img = $img_path."thumb/s_".$row[imgname];
            unlink($del_img);  	
		}

    	//그림 테이블의 관련 정보를 지운다.
    	$q = "delete from Anyting_comimg where companyid = '$param' ";
    	$result=mysql_query($q,$rs);




			
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
	$img_id = substr($param,0,4).substr(md5($ad_date),0,6);
	
	$tt = $_POST[subject]; //업체의 로그 이미지
	if($tt == "logup"){
		$max_width = 300;
		$ffxt = "log_";
		$imgg = 1;
	}else{
		$max_width = 1000;
		$ffxt = "";
		$imgg = 0;
	}
	
	$img_id = $ffxt.$img_id;
	//echo $img_id;
	
	if($_POST[webinf] == "ok"){
		$pp = "fd1";
		//썸네일 이미지 생성 업로드
		$ss = file_upload($_FILES[$pp],$img_path,'gif,jpg',$img_id);
	}else{
		//썸네일 이미지 생성 업로드
		$ss = file_upload($_FILES[upfile],$img_path,'gif,jpg',$img_id);
	}
	//echo $ss;
	
	
	//이미지 테이블 기록
	$rr = mysql_query("insert into Anyting_comimg (companyid, gubun, imgname)values('$param', $imgg, '$ss')",$rs);
	if(!$rr)die("company Update err".mysql_error());



	mysql_close($rs);



echo('{"result":"'.$ss.'"}');




?>