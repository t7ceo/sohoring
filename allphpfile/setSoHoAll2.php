<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	$ad_date = date("Y-m-d H:i:s");


	switch($_GET[mode]){
	case "ujmsDel":   //업종별 음원 삭제.
		$mlink = "../Asangdam/onecut/";
	
		unlink($mlink.$_GET[nam]);
	

		$jsongab = '{"rs":"ok"}';
		
	break;	
	}


	echo($jsongab);
	$mycon->sql_close();


?>