<?

class BoardFn
{
	
	/*===========================================================================
	@@ 함수명 : orderBy()

	$val : 값(pdf:자료형, normal:답변글이 없는 형태의 게시판, ramification:다단답변형 게시판)
	
	## 쿼리할때 orderBy 다음에 넘겨줄 문장을 결정한다.
	=============================================================================*/
	function orderBy($val){
		
		switch($val){
			
			case(multi) :
				$result	.= "gnum DESC,idx";
				break;

			case(thread) :
				$result	.= "gnum DESC,idx";
				break;

			case(pds) :
				$result	.= "uid DESC";
				break;

			case(notice) :
				$result	.= "uid DESC";
				break;
			
			default : 
				$result .= "$val";
		}
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : nameLink()

	$string : 이메일 / $name : 이름, 닉네임, ID
	
	## 이름에 이메일 및 주소 연결
	=============================================================================*/
	function nameLink($string, $name){
		
		// $string에 값이 있는지 판별
		if($string != ""){ return false; }
		
		// 조건이 있을때
		if($string=="6m") $forday = 180;
		else if($string=="1y") $forday = 365;
		
		$today		= mktime(0,0,0,date(m),date(d),date(Y)) - ($forday*86400);
		$today_date	= date("Y-m-d", $today);

		$result = "(date_format(regdate, '%Y-m-d%') >= $today_date)";
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : searchDate()

	$string : 최근 6개월 :sixmonth, 최근1년:oneyear, 전체:alldate
	
	## 검색할 기간을 설정한다.
	=============================================================================*/
	function searchDate($string){
		
		// 전체 검색이면 바로 빠져나간다.
		if($string=="alldate" || !$string){ return false; }
		
		// 조건이 있을때
		if($string=="6m") $forday = 180;
		else if($string=="1y") $forday = 365;
		
		$today		= mktime(0,0,0,date(m),date(d),date(Y)) - ($forday*86400);
		$today_date	= date("Y-m-d", $today);

		$result = "(date_format(regdate, '%Y-m-d%') >= $today_date)";
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : replyRe()

	$sort		: 글 깊이
	$depth		: 리플 밀림정도 제한숫자
	$icon		: 답변임을 알리는 아이콘이미지
	
	## 이 글의 답변이 쓰여진 깊이에 따라 아이콘 및 [re]문자 및 &nbsp; 문자를 추가한다.
	=============================================================================*/
	function replyRe($sort,$depth,$icon="",$font="#CC6600"){

		if($sort<1 || $sort==0) { return false; }
		
		// sort > 0
		if($sort < $depth)
		{
			for ($i=1; $i<=$sort; $i++)
			{
				$rlt .= "&nbsp;&nbsp;";
			}
			$result = $rlt.$icon."<font color=$font>[Re]</font>";
		}
		else {
			for ($i=1; $i<= $depth; $i++)
			{
				$rlt .="&nbsp;&nbsp;";
			}
			$result = $rlt.$icon."<font color=$font>[Re]</font>";
		}	
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : percentage()

	$string	: 적용시킬대상
	$keyword: 검색어
	
	## 찾고자 하는 문자와의 정확도
	## 100%
	=============================================================================*/
	function percentage($string,$keyword){
		
			$result .= similar_text($string,$keyword,&$p);
	
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : fontColor()

	$string	: 적용시킬대상
	$color	: 선택된칼라
	$arr	: 칼라배열
	
	## 문자에 칼라를 적용한다.

	찾고자 하는 문자와의 정확도
	$i = similar_text($list[subject],$keyword,&$p);
	$percent = " ($p%)";
	=============================================================================*/
	function fontColor($color,$string){
		
			if($color || isset($color)){
				$result .= "<font color='$color'>$string</font>";
			}else {
				$result .= "<font color='#666666'>$string</font>";
			}
	
	return $result;
	}

	/*=============================================================================================
	@@ 함수명	: fontKeyColor
	 
	$val		: 검색필드의 내용
	$keywords	: 검색어

	## 현재 공백 [ ]를 기준으로 3개까지 검색이 된다.
	===============================================================================================*/
	function fontKeyColor($keywords,$val,$type="red") 
	{
		if(!$keywords){ return false; }		
		
		$keywords = urldecode($keywords);
		$keywords = trim($keywords);
		$keywords = ereg_replace("([ ]+)"," ",$keywords);

		if(!ereg(" ",$keywords)) $KeyWords = "$keywords";		## 키워드가 1개일때
		else $KeyWords = explode(" ",$keywords);				## 키워드가 복수일때

		$count = count($KeyWords);								## 키워드 카운트
		if($type) {
			$font1 = "<font color='$type'>";
			$font2 = "</font>";
		}else{
			$font1= ""; $font2="";
		}
		if($count==1)
		{
			$result= str_replace("$KeyWords", "$font1<b>$KeyWords</b>$font2", $val);
		}else {
			
			$rt = str_replace("$KeyWords[0]","$font1<b>$KeyWords[0]</b>$font2", $val);
			$rt = str_replace("$KeyWords[1]","$font1<b>$KeyWords[1]</b>$font2", $rt);
			$rt = str_replace("$KeyWords[2]","$font1<b>$KeyWords[2]</b>$font2", $rt);
			$result = str_replace("$KeyWords[3]","$font1<b>$KeyWords[3]</b>$font2", $rt);

		}

	return $result;
	}


	/*===========================================================================
	@@ 함수명 : newIcon()

	$forday	: 아이콘을 출력시켜줄 기간
	$regdate	: 등록일
	$icon		: 적용시킬아이콘
	
	## 뉴 아이콘 적용
	=============================================================================*/
	function newIcon($forday,$regdate,$icon)
	{
		$rgdate		= str_replace(" ","-",$regdate);
		$value		= str_replace(":","-",$rgdate);
		$re_value	= explode("-",$value);

		$date_num	= mktime($re_value[3],$re_value[4],$re_value[5],$re_value[1],$re_value[2],$re_value[0]);
		$today		= mktime(0,0,0,date(m),date(d),date(Y)) - ($forday*86400);
		
		if($date_num<=$today) $result .= "";
		else $result .= $icon;
	
	return $result;
	}

	/*===========================================================================
	@@ 함수명 : hidden()

	$val		: 감출 값
	$hidden		: 감출것인지 아닌지
	$adminlevel	: 관리자 등급
	$icon		: 아이콘
	$level		: 설정해놓은 등급
	
	## 뉴 아이콘 적용
	=============================================================================*/
	function hidden($val,$hidden,$adminlevel,$level,$icon)
	{
		if($hidden>0 && $level<$adminlevel)
		{
			$result .= $icon;
		}
		else{
			$autolink = $this->autoLink($val);
			$result = $autolink;
		}
	return $result;
	}
//제목 자르기
function getTitle($title,$trim)
{
	$title = stripslashes($title);
	$title_len=strlen($title);
	$trim_len=strlen(substr($title,0,$trim));//문자열을 자름
	echo substr($title,0,$trim);
	if($title_len > $trim_len){//만약 문자열이 자를 문자열보다 작으면 자르지 않음
		for($jj=0;$jj < $trim_len;$jj++){
			$uu=ord(substr($title, $jj, 1));
			if( $uu > 127 ){//127보다 크면 한글로 가준하여 2바이트씩 자름
				$jj++;
			}
		}
		$title=substr($title,0,$jj);
		$title="$title"."…";
	}
	
	//addslashes() 함수로 escape된 제목의 문자열을 원상복귀시킨다.
    $title = stripslashes($title);
    
	//원칙상 제목에는 HTML 태그를 허용하지 않는다.
    $title = htmlspecialchars($title);

	return $title;
}

	/*===========================================================================
	@@ 함수명 : cutString()

	$str	: 문자열
	$len	: 자를 길이
	
	## $len의 길이로 $str이라는 문자열을 자른다.
	## 한글을 한바이트 단위로 잘르는 경우를 막고 대문자가 많이 쓰인 경우
	   소문자와의 크기 비율 정도(1.5?)에 따라 문자열을 자름
	=============================================================================*/
	function cutString($str, $len)
	{
		$ori_len = strlen($str);
		##	넘어온 문자열이 자를려는 것보다 작거나 1글자이면 리턴
		if(strlen($str) <= $len && !eregi("^[a-z]+$", $str))    
			return $str;  

		for($i = $len; $i >=1; $i--) 
		{      
			# 끝에서부터 한글 byte수를 센다.      
			if($this->check_hangul($str[$i-1]))
				$hangul++;      
			else 
				break;
		}    

		if ($hangul)
		{     
			# byte수가 홀수이면, 한글의 첫번째 바이트이다.      
			# 한글의 첫번째 바이트일 때 깨지는 것을 막기 위해 지정된 길이를 한 바이트 줄임      
			if ($hangul%2) 
				$len--;            
			
			$str = chop(substr($str, 0, $len));  

			return $str."...";
		} 
		else 
		{ 
			# 문자열의 끝이 한글이 아닐 경우      
			for($i = 1; $i <= $len; $i++) 
			{          
				# 대문자의 갯수를 기록          
				if($this->check_alpha($str[$i-1]) == 2)	$alpha++;

				# 마지막 한글이 나타난 위치 기록       
				if($this->check_hangul($str[$i-1]))	$last_han=$i;      

			}            
			# 지정된 길이로 문자열을 자르고 문자열 끝의 공백 문자를 삭제함      
			# 대문자의 길이는 1.3으로 계산한다. 문자열 마지막의 영문 문자열이       
			# 빼야할 전체 길이보다 크면 초과된 만큼 뺀다.      
			$capitals = intval($alpha * 0.5);      
			if ( ($len-$last_han) <= $capitals) $capitals=0;      
			
			$str = chop(substr($str, 0, $len - $capitals)); 
			$srt = $str;

		}  
		if($ori_len > $len)	return $str."...";
		else return $str;
	}

	/*===========================================================================
	@@ 함수명 : autoLink()

	$str	: 문자열
	
	## $str의 값에 자동으로 링크를 시켜준다.
	=============================================================================*/
	function autoLink($str,$type=0) {
	  global $color;

	  $regex[http] = "(http|https|ftp|telnet|news):\/\/([a-z0-9_\-]+\.[][a-zA-Z0-9:;&#@=_~%\?\/\.\,\+\-]+)";
	  $regex[mail] = "([a-z0-9_\-]+)@([a-z0-9_\-]+\.[a-z0-9\._\-]+)";

	  if ($type==1){
		  if (ereg("^http://",$str) || ereg("^ftp://",$str)) return "<a href='$str' target='_blank'>$str</a>";
		  else return "<a href='http://$str' target='_blank'>$str</a>";
	  }

	  // < 로 열린 태그가 그 줄에서 닫히지 않을 경우 nl2br()에서 <BR> 태그가
	  // 붙어 깨지는 문제를 막기 위해 다음 줄까지 검사하여 이어줌
	  $str = eregi_replace("<([^<>\n]+)\n([^\n<>]+)>", "<\\1 \\2>", $str);

	  // 특수 문자와 링크시 target 삭제
	  $str = eregi_replace("&(quot|gt|lt)","!\\1",$str);
	  $str = eregi_replace("([ ]*)target=[\"'_a-z,A-Z]+","", $str);
	  $str = eregi_replace("([ ]+)on([a-z]+)=[\"'_a-z,A-Z\?\.\-_\/()]+","", $str);

	  // html사용시 link 보호
	  $str = eregi_replace("<a([ ]+)href=([\"']*)($regex[http])([\"']*)>","<a href=\"\\4_orig://\\5\" target=\"_blank\">", $str);
	  $str = eregi_replace("<a([ ]+)href=([\"']*)mailto:($regex[mail])([\"']*)>","<a href=\"mailto:\\4#-#\\5\">", $str);
	  $str = eregi_replace("<img([ ]*)src=([\"']*)($regex[http])([\"']*)","<img src=\"\\4_orig://\\5\"",$str);

	  // 링크가 안된 url및 email address 자동링크
	  $str = eregi_replace("($regex[http])","<a href=\"\\1\" target=\"_blank\">\\1</a>", $str);
	  $str = eregi_replace("($regex[mail])","<a href=\"mailto:\\1\">\\1</a>", $str);

	  // 보호를 위해 치환한 것들을 복구 
	  $str = eregi_replace("!(quot|gt|lt)","&\\1",$str);
	  $str = eregi_replace("http_orig","http", $str);
	  $str = eregi_replace("#-#","@",$str);

	  // link가 2개 겹쳤을때 이를 하나로 줄여줌
	  $str = eregi_replace("(<a href=([\"']*)($regex[http])([\"']*)+([^>]*)>)+<a href=([\"']*)($regex[http])([\"']*)+([^>]*)>","\\1", $str);
	  $str = eregi_replace("(<a href=([\"']*)mailto:($regex[mail])([\"']*)>)+<a href=([\"']*)mailto:($regex[mail])([\"']*)>","\\1", $str);
	  $str = eregi_replace("</a></a>","</a>",$str);

	return $str;
	}

	/*===========================================================================
	@@ 함수명 : replaceUrl()

	$url : URL
	
	## $type에 맞게 URL을 변환한다. 
	## $type=1 일 경우 -> URL앞에 http:// 를 붙이다.
	## $type=0 일 경우 -> URL앞에 http:// 를 없앤다.
	=============================================================================*/
	function replaceUrl($url, $type=1)
	{
		$url = trim($url);

		##	기본적으로 넘어온 URL에 프로토콜을 나타내는 부분이 있는지 확인하여 http:// 를 붙인다.
		if(!eregi("^(http://|https://|ftp://|telnet://|news://)", $url)) {
			$url = eregi_replace("^", "http://", $url);
		}
		
		$url = eregi_replace("http.*://", "", $url);

		##	넘어온 $type 에 따라서 URL 변경
		$url = $type ? eregi_replace("^", "http://", $url) : $url;

	return $url;
	}

	/*===========================================================================
	@@ 함수명 : download()

	$url	: 파일경로
	$table	: 테이블명
	$field	: 필드
	$where	: 조건문
	
	## 파일을 다운로드 받을 수 있도록 한다.
	=============================================================================*/
	function download($table,$field,$where,$url)
	{
		if(!$qry = mysql_query("SELECT $field FROM $table $where")){
			
			if((!$qry) OR (empty($qry))){ 
			@mysql_free_result($qry);
			return false;
			}
		}

		$lt = @mysql_fetch_array($qry);

		$file = $url."/".$lt[$field];
		
		
		header("Content-type:application/octet-stream");
		Header("Content-Disposition:attachment;filename=".$lt[$field]."");
		header("Content-Transfer-Encoding:binary");
		header("Pragma:no-cache");
		header("Expires:0");

		if(is_file($file)) $fp=fopen($file,"r");
		if(!fpassthru($fp)) fclose($fp);
		
		exit();
	} 

	/*========================================================================
	@함수명 : filePrint

	$filesrc	= 파일경로
	$realfile	= 아이콘 클릭시 사용될 파일경로
	$filename	= 파일명
	$type		= 1:image, 2:file
	$wsize		= 이미지 가로크기
	$hsize		= 이미지 세로크기
	$name		= 이미지명
	$is_file	= 실제 서버측 절대경로

	## GetImageSize 이미지 사이즈를 알아내는 것임
	=======================================================================*/
	function filePrint($filesrc,$filename,$wsize,$hsize,$type=1,$name="",$is_file="",$realfile="")
	{
		if(!$filename || !is_file("$is_file/$filename")) { return false; }
		
		$filewhere  = $filesrc.$filename;
		$file		= explode(".",$filename);
		$extention	= strtolower($file[1]);
		
		if($type==1)
		{
			if($extention=="swf")
			{
				$result .="<embed src='$filewhere' menu=false quality=high width=$wsize TYPE=application/x-shockwave-flash></embed>";
			}else if($extention=="gif" || $extention=="jpeg" || $extention=="jpg" || $extention=="png"){
				
				$img_size	= GetImageSize($filewhere);
				$width		= $img_size[0];		## 이미지의 넓이를 알 수 있음
				$height		= $img_size[1];		## 이미지의 높이를 알 수 있음
				$image_type = $img_size[2];		## 이미지의 type를 알 수 있음
				
				## 넓이
				if($width > $wsize){
					$w = $wsize;
				}else {
					$w = $width;
				}
				
				## 높이
				if($height > $hsize){
					$h = $hsize;
				}else {
					$h = $height;
				}

				
				$result .=("<img src='$filewhere' border='0' width='$w' height='$h' hspace='5' vspace='5' NAME='$name'");
			}
		}else {

			// 파일 형식에 맞는 아이콘 출력
			switch($extention){
				case(gif) :
					$rlt .= "<img src='".$filesrc."icon_gif.gif' border='0'>";
					break;
				case(jpg) :
					$rlt .= "<img src='".$filesrc."icon_jpg.gif' border='0'>";
					break;
				case(jpeg) :
					$rlt .= "<img src='".$filesrc."icon_jpeg.gif' border='0'>";
					break;
				case(swf) :
					$rlt .= "<img src='".$filesrc."icon_swf.gif' border='0'>";
					break;
				case(hwp) :
					$rlt .= "<img src='".$filesrc."icon_hwp.gif' border='0'>";
					break;
				case(txt) :
					$rlt .= "<img src='".$filesrc."icon_txt.gif' border='0'>";
					break;
				case(doc) :
					$rlt .= "<img src='".$filesrc."icon_doc.gif' border='0'>";
					break;
				case(xls) :
					$rlt .= "<img src='".$filesrc."icon_xls.gif' border='0'>";
					break;
				case(ppt) :
					$rlt .= "<img src='".$filesrc."icon_ppt.gif' border='0'>";
					break;
				case(pdf) :
					$rlt .= "<img src='".$filesrc."icon_pdf.gif' border='0'>";
					break;
				default : 
					$rlt .= "<img src='".$filesrc."icon_zip.gif' border='0'>";
			}
		
		if($realfile) $result .= "<a href='".$realfile.$filename."' target='blink'>".$rlt."</a>";
		else $result .= $rlt;
				
		}
	return $result;
	}

	/*-----------------------------------------------------
	@@함수명		: check_hangul

	$char	: 값
	
	## $char이 한글인지 체크
	---------------------------------------------------------*/
	function check_hangul($char) {
		// 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
		$char = ord($char);

		if($char >= 0xa1 && $char <= 0xfe) {
	    return 1;
	}

	return;
	}

	/*-----------------------------------------------------
	@@함수명		: check_alpha

	$char	: 값
	
	## 영문인지 체크
	## 반환값		: 2(대문자), 1(소문자), 0(영문아님)
	---------------------------------------------------------*/
	function check_alpha($char) {
		$char = ord($char);

		if($char >= 0x61 && $char <= 0x7a) {
			return 1;
		}
		if($char >= 0x41 && $char <= 0x5a) {
			return 2;
		}

	return;
	}

	/*===========================================================================
	@@ 함수명 : replaceString()

	$content	: 내용
	$type		: TEXT/HTML/HTML+TEXT
	
	## $type에 맞추어 $content의 값을 변경시킨다.
	=============================================================================*/
	function replace_string($content, $type="TEXT") 
	{
		// $type를 대문자로전환
		$type = strtoupper($type);

		if($type=="TEXT") {
			$content = stripslashes($content);
			$content = htmlspecialchars($content);
			$content = eregi_replace("\r\n", "\n", $content);
			$content = eregi_replace("\n", "<br>", $content);
			$content = $this->autoLink($content);
		}
		elseif($type=="HTML") {
			$content = stripslashes($content);
			$content = ereg_replace("\"","", $content);
			$content = ereg_replace("\'","", $content);
			$content = ereg_replace("<\?", "&lt;?", $content);
			$content = ereg_replace("\?>", "?&gt;", $content);
			$content = ereg_replace("<\%", "&lt;%", $content);
			$content = ereg_replace("\%>", "%&gt;", $content);
			$content = ereg_replace("<(script)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("<\(script)>", "&lt;/\\1&gt;", $content);
			$content = ereg_replace("<(XMP)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("</(XMP)>", "&lt;/\\1&gt;", $content);
			$content = ereg_replace("<(PRE)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("</(PRE)>", "&lt;/\\1&gt;", $content);
		}
		elseif($type=="HTML+TEXT"){
			$content = stripslashes($content);
			$content = eregi_replace("\r\n", "\n", $content);
			$content = eregi_replace("\n", "<br>", $content);
			$content = ereg_replace("\"","", $content);
			$content = ereg_replace("\'","", $content);
			$content = ereg_replace("<\?", "&lt;?", $content);
			$content = ereg_replace("\?>", "?&gt;", $content);
			$content = ereg_replace("<\%", "&lt;%", $content);
			$content = ereg_replace("\%>", "%&gt;", $content);
			$content = ereg_replace("<(SCRIPT)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("<\(SCRIPT)>", "&lt;/\\1&gt;", $content);
			$content = ereg_replace("<(XMP)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("</(XMP)>", "&lt;/\\1&gt;", $content);
			$content = ereg_replace("<(PRE)(^>]*)>", "&lt;\\1\\2&gt;", $content);
			$content = ereg_replace("</(PRE)>", "&lt;/\\1&gt;", $content);
		}

	return $content;
	}

	/*-----------------------------------------------------
	@@함수명		: cmtCompose

	$num		: 덧말 수
	$sideChr	: 덧말 양 사이드 문자
	$fontColor	: 덧말 글자 색깔
	$img		: 이미지
	
	## 출력 형식 : 덧말이미지 (3)
	## 덧말의 색깔, 이미지 적용
	---------------------------------------------------------*/
	function cmtCompose($num, $img="", $sidechr="(", $fontColor="red") {
		switch ($sidechr) {
			case "(" :
				$sc1 = "(";
				$sc2 = ")";
				break;
			case "{" :
				$sc1 = "{";
				$sc2 = "}";
				break;
			case "[" :
				$sc1 = "[";
				$sc2 = "]";
				break;
			default :
				$sc1 = $sidechr;
				$sc2 = $sidechr;
				break;
		}
		if ($num>0){
			$result = $img;
			if ($fontColor!="") $result .= " <b><font color='$fontColor' size=-1>{$sc1}{$num}{$sc2}</font></b>";
			else $result .= " {$sc1}{$num}{$sc2}";
		}else $result = "";

		return $result;
	}

}
?>