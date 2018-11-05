<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	$displow = 10;   //한번에 보여줄 줄수

	$ad_date = date("Y-m-d H:i:s");

	if(!$page){
		$disppage = "";
	}else{
		
		$startrow = (($page - 1) * $displow);
		$endrow = $displow;
		
		$disppage = " limit ".$startrow.", ".$endrow." ";
	}


	switch($_GET[mode]){
	case "delJdSp":   //전단을 삭제한다.
		
		//글 읽은 내역 삭제
		$mycon->bas_delete("soho_Anyting_jdimg", " id=".$_GET[jdid]." limit 1 ");

		$jsongab = '{"rs":"ok"}';
	
	
	break;
	case "addJdSp":   //전단상품을 등록한다.
		//"mode=addJdSp&spid="+rid+"&jdid="+alljdimg.viewRid;
		
		//이전에 전단의 등록여부를 확인한다.
		$bb = "select * from soho_Anyting_jdimg where comid = ".$_GET[spid]." and jdtxt = ".$_GET[jdid]." and project = '".$project."' limit 1";
		$bbb = mysql_query($bb, $rs);
		if(mysql_num_rows($bbb) > 0){  //이미 등록된 상품이다.
		
			$jsongab = '{"rs":"err"}';
		
		}else{   //새로운 등록을 한다.
		
			//상품의 대표이미지를 가져온다.
			$cc = "select b.imgname from soho_Anyting_company as a left join soho_Anyting_comimg as b on(a.companyid = b.companyid) where a.id = ".$_GET[spid]." and b.gubun = 1 limit 1";
			$imgaa = mysql_query($cc, $rs);
			if(mysql_num_rows($imgaa) > 0){
				$rowimg = mysql_fetch_array($imgaa);
				$rsimg = $rowimg[imgname];
			}else{
				$rsimg = "0";
			}
		
		
			//전단을 등록한다.
			$ii = "insert into soho_Anyting_jdimg (comid, num, imgname, jdtxt, project)values(".$_GET[spid].", ".$_GET[spid].", '".$rsimg."', ".$_GET[jdid].", '".$project."')";
			$kk = mysql_query($ii,$rs);	
		
			$jsongab = '{"rs":"ok"}';

		}
	
		
	break;	
	case "jdsp":    //전단 제작을 위한 상품 리스트 =================================
	
		//if(!$_GET[latpo] or $_GET[latpo] == 0) $_GET[latpo] = 37.566535;
		//if(!$_GET[longpo] or $_GET[longpo] == 0) $_GET[longpo] = 126.977969;

	
		//$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
		
		
	
		$evntss = " (oninf = 1 or oninf = 2) ";     //현재 등록된 가맹점
		if($_GET[fnd] <> ""){
			$fndq = " and (sangho like '%".$_GET[fnd]."%' or memo like '%".$_GET[fnd]."%') ";
		}else{
			$fndq = "";
		}
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select id, project, companyid, sangho, tel, juso, memo, url from soho_Anyting_company where  ".$evntss."  and  gubun = 1 ".$fndq." and project = '".$project."'  order by ondate desc", $rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
					if($i > 1) $jsongab .= ",";
					//업체의 이미지를 가져온다.
					//$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
					//if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					//$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
					
					
					//전단등록 여부를 확인한다.
					$rr1 = mysql_query("select * from soho_Anyting_jdimg where comid = ".$row[id]." and jdtxt = ".$_GET[jdid]."  ",$rs);
					if(!$rr1) die("soho_Anyting_jdimg select err".mysql_error());
					$su = mysql_num_rows($rr1);   //전단의 등록숫자를 구한다.
					$chkinf = 0;
					$jdspid = 0;
					if($su > 0){
						$chkinf = 1;
						$jdrow = mysql_fetch_array($rr1);
						$jdspid = $jdrow[id];
					}
					
					//업체의 별점을 가져 온다.
					//list($allgab, $su) = $mycon->comStar($row[companyid]);
					//if($su > 0){
						//$star = round($allgab / $su);
					//}else{
						//$star = 0;
					//}
	
					//if(!$row[latpo]) $row[latpo] = 0;
					//if(!$row[longpo]) $row[longpo] = 0;
					//if(!$row[kk]) $row[kk] = 0;
	
	
					
					//$imgnam = $imgrow[imgname];
					//if($imgnam == "") $imgnam = "sangseBas.png";
					$imgnam = "sangseBas.png";
		
		
					$jsongab .= '{"id":'.$row[id].', "jdspid":'.$jdspid.', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'", "jdinf":'.$chkinf.', "lat":0, "long":0, "sai":0, "star":0, "rwsu":0, "rwgab":0}';
					
					$i++;

			}
			$jsongab .= ']}';
		}

	
	break;
	case "member":      //회원 리스트
	
		if($_GET[pss] == "ldiw6c4b48"){
			
			$kk = mysql_query("select * from soho_Anyting_memberAdd where project = 'church' order by id desc  ", $rs);
			$jsongab = '{"rs":[';
			$i = 0;
			while($row=mysql_fetch_array($kk)){
				if($i > 0) $jsongab .= ",";
				
				$cc = mysql_query("select * from soho_Anyting_member where memid = '".$row[memid]."' limit 1  ", $rs);
				$row2 = mysql_fetch_array($cc);
			
				$jsongab .= '{"id":'.$row[id].', "nam":"'.$row[name].'", "mem":"'.$row[memid].'", "day":"'.$row2[indate].'", "em":"'.$row2[email].'", "tel":"'.$row2[tel].'"}';
						
				$i++;
			
			}
			$jsongab .= '], "su":'.$i.'}';
			
		}else{
			$jsongab = '{"rs":"err"}';
		}
	
	
	
	break;
	case "findget":     //업체 검색을 한다.
	
		//if(!$_GET[latpo]) $_GET[latpo] = 37.566535;
		//if(!$_GET[longpo]) $_GET[longpo] = 126.977969;
		
		
	
		//$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
	
		$fndP = " ((a.coname like '%".rawurldecode($_GET[fndt])."%' or a.sangho like '%".rawurldecode($_GET[fndt])."%' or a.memo like '%".rawurldecode($_GET[fndt])."%') or (a.coname like '%".$_GET[fndt]."%' or a.sangho like '%".$_GET[fndt]."%' or a.memo like '%".$_GET[fndt]."%') ) ";
	
		$evntss = $fndP." and  (a.oninf = 1 or a.oninf = 2 or a.star = 9) ";     //현재 등록된 가맹점   
	
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.project, a.companyid, a.sangho, a.tel, a.juso, a.memo, a.url, a.gubun, b.latpo, b.longpo from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) where  ".$evntss." and a.project = '".$_GET[proj]."'  order by a.gubun, a.star desc, a.sangho " ,$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				//업체의 이미지를 가져온다.
				$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
				if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
				$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
				//업체의 별점을 가져 온다.
				list($allgab, $su) = $mycon->comStar($row[companyid]);
				if($su > 0){
					$star = round($allgab / $su);
				}else{
					$star = 0;
				}

				
				$imgnam = $imgrow[imgname];
				if($imgnam == "") $imgnam = "sangseBas.png";
	
	
				$jsongab .= '{"id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'",  "lat":0, "long":0, "sai":0, "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.', "gb":'.$row[gubun].'}';
				
				$i++;
	
			}
			$jsongab .= ']}';
			
			
			
		}
	
	break;
	case "gongjiEdt":   //공지 사항 수정

		$rr = mysql_query("select * from soho_AAmyGongji where project = '".$_GET[proj]."' and id = ".$_GET[rid]." limit 1",$rs);
		if(!$rr){
			die("soho_AAmyGongji select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$row=mysql_fetch_array($rr);
			$jsongab = '{"rs":"ok", "id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "memo":"'.$row[gongji].'", "day":"'.$row[indate].'"}';
		}
	
	
	
	break;
	case "gongjiOne":   //공지 사항 한개만 가져 온다.
	
		$rr = mysql_query("select id, title, title2, gongji, indate from soho_AAmyGongji where project = '".$_GET[proj]."' and allinf = 3 order by indate desc limit 1",$rs);
		if(!$rr){
			die("soho_AAmyGongji select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			
			if(mysql_num_rows($rr) > 0){
				$row=mysql_fetch_array($rr);
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "memo":"'.$row[gongji].'", "day":"'.$row[indate].'"}';
			}else{
				$jsongab .= '{"id":0}';
			}
			$jsongab .= ']}';
		}

	
	break;
	case "faqDel":     //faq 삭제
		$dd = $mycon->bas_delete("soho_AAmyOnecut", " id = ".$_GET[rid]."  limit 1");
		$dd = $mycon->bas_delete("soho_AAmyOnecutRe", " id = ".$_GET[rid]."  ");
		
		$jsongab = '{"rs":"ok"}';
	break;
	case "faq":      //faq 를 수정 한다.
	
		$rr = mysql_query("select * from soho_AAmyOnecut where project = '".$_GET[proj]."' and id = ".$_GET[rid]." limit 1",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
				$row=mysql_fetch_array($rr);
				$jsongab = '{"id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "day":"'.$row[indate].'"}';
		}

	
	break;
	case "faqList":     //faq 리스트를 출력
	
		$rr = mysql_query("select id, title, memo, fromid, indate from soho_AAmyOnecut where project = '".$_GET[proj]."' and gubun = 'faq'  order by indate desc",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				
				//회원의 닉네임을 구한다.
				$kk = mysql_query("select name from soho_Anyting_memberAdd where project = '".$_GET[proj]."' and memid = '".$row[fromid]."' limit 1  ", $rs);
				$kkrow = mysql_fetch_array($kk);
	
	
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "day":"'.$row[indate].'", "frm":"'.$row[fromid].'", "nic":"'.$kkrow[name].'"}';
				
				$i++;
	
			}
			$jsongab .= ']}';
		}

	
	break;
	case "faqListAllDet":    //전체 faq 리스트
	case "jhyuListAllDet":   //jhyuListAllDet전체 댓글 리스트를 가져 온다.
	
		$rr = mysql_query("select id, idnum, review, fromid, indate from soho_AAmyOnecutRe where id = ".$_GET[rid]." order by indate desc",$rs);
		if(!$rr){
			die("soho_AAmyOnecutRe select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				//회원의 닉네임을 구한다.
				$kk = mysql_query("select name from soho_Anyting_memberAdd where project = '".$_GET[proj]."' and memid = '".$row[fromid]."' limit 1  ", $rs);
				$kkrow = mysql_fetch_array($kk);

	
				$jsongab .= '{"id":'.$row[idnum].',  "rid":'.$row[id].', "memo":"'.$row[review].'", "frm":"'.$row[fromid].'", "nic":"'.$kkrow[name].'", "day":"'.$row[indate].'"}';
				
				$i++;
	
			}
			$jsongab .= ']}';
		}
	
	break;
	case "faqListDet":    //FAQ 에 댓글을 단다.
	case "jhyuListDet":    //제휴문의에 댓글을 단다.
		
		$aa = $mycon->query("insert into soho_AAmyOnecutRe (id, review, fromid, indate)values(".$_GET[tid].", '".$_GET[dtxt]."', '".$_GET[memid]."', '".$ad_date."')");
		$jsongab = '{"rs":"ok"}';
	
	
	break;
	case "jehyuDetEdt":    //제휴의 댓글을 수정한다.
		$aa = $mycon->query("update soho_AAmyOnecutRe set review = '".$_GET[memo]."' where idnum = ".$_GET[rid]." limit 1");
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "jehyuDetDel":    //제휴 삭제
		//선택한 제휴 댓글 삭제
		$dd = $mycon->bas_delete("soho_AAmyOnecutRe", " idnum = ".$_GET[rid]."  limit 1");
		
		$jsongab = '{"rs":"ok"}';
	break;
	case "jehyuDel":    //제휴 삭제
		$dd = $mycon->bas_delete("soho_AAmyOnecut", " id = ".$_GET[rid]."  limit 1");
		
		//제휴 댓글 삭제
		$dd = $mycon->bas_delete("soho_AAmyOnecutRe", " id = ".$_GET[rid]." ");
		
		$jsongab = '{"rs":"ok"}';
	break;
	case "jehy":    //제휴 문의 수정

		$rr = mysql_query("select * from soho_AAmyOnecut where project = '".$_GET[proj]."' and id = '".$_GET[rid]."'  limit 1",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
				$row=mysql_fetch_array($rr);
				$jsongab = '{"rs":"ok", "id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "frm":"'.$row[fromid].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "day":"'.$row[indate].'"}';

		}

	
	break;
	case "jhyuList":    //제휴문의 리스트
	
		if($_GET[mast] > 6){
			$ff = " ";     //관리자는 모든 리스트를 가져 온다.
		}else{
			$ff = " and fromid = '".$_GET[memid]."' ";   //자신이 작성한 리스트를 가져 온다.
		}
	
		$rr = mysql_query("select id, title, memo, fromid, tel, url, indate from soho_AAmyOnecut where project = '".$_GET[proj]."' and gubun = 'jhy' ".$ff." order by indate desc",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				
				//회원의 닉네임을 구한다.
				$kk = mysql_query("select name from soho_Anyting_memberAdd where project = '".$_GET[proj]."' and memid = '".$row[fromid]."' limit 1  ", $rs);
				$kkrow = mysql_fetch_array($kk);

	
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "frm":"'.$row[fromid].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "day":"'.$row[indate].'", "nic":"'.$kkrow[name].'"}';
				
				$i++;
	
			}
			$jsongab .= ']}';
		}

	break;
	case "guideDel":    //사용자 가이드 삭제
		$dd = $mycon->bas_delete("soho_AAmyOnecut", " id = ".$_GET[rid]."  limit 1");
		
		$jsongab = '{"rs":"ok"}';
	break;
	case "uguide":   //이용가이드를 수정 한다.
		$rr = mysql_query("select * from soho_AAmyOnecut where project = '".$_GET[proj]."' and id = ".$_GET[rid]." limit 1",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$row = mysql_fetch_array($rr);
			$jsongab = '{"rs":"ok", "id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "day":"'.$row[indate].'"}';
		}
	break;
	case "UseGuide":    //이용자 가이드 리스트
		$rr = mysql_query("select id, title, memo, indate from soho_AAmyOnecut where project = '".$_GET[proj]."' and gubun = 'gud' order by indate desc",$rs);
		if(!$rr){
			die("soho_AAmyOnecut select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "memo":"'.$row[memo].'", "day":"'.$row[indate].'"}';
				
				$i++;
	
			}
			$jsongab .= ']}';
		}


	
	break;
	case "gongjiDel":    //공지 삭제
		$dd = $mycon->bas_delete("soho_AAmyGongji", " id = ".$_GET[rid]."  limit 1");
		$jsongab = '{"rs":"ok"}';
	break;
	case "gongji":   //공지 리스트를 가져 온다.
	
		$rr = mysql_query("select id, title, title2, gongji, indate from soho_AAmyGongji where project = '".$_GET[proj]."' and allinf = 3 order by indate desc",$rs);
		if(!$rr){
			die("soho_AAmyGongji select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			if(mysql_num_rows($rr) > 0){
				while($row=mysql_fetch_array($rr)){
					if($i > 1) $jsongab .= ",";
		
					$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "memo":"'.$row[gongji].'", "day":"'.$row[indate].'"}';
					
					$i++;
		
				}
		
			}else{
				$jsongab .= '{"id":0}';
			}
			$jsongab .= ']}';
		}

	
	
	
	break;
	case "newOnDel":   //신규등록 업체 쉬소
		$aa = $mycon->query("update soho_Anyting_company set oninf = 0, ondate = '0' where id = ".$_GET[rid]." limit 1");
		$jsongab = '{"companyid":"ok"}';
		
	
	break;
	case "newOnOk":    //신규등록 업체 승인
	
		$aa = $mycon->query("update soho_Anyting_company set oninf = 1, ondate = '".$ad_date."' where id = ".$_GET[rid]." limit 1");
		$jsongab = '{"companyid":"ok"}';
		
	
	break;
	case "comNew":    //신규 업체리스트 출력=================================
	
		if(!$_GET[latpo] or $_GET[latpo] == 0) $_GET[latpo] = 37.566535;
		if(!$_GET[longpo] or $_GET[longpo] == 0) $_GET[longpo] = 126.977969;
		
		if($_GET[mast] > 6){   //마스터의 경우 전체 업체를 출력한다.
			$memgb = "";
		
		}else{    //일반회원은 자신이 등록한 것만 출력한다.
			$memgb = " and a.masterid = '".$_GET[memid]."' ";
		
		}
		
		
	
		$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
	
		$evntss = " (a.oninf = 0) ";     //현재 등록된 가맹점   
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.project, a.companyid, a.sangho, a.indate, a.gubun, a.tel, a.juso, a.memo, a.url, b.latpo, b.longpo, ".$fs." as kk from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) where  ".$evntss.$memgb."  and a.project = '".$_GET[proj]."'  order by id desc ".$disppage ,$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				//업체의 이미지를 가져온다.
				$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
				if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
				$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
				//업체의 별점을 가져 온다.
				list($allgab, $su) = $mycon->comStar($row[companyid]);
				if($su > 0){
					$star = round($allgab / $su);
				}else{
					$star = 0;
				}

				if(!$row[latpo]) $row[latpo] = 0;
				if(!$row[longpo]) $row[longpo] = 0;
				if(!$row[kk]) $row[kk] = 0;


				
				$imgnam = $imgrow[imgname];
				if($imgnam == "") $imgnam = "sangseBas.png";
	
	
				$jsongab .= '{"id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "gb":'.$row[gubun].', "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'",  "lat":'.$row[latpo].', "long":'.$row[longpo].', "sai":'.$row[kk].', "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.', "inday":"'.$row[indate].'"}';
				
				$i++;
	
			}
			$jsongab .= ']}';
		}

	
	break;
	case "mycomlist":    //내가 등록한 업체의 리스트
	
	
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.project, a.companyid, a.sangho, a.tel, a.juso, a.memo, a.url, b.latpo, b.longpo from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) where a.project = '".$_GET[proj]."' and masterid = '".$_GET[memid]."'  order by a.star desc, a.sangho",$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
					if($i > 1) $jsongab .= ",";
					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
					
					//업체의 별점을 가져 온다.
					list($allgab, $su) = $mycon->comStar($row[companyid]);
					if($su > 0){
						$star = round($allgab / $su);
					}else{
						$star = 0;
					}
	
					if(!$row[latpo]) $row[latpo] = 0;
					if(!$row[longpo]) $row[longpo] = 0;
	
					
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";
		
		
					$jsongab .= '{"id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'",  "lat":'.$row[latpo].', "long":'.$row[longpo].', "sai":0, "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.'}';
					
					$i++;

			}
			$jsongab .= ']}';
		}
	
	
	break;
	case "mycom":    //나의 마트 정보를 가져온다.
	
	
		if(!$_GET[latpo] or $_GET[latpo] == 0) $_GET[latpo] = 37.566535;
		if(!$_GET[longpo] or $_GET[longpo] == 0) $_GET[longpo] = 126.977969;

	
		$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
	
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.project, a.companyid, a.sangho, a.tel, a.juso, a.memo, a.url, b.latpo, b.longpo, ".$fs." as kk from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) where  a.companyid = '".$_GET[martcomid]."' and a.project = '".$_GET[proj]."'  order by a.star desc, a.sangho ".$disppage ,$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($row[kk] <= $_GET[sai] or $_GET[sai] == 0){   //+++++++++++++++++++++++++++++++++++++++++
					if($i > 1) $jsongab .= ",";
					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
					
					//업체의 별점을 가져 온다.
					list($allgab, $su) = $mycon->comStar($row[companyid]);
					if($su > 0){
						$star = round($allgab / $su);
					}else{
						$star = 0;
					}
	
					if(!$row[latpo]) $row[latpo] = 0;
					if(!$row[longpo]) $row[longpo] = 0;
					if(!$row[kk]) $row[kk] = 0;
	
	
					
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";
		
		
					$jsongab .= '{"id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'",  "lat":'.$row[latpo].', "long":'.$row[longpo].', "sai":'.$row[kk].', "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.'}';
					
					$i++;

				}  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
			$jsongab .= ']}';
		}
	
	
	break;
	case "onbuglist":   //장바구니 리스트를 출력한다.
	

		$ss = "select * from soho_Anyting_combaguni where memid = '".$_GET[memid]."' group by spid order by id desc ";
		$aa = mysql_query($ss, $rs);
		if(mysql_num_rows($aa) > 0){
		
			$jsongab = '{"rs":[';
			$i = 1;
			$alltot = 0;
			while($row=mysql_fetch_array($aa)){
				if($i > 1) $jsongab .= ",";
				
			
	
					//상품의 총판배 수량을 구한다.
					$rr9 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$row[spid]." group by spid ",$rs);
					if(mysql_num_rows($rr9) > 0){
						//if(!$rr9) die("soho_Anyting_combaguni select err".mysql_error());
						$ssurow = mysql_fetch_array($rr9);   //이미지 가져온다.
						$ssu = $ssurow[ssu];
					}else{
						$ssu = 0;
					}

				
	
					//내가 주문한 수량을 구한다.
					$rr10 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$row[spid]." and memid = '".$_GET[memid]."' and gubun < 4 group by spid ",$rs);
					if(mysql_num_rows($rr10) > 0){
						$ssumrow = mysql_fetch_array($rr10);   //이미지 가져온다.
						$ssum = $ssumrow[ssu];
					}else{
						$ssum = 0;
					}
		
		
				
	
				//선택한 상품의 정보를 가져온다.
				$rr = mysql_query("select * from soho_Anyting_company where id = ".$row[spid]." limit 1",$rs);
				$brow = mysql_fetch_array($rr);
				
				$ddon = (double)$brow[coname];
	
				$saledon = ($ddon * $ssum);
				$alltot += $saledon;
				
	
	

					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$brow[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";

				
					$sho = str_replace("%2F", "/", $brow[sangho]);
					$jso = str_replace("%2F", "/", $brow[juso]);
					//$_GET[memo] = str_replace("%2F", "/", $brow[memo]);
	
				$jsongab .= '{"id":'.$row[spid].', "comid":"'.$brow[companyid].'",  "comimg":"'.$imgnam.'", "sangho":"'.$sho.'", "don":'.$row[dandon].', "ssu":'.$ssu.', "ssumy":'.$ssum.', "su":'.$row[su].', "tdon":"'.number_format($row[dandon]).'", "sdon":"'.number_format($saledon).'"}';
				
				$i++;
			}
			
			$jsongab .= '], "tot":"'.number_format($alltot).'"}';
		
		
		}else{
			$jsongab = '{"rs":"not"}';
		}

	
	break;
	case "bugon":  //장바구니 등록 한다.

			//선택한 상품의 정보를 가져온다.
			$rr = mysql_query("select coname from soho_Anyting_company where id = ".$_GET[bid]." limit 1",$rs);
			$brow = mysql_fetch_array($rr);
		
		//장바구니에 등록 정보를 확인 한다.
		$rr2 = mysql_query("select * from soho_Anyting_combaguni where spid = ".$_GET[bid]." and memid = '".$_GET[memid]."' and gubun < 4 ",$rs);
		if(mysql_num_rows($rr2) > 0){   //등록된 자료가 있다.
			$brow2 = mysql_fetch_array($rr2);
			
			$ss = mysql_query("update soho_Anyting_combaguni set su = ".$_GET[su].", inday = '".$ad_date."' where id = ".$brow2[id]." limit 1  ", $rs);
		
		
		}else{
		
			$ddon = (double)$brow[coname];
			$ss = "insert into soho_Anyting_combaguni (spid, project, gubun, memid, su, inday, dandon)values(".$_GET[bid].", '".$project."', 1, '".$_GET[memid]."', ".$_GET[su].", '".$ad_date."', ".$ddon.")";
			$aa = mysql_query($ss, $rs);
				
		
		}
		

	
		$jsongab = '{"rs":"ok"}';
	break;
	case "bugdel":   //장바구니 삭제 한다.
	
		$dd = $mycon->bas_delete("soho_Anyting_combaguni", " spid = ".$_GET[bid]." and memid = '".$_GET[memid]."' and gubun < 3 ");
		$jsongab = '{"rs":"ok"}';
		
	
	break;
	case "jbaguni":    //장바구니 상품의 상세 정보를 출력=================================
	
		//장바구니에 담기 위해서 선택한 상품의 아이디
		$bspid = $_GET[bid];
		if($_GET[bid] > 0){
		
			//선택한 상품의 정보를 가져온다.
			$rr = mysql_query("select id, project, jdon, spsu, companyid, sangho, tel, juso, memo, url, coname from soho_Anyting_company where id = ".$_GET[bid]." limit 1",$rs);
			$brow = mysql_fetch_array($rr);
			
			
					//상품의 판배 수량을 구한다.
					$rr9 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$_GET[bid]." group by spid ",$rs);
					if(mysql_num_rows($rr9) > 0){
						//if(!$rr9) die("soho_Anyting_combaguni select err".mysql_error());
						$ssurow = mysql_fetch_array($rr9);   //이미지 가져온다.
						$ssu = $ssurow[ssu];
					}else{
						$ssu = 0;
					}
					
					//내가 주문한 수량을 구한다.
					$rr10 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$_GET[bid]." and memid = '".$_GET[memid]."' and gubun < 4 group by spid ",$rs);
					if(mysql_num_rows($rr10) > 0){
						$ssumrow = mysql_fetch_array($rr10);   //이미지 가져온다.
						$ssum = $ssumrow[ssu];
					}else{
						$ssum = 0;
					}
						

				
			
					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$brow[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";

					//업체의 별점을 가져 온다.
					list($allgab, $su) = $mycon->comStar($brow[companyid]);
					if($su > 0){
						$star = round($allgab / $su);
					}else{
						$star = 0;
					}
	

					$dd = (double)$brow[coname];
					
					$sho = str_replace("%2F", "/", $brow[sangho]);
					$jso = str_replace("%2F", "/", $brow[juso]);
					$_GET[memo] = str_replace("%2F", "/", $brow[memo]);
						
			
			$jsongab = '{"id":'.$brow[id].', "comid":"'.$brow[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$sho.'", "memo":"'.$_GET[memo].'", "tel":"'.$brow[tel].'", "url":"'.$brow[url].'", "addr":"'.$jso.'",  "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.', "jdon":'.$brow[jdon].', "tjdon":"'.number_format($brow[jdon]).'", "don":"'.number_format($dd).'", "spsu":'.$brow[spsu].', "ssu":'.$ssu.', "ssumy":'.$ssum.'}';
	
		
		
		}else{
			$jsongab = '{"rs":"ok"}';
		}
		
	
	
	
	
