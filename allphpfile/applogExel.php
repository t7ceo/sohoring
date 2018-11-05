<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';   //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스


	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


if(!$_GET['tel'] or $_GET['te'] == '0'){
	$fs2 = "select * from soho_app_log where tel <> '' order by day desc";
}else{
	$fs2 = "select * from soho_app_log where tel = '".$_GET['tel']."' order by day desc";
}

		
		$hh = mysql_query($fs2,$rs);
		$row = mysql_fetch_array($hh);
		

$day = date("Y-m-d_H-i");

header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = applog_".$day.".xls" );   
header( "Content-Description: PHP5 Generated Data" );   


 
// 테이블 상단 만들기
$EXCEL_STR = "
<table border='1'>
<tr>
   <td>순번</td>
   <td>전화</td>
   <td>IP</td>
   <td>Menu</td>
   <td>Bigo</td>
   <td>Date</td>
</tr>";

$num = 0; 
while($rowExl = mysql_fetch_array($hh)) {
   $num++;
   $EXCEL_STR .= "
   <tr>
       <td>".$num."</td>
       <td>".$rowExl['tel']."</td>
       <td>".$rowExl['ip']."</td>
       <td>".$rowExl['menu']."</td>
       <td>".$rowExl['bigo']."</td>
       <td>".$rowExl['day']."</td>
   </tr>
   ";
}
 
$EXCEL_STR .= "</table>";


	
	$mycon->sql_close();

 
echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
echo $EXCEL_STR;




?>
