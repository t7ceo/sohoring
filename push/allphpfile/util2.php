<?


//문자열 변환
function change_str($otxt){
	$ss = nl2br($otxt);
	//$ss = str_replace("%0A", "<br />", $ss);
	$ss = str_replace("?", "\?", $ss);
	$ss = str_replace("\n", "", $ss);
	$ss = str_replace("\r", "", $ss);
	
	return $ss;
}


?>
