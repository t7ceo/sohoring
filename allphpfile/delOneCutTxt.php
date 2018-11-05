<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");


	if(!$_GET[mode]) $_GET[mode] = "onecut";
	
	if($_GET[mode] == "speed"){
		
			//총알머니를 삭제 한다.
		$rr = mysql_query("delete from  AAmySpeedDon where id = ".$_GET[delid]."  limit 1",$rs);
		if(!$rr){
			die("AAmySpeedDon insert err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
	
					//댓글을 삭제 한다.
				$rr = mysql_query("delete from  AAmySpeedRe  where id = ".$_GET[delid]."  ",$rs);
	
				$jsongab = '{"rs":"ok"}';
	
		}

		
	}else if($_GET[mode] == "comimg"){   //업체 이미지를 삭제 한다.
	
		//이미지의 이름을 가져 온다.
		$aa = mysql_query("select imgname from Anyting_comimg where id = ".$_GET[delid]." limit 1 ", $rs);
		$row = mysql_fetch_array($aa);
		
					$img_path = "../Asangdam/images/";
					
					$del_img = $img_path.$row[imgname];
					unlink($del_img);
							
					$del_img = $img_path."thumb/s_".$row[imgname];
					unlink($del_img);  	

		$dd = mysql_query("delete from Anyting_comimg where  id = ".$_GET[delid]." limit 1");
	
		$jsongab = '{"rs":"ok"}';
	
	
	
	}else{
	
			//한컷 리뷰를 삭제 한다.
		$rr = mysql_query("delete from  AAmyOnecut where id = ".$_GET[delid]."  limit 1",$rs);
		if(!$rr){
			die("AAmyOnecut insert err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
	
			//갑맹점 정보 가져옴
			$rr1 = mysql_query("select imgname from AAmyOnecutimg where id = ".$_GET[delid]."  limit 1",$rs);
			if(!$rr1){
				die("AAmyOnecutimg select err".mysql_error());
				$jsongab = '{"rs":"err"}';
			}else{
				$row = mysql_fetch_array($rr1);
				if($row[imgname] != "icon.jpg"){
	
					$img_path = "../Asangdam/onecut/";
					
					$del_img = $img_path.$row[imgname];
					unlink($del_img);
							
					$del_img = $img_path."thumb/s_".$row[imgname];
					unlink($del_img);  	
				}
				
				$rr = mysql_query("delete from  AAmyOnecutimg  where id = ".$_GET[delid]."  limit 1",$rs);
				
				//댓글을 삭제 한다.
				$rr = mysql_query("delete from  AAmyOnecutRe  where id = ".$_GET[delid]."  ",$rs);
	
				$jsongab = '{"rs":"ok"}';
			}
	
		}

	
	}



	mysql_close($rs);

	echo($jsongab);

?>