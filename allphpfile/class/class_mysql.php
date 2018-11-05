<?
/*======================================================================================================
======================================================================================================*/
class MySQL
{
	var $HOST	= "localhost";	##	Host
	var $USER	= "root";		##	DB User
	var $PASS	= "";			##	Password
	var $DB		= "";			##	DB Name
	var $CONN	= "";			##	DB Server ���� �ĺ���
	var $rowsu	= "";
	var $SQL	= "";
	
/*============================================================================
	�Լ� �̸� :	error($msg)
	�Լ� ���� :	$msg	-> ǥ������ ���� �޽���

	�Լ� �뵵 :	�޽����� ����Ѵ�.
	Return �� : -
==============================================================================*/
	function error($msg)
	{
		$err_no = mysql_errno();
		$err_msg = mysql_error();
		echo "[ $msg ] ( $err_no : $err_msg )<BR>\n";
		exit;
	}

/*============================================================================
	�Լ� �̸� :	connect($host="", $user="", $pass="")
	�Լ� ���� :	$host	-> DB Server
				$user	-> DB User
				$pass	-> DB Password

	�Լ� �뵵 :	DB Server�� ������ �õ��Ѵ�.
	Return �� : $this->CONN;
===============================================================================*/
	function connect($host="", $user="", $pass="")
	{
		if(!$host)
			$host = $this->HOST;

		if(!$user)
			$user = $this->USER;

		if(!$pass)
			$pass = $this->PASS;

		$this->CONN = @mysql_connect($host, $user, $pass) or $this->error("DB ���� ���� ����!");

		return $this->CONN;
	}

/*=============================================================================
	�Լ� �̸� :	select($db="", $conn="")
	�Լ� ���� :	$db		-> DB Name
				$conn	-> DB Server ���� �ĺ���

	�Լ� �뵵 :	����� DB�� �����Ѵ�.
	Return �� : true
==============================================================================*/
	function select($db="", $conn="")
	{
		if(!$db) $db = $this->DB;
		else $this->DB = $db;


		if(!$conn)
			$conn = $this->CONN;

		@mysql_select_db($db, $conn) or $this->error("DB ���� ����!");

		return true;
	}

/*==============================================================================
	�Լ� �̸� :	search($keywords="")
	�Լ� ���� :	$keywords	-> �˻��ϰ��� �Է��� ���ڿ�
				$field		-> �ʵ�
				$where		-> "$where" ������ �ʿ��Ҷ�
				$distat		-> �˻� ���� ���
	�Լ� �뵵 :	������ ����ó�� �Ȱ��� �ؾ��Ѵ�.
	
	������ : 2003-04-11
================================================================================*/
	function search($field,$keywords="",$where="", $distat=0)
	{

		// �ʵ峪 �˻�� ������ �ٷ� ���� ������.
		if((empty($keywords) || !$field) || (empty($field) || !$field)){ return false; }
		// �ʵ带 �˻��� �°� ����
	
			if(!ereg("-",$field)) $column[0] = $field;			## �ʵ尡 1���϶�
			else $column = explode("-",$field);				## Ű���尡 �����϶�

			$column_num = count($column);

			// Ű���带 �˻��� �´� ������ �˸°� ��ģ��.
			$keywords = urldecode($keywords);
			$keywords = trim($keywords);
			$keywords = ereg_replace("([ ]+)"," ",$keywords);

			if(!ereg(" ",$keywords)) $keywords = "$keywords";			## Ű���尡 1���϶�
			else $keywords = explode(" ",$keywords);					## Ű���尡 �����϶�

			$count = count($keywords);									## Ű���� ī����


			for($cn=0; $cn<$column_num; $cn++){
				if($count==1)
				{
					$sql .= " $column[$cn] LIKE '%$keywords%'";

				}else {
					for($i=0; $i<$count; $i++)
					{
						if($keywords[$i])
						{
							$ir .= " $column[$cn] LIKE '%$keywords[$i]%' OR";
						}
					$val = $ir;
					}
					$sql = substr("$val",0,-2);		## ������ 'OR'���ڸ� �������� �����Ѵ�.
				}
				if ($column_num>1){
					$sql .= "OR";
				}
			}

			if ($column_num>1){
				$sql = substr("$sql",0,-2);		## ������ 'OR'���ڸ� �������� �����Ѵ�.
			}		
			/////////////////////////[ WHERE ���ǹ��� ������ ]
			if($where) $result .= "$where AND ($sql)";
			
			else $result .= "$sql";
			
			/////////////////////////[ $disat=1�϶� result ���� ��� ]
			if ($distat==1) echo $result;

			return $result;
		}


/*==============================================================================
	�Լ� �̸� :	query($query, $db_name="", $conn="")
	�Լ� ���� :	$query		-> �����ų SQL ����
				$db_name	-> �����ų DB �̸�
				$conn		-> SQL Query ���� �ĺ���
				$distat		-> ���� ��� ���
	�Լ� �뵵 :	SQL���� ���� ��Ų��.
	Return �� : $result -> SQL���� ���� �����
	
	������ : 2003-02-16
================================================================================*/
	function query($query, $disat=0, $db_name="", $conn="")
	{
		if(!$conn)
			$conn = $this->CONN;

		if($db_name)
			$result = @mysql_db_query($db_name, $query) or $this->error("$query<br><br>SQL�� ����");
		else
			$result = @mysql_query($query) or $this->error("$query<br><br>SQL�� ����");
			
			////����������� ���ų� ���� 0�̸� �޸𸮸� �����.
			if((!$result) or (empty($result))){
				@mysql_free_result($result);
				return false;
			}

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($disat==1) echo $query;

		return $result;

	}

/*==============================================================================
	�Լ� �̸� :	queryfs($query, $disat=0, $db_name="", $conn="")
	�Լ� ���� :	$query		-> �����ų SQL ����
				$distat		-> ���� ��� ���
				$db_name	-> �����ų DB �̸�
				$conn		-> SQL Query ���� �ĺ���
	�Լ� �뵵 :	������� �Ѱ��� ���ڵ常 ���� SQL���� �����Ű�� fetch����Ų��.
	Return �� : $result -> SQL���� ���� �����
================================================================================*/
/*
	function queryfs($query, $disat=0, $db_name="", $conn="")
	{
		if(!$conn) $conn = $this->CONN;

		if($db_name) $result = @mysql_db_query($db_name, $query) or $this->error("$query<br><br>SQL�� ����");
		else $result = @mysql_query($query) or $this->error("$query<br><br>SQL�� ����");
			
		////����������� ���ų� ���� 0�̸� �޸𸮸� �����.
		if((!$result) or (empty($result))){
			@mysql_free_result($result);
			return false;
		}

		

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $result;

		return $result;

	}
*/
/*==============================================================================
	�Լ� �̸� : makeSQL($table, $filed, $where="",$disat=0)
	�Լ� ���� :	$table		-> ���̺� ��
				$filed		-> ���̺� �ʵ��
				$where		-> ����
				$distat		-> ���� ��� ���
	�Լ� �뵵 :	SQL���� ���� ��Ų��.
	Return �� : $result -> SQL ���� �����
	
================================================================================*/
	function makeSQL($table, $filed, $where="",$disat=0)
	{
		$result = "SELECT {$filed} FROM {$table} ";
		if($where) $result .= " WHERE $where ";

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $result;

		return $result;

	}

/*=====================================================================================
	�Լ� �̸� :	fetch_row($result)
	
	## ��� ���ڵ� ��Ʈ���� �� ��(���ڵ�)�� �����͸� �����´�.
=======================================================================================*/
	function fetch_row($result)
	{
		$list = @mysql_fetch_row($result);
		if((!$list) or (empty($list)))
		{
			mysql_free_result($result);
			$this->error("�����͸� �ҷ������� ���߽��ϴ�. result ���� Ȯ���� ���ñ� �ٶ��ϴ�.");
		}
				
		return $list;
	}

/*=====================================================================================
	�Լ� �̸� :	fetch_rows($result)
	�Լ� ���� :	$result -> SQL�� ���� ���
	�Լ� �뵵 :	�Ѿ�� SQL���� ������� �� ���ڵ� ������ ���� �迭�� ������ �� ���� ���ڵ�� ��ġ�� �ű��.
	Return �� : $arr -> ���� �Խù� ������ �迭ȭ�� �迭
=======================================================================================*/
	function fetch_array($result)
	{
		$list = @mysql_fetch_array($result);
		if((!$list) or (empty($list)))
		{
			mysql_free_result($result);
			$this->error("�����͸� �ҷ������� ���߽��ϴ�. result ���� Ȯ���� ���ñ� �ٶ��ϴ�.");
		}
				
		return $list;
	}

/*==================================================================
	�Լ� �̸� :	rows($result="")
	�Լ� ���� :	$result -> SQL Query ���� �ĺ���
	�Լ� �뵵 :	���� �ֱٿ� �ҷ����� ���ڵ��� �� ������ ���Ѵ�.
	Return �� : $total -> �ҷ����� ��ũ���� �� ����
=====================================================================*/
	function rows($result="")
	{
		$total = $result ? @mysql_num_rows($result) : @mysql_affected_rows();
		
		return ($total > 0 ? $total : 0);
	}

/*==============================================================================
	�Լ� �̸� :	result($result, $num, $field)
	�Լ� ���� :	$result -> SQL�� ���� ���
				$result -> ���� �ҷ����� ��ũ�� ��ȣ
				$field	-> ���� �ҷ����� �ʵ��̸�
	�Լ� �뵵 :	�Ѿ�� SQL���� ������� ���ڵ� ��ȣ�� �´� �ʵ��� ���� �ҷ��´�.
	Return �� : $value -> �ҷ����� �ʵ��� ��
================================================================================*/
	function result($result, $row, $field)
	{
		$value = @mysql_result($result, $row, $field);

		return $value;
	}

/*============================================================================
	�Լ� �̸� :	get_count($table, $where)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$where	-> ����
	�Լ� �뵵 :	$table ���� ����($where)�� �´� ��� ������ ���Ѵ�.
	Return �� : $this->result($result, 0, "count(*)")	-> ���ǿ� �´� �� ���ڵ� ��
=============================================================================*/
	function get_count($table, $where="", $distat=0)
	{
		if($where)
			$where = " WHERE $where ";

		$query = "SELECT count(*) FROM $table $where";

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		$result = $this->query($query);

		return $this->result($result, 0, "count(*)");

		@mysql_free_result($result);
	}

/*============================================================================
	�Լ� �̸� :	get_result($table, $where, $field)
	�Լ� ���� :	$table	-> ���̺� �̸�
					$where	-> ����
					$filed		-> �ʵ�
	�Լ� �뵵 :	$table ���� ����($where)�� �´� $field�� ���� ���Ѵ�.
	Return �� : $this->result($result, 0, $field)	-> ���ǿ� �´� �� ���ڵ� ��
=============================================================================*/
	function get_result($table, $where, $field="*", $distat=0)
	{
		if($where && $field)
		{
			$query = "SELECT $field FROM $table WHERE $where";

			/////////////////////////[ $disat=1�϶� result ���� ��� ]
			if ($distat==1) echo $query;

			$result = $this->query($query);

			return $this->result($result, 0, $field);
			@mysql_free_result($result);
		}
		else
		{
			return 0;
		}
	}

/*============================================================================
	�Լ� �̸� :	get_query($table, $where, $field)
	�Լ� ���� :	$table	-> ���̺� �̸�
					$where	-> ����
					$filed		-> �ʵ�
	�Լ� �뵵 :	$table ���� ����($where)�� �´� $field�� ���� ���Ѵ�.
	Return �� : $this->result($result, 0, $field)	-> ���ǿ� �´� �� ���ڵ� ��
=============================================================================*/
	function get_query($table, $where, $field, $distat=0)
	{
		if($where && $field)
		{
			$query = "SELECT $field FROM $table WHERE $where";

			/////////////////////////[ $disat=1�϶� result ���� ��� ]
			if ($distat==1) echo $query;

			$result = $this->query($query);

			return $result;
		}
		else
		{
			return 0;
		}
	}

/*============================================================================
	�Լ� �̸� :	get_record($table, $where, $field)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$where	-> ����
				$field	-> ����Ʈ �� �ʵ��
	�Լ� �뵵 :	$table ���� ����($where)�� �´� �ʵ���� ���� ���Ѵ�.
				query �� ���ʿ��ϰ� ������� �ʾƵ� �ȴ�.
=============================================================================*/
	function get_record($table, $where="", $field="*", $distat=0)
	{
		if($where)
			$where = " WHERE $where ";

		$query = "SELECT $field FROM $table $where";
		$result = $this->query($query);
		
		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		$this->rowsu = $this->rows($result);

		if($this->rows())
		{
			return $this->fetch_array($result);
		}
		else
		{
			return 0;
		}
	}
/*==================================================================
	�Լ� �̸� :	sql_insert($table, $arr)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$arr	-> �迭�� Key ���� �ʵ��̸�, Value ���� �� ���� �ִ�.
	�Լ� �뵵 :	�Ѿ�� $arr�� ���� $table�� Insert �Ѵ�.
	Return �� : true
=====================================================================*/
	function sql_insert($table, $arr, $distat=0)
	{
		if(!$table || !is_array($arr))
			$this->error("���̺� �̸��� ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$i = 0;
		while(list($key, $value)=each($arr))
		{
			$comma = $i ? "," : "";
			$fields .= $comma."`".$key."`";
			$values .= $comma.$value;

			$i++;
		}

		$query = "INSERT INTO $table ($fields) VALUES ($values)";

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		$this->query($query);
		
		return true;
	}


/*===================================================================
	�Լ� �̸� :	sql_update($table, $arr, $where)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$arr	-> �迭�� Key ���� �ʵ��̸�, Value ���� �� ���� �ִ�.
				$where	-> Update�� ������
	�Լ� �뵵 :	�Ѿ�� $arr�� ���� $table�� $where ���ǿ� �°� Update �Ѵ�.
	Return �� : true
====================================================================*/
	function sql_update($table, $arr, $where="", $distat=0)
	{
		
		//$arr = Array( 'login' => 'kok', 'project' => 'autocampko' );  //$project.'ko');
		
		
		if(!$table || !$arr)
			$this->error("���̺� �̸��� ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		if($where)
			$where = " WHERE $where ";

		$i = 0;
		while(list($key, $value)=each($arr))
		{
			$comma = $i ? "," : "";

			$tmp .= $comma."`".$key."`"."=".$value;

			$i++;
		}

		$query = "UPDATE $table SET $tmp $where";

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		$this->query($query);
		$this->SQL = $query;
		return true;
	}
/*========================================================================
	�Լ� �̸� :	bas_delete($table, $where, $distat=0)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$field	-> �ʵ��̸�.
	�Լ� �뵵 :	�Ѿ�� $arr�� ���� $table�� Insert �Ѵ�.
	Return �� : true
==========================================================================*/
	function bas_delete($table, $where, $distat=0)
	{
		if(!$table || !$where)
			$this->error("���̺� �̸� �Ǵ� ���� ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$where = " WHERE $where ";
		$query = "DELETE FROM $table $where";

		$rt = $this->query($query);
		if($rt) $aa = "ok";
		else $aa = "err";
		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		return $aa;
	}


/*========================================================================
	�Լ� �̸� :	sql_delete($table, $field, $value, $distat=0)
	�Լ� ���� :	$table	-> ���̺� �̸�
				$field	-> �ʵ��̸�.
	�Լ� �뵵 :	�Ѿ�� $arr�� ���� $table�� Insert �Ѵ�.
	Return �� : true
==========================================================================*/
	function sql_delete($table, $field, $value, $distat=0)
	{
		if(!$table || !$field || !$value)
			$this->error("���̺� �̸�, �ʵ� �̸�, ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$arr_table = explode("-", $table);
		$arr_field = explode("-", $field);
		$arr_value = explode("-", $value);

		$total = count($arr_table);
		for($i=0; $i<$total; $i++)
		{
			$where = " WHERE $arr_field[$i]=$arr_value[$i]";
			$query = "DELETE FROM $arr_table[$i] $where";

			$this->query($query);
		}

		/////////////////////////[ $disat=1�϶� result ���� ��� ]
		if ($distat==1) echo $query;

		return true;
	}

/*========================================================================
	�Լ� �̸� :	sql_num_fields($table, $arr)
	�Լ� ���� :	$val	-> $this->query ��
	�Լ� �뵵 :	�ʵ� �� ���� �˾Ƴ���

	## ������ڵ� ��Ʈ���� �˻��� ���ڵ尡 ���� ���� ��, ## {�� �ʵ��� ��}�� ��ȯ
==========================================================================*/
	function sql_num_fields($val)
	{
		if(!$val) $this->error("query ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$result = mysql_num_fields($val);
	return $result;
	}

/*========================================================================
	�Լ� �̸� :	sql_num_fields($table, $arr)
	
	$val	: $result
	$num	: $i (����)

	## ������ڵ� ��Ʈ���� �˻��� ���ڵ尡 ���� ���� ��, ## {�� �ʵ��� ��}�� ��ȯ
==========================================================================*/
	function sql_field_name($val,$num)
	{
		if(!$val) $this->error("query ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$result = mysql_field_name($val,$num);
	return $result;
	}

/*========================================================================
	�Լ� �̸� :	sql_fetch_field($table, $arr)
	
	$val	: $result
	$num	: $i (����)

	## $list->field == $fieldname
==========================================================================*/
	function sql_fetch_field($val,$num)
	{
		if(!$val) $this->error("query ���� Ȯ���� �ֽñ� �ٶ��ϴ�.(��)");

		$result = mysql_fetch_field($val,$num);
	return $result;
	}

/*========================================================================
	�Լ� �̸� :	is_mysqltable()

	$dbname	: db ��
	$table	: table ��

	## ���� db �� ���� �̸��� ���� TABLE �� �����ϴ����� üũ�Ѵ�.
	## ���� ���̺��� �����ϸ� 1, �ƴϸ� 0
==========================================================================*/
	function is_mysqltable($dbname, $table) 
	{ 
		$result = mysql_list_tables($dbname); 
		$total = mysql_num_rows($result); 
		for($i=0; $i<$total; $i++) 
		{ 
			if($table==mysql_tablename($result, $i)) 
			{ 
				return 1; 
			} 
		} 
		return 0; 
	} 

/*========================================================================
	�Լ� �̸� :	sql_close()
	Return �� : true
==========================================================================*/
	function sql_close()
	{
		mysql_close($this->CONN);

		return true;
	}

}
?>