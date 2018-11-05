<?
/*======================================================================================================
⊙ 개발자		::	멤버 관련 테이블
⊙ 최초개발일	::	5월 27일
⊙ 수정일		::	
⊙ 사이트		::	http://mlrl2000.cafe24.com
⊙ 수정자		::	김성식
⊙ 수정일		::	2013년 5월 27일
======================================================================================================*/
//사용하는 테이블
//soho_Anyting_gcmid

class Tbcont extends MySQL
{
/*========================================================================
	함수 이름 :	create_basicTb("", dbname)
	file 이름 : dbTableMk.php

	## 기본 테이블을 만든다.
	UNIQUE KEY  `id` (  `id` ) ,  추가 필요
==========================================================================*/
	function create_basicTb($ft, $dbn)
	{
		
		//회원 테이블 만들기
		$tbname[0] = $ft."Anyting_member";
		$tb[0] = "CREATE TABLE  `".$dbn."`.`".$tbname[0]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT , 
`memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디', 
`pass` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '비번', 
`email` VARCHAR( 30 ) NOT NULL DEFAULT  '0' COMMENT  '이메일', 
`tel` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '전화번호', 
`meminf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:매니져,2:업주, 9:총 마스터', 
`indate` DATE NOT NULL DEFAULT  '0000-00-00', 
`uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '폰고유번호',
UNIQUE KEY  `id` (  `id` ) ,KEY  `memid` (  `memid` )) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//회원 테이블 추가 정보
		$tbname[1] = $ft."Anyting_memberAdd";
		$tb[1] = "CREATE TABLE `".$dbn."`.`".$tbname[1]."` ( 
`id` int( 11 ) NOT NULL AUTO_INCREMENT , 
`memid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '회원아이디', 
`name` varchar( 50 ) NOT NULL DEFAULT '0' COMMENT '회원 이름', 
`bday` date NOT NULL DEFAULT '0000-00-00' COMMENT '생년월일', 
`adpass` varchar( 20 ) NOT NULL DEFAULT '0' COMMENT '추가적인 비번', 
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '프로젝트 이름', 
`memup` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '등업신청', 
`mempo` tinyint( 2 ) NOT NULL DEFAULT '0', 
`position` text NOT NULL , 
`addr` text NOT NULL COMMENT '주소', 
`mtel` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT '회원전화번호', 
`otel` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT '사무실 전화', 
`sex` tinyint( 1 ) NOT NULL DEFAULT '1' COMMENT '성별 남', 
`coname` text NOT NULL COMMENT '업체명', 
`copo` text NOT NULL COMMENT '직책 직위', 
`upjong` varchar( 300 ) NOT NULL DEFAULT '0' COMMENT '업종정보', 
`courl` varchar( 200 ) NOT NULL DEFAULT '0' COMMENT '업체url', 
`perimg` varchar( 20 ) NOT NULL DEFAULT 'noperimg.jpg' COMMENT '회원 사진', 
`jiyeog` tinyint( 2 ) NOT NULL DEFAULT '0', 
`jibu` tinyint( 2 ) NOT NULL DEFAULT '0', 
`jijeom` tinyint( 2 ) NOT NULL DEFAULT '0', 
`udid` varchar( 20 ) NOT NULL DEFAULT '0' COMMENT '폰고유번호', 
`talk` text NOT NULL COMMENT '하고픈말', 
`sname` varchar( 50 ) NOT NULL DEFAULT '0' COMMENT '자녀이름', 
`sonid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '자녀의 아이디', 
`jage` tinyint( 3 ) NOT NULL DEFAULT '0' COMMENT '자녀의 나이', 
`clsnam` int( 11 ) NOT NULL DEFAULT '0' COMMENT '자녀의 클래스아이디', 
`indate` DATE NOT NULL DEFAULT  '0000-00-00',
UNIQUE KEY  `id` (  `id` ) ,KEY  `memid` (  `project`, `memid` )) ENGINE = MYISAM DEFAULT CHARSET = utf8"; 
		
		
		//회원 테이블 추가 정보
		$tbname[2] = $ft."Anyting_test";
		$tb[2] = "CREATE TABLE  `".$dbn."`.`".$tbname[2]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `t1` VARCHAR( 30 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
 `t2` VARCHAR( 30 ) NOT NULL DEFAULT  '0',
 `t3` VARCHAR( 30 ) NOT NULL DEFAULT  '0',
 `db1` DOUBLE NOT NULL DEFAULT  '0',
 `db2` DOUBLE NOT NULL DEFAULT  '0',
 `db3` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '숫자',
 `txt` TEXT NOT NULL COMMENT  '내용',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `t1` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//GCM id 테이블
		$tbname[3] = $ft."soho_Anyting_gcmid";
		$tb[3] = "CREATE TABLE  `".$dbn."`.`".$tbname[3]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람',
 `phonum` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '회원전화번호',
 `gcmid` VARCHAR( 254 ) NOT NULL DEFAULT  '0' COMMENT  '보내는 메세지',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 명을 입력한다.',
 `bell` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:기본은 벨을 울리지 않는다.',
 `endtime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '마지막으로 메시지 콜된 시간',
 `login` VARCHAR( 3 ) NOT NULL DEFAULT  'ok' COMMENT  'no:로그아웃,ok:로그인',
 `ver_num` VARCHAR( 10 ) NOT NULL DEFAULT  '1.0' COMMENT  '사용자의 앱버젼',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gcmid` (  `project` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		
		//컴파니 테이블 생성
		$tbname[4] = $ft."Anyting_company";
		$tb[4] = "CREATE TABLE  `".$dbn."`.`".$tbname[4]."` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`companyid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '기업아이디',
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '프로젝트 이름',
`gubun` tinyint( 3 ) NOT NULL DEFAULT '1' COMMENT '1:호프,2:커피,3:카페7:이벤트',
`masterid` varchar( 60 ) NOT NULL DEFAULT '0' COMMENT '마스터의 아이디',
`ymanid` varchar( 10 ) NOT NULL DEFAULT '0' COMMENT '영업자아이디',
`coname` varchar( 100 ) NOT NULL DEFAULT 'Hong gil dong Co' COMMENT '가맹점의 대표이름과 직함',
`sangho` varchar( 255 ) NOT NULL DEFAULT '0' COMMENT '상호',
`memo` text NOT NULL COMMENT '설명',
`tel` varchar( 13 ) NOT NULL DEFAULT '0' COMMENT '업체전화',
`jygab` int( 3 ) NOT NULL DEFAULT '0' COMMENT '지역',
`juso` varchar( 500 ) NOT NULL DEFAULT '0' COMMENT '주소',
`url` varchar( 200 ) NOT NULL DEFAULT '0' COMMENT '홈페이지',
`inname` varchar( 60 ) NOT NULL DEFAULT '0' COMMENT '입금자 이름',
`inday` DATE NOT NULL DEFAULT  '0000-00-00' COMMENT  '입금일자',
`indon` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '입금액',
`ondon` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '실제 입금액',
`oninf` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '0:출력않함, 1:출력함',
`star` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '숫자가 높으면 위로 출력',		
`indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '등록일자',
`ondate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '서비스 시작일자',
`enddate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '서비스 종료일자',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `companyindex` (  `project` , `gubun`,  `companyid` ,   `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//업체 이미지 테이블 생성
		$tbname[5] = $ft."Anyting_comimg";
		$tb[5] = "CREATE TABLE  `".$dbn."`.`".$tbname[5]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '이미지 이름',
 `manphoto` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '증명사진',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `comimg` (  `companyid` ,  `imgname` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//업체 GPS 정보
		$tbname[6] = $ft."Anyting_comgps";
		$tb[6] = "CREATE TABLE  `".$dbn."`.`".$tbname[6]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
 `latpo` DOUBLE NOT NULL DEFAULT  '12.1212121',
 `longpo` DOUBLE NOT NULL DEFAULT  '12.1212121',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `companyid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//앱버젼 관리
		$tbname[7] = $ft."Anyting_appinf";
		$tb[7] = "CREATE TABLE  `".$dbn."`.`".$tbname[7]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `ver_num` VARCHAR( 10 ) NOT NULL DEFAULT  '1.0' COMMENT  '사용자의 앱버젼',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '1.0' COMMENT  'project',
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//상당실 입실자 표시
		$tbname[8] = $ft."AAonSangdamTb";
		$tb[8] = "CREATE TABLE  `".$dbn."`.`".$tbname[8]."` (
`id` DOUBLE NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '업체제공 패스',
 `pauseinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '1: 푸즈상태',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입장시간',
UNIQUE KEY  `mastid` (  `companyid` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//읽지않은 새로운 대화 리스트
		$tbname[9] = $ft."AAmyPo";
		$tb[9] = "CREATE TABLE  `".$dbn."`.`".$tbname[9]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `messid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '글번호',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: 새로운 메세지 없음, 1: 새메세지 있음',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람아이디',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람의 아이디',
 `wrinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '쓰기의 상태',
 `popinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '팝업 숫자를 기록한다.',
UNIQUE KEY  `aamypo` (  `companyid` ,  `tomemid` ,  `fromid` ,  `id` ) ,
KEY  `newmess` (  `newinf` ,  `tomemid` ,  `messid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//읽지않은 새로운 대화 리스트
		$tbname[10] = $ft."AAmyOnecutRe";
		$tb[10] = "CREATE TABLE  `".$dbn."`.`".$tbname[10]."` (
`idnum` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `id` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '글아이디',
 `review` TEXT NOT NULL COMMENT  '원컷리뷰',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람아이디',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `idnum` (  `idnum` ) ,
KEY  `onere` (  `id` ,  `fromid` ,  `idnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//읽지않은 새로운 대화 리스트
		$tbname[11] = $ft."AAmyOnecutimg";
		$tb[11] = "CREATE TABLE  `".$dbn."`.`".$tbname[11]."` (
`id` INT( 11 ) NOT NULL DEFAULT  '0',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '이미지 이름',
KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `imgname` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//원컷 이미지를 저장 한다.
		$tbname[12] = $ft."AAmyOnecut";
		$tb[12] = "CREATE TABLE  `".$dbn."`.`".$tbname[12]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 이름을 기록',
 `bloginf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '블로그 연동여부',
  `title` TEXT NOT NULL COMMENT  '블로그 제목',
 `memo` TEXT NOT NULL COMMENT  '원컷리뷰',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람아이디',
 `gubun` VARCHAR( 5 ) NOT NULL DEFAULT  '0' COMMENT  'not:수다, love:만남',
 `categori` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '카테고리 구분',
 `url` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  '참고자료 링크',
 `latpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '위도',
 `longpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '경도',
 `vnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '조회숫자',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `project` ,  `companyid` ,  `fromid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//전체 메시지의 발송 숫자를 저장
		$tbname[13] = $ft."AAmyMessSendSu";
		$tb[13] = "CREATE TABLE  `".$dbn."`.`".$tbname[13]."` (
`messid` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'messge id',
 `sendsu` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '메시지 보낸 수',
KEY  `messsends` (  `messid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//메세지를 기록 한다.
		$tbname[14] = $ft."AAmyMess";
		$tb[14] = "CREATE TABLE  `".$dbn."`.`".$tbname[14]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `message` TEXT NOT NULL COMMENT  '보내는 메세지',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람아이디',
 `tomanid` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람 아이디',
 `peinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '2:단순알림,1: 회원간의 메시지 교환이다.',
 `onecutid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '원컷리뷰의 아이디',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `mymess` (  `companyid` ,  `tomanid` ,  `fromid` ,  `id` ) ,
KEY  `newmess` (  `tomanid` ,  `indate` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//상담자에 대한 메모 기록
		$tbname[15] = $ft."AAmyMemo";
		$tb[15] = "CREATE TABLE  `".$dbn."`.`".$tbname[15]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `tomem` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `wrt` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '작성자',
 `mmo` TEXT NOT NULL COMMENT  '보내는 메세지',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `babynewWr` (  `companyid` ,  `wrt` ,  `tomem` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//상담자에 대한 메모 기록
		$tbname[16] = $ft."AAmyGongjiRe";
		$tb[16] = "CREATE TABLE  `".$dbn."`.`".$tbname[16]."` (
`idnum` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `id` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '글아이디',
 `review` TEXT NOT NULL COMMENT  '원컷리뷰',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람아이디',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `idnum` (  `idnum` ) ,
KEY  `babynewWr` (  `id` ,  `fromid` ,  `idnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//상담자에 대한 메모 기록
		$tbname[17] = $ft."AAmyGongjiGcm";
		$tb[17] = "CREATE TABLE  `".$dbn."`.`".$tbname[17]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `recnum` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'gcm 레코드 번호',
 `newinf` TINYINT( 3 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 이름을 기록',
 `udid` VARCHAR( 20 ) NOT NULL COMMENT  '회원고유번호',
 `url` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '외부링크',
 `mess` text NOT NULL COMMENT '메시지',
 `jiyeog` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '지역값',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gonggcm` (  `project` ,  `recnum` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//공지사항 리스트
		$tbname[18] = $ft."AAmyGongji";
		$tb[18] = "CREATE TABLE  `".$dbn."`.`".$tbname[18]."` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`gjnum` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT '공지사항이미지아이디',
`companyid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '작성자 아이디',
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '프로젝트 이름을 기록',
`title` text NOT NULL COMMENT '제목입력',
`title2` text NOT NULL COMMENT '소제목',
`jangso` text NOT NULL COMMENT '장소설정',
`url` varchar( 120 ) NOT NULL DEFAULT '0' COMMENT '관련주소',
`gongji` text NOT NULL COMMENT '공지사항',
`fromid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '보낸사람아이디',
`gjtel` varchar( 14 ) NOT NULL DEFAULT '000-0000-000' COMMENT '문의 전화',
`sday` varchar( 10 ) NOT NULL DEFAULT '0000-00-00' COMMENT '시작일자',
`eday` varchar( 10 ) NOT NULL DEFAULT '0000-00-00' COMMENT '종료일자',
`stime` varchar( 8 ) NOT NULL DEFAULT '00:00 Am' COMMENT '시작시간',
`etime` varchar( 8 ) NOT NULL DEFAULT '00:00 Am' COMMENT '종료시간',
`latpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT '위도',
`longpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT '경도',
`vinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: 보이지않는다., 1: 보인다.',
`jiyeog` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '지역값',
`allinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:일반공지,1:전체공지',
`indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `myGongji` (  `project` , `companyid` ,  `fromid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//gcm 발송 리스트
		$tbname[19] = $ft."soho_AAmyGcmSendList ";
		$tb[19] = "CREATE TABLE  `".$dbn."`.`".$tbname[19]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람',
 `gcmrecid` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'gcm 레코드 번호',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 명을 입력한다.',
 `sendday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '보낸 일시',
 `readday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '읽은 일시',
UNIQUE KEY  `id` (  `project` ,  `memid` ,  `udid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//새로운 공지 발송현황
		$tbname[20] = $ft."AAmyGcm";
		$tb[20] = "CREATE TABLE  `".$dbn."`.`".$tbname[20]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `recnum` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '공지사항의 레코드 번호',
 `newinf` TINYINT( 3 ) NOT NULL DEFAULT  '0',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `wrinf` INT( 11 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 이름을 기록',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '회원고유번호',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `b` INT( 11 ) NOT NULL DEFAULT  '0',
UNIQUE KEY  `babynewWr` (  `project` ,  `companyid` ,  `tomemid` ,  `udid` ,  `id` ) ,
KEY  `newmess` (  `tomemid` ,  `udid` ,  `recnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//비밀번호 변경 임시기록
		$tbname[21] = $ft."AAmyPasschn";
		$tb[21] = "CREATE TABLE  `".$dbn."`.`".$tbname[21]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `passinf` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '비번 확인값',
 `imsi` VARCHAR( 12 ) NOT NULL DEFAULT  'MTIzNA==' COMMENT  '임시 비번',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '입력일시',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `passchn` (  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";

		
		
		//나의 현재 테이블 위치
		$tbname[22] = $ft."Anyting_mypo";
		$tb[22] = "CREATE TABLE  `".$dbn."`.`".$tbname[22]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `tbnum` INT( 5 ) NOT NULL DEFAULT  '1' COMMENT  '받는 사람테이블번호',
 `fromnum` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람',
 `recnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '실제글의 레코드번호',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: 새로운 메세지 없음, 1: 새메세지 있음',
 `managid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '메니저의 고유아이디',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '받는 사람의 아이디',
 `wrinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '쓰기의 상태',
 `pauseok` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: 알림전, 1: 알림횟수, 9:gcm',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `companyid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//매니저 관리 테이블
		$tbname[23] = $ft."Anyting_manager";
		$tb[23] = "CREATE TABLE  `".$dbn."`.`".$tbname[23]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `name` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '이름',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '가맹점',
 `meminf` TINYINT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '11: 매니저신청, 1:매니저',
 `uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '폰고유번호',
 `indate` DATE NOT NULL DEFAULT  '0000-00-00' COMMENT  '등록일자',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `memid` (  `memid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//마스터 테이블
		$tbname[24] = $ft."Anyting_master";
		$tb[24] = "CREATE TABLE  `".$dbn."`.`".$tbname[24]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `tbnum` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '나의 테이블번호',
 `pass` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '업체제공 패스',
 `uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '폰고유번호',
 `nickname` VARCHAR( 80 ) NOT NULL DEFAULT  '0' COMMENT  '닉네임 설정',
 `sex` VARCHAR( 1 ) NOT NULL DEFAULT  'm' COMMENT  'm:남,g:여',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: 새로운 메세지 없음, 1: 새메세지 있음',
 `roomInf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:초기화전, 1: 열기, 2:부킹, 3:닫기',
UNIQUE KEY  `mastid` (  `id` ) ,
KEY  `master` (  `companyid` ,  `tbnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		


		//공지사항 이미지 테이블
		$tbname[25] = $ft."AAmyGgImg";
		$tb[25] = "CREATE TABLE  `".$dbn."`.`".$tbname[25]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `gjnum` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '공지사항 고유번호',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트 이름을 기록',
 `memo` TEXT NOT NULL COMMENT  '이미지설명',
 `url` VARCHAR( 120 ) NOT NULL DEFAULT  '0' COMMENT  '관련주소',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '이미지이름',
 `numb` INT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '이미지번호',
 `inf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:카메라, 2:링크',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `myGongji` (  `project` ,  `gjnum` ,  `numb` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '공지사항의 이미지'";

		
		//기본 링크 테이블
		$tbname[26] = $ft."AAmyGgBasLink";
		$tb[26] = "CREATE TABLE  `".$dbn."`.`".$tbname[26]."` (
`id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트 이름을 기록',
 `url` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '관련주소',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `myGongji` (  `project` ,  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '업체의 기본 링크'";














//처음 부터 여기 까지는 twin7 관련 테이블들
//============================================================================================

		//기본 링크 테이블
		$tbname[27] = $ft."AAmyClass";
		$tb[27] = "CREATE TABLE  `".$dbn."`.`".$tbname[27]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `classnam` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  '클래스이름',
 `damdang` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '담당자 아이디',
 `age` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '학년 번호',
 `dispinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `age` ,  `damdang` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '개설된 과목 리스트'";




		//기본 링크 테이블
		$tbname[28] = $ft."AAmyClassSai";
		$tb[28] = "CREATE TABLE  `".$dbn."`.`".$tbname[28]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '학생의 고유번호',
 `memidst` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '학생아이디',
 `memidbu` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '부모아이디',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `memidbu` ,  `memidst` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '학생과 부모의 관계를 설정'";


		//기본 링크 테이블
		$tbname[29] = $ft."AAmyClassSeSt";
		$tb[29] = "CREATE TABLE  `".$dbn."`.`".$tbname[29]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memidst` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '학생아이디',
 `testinf` TINYINT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '1:시험대기, 2:시험참여',
 `clsid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '과목 번호',
 `memidtc` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '교사아이디',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `classsest` (  `project` ,  `clsid` ,  `memidst` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '각학생이 수강하는 과목 리스트'";



		//기본 링크 테이블
		$tbname[30] = $ft."AAmyClassTest";
		$tb[30] = "CREATE TABLE  `".$dbn."`.`".$tbname[30]."` (
`id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `damdang` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '교사아이디',
 `wrmode` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1.단계적풀이, 2.전체풀이',
 `tpass` varchar( 15  )  NOT  NULL DEFAULT  'MTIzNA==' COMMENT  '2차 암호',
 `clsid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '클래스 고유번호',
 `testday` datetime NOT  NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '시험일시',
 `munsu` tinyint( 4  )  NOT  NULL DEFAULT  '0' COMMENT  '문항수',
 `testtime` int( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '시험시간',
 `testinf` tinyint( 1  )  NOT  NULL DEFAULT  '0' COMMENT  '1:준비, 2:테스트, 3:종료',
 `testnum` tinyint( 4  )  NOT  NULL DEFAULT  '0' COMMENT  '현재풀이하는 번호',
 `stTime` datetime NOT  NULL  COMMENT  '시험 시작시간',
 `eTime` datetime NOT  NULL  COMMENT  '시험 종료시간',
 `m1` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m2` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m3` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m4` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m5` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m6` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m7` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m8` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m9` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m10` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m11` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m12` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m13` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m14` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m15` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m16` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m17` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m18` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m19` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m20` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m21` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m22` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m23` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m24` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m25` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m26` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m27` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m28` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m29` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m30` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m31` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m32` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m33` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m34` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m35` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m36` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m37` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m38` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m39` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m40` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m41` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m42` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m43` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m44` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m45` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m46` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m47` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m48` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m49` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '문제',
 `m50` varchar( 150  )  NOT  NULL DEFAULT  '0',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `classsest` (  `clsid` ,  `damdang`, `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '각학생이 수강하는 과목 리스트'";



		//기본 링크 테이블
		$tbname[31] = $ft."AAmyClassTestRs";
		$tb[31] = "CREATE TABLE  `".$dbn."`.`".$tbname[31]."` (
`testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '시험의 고유번호',
 `testgoinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:시험계속, 2:시험종료',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '나의 아이디',
 `stTime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '시험에 응시한 시간',
 `eTime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '답안 제출시간',
 `oninf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:출석, 2결석, 3지각, 4답안제출',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `jeomsu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '내가 받은 점수',
KEY  `testst` (  `testid` ,  `memid` ,  `stTime` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '각 학생의 시험 결과를 기록한다.'";



		//기본 링크 테이블
		$tbname[32] = $ft."AAmyClassTestSt";
		$tb[32] = "CREATE TABLE  `".$dbn."`.`".$tbname[32]."` (
`testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '시험의 고유번호',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '나의 아이디',
 `mun` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '문제의 필드이름',
 `mydab` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '나의 답',
 `orgdab` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '정답',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `jeomsu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '내가 받은 점수',
KEY  `testst` (  `testid` ,  `memid` ,  `mun` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '학생이 입력한 답안'";


		//기본 링크 테이블
		$tbname[33] = $ft."AAmyJGan";
		$tb[33] = "CREATE TABLE  `".$dbn."`.`".$tbname[33]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `jibu` TINYINT( 5 ) NOT NULL DEFAULT  '1' COMMENT  '각 지부 구분',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '작성자 아이디',
 `jang` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '장',
 `title` TEXT NOT NULL COMMENT  '대제목',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `jo` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '조',
 `sub1` TEXT NOT NULL ,
 `mmo` TEXT NOT NULL ,
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00',
UNIQUE KEY  `babynewWr` (  `companyid` ,  `id` ) ,
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//기본 링크 테이블
		$tbname[34] = $ft."AAmyMmenu";
		$tb[34] = "CREATE TABLE  `".$dbn."`.`".$tbname[34]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `maingab` INT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '메인메뉴',
 `mainname` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '메뉴이름',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0',
UNIQUE KEY  `babynewWr` ( `project`,  `companyid` ,  `id` ) ,
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//기본 링크 테이블
		$tbname[35] = $ft."AAmySlogon";
		$tb[35] = "CREATE TABLE  `".$dbn."`.`".$tbname[35]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '회장이미지',
 `slogon` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '슬로건',
 `spo` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  '직책',
 `name` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '회장이름',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
 `jiyeog` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '지구',
 `jibu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '지부선택',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '등록자 아이디',
 `inday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '등록일자',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `companyid` ,  `spo` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//기본 링크 테이블
		$tbname[36] = $ft."AAmySmenu";
		$tb[36] = "CREATE TABLE  `".$dbn."`.`".$tbname[36]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `mainid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '메인메뉴아이디',
 `sname` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '서버메뉴이름',
 `smenval` INT( 4 ) NOT NULL DEFAULT  '0' COMMENT  '서버메뉴값',
 `url` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '서버메뉴링크',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `menu` (  `mainid` ,  `smenval` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//기본 링크 테이블
		$tbname[37] = $ft."AAmyTestGcm";
		$tb[37] = "CREATE TABLE  `".$dbn."`.`".$tbname[37]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `frommem` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '보낸사람',
 `tomem` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '받는사람',
 `sonid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '자녀아이디',
 `testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '시험고유번호',
 `companyid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '업체아이디',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL ,
 `url` VARCHAR( 300 ) NOT NULL DEFAULT  '0',
 `mess` TEXT NOT NULL COMMENT  '메시지',
 `day` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '보낸날자',
 `redinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1: 읽기전',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gonggcm` (  `project` ,  `frommem` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '학원시험 결과를 전달 한다.'";




		//기본 링크 테이블
		$tbname[38] = $ft."AAmyWmenu";
		$tb[38] = "CREATE TABLE  `".$dbn."`.`".$tbname[38]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `webpass` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '웹 비밀번호',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '관리자아이디',
 `url` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '메뉴관리웹주소',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `url` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '웹에서 메뉴설정을 하기 위한 비번'";

		
		
		//기본 링크 테이블
		$tbname[39] = $ft."AAcarMemul";
		$tb[39] = "CREATE TABLE  `".$dbn."`.`".$tbname[39]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `imgnum` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '아이디 레코드번호',
 `saleid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '판매자 아이디',
 `cardon` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '판매 금액',
 `mkid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '제조사아이디',
 `yongdoid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '용도아이디',
 `modelnid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '모델명아이디',
 `modelS` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '모델상세구분아이디',
 `modelst` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '모델 등급',
 `transm` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '변속기',
 `cary` INT( 5 ) NOT NULL DEFAULT  '1999' COMMENT  '년식',
 `carm` INT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '년식월',
 `carkm` INT( 7 ) NOT NULL DEFAULT  '0' COMMENT  '주행거리',
 `carcolor` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '자동차 칼라',
 `caroil` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '연료',
 `carcc` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '배기량',
 `cartel` VARCHAR( 15 ) NOT NULL DEFAULT  '0000-0000-0000' COMMENT  '문의전화',
 `dispinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제,2:매매',
 `inday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '등록일자',
 `saleday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '판매 일자',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '기업아이디',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `project` ,  `dispinf` ,  `mkid` ,  `yongdoid` ,  `modelnid` ,  `modelS` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '자동차 매물 정보'";

		
		
		
		//기본 링크 테이블
		$tbname[40] = $ft."AAcarMemulText";
		$tb[40] = "CREATE TABLE  `".$dbn."`.`".$tbname[40]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `recid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '매물레코드아이디',
 `imgnum` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '이미지 번호',
 `cartxt` text NOT  NULL  COMMENT  '설명',
 UNIQUE  KEY  `id` (  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차 제조사'";
 


		//기본 링크 테이블
		$tbname[41] = $ft."AAcarMk";
		$tb[41] = "CREATE TABLE  `".$dbn."`.`".$tbname[41]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `carmk` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '제조사 이름',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '기업아이디',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `carmk`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차 제조사'";
 
 
		//기본 링크 테이블
		$tbname[42] = $ft."AAcarModel";
		$tb[42] = "CREATE TABLE  `".$dbn."`.`".$tbname[42]."` (

  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '제조사아이디',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '용도아이디',
 `modeln` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '모델명',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '기업아이디',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdoid` ,  `modeln`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차 모델명'";
 
 
		//기본 링크 테이블
		$tbname[43] = $ft."AAcarModelGubun";
		$tb[43] = "CREATE TABLE  `".$dbn."`.`".$tbname[43]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '제조사아이디',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '용도아이디',
 `modelnid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '모델명아이디',
 `modelS` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '모델상세구분',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '기업아이디',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdoid` ,  `modelnid`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차 모델별 형식구분'";
 

		//기본 링크 테이블
		$tbname[44] = $ft."AAcarStep";
		$tb[44] = "CREATE TABLE  `".$dbn."`.`".$tbname[44]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '제조사',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '용도아이디',
 `modelnid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '모델 아이디',
 `modelSid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '모델 상세',
 `modelSt` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '모델 등급',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '기업아이디',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `mkid` ,  `yongdoid` ,  `modelnid` ,  `modelSid` ,  `modelSt`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차 등급'";
 
 
 		//기본 링크 테이블
		$tbname[45] = $ft."AAcarYongdo";
		$tb[45] = "CREATE TABLE  `".$dbn."`.`".$tbname[45]."` (
 
  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `yongdo` varchar( 100  )  NOT  NULL DEFAULT  '승용' COMMENT  '자동차 용도',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:출력, 0:삭제',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '프로젝트이름',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '기업아이디',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdo`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '자동차를 용도로 구분'";

 
 		//기본 링크 테이블
		$tbname[46] = $ft."AAmyTextSend";
		$tb[46] = "CREATE TABLE  `".$dbn."`.`".$tbname[46]."` (
 
  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `frommem` varchar( 12  )  NOT  NULL DEFAULT  '0' COMMENT  '보낸사람',
 `tomem` varchar( 12  )  NOT  NULL DEFAULT  '0' COMMENT  '받는사람',
 `companyid` varchar( 20  )  NOT  NULL DEFAULT  '0' COMMENT  '업체아이디',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0',
 `udid` varchar( 20  )  NOT  NULL ,
 `url` varchar( 300  )  NOT  NULL DEFAULT  '0',
 `mess` text NOT  NULL  COMMENT  '메시지',
 `day` datetime NOT  NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '보낸날자',
 `redinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1: 읽기전',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `gonggcm` (  `project` ,  `frommem` ,  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '학원시험 결과를 전달 한다.'";
 
 
 
		
		
		//테이블의 존재 여부를 확인하고 없다면 만든다.
		for($c = 0; $c < 27; $c++){
			if($this->is_mysqltable($this->DB, $tbname[$c]) == 0)	$this->query($tb[$c]);  //테이블이 없는 경우 생성 한다.
		}
	}


}
?>