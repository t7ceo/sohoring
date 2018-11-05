<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

//받을 사람의 테이블 번호를 가져 온다.
//받을 사람의 현재 테이블 번호가 있는 곳은 ? Anyting_master 의 nickname 필드에서 회원 아이디로 찾아서 tbnum 필드의 값을 가져 온다.
//받을 사람이 현재 테이블에 없다면 Anyting_message 테이블의 fromnum 필드에서 가장 최근의 테이블 번호를 가져 온다.

	$rr1 = mysql_query("select tbnum, count(sex) as su from Anyting_master where companyid = '".$comid."' and  nickname = '".$sdmemid."' and roomInf > 0  limit 1",$rs);
	if(!$rr1){
		$jsongab = '{"tbn":"err"}';
		die("getTableNumber.php err".mysql_error());
	}else{
		$row = mysql_fetch_array($rr1);
		if($row[su] > 0){   //회원이 존재 한다.
			$jsongab = '{"tbn":"ok", "frm":'.$row[tbnum].'}';
		}else{      //위에서 존재 하지 않는 경우
			$rr2 = mysql_query("select fromnum from Anyting_message where companyid = '".$comid."' and  pass = '".$sdmemid."' order by id desc limit 1",$rs);
			if(!$rr2){
				$jsongab = '{"tbn":"err"}';
				die("getTableNumber.php err".mysql_error());
			}else{
				$row1=mysql_fetch_array($rr2);
				
				$jsongab = '{"tbn":"ok", "frm":'.$row1[fromnum].'}';
			}
		}
	}

	mysql_close($rs);

	echo($jsongab);
?>