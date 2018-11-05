<?
/*
include '../allphpfile/config.php';
include_once '../allphpfile/class/class_mysql.php';   //부모 클래스
include_once '../allphpfile/class/member_admin.php';      //회원 관련

	
	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
*/


?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title></title>
    
	<script src="../../allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>

    <link rel="stylesheet" href="../../allphpfile/apis/getmoney.css" />
</head>


<body  topmargin="0" leftmargin="0" width="100%" bgcolor="#fff">

<div>
<img src="./img/soho1.jpg" style="width:100%;margin:0;border:none;display:block;">
<a href="https://play.google.com/store/apps/details?id=com.twin7.sohoring" style="padding:0;font-size:0;margin:0;"><img src="./img/soho2.jpg" style="width:100%;margin:0;border:none;display:block;"></a>
<img src="./img/soho3.jpg" style="width:100%;margin:0;border:none;display:block;">
</div>



</body>

	<script type="text/javascript">

		
    </script>
</html>

<?
	$mycon->sql_close();
?>