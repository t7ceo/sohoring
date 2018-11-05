<?
/*======================================================================================================
�� ������		::	��� ���� ���̺�
�� ���ʰ�����	::	5�� 27��
�� ������		::	
�� ����Ʈ		::	http://mlrl2000.cafe24.com
�� ������		::	�輺��
�� ������		::	2013�� 5�� 27��
======================================================================================================*/
//����ϴ� ���̺�
//soho_Anyting_gcmid

class Tbcont extends MySQL
{
/*========================================================================
	�Լ� �̸� :	create_basicTb("", dbname)
	file �̸� : dbTableMk.php

	## �⺻ ���̺��� �����.
	UNIQUE KEY  `id` (  `id` ) ,  �߰� �ʿ�
==========================================================================*/
	function create_basicTb($ft, $dbn)
	{
		
		//ȸ�� ���̺� �����
		$tbname[0] = $ft."Anyting_member";
		$tb[0] = "CREATE TABLE  `".$dbn."`.`".$tbname[0]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT , 
`memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�', 
`pass` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '���', 
`email` VARCHAR( 30 ) NOT NULL DEFAULT  '0' COMMENT  '�̸���', 
`tel` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '��ȭ��ȣ', 
`meminf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:�Ŵ���,2:����, 9:�� ������', 
`indate` DATE NOT NULL DEFAULT  '0000-00-00', 
`uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '��������ȣ',
UNIQUE KEY  `id` (  `id` ) ,KEY  `memid` (  `memid` )) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//ȸ�� ���̺� �߰� ����
		$tbname[1] = $ft."Anyting_memberAdd";
		$tb[1] = "CREATE TABLE `".$dbn."`.`".$tbname[1]."` ( 
`id` int( 11 ) NOT NULL AUTO_INCREMENT , 
`memid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT 'ȸ�����̵�', 
`name` varchar( 50 ) NOT NULL DEFAULT '0' COMMENT 'ȸ�� �̸�', 
`bday` date NOT NULL DEFAULT '0000-00-00' COMMENT '�������', 
`adpass` varchar( 20 ) NOT NULL DEFAULT '0' COMMENT '�߰����� ���', 
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '������Ʈ �̸�', 
`memup` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '�����û', 
`mempo` tinyint( 2 ) NOT NULL DEFAULT '0', 
`position` text NOT NULL , 
`addr` text NOT NULL COMMENT '�ּ�', 
`mtel` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT 'ȸ����ȭ��ȣ', 
`otel` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT '�繫�� ��ȭ', 
`sex` tinyint( 1 ) NOT NULL DEFAULT '1' COMMENT '���� ��', 
`coname` text NOT NULL COMMENT '��ü��', 
`copo` text NOT NULL COMMENT '��å ����', 
`upjong` varchar( 300 ) NOT NULL DEFAULT '0' COMMENT '��������', 
`courl` varchar( 200 ) NOT NULL DEFAULT '0' COMMENT '��üurl', 
`perimg` varchar( 20 ) NOT NULL DEFAULT 'noperimg.jpg' COMMENT 'ȸ�� ����', 
`jiyeog` tinyint( 2 ) NOT NULL DEFAULT '0', 
`jibu` tinyint( 2 ) NOT NULL DEFAULT '0', 
`jijeom` tinyint( 2 ) NOT NULL DEFAULT '0', 
`udid` varchar( 20 ) NOT NULL DEFAULT '0' COMMENT '��������ȣ', 
`talk` text NOT NULL COMMENT '�ϰ��¸�', 
`sname` varchar( 50 ) NOT NULL DEFAULT '0' COMMENT '�ڳ��̸�', 
`sonid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '�ڳ��� ���̵�', 
`jage` tinyint( 3 ) NOT NULL DEFAULT '0' COMMENT '�ڳ��� ����', 
`clsnam` int( 11 ) NOT NULL DEFAULT '0' COMMENT '�ڳ��� Ŭ�������̵�', 
`indate` DATE NOT NULL DEFAULT  '0000-00-00',
UNIQUE KEY  `id` (  `id` ) ,KEY  `memid` (  `project`, `memid` )) ENGINE = MYISAM DEFAULT CHARSET = utf8"; 
		
		
		//ȸ�� ���̺� �߰� ����
		$tbname[2] = $ft."Anyting_test";
		$tb[2] = "CREATE TABLE  `".$dbn."`.`".$tbname[2]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `t1` VARCHAR( 30 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
 `t2` VARCHAR( 30 ) NOT NULL DEFAULT  '0',
 `t3` VARCHAR( 30 ) NOT NULL DEFAULT  '0',
 `db1` DOUBLE NOT NULL DEFAULT  '0',
 `db2` DOUBLE NOT NULL DEFAULT  '0',
 `db3` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '����',
 `txt` TEXT NOT NULL COMMENT  '����',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `t1` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//GCM id ���̺�
		$tbname[3] = $ft."soho_Anyting_gcmid";
		$tb[3] = "CREATE TABLE  `".$dbn."`.`".$tbname[3]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ���',
 `phonum` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  'ȸ����ȭ��ȣ',
 `gcmid` VARCHAR( 254 ) NOT NULL DEFAULT  '0' COMMENT  '������ �޼���',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ ���� �Է��Ѵ�.',
 `bell` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:�⺻�� ���� �︮�� �ʴ´�.',
 `endtime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���������� �޽��� �ݵ� �ð�',
 `login` VARCHAR( 3 ) NOT NULL DEFAULT  'ok' COMMENT  'no:�α׾ƿ�,ok:�α���',
 `ver_num` VARCHAR( 10 ) NOT NULL DEFAULT  '1.0' COMMENT  '������� �۹���',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gcmid` (  `project` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		
		//���Ĵ� ���̺� ����
		$tbname[4] = $ft."Anyting_company";
		$tb[4] = "CREATE TABLE  `".$dbn."`.`".$tbname[4]."` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`companyid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '������̵�',
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '������Ʈ �̸�',
`gubun` tinyint( 3 ) NOT NULL DEFAULT '1' COMMENT '1:ȣ��,2:Ŀ��,3:ī��7:�̺�Ʈ',
`masterid` varchar( 60 ) NOT NULL DEFAULT '0' COMMENT '�������� ���̵�',
`ymanid` varchar( 10 ) NOT NULL DEFAULT '0' COMMENT '�����ھ��̵�',
`coname` varchar( 100 ) NOT NULL DEFAULT 'Hong gil dong Co' COMMENT '�������� ��ǥ�̸��� ����',
`sangho` varchar( 255 ) NOT NULL DEFAULT '0' COMMENT '��ȣ',
`memo` text NOT NULL COMMENT '����',
`tel` varchar( 13 ) NOT NULL DEFAULT '0' COMMENT '��ü��ȭ',
`jygab` int( 3 ) NOT NULL DEFAULT '0' COMMENT '����',
`juso` varchar( 500 ) NOT NULL DEFAULT '0' COMMENT '�ּ�',
`url` varchar( 200 ) NOT NULL DEFAULT '0' COMMENT 'Ȩ������',
`inname` varchar( 60 ) NOT NULL DEFAULT '0' COMMENT '�Ա��� �̸�',
`inday` DATE NOT NULL DEFAULT  '0000-00-00' COMMENT  '�Ա�����',
`indon` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '�Աݾ�',
`ondon` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '���� �Աݾ�',
`oninf` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '0:��¾���, 1:�����',
`star` tinyint( 1 ) NOT NULL DEFAULT '0' COMMENT '���ڰ� ������ ���� ���',		
`indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�������',
`ondate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���� ��������',
`enddate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���� ��������',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `companyindex` (  `project` , `gubun`,  `companyid` ,   `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//��ü �̹��� ���̺� ����
		$tbname[5] = $ft."Anyting_comimg";
		$tb[5] = "CREATE TABLE  `".$dbn."`.`".$tbname[5]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�̹��� �̸�',
 `manphoto` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�������',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `comimg` (  `companyid` ,  `imgname` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//��ü GPS ����
		$tbname[6] = $ft."Anyting_comgps";
		$tb[6] = "CREATE TABLE  `".$dbn."`.`".$tbname[6]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
 `latpo` DOUBLE NOT NULL DEFAULT  '12.1212121',
 `longpo` DOUBLE NOT NULL DEFAULT  '12.1212121',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `companyid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//�۹��� ����
		$tbname[7] = $ft."Anyting_appinf";
		$tb[7] = "CREATE TABLE  `".$dbn."`.`".$tbname[7]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `ver_num` VARCHAR( 10 ) NOT NULL DEFAULT  '1.0' COMMENT  '������� �۹���',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '1.0' COMMENT  'project',
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//���� �Խ��� ǥ��
		$tbname[8] = $ft."AAonSangdamTb";
		$tb[8] = "CREATE TABLE  `".$dbn."`.`".$tbname[8]."` (
`id` DOUBLE NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '��ü���� �н�',
 `pauseinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '1: Ǫ�����',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '����ð�',
UNIQUE KEY  `mastid` (  `companyid` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//�������� ���ο� ��ȭ ����Ʈ
		$tbname[9] = $ft."AAmyPo";
		$tb[9] = "CREATE TABLE  `".$dbn."`.`".$tbname[9]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `messid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�۹�ȣ',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: ���ο� �޼��� ����, 1: ���޼��� ����',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����������̵�',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ����� ���̵�',
 `wrinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '������ ����',
 `popinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '�˾� ���ڸ� ����Ѵ�.',
UNIQUE KEY  `aamypo` (  `companyid` ,  `tomemid` ,  `fromid` ,  `id` ) ,
KEY  `newmess` (  `newinf` ,  `tomemid` ,  `messid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//�������� ���ο� ��ȭ ����Ʈ
		$tbname[10] = $ft."AAmyOnecutRe";
		$tb[10] = "CREATE TABLE  `".$dbn."`.`".$tbname[10]."` (
`idnum` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `id` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�۾��̵�',
 `review` TEXT NOT NULL COMMENT  '���Ƹ���',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����������̵�',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `idnum` (  `idnum` ) ,
KEY  `onere` (  `id` ,  `fromid` ,  `idnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//�������� ���ο� ��ȭ ����Ʈ
		$tbname[11] = $ft."AAmyOnecutimg";
		$tb[11] = "CREATE TABLE  `".$dbn."`.`".$tbname[11]."` (
`id` INT( 11 ) NOT NULL DEFAULT  '0',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�̹��� �̸�',
KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `imgname` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//���� �̹����� ���� �Ѵ�.
		$tbname[12] = $ft."AAmyOnecut";
		$tb[12] = "CREATE TABLE  `".$dbn."`.`".$tbname[12]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ �̸��� ���',
 `bloginf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '��α� ��������',
  `title` TEXT NOT NULL COMMENT  '��α� ����',
 `memo` TEXT NOT NULL COMMENT  '���Ƹ���',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����������̵�',
 `gubun` VARCHAR( 5 ) NOT NULL DEFAULT  '0' COMMENT  'not:����, love:����',
 `categori` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  'ī�װ� ����',
 `url` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  '�����ڷ� ��ũ',
 `latpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '����',
 `longpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '�浵',
 `vnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '��ȸ����',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `project` ,  `companyid` ,  `fromid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//��ü �޽����� �߼� ���ڸ� ����
		$tbname[13] = $ft."AAmyMessSendSu";
		$tb[13] = "CREATE TABLE  `".$dbn."`.`".$tbname[13]."` (
`messid` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'messge id',
 `sendsu` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '�޽��� ���� ��',
KEY  `messsends` (  `messid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//�޼����� ��� �Ѵ�.
		$tbname[14] = $ft."AAmyMess";
		$tb[14] = "CREATE TABLE  `".$dbn."`.`".$tbname[14]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `message` TEXT NOT NULL COMMENT  '������ �޼���',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����������̵�',
 `tomanid` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ��� ���̵�',
 `peinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '2:�ܼ��˸�,1: ȸ������ �޽��� ��ȯ�̴�.',
 `onecutid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '���Ƹ����� ���̵�',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `mymess` (  `companyid` ,  `tomanid` ,  `fromid` ,  `id` ) ,
KEY  `newmess` (  `tomanid` ,  `indate` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//����ڿ� ���� �޸� ���
		$tbname[15] = $ft."AAmyMemo";
		$tb[15] = "CREATE TABLE  `".$dbn."`.`".$tbname[15]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `tomem` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ���',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `wrt` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ���',
 `mmo` TEXT NOT NULL COMMENT  '������ �޼���',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `babynewWr` (  `companyid` ,  `wrt` ,  `tomem` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//����ڿ� ���� �޸� ���
		$tbname[16] = $ft."AAmyGongjiRe";
		$tb[16] = "CREATE TABLE  `".$dbn."`.`".$tbname[16]."` (
`idnum` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `id` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�۾��̵�',
 `review` TEXT NOT NULL COMMENT  '���Ƹ���',
 `fromid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����������̵�',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `idnum` (  `idnum` ) ,
KEY  `babynewWr` (  `id` ,  `fromid` ,  `idnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//����ڿ� ���� �޸� ���
		$tbname[17] = $ft."AAmyGongjiGcm";
		$tb[17] = "CREATE TABLE  `".$dbn."`.`".$tbname[17]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `recnum` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'gcm ���ڵ� ��ȣ',
 `newinf` TINYINT( 3 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ �̸��� ���',
 `udid` VARCHAR( 20 ) NOT NULL COMMENT  'ȸ��������ȣ',
 `url` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '�ܺθ�ũ',
 `mess` text NOT NULL COMMENT '�޽���',
 `jiyeog` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '������',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gonggcm` (  `project` ,  `recnum` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//�������� ����Ʈ
		$tbname[18] = $ft."AAmyGongji";
		$tb[18] = "CREATE TABLE  `".$dbn."`.`".$tbname[18]."` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`gjnum` varchar( 14 ) NOT NULL DEFAULT '0' COMMENT '���������̹������̵�',
`companyid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '�ۼ��� ���̵�',
`project` varchar( 15 ) NOT NULL DEFAULT '0' COMMENT '������Ʈ �̸��� ���',
`title` text NOT NULL COMMENT '�����Է�',
`title2` text NOT NULL COMMENT '������',
`jangso` text NOT NULL COMMENT '��Ҽ���',
`url` varchar( 120 ) NOT NULL DEFAULT '0' COMMENT '�����ּ�',
`gongji` text NOT NULL COMMENT '��������',
`fromid` varchar( 12 ) NOT NULL DEFAULT '0' COMMENT '����������̵�',
`gjtel` varchar( 14 ) NOT NULL DEFAULT '000-0000-000' COMMENT '���� ��ȭ',
`sday` varchar( 10 ) NOT NULL DEFAULT '0000-00-00' COMMENT '��������',
`eday` varchar( 10 ) NOT NULL DEFAULT '0000-00-00' COMMENT '��������',
`stime` varchar( 8 ) NOT NULL DEFAULT '00:00 Am' COMMENT '���۽ð�',
`etime` varchar( 8 ) NOT NULL DEFAULT '00:00 Am' COMMENT '����ð�',
`latpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT '����',
`longpo` DOUBLE NOT NULL DEFAULT  '0' COMMENT '�浵',
`vinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: �������ʴ´�., 1: ���δ�.',
`jiyeog` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '������',
`allinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:�Ϲݰ���,1:��ü����',
`indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `myGongji` (  `project` , `companyid` ,  `fromid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//gcm �߼� ����Ʈ
		$tbname[19] = $ft."soho_AAmyGcmSendList ";
		$tb[19] = "CREATE TABLE  `".$dbn."`.`".$tbname[19]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ���',
 `gcmrecid` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  'gcm ���ڵ� ��ȣ',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ ���� �Է��Ѵ�.',
 `sendday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���� �Ͻ�',
 `readday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���� �Ͻ�',
UNIQUE KEY  `id` (  `project` ,  `memid` ,  `udid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//���ο� ���� �߼���Ȳ
		$tbname[20] = $ft."AAmyGcm";
		$tb[20] = "CREATE TABLE  `".$dbn."`.`".$tbname[20]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `recnum` INT( 12 ) NOT NULL DEFAULT  '0' COMMENT  '���������� ���ڵ� ��ȣ',
 `newinf` TINYINT( 3 ) NOT NULL DEFAULT  '0',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `wrinf` INT( 11 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ �̸��� ���',
 `udid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  'ȸ��������ȣ',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `b` INT( 11 ) NOT NULL DEFAULT  '0',
UNIQUE KEY  `babynewWr` (  `project` ,  `companyid` ,  `tomemid` ,  `udid` ,  `id` ) ,
KEY  `newmess` (  `tomemid` ,  `udid` ,  `recnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//��й�ȣ ���� �ӽñ��
		$tbname[21] = $ft."AAmyPasschn";
		$tb[21] = "CREATE TABLE  `".$dbn."`.`".$tbname[21]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `passinf` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '��� Ȯ�ΰ�',
 `imsi` VARCHAR( 12 ) NOT NULL DEFAULT  'MTIzNA==' COMMENT  '�ӽ� ���',
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Է��Ͻ�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `passchn` (  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";

		
		
		//���� ���� ���̺� ��ġ
		$tbname[22] = $ft."Anyting_mypo";
		$tb[22] = "CREATE TABLE  `".$dbn."`.`".$tbname[22]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `tbnum` INT( 5 ) NOT NULL DEFAULT  '1' COMMENT  '�޴� ������̺��ȣ',
 `fromnum` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '�������',
 `recnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�������� ���ڵ��ȣ',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: ���ο� �޼��� ����, 1: ���޼��� ����',
 `managid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�޴����� �������̵�',
 `tomemid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�޴� ����� ���̵�',
 `wrinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '������ ����',
 `pauseok` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: �˸���, 1: �˸�Ƚ��, 9:gcm',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `companyid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//�Ŵ��� ���� ���̺�
		$tbname[23] = $ft."Anyting_manager";
		$tb[23] = "CREATE TABLE  `".$dbn."`.`".$tbname[23]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `name` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�̸�',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '������',
 `meminf` TINYINT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '11: �Ŵ�����û, 1:�Ŵ���',
 `uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '��������ȣ',
 `indate` DATE NOT NULL DEFAULT  '0000-00-00' COMMENT  '�������',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `memid` (  `memid` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		
		
		//������ ���̺�
		$tbname[24] = $ft."Anyting_master";
		$tb[24] = "CREATE TABLE  `".$dbn."`.`".$tbname[24]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `tbnum` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '���� ���̺��ȣ',
 `pass` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '��ü���� �н�',
 `uiu` VARCHAR( 18 ) NOT NULL DEFAULT  '0' COMMENT  '��������ȣ',
 `nickname` VARCHAR( 80 ) NOT NULL DEFAULT  '0' COMMENT  '�г��� ����',
 `sex` VARCHAR( 1 ) NOT NULL DEFAULT  'm' COMMENT  'm:��,g:��',
 `newinf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0: ���ο� �޼��� ����, 1: ���޼��� ����',
 `roomInf` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:�ʱ�ȭ��, 1: ����, 2:��ŷ, 3:�ݱ�',
UNIQUE KEY  `mastid` (  `id` ) ,
KEY  `master` (  `companyid` ,  `tbnum` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		


		//�������� �̹��� ���̺�
		$tbname[25] = $ft."AAmyGgImg";
		$tb[25] = "CREATE TABLE  `".$dbn."`.`".$tbname[25]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `gjnum` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '�������� ������ȣ',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ �̸��� ���',
 `memo` TEXT NOT NULL COMMENT  '�̹�������',
 `url` VARCHAR( 120 ) NOT NULL DEFAULT  '0' COMMENT  '�����ּ�',
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '�̹����̸�',
 `numb` INT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '�̹�����ȣ',
 `inf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:ī�޶�, 2:��ũ',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `myGongji` (  `project` ,  `gjnum` ,  `numb` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '���������� �̹���'";

		
		//�⺻ ��ũ ���̺�
		$tbname[26] = $ft."AAmyGgBasLink";
		$tb[26] = "CREATE TABLE  `".$dbn."`.`".$tbname[26]."` (
`id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ �̸��� ���',
 `url` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '�����ּ�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `myGongji` (  `project` ,  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '��ü�� �⺻ ��ũ'";














//ó�� ���� ���� ������ twin7 ���� ���̺��
//============================================================================================

		//�⺻ ��ũ ���̺�
		$tbname[27] = $ft."AAmyClass";
		$tb[27] = "CREATE TABLE  `".$dbn."`.`".$tbname[27]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `classnam` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  'Ŭ�����̸�',
 `damdang` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����� ���̵�',
 `age` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '�г� ��ȣ',
 `dispinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `age` ,  `damdang` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '������ ���� ����Ʈ'";




		//�⺻ ��ũ ���̺�
		$tbname[28] = $ft."AAmyClassSai";
		$tb[28] = "CREATE TABLE  `".$dbn."`.`".$tbname[28]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memnum` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�л��� ������ȣ',
 `memidst` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�л����̵�',
 `memidbu` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�θ���̵�',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `memidbu` ,  `memidst` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '�л��� �θ��� ���踦 ����'";


		//�⺻ ��ũ ���̺�
		$tbname[29] = $ft."AAmyClassSeSt";
		$tb[29] = "CREATE TABLE  `".$dbn."`.`".$tbname[29]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `memidst` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�л����̵�',
 `testinf` TINYINT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '1:������, 2:��������',
 `clsid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '���� ��ȣ',
 `memidtc` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `classsest` (  `project` ,  `clsid` ,  `memidst` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '���л��� �����ϴ� ���� ����Ʈ'";



		//�⺻ ��ũ ���̺�
		$tbname[30] = $ft."AAmyClassTest";
		$tb[30] = "CREATE TABLE  `".$dbn."`.`".$tbname[30]."` (
`id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `damdang` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 `wrmode` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1.�ܰ���Ǯ��, 2.��üǮ��',
 `tpass` varchar( 15  )  NOT  NULL DEFAULT  'MTIzNA==' COMMENT  '2�� ��ȣ',
 `clsid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  'Ŭ���� ������ȣ',
 `testday` datetime NOT  NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�����Ͻ�',
 `munsu` tinyint( 4  )  NOT  NULL DEFAULT  '0' COMMENT  '���׼�',
 `testtime` int( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '����ð�',
 `testinf` tinyint( 1  )  NOT  NULL DEFAULT  '0' COMMENT  '1:�غ�, 2:�׽�Ʈ, 3:����',
 `testnum` tinyint( 4  )  NOT  NULL DEFAULT  '0' COMMENT  '����Ǯ���ϴ� ��ȣ',
 `stTime` datetime NOT  NULL  COMMENT  '���� ���۽ð�',
 `eTime` datetime NOT  NULL  COMMENT  '���� ����ð�',
 `m1` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m2` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m3` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m4` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m5` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m6` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m7` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m8` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m9` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m10` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m11` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m12` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m13` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m14` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m15` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m16` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m17` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m18` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m19` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m20` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m21` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m22` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m23` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m24` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m25` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m26` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m27` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m28` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m29` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m30` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m31` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m32` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m33` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m34` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m35` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m36` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m37` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m38` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m39` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m40` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m41` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m42` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m43` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m44` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m45` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m46` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m47` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m48` varchar( 150  )  NOT  NULL DEFAULT  '0',
 `m49` varchar( 150  )  NOT  NULL DEFAULT  '0' COMMENT  '����',
 `m50` varchar( 150  )  NOT  NULL DEFAULT  '0',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `classsest` (  `clsid` ,  `damdang`, `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '���л��� �����ϴ� ���� ����Ʈ'";



		//�⺻ ��ũ ���̺�
		$tbname[31] = $ft."AAmyClassTestRs";
		$tb[31] = "CREATE TABLE  `".$dbn."`.`".$tbname[31]."` (
`testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '������ ������ȣ',
 `testgoinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:������, 2:��������',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '���� ���̵�',
 `stTime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '���迡 ������ �ð�',
 `eTime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '��� ����ð�',
 `oninf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:�⼮, 2�Ἦ, 3����, 4�������',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `jeomsu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '���� ���� ����',
KEY  `testst` (  `testid` ,  `memid` ,  `stTime` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '�� �л��� ���� ����� ����Ѵ�.'";



		//�⺻ ��ũ ���̺�
		$tbname[32] = $ft."AAmyClassTestSt";
		$tb[32] = "CREATE TABLE  `".$dbn."`.`".$tbname[32]."` (
`testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '������ ������ȣ',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '���� ���̵�',
 `mun` VARCHAR( 10 ) NOT NULL DEFAULT  '0' COMMENT  '������ �ʵ��̸�',
 `mydab` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '���� ��',
 `orgdab` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '����',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `jeomsu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '���� ���� ����',
KEY  `testst` (  `testid` ,  `memid` ,  `mun` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '�л��� �Է��� ���'";


		//�⺻ ��ũ ���̺�
		$tbname[33] = $ft."AAmyJGan";
		$tb[33] = "CREATE TABLE  `".$dbn."`.`".$tbname[33]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `jibu` TINYINT( 5 ) NOT NULL DEFAULT  '1' COMMENT  '�� ���� ����',
 `memid` VARCHAR( 13 ) NOT NULL DEFAULT  '0' COMMENT  '�ۼ��� ���̵�',
 `jang` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '��',
 `title` TEXT NOT NULL COMMENT  '������',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `jo` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '��',
 `sub1` TEXT NOT NULL ,
 `mmo` TEXT NOT NULL ,
 `indate` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00',
UNIQUE KEY  `babynewWr` (  `companyid` ,  `id` ) ,
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//�⺻ ��ũ ���̺�
		$tbname[34] = $ft."AAmyMmenu";
		$tb[34] = "CREATE TABLE  `".$dbn."`.`".$tbname[34]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `maingab` INT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '���θ޴�',
 `mainname` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '�޴��̸�',
 `companyid` VARCHAR( 12 ) NOT NULL DEFAULT  '0',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0',
UNIQUE KEY  `babynewWr` ( `project`,  `companyid` ,  `id` ) ,
UNIQUE KEY  `id` (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";




		//�⺻ ��ũ ���̺�
		$tbname[35] = $ft."AAmySlogon";
		$tb[35] = "CREATE TABLE  `".$dbn."`.`".$tbname[35]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `imgname` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  'ȸ���̹���',
 `slogon` VARCHAR( 300 ) NOT NULL DEFAULT  '0' COMMENT  '���ΰ�',
 `spo` VARCHAR( 200 ) NOT NULL DEFAULT  '0' COMMENT  '��å',
 `name` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  'ȸ���̸�',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
 `jiyeog` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '����',
 `jibu` TINYINT( 3 ) NOT NULL DEFAULT  '0' COMMENT  '���μ���',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '����� ���̵�',
 `inday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�������',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `companyid` ,  `spo` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";


		//�⺻ ��ũ ���̺�
		$tbname[36] = $ft."AAmySmenu";
		$tb[36] = "CREATE TABLE  `".$dbn."`.`".$tbname[36]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `mainid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '���θ޴����̵�',
 `sname` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '�����޴��̸�',
 `smenval` INT( 4 ) NOT NULL DEFAULT  '0' COMMENT  '�����޴���',
 `url` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '�����޴���ũ',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `menu` (  `mainid` ,  `smenval` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8";



		//�⺻ ��ũ ���̺�
		$tbname[37] = $ft."AAmyTestGcm";
		$tb[37] = "CREATE TABLE  `".$dbn."`.`".$tbname[37]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `frommem` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�������',
 `tomem` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�޴»��',
 `sonid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�ڳ���̵�',
 `testid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '���������ȣ',
 `companyid` VARCHAR( 20 ) NOT NULL DEFAULT  '0' COMMENT  '��ü���̵�',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0',
 `udid` VARCHAR( 20 ) NOT NULL ,
 `url` VARCHAR( 300 ) NOT NULL DEFAULT  '0',
 `mess` TEXT NOT NULL COMMENT  '�޽���',
 `day` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '��������',
 `redinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1: �б���',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `gonggcm` (  `project` ,  `frommem` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '�п����� ����� ���� �Ѵ�.'";




		//�⺻ ��ũ ���̺�
		$tbname[38] = $ft."AAmyWmenu";
		$tb[38] = "CREATE TABLE  `".$dbn."`.`".$tbname[38]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `webpass` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '�� ��й�ȣ',
 `memid` VARCHAR( 12 ) NOT NULL DEFAULT  '0' COMMENT  '�����ھ��̵�',
 `url` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '�޴��������ּ�',
 `project` VARCHAR( 15 ) NOT NULL COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
UNIQUE KEY  `id` (  `id` ) ,
UNIQUE KEY  `babynewWr` (  `project` ,  `url` ,  `memid` ,  `id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '������ �޴������� �ϱ� ���� ���'";

		
		
		//�⺻ ��ũ ���̺�
		$tbname[39] = $ft."AAcarMemul";
		$tb[39] = "CREATE TABLE  `".$dbn."`.`".$tbname[39]."` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `imgnum` VARCHAR( 14 ) NOT NULL DEFAULT  '0' COMMENT  '���̵� ���ڵ��ȣ',
 `saleid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '�Ǹ��� ���̵�',
 `cardon` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '�Ǹ� �ݾ�',
 `mkid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '��������̵�',
 `yongdoid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�뵵���̵�',
 `modelnid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�𵨸���̵�',
 `modelS` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�𵨻󼼱��о��̵�',
 `modelst` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '�� ���',
 `transm` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '���ӱ�',
 `cary` INT( 5 ) NOT NULL DEFAULT  '1999' COMMENT  '���',
 `carm` INT( 2 ) NOT NULL DEFAULT  '1' COMMENT  '��Ŀ�',
 `carkm` INT( 7 ) NOT NULL DEFAULT  '0' COMMENT  '����Ÿ�',
 `carcolor` VARCHAR( 100 ) NOT NULL DEFAULT  '0' COMMENT  '�ڵ��� Į��',
 `caroil` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '����',
 `carcc` INT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '��ⷮ',
 `cartel` VARCHAR( 15 ) NOT NULL DEFAULT  '0000-0000-0000' COMMENT  '������ȭ',
 `dispinf` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '1:���, 0:����,2:�Ÿ�',
 `inday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�������',
 `saleday` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '�Ǹ� ����',
 `project` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` VARCHAR( 15 ) NOT NULL DEFAULT  '0' COMMENT  '������̵�',
UNIQUE KEY  `id` (  `id` ) ,
KEY  `babynewWr` (  `project` ,  `dispinf` ,  `mkid` ,  `yongdoid` ,  `modelnid` ,  `modelS` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT =  '�ڵ��� �Ź� ����'";

		
		
		
		//�⺻ ��ũ ���̺�
		$tbname[40] = $ft."AAcarMemulText";
		$tb[40] = "CREATE TABLE  `".$dbn."`.`".$tbname[40]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `recid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�Ź����ڵ���̵�',
 `imgnum` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '�̹��� ��ȣ',
 `cartxt` text NOT  NULL  COMMENT  '����',
 UNIQUE  KEY  `id` (  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ��� ������'";
 


		//�⺻ ��ũ ���̺�
		$tbname[41] = $ft."AAcarMk";
		$tb[41] = "CREATE TABLE  `".$dbn."`.`".$tbname[41]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `carmk` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '������ �̸�',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `carmk`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ��� ������'";
 
 
		//�⺻ ��ũ ���̺�
		$tbname[42] = $ft."AAcarModel";
		$tb[42] = "CREATE TABLE  `".$dbn."`.`".$tbname[42]."` (

  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '��������̵�',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�뵵���̵�',
 `modeln` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '�𵨸�',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdoid` ,  `modeln`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ��� �𵨸�'";
 
 
		//�⺻ ��ũ ���̺�
		$tbname[43] = $ft."AAcarModelGubun";
		$tb[43] = "CREATE TABLE  `".$dbn."`.`".$tbname[43]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '��������̵�',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�뵵���̵�',
 `modelnid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�𵨸���̵�',
 `modelS` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '�𵨻󼼱���',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdoid` ,  `modelnid`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ��� �𵨺� ���ı���'";
 

		//�⺻ ��ũ ���̺�
		$tbname[44] = $ft."AAcarStep";
		$tb[44] = "CREATE TABLE  `".$dbn."`.`".$tbname[44]."` (

 `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `mkid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '������',
 `yongdoid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�뵵���̵�',
 `modelnid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�� ���̵�',
 `modelSid` int( 11  )  NOT  NULL DEFAULT  '0' COMMENT  '�� ��',
 `modelSt` varchar( 200  )  NOT  NULL DEFAULT  '0' COMMENT  '�� ���',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `mkid` ,  `yongdoid` ,  `modelnid` ,  `modelSid` ,  `modelSt`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ��� ���'";
 
 
 		//�⺻ ��ũ ���̺�
		$tbname[45] = $ft."AAcarYongdo";
		$tb[45] = "CREATE TABLE  `".$dbn."`.`".$tbname[45]."` (
 
  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `yongdo` varchar( 100  )  NOT  NULL DEFAULT  '�¿�' COMMENT  '�ڵ��� �뵵',
 `dispinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1:���, 0:����',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������Ʈ�̸�',
 `companyid` varchar( 15  )  NOT  NULL DEFAULT  '0' COMMENT  '������̵�',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `babynewWr` (  `project` ,  `dispinf` ,  `yongdo`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�ڵ����� �뵵�� ����'";

 
 		//�⺻ ��ũ ���̺�
		$tbname[46] = $ft."AAmyTextSend";
		$tb[46] = "CREATE TABLE  `".$dbn."`.`".$tbname[46]."` (
 
  `id` int( 11  )  NOT  NULL  AUTO_INCREMENT ,
 `frommem` varchar( 12  )  NOT  NULL DEFAULT  '0' COMMENT  '�������',
 `tomem` varchar( 12  )  NOT  NULL DEFAULT  '0' COMMENT  '�޴»��',
 `companyid` varchar( 20  )  NOT  NULL DEFAULT  '0' COMMENT  '��ü���̵�',
 `project` varchar( 15  )  NOT  NULL DEFAULT  '0',
 `udid` varchar( 20  )  NOT  NULL ,
 `url` varchar( 300  )  NOT  NULL DEFAULT  '0',
 `mess` text NOT  NULL  COMMENT  '�޽���',
 `day` datetime NOT  NULL DEFAULT  '0000-00-00 00:00:00' COMMENT  '��������',
 `redinf` tinyint( 1  )  NOT  NULL DEFAULT  '1' COMMENT  '1: �б���',
 UNIQUE  KEY  `id` (  `id`  ) ,
 KEY  `gonggcm` (  `project` ,  `frommem` ,  `id`  )  ) ENGINE  =  MyISAM  DEFAULT CHARSET  = utf8 COMMENT  =  '�п����� ����� ���� �Ѵ�.'";
 
 
 
		
		
		//���̺��� ���� ���θ� Ȯ���ϰ� ���ٸ� �����.
		for($c = 0; $c < 27; $c++){
			if($this->is_mysqltable($this->DB, $tbname[$c]) == 0)	$this->query($tb[$c]);  //���̺��� ���� ��� ���� �Ѵ�.
		}
	}


}
?>