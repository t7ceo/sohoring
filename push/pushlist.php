<?
include './allphpfile/config.php';
//include 'util.php';
include './allphpfile/gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련

	

	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	
	$ntime = mktime();
?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="euc-kr">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title></title>


	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.css" /> 	
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.structure-1.4.0.min.css" />
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.theme-1.4.0.min.css" />
	
    <link rel="stylesheet" href="./allphpfile/apis/getmoney.css" />

	<script src="./allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>
	<script src="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.js"></script>


</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="pushList">
		<ul id="pushListImg" class="pushListImg" style="min-height:800px;">
        </ul>    
                
        
    
    </div>

	<script type="text/javascript">
		String.prototype.replaceAll = replaceAll;
		
		var proje = "<?=$project?>";
		var nnt = <?=$ntime?>;
		
		function getPushListImg(){
		
			var qr = "<?=$all_path?>gongjiAllReList.php";
			var param = "mode=1&proj="+<?=$project?>;
			//alert(param);
			var chn = input_smstext(param,0);
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
				
					var allsu = data.rs.length;
					var ss = "";
					if(allsu > 0){
						for(var c=0; c < allsu; c++){
							ss += "<li>";
							ss += "<table border=0 cellpadding=0 cellspacing=0 width='100%'>";
							ss += "<tr><td>";
							ss += "<img src='<?=$psimgpath?>"+data.rs[c].img+"' width='100%'>";
							ss += "</td></tr>";
							ss += "<tr><td style='padding:1px 12px 12px;'>";
							ss += "<p style='font-size:1.2em;'><b>"+disp_smstext1(data.rs[c].tit,0)+"</b></p><p>"+disp_smstext1(data.rs[c].tit2,0)+"</p>";
							ss += "<span class='graytxt'>"+data.rs[c].day+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='graytxt'><a href='"+data.rs[c].urlp+"'>확인하러 가기 ></a></span>";
							ss += "</td></tr></table>";
							ss += "</li>";
						}
					}
					document.getElementById("pushListImg").innerHTML = ss;
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});

		
		}
		
		
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
		

		getPushListImg();

    </script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>