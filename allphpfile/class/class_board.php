<?

class BoardFn
{
	
	/*===========================================================================
	@@ �Լ��� : orderBy()

	$val : ��(pdf:�ڷ���, normal:�亯���� ���� ������ �Խ���, ramification:�ٴܴ亯�� �Խ���)
	
	## �����Ҷ� orderBy ������ �Ѱ��� ������ �����Ѵ�.
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
	@@ �Լ��� : nameLink()

	$string : �̸��� / $name : �̸�, �г���, ID
	
	## �̸��� �̸��� �� �ּ� ����
	=============================================================================*/
	function nameLink($string, $name){
		
		// $string�� ���� �ִ��� �Ǻ�
		if($string != ""){ return false; }
		
		// ������ ������
		if($string=="6m") $forday = 180;
		else if($string=="1y") $forday = 365;
		
		$today		= mktime(0,0,0,date(m),date(d),date(Y)) - ($forday*86400);
		$today_date	= date("Y-m-d", $today);

		$result = "(date_format(regdate, '%Y-m-d%') >= $today_date)";
	return $result;
	}

	/*===========================================================================
	@@ �Լ��� : searchDate()

	$string : �ֱ� 6���� :sixmonth, �ֱ�1��:oneyear, ��ü:alldate
	
	## �˻��� �Ⱓ�� �����Ѵ�.
	=============================================================================*/
	function searchDate($string){
		
		// ��ü �˻��̸� �ٷ� ����������.
		if($string=="alldate" || !$string){ return false; }
		
		// ������ ������
		if($string=="6m") $forday = 180;
		else if($string=="1y") $forday = 365;
		
		$today		= mktime(0,0,0,date(m),date(d),date(Y)) - ($forday*86400);
		$today_date	= date("Y-m-d", $today);

		$result = "(date_format(regdate, '%Y-m-d%') >= $today_date)";
	return $result;
	}

	/*===========================================================================
	@@ �Լ��� : replyRe()

	$sort		: �� ����
	$depth		: ���� �и����� ���Ѽ���
	$icon		: �亯���� �˸��� �������̹���
	
	## �� ���� �亯�� ������ ���̿� ���� ������ �� [re]���� �� &nbsp; ���ڸ� �߰��Ѵ�.
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
	@@ �Լ��� : percentage()

	$string	: �����ų���
	$keyword: �˻���
	
	## ã���� �ϴ� ���ڿ��� ��Ȯ��
	## 100%
	=============================================================================*/
	function percentage($string,$keyword){
		
			$result .= similar_text($string,$keyword,&$p);
	
	return $result;
	}

