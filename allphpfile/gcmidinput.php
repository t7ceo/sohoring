<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php'; //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	if(!$_POST[phonenum]) $_POST[phonenum] = "000-000-000";


	//새로운 GCM Id 를 설정 한다.
	$mycon->editGCMID($_POST[regid], $_POST[udid], $_POST[phonenum], $project, $_POST[memid]);
	

	$mycon->sql_close();	

?>