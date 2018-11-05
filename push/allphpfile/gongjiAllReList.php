<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if(!$_GET[mode]) $_GET[mode] = 0;


	if($_GET[mode] == 0){
		/*
		//원컷 댓글을 모두 가져 온다.
		$rr = mysql_query("select * from soho_AAmyGongjiRe where  id = ".$id."  order by indate",$rs);
		if(!$rr){
			die("AAmyGongjiRe select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				$jsongab .= '{"idnum":'.$row[idnum].', "from":"'.$row[fromid].'", "review":"'.$row[review].'", "day":"'.$row[indate].'" }';
				
				$i++;
			}
			$jsongab .= ']}';
		}
		*/
	
	}else if($_GET[mode] == 1){

		//발송한 공지 내용을 모두 표시 한다.
		$rr = mysql_query("select * from soho_AAmyGongji where project = '".$project."'  order by indate desc",$rs);
		if(!$rr){
			die("AAmyGongji select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				$urlg = $row[url];
				//$urlg2 = str_replace("http://","",$urlg);
				//$urlg1 = "http://".$urlg2;
	
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.rawurlencode($row[title2]).'", "tit3":"'.rawurlencode($row[gongji]).'", "su":'.$row[allinf].', "url":"'.$urlg.'", "urlp":"pushv://'.$urlg.'", "day":"'.$row[indate].'", "img":"'.$row[jangso].'"}';
				
				$i++;
			}
			$jsongab .= ']}';
		}

		
	
	}else{
	
		$rr = mysql_query("select jangso from soho_AAmyGongji where id = ".$_GET[did]." limit 1 ",$rs);
		if(!$rr){
			die("AAmyGongji select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			$row = mysql_fetch_array($rr);
			if($row[jangso] != "0" and $row[jangso] != "norPush.jpg"){
				unlink($my_imgpath.$row[jangso]);
			}
		}
	
		$aa = mysql_query("delete from soho_AAmyGongji where id = ".$_GET[did]." limit 1 ", $rs);
		
		$jsongab = '{"rs":"ok"}';
	
	}

	
	mysql_close($rs);

	echo($jsongab);
?>