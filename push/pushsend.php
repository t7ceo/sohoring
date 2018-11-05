<?
include './allphpfile/config.php';
//include 'util.php';
include 'util2.php';
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

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title><?=$title?></title>


	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.css" /> 	
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.structure-1.4.0.min.css" />
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.theme-1.4.0.min.css" />
	
    <link rel="stylesheet" href="./allphpfile/apis/getmoney.css" />

	<script src="./allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>
	<script src="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.js"></script>


</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="AdInput">
    
        <div class="getmoneyHeadNo"><h2><?=$title?></h2></div>
                
        <div class="GmStrMenuHead" id="GmStrMenuHeadIn" style="text-align:center;">
            모든 회원에게 공지사항을 푸시로 발송 합니다.
        </div>	
                
        <div class="pageBodyR">
       		<form name="incamp" action="<?=$all_path?>sangpum_inprocess.php" method="post" enctype="multipart/form-data">
            <table border="0" width="90%" style="margin:5px 5%;">
                <tr>
                    <td>공지 URL</td>
                    <td><input type="text" name="url" id="url" value="ps" placeholder="푸시확인 URL"/></td>
                </tr>
                <tr>
                    <td>제목</td>
                    <td><input type="text" name="gtit1" id="gtit1" value="" placeholder="큰제목" /></td>
                </tr>
                <tr>
                    <td>상세제목</td>
                    <td>
                    <input type="text" name="gtit2" id="gtit2" value="" placeholder="상세제목" />
                    
                    </td>
                </tr>
                <tr>
                    <td>상세내용</td>
                    <td>
                    <textarea name="gongji" id="gongji" placeholder="상세내용"></textarea>
                    
                    <!--<input type="text" name="gtit2" id="gtit2" value="" placeholder="상세제목" />-->
                    
                    </td>
                </tr>
                <tr>
                    <td>비밀번호</td>
                    <td><input type="text" name="pass" id="passwd" value="" /></td>
                </tr>
                <tr>
                    <td>수신대상</td>
                    <td><input type="text" name="desang" id="desang" value="All" /></td>
                </tr>
                <tr>
                    <td>이미지 등록</td>
                    <td><input type="file" id="img1" name="fd1" style="padding:4px 0px 1px 0px;" size=45><br />
                    메인 이미지: (필수로 올려야 하는 항목 입니다.)<br />
					* 관련이미지는 800픽셀*560픽셀 최적화.
                    </td>
                </tr>
            </table>
			</form>
    
    
          </div>
    
        <div style="width:90%; margin:10px 4%; text-align:center;">
			<input type="button" value="푸시발송" style="margin:5px auto 20px;" class="redBtn" onclick="input_camp()">
            <!--<a href="#" class="redBtn" style="margin:5px auto 20px;" onclick="pushsend()">푸시발송</a>-->
        </div>
        
        
        <div id="pushSendList" style="width:100%;">
        </div>
        
        
    
    </div>

	<script type="text/javascript">
		String.prototype.replaceAll = replaceAll;
		
		var proje = "<?=$project?>";
		var nnt = <?=$ntime?>;
		
		//상품등록
		function input_camp(){
			var frm= eval(document.incamp);
		
			if(!frm.url.value){
				alert("url을 입력하세요.");
				frm.url.focus();
				return;
			}
			if(!frm.gtit1.value){
				alert("제목을 입력하세요.");
				frm.gtit1.focus();
				return;
			}
			
			//alert(frm.gtit1.value);
			
			if(!frm.gtit2.value){
				alert("상세제목을 입력하세요.");
				frm.gtit2.focus();
				return;
			}
			if(!frm.pass.value){
				alert("비밀번호를 입력하세요.");
				frm.pass.focus();
				return;
			}
			if(!frm.desang.value){
				frm.desang.value = "All";
			}
		
			//return;
		
			frm.submit();
		}

		
		
		//alert(proje);
		function getPushList(){
		
			var qr = "<?=$all_path?>gongjiAllReList.php";
			var param = "mode=1&proj="+proje;
			//alert(param);
			var chn = input_smstext(param,0);
			$.ajax({type:"GET", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
				
					var allsu = data.rs.length;
					var ss = "<table width='100%'>";
					ss += "<tr><th>순번</th><th>제목</th><th>상세제목</th><th>발송숫자</th><th>일시</th><th>수정</th></tr>";
					if(allsu > 0){
						for(var c=0; c < allsu; c++){
							ss += "<tr>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+(allsu - c)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].tit,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].tit2,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+data.rs[c].su+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+data.rs[c].day+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'><span class='r5button' onclick='pushDel("+data.rs[c].id+")'>삭제</span></td>";
							ss += "</tr>";
						}
					}
					ss += "</table>";				
				
					document.getElementById("pushSendList").innerHTML = ss;
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});

		
		}
		
		
		function pushDel(did){
		
			//푸시를 발송 합니다.
			var qr = "<?=$all_path?>gongjiAllReList.php";
			var param = "mode=2&did="+did;
			var chn = input_smstext(param,0);
			
			$.ajax({type:"GET", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
					
					getPushList();
					
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
			//var rst = str;
			var rst = decodeURI(str);
			
			//&기호 처리
			rst = rst.replaceAll("~and~", "&");
			rst = rst.replaceAll("~pls~", "+");
		
			
			return rst;
		}
		

		//document.getElementById("url").value = "<?=$gurl?>";	
		
		
			
		getPushList();

    </script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>