<?
include 'config.php';
//include 'util.php';
include 'gcmutil.php';
include 'class/class_mysql.php';   //부모 클래스
include 'class/member_admin.php';      //회원 관련



	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();
//====================================================================================
			$proj = "voicering";
			$ll = "SUmain1";
					
			//실제 메시지를 발송 한다.
			//sendMessageGCM("test","푸쉬 테스트 합니다.", "Master/77", "01072215487", $rs, $proj, $ll);
			sendMessageGCM("test","푸쉬 테스트 합니다.", "Master/77", "01095535785", $rs, $proj, $ll);
			//sendMessageGCM($mess1, $mess2, $fromm, $rgid, $rs, $projec, $golink, $img='0')


//===============================================================================================



	//$mycon->sql_close();



	//echo($jsongab);


?>