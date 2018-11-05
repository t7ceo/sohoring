<?
class PageRelation
{
	var $View_Page;			// ���� ������
	var $Basic_Url_S;			// �⺻
	var $Basic_Url;			// ���
	var $Page_Limit;		// �������� ����� ����
	var $First_Page;		// ó��������
	var $Last_Page;			// ������������
	var $Block;				// ���� ���
	var $Total_Block;		// ��Ż���
	var $Total_Page;		// ��ü��������
	
	var $First_Block;		// ó����ư
	var $Privew_Block;		// �������ư
	var $Next_Block;		// �������ư
	var $Last_Block;		// ��������ư
	var $Direct_Block;		// ������������ �̵��ϱ� ����

	/*-----------------------------------------
	@�Լ��� : PageIni

	$page	=> ���� ������
	$url	=> Ŭ���� �̵��� ����ּ�
	$tpage	=> ��������
	$limit	=> �������� ����� ����

	## �ʿ��� �������� �����ش�.
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
	@�Լ��� : FirstPage

	$img	=> ��ư�� �̹����� �ϰ������ ���
			=> ��� : <img src='./next_b.gif' border='0'>

	## ó��������
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
			if(!$img || empty($img)) $this->First_Block = "<table border=0 cellpadding=3 cellspacing=1 bgcolor=#030303><tr><td bgcolor=#F4FAFF><a href='".$this->Basic_Url."&".$pages."=1'><font color=#FF9900>ó��</font></a></td></tr></table>";
			else $this->First_Block = "<a href='".$this->Basic_Url."&".$pages."=1'>{$img}</a>";
		}else {
			$this->First_Block = $img;
		}
	}

	/*-----------------------------------------
	@�Լ��� : PrivewPage

	$img	=> ��ư�� �̹����� �ϰ������ ���
			=> ��� : <img src='./next_b.gif' border='0'>

	## ���������� ���
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
			if(!$img || empty($img)) $this->Privew_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->First_Page'>[����]</a>";
			else $this->Privew_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->First_Page'>$img</a>&nbsp;&nbsp;";
		}else{
			if(!$img || empty($img)) $this->Privew_Block = "<font color=gray>[����]</font>";
			else $this->Privew_Block = "$img &nbsp;&nbsp;";
		}
	}

	/*-----------------------------------------
	@�Լ��� : DirectPage

	## ������ �ٷΰ���
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
	@�Լ��� : NextPage

	$img	=> ��ư�� �̹����� �ϰ������ ���
			=> ��� : <img src='./next_b.gif' border='0'>

	## ���������� �
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
			// ��Ʈ�������� +1�� ���Ѵ�.
			$LP	= $this->Last_Page + 1;
			
			if(!$img || empty($img)) $this->Next_Block = "<a href='".$this->Basic_Url."&".$pages."=$LP'>[����]</a>";
			else $this->Next_Block = "&nbsp;&nbsp;<a href='".$this->Basic_Url."&".$pages."=$LP'>$img</a>";
		}else{
			if(!$img || empty($img)) $this->Next_Block = "<font color=gray>[����]</font>";
			else $this->Next_Block = "&nbsp;&nbsp;$img";
		}
	}

	/*-----------------------------------------
	@�Լ��� : LastPage

	$img	=> ��ư�� �̹����� �ϰ������ ���
			=> ��� : <img src='./next_b.gif' border='0'>

	## ������ ������
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
			if(!$img || empty($img)) $this->Last_Block = "<font color=gray>[������]</font>";
			else $this->Last_Block = "$img";	
		}else if($this->Last_Page > 1){
			if(!$img || empty($img)) $this->Last_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->Total_Page'>[������]</a>";
			else $this->Last_Block = "<a href='".$this->Basic_Url."&".$pages."=$this->Total_Page'>$img</a>";
		
		}else {
			if(!$img || empty($img)) $this->Last_Block = "<font color=gray>[������]</font>";
			else $this->Last_Block = "$img";
		}
	}

	/*-----------------------------------------
	@�Լ��� : PrintPage

	## ������ ���
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