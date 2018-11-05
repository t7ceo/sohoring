<?
include 'config.php';
include 'util.php';
include $my_path.'class/class_mysql.php';   //부모 클래스
include $my_path.'class/member_admin.php';      //회원 관련



	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();
//====================================================================================

		$ss = "select * from soho_AAmyGongji  where  id = ".$recnum." and project = '".$proj."'  limit 1";
		$rr = mysql_query($ss, $rs); 
		
		if(!$rr){
			die("soho_AAmyGongji select err".mysql_error());
			$s1 = "err";
		}else{
			$s1 = "ok";
			$row = mysql_fetch_array($rr);		
			
			
			$jsongab = '[{"id":'.$recnum.', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "url":"'.$row[url].'"}]';
			
		}


//===============================================================================================



	$mycon->sql_close();



	echo($jsongab);


?>