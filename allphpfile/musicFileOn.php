<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	$uploaddir = "../Asangdam/onecut/";
	$maxsize = 30000000;


	$s="fd1";

	$ad_date = date("Y-m-d H:i:s");
	$img_id = substr(md5($ad_date),-5);

	$allLen = basename($_FILES[$s]['name']);
	$extp = stripos(basename($_FILES[$s]['name']),".");
	$ext = substr(basename($_FILES[$s]['name']),-($allLen - $extp));
	$fnam = substr(basename($_FILES[$s]['name']), 0, $extp);
	$fnam = substr(md5($fnam), -7).$img_id;
	

	// uploads디렉토리에 파일을 업로드합니다. 
	 $uploadfile = $uploaddir.$fnam.$ext;	 
	 

	 if($maxsize < $_FILES[$s]['size']){ 
		  echo "업로드 파일이 지정된 파일크기보다 큽니다.Big\n"; 
	 } else { 
		 if(($_FILES[$s]['error'] > 0) || ($_FILES[$s]['size'] <= 0)){ 
		 		//echo $_FILES[$s]['size'];
			  echo "파일 업로드에 실패하였습니다.Err"; 
		 } else { 
			  // HTTP post로 전송된 것인지 체크합니다. 
			  if(!is_uploaded_file($_FILES[$s]['tmp_name'])) { 
					echo "HTTP로 전송된 파일이 아닙니다.Http"; 
			  } else { 
					// move_uploaded_file은 임시 저장되어 있는 파일을 ./uploads 디렉토리로 이동합니다. 
					//echo "tmp=".$_FILES[$s]['tmp_name']."////".$uploadfile."///".$s;
					
					if (move_uploaded_file($_FILES[$s]['tmp_name'], $uploadfile)) { 
					
	//파일의 이름을 가져 온다.
	$kk = mysql_query("insert into soho_AllMusic (tit, mname, gubun, sub, memid, fileInf, sex, onday, pid)values('".$_POST[tit]."', '".$fnam.$ext."', ".$_POST[gubun].", ".$_POST[gubun2].", 'admin', 1, '".$_POST[sex]."', ".mktime().", '".$_POST[pid]."')", $rs);
					
						echo "성공적으로 업로드 되었습니다.Ok\n"; 
					} else { 
					
						echo "파일 업로드 실패입니다.No\n"; 
					} 
			  } 
		 } 
	 } 


//echo "size=".$uploadfile."//tmp==".$_FILES[$s]['tmp_name']."<br />";
///*
$jsongab = '<script>history.go(-1)</script>'; //{"rs":"ok"}';
echo $jsongab;
//*/


?>