<?php

////////////////////////////////////////////////////////////////
// SMTP 프로토콜을 Class로 구현한 PHP 파일
//	(Multl-Part 기능 지원)
//
// Multi-Part Mail 클래스에는 다음과 같은 4개의 메소드 들이 있다.
//	NewHeader() : 편지의 Header를 구성한다.
//	AddBody() : 편지에 본문을 추가한다.
//	EndMultiPart() : MultiPart 편지일 경우 본문의 끝임을 추가한다.
//	SendMail() : 편지를 보낸다.
//
// 하나의 본문을 포함한 편지를 보낼 경우
//	NewHeader() -> AddBody() -> SendMail()
// 순으로 호출하며
// 두개 이상의 본문을 포함한 편지를 보낼 경우
//	NewHeader() -> AddBody() -> .... -> EndMultiPart() -> SendMail()
// 순으로 호출한다.
// NewHeader() 의 마지막 인자로서 Multi-Part 기능을 사용할 것인지
// 아닌지를 결정하며 Multi-Part 기능을 사용할 때는 필요한 본문 수 만큼
// AddBody() 를 호출하여 본문을 추가하며 마지막 본문을 추가한 다음에는
// 반드시 EndMultiPart() 를 호출하여야 한다.
// 또한 SendMail() 은 여러번 호출할 수 있다. (여러명에게 보낼 수 있다.)
//

// Multi-Part 의 구분을 위한 문자열
$boundary = "Boundary of PHP SendMail Client" ;
$delimiter = "--$boundary\n" ;
$close_delimiter = "--$boundary--\n" ;

// Multi-Part Mail 클래스
class	MailSend
{
	var	$Title ;		// 편지 제목을 기억
	var	$Header ;		// 편지의 제목을 제외한 주소 정보
	var	$Body ;			// 편지의 내용
	var	$Type ;			// html 사용유무
	var	$Multipart ;		// Multipart 유무

	// NewHeader()
	// 편지의 헤더를 구성한다.
	// 각 인자들은 다음과 같다.
	//	$title : 편지의 제목을 정한다.
	//	$name : 보내는 사람의 이름을 넣는다.
	//	$email : 보내는 사람의 E-mail 주소를 넣는다.
	//	$multipart: Multi-Part 기능 사용유무 (true or false)
	function	NewHeader ($title, $name, $email, $multipart)
	{
		global	$boundary ;

		// Title을 기억해 두고 가장 기본적인 Header를 만든다.
		$this->Title = $title ;
		$this->Header =
				"From: $name <$email>\n".
				"MIME-Version: 1.0" ;

		// Multi-Part 기능 사용 유무를 판별하여 헤더에 기록한다.
		if ($multipart)
			$this->Header .= "\nContent-Type: multipart/mixed; boundary=\"$boundary\"" ;
		$this->Multipart = $multipart ;
	}

	// AddBody()
	// 편지에 본문을 추가한다.
	// 각 인자들은 다음과 같다.
	//	$Body : 본문을 나타낸 String 형의 자료이다.
	//	$FileName : 만약 추가하려는 본문이 파일인 경우 파일명을 넣는다.
	function	AddBody ($Body, $FileName=false)
	{
		global	$delimiter ;
		
		if($this->Type) {
			$ctype = "text/html";
		}
		else {
			$ctype = "text/plain";
		}

		// Multi-Part 기능을 사용할 때는 현재 본문의 정보를 Body 에 기록해야 한다.
		if ($this->Multipart)
		{
			$this->Body .= $delimiter ;
			if ($FileName)
				$this->Body .= "Content-Type: application/octet-stream; name=\"$FileName\"\n".
						"Content-Transfer-Encoding: base64\n".
						"Content-Disposition: attachment; filename=\"$FileName\"\n" ;
			else
				$this->Body .= "Content-Type: $ctype; charset=EUC-KR\n" ;
			$this->Body .= "\n" ;
		}
		else
		// Multi-Part 기능을 사용하지 않을 때는 현재 본문의 정보를 Header 에 기록한다.
		{
			if ($FileName)
				$this->Header .= "\nContent-Type: application/octet-stream; name=\"$FileName\"\n".
						"Content-Transfer-Encoding: base64\n".
						"Content-Disposition: attachment; filename=\"$FileName\"" ;
			else
				$this->Header .= "\nContent-Type: $ctype; charset=EUC-KR" ;
		}

		// 파일을 추가하려는 경우 Base64로 Encode 해서 추가한다.
		if ($FileName)
			$Body = base64_encode($Body) ;

//		$c = $n = 0 ;
//		do
//		{
//			$c += $n ;
//			$line = substr($Body, $c, 64) ;
			// 기존의 본문들에 현재의 본문을 추가한다.
			$this->Body .= $Body ;
//		}
//		while ($n = strlen($line)) ;
		return ;
	}

	// EndMultiPart()
	// Multi-Part 기능의 편지의 끝임을 기록한다.
	// 반드시 NewHeader() 호출시 마지막 인자를 true로 했을 때 사용해야 한다.
	function	EndMultiPart ()
	{
		global	$close_delimiter ;
		$this->Body .= "\n$close_delimiter" ;
		return ;
	}

	// SendMail()
	// 편지 내용을 완성한 후에 실제 편지를 보내기 위한 명령이다.
	// 반드시 앞의 메소드 들을 사용하여 편지 내용을 완성한 후에 사용한다.
	// 	$toEmail : 받는이의 주소
	// (이 함수를 여러번 호출하여 같은 내용의 편지를 여러명에게 보낼 수 있다.)
	function	SendMail ($toEmail)
	{
		$result = mail($toEmail, $this->Title, $this->Body, $this->Header) ;
		return	$result ;
	}
}

?>
