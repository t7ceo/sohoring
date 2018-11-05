<?php

class Upload
{
	var $path = "";			## 업로드 경로; 퍼미션은 2773으로 되어 있어야함
	var $upfile = "";		## Upload된 파일 이름
	var $upfile_name = "";	## 올릴 파일 이름
	var $upfile_type = "";	## 올릴 파일 형태
	var $upfile_size = "";	## 올릴 파일 사이즈
	var $perm = "777";		## 퍼미션

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