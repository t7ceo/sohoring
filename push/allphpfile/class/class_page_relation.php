<?
class PageRelation
{
	var $View_Page;			// 현재 페이지
	var $Basic_Url_S;			// 기본
	var $Basic_Url;			// 경로
	var $Page_Limit;		// 페이지당 출력할 갯수
	var $First_Page;		// 처음페이지
	var $Last_Page;			// 마지막페이지
	var $Block;				// 계산된 블록
	var $Total_Block;		// 토탈블록
	var $Total_Page;		// 전체페이지수
	
	var $First_Block;		// 처음버튼
	var $Privew_Block;		// 이전몇개버튼
	var $Next_Block;		// 다음몇개버튼
	var $Last_Block;		// 마지막버튼
	var $Direct_Block;		// 각페이지마다 이동하기 위한

	/*-----------------------------------------
	@함수명 : PageIni

	$page	=> 현재 페이지
	$url	=> 클릭시 이동할 경로주소
	$tpage	=> 총페이지
	$limit	=> 페이지당 출력할 갯수

	## 필요한 정보들을 보내준다.
	------------------------------------------*/
	function PageIni($page,$url,$tpage,$limit)
	{
		$total_block	= ceil($tpage/$limit);
		$block			= ceil($page/$limit);

		$first_page		= ($block-1)*$limit;
		$last_page		= $block*$limit;

		if($total_block <= $block) {
		   $last_page = $tpage;
		}
		
		$this->View_Page	= $page;
		$this->Basic_Url		= $url;
		$this->Page_Limit	= $limit;
		$this->Total_Block	= $total_block;
		$this->Block			= $block;
		$this->First_Page	= $first_page;
		$this->Last_Page	= $last_page;
		$this->Total_Page	= $tpage;

	}

	/*-----------------------------------------
	@함수명 : FirstPage

	$img	=> 버튼을 이미지로 하고싶을때 사용
			=> 방법 : <img src='./next_b.gif' border='0'>

	## 처음페이지
	------------------------------------------*/
	function FirstPage($img="",$page=1)
	{
		if($page == 1){
			$pages = 'page';
		}else if($page == 2){
			$pages = 'page2';	
		}else if($page == 3){
			$pages = 'page3';
		}
		if($this->View_Page > 1)
		{
			if(!$img || empty($img)) $this->First_Block = "<table border=0 cellpadding=3 cellspacing=1 bgcolor=#030303><tr><td bgcolor=#F4FAFF><a href='".$this->Basic_Url."&".$pages."=1'><font color=#FF9900>처음</font></a></td></tr></table>";
			else $this->First_Block = "<a href='".$this->Basic_Url."&".$pages."=1'>{$img}</a>";
		}else {
			$this->First_Block = $img;
		}
	}

	/*-----------------------------------------
	@함수명 : PrivewPage

	$img	=> 버튼을 이미지로 하고싶을때 사용
			=> 방법 : <img src='./next_b.gif' border='0'>

	## 이전페이지 블록
	------------------------------------------*/
	function PrivewPage($img="",$page=1)
	{
		if($page == 1){
			$pages = 'page';
		}else if($page == 2){
			$pages = 'page2';	
		}else if($page == 3){
			$pages = 'page3';
		}
		if($this->Block > 1)
		{
			if(!$img || empty($img)) $this->Privew_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->First_Page'>[이전]</a>";
			else $this->Privew_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->First_Page'>$img</a>&nbsp;&nbsp;";
		}else{
			if(!$img || empty($img)) $this->Privew_Block = "<font color=gray>[이전]</font>";
			else $this->Privew_Block = "$img &nbsp;&nbsp;";
		}
	}

