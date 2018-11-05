<?
class IsCheck
{
	var $fieldname;
	var $fieldval;

	/*-------------------------------------------------------
	@@ 함수명 : main

	$field		: 필드명
	$val		: 필드값
	-------------------------------------------------------*/
	function main($field,$val){
		$this->fieldname	= $field;
		$this->fieldval		= trim($val);
	}

	/*-------------------------------------------------------
	@@ 함수명 : isSpace

	$string			: 출력할 메세지코드
	$ptstring		: 표시문자
	-------------------------------------------------------*/
	function isSpace($string){
		if(!$this->fieldval || empty($this->fieldval)){
			$ptstring	.= $this->errFdKor($this->fieldname);
			$msg		.= $this->errMsg($string,$ptstring);
			$this->msg_go($msg);
			return false;
		}
	}

	/*-------------------------------------------------------
	@@ 함수명 : isCheck

	## 필수입력항목에 대한 체크하기
	-------------------------------------------------------*/
	function isCheck(){
		
		switch($this->fieldname){
			case(mode) :
				$this->check_empty($this->fieldval);
				$this->check_firsten($this->fieldval);			## 첫문자는 반드시 영문
				$this->check_engnum($this->fieldval);			## 영문+숫자만
				break;
			case(userid) :
				$this->check_empty($this->fieldval);
				break;
			case(username) :
				$this->check_empty($this->fieldval);
				break;
			case(subject) :
				$this->check_empty($this->fieldval);
				$this->check_Filter($this->fieldval);
				break;
			case(content) :
				$this->check_empty($this->fieldval);
				$this->check_Filter($this->fieldval);
				break;
			case(email) :
				$this->check_email($this->fieldval);
				break;
			case(telephone) :
				$this->check_engnum($this->fieldval);
				break;
			case(fileins) :
				$this->check_email($this->fieldval);
				break;
/*
			case(jumin) :
				$this->check_space($this->fieldval);
				$this->check_onlynum($this->fieldval);
				break;
			case(passwd) :
				$this->check_space($this->fieldval);
				$this->check_strlen($this->fieldval,4,14);		## 길이제한
				$this->check_engnum($this->fieldval);			## 영문+숫자만
				break;
			case(email) :
				$this->check_space($this->fieldval);
				$this->check_email($this->fieldval);
				break;
			case(page_block) :
				$this->check_space($this->fieldval);
				$this->check_onlynum($this->fieldval);
				break;
			case(homepy) :
				$this->check_space($this->fieldval);
				$this->check_alpha($this->fieldval);
				break;
*/
			default : 
				break;				
		}
	}

	/*-------------------------------------------------------
	@@ 함수명 : errFdKor();

	## 필드에 따라 이름을 지어준다.
	## 경고창에 사용될 이름명
	-------------------------------------------------------*/
	function errFdKor($string){
		$errmsg = array("userid"		=>"아이디",
						"passwd"		=>"비밀번호",
						"username"		=>"이름",
						"name"			=>"이름",
						"regnum"		=>"주민등록번호",
						"email"			=>"이메일",
						"link"			=>"링크",
						"filewhere"		=>"파일업로드",
						"subject"		=>"제목",
						"content"		=>"내용",
						"telephone"		=>"전화번호"
						);


		while(list($key, $value) = each($errmsg))
		{
			$result .= ($string==$key)? $value :"";
		}
	return $result;
	}

	function Ext_chk($uploadfilename){
		if(eregi("php|php3|html|htm|phtml|com|bat|exe|inc|js|ph|asp|jsp|cgi|pl",$uploadfilename))
		$this->msg_go("업로드가 제한된 파일입니다.");
		return;
	}

