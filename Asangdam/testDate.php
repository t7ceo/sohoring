<?
include 'config.php';
include 'util.php';

$uiu = session_id();
//$_SESSION['session_id'] = $uiu;

if(!isset($_SESSION['session_id'])){
	$_SESSION['session_id'] = $uiu;
	$my_session = $uiu;
}else{
	
 my_session = $_SESSION['session_id'];
	$my_session .= "uuuu";
}

//$my_session = session_id();
//$_SESSION['session_id'] = session_id();

//$my_session = session_id();

$ad_date = date("Y-m-d H:i:s");


	$jsongab = '{"companyid":"'.' / '.$my_session.$ad_date.'"}';


	echo($jsongab);
	exit;
?>