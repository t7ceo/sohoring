<?
ob_start();

session_start();

$host="localhost";
$dbid="pigg1234";
$dbpass="soho7273";
$dbname="pigg1234";

$urlgab = "sohoring.com:41020";
$my_path = "../allphpfile/";
//php 파일 들이 있는 곳의 경로
$_base_url = "https://".$urlgab."/sohoring/";
$img_path = $_base_url."spimgs/";

$all_path = $_base_url."allphpfile/";

//소호링 연동 관련=====================================
//$keyam = "EC655C39874E357EB759AA159FEB5AC5"; 
//상용 암호화 키
$keyam = "544B18D6CAAE357EB759AD34504B3A48";


//테스트 서버 ==========================
/////////////////$qp_path = "http://211.115.75.243/";
//////////////////////$fsocket = "211.115.75.243";  
//$hostG = "211.115.75.243:8080"; //$url['host'];
//==============================================


//개발검수 서버 
////////////////$qp_path = "http://222.231.13.65/";   //검수 cms 서버
///////////////$fsocket = "222.231.13.65";     //검수 cms 서버 
///////////////////$hostG = "192.168.233.135";   //???????
//$hostG = "222.231.13.65";



//상용서버
$hostG = "feelringapi.uplus.co.kr";
//////////////////$hostG = "feelring.ez-i.co.kr";

//=================================================





$homepage   = "index.php";
$_mb_url    = $_base_url;
$_sbase_url = $_base_url;
$_smb_url   = $_base_url;
$_my_path   = "./";


$project = "voicering";


$displow = 10;   //한번에 보여줄 줄수
//$startrow = 0;  //시작 줄번호
//$endrow = $startrow + $displow;   //마지막 줄수





?>
