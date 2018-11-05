<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);





	//가맹점의 정보와 이미지를 가져 온다.
	$rr = mysql_query("select id, companyid, masterid, memo, tel, sangho, spsu, jdon, coname, oninf, url, juso, indate, gubun, ondate, enddate from soho_Anyting_company where id = ".$id."  limit 1",$rs);
	if(!$rr){
		die("soho_Anyting_company select err".mysql_error());
		$jsongab = '{"companyid":"err"}';
	}else{
		$jsongab = '';
       	$row=mysql_fetch_array($rr);
		
		
					//상품의 판배 수량을 구한다.
					$rr9 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$id." group by spid ",$rs);
					if(mysql_num_rows($rr9) > 0){
						//if(!$rr9) die("soho_Anyting_combaguni select err".mysql_error());
						$ssurow = mysql_fetch_array($rr9);   //이미지 가져온다.
						$ssu = $ssurow[ssu];
					}else{
						$ssu = 0;
					}
			
		

		//업체의 별점을 가져 온다.
		list($allgab , $su) = $mycon->comStar($row[companyid]);
		if($su > 0){
			$star = round($allgab / $su);
			$stjum = round(($allgab * 20) / $su,1);	
		}else{
			$stjum = 0;	
			$star = 0;
		}

		//메인 로고를 가져 온다.
		$ll = $mycon->query("select imgname from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1 limit 1");
		$rowimg = mysql_fetch_array($ll);
		if($rowimg[imgname] == ""){
			$logimg = "sangseBas.png";
		}else{
			$logimg = $rowimg[imgname];
		}

		
		//가맹점의 Gps 값을 가져 온다.
		$aa = mysql_query("select latpo, longpo from soho_Anyting_comgps where companyid = '".$row[companyid]."' limit 1", $rs);
		$row1 = mysql_fetch_array($aa);
		
		
					$sho = str_replace("%2F", "/", $row[sangho]);
					$jso = str_replace("%2F", "/", $row[juso]);
					$memo = str_replace("%2F", "/", $row[memo]);

		
		
		
		$day = $row[indate];
		
		$don = number_format($row[coname]);
		$tjdon = number_format($row[jdon]);
		$jdon = $row[jdon];
		
		
		$jsongab .= '{"comid":"'.$row[companyid].'","masterid":"'.$row[masterid].'","comimg":"'.$logimg.'", "memo":"'.$memo.'", "tel":"'.$row[tel].'", "sangho":"'.$sho.'", "coname":"'.$row[coname].'", "tablesu":0, "oninf":'.$row[oninf].', "url":"'.$row[url].'", "don":"'.$don.'", "jdon":'.$jdon.', "tjdon":"'.$tjdon.'", "latpo":0, "longpo":0, "day":"'.$day.'", "addr":"'.$jso.'", "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$stjum.', "spsu":'.$row[spsu].', "ssu":'.$ssu.', "gb":'.$row[gubun].', "id":'.$row[id].', "stday":"'.$row[ondate].'", "endday":"'.$row[enddate].'"}';

	}



	$mycon->sql_close();

	echo($jsongab);
?>