	/*-------------------------------------------------------
	@@ 함수명 : check_Filter();

	## 쓰기금지할 단어들을 검색해서 있으면 true
	-------------------------------------------------------*/
	function check_Filter($str){ 
		$filterword="개새끼,십새끼,시팔놈,씨발놈";
		$fil=explode(',',$filterword); 
		
		$filter_str='/('; 
		for($i=0;$i<count($fil);$i++){ 
			if($i>0)$filter_str.='|'; 
			$filter_str.= $fil[$i]; 
		} 

		$filter_str.=')+/'; 
		if(preg_match($filter_str,$str) ) {
			$this->msg_go("사용할수 없는 단어, 문장을 입력하셨습니다.");
			return true; 
		} else {
			return true; 
		}
	} 

	/*-------------------------------------------------------
	@@ 함수명 : check_firsten
	## 첫문자는 반드시 영문이어야 한다.
	-------------------------------------------------------*/
	function check_firsten($val)
	{
		if(!ereg("^[a-zA-Z]","$val")){
			$ptstring	.= $this->errFdKor($this->fieldname);
			$msg		.= $this->errMsg("ERROR_FIRSTSTRING_ENG",$ptstring);
			$this->msg_go($msg);
		}
	}

	/*-------------------------------------------------------
	@@ 함수명 : check_onlynum
	## 숫자만 허용한다.
	-------------------------------------------------------*/
	function check_onlynum($val)
	{
		if(ereg("[^0-9]","$val",$temp)){
			$ptstring	.= $this->errFdKor($this->fieldname);
			$msg		.= $this->errMsg("ERROR_STRING_ONLYNUM",$ptstring);
			$this->msg_go($msg);
		}
	}
	function check_onlynum2($val,$msg)
	{
		if(ereg("[^0-9]","$val",$temp)){
			$ptstring	.= $this->errFdKor($this->fieldname);
//			$msg		.= $this->errMsg("ERROR_STRING_ONLYNUM",$ptstring);
			$this->msg_go($msg);
		}
	}

	/*-------------------------------------------------------
	@@ 함수명 : check_engnum
	## 영문과 숫자만허용
	-------------------------------------------------------*/
	function check_engnum($val)
	{
		if(ereg("[^a-zA-Z0-9]","$val",$temp)){
			$ptstring	.= $this->errFdKor($this->fieldname);
			$msg		.= $this->errMsg("ERROR_STRING_ENGNUM",$ptstring);
			$this->msg_go($msg);
		}
	}

	/*-----------------------------------------------------
	@@함수명: check_hangul
	## $char이 한글인지 체크
	---------------------------------------------------------*/
	function check_hangul($char) {
		// 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
		$char = ord($char);

		if($char >= 0xa1 && $char <= 0xfe) {			
			$char=1;
			if($char<1){
				$ptstring	.= $this->errFdKor($this->fieldname);
				$msg		.= $this->errMsg("ERROR_STRING_KOR",$ptstring);
				$this->msg_go($msg);
			}
		}
	}

	/*-----------------------------------------------------
	@@함수명		: check_alpha
	## 영문인지 체크
	## 반환값		: 2(대문자), 1(소문자), 0(영문아님)
	---------------------------------------------------------*/
	function check_alpha($char) {
		if($char || isset($char))
		{
		
			$char = ord($char);

			if($char >= 0x61 && $char <= 0x7a) $char_val = 1;
			else if($char >= 0x41 && $char <= 0x5a) $char_val = 2;
			else $char_val = 0;

			if($char_val<1){
				$ptstring	.= $this->errFdKor($this->fieldname);
				$msg		.= $this->errMsg("ERROR_BADSTRING_CHECK",$ptstring);
				$this->msg_go($msg);
			}
		}
	}

	/*----------------------------------------------------------
	@@함수명		: check_email
	## $email의 형식이 올바른지 체크한다.
	----------------------------------------------------------*/
	function check_email($val)
	{
		if($val || isset($val))
		{
			if(!eregi("^[a-z0-9_-]+@[a-z0-9-]+\.[a-z0-9-]+", $val)) 
			{
				$ptstring	.= $this->errFdKor($this->fieldname);
				$msg		.= $this->errMsg("ERROR_BADSTRING_CHECK",$ptstring);
				$this->msg_go($msg);
			}
		}
	}

