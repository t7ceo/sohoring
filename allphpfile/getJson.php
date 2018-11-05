<?
include 'config.php';
include 'util.php';
include $my_path.'class/class_mysql.php';   //부모 클래스
include $my_path.'class/member_admin.php';      //회원 관련



	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	
	
	$ad_date = date("Y-m-d H:i:s");
	
	
	//$mycon->sql_close();
//====================================================================================
	
		switch($mode){
		case "mess":   //메시지 gcm 발송
		
			$ss = "select title, title2, url from AAmyGongji  where  id = ".$recnum." and project = '".$proj."'  limit 1";
			$rr = mysql_query($ss, $rs); 
			
			if(!$rr){
				die("AAmyGongji select err".mysql_error());
				$s1 = "err";
			}else{
				$s1 = "ok";
				$row = mysql_fetch_array($rr);		
				
				
				$jsongab = '[{"id":'.$recnum.', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "url":"'.$row[url].'"}]';
				
			}
		
		break;
		}
	

//===============================================================================================



	$mycon->sql_close();



	echo($jsongab);


?>