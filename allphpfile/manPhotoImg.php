<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");
	

		if($md == 1){   //회원의 퍼스나콘을 가져 온다.=================
		
			$ss = "select perimg from soho_Anyting_memberAdd where memid = '".$memid."'  and project = '".$proj."' limit 1";
			$r1 = mysql_query($ss, $rs);
			if(!$r1){
				die("soho_Anyting_memberAdd select err".mysql_error());
				$ss1 = "err";
			}else{
				$row1 = mysql_fetch_array($r1);
				$ss1 = "ok";
				
				if($row1[perimg] != "noperimg.jpg"){    //내용 있음
					$aa = $row1[perimg];
				
				}else{                //내용 없음
					$aa = "noperimg.jpg";
				}
				
			}
		
			$jsongab = '{"rs":"'.$ss1.'", "img":"'.$aa.'"}';
		
		}else{   //업체의 모든 이미지를 가져 온다.========================
		
		
			//업체의 모든 이미지
			$rr = mysql_query("select * from Anyting_comimg where  companyid = '".$comid."' and gubun = 0  order by id desc",$rs);
			if(!$rr){
				die("Anyting_comimg select err".mysql_error());
				$jsongab = '{"rs":"err"}';
			}else{
				if(mysql_num_rows($rr) > 0){
					$jsongab = '{"rs":[';
					$i = 1;
					while($row=mysql_fetch_array($rr)){
						if($i > 1) $jsongab .= ",";
			
						$jsongab .= '{"id":'.$row[id].', "img":"'.$row[imgname].'"}';
						
						$i++;
					}
					$jsongab .= ']}';
				
				}else{
					$jsongab = '{"rs":"not"}';
				
				}
				
			}

		
		
		}
	
	
	echo $jsongab;

	mysql_close($rs);



?>