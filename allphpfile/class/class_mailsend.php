<?php

////////////////////////////////////////////////////////////////
// SMTP ���������� Class�� ������ PHP ����
//	(Multl-Part ��� ����)
//
// Multi-Part Mail Ŭ�������� ������ ���� 4���� �޼ҵ� ���� �ִ�.
//	NewHeader() : ������ Header�� �����Ѵ�.
//	AddBody() : ������ ������ �߰��Ѵ�.
//	EndMultiPart() : MultiPart ������ ��� ������ ������ �߰��Ѵ�.
//	SendMail() : ������ ������.
//
// �ϳ��� ������ ������ ������ ���� ���
//	NewHeader() -> AddBody() -> SendMail()
// ������ ȣ���ϸ�
// �ΰ� �̻��� ������ ������ ������ ���� ���
//	NewHeader() -> AddBody() -> .... -> EndMultiPart() -> SendMail()
// ������ ȣ���Ѵ�.
// NewHeader() �� ������ ���ڷμ� Multi-Part ����� ����� ������
// �ƴ����� �����ϸ� Multi-Part ����� ����� ���� �ʿ��� ���� �� ��ŭ
// AddBody() �� ȣ���Ͽ� ������ �߰��ϸ� ������ ������ �߰��� ��������
// �ݵ�� EndMultiPart() �� ȣ���Ͽ��� �Ѵ�.
// ���� SendMail() �� ������ ȣ���� �� �ִ�. (�������� ���� �� �ִ�.)
//

// Multi-Part �� ������ ���� ���ڿ�
$boundary = "Boundary of PHP SendMail Client" ;
$delimiter = "--$boundary\n" ;
$close_delimiter = "--$boundary--\n" ;

// Multi-Part Mail Ŭ����
class	MailSend
{
	var	$Title ;		// ���� ������ ���
	var	$Header ;		// ������ ������ ������ �ּ� ����
	var	$Body ;			// ������ ����
	var	$Type ;			// html �������
	var	$Multipart ;		// Multipart ����

	// NewHeader()
	// ������ ����� �����Ѵ�.
	// �� ���ڵ��� ������ ����.
	//	$title : ������ ������ ���Ѵ�.
	//	$name : ������ ����� �̸��� �ִ´�.
	//	$email : ������ ����� E-mail �ּҸ� �ִ´�.
	//	$multipart: Multi-Part ��� ������� (true or false)
	function	NewHeader ($title, $name, $email, $multipart)
	{
		global	$boundary ;

		// Title�� ����� �ΰ� ���� �⺻���� Header�� �����.
		$this->Title = $title ;
		$this->Header =
				"From: $name <$email>\n".
				"MIME-Version: 1.0" ;

		// Multi-Part ��� ��� ������ �Ǻ��Ͽ� ����� ����Ѵ�.
		if ($multipart)
			$this->Header .= "\nContent-Type: multipart/mixed; boundary=\"$boundary\"" ;
		$this->Multipart = $multipart ;
	}

	// AddBody()
	// ������ ������ �߰��Ѵ�.
	// �� ���ڵ��� ������ ����.
	//	$Body : ������ ��Ÿ�� String ���� �ڷ��̴�.
	//	$FileName : ���� �߰��Ϸ��� ������ ������ ��� ���ϸ��� �ִ´�.
	function	AddBody ($Body, $FileName=false)
	{
		global	$delimiter ;
		
		if($this->Type) {
			$ctype = "text/html";
		}
		else {
			$ctype = "text/plain";
		}

		// Multi-Part ����� ����� ���� ���� ������ ������ Body �� ����ؾ� �Ѵ�.
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
		// Multi-Part ����� ������� ���� ���� ���� ������ ������ Header �� ����Ѵ�.
		{
			if ($FileName)
				$this->Header .= "\nContent-Type: application/octet-stream; name=\"$FileName\"\n".
						"Content-Transfer-Encoding: base64\n".
						"Content-Disposition: attachment; filename=\"$FileName\"" ;
			else
				$this->Header .= "\nContent-Type: $ctype; charset=EUC-KR" ;
		}

		// ������ �߰��Ϸ��� ��� Base64�� Encode �ؼ� �߰��Ѵ�.
		if ($FileName)
			$Body = base64_encode($Body) ;

//		$c = $n = 0 ;
//		do
//		{
//			$c += $n ;
//			$line = substr($Body, $c, 64) ;
			// ������ �����鿡 ������ ������ �߰��Ѵ�.
			$this->Body .= $Body ;
//		}
//		while ($n = strlen($line)) ;
		return ;
	}

	// EndMultiPart()
	// Multi-Part ����� ������ ������ ����Ѵ�.
	// �ݵ�� NewHeader() ȣ��� ������ ���ڸ� true�� ���� �� ����ؾ� �Ѵ�.
	function	EndMultiPart ()
	{
		global	$close_delimiter ;
		$this->Body .= "\n$close_delimiter" ;
		return ;
	}

	// SendMail()
	// ���� ������ �ϼ��� �Ŀ� ���� ������ ������ ���� ����̴�.
	// �ݵ�� ���� �޼ҵ� ���� ����Ͽ� ���� ������ �ϼ��� �Ŀ� ����Ѵ�.
	// 	$toEmail : �޴����� �ּ�
	// (�� �Լ��� ������ ȣ���Ͽ� ���� ������ ������ �������� ���� �� �ִ�.)
	function	SendMail ($toEmail)
	{
		$result = mail($toEmail, $this->Title, $this->Body, $this->Header) ;
		return	$result ;
	}
}

?>
