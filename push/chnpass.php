<?
include './allphpfile/config.php';
include './allphpfile/util.php';
//include 'gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련


	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	//edtoldpassnewpass;   //수정
	$mode1 = rawurlencode($mode);
	//기존 비밀번호를 가져 온다.
	$oo = $mycon->query("select * from AAmyPass_chn where memid = 'mastpass' limit 1 ");
	$row = mysql_fetch_array($oo);
	$oldpass = $row[pass];
	$oldlen = strlen($oldpass);
	
	$newlen = strlen($mode1);
	$txtcha = $newlen - $oldlen; 
	$newpass = substr($mode1, ($oldlen + 3), $txtcha);
	
	if(substr($mode1, 0, 3) == "edt"){    //수정 모드

		$kk = str_replace("edt", "", $mode1);
		if(substr($kk,0, $oldlen) == $oldpass){  //비밀번호 일치
			
			$uu = $mycon->query("update AAmyPass_chn set pass = '".$newpass."' where id = ".$row[id]."  limit 1");
			echo 'Change Ok';					
		}else{
			echo 'Change NO';		
		}
	

	}else{
			echo 'Change No';		
	}
	
	

	$mycon->sql_close();

?>