	/*-----------------------------------------
	@함수명 : DirectPage

	## 페이지 바로가기
	------------------------------------------*/
	function DirectPage($page=1)
	{
		if($page == 1){
			$pages = 'page';
		}else if($page == 2){
			$pages = 'page2';	
		}else if($page == 3){
			$pages = 'page3';
		}
		$direct_page = $this->First_Page + 1;
		$i = 1;
		for($dpage = $direct_page; $dpage<=$this->Last_Page; $dpage++){
			
			if($this->View_Page==$dpage){
				$rt	= " <b><font size='2'>$dpage</font></b> ";
			}else {
				$rt	= " <a href='".$this->Basic_Url."&".$pages."=$dpage'>[$dpage]</a> ";
			}
		$result .= $rt;
		$i++;
		}
	$this->Direct_Block = $result;

	}

	/*-----------------------------------------
	@함수명 : NextPage

	$img	=> 버튼을 이미지로 하고싶을때 사용
			=> 방법 : <img src='./next_b.gif' border='0'>

	## 다음페이지 몇개
	------------------------------------------*/
	function NextPage($img="",$page=1)
	{
		if($page == 1){
			$pages = 'page';
		}else if($page == 2){
			$pages = 'page2';	
		}else if($page == 3){
			$pages = 'page3';
		}
		if($this->Block < $this->Total_Block)
		{
			// 라스트페이지에 +1를 더한다.
			$LP	= $this->Last_Page + 1;
			
			if(!$img || empty($img)) $this->Next_Block = "<a href='".$this->Basic_Url."&".$pages."=$LP'>[다음]</a>";
			else $this->Next_Block = "&nbsp;&nbsp;<a href='".$this->Basic_Url."&".$pages."=$LP'>$img</a>";
		}else{
			if(!$img || empty($img)) $this->Next_Block = "<font color=gray>[다음]</font>";
			else $this->Next_Block = "&nbsp;&nbsp;$img";
		}
	}

	/*-----------------------------------------
	@함수명 : LastPage

	$img	=> 버튼을 이미지로 하고싶을때 사용
			=> 방법 : <img src='./next_b.gif' border='0'>

	## 마지막 페이지
	------------------------------------------*/
	function LastPage($img="",$img_off="",$page=1)
	{
		if($page == 1){
			$pages = 'page';
		}else if($page == 2){
			$pages = 'page2';	
		}else if($page == 3){
			$pages = 'page3';
		}
		//$lastpg = $this->Page_Limit*$this->Total_Block;

		if($this->Total_Page == $this->View_Page)
		{
			if(!$img || empty($img)) $this->Last_Block = "<font color=gray>[마지막]</font>";
			else $this->Last_Block = "$img";	
		}else if($this->Last_Page > 1){
			if(!$img || empty($img)) $this->Last_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->Total_Page'>[마지막]</a>";
			else $this->Last_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->Total_Page'>$img</a>";
		
		}else {
			if(!$img || empty($img)) $this->Last_Block = "<font color=gray>[마지막]</font>";
			else $this->Last_Block = "$img";
		}
	}

	/*-----------------------------------------
	@함수명 : PrintPage

	## 페이지 출력
	------------------------------------------*/
	function PrintPage($check)
	{
	//$result .= $this->First_Block.$this->Privew_Block.$this->Direct_Block.$this->Next_Block.$this->Last_Block;
	if($check == 2){
		$result ="
				$this->First_Block
				$this->Privew_Block
				$this->Direct_Block
				$this->Next_Block
				$this->Last_Block
		";
	//$result .= $this->First_page.$this->Privew_Block.$this->Direct_Block.$this->Next_Block.$this->Last_page;
	}else{
		//$result .= $this->First_Block.$this->Privew_Block.$this->Direct_Block.$this->Next_Block.$this->Last_Block;
		$result ="<table border=0 cellpadding=3 cellspacing=2>
			<tr>
				<td>$this->First_Block</td>
				<td>$this->Privew_Block</td>
				<td>$this->Direct_Block</td>
				<td>$this->Next_Block</td>
				<td>$this->Last_Block</td>
			</tr>
		</table>";
//		$result .= $this->First_page.$this->Privew_Block.$this->Direct_Block.$this->Next_Block.$this->Last_page;
	}
	return $result;
	}
}
?>