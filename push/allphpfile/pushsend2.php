<?
include 'config.php';
//include 'util.php';
include 'gcmutil.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;	
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	
	$pwd1 = rawurldecode($pwd);
	$gogo = explode("_",$pwd1);

		//비밀번호 확인을 한다.
		$oo = $mycon->query("select * from AAmyPass_chn where memid = 'mastpass' and pass = '".$gogo[0]."' limit 1 ");
		if(mysql_num_rows($oo) > 0){
			$ll = str_replace("^","&", $url);
			$ll = str_replace("%5E","&", $url);

			$gtit2 = str_replace("~and~", "&",$gtit2);
			
			
			$rr = '{"rs":"ok"}';
			
			if($desang != "All"){
				$gcmid = $desang;
			}else{
				$gcmid =  "All";
			}
			
			//실제 메시지를 발송 한다.
			sendMessageGCM($gtit1, $gtit2, "Master/77", $gcmid, $rs, $proj, $ll);

		}else{
			$rr = '{"rs":"no"}';		
		}
	
	echo $rr;

	$mycon->sql_close();

?>