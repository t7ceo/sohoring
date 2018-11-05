<?php

class Upload
{
	var $path = "";			## ���ε� ���; �۹̼��� 2773���� �Ǿ� �־����
	var $upfile = "";		## Upload�� ���� �̸�
	var $upfile_name = "";	## �ø� ���� �̸�
	var $upfile_type = "";	## �ø� ���� ����
	var $upfile_size = "";	## �ø� ���� ������
	var $perm = "777";		## �۹̼�

	function init($arr)
	{
		if($arr[path])
			$this->path = $arr[path];

		if($arr[upfile])
			$this->upfile = $arr[upfile];

		if($arr[upfile_name])
			$this->upfile_name = $arr[upfile_name];

		if($arr[upfile_type])
			$this->upfile_type = $arr[upfile_type];

		if($arr[upfile_size])
			$this->upfile_size = $arr[upfile_size];

		if($arr[perm])
			$this->perm = $arr[perm];
	}

	function upload()
	{
		if(!is_dir($this->path)) 
			`mkdir $this->path; chmod 2773 $this->path`;

		$this->upfile_name = ereg_replace("php3$", "phps", $this->upfile_name);
		$this->upfile_name = ereg_replace("php$", "phps", $this->upfile_name);
		$this->upfile_name = ereg_replace("html$", "phps", $this->upfile_name);
		$this->upfile_name = ereg_replace("cgi$", "phps", $this->upfile_name);

		if($this->upfile_name) 
		{
			$count = strrpos($this->upfile_name,'.');
			$expend = strtolower(substr($this->upfile_name, $count + 1, 3));
			$file = substr($this->upfile_name, 0, $count);

			$i=1;
			while (file_exists("$this->path/$this->upfile_name")) 
			{
				$this->upfile_name = $file."_$i".".".$expend;
				$i++;
			}

			if (file_exists($this->upfile))
			{
				copy($this->upfile, "$this->path/$this->upfile_name");
				unlink($this->upfile);
			}
			else
			{
				$this->upfile_name = "";
			}
		
		}
	return($this->upfile_name);
	}

}
?>