<?
class IsCheck
{
	var $fieldname;
	var $fieldval;

	/*-------------------------------------------------------
	@@ �Լ��� : main

	$field		: �ʵ��
	$val		: �ʵ尪
	-------------------------------------------------------*/
	function main($field,$val){
		$this->fieldname	= $field;
		$this->fieldval		= trim($val);
	}

	/*-------------------------------------------------------
	@@ �Լ��� : isSpace

	$string			: ����� �޼����ڵ�
	$ptstring		: ǥ�ù���
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
	@@ �Լ��� : isCheck

	## �ʼ��Է��׸� ���� üũ�ϱ�
	-------------------------------------------------------*/
	function isCheck(){
		
		switch($this->fieldname){
			case(mode) :
				$this->check_empty($this->fieldval);
				$this->check_firsten($this->fieldval);			## ù���ڴ� �ݵ�� ����
				$this->check_engnum($this->fieldval);			## ����+���ڸ�
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
				$this->check_strlen($this->fieldval,4,14);		## ��������
				$this->check_engnum($this->fieldval);			## ����+���ڸ�
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
	@@ �Լ��� : errFdKor();

	## �ʵ忡 ���� �̸��� �����ش�.
	## ���â�� ���� �̸���
	-------------------------------------------------------*/
	function errFdKor($string){
		$errmsg = array("userid"		=>"���̵�",
						"passwd"		=>"��й�ȣ",
						"username"		=>"�̸�",
						"name"			=>"�̸�",
						"regnum"		=>"�ֹε�Ϲ�ȣ",
						"email"			=>"�̸���",
						"link"			=>"��ũ",
						"filewhere"		=>"���Ͼ��ε�",
						"subject"		=>"����",
						"content"		=>"����",
						"telephone"		=>"��ȭ��ȣ"
						);


		while(list($key, $value) = each($errmsg))
		{
			$result .= ($string==$key)? $value :"";
		}
	return $result;
	}

	function Ext_chk($uploadfilename){
		if(eregi("php|php3|html|htm|phtml|com|bat|exe|inc|js|ph|asp|jsp|cgi|pl",$uploadfilename))
		$this->msg_go("���ε尡 ���ѵ� �����Դϴ�.");
		return;
	}

	/*-------------------------------------------------------
	@@ �Լ��� : check_Filter();

	## ��������� �ܾ���� �˻��ؼ� ������ true
	-------------------------------------------------------*/
	function check_Filter($str){ 
		$filterword="������,�ʻ���,���ȳ�,���߳�";
		$fil=explode(',',$filterword); 
		
		$filter_str='/('; 
		for($i=0;$i<count($fil);$i++){ 
			if($i>0)$filter_str.='|'; 
			$filter_str.= $fil[$i]; 
		} 

		$filter_str.=')+/'; 
		if(preg_match($filter_str,$str) ) {
			$this->msg_go("����Ҽ� ���� �ܾ�, ������ �Է��ϼ̽��ϴ�.");
			return true; 
		} else {
			return true; 
		}
	} 

	/*-------------------------------------------------------
	@@ �Լ��� : check_firsten
	## ù���ڴ� �ݵ�� �����̾�� �Ѵ�.
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
	@@ �Լ��� : check_onlynum
	## ���ڸ� ����Ѵ�.
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
	@@ �Լ��� : check_engnum
	## ������ ���ڸ����
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
	@@�Լ���: check_hangul
	## $char�� �ѱ����� üũ
	---------------------------------------------------------*/
	function check_hangul($char) {
		// Ư�� ���ڰ� �ѱ��� ������(0xA1A1 - 0xFEFE)�� �ִ��� �˻�
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
	@@�Լ���		: check_alpha
	## �������� üũ
	## ��ȯ��		: 2(�빮��), 1(�ҹ���), 0(�����ƴ�)
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
	@@�Լ���		: check_email
	## $email�� ������ �ùٸ��� üũ�Ѵ�.
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
	@@�Լ���	: check_empty
	## ����Ÿ�� ������ üũ�Ѵ�.
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
	@@�Լ���	: check_space
	## ���ڿ� ���ڻ����� ������ üũ�Ѵ�.
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
	@@ �Լ��� : check_strlen

	$val	= ��
	$min	= �ּ��Է°�
	$max	= �ִ��Է°�

	## �ּ�,�ִ� ��������
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
	@@ �Լ��� : errMsg();

	$errstring		: �����ڵ��
	$ptstring		: ǥ�ù���
	-------------------------------------------------------*/
	function errMsg($errstring,$ptstring,$min="",$max=""){
		$errmsg = array(
						"ERROR_NULL_SPACE"		=>"{$ptstring} ��(��) �Է��� �ּ���",
						"ERROR_BETWEEN_SPACE"	=>"{$ptstring} ���ڿ� ���ڻ����� ������ ������� �ʽ��ϴ�.",
						"ERROR_BETWEEN_MAXMIN"	=>"{$ptstring} �ּ� {$min} �ִ� {$max}�ڱ��� �Է����ּ���",
						"ERROR_STRING_ENGNUM"	=>"{$ptstring} ������ ���� �������� �Է��� �ּ���.",
						"ERROR_STRING_ONLYNUM"	=>"{$ptstring} ���ڸ� �Է��� �ּ���.",
						"ERROR_STRING_KOR"		=>"{$ptstring} �ѱ۷� �Է��� �ּ���",
						"ERROR_STRING_MATIC"	=>"{$ptstring} Ư�����ڴ� ����� �� �����ϴ�.",
						"ERROR_BADSTRING_CHECK"	=>"�߸��� {$ptstring} �����Դϴ�.",
						"ERROR_FIRSTSTRING_ENG"	=>"{$ptstring} ù���ڴ� �ݵ�� �������� �Է��� �ּ���"
						);


		while(list($key, $value) = each($errmsg))
		{
			$result .= ($errstring==$key)? $value :"";
		}
	return $result;
	}

	/*--------------------------------------------------------
	�Լ� �̸� :	msg_go()
	�Լ� ���� :	$msg -> ����� �޽���

	## ���â���� ���޼����� ����� �ڷ� back �Ѵ�.
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