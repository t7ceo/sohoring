<?
class FileF
{
	var $fp;			// 파일 포인터
	var $filename;		// 읽어들일 파일 이름

	/*-----------------------------------------
	@함수명 : Open

	$fn		=> 열파일
	$mode	=> 파일을 여는 모드(r,w,w+,a,a+)

	## 열기
	------------------------------------------*/
	function Open($fn, $mode)
	{
		$this->fp = fopen($fn,$mode);
		$this->filename = $fn;

		if(!$this->fp){ echo "$fn 파일 오픈 실패"; }
	}

	/*-----------------------------------------
	@함수명 : Read

	## 읽기
	------------------------------------------*/
	function Read()
	{
		// filesize 만큼 읽어온다.
		return fread($this->fp,filesize($this->filename));

	}

	/*-----------------------------------------
	@함수명 : File

	$file	: 읽어 들일 파일 주소

	## 한줄 씩 읽기
	------------------------------------------*/
	function FileR($file)
	{
		$result = file($file);
	return $result;
	}

	/*-----------------------------------------
	@함수명 : Rewind

	## 파일 포인터(fp)를 파일의 처음으로 되돌린다.
	------------------------------------------*/
	function Rewind()
	{
		rewind($this->fp);

	}

	/*-----------------------------------------
	@함수명 : Fcsv

	## 파일포인터가 라리키는 csv 타입의 파일로부터 
	한줄씩 읽어들인 문자열을 배열의 형대로 반환한다.
	## 엑셀파일로 볼수있음 (김종관,하이방가루)
	------------------------------------------*/
	function Fcsv($num=10000)
	{
		while($line = fgetcsv($this->fp,$num,",")){
			for($i=0; $i<sizeof($line); $i++){
				$result .= $line[$i];
			}
		}
	return $result;
	}

	/*-----------------------------------------
	@함수명 : Ftime

	## 파일이 마지막으로 요청된 시간을 유닉스 시간 형태로 반환한다.
	------------------------------------------*/
	function Ftime()
	{
		$lastAccesstime	=	fileatime($this->fp);
		$result  = date("Y년 m월 d일 h시 i분 s초",$lastAccesstime);
	return $result;
	}

	/*-----------------------------------------
	@함수명 : Fmdtime

	## 파일이 마지막으로 수정된 시간을 유닉스 시간의 형태로 반환한다.
	------------------------------------------*/
	function Fmdtime()
	{
		$modifytime	=	filemtime($this->fp);
		$result  = date("Y년 m월 d일 h시 i분 s초",$modifytime);
	return $result;
	}

	/*-----------------------------------------
	@함수명 : Fexist

	## 파일명으로 전해준 이름이 존재하는지 검사하여 파일이 존재하면 true, 아니면 false를 반환한다.
	## 전달할 수 있는 파일은 반드시 로컬서버상에 있는 파일이어야 한다.
	------------------------------------------*/
	function Fexist($filename)
	{
		return file_exists($filename);
	}

	/*-----------------------------------------
	@함수명 : Fis

	## 파일명으로 전해 준 파일 이름이 존재하고 정상적인 파일일 경우 true를 반환한다.
	------------------------------------------*/
	function Fis()
	{
		return is_file($this->$filename);
	}

	/*-----------------------------------------
	@함수명 : Funlink

	$filename	: 삭제할 파일명

	## 파일삭제
	## fopen 사용안해도 됨
	------------------------------------------*/
	function Funlink($filename)
	{
		return @unlink($filename);
	}

	/*-----------------------------------------
	@함수명 : Fdirname

	## 디렉토리 패스를 포함한 파일의 전체경로명을 인자로 받아 디렉토리명만을 반환한다.
	## fopen 사용안해도 됨
	## /usr/local/apache/htdocs/index.html
	------------------------------------------*/
	function Fdirname($filename)
	{
		$result = dirname($filename);
	return $result;
	}

	/*-----------------------------------------
	@함수명 : Fopendir

	## 디렉토리 패스를 포함한 파일의 전체경로명을 인자로 받아 디렉토리명만을 반환한다.
	## fopen 사용안해도 됨
	## /usr/local/apache/htdocs/index.html
	------------------------------------------*/
	function Fopendir($filename)
	{
		 $this->fp = opendir($filename);
	}

	/*-----------------------------------------
	@함수명 : Freaddir

	## 디렉토리 패스를 포함한 파일의 전체경로명을 인자로 받아 디렉토리명만을 반환한다.
	## fopen 사용안해도 됨
	## /usr/local/apache/htdocs/index.html
	------------------------------------------*/
	function Freaddir()
	{
		while($filename = readdir($this->fp)){
			if($filename=="." || $filename=="..") $result = "";
			else $result .= $filename."<br>";
		}

		$rlt = substr($result,0,-4);
	return $rlt;
	}

	/*-----------------------------------------
	@함수명 : Fclosedir

	## 디렉토리 패스를 포함한 파일의 전체경로명을 인자로 받아 디렉토리명만을 반환한다.
	## fopen 사용안해도 됨
	## /usr/local/apache/htdocs/index.html
	------------------------------------------*/
	function Fclosedir()
	{
		closedir($this->fp);
	}

	/*-----------------------------------------
	@함수명 : FileSize

	## 파일 포인터(fp)를 파일의 처음으로 되돌린다.
	------------------------------------------*/
	function fileSize()
	{
		// 사이즈를 구하고 kbyte로 전환
		$filesize = filesize($this->fp) / 1024;

		//파일 사이즈 소수점 이하가 0.5 는 1로 반올림한다.
		return round($filesize);

	}

	/*-----------------------------------------
	@함수명 : Seek

	$val	=> 파일안에서 이동할 크기

	## 파일포인터를 $val 만큼 앞뒤로 이동시킨다.

	ex)$val = -3;
		fseek($fp,$val);
		파일안에서 뒤로 3칸이동
	------------------------------------------*/
	function seek($val)
	{
		return fseek($this->fp,$val);

	}

	/*-----------------------------------------
	@함수명 : Write

	$val	=> 파일에 기록한 내용

	## 한번에 데이터를 모두 기록한다.
	------------------------------------------*/
	function write($val)
	{
		return fwrite($this->fp,$val);

	}

	/*-----------------------------------------
	@함수명 : Close

	## 열었던 파일을 닫는다.
	------------------------------------------*/
	function Close()
	{
		fclose($this->fp);
	}
}
?>