/*	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.companyid, b.sangho, b.tel, b.juso, a.su from soho_Anyting_baguni as a left join soho_Anyting_company as b on(a.companyid = b.companyid) where a.memid = '".$_GET[memid]."' and a.project = '".$project."' order by a.indate ",$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
					if($i > 1) $jsongab .= ",";
					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
					
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";
		
		
					$jsongab .= '{"id":'.$row[id].', "proj":"'.$project.'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$row[sangho].'", "tel":"'.$row[tel].'", "addr":"'.$row[juso].'", "su":'.$row[su].'}';
					
					$i++;

			}
			$jsongab .= ']}';
		}
*/
	
	break;
	case "com":    //쇼핑몰의 리스트 출력=================================
	
		if(!$_GET[latpo] or $_GET[latpo] == 0) $_GET[latpo] = 37.566535;
		if(!$_GET[longpo] or $_GET[longpo] == 0) $_GET[longpo] = 126.977969;

	
		$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
	
		$evntss = " (a.oninf = 1 or a.oninf = 2 or a.star = 9) ";     //현재 등록된 가맹점   
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id, a.project, a.jdon, a.companyid, a.sangho, a.tel, a.spsu, a.juso, a.memo, a.url, b.latpo, a.coname, b.longpo, ".$fs." as kk from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) where  ".$evntss."  and  a.gubun = ".$_GET[maingubun]." and a.project = '".$_GET[proj]."'  order by a.star desc, a.sangho ".$disppage ,$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($row[kk] <= $_GET[sai] or $_GET[sai] == 0){   //+++++++++++++++++++++++++++++++++++++++++
					if($i > 1) $jsongab .= ",";
					
					//상품의 판배 수량을 구한다.
					///*
					$rr9 = mysql_query("select sum(su) as ssu from soho_Anyting_combaguni where spid = ".$row[id]." group by spid ",$rs);
					if(mysql_num_rows($rr9) > 0){
						//if(!$rr9) die("soho_Anyting_combaguni select err".mysql_error());
						$ssurow = mysql_fetch_array($rr9);   //이미지 가져온다.
						$ssu = $ssurow[ssu];
					}else{
						$ssu = 0;
					}
					//*/
					//$ssu = 0;
					
					
					//업체의 이미지를 가져온다.
					$rr1 = mysql_query("select * from soho_Anyting_comimg where companyid = '".$row[companyid]."' and gubun = 1   limit 1",$rs);
					if(!$rr1) die("soho_Anyting_comimg select err".mysql_error());
					$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
					
					//업체의 별점을 가져 온다.
					list($allgab, $su) = $mycon->comStar($row[companyid]);
					if($su > 0){
						$star = round($allgab / $su);
					}else{
						$star = 0;
					}
	
					if(!$row[latpo]) $row[latpo] = 0;
					if(!$row[longpo]) $row[longpo] = 0;
					if(!$row[kk]) $row[kk] = 0;
	
	
					
					$imgnam = $imgrow[imgname];
					if($imgnam == "") $imgnam = "sangseBas.png";
		
					$dd = (double)$row[coname];
					
					$sho = str_replace("%2F", "/", $row[sangho]);
					$jso = str_replace("%2F", "/", $row[juso]);
					$_GET[memo] = str_replace("%2F", "/", $row[memo]);
					
					
					
					$jsongab .= '{"id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "comimg":"'.$imgnam.'", "sangho":"'.$sho.'", "memo":"'.$_GET[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$jso.'",  "lat":'.$row[latpo].', "long":'.$row[longpo].', "sai":'.$row[kk].', "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.', "tjdon":'.$row[jdon].', "jdon":"'.number_format($row[jdon]).'", "don":"'.number_format($dd).'", "spsu":'.$row[spsu].', "ssu":'.$ssu.'}';
					
					$i++;

				}  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
			$jsongab .= ']}';
		}

	
	break;
	case "mysqlon":
	
	
		$ttt = "t7ceosp1,바나나 1봉,1980 ,IMG_1.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp2,거제유자청 2kg 1병,7900 ,IMG_2.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp3,밀감 5kg 1박스,7900 ,IMG_3.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp4,포기새송이버성1+1,1100 ,IMG_4.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp5,배추 3잎 1망,3480 ,IMG_5.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp6,양파 1kg내외 1+1,1100 ,IMG_6.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp7,브랜드생삽겹 100g,1280 ,IMG_7.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp8,한우국걸리/불고기 100g,2580 ,IMG_8.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp9,한우꽃등심 100g,4580 ,IMG_9.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp10,한우차돌박이 100g,3980 ,IMG_10.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp11,미국산 두절가자미 5마리,3980 ,IMG_11.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp12,국산 봉지굴 2봉,3490 ,IMG_12.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp13,꽃살 20kg,40900 ,IMG_13.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp14,일판란 30구 1판,2980 ,IMG_14.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp15,맥심모카골드 150T+20T,17800 ,IMG_15.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp16,오뚜기 옛날참기름 500ml 1개,4500 ,IMG_16.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp17,농심 사리곰탕면 5입멀티 1개,2980 ,IMG_17.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp18,롯데제주감귤 1.5리터 1개 ,990 ,IMG_18.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp19,풀무원가쓰오우동 4입 1개,5750 ,IMG_19.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp20,건강한두부 300g 1개,450 ,IMG_20.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp21,코디 3겹데코 30롤,7900 ,IMG_21.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp22,가시오이 1박스,18900 ,IMG_22.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp23,깻잎 1박스,9800 ,IMG_23.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp24,꽃상추 2kg 1박스,5980 ,IMG_24.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp25,적상추 2kg 1박스,5980 ,IMG_25.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp26,콩알새송이버섯 2kg 1봉,3480 ,IMG_26.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp27,새송이 버섯 2kg 1봉,5980 ,IMG_27.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp28,애느타리버섯 2kg 1봉,4480 ,IMG_28.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp29,양배추 3입 1망,3480 ,IMG_29.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp30,양파 20kg 1망,9900 ,IMG_30.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp31,표고버섯 1kg 1봉,14800 ,IMG_31.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp32,염장미역 1박스,3880 ,IMG_32.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp33,염장다시다 1박스,3880 ,IMG_33.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp34,무 1박스,7800 ,IMG_34.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp35,쥬키니호박 1박스,9800 ,IMG_35.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp36,냉동삼겹살 1판원물 100g,1280 ,IMG_36.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp37,냉동삼겹살 1판원물 100g,890 ,IMG_37.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp38,수제돈까스 1kg 1개,10500 ,IMG_38.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp39,갈릭스테이크 1kg 1개,10500 ,IMG_39.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp40,철마 한우곰탕 800g 1개,8500 ,IMG_40.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp41,중국  냉동새우살 1kg,9980 ,IMG_41.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp42,대만 꽁치 1박스,23900 ,IMG_42.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp43,베트남 호롱낙지 1봉,12900 ,IMG_43.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp44,수입청포도 2kg 1박스,12800 ,IMG_44.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp45,방울토마토 1kg 1박스,3480 ,IMG_45.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp46,대추방울토마트 2kg 1박스,6900 ,IMG_46.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp47,대봉 3kg 1박스,6380 ,IMG_47.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp48,단감 4kg 1박스,6980 ,IMG_48.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp49,사과 7입 1봉,4980 ,IMG_49.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp50,석류 15수 1박스,22880 ,IMG_50.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp51,배 4입 1봉,3980 ,IMG_51.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp52,그린키위 4입 1팩,2480 ,IMG_52.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp53,골드키위8입 1팩,5880 ,IMG_53.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp54,가시오이 2입 1봉,1100 ,IMG_54.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp55,팽이버섯 3입 1봉,1100 ,IMG_55.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp56,애느타리버섯 1+1팩,1100 ,IMG_56.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp57,애오박 1개,1100 ,IMG_57.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp58,부추1단,1880 ,IMG_58.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp59,무우 1통,780 ,IMG_59.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp60,대파1단,980 ,IMG_60.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp61,양배추 1통,1180 ,IMG_61.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp62,깐마늘 1kg 1봉,4480 ,IMG_62.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp63,간마늘 1kg 1봉,2680 ,IMG_63.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp64,쥬키니호박 2개,1100 ,IMG_64.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp65,청량고추 300g 1봉,1980 ,IMG_65.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp66,단배추 2단,1100 ,IMG_66.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp67,남해시금치 1단,1380 ,IMG_67.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp68,고구마 700g 내외,2380 ,IMG_68.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp69,감자 2kg 1박스,2550 ,IMG_69.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp70,국내산 돼지앞다리살(수육용)100g,890 ,IMG_70.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp71,국내산 돼지목심불고기 100g,780 ,IMG_71.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp72,국내산 생오리양념 불고기 100g,990 ,IMG_72.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp73,국내산 돼지뒷다리살(수육용)100g,590 ,IMG_73.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp74,국내산 양념돼지갈비 100g,990 ,IMG_74.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp75,수입 양념소불고기 100g,1090 ,IMG_75.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp76,국내산 올품육계1수,3980 ,IMG_76.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp77,기니아산 침굴비 10마리 1두릅,8900 ,IMG_77.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp78,비타 요구르트 5입 3줄,990 ,IMG_78.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp79,동원 365일 순수한목장우유 900mlx2,2980 ,IMG_79.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp80,콘푸라이트 600g,3750 ,IMG_80.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp82,롯데 키스틱 500gx2,6980 ,IMG_82.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp83,롯데 칙촉 168gx2,3950 ,IMG_83.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp84,크라운 빅파이 324g 1개,1980 ,IMG_84.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp85,동원 리챔(오리지널 2입+통살 1입),9900 ,IMG_85.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp86,동원 런천미트 340g 1개,1980 ,IMG_86.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp87,칠성사이다 1.5리터+밀키스 1.5리터,2750 ,IMG_87.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp88,삼육두유A 190mlX24입,9900 ,IMG_88.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp89,아카페라(5종) 240ml,850 ,IMG_89.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp90,가나 초코우유/바나나우유 225mlx4입,2200 ,IMG_90.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp91,유자차/대추차/생강차 1kg,4950 ,IMG_91.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp92,고려잣호두율무차 900g 50T,9500 ,IMG_92.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp93,롯데 제크 300g 1개,1500 ,IMG_93.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp94,해태 아이비 270g 1개 ,1980 ,IMG_94.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp95,오리온 고소미 241g 1개,1980 ,IMG_95.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp96,오리온 초코칩 192gX2입 1개,2580 ,IMG_96.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp97,청우 5000미본쌀과자 288g 1개,2450 ,IMG_97.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp98,롯데 출첵 345g 1개,2980 ,IMG_98.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp99,팔도 일품해물라면 5입멀티 1개,2950 ,IMG_99.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp100,구포국수 소면/중면 1.4kg,1980 ,IMG_100.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp101,동원살코기 참치 150gx3입,5980 ,IMG_101.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp102,동원 스위트콘 340g,950 ,IMG_102.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp103,오뚜기 잡채만두 540gx2입,4950 ,IMG_103.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp104,롯데 북촌옛날군만두 360gx2입,4950 ,IMG_104.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp105,풀무원 부추잡채만두 300gx2입,5400 ,IMG_105.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp106,청정원 숯불떡갈비 410gx2입,5980 ,IMG_106.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp107,한성 해물경단 300gx2입,4980 ,IMG_107.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp108,진주 방과후핫도그 250g+250g,4500 ,IMG_108.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp109,농심 고시히카리쌀밥 210gx3입,2750 ,IMG_109.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp110,청정원 볶음밥(3종) 450g,3750 ,IMG_110.jpg,전단상품,원산지 국산/추천 전단상품,
