<?
//==========================================================
////////////   /////		 ///////////     /////    ///////
///////////  ////  //	    ////       //   /// //   //  ///
////////// ///	   ///     ////////////    ///  //  //   ///
///////// ////////////    ///             ///   // //    ///
//////// ///		///..///.............///.... ////....///apmsoft.net

//----------------> ���÷��� <--------------------------
//�� ������		::	������
//�� ���ʰ�����	::	8�� 28��
//�� ������		::	04-04-16
//�� ����Ʈ		::	http://www.apmsoft.net
//==========================================================
class LayoutTpl
{
	var $fp;
	var $Line;
	var $type;

	var $Looped_num;
	var $Hidden_str;
	var $chgstr;
	var $ct_arr;
	var $cts_arr;
	var $cache_file;
	var $sub_Line;

	function tpl_File($fn){
		if (!@file_exists($fn)) die("LayoutTpl : ����({$fn})�� �������� �ʽ��ϴ�.");
		$this->fp = file($fn);
	}

	//array("img/"=>"../img/","../../img/"=>"../img/")
	function tpl_Define($strarray){
		$this->chgstr = $strarray;
	}

	function tpl_StrSrch(&$content,&$contents,&$loop_contents,&$loop_num,&$hidden_arr,$type, $cache_file)
	{
		if($this->fp)
		{
			$this->Looped_num= 0;
			$this->ct_arr			= $content;
			$this->cts_arr		= $contents;
			$this->type			= $type;
			$this->cache_file	= $cache_file;
			
			foreach($this->fp as $key => $val)
			{
				// [�⺻���ں���]
				if(is_array($this->chgstr)) {
					foreach($this->chgstr as $ke_y => $value) 
						$val = str_replace($ke_y,$value,$val);
				}

				//[ loop ]
				if(!strcmp(trim($val),"<!--@@Begin LOOPSTART@@-->")){
					if($this->Hidden_str=="Y") $loop= "n";
					else $loop = "y";

				}else if(!strcmp(trim($val),"<!--@@End LOOPSTART@@-->")){
					if($loop=="y") {
						$tmp_line = $this->tplLoop($loop_Line,$loop_contents[$this->Looped_num],$loop_num[$this->Looped_num]);
						$this->cache_buffer($tmp_line);
					}
					$this->Looped_num++;
					unset($loop_Line, $loop);
				}

				//[ hidden ]
				else if("BeginHidden@@-->"==(substr(trim($val),-16))){
					$tmp_str			= explode("@@",$val);
					$hidden_str	= explode(" ",$tmp_str[1]);
					$this->hidden($hidden_arr, $hidden_str[0]);
		
					$hidden = ($this->Hidden_str=="N")?  "y" : "n";
				}
				else if(!strcmp(trim($val),"<!--@@End Hidden@@-->")){
					unset($this->Hidden_str);
					$hidden	= "";
				}
				
				//[ include ]
				else if(ereg("<!--[#{}0-9a-zA-Z./@~?&=_]+-->",trim($val))){
					$this->tplInclude(trim($val));
					continue;
				}

				// result
				if($loop=="y" && "<!--@@Begin LOOPSTART@@-->"!=trim($val))
				{
					if($hidden=="y") $loop_Line[] .= $val;
					else if($hidden=="n") unset($val, $this->Hidden_str);
					else $loop_Line[] .= $val;
				}else if($loop=="n"){ unset($val);
				}else if($hidden=="y"){ $this->cache_buffer($val);
				}else if($hidden=="n"){ unset($val, $this->Hidden_str);
				}else{ $this->cache_buffer($val); }
			}
		}else {
			die("LayoutTpl : ������ �������� �ʽ��ϴ�.");
		}
	}

	// check --------------------->
	function cache_buffer($val)
	{
		if($this->type == "save"){
			if(preg_match("/\{[^\"&=;#-]+\}/",$val)) $this->Line .= $this->tplone_replace($val);
			else $this->Line .= $val;
		}else{
			ob_start();

			if(preg_match("/\{[^\"&=;#-]+\}/",$val)) echo $this->tplone_replace($val);
			else echo $val;
			
			if($this->type=="buffer") $this->Line .= ob_get_contents();
			ob_end_flush;
		}
	}

