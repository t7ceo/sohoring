<?
include './allphpfile/config.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련

	
	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);



	//이미지를 가져온다
	$aa = "select * from soho_AAmyGongji where id = ".$_GET[recnum]." and project = '".$project."'  limit 1";
	$a = mysql_query($aa, $rs);
	$row = mysql_fetch_array($a);
	
	$pushmd = $row[allinf];
	
	//이미지를 가져와서 보여 준다.
	$imgnam = $row[jangso];
	
	$tit = rawurldecode($row[title]);
	$tit2 = rawurldecode($row[title2]);
	$tit3 = rawurldecode($row[gongji]);
	
	//echo $aa.$imgnam;
?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title></title>
    
	<script src="./allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>

    <link rel="stylesheet" href="./allphpfile/apis/getmoney.css" />
</head>


<body  topmargin="0" leftmargin="0" width="100%" bgcolor="#000000">
        <table id="pushTb" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin:0; padding:0;">
        <tr><td id="pushimg" style="color:white; width:100%; height:100%;">
        	<span style="position:absolute; top:10px; left:15px; font-weight:bold; border-radius:6px; font-size:1.2em; color:black; padding:5px 7px; background-color:rgba(255, 255, 255, 0.6)"><?=$tit?></span>
            
            <? if($pushmd == 3){ ?>
            
            	<span style="position:absolute; top:46px; left:15px; font-weight:bold; border-radius:6px; font-size:1.2em; color:white; padding:5px 7px; background-color:rgba(0, 0, 0, 0.8)"><?=$tit3?></span>
            
            <? } ?>
        </td></tr>
        </table>

	<script type="text/javascript">
		String.prototype.replaceAll = replaceAll;
		

		
		var proje = "<?=$proj?>";
		var imgnam = "<?=$imgnam?>";
		
		var allinf = "<?=$tit3?>";
	
 		var imgpath = "<?=$psimgpath?>";
		if(allinf == "jd" || allinf == "ev") imgpath = "<?=$jdimgpath?>";

		
		
		var hh = $("#pushTb").height();
		
		
		var ww = $("#pushimg").width();
		var hh = ww * 1;
		$("#pushimg").css({"background":"url("+imgpath+imgnam+")", "height":hh+"px", "background-size":"100%","background-repeat":"no-repeat", "position":"50% 50%"});

		
		
		function replaceAll(str1, str2){
			var strTemp = this;
			strTemp = strTemp.replace(new RegExp(str1, "g"), str2);
			return strTemp;
		}

		//메세지 전송 관련 글자 입력
		function input_smstext(str,tsu){
			
			var ss = encodeURI(str);
			var rst = encodeURI(ss);
			
			
			return rst;
		}
		
		
		//모든 내용 출력
		function disp_smstext1(str,tsu){
		
			var rst = decodeURI(str);
			
			//&기호 처리
			rst = rst.replaceAll("~and~", "&");
			rst = rst.replaceAll("~pls~", "+");
		
			
			return rst;
		}
		
    </script>

</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>