t7ceosp111,청정원 카레여왕(5종) 108g,1950 ,IMG_111.jpg,전단상품,원산지 국산/추천 전단상품";
		
		$kk = explode(",", $ttt);
		
		//echo $kk[6];
		for($c=0; $c < count($kk); $c += 6){
			
			$ss = "insert into soho_Anyting_company (companyid, project, gubun, masterid, coname, sangho, memo, juso, si, gu, oninf)values('".trim($kk[($c+0)])."', 'wrmartad', 1, 't7ce2ea69e', '".$kk[($c+2)]."', '".rawurlencode($kk[($c+1)])."', '".rawurlencode($kk[($c+5)])."', '".rawurlencode($kk[($c+4)])."', 'a', 'a1', 1)";
			
			echo $ss."<br />";
			
			$uu = mysql_query($ss, $rs);
			
			
			
			
			$ss2 = "insert into soho_Anyting_comimg (companyid, gubun, imgname)values('".$kk[($c+0)]."', 1, '".$kk[($c+3)]."')";
			
			echo $ss2."<br />";
			
			$uu2 = mysql_query($ss2, $rs);
			
		
		}
	
	
	break;
	case "linkAdd":   //즐겨 찾기 추가
		//즐겨찾기 추가 한다.
		$oo = $mycon->AddMyLInk($_GET[comid], $_GET[memid], $_GET[proj]);
		$jsongab = '{"companyid":[{"rs":"ok"}]}';
	
	break;
	case "link":   //즐겨 찾기 업체 리스트
	
		if(!$_GET[latpo]) $_GET[latpo] = 37.566535;
		if(!$_GET[longpo]) $_GET[longpo] = 126.977969;
		
	
		$fs = "ROUND( 6371 * acos(cos(radians(".$_GET[latpo].")) * cos(radians(b.latpo)) * cos(radians(b.longpo) - radians(".$_GET[longpo].")) + sin(radians(".$_GET[latpo].")) * sin(radians(b.latpo))) ,2)";
	
		$evntss = " (a.oninf = 1 or a.oninf = 2 or a.star = 9) ";     //현재 등록된 가맹점   
	
		//갑맹점 정보 가져옴
		$rr = mysql_query("select a.id as aid, c.id, a.project, a.gubun, a.companyid, a.sangho, a.tel, a.juso, a.memo, a.url, b.latpo, b.longpo, ".$fs." as kk from soho_Anyting_company as a left join soho_Anyting_comgps as b on(a.companyid = b.companyid) left join soho_Anyting_Mycompany as c on(a.companyid = c.companyid) where  ".$evntss."  and  c.memid = '".$_GET[memid]."' and c.project = '".$_GET[proj]."'  order by a.gubun, a.sangho ",$rs);
		if(!$rr){
			die("soho_Anyting_company select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				
				//업체의 별점을 가져 온다.
				list($allgab, $su) = $mycon->comStar($row[companyid]);
				if($su > 0){
					$star = round($allgab / $su);
				}else{
					$star = 0;
				}
	
				$jsongab .= '{"aid":'.$row[aid].', "id":'.$row[id].', "proj":"'.$row[project].'", "comid":"'.$row[companyid].'", "sangho":"'.$row[sangho].'", "memo":"'.$row[memo].'", "tel":"'.$row[tel].'", "url":"'.$row[url].'", "addr":"'.$row[juso].'",  "lat":0, "long":0, "sai":0, "star":'.$star.', "rwsu":'.$su.', "rwgab":'.$allgab.', "gb":'.$row[gubun].'}';
				
				$i++;
	
			}
			$jsongab .= ']}';
			
		}

	
	
	
	
	break;
	case "anzReview":   //나의 리뷰 관리
	
		//나의 리뷰 정보를 가져 온다.
		$rr = mysql_query("select * from soho_AAmyMess where fromid = '".$_GET[memid]."' and  project = '".$_GET[proj]."' order by companyid, id desc ", $rs);
		if(!$rr){
			die("soho_AAmyMess select err".mysql_error());
			$jsongab = '{"companyid":"err"}';
		}else{
			$jsongab = '{"companyid":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				
				$edtinf = "o";   //리뷰 수정 가능 한다.
				
				$sho = $mycon->query("select id, sangho, gubun from soho_Anyting_company where companyid = '".$row[companyid]."' and project = '".$_GET[proj]."' limit 1 ");
				$shrow = mysql_fetch_array($sho);
				
				
				
				//회원의 정보를 출력
				$rr1 = mysql_query("select * from soho_Anyting_memberAdd where memid = '".$_GET[memid]."' and project = '".$_GET[proj]."' limit 1",$rs);
				if(!$rr1) die("soho_Anyting_memberAdd select err".mysql_error());
				$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
				//$tt = change_str($row[message]);
				
				$jsongab .= '{"id":'.$row[id].', "idrec":'.$shrow[id].', "gb":"'.$shrow[gubun].'", "sho":"'.$shrow[sangho].'", "star":'.$row[star].', "edt":"'.$edtinf.'", "pimg":"'.$imgrow[perimg].'", "nam":"'.$imgrow[name].'", "memo":"'.$row[message].'", "day":"'.$row[indate].'" }';
				
				$i++;
	
			}
			$jsongab .= ']}';
			
		}
	
	break;
	case "review":    //리뷰 리스트 출력=======================================

		//리뷰 정보를 가져 온다.
		$rr = mysql_query("select * from soho_AAmyMess where companyid = '".$_GET[comid]."' and project = '".$_GET[proj]."' order by indate desc, id desc ", $rs);
		if(!$rr){
			die("soho_AAmyMess select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
				
				//업체의 마스터 아디이를 구한다.
				$rrm = mysql_query("select masterid from soho_Anyting_company where companyid = '".$_GET[comid]."' and project = '".$_GET[proj]."' limit 1 ", $rs);				
				$rowm = mysql_fetch_array($rrm);
				$edtinf = "n";   //리뷰 수정 불가능
				if($rowm[masterid] == $row[fromid] or $memid == $row[fromid]) $edtinf = "o";   //리뷰 수정 가능 한다.
				
				
				//회원의 정보를 출력
				$rr1 = mysql_query("select * from soho_Anyting_memberAdd where memid = '".$row[fromid]."' and project = '".$_GET[proj]."' limit 1",$rs);
				if(!$rr1) die("soho_Anyting_memberAdd select err".mysql_error());
				$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.
				
				//$tt = change_str($row[message]);
				
				$jsongab .= '{"id":'.$row[id].', "star":'.$row[star].', "edt":"'.$edtinf.'", "pimg":"'.$imgrow[perimg].'", "nam":"'.$imgrow[name].'", "memo":"'.$row[message].'", "day":"'.$row[indate].'" }';
				
				$i++;
	
			}
			$jsongab .= ']}';
			
		}
	
	
	
	break;
	case "rwDel":   //리뷰 삭제
	
		$dd = $mycon->bas_delete("soho_AAmyMess", " id = ".$_GET[rid]."  limit 1");
		$jsongab = '{"rs":"ok"}';
	
	
	break;
	case "linkDel":   //즐겨 찾기 삭제
		$dd = $mycon->bas_delete("soho_Anyting_Mycompany", " id = ".$_GET[rid]."  limit 1");
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "rwEdit":   //리뷰를 수정한다.
	
		//업체의 마스터 아디이를 구한다.
		$rrm = mysql_query("select * from soho_AAmyMess where id = ".$_GET[rid]." and project = '".$_GET[proj]."' limit 1 ", $rs);				
		$row = mysql_fetch_array($rrm);

		//회원의 정보를 출력
		$rr1 = mysql_query("select * from soho_Anyting_memberAdd where memid = '".$row[fromid]."' and project = '".$_GET[proj]."' limit 1",$rs);
		if(!$rr1) die("soho_Anyting_memberAdd select err".mysql_error());
		$imgrow = mysql_fetch_array($rr1);   //이미지 가져온다.

		$jsongab = '{"rs":"ok", "id":'.$row[id].', "star":'.$row[star].', "nam":"'.$imgrow[name].'", "txt":"'.$row[message].'", "comid":"'.$row[companyid].'"}';
	break;
	}

	
	//$jsongab = '{"rs":"ok"}';
	
	
	//$jsongab = '{"companyid":'.$bb.'}';
	$mycon->sql_close();

	echo($jsongab);
?>