	/*-----------------------------------------------------
	@@함수명	: check_empty
	## 데이타의 공백을 체크한다.
	---------------------------------------------------------*/
	function check_empty($string)
	{
		$string		= trim($string);
		if(strlen($string)==0 || !$string){
			$ptstring	.= $this->errFdKor($this->fieldname);
			$msg		.= $this->errMsg("ERROR_NULL_SPACE",$ptstring);
			$this->msg_go($msg);
		}
	}
	/*-----------------------------------------------------
	@@함수명	: check_space
	## 문자와 문자사이의 공백을 체크한다.
	---------------------------------------------------------*/
	function check_space($string)
	{
		$string		= trim($string);
		$str_split	= split("[[:space:]]+",$string);
		
		for($i=0; $i<sizeof($str_split); $i++)
		{
			if($i>0){
				$ptstring	.= $this->errFdKor($this->fieldname);
				$msg		.= $this->errMsg("ERROR_BETWEEN_SPACE",$ptstring);
				$this->msg_go($msg);
			}
		}
	}
	
	/*-------------------------------------------------------
	@@ 함수명 : check_strlen

	$val	= 값
	$min	= 최소입력값
	$max	= 최대입력값

	## 최소,최대 길이제한
	-------------------------------------------------------*/
	function check_strlen($val,$min,$max)
	{
		if(!((strlen($val)>=$min)&&(strlen($val)<=$max))){
				$ptstring	.= $this->errFdKor($this->fieldname);
				$msg		.= $this->errMsg("ERROR_BETWEEN_MAXMIN",$ptstring,$min,$max);
				$this->msg_go($msg,$this->msgtype);
		}
	}

	/*-------------------------------------------------------
	@@ 함수명 : errMsg();

	$errstring		: 에러코드명
	$ptstring		: 표시문자
	-------------------------------------------------------*/
	function errMsg($errstring,$ptstring,$min="",$max=""){
		$errmsg = array(
						"ERROR_NULL_SPACE"		=>"{$ptstring} 를(을) 입력해 주세요",
						"ERROR_BETWEEN_SPACE"	=>"{$ptstring} 문자와 문자사이의 공백은 허용하지 않습니다.",
						"ERROR_BETWEEN_MAXMIN"	=>"{$ptstring} 최소 {$min} 최대 {$max}자까지 입력해주세요",
						"ERROR_STRING_ENGNUM"	=>"{$ptstring} 영문과 숫자 조합으로 입력해 주세요.",
						"ERROR_STRING_ONLYNUM"	=>"{$ptstring} 숫자만 입력해 주세요.",
						"ERROR_STRING_KOR"		=>"{$ptstring} 한글로 입력해 주세요",
						"ERROR_STRING_MATIC"	=>"{$ptstring} 특수문자는 사용할 수 없습니다.",
						"ERROR_BADSTRING_CHECK"	=>"잘못된 {$ptstring} 형식입니다.",
						"ERROR_FIRSTSTRING_ENG"	=>"{$ptstring} 첫문자는 반드시 영문으로 입력해 주세요"
						);


		while(list($key, $value) = each($errmsg))
		{
			$result .= ($errstring==$key)? $value :"";
		}
	return $result;
	}

	/*--------------------------------------------------------
	함수 이름 :	msg_go()
	함수 인자 :	$msg -> 출력할 메시지

	## 경고창으로 경고메세지를 띄운후 뒤로 back 한다.
	----------------------------------------------------------*/
	function msg_go($msg)
	{
		$go = "history.go(-1);";

		echo " <script> ";
		echo "  window.alert('$msg'); ";
		echo "  $go ";
		echo " </script> ";
		exit;
	}


}
?>