	// hidden -------------------->
	function hidden($arr, $str)
	{
		if(!is_array($arr)) return false;

		foreach($arr as $key => $value)
		{
			if($key==$str)	
			{
				if($value=="N") return $this->Hidden_str = "N";
				else return "";
			}
		}
	}

	// include ------------------->
	function tplInclude($line)
	{
		if(strpos($line,"{")) $line = $this->tplone_replace($line);
		
		$include_path = explode("##",$line);
		include("{$include_path[1]}");
		unset($include_path);
	}

	// loop ---------------------->
	function tplLoop($line,$loop_cnt,$num)
	{
		if(!is_array($loop_cnt)) return false;

		for($i=0; $i<=$num-1; $i++)
		{
			foreach($line as $key => $value)
			{
				if(!strcmp(trim($value),"<!--@@SUB BeginLOOPSTART@@-->"))
				{
					$sub_loop = "y";
				}
				
				else if(!strcmp(trim($value),"<!--@@SUB EndLOOPSTART@@-->"))
				{					
					foreach($sub_line as $key2 => $value2)
					{
						$count = count($loop_cnt[$i]["SUB"]);
						for($j=0; $j<$count; $j++)
						{
							if(strpos($value2,"{"))
							{
								$result .= $this->tplLoop_replace($value2, $loop_cnt[$i]["SUB"][$j]);
							}else{
								$result .= $value;
							}
						}
					}
					$sub_loop = "";
				}
				
				if(!$sub_loop)
				{
					if(strpos($value,"{"))
					{
						$result .= $this->tplLoop_replace($value, $loop_cnt[$i]);
					}else{
						$result .= $value;
					}
				}else {
					$sub_line[$i] .= $value;
					if($i>0) unset($sub_line[$i-1]);
				}
			}
		}
	return $result;
	}

	// �迭 ����
	function tpl_array_splice(&$arr, $index, $len)
	{
		$key		=array_keys($arr);
		$key_n	=array_search($index, $key);
		$_keys		=array_splice($key, $key_n, $len);
		foreach($_keys as $key_n)
		{
			unset($arr[$key_n]);
		}
	}

	// 1�� array ----------->
	function tplone_replace($line,$arr="")
	{		
		## �ܼ��迭
		if(is_array($this->ct_arr))
		{
			foreach($this->ct_arr as $key => $value)
			{				
				if(substr($line,strpos($line,$key),strlen($key)) == $key)
				{
					$re_key	= "{".$key."}";
					$line = str_replace($re_key, $value,$line);

					//$this->tpl_array_splice($this->ct_arr, $key, 1);

					//echo sizeof($this->ct_arr);
				}else {
					
					## �����迭
					if(sizeof($this->cts_arr) > 0){
						$line = $this->tplLoop_replace($line,$this->cts_arr);
					}
				}
			
			$line = $line;
			}
		## �����迭
		}else {				
			if(is_array($this->cts_arr)){
				$line = $this->tplLoop_replace($line,$this->cts_arr);
			}
		}
	return $line;	
	}

	// ���� array ----------------->
	function tplLoop_replace($line,$arr)
	{		
		if(is_array($arr))
		{
			foreach($arr as $key => $value)
			{
				$re_key	= "{".$key."}";
				$line   = str_replace($re_key, $value,$line);
			}
		}
	return $line;
	}

	function cache_file_make($cache_fp, $contents)
	{
		if(!$contents) return false;
		unset($this->Line);

		if(!$gfp = fopen($cache_fp, "w")) die("LayoutTpl : FOPEN is false");
		$g_content =fwrite($gfp, $contents);
		fclose($gfp);
	}

	// save ------------>
	function tpl_PrintView()
	{
		//if(!$this->type) return false;
		
		if($this->type=="save") return $this->Line;
		else if($this->type =="buffer") $this->cache_file_make($this->cache_file, $this->Line);
	}
}
?>