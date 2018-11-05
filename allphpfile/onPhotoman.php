<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	$ad_date = date("Y-m-d H:i:s");
	
	if($pcall == 0){ //p일반 사진추가ppppppppppppppppppppppppp
	
		if($md == 1){   //아이콘 등록에서 호출==================
		
			$ss = "select id, coname from soho_Anyting_memberAdd where memid = '".$memid."' and project ='".$proj."'  limit 1";
			$r1 = mysql_query($ss, $rs);
			if(!$r1){
				die("soho_Anyting_memberAdd select err".mysql_error());
				$ss = "err";
			}else{
				$row1 = mysql_fetch_array($r1);
				$ss = "ok";
				
				if($row1[coname] == "0" or $row1[coname] == ""){    //신규 입력
					$aa = "n";
				}else{                //수정
					$aa = $row1[coname];
				}
				
			}
		
		}else{    //업체 이미지 등록에서 호출=====================
		
			//$aa = $mycon->query("insert into Anyting_comimg (companyid, imgname)values('".$comid."', '".."')");

			$ss = "ok";
			$aa = "n";
		}  //====================================================
	
	}else{  //pp업체이벤트 사진변경ppppppppppppppppppppppppppp
		
			$ss = "ok";
			$aa = "n";
	
	}  //ppppppppppppppppppppp
	
	
	

	mysql_close($rs);

	echo('{"rs":"'.$ss.'", "img":"'.$aa.'"}');

?>