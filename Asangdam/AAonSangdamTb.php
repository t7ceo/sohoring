<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	//널값을 삭제 한다.
	$rrdel = mysql_query("delete from AAonSangdamTb where memid = 'null' or memid = 'Null' limit 1",$rs);

	if(!($memid == 'null' or $memid == 'Null' or $memid == "")){
		$aday = date("Y-m-d h:i:s");
		
	
		//업체의 대표가 상담대기자 테이블에 등록되지 않은 경우 등록하고 기존에 있다면 수정 한다.
		$rr1 = mysql_query("select count(memid) as su, id from AAonSangdamTb where memid = '".$memid."' and companyid = '".$comid."' limit 1",$rs);
		if(!$rr1){
			$jsongab = '{"rs":"err"}';
		}else{
			$row1 = mysql_fetch_array($rr1);
			if($row1[su] > 0){
				//테이블의 자료를 변경.
				$rr0 = mysql_query("update AAonSangdamTb set companyid = '".$comid."',  indate = '".$aday."' where id = ".$row1[id]." limit 1",$rs);
				if(!$rr0){
					$jsongab = '{"rs":"err"}';
				}else{
					
					$jsongab = '{"rs":"ok","recnum":'.$row1[id].'}';
				}
			}else{
				//테이블의 자료를 초기화 한다.
				$rr0 = mysql_query("insert into AAonSangdamTb (companyid, memid, indate)values('".$comid."', '".$memid."', '".$aday."')",$rs);
				if(!$rr0){
					$jsongab = '{"rs":"err"}';
				}else{
				//마지막으로 삽입된 글의 번호를 반환 한다.
					$rr=mysql_query("select last_insert_id() as num",$rs); 
					if(!$rr) die("onAAonsangdamTB last id err".mysql_error());
					$row = mysql_fetch_array($rr);
					
					$jsongab = '{"rs":"ok","recnum":'.$row[num].'}';
				}
			}
		}
	}else{
				$jsongab = '{"rs":"err"}';
	}

	mysql_close($rs);

	echo($jsongab);
?>