	/*===========================================================================
	@@ �Լ��� : fontColor()

	$string	: �����ų���
	$color	: ���õ�Į��
	$arr	: Į��迭
	
	## ���ڿ� Į�� �����Ѵ�.

	ã���� �ϴ� ���ڿ��� ��Ȯ��
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
	@@ �Լ���	: fontKeyColor
	 
	$val		: �˻��ʵ��� ����
	$keywords	: �˻���

	## ���� ���� [ ]�� �������� 3������ �˻��� �ȴ�.
	===============================================================================================*/
	function fontKeyColor($keywords,$val,$type="red") 
	{
		if(!$keywords){ return false; }		
		
		$keywords = urldecode($keywords);
		$keywords = trim($keywords);
		$keywords = ereg_replace("([ ]+)"," ",$keywords);

		if(!ereg(" ",$keywords)) $KeyWords = "$keywords";		## Ű���尡 1���϶�
		else $KeyWords = explode(" ",$keywords);				## Ű���尡 �����϶�

		$count = count($KeyWords);								## Ű���� ī��Ʈ
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
	@@ �Լ��� : newIcon()

	$forday	: �������� ��½����� �Ⱓ
	$regdate	: �����
	$icon		: �����ų������
	
	## �� ������ ����
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
	@@ �Լ��� : hidden()

	$val		: ���� ��
	$hidden		: ��������� �ƴ���
	$adminlevel	: ������ ���
	$icon		: ������
	$level		: �����س��� ���
	
	## �� ������ ����
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
//���� �ڸ���
function getTitle($title,$trim)
{
	$title = stripslashes($title);
	$title_len=strlen($title);
	$trim_len=strlen(substr($title,0,$trim));//���ڿ��� �ڸ�
	echo substr($title,0,$trim);
	if($title_len > $trim_len){//���� ���ڿ��� �ڸ� ���ڿ����� ������ �ڸ��� ����
		for($jj=0;$jj < $trim_len;$jj++){
			$uu=ord(substr($title, $jj, 1));
			if( $uu > 127 ){//127���� ũ�� �ѱ۷� �����Ͽ� 2����Ʈ�� �ڸ�
				$jj++;
			}
		}
		$title=substr($title,0,$jj);
		$title="$title"."��";
	}
	
	//addslashes() �Լ��� escape�� ������ ���ڿ��� ���󺹱ͽ�Ų��.
    $title = stripslashes($title);
    
	//��Ģ�� ���񿡴� HTML �±׸� ������� �ʴ´�.
    $title = htmlspecialchars($title);

	return $title;
}

	/*===========================================================================
	@@ �Լ��� : cutString()

	$str	: ���ڿ�
	$len	: �ڸ� ����
	
	## $len�� ���̷� $str�̶�� ���ڿ��� �ڸ���.
	## �ѱ��� �ѹ���Ʈ ������ �߸��� ��츦 ���� �빮�ڰ� ���� ���� ���
	   �ҹ��ڿ��� ũ�� ���� ����(1.5?)�� ���� ���ڿ��� �ڸ�
	=============================================================================*/
	function cutString($str, $len)
	{
		$ori_len = strlen($str);
		##	�Ѿ�� ���ڿ��� �ڸ����� �ͺ��� �۰ų� 1�����̸� ����
		if(strlen($str) <= $len && !eregi("^[a-z]+$", $str))    
			return $str;  

		for($i = $len; $i >=1; $i--) 
		{      
			# ���������� �ѱ� byte���� ����.      
			if($this->check_hangul($str[$i-1]))
				$hangul++;      
			else 
				break;
		}    

		if ($hangul)
		{     
			# byte���� Ȧ���̸�, �ѱ��� ù��° ����Ʈ�̴�.      
			# �ѱ��� ù��° ����Ʈ�� �� ������ ���� ���� ���� ������ ���̸� �� ����Ʈ ����      
			if ($hangul%2) 
				$len--;            
			
			$str = chop(substr($str, 0, $len));  

			return $str."...";
		} 
		else 
		{ 
			# ���ڿ��� ���� �ѱ��� �ƴ� ���      
			for($i = 1; $i <= $len; $i++) 
			{          
				# �빮���� ������ ���          
				if($this->check_alpha($str[$i-1]) == 2)	$alpha++;

				# ������ �ѱ��� ��Ÿ�� ��ġ ���       
				if($this->check_hangul($str[$i-1]))	$last_han=$i;      

			}            
			# ������ ���̷� ���ڿ��� �ڸ��� ���ڿ� ���� ���� ���ڸ� ������      
			# �빮���� ���̴� 1.3���� ����Ѵ�. ���ڿ� �������� ���� ���ڿ���       
			# ������ ��ü ���̺��� ũ�� �ʰ��� ��ŭ ����.      
			$capitals = intval($alpha * 0.5);      
			if ( ($len-$last_han) <= $capitals) $capitals=0;      
			
			$str = chop(substr($str, 0, $len - $capitals)); 
			$srt = $str;

		}  
		if($ori_len > $len)	return $str."...";
		else return $str;
	}

	/*===========================================================================
	@@ �Լ��� : autoLink()

	$str	: ���ڿ�
	
	## $str�� ���� �ڵ����� ��ũ�� �����ش�.
	=============================================================================*/
	function autoLink($str,$type=0) {
	  global $color;

	  $regex[http] = "(http|https|ftp|telnet|news):\/\/([a-z0-9_\-]+\.[][a-zA-Z0-9:;&#@=_~%\?\/\.\,\+\-]+)";
	  $regex[mail] = "([a-z0-9_\-]+)@([a-z0-9_\-]+\.[a-z0-9\._\-]+)";

	  if ($type==1){
		  if (ereg("^http://",$str) || ereg("^ftp://",$str)) return "<a href='$str' target='_blank'>$str</a>";
		  else return "<a href='http://$str' target='_blank'>$str</a>";
	  }

	  // < �� ���� �±װ� �� �ٿ��� ������ ���� ��� nl2br()���� <BR> �±װ�
	  // �پ� ������ ������ ���� ���� ���� �ٱ��� �˻��Ͽ� �̾���
	  $str = eregi_replace("<([^<>\n]+)\n([^\n<>]+)>", "<\\1 \\2>", $str);

	  // Ư�� ���ڿ� ��ũ�� target ����
	  $str = eregi_replace("&(quot|gt|lt)","!\\1",$str);
	  $str = eregi_replace("([ ]*)target=[\"'_a-z,A-Z]+","", $str);
	  $str = eregi_replace("([ ]+)on([a-z]+)=[\"'_a-z,A-Z\?\.\-_\/()]+","", $str);

	  // html���� link ��ȣ
	  $str = eregi_replace("<a([ ]+)href=([\"']*)($regex[http])([\"']*)>","<a href=\"\\4_orig://\\5\" target=\"_blank\">", $str);
	  $str = eregi_replace("<a([ ]+)href=([\"']*)mailto:($regex[mail])([\"']*)>","<a href=\"mailto:\\4#-#\\5\">", $str);
	  $str = eregi_replace("<img([ ]*)src=([\"']*)($regex[http])([\"']*)","<img src=\"\\4_orig://\\5\"",$str);

	  // ��ũ�� �ȵ� url�� email address �ڵ���ũ
	  $str = eregi_replace("($regex[http])","<a href=\"\\1\" target=\"_blank\">\\1</a>", $str);
	  $str = eregi_replace("($regex[mail])","<a href=\"mailto:\\1\">\\1</a>", $str);

	  // ��ȣ�� ���� ġȯ�� �͵��� ���� 
	  $str = eregi_replace("!(quot|gt|lt)","&\\1",$str);
	  $str = eregi_replace("http_orig","http", $str);
	  $str = eregi_replace("#-#","@",$str);

	  // link�� 2�� �������� �̸� �ϳ��� �ٿ���
	  $str = eregi_replace("(<a href=([\"']*)($regex[http])([\"']*)+([^>]*)>)+<a href=([\"']*)($regex[http])([\"']*)+([^>]*)>","\\1", $str);
	  $str = eregi_replace("(<a href=([\"']*)mailto:($regex[mail])([\"']*)>)+<a href=([\"']*)mailto:($regex[mail])([\"']*)>","\\1", $str);
	  $str = eregi_replace("</a></a>","</a>",$str);

	return $str;
	}

	/*===========================================================================
	@@ �Լ��� : replaceUrl()

	$url : URL
	
	## $type�� �°� URL�� ��ȯ�Ѵ�. 
	## $type=1 �� ��� -> URL�տ� http:// �� ���̴�.
	## $type=0 �� ��� -> URL�տ� http:// �� ���ش�.
	=============================================================================*/
	function replaceUrl($url, $type=1)
	{
		$url = trim($url);

		##	�⺻������ �Ѿ�� URL�� ���������� ��Ÿ���� �κ��� �ִ��� Ȯ���Ͽ� http:// �� ���δ�.
		if(!eregi("^(http://|https://|ftp://|telnet://|news://)", $url)) {
			$url = eregi_replace("^", "http://", $url);
		}
		
		$url = eregi_replace("http.*://", "", $url);

		##	�Ѿ�� $type �� ���� URL ����
		$url = $type ? eregi_replace("^", "http://", $url) : $url;

	return $url;
	}

	/*===========================================================================
	@@ �Լ��� : download()

	$url	: ���ϰ��
	$table	: ���̺��
	$field	: �ʵ�
	$where	: ���ǹ�
	
	## ������ �ٿ�ε� ���� �� �ֵ��� �Ѵ�.
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
	@�Լ��� : filePrint

	$filesrc	= ���ϰ��
	$realfile	= ������ Ŭ���� ���� ���ϰ��
	$filename	= ���ϸ�
	$type		= 1:image, 2:file
	$wsize		= �̹��� ����ũ��
	$hsize		= �̹��� ����ũ��
	$name		= �̹�����
	$is_file	= ���� ������ ������

	## GetImageSize �̹��� ����� �˾Ƴ��� ����
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
				$width		= $img_size[0];		## �̹����� ���̸� �� �� ����
				$height		= $img_size[1];		## �̹����� ���̸� �� �� ����
				$image_type = $img_size[2];		## �̹����� type�� �� �� ����
				
				## ����
				if($width > $wsize){
					$w = $wsize;
				}else {
					$w = $width;
				}
				
				## ����
				if($height > $hsize){
					$h = $hsize;
				}else {
					$h = $height;
				}

				
				$result .=("<img src='$filewhere' border='0' width='$w' height='$h' hspace='5' vspace='5' NAME='$name'");
			}
		}else {

			// ���� ���Ŀ� �´� ������ ���
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
	@@�Լ���		: check_hangul

	$char	: ��
	
	## $char�� �ѱ����� üũ
	---------------------------------------------------------*/
	function check_hangul($char) {
		// Ư�� ���ڰ� �ѱ��� ������(0xA1A1 - 0xFEFE)�� �ִ��� �˻�
		$char = ord($char);

		if($char >= 0xa1 && $char <= 0xfe) {
	    return 1;
	}

	return;
	}

	/*-----------------------------------------------------
	@@�Լ���		: check_alpha

	$char	: ��
	
	## �������� üũ
	## ��ȯ��		: 2(�빮��), 1(�ҹ���), 0(�����ƴ�)
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
	@@ �Լ��� : replaceString()

	$content	: ����
	$type		: TEXT/HTML/HTML+TEXT
	
	## $type�� ���߾� $content�� ���� �����Ų��.
	=============================================================================*/
	function replace_string($content, $type="TEXT") 
	{
		// $type�� �빮�ڷ���ȯ
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
	@@�Լ���		: cmtCompose

	$num		: ���� ��
	$sideChr	: ���� �� ���̵� ����
	$fontColor	: ���� ���� ����
	$img		: �̹���
	
	## ��� ���� : �����̹��� (3)
	## ������ ����, �̹��� ����
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